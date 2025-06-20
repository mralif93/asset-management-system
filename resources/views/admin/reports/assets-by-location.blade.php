@extends('layouts.admin')

@section('title', 'Laporan Aset Mengikut Lokasi')
@section('page-title', 'Laporan Aset Mengikut Lokasi')
@section('page-description', 'Analisis distribusi aset mengikut lokasi penempatan')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Laporan Aset Mengikut Lokasi</h1>
                <p class="text-emerald-100 text-lg">Analisis distribusi dan penempatan aset dalam sistem</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-map text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $assets->count() }} aset</span>
                    </div>
                    @if(!empty($lokasi))
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-filter text-emerald-200'></i>
                        <span class="text-emerald-100">Lokasi: {{ $lokasi }}</span>
                    </div>
                    @endif
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-map text-6xl text-emerald-200 opacity-80'></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Assets -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-box text-blue-600 text-xl'></i>
                </div>
                <span class="text-sm text-blue-600 bg-blue-100 px-2 py-1 rounded-full font-medium">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $assets->count() }}</h3>
            <p class="text-sm text-gray-600">Jumlah Aset</p>
        </div>

        <!-- Total Value -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-money text-green-600 text-xl'></i>
                </div>
                <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">RM</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($assets->sum('nilai_perolehan'), 0) }}</h3>
            <p class="text-sm text-gray-600">Nilai Keseluruhan</p>
        </div>

        <!-- Unique Locations -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-map-pin text-purple-600 text-xl'></i>
                </div>
                <span class="text-sm text-purple-600 bg-purple-100 px-2 py-1 rounded-full font-medium">Lokasi</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $assets->pluck('lokasi_penempatan')->unique()->count() }}</h3>
            <p class="text-sm text-gray-600">Lokasi Unik</p>
        </div>

        <!-- Average Value -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-calculator text-amber-600 text-xl'></i>
                </div>
                <span class="text-sm text-amber-600 bg-amber-100 px-2 py-1 rounded-full font-medium">Purata</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $assets->count() > 0 ? number_format($assets->avg('nilai_perolehan'), 0) : 0 }}</h3>
            <p class="text-sm text-gray-600">Nilai Purata</p>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Carian dan Penapis</h2>
                <p class="text-sm text-gray-600">Cari aset berdasarkan lokasi penempatan</p>
            </div>
            <i class='bx bx-filter-alt text-2xl text-gray-400'></i>
        </div>
        
        <form method="GET" action="{{ route('admin.reports.assets-by-location') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Location Search -->
                <div>
                    <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-2">Lokasi Penempatan</label>
                    <div class="relative">
                        <input type="text" 
                               id="lokasi" 
                               name="lokasi" 
                               value="{{ $lokasi }}"
                               placeholder="Cari lokasi..."
                               class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                        <i class='bx bx-search absolute left-3 top-2.5 text-gray-400'></i>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit" 
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors flex items-center">
                        <i class='bx bx-search mr-2'></i>
                        Cari
                    </button>
                    <a href="{{ route('admin.reports.assets-by-location') }}" 
                       class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                        Reset
                    </a>
                </div>

                <!-- Export -->
                <div class="flex items-end justify-end">
                    <button type="button" 
                            onclick="window.print()"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors flex items-center">
                        <i class='bx bx-printer mr-2'></i>
                        Cetak
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Assets Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <!-- Table Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Senarai Aset</h2>
                    <p class="text-sm text-gray-600">
                        @if(!empty($lokasi))
                            Aset di lokasi "{{ $lokasi }}"
                        @else
                            Semua aset dalam sistem
                        @endif
                    </p>
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Masjid/Surau</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
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
                            <div class="text-sm text-gray-900">{{ $asset->lokasi_penempatan ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $asset->masjidSurau->nama ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $asset->kategori_aset }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            RM {{ number_format($asset->nilai_perolehan, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full 
                                @if($asset->status_aset === 'aktif') bg-green-100 text-green-800
                                @elseif($asset->status_aset === 'tidak_aktif') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                <div class="w-2 h-2 
                                    @if($asset->status_aset === 'aktif') bg-green-500
                                    @elseif($asset->status_aset === 'tidak_aktif') bg-red-500
                                    @else bg-yellow-500 @endif rounded-full mr-2"></div>
                                {{ ucfirst(str_replace('_', ' ', $asset->status_aset)) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class='bx bx-map text-3xl text-gray-400'></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tiada Aset Dijumpai</h3>
                                <p class="text-gray-500 text-sm mb-6 max-w-sm">
                                    @if(!empty($lokasi))
                                        Tiada aset dijumpai di lokasi "{{ $lokasi }}". Cuba cari lokasi lain.
                                    @else
                                        Belum ada aset yang didaftarkan dalam sistem.
                                    @endif
                                </p>
                                <a href="{{ route('admin.assets.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                                    <i class='bx bx-plus mr-2'></i>
                                    Tambah Aset
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Location Summary -->
    @if($assets->count() > 0)
    <div class="mt-8 bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Mengikut Lokasi</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($assets->groupBy('lokasi_penempatan') as $location => $locationAssets)
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="font-medium text-gray-900">{{ $location ?: 'Lokasi Tidak Dinyatakan' }}</h4>
                    <span class="text-sm text-gray-500">{{ $locationAssets->count() }} aset</span>
                </div>
                <div class="text-sm text-gray-600">
                    <div>Nilai: RM {{ number_format($locationAssets->sum('nilai_perolehan'), 0) }}</div>
                    <div class="mt-1">
                        <span class="text-green-600">{{ $locationAssets->where('status_aset', 'aktif')->count() }} aktif</span>
                        @if($locationAssets->where('status_aset', 'tidak_aktif')->count() > 0)
                        <span class="text-red-600 ml-2">{{ $locationAssets->where('status_aset', 'tidak_aktif')->count() }} tidak aktif</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>

@push('styles')
<style>
    @media print {
        .no-print {
            display: none !important;
        }
        
        body {
            font-size: 12px;
        }
        
        .bg-gradient-to-r {
            background: #10b981 !important;
            color: white !important;
        }
    }
</style>
@endpush
@endsection 