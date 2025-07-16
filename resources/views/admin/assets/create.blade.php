@extends('layouts.admin')

@section('title', 'Tambah Aset')
@section('page-title', 'Tambah Aset Baru')
@section('page-description', 'Cipta aset baru dalam sistem')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Tambah Aset Baru</h1>
                <p class="text-emerald-100 text-lg">Cipta aset baharu dalam sistem</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-plus text-emerald-200'></i>
                        <span class="text-emerald-100">Daftar Aset</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-shield-check text-emerald-200'></i>
                        <span class="text-emerald-100">Sistem Selamat</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-plus text-6xl text-emerald-200'></i>
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
        <span class="text-emerald-600 font-medium">Tambah Aset</span>
    </div>



    <!-- Progress Steps -->
    <div class="mb-8">
        <div class="flex items-center justify-center">
            <div class="flex items-center space-x-4">
                <!-- Step 1 -->
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-semibold">
                        1
                    </div>
                    <span class="ml-2 text-sm font-medium text-emerald-600">Maklumat Asas</span>
                </div>
                <div class="w-16 h-1 bg-gray-200 rounded"></div>
                
                <!-- Step 2 -->
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">
                        2
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-500">Nilai & Kewangan</span>
                </div>
                <div class="w-16 h-1 bg-gray-200 rounded"></div>
                
                <!-- Step 3 -->
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">
                        3
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-500">Semak & Simpan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card - Full Width -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <form action="{{ route('admin.assets.store') }}" method="POST" enctype="multipart/form-data" x-data="assetForm()" class="space-y-0">
            @csrf

            <!-- Form Header -->
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Cipta Aset Baru</h2>
                        <p class="text-sm text-gray-600">Isikan semua maklumat yang diperlukan untuk mencipta aset</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-sm text-gray-600">Sistem Online</span>
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
                                <p class="text-sm text-emerald-700">Maklumat asas dan identifikasi aset</p>
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
                                           value="{{ old('nama_aset') }}"
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
                                        <option value="Elektronik" {{ old('jenis_aset') === 'Elektronik' ? 'selected' : '' }}>Elektronik</option>
                                        <option value="Perabot" {{ old('jenis_aset') === 'Perabot' ? 'selected' : '' }}>Perabot</option>
                                        <option value="Kenderaan" {{ old('jenis_aset') === 'Kenderaan' ? 'selected' : '' }}>Kenderaan</option>
                                        <option value="Lain-lain" {{ old('jenis_aset') === 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
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
                                        <option value="asset" {{ old('kategori_aset') === 'asset' ? 'selected' : '' }}>Asset</option>
                                        <option value="non-asset" {{ old('kategori_aset') === 'non-asset' ? 'selected' : '' }}>Non-Asset</option>
                                    </select>
                                </div>
                                @error('kategori_aset')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Serial Number (Auto-generated) -->
                            <div class="md:col-span-2">
                                <label for="no_siri_pendaftaran" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-barcode mr-1'></i>
                                    No. Siri Pendaftaran <span class="text-gray-500">(Auto-generated)</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-barcode text-gray-400'></i>
                                    </div>
                                    <input type="text" 
                                           id="no_siri_pendaftaran" 
                                           name="no_siri_pendaftaran" 
                                           value="{{ old('no_siri_pendaftaran') }}"
                                           readonly
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-600"
                                           placeholder="Akan dijana secara automatik">
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
                                        <option value="Sedang Digunakan" {{ old('status_aset') === 'Sedang Digunakan' ? 'selected' : '' }}>Sedang Digunakan</option>
                                        <option value="Dalam Penyelenggaraan" {{ old('status_aset') === 'Dalam Penyelenggaraan' ? 'selected' : '' }}>Dalam Penyelenggaraan</option>
                                        <option value="Rosak" {{ old('status_aset') === 'Rosak' ? 'selected' : '' }}>Rosak</option>
                                    </select>
                                </div>
                                @error('status_aset')
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
                                    <input type="text" 
                                           id="lokasi_penempatan" 
                                           name="lokasi_penempatan" 
                                           value="{{ old('lokasi_penempatan') }}"
                                           required
                                           x-model="form.lokasi_penempatan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('lokasi_penempatan') border-red-500 @enderror bg-white"
                                           placeholder="Cth: Ruang Utama, Pejabat">
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
                                <p class="text-sm text-purple-700">Butiran cara dan masa perolehan aset</p>
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
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-calendar text-gray-400'></i>
                                    </div>
                                    <input type="date" 
                                           id="tarikh_perolehan" 
                                           name="tarikh_perolehan" 
                                           value="{{ old('tarikh_perolehan') }}"
                                           required
                                           x-model="form.tarikh_perolehan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_perolehan') border-red-500 @enderror bg-white">
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
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-transfer text-gray-400'></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class='bx bx-chevron-down text-gray-400'></i>
                                    </div>
                                    <select id="kaedah_perolehan" 
                                            name="kaedah_perolehan" 
                                            required
                                            x-model="form.kaedah_perolehan"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kaedah_perolehan') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Kaedah</option>
                                        <option value="Pembelian" {{ old('kaedah_perolehan') === 'Pembelian' ? 'selected' : '' }}>Pembelian</option>
                                        <option value="Sumbangan" {{ old('kaedah_perolehan') === 'Sumbangan' ? 'selected' : '' }}>Sumbangan</option>
                                        <option value="Hibah" {{ old('kaedah_perolehan') === 'Hibah' ? 'selected' : '' }}>Hibah</option>
                                        <option value="Lain-lain" {{ old('kaedah_perolehan') === 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                                    </select>
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
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-dollar text-gray-400'></i>
                                    </div>
                                    <input type="number" 
                                           id="nilai_perolehan" 
                                           name="nilai_perolehan" 
                                           value="{{ old('nilai_perolehan') }}"
                                           required
                                           step="0.01"
                                           min="0"
                                           x-model="form.nilai_perolehan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nilai_perolehan') border-red-500 @enderror bg-white"
                                           placeholder="0.00">
                                </div>
                                @error('nilai_perolehan')
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
                                    Pegawai Bertanggungjawab
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-user text-gray-400'></i>
                                    </div>
                                    <input type="text" 
                                           id="pegawai_bertanggungjawab_lokasi" 
                                           name="pegawai_bertanggungjawab_lokasi" 
                                           value="{{ old('pegawai_bertanggungjawab_lokasi') }}"
                                           x-model="form.pegawai_bertanggungjawab_lokasi"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('pegawai_bertanggungjawab_lokasi') border-red-500 @enderror bg-white"
                                           placeholder="Nama pegawai">
                                </div>
                                @error('pegawai_bertanggungjawab_lokasi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Financial Information Section -->
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-trending-down text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Maklumat Kewangan</h3>
                                <p class="text-sm text-amber-700">Susut nilai dan umur faedah aset</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Useful Life -->
                            <div>
                                <label for="umur_faedah_tahunan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-time mr-1'></i>
                                    Umur Faedah (Tahun)
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-time text-gray-400'></i>
                                    </div>
                                    <input type="number" 
                                           id="umur_faedah_tahunan" 
                                           name="umur_faedah_tahunan" 
                                           value="{{ old('umur_faedah_tahunan') }}"
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
                                           value="{{ old('susut_nilai_tahunan') }}"
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
                        </div>
                    </div>

                    <!-- Organization Assignment Section -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-building text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Organisasi</h3>
                                <p class="text-sm text-blue-700">Maklumat organisasi dan penempatan</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-6">
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
                                            <option value="{{ $masjid->id }}" {{ old('masjid_surau_id') == $masjid->id ? 'selected' : '' }}>
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
                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-note text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Maklumat Tambahan</h3>
                                <p class="text-sm text-green-700">Catatan dan gambar aset</p>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
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
                                          placeholder="Catatan tambahan tentang aset ini...">{{ old('catatan') }}</textarea>
                                @error('catatan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Asset Images -->
                            <div>
                                <label for="gambar_aset" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-image mr-1'></i>
                                    Gambar Aset
                                </label>
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-emerald-400 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <i class='bx bx-image text-4xl text-gray-400 mb-4'></i>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="gambar_aset" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                                <span>Upload gambar</span>
                                                <input id="gambar_aset" name="gambar_aset[]" type="file" class="sr-only" multiple accept="image/*">
                                            </label>
                                            <p class="pl-1">atau drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF hingga 10MB</p>
                                    </div>
                                </div>
                                @error('gambar_aset')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Summary & Actions -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Form Summary -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                                <i class='bx bx-check-circle text-white text-sm'></i>
                            </div>
                            <h3 class="font-semibold text-gray-900">Ringkasan Aset</h3>
                        </div>
                        
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nama Aset:</span>
                                <span class="font-medium text-gray-900" x-text="form.nama_aset || '-'"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Jenis:</span>
                                <span class="font-medium text-gray-900" x-text="form.jenis_aset || '-'"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Kategori:</span>
                                <span class="font-medium text-gray-900" x-text="form.kategori_aset === 'asset' ? 'Asset' : (form.kategori_aset === 'non-asset' ? 'Non-Asset' : '-')"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-medium text-gray-900" x-text="form.status_aset || '-'"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Lokasi:</span>
                                <span class="font-medium text-gray-900" x-text="form.lokasi_penempatan || '-'"></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Nilai:</span>
                                <span class="font-medium text-gray-900" x-text="form.nilai_perolehan ? 'RM ' + parseFloat(form.nilai_perolehan).toFixed(2) : '-'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                        <h3 class="font-semibold text-gray-900 mb-4">Tindakan</h3>
                        <div class="space-y-3">
                            <button type="submit" 
                                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center">
                                <i class='bx bx-save mr-2'></i>
                                Simpan Aset
                            </button>
                            <a href="{{ route('admin.assets.index') }}" 
                               class="w-full bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center">
                                <i class='bx bx-x mr-2'></i>
                                Batal
                            </a>
                        </div>
                    </div>

                    <!-- Help & Tips -->
                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                        <div class="flex items-start">
                            <i class='bx bx-info-circle text-blue-600 text-lg mr-3 mt-0.5'></i>
                            <div>
                                <h4 class="font-medium text-blue-900 mb-2">Tips Pengisian</h4>
                                <ul class="text-sm text-blue-800 space-y-1">
                                    <li>• Pastikan nama aset jelas dan spesifik</li>
                                    <li>• Nilai perolehan dalam Ringgit Malaysia</li>
                                    <li>• Upload gambar untuk dokumentasi</li>
                                    <li>• Susut nilai dikira automatik</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function assetForm() {
    return {
        form: {
            nama_aset: '',
            jenis_aset: '',
            kategori_aset: '',
            status_aset: '',
            lokasi_penempatan: '',
            nilai_perolehan: '',
            tarikh_perolehan: '',
            kaedah_perolehan: '',
            pegawai_bertanggungjawab_lokasi: '',
            umur_faedah_tahunan: '',
            susut_nilai_tahunan: '',
            masjid_surau_id: '',
            catatan: ''
        }
    }
}
</script>
@endsection 