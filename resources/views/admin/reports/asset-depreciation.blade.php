@extends('layouts.admin')

@section('title', 'Laporan Susut Nilai Aset')
@section('page-title', 'Laporan Susut Nilai Aset')
@section('page-description', 'Analisis susut nilai dan nilai semasa aset')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Laporan Susut Nilai Aset</h1>
                <p class="text-emerald-100 text-lg">Analisis susut nilai dan nilai semasa aset</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-trending-down text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $assets->count() }} aset</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-calculator text-emerald-200'></i>
                        <span class="text-emerald-100">Dengan Susut Nilai</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-trending-down text-6xl text-emerald-200 opacity-80'></i>
            </div>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Original Value -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-dollar text-blue-600 text-xl'></i>
                </div>
                <span class="text-sm text-blue-600 bg-blue-100 px-2 py-1 rounded-full font-medium">Asal</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($assets->sum('nilai_perolehan'), 0) }}</h3>
            <p class="text-sm text-gray-600">Nilai Asal</p>
        </div>

        <!-- Total Current Value -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-money text-green-600 text-xl'></i>
                </div>
                <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">Semasa</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($assets->sum('current_value'), 0) }}</h3>
            <p class="text-sm text-gray-600">Nilai Semasa</p>
        </div>

        <!-- Total Depreciation -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-trending-down text-red-600 text-xl'></i>
                </div>
                <span class="text-sm text-red-600 bg-red-100 px-2 py-1 rounded-full font-medium">Susut</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($assets->sum('total_depreciation'), 0) }}</h3>
            <p class="text-sm text-gray-600">Jumlah Susut Nilai</p>
        </div>

        <!-- Average Age -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-time text-purple-600 text-xl'></i>
                </div>
                <span class="text-sm text-purple-600 bg-purple-100 px-2 py-1 rounded-full font-medium">Umur</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($assets->avg('years_elapsed'), 1) }}</h3>
            <p class="text-sm text-gray-600">Purata Umur (Tahun)</p>
        </div>
    </div>

    <!-- Assets Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <!-- Table Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Senarai Aset dengan Susut Nilai</h2>
                    <p class="text-sm text-gray-600">Aset yang mempunyai susut nilai tahunan</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">{{ $assets->count() }} aset</span>
                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Asal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Susut Nilai/Tahun</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Umur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Susut</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Semasa</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($assets as $asset)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <i class='bx bx-box text-emerald-600'></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $asset->nama_aset }}</div>
                                    <div class="text-sm text-gray-500">{{ $asset->no_siri_pendaftaran }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">RM {{ number_format($asset->nilai_perolehan, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">RM {{ number_format($asset->susut_nilai_tahunan, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full bg-purple-100 text-purple-800">
                                {{ $asset->years_elapsed }} tahun
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-red-600">RM {{ number_format($asset->total_depreciation, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-green-600">RM {{ number_format($asset->current_value, 2) }}</div>
                            @if($asset->current_value <= 0)
                                <div class="text-xs text-red-500">Nilai penuh susut</div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class='bx bx-trending-down text-3xl text-gray-400'></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tiada Aset dengan Susut Nilai</h3>
                                <p class="text-gray-500 text-sm">Belum ada aset yang mempunyai susut nilai tahunan.</p>
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