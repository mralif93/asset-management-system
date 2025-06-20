@extends('layouts.admin')

@section('title', 'Ringkasan Pergerakan Aset')
@section('page-title', 'Ringkasan Pergerakan Aset')
@section('page-description', 'Senarai pergerakan dan pemindahan aset yang diluluskan')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Ringkasan Pergerakan Aset</h1>
                <p class="text-emerald-100 text-lg">Senarai pergerakan dan pemindahan aset yang diluluskan</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-transfer text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $movements->count() }} pergerakan</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-check-circle text-emerald-200'></i>
                        <span class="text-emerald-100">Diluluskan</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-transfer text-6xl text-emerald-200 opacity-80'></i>
            </div>
        </div>
    </div>

    <!-- Movements Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <!-- Table Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Senarai Pergerakan Aset</h2>
                    <p class="text-sm text-gray-600">Pergerakan aset yang telah diluluskan</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">{{ $movements->count() }} pergerakan</span>
                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dari</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ke</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarikh</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($movements as $movement)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <i class='bx bx-box text-emerald-600'></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $movement->asset->nama_aset ?? 'N/A' }}</div>
                                    <div class="text-sm text-gray-500">{{ $movement->asset->no_siri_pendaftaran ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $movement->lokasi_asal ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $movement->lokasi_destinasi ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $movement->tarikh_pergerakan ? $movement->tarikh_pergerakan->format('d/m/Y') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                Diluluskan
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class='bx bx-transfer text-3xl text-gray-400'></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tiada Pergerakan Aset</h3>
                                <p class="text-gray-500 text-sm">Belum ada pergerakan aset yang diluluskan.</p>
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
            Cetak Laporan
        </button>
        <a href="{{ route('admin.reports.index') }}" 
           class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
            Kembali
        </a>
    </div>
</div>
@endsection 