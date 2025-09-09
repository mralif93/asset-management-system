@extends('layouts.admin')

@section('title', 'Pengurusan Pemeriksaan')
@section('page-title', 'Pengurusan Pemeriksaan')
@section('page-description', 'Urus semua pemeriksaan aset dalam sistem')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Pengurusan Pemeriksaan</h1>
                <p class="text-emerald-100 text-lg">Urus dan pantau semua pemeriksaan aset dalam sistem</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-search-alt text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $inspections->total() }} pemeriksaan</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-shield-check text-emerald-200'></i>
                        <span class="text-emerald-100">Sistem Aktif</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-search-alt text-6xl text-emerald-200'></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Inspections -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-search-alt text-emerald-600 text-xl'></i>
                </div>
                <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $inspections->total() }}</h3>
            <p class="text-sm text-gray-600">Jumlah Pemeriksaan</p>
        </div>

        <!-- Good Condition -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-check-circle text-green-600 text-xl'></i>
                </div>
                <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">A</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $inspections->where('kondisi_aset', 'Sedang Digunakan')->count() }}</h3>
            <p class="text-sm text-gray-600">Sedang Digunakan</p>
        </div>

        <!-- Moderate Condition -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-error-circle text-yellow-600 text-xl'></i>
                </div>
                <span class="text-sm text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full font-medium">B</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $inspections->where('kondisi_aset', 'Tidak Digunakan')->count() }}</h3>
            <p class="text-sm text-gray-600">Tidak Digunakan</p>
        </div>

        <!-- Poor Condition -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-x-circle text-red-600 text-xl'></i>
                </div>
                <span class="text-sm text-red-600 bg-red-100 px-2 py-1 rounded-full font-medium">C</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $inspections->where('kondisi_aset', 'Rosak')->count() }}</h3>
            <p class="text-sm text-gray-600">Rosak</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Add Inspection -->
        <a href="{{ route('admin.inspections.create') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                    <i class='bx bx-plus text-emerald-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-emerald-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Tambah Pemeriksaan</h3>
            <p class="text-sm text-gray-600">Rekod pemeriksaan baharu</p>
        </a>

        <!-- Export Inspections -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <i class='bx bx-download text-blue-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-blue-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Eksport Data</h3>
            <p class="text-sm text-gray-600">Muat turun laporan pemeriksaan</p>
        </div>

        <!-- Inspection Reports -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <i class='bx bx-bar-chart text-purple-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-purple-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Laporan Pemeriksaan</h3>
            <p class="text-sm text-gray-600">Analitik dan statistik</p>
        </div>

        <!-- Schedule Inspections -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                    <i class='bx bx-calendar text-amber-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-amber-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Jadual Pemeriksaan</h3>
            <p class="text-sm text-gray-600">Atur pemeriksaan akan datang</p>
        </div>
    </div>

    <!-- Search and Filters Card -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Penapis & Carian</h2>
                <p class="text-sm text-gray-600">Gunakan penapis untuk mencari pemeriksaan tertentu</p>
            </div>
            <i class='bx bx-filter-alt text-2xl text-gray-400'></i>
        </div>
        
        <form method="GET" action="{{ route('admin.inspections.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
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

                <!-- Condition Filter -->
                <div>
                    <label for="kondisi" class="block text-sm font-medium text-gray-700 mb-2">Kondisi</label>
                    <select id="kondisi" name="kondisi" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">Semua Kondisi</option>
                        <option value="Baik" {{ request('kondisi') === 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Sederhana" {{ request('kondisi') === 'Sederhana' ? 'selected' : '' }}>Sederhana</option>
                        <option value="Buruk" {{ request('kondisi') === 'Buruk' ? 'selected' : '' }}>Buruk</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div>
                    <label for="tarikh" class="block text-sm font-medium text-gray-700 mb-2">Tarikh Pemeriksaan</label>
                    <input type="date" 
                           id="tarikh" 
                           name="tarikh" 
                           value="{{ request('tarikh') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit" 
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors flex items-center">
                        <i class='bx bx-search mr-2'></i>
                        Cari
                    </button>
                    <a href="{{ route('admin.inspections.index') }}" 
                       class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Inspections Table Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <!-- Table Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Senarai Pemeriksaan</h2>
                    <p class="text-sm text-gray-600">Urus dan pantau semua pemeriksaan aset</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">{{ $inspections->total() }} pemeriksaan</span>
                    <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarikh Pemeriksaan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kondisi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemeriksaan Akan Datang</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemeriksa</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($inspections as $inspection)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <i class='bx bx-search-alt text-emerald-700 text-lg'></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $inspection->asset->nama_aset }}</div>
                                    <div class="text-sm text-gray-500">{{ $inspection->asset->no_siri_pendaftaran }}</div>
                                    @if($inspection->asset->kategori)
                                        <div class="text-xs text-gray-400 flex items-center">
                                            <i class='bx bx-category mr-1'></i>
                                            {{ $inspection->asset->kategori }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($inspection->tarikh_pemeriksaan)->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($inspection->tarikh_pemeriksaan)->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full 
                                @if($inspection->kondisi_aset === 'Sedang Digunakan') bg-green-100 text-green-800
                                @elseif($inspection->kondisi_aset === 'Tidak Digunakan') bg-yellow-100 text-yellow-800
                                @elseif($inspection->kondisi_aset === 'Rosak') bg-red-100 text-red-800
                                @elseif($inspection->kondisi_aset === 'Sedang Diselenggara') bg-blue-100 text-blue-800
                                @elseif($inspection->kondisi_aset === 'Hilang') bg-gray-100 text-gray-800
                                @else bg-gray-100 text-gray-800 @endif">
                                <div class="w-2 h-2 
                                    @if($inspection->kondisi_aset === 'Sedang Digunakan') bg-green-500
                                    @elseif($inspection->kondisi_aset === 'Tidak Digunakan') bg-yellow-500
                                    @elseif($inspection->kondisi_aset === 'Rosak') bg-red-500
                                    @elseif($inspection->kondisi_aset === 'Sedang Diselenggara') bg-blue-500
                                    @elseif($inspection->kondisi_aset === 'Hilang') bg-gray-500
                                    @else bg-gray-500 @endif rounded-full mr-2"></div>
                                {{ $inspection->kondisi_aset }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($inspection->tarikh_pemeriksaan_akan_datang)
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($inspection->tarikh_pemeriksaan_akan_datang)->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($inspection->tarikh_pemeriksaan_akan_datang)->diffForHumans() }}</div>
                            @else
                                <span class="text-gray-400 text-sm">Belum dijadualkan</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $inspection->nama_pemeriksa ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="{{ route('admin.inspections.show', $inspection) }}" 
                                   class="w-8 h-8 bg-emerald-100 hover:bg-emerald-200 text-emerald-600 rounded-lg flex items-center justify-center transition-colors"
                                   title="Lihat">
                                    <i class='bx bx-show text-sm'></i>
                                </a>
                                <a href="{{ route('admin.inspections.edit', $inspection) }}" 
                                   class="w-8 h-8 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-lg flex items-center justify-center transition-colors"
                                   title="Edit">
                                    <i class='bx bx-edit text-sm'></i>
                                </a>
                                
                                @if(auth()->user()->role === 'admin')
                                <form action="{{ route('admin.inspections.destroy', $inspection) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Adakah anda pasti ingin memadamkan pemeriksaan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg flex items-center justify-center transition-colors"
                                            title="Padamkan">
                                        <i class='bx bx-trash text-sm'></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class='bx bx-search-alt text-5xl text-gray-400 mb-4'></i>
                                <p class="text-gray-500 text-lg">Tiada pemeriksaan dijumpai</p>
                                <p class="text-gray-400 text-sm">Cuba tukar kriteria carian anda atau tambah pemeriksaan baharu</p>
                                <a href="{{ route('admin.inspections.create') }}" 
                                   class="mt-4 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                                    <i class='bx bx-plus mr-2'></i>
                                    Tambah Pemeriksaan
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($inspections->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $inspections->links() }}
        </div>
        @endif
    </div>
</div>
@endsection 