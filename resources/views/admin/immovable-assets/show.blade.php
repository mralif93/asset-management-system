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
                <h1 class="text-3xl font-bold mb-2">Detail Aset Tak Alih</h1>
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
                <div class="w-20 h-20 bg-emerald-500 rounded-2xl flex items-center justify-center shadow-xl">
                    <i class='bx bx-buildings text-white text-4xl'></i>
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
            <button type="button" onclick="window.print()"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                <i class='bx bx-printer mr-2'></i>
                Cetak
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Asset Value -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700">Nilai Aset</p>
                    <p class="text-2xl font-bold text-blue-900">RM {{ number_format($immovableAsset->kos_perolehan, 0) }}</p>
                    <p class="text-xs text-blue-600 mt-1">Kos Perolehan</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-dollar text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Area Size -->
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-700">Luas Keseluruhan</p>
                    <p class="text-2xl font-bold text-amber-900">{{ number_format($immovableAsset->luas_tanah_bangunan, 2) }}</p>
                    <p class="text-xs text-amber-600 mt-1">Meter Persegi</p>
                </div>
                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-vector text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Age -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-700">Umur Aset</p>
                    <p class="text-2xl font-bold text-green-900">{{ $immovableAsset->tarikh_perolehan ? $immovableAsset->tarikh_perolehan->diffInYears(now()) : 0 }}</p>
                    <p class="text-xs text-green-600 mt-1">Tahun</p>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-time text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Condition Status -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700">Status Keadaan</p>
                    <p class="text-lg font-bold text-purple-900">{{ $immovableAsset->keadaan_semasa }}</p>
                    <p class="text-xs text-purple-600 mt-1">Penilaian Semasa</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
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
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Asas Aset</h3>
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

                    <!-- Asset Type -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-category text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Jenis Aset</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-100 text-emerald-800">
                                <i class='bx bx-buildings mr-1'></i>
                                {{ $immovableAsset->jenis_aset }}
                            </span>
                        </dd>
                    </div>

                    <!-- Masjid/Surau -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200 md:col-span-2">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-building text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Masjid/Surau</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $immovableAsset->masjidSurau->nama ?? 'Tidak ditetapkan' }}</dd>
                        @if($immovableAsset->masjidSurau)
                            <p class="text-xs text-gray-500 mt-2">Aset dimiliki oleh organisasi ini</p>
                        @endif
                    </div>

                    <!-- Address -->
                    @if($immovableAsset->alamat)
                    <div class="bg-white rounded-lg p-4 border border-gray-200 md:col-span-2">
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
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-file-contract text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Butiran Hakmilik</h3>
                        <p class="text-sm text-purple-700">Maklumat hakmilik dan ukuran</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Title Number -->
                    @if($immovableAsset->no_hakmilik)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-file text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">No. Hakmilik</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $immovableAsset->no_hakmilik }}</dd>
                    </div>
                    @endif

                    <!-- Lot Number -->
                    @if($immovableAsset->no_lot)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-map-pin text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">No. Lot</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $immovableAsset->no_lot }}</dd>
                    </div>
                    @endif

                    <!-- Area -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-vector text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Luas Keseluruhan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ number_format($immovableAsset->luas_tanah_bangunan, 2) }} m²</dd>
                        <p class="text-xs text-gray-500 mt-1">Meter persegi</p>
                    </div>
                </div>
            </div>

            <!-- Acquisition Details Section -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-handshake text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Perolehan</h3>
                        <p class="text-sm text-blue-700">Butiran perolehan dan nilai aset</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Acquisition Date -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar text-blue-600 mr-2'></i>
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
                            <i class='bx bx-source text-blue-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Sumber Perolehan</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if($immovableAsset->sumber_perolehan === 'Pembelian') bg-blue-100 text-blue-800
                                @elseif($immovableAsset->sumber_perolehan === 'Hibah') bg-green-100 text-green-800
                                @elseif($immovableAsset->sumber_perolehan === 'Wakaf') bg-purple-100 text-purple-800
                                @elseif($immovableAsset->sumber_perolehan === 'Derma') bg-amber-100 text-amber-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $immovableAsset->sumber_perolehan }}
                            </span>
                        </dd>
                    </div>

                    <!-- Acquisition Cost -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-dollar text-blue-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Kos Perolehan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">RM {{ number_format($immovableAsset->kos_perolehan, 2) }}</dd>
                        <p class="text-xs text-gray-500 mt-1">Ringgit Malaysia</p>
                    </div>
                </div>
            </div>

            <!-- Current Condition & Notes Section -->
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-check-circle text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Keadaan & Catatan</h3>
                        <p class="text-sm text-amber-700">Status semasa dan maklumat tambahan</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 gap-6">
                    <!-- Current Condition -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-check-circle text-amber-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Keadaan Semasa</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if($immovableAsset->keadaan_semasa === 'Sangat Baik' || $immovableAsset->keadaan_semasa === 'Baik') bg-green-100 text-green-800
                                @elseif($immovableAsset->keadaan_semasa === 'Sederhana') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                <div class="w-2 h-2 
                                    @if($immovableAsset->keadaan_semasa === 'Sangat Baik' || $immovableAsset->keadaan_semasa === 'Baik') bg-green-500
                                    @elseif($immovableAsset->keadaan_semasa === 'Sederhana') bg-yellow-500
                                    @else bg-red-500 @endif rounded-full mr-2"></div>
                                {{ $immovableAsset->keadaan_semasa }}
                            </span>
                        </dd>
                        <p class="text-xs text-gray-500 mt-2">Penilaian keadaan fizikal aset pada masa ini</p>
                    </div>

                    <!-- Notes -->
                    @if($immovableAsset->catatan)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-note text-amber-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Catatan</dt>
                        </div>
                        <dd class="text-gray-900">{{ $immovableAsset->catatan }}</dd>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Asset Images Section -->
            @if($immovableAsset->gambar_aset && count($immovableAsset->gambar_aset) > 0)
            <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 rounded-xl p-6 border border-indigo-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-indigo-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-images text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Gambar Aset</h3>
                        <p class="text-sm text-indigo-700">Koleksi gambar aset tak alih</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($immovableAsset->gambar_aset as $gambar)
                    <div class="relative group">
                        <img src="{{ Storage::url($gambar) }}" 
                             alt="Gambar {{ $immovableAsset->nama_aset }}" 
                             class="w-full h-32 object-cover rounded-lg shadow-md group-hover:shadow-lg transition-shadow cursor-pointer"
                             onclick="openImageModal('{{ Storage::url($gambar) }}')">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-opacity rounded-lg flex items-center justify-center">
                            <i class='bx bx-expand text-white opacity-0 group-hover:opacity-100 transition-opacity text-2xl'></i>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Quick Info & Actions -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-6">
                
                <!-- Asset Card -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-100 rounded-xl p-6 border border-indigo-200">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class='bx bx-buildings text-emerald-700 text-3xl'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $immovableAsset->nama_aset }}</h3>
                        <p class="text-sm text-gray-600">{{ $immovableAsset->jenis_aset }}</p>
                        <div class="flex items-center justify-center space-x-2 mt-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                {{ $immovableAsset->jenis_aset }}
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                @if($immovableAsset->keadaan_semasa === 'Sangat Baik' || $immovableAsset->keadaan_semasa === 'Baik') bg-green-100 text-green-800
                                @elseif($immovableAsset->keadaan_semasa === 'Sederhana') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $immovableAsset->keadaan_semasa }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan Pantas</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.immovable-assets.edit', $immovableAsset) }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg transition-colors">
                            <i class='bx bx-edit mr-2'></i>
                            Edit Maklumat
                        </a>
                        
                        <button type="button" onclick="window.print()"
                                class="w-full flex items-center justify-center px-4 py-3 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                            <i class='bx bx-printer mr-2'></i>
                            Cetak Detail
                        </button>
                        
                        <a href="{{ route('admin.immovable-assets.index') }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                            <i class='bx bx-list-ul mr-2'></i>
                            Senarai Aset
                        </a>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-6 border border-green-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-bar-chart text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Ringkasan Aset</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Nilai Aset:</span>
                            <span class="font-semibold text-green-700">RM {{ number_format($immovableAsset->kos_perolehan, 0) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Luas:</span>
                            <span class="font-semibold text-green-700">{{ number_format($immovableAsset->luas_tanah_bangunan, 2) }} m²</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Umur:</span>
                            <span class="font-semibold text-green-700">{{ $immovableAsset->tarikh_perolehan ? $immovableAsset->tarikh_perolehan->diffInYears(now()) : 0 }} tahun</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Status:</span>
                            <span class="font-semibold text-green-700">{{ $immovableAsset->keadaan_semasa }}</span>
                        </div>
                    </div>
                </div>

                <!-- System Info -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-100 rounded-xl p-6 border border-amber-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-info-circle text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Info Rekod</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center text-amber-700">
                            <i class='bx bx-calendar-plus mr-2'></i>
                            Dicipta: {{ $immovableAsset->created_at->format('d/m/Y') }}
                        </div>
                        <div class="flex items-center text-amber-700">
                            <i class='bx bx-edit mr-2'></i>
                            Dikemaskini: {{ $immovableAsset->updated_at->format('d/m/Y') }}
                        </div>
                        <div class="flex items-center text-amber-700">
                            <i class='bx bx-shield-check mr-2'></i>
                            Data dilindungi sistem
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <img id="modalImage" src="" alt="Gambar Aset" class="max-w-full max-h-full object-contain rounded-lg">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-75">
            <i class='bx bx-x text-2xl'></i>
        </button>
    </div>
</div>

@push('scripts')
<script>
    function openImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside the image
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
</script>
@endpush
@endsection 