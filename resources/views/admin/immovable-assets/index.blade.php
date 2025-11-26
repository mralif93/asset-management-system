@extends('layouts.admin')

@section('title', 'Pengurusan Aset Tak Alih')
@section('page-title', 'Pengurusan Aset Tak Alih')
@section('page-description', 'Urus semua aset tak alih dalam sistem')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Pengurusan Aset Tak Alih</h1>
                <p class="text-emerald-100 text-lg">Urus dan pantau semua aset tak alih dalam sistem</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-buildings text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $immovableAssets->total() }} aset</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-shield-check text-emerald-200'></i>
                        <span class="text-emerald-100">Sistem Aktif</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-buildings text-6xl text-emerald-200'></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Assets -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-buildings text-emerald-600 text-xl'></i>
                </div>
                <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium">+12.3%</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $immovableAssets->total() }}</h3>
            <p class="text-sm text-gray-600">Jumlah Aset</p>
        </div>

        <!-- Total Area -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-map text-blue-600 text-xl'></i>
                </div>
                <span class="text-sm text-blue-600 bg-blue-100 px-2 py-1 rounded-full font-medium">Aktif</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($immovableAssets->sum('luas_tanah_bangunan'), 0) }}</h3>
            <p class="text-sm text-gray-600">Keluasan (m²)</p>
        </div>

        <!-- Good Condition -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-check-circle text-green-600 text-xl'></i>
                </div>
                <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">+5.2%</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $immovableAssets->whereIn('keadaan_semasa', ['Sangat Baik', 'Baik'])->count() }}</h3>
            <p class="text-sm text-gray-600">Kondisi Baik</p>
        </div>

        <!-- Total Value -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-dollar text-amber-600 text-xl'></i>
                </div>
                <span class="text-sm text-amber-600 bg-amber-100 px-2 py-1 rounded-full font-medium">RM</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($immovableAssets->sum('kos_perolehan'), 0) }}</h3>
            <p class="text-sm text-gray-600">Nilai Keseluruhan</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Add Asset -->
        <a href="{{ route('admin.immovable-assets.create') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                    <i class='bx bx-plus text-emerald-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-emerald-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Tambah Aset</h3>
            <p class="text-sm text-gray-600">Daftar aset tak alih baharu</p>
        </a>

        <!-- Export Assets -->
        <a href="{{ route('admin.immovable-assets.export', request()->query()) }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <i class='bx bx-download text-blue-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-blue-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Eksport Data</h3>
            <p class="text-sm text-gray-600">Muat turun senarai aset</p>
        </a>

        <!-- Asset Reports -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <i class='bx bx-bar-chart text-purple-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-purple-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Laporan Aset</h3>
            <p class="text-sm text-gray-600">Analitik dan statistik</p>
        </div>

        <!-- Import Assets -->
        <a href="{{ route('admin.immovable-assets.import') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                    <i class='bx bx-cloud-upload text-amber-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-amber-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Import Data</h3>
            <p class="text-sm text-gray-600">Muat naik senarai aset</p>
        </a>
    </div>

    <!-- Search and Filters Card -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Penapis & Carian</h2>
                <p class="text-sm text-gray-600">Gunakan penapis untuk mencari aset tertentu</p>
            </div>
            <i class='bx bx-filter-alt text-2xl text-gray-400'></i>
        </div>
        
        <form method="GET" action="{{ route('admin.immovable-assets.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                    <div class="relative">
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Nama aset..."
                               class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <i class='bx bx-search absolute left-3 top-2.5 text-gray-400'></i>
                    </div>
                </div>

                <!-- Asset Type Filter -->
                <div>
                    <label for="jenis_aset" class="block text-sm font-medium text-gray-700 mb-2">Jenis Aset</label>
                    <select id="jenis_aset" name="jenis_aset" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Semua Jenis</option>
                        <option value="Tanah" {{ request('jenis_aset') === 'Tanah' ? 'selected' : '' }}>Tanah</option>
                        <option value="Bangunan" {{ request('jenis_aset') === 'Bangunan' ? 'selected' : '' }}>Bangunan</option>
                        <option value="Tanah dan Bangunan" {{ request('jenis_aset') === 'Tanah dan Bangunan' ? 'selected' : '' }}>Tanah dan Bangunan</option>
                    </select>
                </div>

                <!-- Condition Filter -->
                <div>
                    <label for="keadaan_semasa" class="block text-sm font-medium text-gray-700 mb-2">Keadaan</label>
                    <select id="keadaan_semasa" name="keadaan_semasa" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Semua Keadaan</option>
                        <option value="Sangat Baik" {{ request('keadaan_semasa') === 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik</option>
                        <option value="Baik" {{ request('keadaan_semasa') === 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Sederhana" {{ request('keadaan_semasa') === 'Sederhana' ? 'selected' : '' }}>Sederhana</option>
                        <option value="Perlu Pembaikan" {{ request('keadaan_semasa') === 'Perlu Pembaikan' ? 'selected' : '' }}>Perlu Pembaikan</option>
                        <option value="Rosak" {{ request('keadaan_semasa') === 'Rosak' ? 'selected' : '' }}>Rosak</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit" 
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors flex items-center">
                        <i class='bx bx-search mr-2'></i>
                        Cari
                    </button>
                    <a href="{{ route('admin.immovable-assets.index') }}" 
                       class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Assets Table Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <!-- Table Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Senarai Aset Tak Alih</h2>
                    <p class="text-sm text-gray-600">Urus dan pantau semua aset tak alih sistem</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">{{ $immovableAssets->total() }} aset</span>
                    <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Masjid/Surau</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keluasan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keadaan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kos Perolehan</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($immovableAssets as $asset)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <i class='bx bx-buildings text-emerald-700 text-lg'></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $asset->nama_aset }}</div>
                                    <div class="text-sm text-gray-500">{{ $asset->jenis_aset }}</div>
                                    @if($asset->no_lot)
                                        <div class="text-xs text-gray-400 flex items-center">
                                            <i class='bx bx-map-pin mr-1'></i>
                                            Lot: {{ $asset->no_lot }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $asset->masjidSurau->nama }}</div>
                            <div class="text-sm text-gray-500">{{ $asset->masjidSurau->negeri }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ number_format($asset->luas_tanah_bangunan, 2) }} m²</div>
                            <div class="text-sm text-gray-500">{{ $asset->sumber_perolehan }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full 
                                @if($asset->keadaan_semasa === 'Sangat Baik') bg-green-100 text-green-800
                                @elseif($asset->keadaan_semasa === 'Baik') bg-blue-100 text-blue-800
                                @elseif($asset->keadaan_semasa === 'Sederhana') bg-yellow-100 text-yellow-800
                                @elseif($asset->keadaan_semasa === 'Perlu Pembaikan') bg-orange-100 text-orange-800
                                @else bg-red-100 text-red-800 @endif">
                                <div class="w-2 h-2 
                                    @if($asset->keadaan_semasa === 'Sangat Baik') bg-green-500
                                    @elseif($asset->keadaan_semasa === 'Baik') bg-blue-500
                                    @elseif($asset->keadaan_semasa === 'Sederhana') bg-yellow-500
                                    @elseif($asset->keadaan_semasa === 'Perlu Pembaikan') bg-orange-500
                                    @else bg-red-500 @endif rounded-full mr-2"></div>
                                {{ $asset->keadaan_semasa }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">RM {{ number_format($asset->kos_perolehan, 2) }}</div>
                            <div class="text-sm text-gray-500">{{ $asset->tarikh_perolehan->format('d/m/Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="{{ route('admin.immovable-assets.show', $asset) }}" 
                                   class="w-8 h-8 bg-emerald-100 hover:bg-emerald-200 text-emerald-600 rounded-lg flex items-center justify-center transition-colors"
                                   title="Lihat">
                                    <i class='bx bx-show text-sm'></i>
                                </a>
                                <a href="{{ route('admin.immovable-assets.edit', $asset) }}" 
                                   class="w-8 h-8 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-lg flex items-center justify-center transition-colors"
                                   title="Edit">
                                    <i class='bx bx-edit text-sm'></i>
                                </a>
                                
                                <form action="{{ route('admin.immovable-assets.destroy', $asset) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Adakah anda pasti ingin memadamkan aset ini?')">
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
                                <i class='bx bx-buildings text-5xl text-gray-400 mb-4'></i>
                                <p class="text-gray-500 text-lg">Tiada aset tak alih dijumpai</p>
                                <p class="text-gray-400 text-sm">Cuba tukar kriteria carian anda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($immovableAssets->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $immovableAssets->links() }}
        </div>
        @endif
    </div>
</div>
@endsection 