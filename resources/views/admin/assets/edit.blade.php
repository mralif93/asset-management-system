@extends('layouts.admin')

@section('title', 'Edit Aset')
@section('page-title', 'Edit Aset')
@section('page-description', 'Kemaskini maklumat aset')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Edit Aset</h1>
                <p class="text-emerald-100 text-lg">Kemaskini maklumat untuk {{ $asset->nama_aset }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-edit text-emerald-200'></i>
                        <span class="text-emerald-100">Kemaskini Data</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 {{ $asset->status_aset === 'Sedang Digunakan' ? 'bg-green-400' : ($asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-400' : 'bg-red-400') }} rounded-full"></div>
                        <span class="text-emerald-100">{{ $asset->status_aset }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-edit-alt text-6xl text-emerald-200'></i>
            </div>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <div class="flex items-center space-x-2 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600">
            <i class='bx bx-home'></i>
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <a href="{{ route('admin.assets.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Aset
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">Edit: {{ $asset->nama_aset }}</span>
    </div>



    <!-- Form Card - Full Width -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <form action="{{ route('admin.assets.update', $asset) }}" method="POST" enctype="multipart/form-data" x-data="editAssetForm()" class="space-y-0">
            @csrf
            @method('PUT')

            <!-- Form Header -->
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Kemaskini Maklumat Aset</h2>
                        <p class="text-sm text-gray-600">Edit dan kemaskini maklumat aset dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $asset->status_aset === 'Sedang Digunakan' ? 'bg-green-100 text-green-800' : ($asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            <div class="w-2 h-2 {{ $asset->status_aset === 'Sedang Digunakan' ? 'bg-green-500' : ($asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-500' : 'bg-red-500') }} rounded-full mr-2"></div>
                            {{ $asset->status_aset }}
                        </span>
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $asset->jenis_aset }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Form Content - Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-6">
                
                <!-- Left Column - Main Form -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Basic Asset Information Section -->
                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-package text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Maklumat Asas Aset</h3>
                                <p class="text-sm text-emerald-700">Kemaskini maklumat asas dan identifikasi aset</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Asset Name -->
                            <div>
                                <label for="nama_aset" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-package mr-1'></i>
                                    Nama Aset <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-package text-gray-400'></i>
                                    </div>
                                    <input type="text" 
                                           id="nama_aset" 
                                           name="nama_aset" 
                                           value="{{ old('nama_aset', $asset->nama_aset) }}"
                                           required
                                           x-model="form.nama_aset"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nama_aset') border-red-500 @enderror bg-white"
                                           placeholder="Masukkan nama aset">
                                </div>
                                @error('nama_aset')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Asset Type -->
                            <div>
                                <label for="jenis_aset" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-category mr-1'></i>
                                    Jenis Aset <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-category text-gray-400'></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class='bx bx-chevron-down text-gray-400'></i>
                                    </div>
                                    <select id="jenis_aset" 
                                            name="jenis_aset" 
                                            required
                                            x-model="form.jenis_aset"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jenis_aset') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Jenis Aset</option>
                                        @foreach($assetTypes as $type)
                                            <option value="{{ $type }}" {{ old('jenis_aset', $asset->jenis_aset) === $type ? 'selected' : '' }}>{{ $type }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('jenis_aset')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Type of Asset -->
                            <div>
                                <label for="kategori_aset" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-cube mr-1'></i>
                                    Kategori Aset <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-cube text-gray-400'></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class='bx bx-chevron-down text-gray-400'></i>
                                    </div>
                                    <select id="kategori_aset" 
                                            name="kategori_aset" 
                                            required
                                            x-model="form.kategori_aset"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kategori_aset') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Kategori</option>
                                        <option value="asset" {{ old('kategori_aset', $asset->kategori_aset) === 'asset' ? 'selected' : '' }}>Asset</option>
                                        <option value="non-asset" {{ old('kategori_aset', $asset->kategori_aset) === 'non-asset' ? 'selected' : '' }}>Non-Asset</option>
                                    </select>
                                </div>
                                @error('kategori_aset')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Serial Number (Read-only) -->
                            <div class="md:col-span-2">
                                <label for="no_siri_pendaftaran" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-barcode mr-1'></i>
                                    No. Siri Pendaftaran <span class="text-gray-500">(Read-only)</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-barcode text-gray-400'></i>
                                    </div>
                                    <input type="text" 
                                           id="no_siri_pendaftaran" 
                                           name="no_siri_pendaftaran" 
                                           value="{{ $asset->no_siri_pendaftaran }}"
                                           readonly
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-600 font-mono">
                                </div>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status_aset" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-check-circle mr-1'></i>
                                    Status Aset <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-check-circle text-gray-400'></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class='bx bx-chevron-down text-gray-400'></i>
                                    </div>
                                    <select id="status_aset" 
                                            name="status_aset" 
                                            required
                                            x-model="form.status_aset"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('status_aset') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Status</option>
                                        <option value="Sedang Digunakan" {{ old('status_aset', $asset->status_aset) === 'Sedang Digunakan' ? 'selected' : '' }}>Sedang Digunakan</option>
                                        <option value="Dalam Penyelenggaraan" {{ old('status_aset', $asset->status_aset) === 'Dalam Penyelenggaraan' ? 'selected' : '' }}>Dalam Penyelenggaraan</option>
                                        <option value="Rosak" {{ old('status_aset', $asset->status_aset) === 'Rosak' ? 'selected' : '' }}>Rosak</option>
                                    </select>
                                </div>
                                @error('status_aset')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Physical Condition -->
                            <div>
                                <label for="keadaan_fizikal" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-health mr-1'></i>
                                    Keadaan Fizikal <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-health text-gray-400'></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class='bx bx-chevron-down text-gray-400'></i>
                                    </div>
                                    <select id="keadaan_fizikal" 
                                            name="keadaan_fizikal" 
                                            required
                                            x-model="form.keadaan_fizikal"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('keadaan_fizikal') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Keadaan</option>
                                        <option value="Cemerlang" {{ old('keadaan_fizikal', $asset->keadaan_fizikal ?? 'Baik') === 'Cemerlang' ? 'selected' : '' }}>Cemerlang</option>
                                        <option value="Baik" {{ old('keadaan_fizikal', $asset->keadaan_fizikal ?? 'Baik') === 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Sederhana" {{ old('keadaan_fizikal', $asset->keadaan_fizikal ?? 'Baik') === 'Sederhana' ? 'selected' : '' }}>Sederhana</option>
                                        <option value="Rosak" {{ old('keadaan_fizikal', $asset->keadaan_fizikal ?? 'Baik') === 'Rosak' ? 'selected' : '' }}>Rosak</option>
                                        <option value="Tidak Boleh Digunakan" {{ old('keadaan_fizikal', $asset->keadaan_fizikal ?? 'Baik') === 'Tidak Boleh Digunakan' ? 'selected' : '' }}>Tidak Boleh Digunakan</option>
                                    </select>
                                </div>
                                @error('keadaan_fizikal')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Warranty Status -->
                            <div>
                                <label for="status_jaminan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-shield-check mr-1'></i>
                                    Status Jaminan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-shield-check text-gray-400'></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class='bx bx-chevron-down text-gray-400'></i>
                                    </div>
                                    <select id="status_jaminan" 
                                            name="status_jaminan" 
                                            required
                                            x-model="form.status_jaminan"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('status_jaminan') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Status Jaminan</option>
                                        <option value="Aktif" {{ old('status_jaminan', $asset->status_jaminan ?? 'Tiada Jaminan') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tamat" {{ old('status_jaminan', $asset->status_jaminan ?? 'Tiada Jaminan') === 'Tamat' ? 'selected' : '' }}>Tamat</option>
                                        <option value="Tiada Jaminan" {{ old('status_jaminan', $asset->status_jaminan ?? 'Tiada Jaminan') === 'Tiada Jaminan' ? 'selected' : '' }}>Tiada Jaminan</option>
                                    </select>
                                </div>
                                @error('status_jaminan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Last Inspection Date -->
                            <div>
                                <label for="tarikh_pemeriksaan_terakhir" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-calendar-check mr-1'></i>
                                    Tarikh Pemeriksaan Terakhir
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-calendar-check text-gray-400'></i>
                                    </div>
                                    <input type="date" 
                                           id="tarikh_pemeriksaan_terakhir" 
                                           name="tarikh_pemeriksaan_terakhir" 
                                           value="{{ old('tarikh_pemeriksaan_terakhir', $asset->tarikh_pemeriksaan_terakhir ? $asset->tarikh_pemeriksaan_terakhir->format('Y-m-d') : '') }}"
                                           x-model="form.tarikh_pemeriksaan_terakhir"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_pemeriksaan_terakhir') border-red-500 @enderror bg-white">
                                </div>
                                @error('tarikh_pemeriksaan_terakhir')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Next Maintenance Date -->
                            <div>
                                <label for="tarikh_penyelenggaraan_akan_datang" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-calendar-plus mr-1'></i>
                                    Tarikh Penyelenggaraan Akan Datang
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-calendar-plus text-gray-400'></i>
                                    </div>
                                    <input type="date" 
                                           id="tarikh_penyelenggaraan_akan_datang" 
                                           name="tarikh_penyelenggaraan_akan_datang" 
                                           value="{{ old('tarikh_penyelenggaraan_akan_datang', $asset->tarikh_penyelenggaraan_akan_datang ? $asset->tarikh_penyelenggaraan_akan_datang->format('Y-m-d') : '') }}"
                                           x-model="form.tarikh_penyelenggaraan_akan_datang"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_penyelenggaraan_akan_datang') border-red-500 @enderror bg-white">
                                </div>
                                @error('tarikh_penyelenggaraan_akan_datang')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Location -->
                            <div>
                                <label for="lokasi_penempatan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-map mr-1'></i>
                                    Lokasi Penempatan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-map text-gray-400'></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class='bx bx-chevron-down text-gray-400'></i>
                                    </div>
                                    <select id="lokasi_penempatan" 
                                            name="lokasi_penempatan" 
                                            required
                                            x-model="form.lokasi_penempatan"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('lokasi_penempatan') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Lokasi</option>
                                        <option value="Anjung kiri" {{ old('lokasi_penempatan', $asset->lokasi_penempatan) === 'Anjung kiri' ? 'selected' : '' }}>Anjung kiri</option>
                                        <option value="Anjung kanan" {{ old('lokasi_penempatan', $asset->lokasi_penempatan) === 'Anjung kanan' ? 'selected' : '' }}>Anjung kanan</option>
                                        <option value="Anjung Depan(Ruang Pengantin)" {{ old('lokasi_penempatan', $asset->lokasi_penempatan) === 'Anjung Depan(Ruang Pengantin)' ? 'selected' : '' }}>Anjung Depan(Ruang Pengantin)</option>
                                        <option value="Ruang Utama (tingkat atas, tingkat bawah)" {{ old('lokasi_penempatan', $asset->lokasi_penempatan) === 'Ruang Utama (tingkat atas, tingkat bawah)' ? 'selected' : '' }}>Ruang Utama (tingkat atas, tingkat bawah)</option>
                                        <option value="Bilik Mesyuarat" {{ old('lokasi_penempatan', $asset->lokasi_penempatan) === 'Bilik Mesyuarat' ? 'selected' : '' }}>Bilik Mesyuarat</option>
                                        <option value="Bilik Kuliah" {{ old('lokasi_penempatan', $asset->lokasi_penempatan) === 'Bilik Kuliah' ? 'selected' : '' }}>Bilik Kuliah</option>
                                        <option value="Bilik Bendahari" {{ old('lokasi_penempatan', $asset->lokasi_penempatan) === 'Bilik Bendahari' ? 'selected' : '' }}>Bilik Bendahari</option>
                                        <option value="Bilik Setiausaha" {{ old('lokasi_penempatan', $asset->lokasi_penempatan) === 'Bilik Setiausaha' ? 'selected' : '' }}>Bilik Setiausaha</option>
                                        <option value="Bilik Nazir & Imam" {{ old('lokasi_penempatan', $asset->lokasi_penempatan) === 'Bilik Nazir & Imam' ? 'selected' : '' }}>Bilik Nazir & Imam</option>
                                        <option value="Bangunan Jenazah" {{ old('lokasi_penempatan', $asset->lokasi_penempatan) === 'Bangunan Jenazah' ? 'selected' : '' }}>Bangunan Jenazah</option>
                                        <option value="Lain-lain" {{ old('lokasi_penempatan', $asset->lokasi_penempatan) === 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                                    </select>
                                </div>
                                @error('lokasi_penempatan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Acquisition Information Section -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-receipt text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Maklumat Perolehan</h3>
                                <p class="text-sm text-purple-700">Kemaskini butiran cara dan masa perolehan aset</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Acquisition Date -->
                            <div>
                                <label for="tarikh_perolehan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-calendar mr-1'></i>
                                    Tarikh Perolehan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="date" 
                                           id="tarikh_perolehan" 
                                           name="tarikh_perolehan" 
                                           value="{{ old('tarikh_perolehan', $asset->tarikh_perolehan ? $asset->tarikh_perolehan->format('Y-m-d') : '') }}"
                                           required
                                           x-model="form.tarikh_perolehan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_perolehan') border-red-500 @enderror bg-white">
                                    <i class='bx bx-calendar absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('tarikh_perolehan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Acquisition Method -->
                            <div>
                                <label for="kaedah_perolehan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-transfer mr-1'></i>
                                    Kaedah Perolehan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="kaedah_perolehan" 
                                            name="kaedah_perolehan" 
                                            required
                                            x-model="form.kaedah_perolehan"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kaedah_perolehan') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Kaedah</option>
                                        <option value="Pembelian" {{ old('kaedah_perolehan', $asset->kaedah_perolehan) === 'Pembelian' ? 'selected' : '' }}>Pembelian</option>
                                        <option value="Sumbangan" {{ old('kaedah_perolehan', $asset->kaedah_perolehan) === 'Sumbangan' ? 'selected' : '' }}>Sumbangan</option>
                                        <option value="Hibah" {{ old('kaedah_perolehan', $asset->kaedah_perolehan) === 'Hibah' ? 'selected' : '' }}>Hibah</option>
                                        <option value="Infaq" {{ old('kaedah_perolehan', $asset->kaedah_perolehan) === 'Infaq' ? 'selected' : '' }}>Infaq</option>
                                        <option value="Lain-lain" {{ old('kaedah_perolehan', $asset->kaedah_perolehan) === 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                                    </select>
                                    <i class='bx bx-transfer absolute left-3 top-3.5 text-gray-400'></i>
                                    <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('kaedah_perolehan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Acquisition Value -->
                            <div>
                                <label for="nilai_perolehan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-dollar mr-1'></i>
                                    Nilai Perolehan (RM) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           id="nilai_perolehan" 
                                           name="nilai_perolehan" 
                                           value="{{ old('nilai_perolehan', $asset->nilai_perolehan) }}"
                                           required
                                           step="0.01"
                                           min="0"
                                           x-model="form.nilai_perolehan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nilai_perolehan') border-red-500 @enderror bg-white"
                                           placeholder="0.00">
                                    <i class='bx bx-dollar absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('nilai_perolehan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Discount -->
                            <div>
                                <label for="diskaun" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-purchase-tag mr-1'></i>
                                    Diskaun (RM)
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-purchase-tag text-gray-400'></i>
                                    </div>
                                    <input type="number" 
                                           id="diskaun" 
                                           name="diskaun" 
                                           value="{{ old('diskaun', $asset->diskaun ?? '0.00') }}"
                                           step="0.01"
                                           min="0"
                                           x-model="form.diskaun"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('diskaun') border-red-500 @enderror bg-white"
                                           placeholder="0.00">
                                </div>
                                @error('diskaun')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Responsible Officer -->
                            <div>
                                <label for="pegawai_bertanggungjawab_lokasi" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-user mr-1'></i>
                                    Pegawai Bertanggungjawab <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="pegawai_bertanggungjawab_lokasi" 
                                           name="pegawai_bertanggungjawab_lokasi" 
                                           value="{{ old('pegawai_bertanggungjawab_lokasi', $asset->pegawai_bertanggungjawab_lokasi) }}"
                                           required
                                           x-model="form.pegawai_bertanggungjawab_lokasi"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('pegawai_bertanggungjawab_lokasi') border-red-500 @enderror bg-white"
                                           placeholder="Nama pegawai">
                                    <i class='bx bx-user absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('pegawai_bertanggungjawab_lokasi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Officer Position -->
                            <div>
                                <label for="jawatan_pegawai" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-briefcase mr-1'></i>
                                    Jawatan Pegawai
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-briefcase text-gray-400'></i>
                                    </div>
                                    <input type="text" 
                                           id="jawatan_pegawai" 
                                           name="jawatan_pegawai" 
                                           value="{{ old('jawatan_pegawai', $asset->jawatan_pegawai) }}"
                                           x-model="form.jawatan_pegawai"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jawatan_pegawai') border-red-500 @enderror bg-white"
                                           placeholder="Jawatan pegawai">
                                </div>
                                @error('jawatan_pegawai')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Financial Information Section -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-trending-down text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Maklumat Kewangan</h3>
                                <p class="text-sm text-blue-700">Kemaskini susut nilai dan umur faedah aset</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Useful Life -->
                            <div>
                                <label for="umur_faedah_tahunan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-time mr-1'></i>
                                    Tahun Dibeli
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-time text-gray-400'></i>
                                    </div>
                                    <input type="number" 
                                           id="umur_faedah_tahunan" 
                                           name="umur_faedah_tahunan" 
                                           value="{{ old('umur_faedah_tahunan', $asset->umur_faedah_tahunan) }}"
                                           min="1"
                                           x-model="form.umur_faedah_tahunan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('umur_faedah_tahunan') border-red-500 @enderror bg-white"
                                           placeholder="Cth: 5">
                                </div>
                                @error('umur_faedah_tahunan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Annual Depreciation -->
                            <div>
                                <label for="susut_nilai_tahunan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-trending-down mr-1'></i>
                                    Susut Nilai Tahunan (RM)
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-trending-down text-gray-400'></i>
                                    </div>
                                    <input type="number" 
                                           id="susut_nilai_tahunan" 
                                           name="susut_nilai_tahunan" 
                                           value="{{ old('susut_nilai_tahunan', $asset->susut_nilai_tahunan) }}"
                                           step="0.01"
                                           min="0"
                                           x-model="form.susut_nilai_tahunan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('susut_nilai_tahunan') border-red-500 @enderror bg-white"
                                           placeholder="0.00">
                                </div>
                                @error('susut_nilai_tahunan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Masjid/Surau -->
                            <div>
                                <label for="masjid_surau_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-building mr-1'></i>
                                    Masjid/Surau <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-building text-gray-400'></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class='bx bx-chevron-down text-gray-400'></i>
                                    </div>
                                    <select id="masjid_surau_id" 
                                            name="masjid_surau_id" 
                                            required
                                            x-model="form.masjid_surau_id"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('masjid_surau_id') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Masjid/Surau</option>
                                        @foreach($masjidSuraus as $masjid)
                                            <option value="{{ $masjid->id }}" {{ old('masjid_surau_id', $asset->masjid_surau_id) == $masjid->id ? 'selected' : '' }}>
                                                {{ $masjid->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('masjid_surau_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information Section -->
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-note text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Maklumat Tambahan</h3>
                                <p class="text-sm text-amber-700">Kemaskini gambar dan catatan aset</p>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Asset Images -->
                            <div>
                                <label for="gambar_aset" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-image mr-1'></i>
                                    Gambar Aset
                                </label>
                                <div class="relative">
                                    <input type="file" 
                                           id="gambar_aset" 
                                           name="gambar_aset[]" 
                                           multiple
                                           accept="image/*"
                                           class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('gambar_aset') border-red-500 @enderror bg-white">
                                </div>
                                @if($asset->gambar_aset && count($asset->gambar_aset) > 0)
                                    <div class="mt-3">
                                        <p class="text-sm text-gray-600 mb-2">Gambar sedia ada:</p>
                                        <div class="grid grid-cols-3 gap-3">
                                            @foreach($asset->gambar_aset as $index => $image)
                                            <div class="relative group">
                                                <img src="{{ Storage::url($image) }}" 
                                                     alt="Gambar Aset {{ $index + 1 }}"
                                                     class="w-full h-20 object-cover rounded-lg border border-gray-200">
                                            </div>
                                            @if($index >= 2) @break @endif
                                            @endforeach
                                        </div>
                                        @if(count($asset->gambar_aset) > 3)
                                        <p class="text-xs text-gray-500 mt-2">+{{ count($asset->gambar_aset) - 3 }} gambar lagi</p>
                                        @endif
                                    </div>
                                @endif
                                @error('gambar_aset')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div>
                                <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-note mr-1'></i>
                                    Catatan
                                </label>
                                <textarea id="catatan" 
                                          name="catatan" 
                                          rows="4"
                                          x-model="form.catatan"
                                          class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('catatan') border-red-500 @enderror bg-white"
                                          placeholder="Catatan tambahan tentang aset (pilihan)">{{ old('catatan', $asset->catatan) }}</textarea>
                                @error('catatan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Warranty Notes -->
                            <div>
                                <label for="catatan_jaminan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-shield mr-1'></i>
                                    Catatan Jaminan
                                </label>
                                <textarea id="catatan_jaminan" 
                                          name="catatan_jaminan" 
                                          rows="3"
                                          x-model="form.catatan_jaminan"
                                          class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('catatan_jaminan') border-red-500 @enderror bg-white"
                                          placeholder="Catatan tentang jaminan aset...">{{ old('catatan_jaminan', $asset->catatan_jaminan) }}</textarea>
                                @error('catatan_jaminan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Preview & Info -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        
                        <!-- Current Asset Preview -->
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-100 rounded-xl p-6 border border-indigo-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-package text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Pratonton Aset</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                        <i class='bx bx-package text-emerald-700 text-xl'></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900" x-text="form.nama_aset || '{{ $asset->nama_aset }}'">{{ $asset->nama_aset }}</p>
                                        <p class="text-sm text-gray-500">{{ $asset->no_siri_pendaftaran }}</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Jenis:</span>
                                        <span class="text-sm font-medium" x-text="form.jenis_aset || '{{ $asset->jenis_aset }}'">{{ $asset->jenis_aset }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Kategori:</span>
                                        <span class="text-sm font-medium" x-text="(form.kategori_aset || '{{ $asset->kategori_aset }}') === 'asset' ? 'Asset' : 'Non-Asset'">{{ $asset->kategori_aset === 'asset' ? 'Asset' : 'Non-Asset' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Status:</span>
                                        <span class="text-sm font-medium" x-text="form.status_aset || '{{ $asset->status_aset }}'">{{ $asset->status_aset }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Lokasi:</span>
                                        <span class="text-sm font-medium" x-text="form.lokasi_penempatan || '{{ $asset->lokasi_penempatan }}'">{{ $asset->lokasi_penempatan }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Nilai:</span>
                                        <span class="text-sm font-medium" x-text="'RM ' + (form.nilai_perolehan || '{{ number_format($asset->nilai_perolehan, 2) }}')">RM {{ number_format($asset->nilai_perolehan, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Asset Summary -->
                        <div class="bg-white rounded-xl p-6 border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Aset</h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Status Aset:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $asset->status_aset === 'Sedang Digunakan' ? 'bg-green-100 text-green-800' : ($asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        <div class="w-2 h-2 {{ $asset->status_aset === 'Sedang Digunakan' ? 'bg-green-500' : ($asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-500' : 'bg-red-500') }} rounded-full mr-1"></div>
                                        {{ $asset->status_aset }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Jenis Aset:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $asset->jenis_aset }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Kategori Aset:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        @if($asset->kategori_aset === 'asset') bg-emerald-100 text-emerald-800
                                        @else bg-orange-100 text-orange-800 @endif">
                                        {{ $asset->kategori_aset === 'asset' ? 'Asset' : 'Non-Asset' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Dicipta:</span>
                                    <span class="text-sm font-medium">{{ $asset->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Umur:</span>
                                    <span class="text-sm font-medium">{{ $asset->tarikh_perolehan ? $asset->tarikh_perolehan->diffInYears(now()) : 0 }} tahun</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-6 border border-green-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-cog text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Tindakan Pantas</h3>
                            </div>
                            
                            <div class="space-y-3">
                                <a href="{{ route('admin.assets.show', $asset) }}" 
                                   class="w-full flex items-center justify-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg transition-colors">
                                    <i class='bx bx-show mr-2'></i>
                                    Lihat Detail
                                </a>
                                
                                <button type="button" onclick="window.print()"
                                        class="w-full flex items-center justify-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                                    <i class='bx bx-printer mr-2'></i>
                                    Cetak
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class='bx bx-info-circle mr-1'></i>
                        Kemaskini terakhir: {{ $asset->updated_at->format('d/m/Y H:i') }}
                    </div>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.assets.index') }}" 
                           class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                            <i class='bx bx-x mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-8 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                            <i class='bx bx-save mr-2'></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function editAssetForm() {
        return {
            form: {
                nama_aset: '{{ old('nama_aset', $asset->nama_aset) }}',
                jenis_aset: '{{ old('jenis_aset', $asset->jenis_aset) }}',
                kategori_aset: '{{ old('kategori_aset', $asset->kategori_aset) }}',
                status_aset: '{{ old('status_aset', $asset->status_aset) }}',
                lokasi_penempatan: '{{ old('lokasi_penempatan', $asset->lokasi_penempatan) }}',
                tarikh_perolehan: '{{ old('tarikh_perolehan', $asset->tarikh_perolehan ? $asset->tarikh_perolehan->format('Y-m-d') : '') }}',
                kaedah_perolehan: '{{ old('kaedah_perolehan', $asset->kaedah_perolehan) }}',
                nilai_perolehan: '{{ old('nilai_perolehan', $asset->nilai_perolehan) }}',
                diskaun: '{{ old('diskaun', $asset->diskaun ?? '0.00') }}',
                pegawai_bertanggungjawab_lokasi: '{{ old('pegawai_bertanggungjawab_lokasi', $asset->pegawai_bertanggungjawab_lokasi) }}',
                jawatan_pegawai: '{{ old('jawatan_pegawai', $asset->jawatan_pegawai) }}',
                umur_faedah_tahunan: '{{ old('umur_faedah_tahunan', $asset->umur_faedah_tahunan) }}',
                susut_nilai_tahunan: '{{ old('susut_nilai_tahunan', $asset->susut_nilai_tahunan) }}',
                catatan: '{{ old('catatan', $asset->catatan) }}',
            catatan_jaminan: '{{ old('catatan_jaminan', $asset->catatan_jaminan) }}'
            }
        }
    }

    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const requiredFields = form.querySelectorAll('[required]');
        
        form.addEventListener('submit', function(e) {
            let hasErrors = false;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    hasErrors = true;
                    field.classList.add('border-red-500');
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            if (hasErrors) {
                e.preventDefault();
                alert('Sila lengkapkan semua medan yang diperlukan.');
            }
        });
    });
</script>
@endpush
@endsection 