@extends('layouts.admin')

@section('title', 'Maklumat Aset Tak Alih')
@section('page-title', 'Maklumat Aset Tak Alih')
@section('page-description', 'Paparan terperinci maklumat aset tak alih')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Profil Aset Tak Alih</h1>
                <p class="text-emerald-100 text-lg">Paparan lengkap maklumat {{ $immovableAsset->nama_aset }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-buildings text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $immovableAsset->jenis_aset }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 
                            @if($immovableAsset->keadaan_semasa === 'Sangat Baik' || $immovableAsset->keadaan_semasa === 'Baik') bg-green-400
                            @elseif($immovableAsset->keadaan_semasa === 'Sederhana') bg-yellow-400
                            @elseif($immovableAsset->keadaan_semasa === 'Perlu Pembaikan') bg-orange-400
                            @else bg-red-400 @endif rounded-full"></div>
                        <span class="text-emerald-100">{{ $immovableAsset->keadaan_semasa }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-calendar text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $immovableAsset->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-emerald-500 rounded-2xl flex items-center justify-center text-3xl font-bold text-white shadow-xl">
                    <i class='bx bx-buildings text-4xl'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <div class="flex items-center space-x-2 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600">
            <i class='bx bx-home'></i>
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <a href="{{ route('admin.immovable-assets.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Aset Tak Alih
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">{{ $immovableAsset->nama_aset }}</span>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end mb-8">
        <div class="flex space-x-3">
            <a href="{{ route('admin.immovable-assets.edit', $immovableAsset) }}" 
               class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                <i class='bx bx-edit mr-2'></i>
                Edit Aset
            </a>
            <form action="{{ route('admin.immovable-assets.destroy', $immovableAsset) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('Adakah anda pasti ingin memadamkan aset ini?')"
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                    <i class='bx bx-trash mr-2'></i>
                    Padamkan Aset
                </button>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Asset Value -->
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-700">Nilai Aset</p>
                    <p class="text-2xl font-bold text-emerald-900">RM {{ number_format($immovableAsset->kos_perolehan, 0) }}</p>
                    <p class="text-xs text-emerald-600 mt-1">Kos Perolehan</p>
                </div>
                <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-dollar text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Area Size -->
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-700">Luas Keseluruhan</p>
                    <p class="text-2xl font-bold text-emerald-900">{{ number_format($immovableAsset->luas_tanah_bangunan, 2) }}</p>
                    <p class="text-xs text-emerald-600 mt-1">Meter Persegi</p>
                </div>
                <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-vector text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Age -->
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-700">Umur Aset</p>
                    <p class="text-2xl font-bold text-emerald-900">{{ $immovableAsset->tarikh_perolehan ? (int)$immovableAsset->tarikh_perolehan->diffInYears(now()) : 0 }}</p>
                    <p class="text-xs text-emerald-600 mt-1">Tahun</p>
                </div>
                <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-time text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Condition Status -->
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-700">Status Keadaan</p>
                    <p class="text-lg font-bold text-emerald-900">{{ $immovableAsset->keadaan_semasa }}</p>
                    <p class="text-xs text-emerald-600 mt-1">Penilaian Semasa</p>
                </div>
                <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-check-shield text-white text-xl'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column - Main Information -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Basic Asset Information Section -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-buildings text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Asas</h3>
                        <p class="text-sm text-emerald-700">Data dan butiran aset tak alih</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Asset Name -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-buildings text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nama Aset</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $immovableAsset->nama_aset }}</dd>
                    </div>

                    <!-- Registration Number -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-barcode text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">No. Siri Pendaftaran</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900 font-mono">{{ $immovableAsset->no_siri_pendaftaran }}</dd>
                    </div>

                    <!-- Asset Type -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-category text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Jenis Aset</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $immovableAsset->jenis_aset }}</dd>
                    </div>

                    <!-- Condition Status -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-check-circle text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Keadaan Semasa</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if($immovableAsset->keadaan_semasa === 'Sangat Baik' || $immovableAsset->keadaan_semasa === 'Baik') bg-green-100 text-green-800
                                @elseif($immovableAsset->keadaan_semasa === 'Sederhana') bg-yellow-100 text-yellow-800
                                @elseif($immovableAsset->keadaan_semasa === 'Perlu Pembaikan') bg-orange-100 text-orange-800
                                @else bg-red-100 text-red-800 @endif">
                                <div class="w-2 h-2 
                                    @if($immovableAsset->keadaan_semasa === 'Sangat Baik' || $immovableAsset->keadaan_semasa === 'Baik') bg-green-500
                                    @elseif($immovableAsset->keadaan_semasa === 'Sederhana') bg-yellow-500
                                    @elseif($immovableAsset->keadaan_semasa === 'Perlu Pembaikan') bg-orange-500
                                    @else bg-red-500 @endif rounded-full mr-2"></div>
                                {{ $immovableAsset->keadaan_semasa }}
                            </span>
                        </dd>
                    </div>

                    <!-- Address -->
                    @if($immovableAsset->alamat)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-map text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Alamat</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $immovableAsset->alamat }}</dd>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Property Details Section -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-file-contract text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Butiran Hakmilik</h3>
                        <p class="text-sm text-emerald-700">Maklumat hakmilik dan ukuran</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Title Number -->
                    @if($immovableAsset->no_hakmilik)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-file text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">No. Hakmilik</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $immovableAsset->no_hakmilik }}</dd>
                    </div>
                    @endif

                    <!-- Lot Number -->
                    @if($immovableAsset->no_lot)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-map-pin text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">No. Lot</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $immovableAsset->no_lot }}</dd>
                    </div>
                    @endif

                    <!-- Area -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-vector text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Luas Keseluruhan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ number_format($immovableAsset->luas_tanah_bangunan, 2) }} m²</dd>
                        <p class="text-xs text-gray-500 mt-1">Meter persegi</p>
                    </div>
                </div>
            </div>

            <!-- Acquisition Details Section -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-receipt text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Perolehan</h3>
                        <p class="text-sm text-emerald-700">Butiran cara dan masa perolehan aset</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Acquisition Date -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Tarikh Perolehan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $immovableAsset->tarikh_perolehan ? $immovableAsset->tarikh_perolehan->format('d/m/Y') : '-' }}</dd>
                        @if($immovableAsset->tarikh_perolehan)
                            <p class="text-xs text-gray-500 mt-1">{{ $immovableAsset->tarikh_perolehan->diffForHumans() }}</p>
                        @endif
                    </div>

                    <!-- Acquisition Source -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-source text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Sumber Perolehan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $immovableAsset->sumber_perolehan }}</dd>
                    </div>

                    <!-- Acquisition Cost -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-dollar text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Kos Perolehan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">RM {{ number_format($immovableAsset->kos_perolehan, 2) }}</dd>
                    </div>

                    <!-- Masjid/Surau -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-building text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Masjid/Surau</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $immovableAsset->masjidSurau->nama ?? '-' }}</dd>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            @if($immovableAsset->catatan)
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-note text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Catatan</h3>
                        <p class="text-sm text-emerald-700">Nota dan maklumat tambahan</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <p class="text-gray-900 leading-relaxed">{{ $immovableAsset->catatan }}</p>
                </div>
            </div>
            @endif

        </div>

        <!-- Right Column - Quick Info & Actions -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-6">
                
                <!-- Asset Card -->
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class='bx bx-buildings text-emerald-700 text-3xl'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $immovableAsset->nama_aset }}</h3>
                        <p class="text-sm text-gray-600">{{ $immovableAsset->no_siri_pendaftaran }}</p>
                        <div class="flex items-center justify-center space-x-2 mt-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $immovableAsset->jenis_aset }}
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                @if($immovableAsset->keadaan_semasa === 'Sangat Baik' || $immovableAsset->keadaan_semasa === 'Baik') bg-green-100 text-green-800
                                @elseif($immovableAsset->keadaan_semasa === 'Sederhana') bg-yellow-100 text-yellow-800
                                @elseif($immovableAsset->keadaan_semasa === 'Perlu Pembaikan') bg-orange-100 text-orange-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $immovableAsset->keadaan_semasa }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-bolt-circle text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Tindakan Pantas</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.immovable-assets.edit', $immovableAsset) }}" 
                           class="group w-full flex items-center justify-center px-4 py-3 bg-white hover:bg-emerald-50 text-emerald-700 hover:text-emerald-800 rounded-lg border border-emerald-200 hover:border-emerald-300 shadow-sm hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
                            <i class='bx bx-edit mr-2 text-lg group-hover:scale-110 transition-transform duration-200'></i>
                            <span class="font-medium">Edit Maklumat</span>
                        </a>
                        
                        <button onclick="window.print()" 
                                class="group w-full flex items-center justify-center px-4 py-3 bg-white hover:bg-emerald-50 text-emerald-700 hover:text-emerald-800 rounded-lg border border-emerald-200 hover:border-emerald-300 shadow-sm hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
                            <i class='bx bx-printer mr-2 text-lg group-hover:scale-110 transition-transform duration-200'></i>
                            <span class="font-medium">Cetak Maklumat</span>
                        </button>
                        
                        <a href="{{ route('admin.immovable-assets.index') }}" 
                           class="group w-full flex items-center justify-center px-4 py-3 bg-white hover:bg-emerald-50 text-emerald-700 hover:text-emerald-800 rounded-lg border border-emerald-200 hover:border-emerald-300 shadow-sm hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
                            <i class='bx bx-list-ul mr-2 text-lg group-hover:scale-110 transition-transform duration-200'></i>
                            <span class="font-medium">Senarai Aset</span>
                        </a>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-bar-chart text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Statistik Ringkas</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Umur Aset:</span>
                            <span class="font-semibold text-emerald-700">{{ $immovableAsset->tarikh_perolehan ? (int)$immovableAsset->tarikh_perolehan->diffInYears(now()) : 0 }} tahun</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Nilai Perolehan:</span>
                            <span class="font-semibold text-emerald-700">RM {{ number_format($immovableAsset->kos_perolehan, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Luas:</span>
                            <span class="font-semibold text-emerald-700">{{ number_format($immovableAsset->luas_tanah_bangunan, 2) }} m²</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Status:</span>
                            <span class="font-semibold text-emerald-700">{{ $immovableAsset->keadaan_semasa }}</span>
                        </div>
                    </div>
                </div>

                <!-- Asset Images -->
                @if($immovableAsset->gambar_aset && is_array($immovableAsset->gambar_aset) && count($immovableAsset->gambar_aset) > 0)
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-image text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Gambar Aset</h3>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($immovableAsset->gambar_aset as $index => $image)
                        <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                            <img src="{{ Storage::url($image) }}" 
                                 alt="Gambar Aset {{ $index + 1 }}"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform cursor-pointer"
                                 onclick="openImageModal('{{ Storage::url($image) }}')">
                        </div>
                        @if($index >= 3) @break @endif
                        @endforeach
                    </div>
                    
                    @if(is_array($immovableAsset->gambar_aset) && count($immovableAsset->gambar_aset) > 4)
                    <p class="text-center text-sm text-emerald-600 mt-3">
                        +{{ count($immovableAsset->gambar_aset) - 4 }} gambar lagi
                    </p>
                    @endif
                </div>
                @endif

                <!-- System Info -->
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-info-circle text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Info Sistem</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center text-gray-700">
                            <i class='bx bx-calendar-check mr-2'></i>
                            Dicipta: {{ $immovableAsset->created_at->format('d/m/Y') }}
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class='bx bx-edit mr-2'></i>
                            Dikemaskini: {{ $immovableAsset->updated_at->format('d/m/Y') }}
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class='bx bx-shield-check mr-2'></i>
                            Data dilindungi SSL
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-6xl max-h-full bg-white rounded-xl shadow-2xl overflow-hidden">
        <button id="closeModal" class="absolute top-4 right-4 z-10 w-10 h-10 bg-black bg-opacity-50 text-white rounded-full flex items-center justify-center hover:bg-opacity-75 transition-all duration-200">
            <i class='bx bx-x text-2xl'></i>
        </button>
        <div class="p-4">
            <img id="modalImage" src="" alt="Full size image" class="max-w-full max-h-[80vh] object-contain mx-auto">
        </div>
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-50 text-white px-4 py-2 rounded-lg">
            <p id="modalImageName" class="text-sm font-medium">Gambar Aset</p>
        </div>
    </div>
</div>

<script>
function openImageModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const modalImageName = document.getElementById('modalImageName');
    
    modalImage.src = imageSrc;
    modalImageName.textContent = 'Gambar Aset';
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto'; // Restore scrolling
}

// Close modal functionality
document.getElementById('closeModal').addEventListener('click', function() {
    closeImageModal();
});

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('imageModal');
        if (!modal.classList.contains('hidden')) {
            closeImageModal();
        }
    }
});
</script>
@endsection
