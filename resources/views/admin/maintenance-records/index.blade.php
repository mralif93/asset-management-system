@extends('layouts.admin')

@section('title', 'Pengurusan Penyelenggaraan')
@section('page-title', 'Pengurusan Penyelenggaraan')
@section('page-description', 'Urus semua rekod penyelenggaraan aset')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Pengurusan Penyelenggaraan</h1>
                <p class="text-emerald-100 text-lg">Urus dan pantau semua rekod penyelenggaraan aset</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-wrench text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $maintenanceRecords->total() }} rekod</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-shield-check text-emerald-200'></i>
                        <span class="text-emerald-100">Sistem Aktif</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-wrench text-6xl text-emerald-200'></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Maintenance Records -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-wrench text-emerald-600 text-xl'></i>
                </div>
                <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium">+8.5%</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $maintenanceRecords->total() }}</h3>
            <p class="text-sm text-gray-600">Jumlah Penyelenggaraan</p>
        </div>

        <!-- This Month -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-calendar text-purple-600 text-xl'></i>
                </div>
                <span class="text-sm text-purple-600 bg-purple-100 px-2 py-1 rounded-full font-medium">Bulan Ini</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $maintenanceRecords->where('tarikh_penyelenggaraan', '>=', now()->startOfMonth())->count() }}</h3>
            <p class="text-sm text-gray-600">Penyelenggaraan Baru</p>
        </div>

        <!-- Total Cost -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-money text-blue-600 text-xl'></i>
                </div>
                <span class="text-sm text-blue-600 bg-blue-100 px-2 py-1 rounded-full font-medium">+12.3%</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">RM {{ number_format($maintenanceRecords->sum('kos_penyelenggaraan'), 0) }}</h3>
            <p class="text-sm text-gray-600">Jumlah Kos</p>
        </div>

        <!-- Preventive Maintenance -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-check-shield text-green-600 text-xl'></i>
                </div>
                <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">Aktif</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $maintenanceRecords->where('jenis_penyelenggaraan', 'Pencegahan')->count() }}</h3>
            <p class="text-sm text-gray-600">Penyelenggaraan Pencegahan</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Add Maintenance -->
        <a href="{{ route('admin.maintenance-records.create') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                    <i class='bx bx-plus text-emerald-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-emerald-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Tambah Penyelenggaraan</h3>
            <p class="text-sm text-gray-600">Rekod penyelenggaraan baharu</p>
        </a>

        <!-- Export Data -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <i class='bx bx-download text-blue-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-blue-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Eksport Data</h3>
            <p class="text-sm text-gray-600">Muat turun laporan penyelenggaraan</p>
        </div>

        <!-- Maintenance Reports -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <i class='bx bx-bar-chart text-purple-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-purple-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Laporan Penyelenggaraan</h3>
            <p class="text-sm text-gray-600">Analitik dan statistik</p>
        </div>

        <!-- Schedule Maintenance -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                    <i class='bx bx-calendar-plus text-amber-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-amber-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Jadual Penyelenggaraan</h3>
            <p class="text-sm text-gray-600">Penyelenggaraan berkala</p>
        </div>
    </div>

    <!-- Search and Filters Card -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Penapis & Carian</h2>
                <p class="text-sm text-gray-600">Gunakan penapis untuk mencari rekod penyelenggaraan tertentu</p>
            </div>
            <i class='bx bx-filter-alt text-2xl text-gray-400'></i>
        </div>
        
        <form method="GET" action="{{ route('admin.maintenance-records.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Aset</label>
                    <div class="relative">
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Nama aset atau no. siri..."
                               class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <i class='bx bx-search absolute left-3 top-2.5 text-gray-400'></i>
                    </div>
                </div>

                <!-- Maintenance Type Filter -->
                <div>
                    <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">Jenis Penyelenggaraan</label>
                    <select id="jenis" name="jenis" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Semua Jenis</option>
                        <option value="Pencegahan" {{ request('jenis') === 'Pencegahan' ? 'selected' : '' }}>Pencegahan</option>
                        <option value="Pembaikan" {{ request('jenis') === 'Pembaikan' ? 'selected' : '' }}>Pembaikan</option>
                        <option value="Kalibrasi" {{ request('jenis') === 'Kalibrasi' ? 'selected' : '' }}>Kalibrasi</option>
                        <option value="Pembersihan" {{ request('jenis') === 'Pembersihan' ? 'selected' : '' }}>Pembersihan</option>
                    </select>
                </div>

                <!-- Date Filter -->
                <div>
                    <label for="bulan" class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                    <select id="bulan" name="bulan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Semua Bulan</option>
                        @for($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit" 
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors flex items-center">
                        <i class='bx bx-search mr-2'></i>
                        Cari
                    </button>
                    <a href="{{ route('admin.maintenance-records.index') }}" 
                       class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Maintenance Records Table Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <!-- Table Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Senarai Penyelenggaraan</h2>
                    <p class="text-sm text-gray-600">Urus dan pantau semua rekod penyelenggaraan aset</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">{{ $maintenanceRecords->total() }} rekod</span>
                    <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Penyelenggaraan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarikh</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kos</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyedia</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($maintenanceRecords as $record)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <i class='bx bx-wrench text-emerald-600 text-lg'></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $record->asset->nama_aset }}</div>
                                    <div class="text-sm text-gray-500">{{ $record->asset->no_siri_pendaftaran }}</div>
                                    <div class="text-xs text-gray-400 flex items-center">
                                        <i class='bx bx-map-pin mr-1'></i>
                                        {{ $record->asset->lokasi_penempatan }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                @if($record->jenis_penyelenggaraan === 'Pencegahan') bg-green-100 text-green-800
                                @elseif($record->jenis_penyelenggaraan === 'Pembaikan') bg-red-100 text-red-800
                                @elseif($record->jenis_penyelenggaraan === 'Kalibrasi') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                <div class="w-2 h-2 
                                    @if($record->jenis_penyelenggaraan === 'Pencegahan') bg-green-500
                                    @elseif($record->jenis_penyelenggaraan === 'Pembaikan') bg-red-500
                                    @elseif($record->jenis_penyelenggaraan === 'Kalibrasi') bg-blue-500
                                    @else bg-yellow-500 @endif rounded-full mr-2"></div>
                                {{ $record->jenis_penyelenggaraan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($record->tarikh_penyelenggaraan)->format('d/m/Y') }}
                            <div class="text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($record->tarikh_penyelenggaraan)->diffForHumans() }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">RM {{ number_format($record->kos_penyelenggaraan, 2) }}</div>
                            @if($record->kos_penyelenggaraan > 1000)
                                <div class="text-xs text-amber-600 flex items-center">
                                    <i class='bx bx-info-circle mr-1'></i>
                                    Kos tinggi
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $record->penyedia_perkhidmatan }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="{{ route('admin.maintenance-records.show', $record) }}" 
                                   class="w-8 h-8 bg-emerald-100 hover:bg-emerald-200 text-emerald-600 rounded-lg flex items-center justify-center transition-colors"
                                   title="Lihat">
                                    <i class='bx bx-show text-sm'></i>
                                </a>
                                <a href="{{ route('admin.maintenance-records.edit', $record) }}" 
                                   class="w-8 h-8 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-lg flex items-center justify-center transition-colors"
                                   title="Edit">
                                    <i class='bx bx-edit text-sm'></i>
                                </a>
                                
                                <form action="{{ route('admin.maintenance-records.destroy', $record) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Adakah anda pasti ingin memadamkan rekod penyelenggaraan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg flex items-center justify-center transition-colors"
                                            title="Padamkan">
                                        <i class='bx bx-trash text-sm'></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class='bx bx-wrench text-5xl text-gray-400 mb-4'></i>
                                <p class="text-gray-500 text-lg">Tiada rekod penyelenggaraan dijumpai</p>
                                <p class="text-gray-400 text-sm mb-4">Cuba tukar kriteria carian anda atau tambah rekod baharu</p>
                                <a href="{{ route('admin.maintenance-records.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                                    <i class='bx bx-plus mr-2'></i>
                                    Tambah Penyelenggaraan
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($maintenanceRecords->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $maintenanceRecords->links() }}
        </div>
        @endif
    </div>
</div>
@endsection 