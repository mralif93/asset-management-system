@extends('layouts.admin')

@section('title', 'Jadual Penyelenggaraan')
@section('page-title', 'Jadual Penyelenggaraan')
@section('page-description', 'Jadual penyelenggaraan aset yang akan datang')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Jadual Penyelenggaraan</h1>
                <p class="text-emerald-100 text-lg">Jadual penyelenggaraan aset yang akan datang</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-wrench text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $upcomingMaintenance->count() }} penyelenggaraan</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-time text-emerald-200'></i>
                        <span class="text-emerald-100">Akan Datang</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-wrench text-6xl text-emerald-200 opacity-80'></i>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- This Week -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-calendar-exclamation text-red-600 text-xl'></i>
                </div>
                <span class="text-sm text-red-600 bg-red-100 px-2 py-1 rounded-full font-medium">Urgent</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">
                {{ $upcomingMaintenance->filter(function($maintenance) { 
                    return $maintenance->tarikh_penyelenggaraan_akan_datang->isBetween(now(), now()->addWeek()); 
                })->count() }}
            </h3>
            <p class="text-sm text-gray-600">Minggu Ini</p>
        </div>

        <!-- This Month -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-calendar text-yellow-600 text-xl'></i>
                </div>
                <span class="text-sm text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full font-medium">Soon</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">
                {{ $upcomingMaintenance->filter(function($maintenance) { 
                    return $maintenance->tarikh_penyelenggaraan_akan_datang->isBetween(now(), now()->addMonth()); 
                })->count() }}
            </h3>
            <p class="text-sm text-gray-600">Bulan Ini</p>
        </div>

        <!-- Total Upcoming -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-list-check text-blue-600 text-xl'></i>
                </div>
                <span class="text-sm text-blue-600 bg-blue-100 px-2 py-1 rounded-full font-medium">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $upcomingMaintenance->count() }}</h3>
            <p class="text-sm text-gray-600">Jumlah Dijadualkan</p>
        </div>

        <!-- Estimated Cost -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-dollar text-green-600 text-xl'></i>
                </div>
                <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">RM</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($upcomingMaintenance->sum('kos_penyelenggaraan'), 0) }}</h3>
            <p class="text-sm text-gray-600">Anggaran Kos</p>
        </div>
    </div>

    <!-- Maintenance Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <!-- Table Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Jadual Penyelenggaraan Akan Datang</h2>
                    <p class="text-sm text-gray-600">Penyelenggaraan aset yang dijadualkan</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">{{ $upcomingMaintenance->count() }} penyelenggaraan</span>
                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarikh Dijadualkan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyelenggaraan Terakhir</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kos Anggaran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keutamaan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($upcomingMaintenance as $maintenance)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <i class='bx bx-box text-emerald-600'></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $maintenance->asset->nama_aset ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $maintenance->asset->no_siri_pendaftaran ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $typeColors = [
                                    'pencegahan' => 'bg-green-100 text-green-800',
                                    'pembaikan' => 'bg-red-100 text-red-800',
                                    'kalibrasi' => 'bg-blue-100 text-blue-800',
                                ];
                                $colorClass = $typeColors[$maintenance->jenis_penyelenggaraan] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full {{ $colorClass }}">
                                {{ ucfirst($maintenance->jenis_penyelenggaraan ?? 'N/A') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                {{ $maintenance->tarikh_penyelenggaraan_akan_datang->format('d/m/Y') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $maintenance->tarikh_penyelenggaraan_akan_datang->diffForHumans() }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $maintenance->tarikh_penyelenggaraan ? $maintenance->tarikh_penyelenggaraan->format('d/m/Y') : 'Belum ada' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">RM {{ number_format($maintenance->kos_penyelenggaraan ?? 0, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $daysUntil = now()->diffInDays($maintenance->tarikh_penyelenggaraan_akan_datang, false);
                            @endphp
                            @if($daysUntil <= 7)
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                    <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                    Urgent
                                </span>
                            @elseif($daysUntil <= 30)
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                                    Sederhana
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                    <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                    Normal
                                </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class='bx bx-wrench text-3xl text-gray-400'></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tiada Penyelenggaraan Dijadualkan</h3>
                                <p class="text-gray-500 text-sm">Belum ada penyelenggaraan aset yang dijadualkan akan datang.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end space-x-4 mt-8">
        <button onclick="window.print()" 
                class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center">
            <i class='bx bx-printer mr-2'></i>
            Cetak Jadual
        </button>
        <a href="{{ route('admin.reports.index') }}" 
           class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
            Kembali
        </a>
    </div>
</div>
@endsection 