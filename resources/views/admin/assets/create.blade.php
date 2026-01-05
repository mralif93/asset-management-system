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
                        <div
                            class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-semibold">
                            1
                        </div>
                        <span class="ml-2 text-sm font-medium text-emerald-600">Maklumat Asas</span>
                    </div>
                    <div class="w-16 h-1 bg-gray-200 rounded"></div>

                    <!-- Step 2 -->
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">
                            2
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500">Nilai & Kewangan</span>
                    </div>
                    <div class="w-16 h-1 bg-gray-200 rounded"></div>

                    <!-- Step 3 -->
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">
                            3
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500">Semak & Simpan</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Card - Full Width -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <form action="{{ route('admin.assets.store') }}" method="POST" enctype="multipart/form-data"
                x-data="assetForm()" class="space-y-0">
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
                        <div
                            class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <i class='bx bx-package text-white text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Maklumat Asas Aset</h3>
                                    <p class="text-sm text-emerald-700">Maklumat asas dan identifikasi aset</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 mb-6">
                                <!-- Asset Name - Full Width -->
                                <div>
                                    <label for="nama_aset" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-package mr-1'></i>
                                        Nama Aset <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-package text-gray-400'></i>
                                        </div>
                                        <input type="text" id="nama_aset" name="nama_aset" value="{{ old('nama_aset') }}"
                                            required x-model="form.nama_aset"
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
                            </div>

                            <!-- Quantity Field -->
                            <div class="grid grid-cols-1 gap-6 mb-6">
                                <div>
                                    <label for="kuantiti" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-package mr-1'></i>
                                        Kuantiti (Quantity) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-package text-gray-400'></i>
                                        </div>
                                        <input type="number" id="kuantiti" name="kuantiti" value="{{ old('kuantiti', 1) }}"
                                            required min="1" x-model="form.kuantiti"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kuantiti') border-red-500 @enderror bg-white"
                                            placeholder="1">
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500">Masukkan bilangan unit aset (default: 1)</p>
                                    @error('kuantiti')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Asset Type and Category Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                        <select id="jenis_aset" name="jenis_aset" required x-model="form.jenis_aset"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jenis_aset') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">-- Pilih --</option>
                                            @foreach($assetTypes as $type)
                                                <option value="{{ $type }}" {{ old('jenis_aset') === $type ? 'selected' : '' }}>
                                                    {{ $type }}
                                                </option>
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
                                        <select id="kategori_aset" name="kategori_aset" required
                                            x-model="form.kategori_aset"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kategori_aset') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">-- Pilih --</option>
                                            <option value="asset" {{ old('kategori_aset') === 'asset' ? 'selected' : '' }}>
                                                Asset</option>
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
                                        <input type="text" id="no_siri_pendaftaran" name="no_siri_pendaftaran"
                                            value="{{ old('no_siri_pendaftaran') }}" readonly
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
                                        <select id="status_aset" name="status_aset" required x-model="form.status_aset"
                                            @change="updateWarrantyStatus($event.target.value)"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('status_aset') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">-- Pilih --</option>
                                            <option value="Baru" {{ old('status_aset') === 'Baru' ? 'selected' : '' }}>Baru
                                            </option>
                                            <option value="Sedang Digunakan" {{ old('status_aset') === 'Sedang Digunakan' ? 'selected' : '' }}>Sedang Digunakan</option>
                                            <option value="Dalam Penyelenggaraan" {{ old('status_aset') === 'Dalam Penyelenggaraan' ? 'selected' : '' }}>Dalam Penyelenggaraan</option>
                                            <option value="Rosak" {{ old('status_aset') === 'Rosak' ? 'selected' : '' }}>Rosak
                                            </option>
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
                                        <select id="keadaan_fizikal" name="keadaan_fizikal" required
                                            x-model="form.keadaan_fizikal"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('keadaan_fizikal') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">-- Pilih --</option>
                                            <option value="Cemerlang" {{ old('keadaan_fizikal') === 'Cemerlang' ? 'selected' : '' }}>Cemerlang</option>
                                            <option value="Baik" {{ old('keadaan_fizikal') === 'Baik' ? 'selected' : '' }}>
                                                Baik</option>
                                            <option value="Sederhana" {{ old('keadaan_fizikal') === 'Sederhana' ? 'selected' : '' }}>Sederhana</option>
                                            <option value="Rosak" {{ old('keadaan_fizikal') === 'Rosak' ? 'selected' : '' }}>
                                                Rosak</option>
                                            <option value="Tidak Boleh Digunakan" {{ old('keadaan_fizikal') === 'Tidak Boleh Digunakan' ? 'selected' : '' }}>Tidak Boleh Digunakan</option>
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
                                        <i class='bx bx-shield mr-1'></i>
                                        Status Jaminan (Warranty)<span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-shield text-gray-400'></i>
                                        </div>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class='bx bx-chevron-down text-gray-400'></i>
                                        </div>
                                        <select id="status_jaminan" name="status_jaminan" required
                                            x-model="form.status_jaminan"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('status_jaminan') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">-- Pilih --</option>
                                            <option value="Aktif" {{ old('status_jaminan') === 'Aktif' ? 'selected' : '' }}>
                                                Aktif</option>
                                            <option value="Tamat" {{ old('status_jaminan') === 'Tamat' ? 'selected' : '' }}>
                                                Tamat</option>
                                            <option value="Tiada Jaminan" {{ old('status_jaminan') === 'Tiada Jaminan' ? 'selected' : '' }}>Tiada Jaminan</option>
                                        </select>
                                    </div>
                                    @error('status_jaminan')
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
                                        <select id="lokasi_penempatan" name="lokasi_penempatan" required
                                            x-model="form.lokasi_penempatan"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('lokasi_penempatan') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">-- Pilih --</option>
                                            <option value="Anjung kiri" {{ old('lokasi_penempatan') === 'Anjung kiri' ? 'selected' : '' }}>Anjung kiri</option>
                                            <option value="Anjung kanan" {{ old('lokasi_penempatan') === 'Anjung kanan' ? 'selected' : '' }}>Anjung kanan</option>
                                            <option value="Anjung Depan(Ruang Pengantin)" {{ old('lokasi_penempatan') === 'Anjung Depan(Ruang Pengantin)' ? 'selected' : '' }}>Anjung Depan(Ruang Pengantin)</option>
                                            <option value="Ruang Utama (tingkat atas, tingkat bawah)" {{ old('lokasi_penempatan') === 'Ruang Utama (tingkat atas, tingkat bawah)' ? 'selected' : '' }}>Ruang Utama (tingkat atas, tingkat bawah)</option>
                                            <option value="Bilik Mesyuarat" {{ old('lokasi_penempatan') === 'Bilik Mesyuarat' ? 'selected' : '' }}>Bilik Mesyuarat</option>
                                            <option value="Bilik Kuliah" {{ old('lokasi_penempatan') === 'Bilik Kuliah' ? 'selected' : '' }}>Bilik Kuliah</option>
                                            <option value="Bilik Bendahari" {{ old('lokasi_penempatan') === 'Bilik Bendahari' ? 'selected' : '' }}>Bilik Bendahari</option>
                                            <option value="Bilik Setiausaha" {{ old('lokasi_penempatan') === 'Bilik Setiausaha' ? 'selected' : '' }}>Bilik Setiausaha</option>
                                            <option value="Bilik Nazir & Imam" {{ old('lokasi_penempatan') === 'Bilik Nazir & Imam' ? 'selected' : '' }}>Bilik Nazir & Imam</option>
                                            <option value="Bangunan Jenazah" {{ old('lokasi_penempatan') === 'Bangunan Jenazah' ? 'selected' : '' }}>Bangunan Jenazah</option>
                                            <option value="Lain-lain" {{ old('lokasi_penempatan') === 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                                        </select>
                                    </div>
                                    @error('lokasi_penempatan')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Last Inspection Date -->
                                <div>
                                    <label for="tarikh_pemeriksaan_terakhir"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-calendar-check mr-1'></i>
                                        Tarikh Pemeriksaan Terakhir
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-calendar-check text-gray-400'></i>
                                        </div>
                                        <input type="date" id="tarikh_pemeriksaan_terakhir"
                                            name="tarikh_pemeriksaan_terakhir"
                                            value="{{ old('tarikh_pemeriksaan_terakhir') }}"
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
                                    <label for="tarikh_penyelenggaraan_akan_datang"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-calendar-plus mr-1'></i>
                                        Tarikh Penyelenggaraan Akan Datang
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-calendar-plus text-gray-400'></i>
                                        </div>
                                        <input type="date" id="tarikh_penyelenggaraan_akan_datang"
                                            name="tarikh_penyelenggaraan_akan_datang"
                                            value="{{ old('tarikh_penyelenggaraan_akan_datang') }}"
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
                            </div>
                        </div>

                        <!-- Organization Assignment Section -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
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
                                        <select id="masjid_surau_id" name="masjid_surau_id" required
                                            x-model="form.masjid_surau_id"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('masjid_surau_id') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">-- Pilih --</option>
                                            @foreach($masjidSuraus as $masjid)
                                                <option value="{{ $masjid->id }}" {{ old('masjid_surau_id', $default_masjid_surau_id ?? '') == $masjid->id ? 'selected' : '' }}>
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

                        <!-- Acquisition Information Section -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
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
                                        <input type="date" id="tarikh_perolehan" name="tarikh_perolehan"
                                            value="{{ old('tarikh_perolehan') }}" required x-model="form.tarikh_perolehan"
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
                                        <select id="kaedah_perolehan" name="kaedah_perolehan" required
                                            x-model="form.kaedah_perolehan"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kaedah_perolehan') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">-- Pilih --</option>
                                            <option value="Pembelian" {{ old('kaedah_perolehan') === 'Pembelian' ? 'selected' : '' }}>Pembelian</option>
                                            <option value="Sumbangan" {{ old('kaedah_perolehan') === 'Sumbangan' ? 'selected' : '' }}>Sumbangan</option>
                                            <option value="Hibah" {{ old('kaedah_perolehan') === 'Hibah' ? 'selected' : '' }}>
                                                Hibah</option>
                                            <option value="Infaq" {{ old('kaedah_perolehan') === 'Infaq' ? 'selected' : '' }}>
                                                Infaq</option>
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

                                <!-- Pembekal / Vendor -->
                                <div class="md:col-span-2">
                                    <label for="pembekal" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-store mr-1'></i>
                                        Pembekal / Vendor <span class="text-gray-500 text-xs">(Jika ada)</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-store text-gray-400'></i>
                                        </div>
                                        <input type="text" id="pembekal" name="pembekal" value="{{ old('pembekal') }}"
                                            x-model="form.pembekal"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('pembekal') border-red-500 @enderror bg-white"
                                            placeholder="Nama pembekal atau vendor">
                                    </div>
                                    @error('pembekal')
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
                                        <input type="text" id="nilai_perolehan_display"
                                            value="{{ old('nilai_perolehan') ? number_format(old('nilai_perolehan'), 2) : '' }}"
                                            required @input="formatPriceInput($event, 'nilai_perolehan')"
                                            @blur="formatPriceBlur($event, 'nilai_perolehan')"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nilai_perolehan') border-red-500 @enderror bg-white"
                                            placeholder="0.00">
                                        <input type="hidden" id="nilai_perolehan" name="nilai_perolehan"
                                            x-model="form.nilai_perolehan">
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
                                        <input type="text" id="diskaun_display"
                                            value="{{ old('diskaun') ? number_format(old('diskaun'), 2) : '0.00' }}"
                                            @input="formatPriceInput($event, 'diskaun')"
                                            @blur="formatPriceBlur($event, 'diskaun')"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('diskaun') border-red-500 @enderror bg-white"
                                            placeholder="0.00">
                                        <input type="hidden" id="diskaun" name="diskaun" x-model="form.diskaun">
                                    </div>
                                    @error('diskaun')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Receipt Number -->
                                <div>
                                    <label for="no_resit" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-receipt mr-1'></i>
                                        No. Resit
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-receipt text-gray-400'></i>
                                        </div>
                                        <input type="text" id="no_resit" name="no_resit" value="{{ old('no_resit') }}"
                                            x-model="form.no_resit"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('no_resit') border-red-500 @enderror bg-white"
                                            placeholder="Masukkan no. resit">
                                    </div>
                                    @error('no_resit')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Receipt Date -->
                                <div>
                                    <label for="tarikh_resit" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-calendar mr-1'></i>
                                        Tarikh Resit
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-calendar text-gray-400'></i>
                                        </div>
                                        <input type="date" id="tarikh_resit" name="tarikh_resit"
                                            value="{{ old('tarikh_resit') }}" x-model="form.tarikh_resit"
                                            @change="setInspectionDate($event.target.value)"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_resit') border-red-500 @enderror bg-white">
                                    </div>
                                    @error('tarikh_resit')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Responsible Officer -->
                                <div>
                                    <label for="pegawai_bertanggungjawab_lokasi"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-user mr-1'></i>
                                        Pegawai Bertanggungjawab
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-user text-gray-400'></i>
                                        </div>
                                        <input type="text" id="pegawai_bertanggungjawab_lokasi"
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
                                        <input type="text" id="jawatan_pegawai" name="jawatan_pegawai"
                                            value="{{ old('jawatan_pegawai') }}" x-model="form.jawatan_pegawai"
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
                        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <i class='bx bx-trending-down text-white text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Maklumat Kewangan</h3>
                                    <p class="text-sm text-amber-700">Susut nilai dan umur faedah aset (only for assets)</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Useful Life -->
                                <div>
                                    <label for="umur_faedah_tahunan" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-time mr-1'></i>
                                        Tempoh Hayat (Tahun)
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-time text-gray-400'></i>
                                        </div>
                                        <input type="number" id="umur_faedah_tahunan" name="umur_faedah_tahunan"
                                            value="{{ old('umur_faedah_tahunan') }}" min="1"
                                            x-model="form.umur_faedah_tahunan" @input="calculateAnnualDepreciation()"
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
                                        <span class="text-gray-500 text-xs ml-1">(akan dikira automatik jika kosong)</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-trending-down text-gray-400'></i>
                                        </div>
                                        <input type="text" id="susut_nilai_tahunan_display"
                                            value="{{ old('susut_nilai_tahunan') ? number_format(old('susut_nilai_tahunan'), 2) : '' }}"
                                            @input="formatPriceInput($event, 'susut_nilai_tahunan')"
                                            @blur="formatPriceBlur($event, 'susut_nilai_tahunan')"
                                            class="w-full pl-10 pr-20 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('susut_nilai_tahunan') border-red-500 @enderror bg-white"
                                            placeholder="Auto-calculate">
                                        <input type="hidden" id="susut_nilai_tahunan" name="susut_nilai_tahunan"
                                            x-model="form.susut_nilai_tahunan">
                                        <button type="button" @click="calculateAnnualDepreciation(true)"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-emerald-600 hover:text-emerald-700"
                                            title="Kira semula (Paksa Kemaskini)">
                                            <i class='bx bx-calculator text-lg'></i>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-emerald-600" x-show="calculatedDepreciation"
                                        x-text="'Dikira: RM ' + parseFloat(calculatedDepreciation || 0).toFixed(2) + ' (Straight-Line Method)'">
                                    </p>
                                    <p class="mt-1 text-xs text-gray-500">
                                        <i class='bx bx-info-circle mr-1 align-middle'></i>
                                        Klik ikon kalkulator untuk memaksa pengiraan semula (override manual input).
                                    </p>
                                    @error('susut_nilai_tahunan')
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
                                <div
                                    class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
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
                                    <textarea id="catatan" name="catatan" rows="4" x-model="form.catatan"
                                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('catatan') border-red-500 @enderror bg-white"
                                        placeholder="Catatan tambahan tentang aset ini...">{{ old('catatan') }}</textarea>
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
                                    <textarea id="catatan_jaminan" name="catatan_jaminan" rows="3"
                                        x-model="form.catatan_jaminan"
                                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('catatan_jaminan') border-red-500 @enderror bg-white"
                                        placeholder="Catatan tentang jaminan aset...">{{ old('catatan_jaminan') }}</textarea>
                                    @error('catatan_jaminan')
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
                                        Gambar Aset (Opsional)
                                    </label>
                                    <div class="mt-1 flex justify-center px-8 pt-8 pb-8 border-2 border-dashed border-gray-300 rounded-xl hover:border-emerald-400 transition-all duration-300 bg-gradient-to-br from-gray-50 to-emerald-50 hover:from-emerald-50 hover:to-emerald-100 group cursor-pointer"
                                        id="dropZone">
                                        <div class="space-y-4 text-center">
                                            <div class="relative">
                                                <i
                                                    class='bx bx-cloud-upload text-5xl text-gray-400 mb-4 group-hover:text-emerald-500 transition-all duration-300 transform group-hover:scale-110'></i>
                                                <div
                                                    class="absolute -top-2 -right-2 w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-300 transform group-hover:scale-110">
                                                    <i class='bx bx-plus text-white text-lg'></i>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <div
                                                    class="flex text-sm text-gray-600 group-hover:text-emerald-700 transition-colors duration-300 justify-center items-center">
                                                    <label for="gambar_aset"
                                                        class="relative cursor-pointer bg-white rounded-lg px-4 py-2 font-medium text-emerald-600 hover:text-emerald-500 hover:bg-emerald-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500 transition-all duration-200 shadow-sm hover:shadow-md">
                                                        <span class="flex items-center">
                                                            <i class='bx bx-upload mr-2'></i>
                                                            Upload gambar
                                                        </span>
                                                        <input id="gambar_aset" name="gambar_aset[]" type="file"
                                                            class="sr-only" multiple accept="image/*">
                                                    </label>
                                                    <p class="pl-3 text-gray-500 group-hover:text-emerald-600">atau drag and
                                                        drop di sini</p>
                                                </div>
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-xs text-gray-500 flex items-center justify-center">
                                                    <i class='bx bx-file-blank mr-1'></i>
                                                    PNG, JPG, GIF hingga 2MB setiap gambar
                                                </p>
                                                <p
                                                    class="text-xs text-emerald-600 font-medium flex items-center justify-center">
                                                    <i class='bx bx-check-circle mr-1'></i>
                                                    Maksimum 5 gambar
                                                </p>
                                                <p class="text-xs text-blue-600 flex items-center justify-center">
                                                    <i class='bx bx-info-circle mr-1'></i>
                                                    Anda boleh menambah gambar lagi kemudian
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Image Preview Area -->
                                    <div id="imagePreview"
                                        class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 hidden">
                                        <!-- Preview images will be inserted here -->
                                    </div>

                                    <!-- Image Modal -->
                                    <div id="imageModal"
                                        class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
                                        <div
                                            class="relative max-w-6xl max-h-full bg-white rounded-xl shadow-2xl overflow-hidden">
                                            <button id="closeModal"
                                                class="absolute top-4 right-4 z-10 w-10 h-10 bg-black bg-opacity-50 text-white rounded-full flex items-center justify-center hover:bg-opacity-75 transition-all duration-200">
                                                <i class='bx bx-x text-2xl'></i>
                                            </button>
                                            <div class="p-4">
                                                <img id="modalImage" src="" alt="Full size image"
                                                    class="max-w-full max-h-[80vh] object-contain mx-auto">
                                            </div>
                                            <div
                                                class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-50 text-white px-4 py-2 rounded-lg">
                                                <p id="modalImageName" class="text-sm font-medium"></p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Upload Progress -->
                                    <div id="uploadProgress" class="mt-4 hidden">
                                        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4">
                                            <div class="flex items-center">
                                                <div
                                                    class="animate-spin rounded-full h-5 w-5 border-b-2 border-emerald-600 mr-3">
                                                </div>
                                                <span class="text-sm text-emerald-700 font-medium">Memproses
                                                    gambar...</span>
                                            </div>
                                            <div class="mt-2 bg-emerald-200 rounded-full h-2">
                                                <div id="progressBar"
                                                    class="bg-emerald-600 h-2 rounded-full transition-all duration-300"
                                                    style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>

                                    @error('gambar_aset')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    @error('gambar_aset.*')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror

                                    <!-- Helpful Info -->
                                    <div
                                        class="mt-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl shadow-sm">
                                        <div class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <i class='bx bx-bulb text-blue-600 text-lg'></i>
                                                </div>
                                            </div>
                                            <div class="ml-3 text-sm">
                                                <p class="font-semibold text-blue-800 mb-1">💡 Tip Berguna:</p>
                                                <p class="text-blue-700 leading-relaxed">Anda boleh upload 1 gambar sekarang
                                                    dan menambah gambar lagi kemudian melalui halaman edit aset. Ini
                                                    memberikan fleksibiliti untuk melengkapkan maklumat aset secara
                                                    berperingkat.</p>
                                            </div>
                                        </div>
                                    </div>
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
                                    <span class="font-medium text-gray-900"
                                        x-text="form.kategori_aset === 'asset' ? 'Asset' : (form.kategori_aset === 'non-asset' ? 'Non-Asset' : '-')"></span>
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
                                    <span class="font-medium text-gray-900"
                                        x-text="form.nilai_perolehan ? 'RM ' + parseFloat(form.nilai_perolehan).toFixed(2) : '-'"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Diskaun:</span>
                                    <span class="font-medium text-gray-900"
                                        x-text="form.diskaun ? 'RM ' + parseFloat(form.diskaun).toFixed(2) : 'RM 0.00'"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Pegawai:</span>
                                    <span class="font-medium text-gray-900"
                                        x-text="form.pegawai_bertanggungjawab_lokasi || '-'"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jawatan:</span>
                                    <span class="font-medium text-gray-900" x-text="form.jawatan_pegawai || '-'"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Keadaan:</span>
                                    <span class="font-medium text-gray-900" x-text="form.keadaan_fizikal || '-'"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jaminan:</span>
                                    <span class="font-medium text-gray-900" x-text="form.status_jaminan || '-'"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tarikh Perolehan:</span>
                                    <span class="font-medium text-gray-900"
                                        x-text="formatDate(form.tarikh_perolehan)"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Kaedah Perolehan:</span>
                                    <span class="font-medium text-gray-900" x-text="form.kaedah_perolehan || '-'"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">No. Resit:</span>
                                    <span class="font-medium text-gray-900" x-text="form.no_resit || '-'"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tarikh Resit:</span>
                                    <span class="font-medium text-gray-900" x-text="formatDate(form.tarikh_resit)"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Umur Faedah:</span>
                                    <span class="font-medium text-gray-900"
                                        x-text="form.umur_faedah_tahunan ? form.umur_faedah_tahunan + ' tahun' : '-'"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Susut Nilai:</span>
                                    <span class="font-medium text-gray-900"
                                        x-text="form.susut_nilai_tahunan ? 'RM ' + parseFloat(form.susut_nilai_tahunan).toFixed(2) + '/tahun' : '-'"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Masjid/Surau:</span>
                                    <span class="font-medium text-gray-900"
                                        x-text="getMasjidName(form.masjid_surau_id)"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Pemeriksaan Terakhir:</span>
                                    <span class="font-medium text-gray-900"
                                        x-text="formatDate(form.tarikh_pemeriksaan_terakhir)"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Penyelenggaraan Akan Datang:</span>
                                    <span class="font-medium text-gray-900"
                                        x-text="formatDate(form.tarikh_penyelenggaraan_akan_datang)"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Catatan:</span>
                                    <span class="font-medium text-gray-900" x-text="form.catatan || '-'"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Catatan Jaminan:</span>
                                    <span class="font-medium text-gray-900" x-text="form.catatan_jaminan || '-'"></span>
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

    @push('scripts')
        <style>
            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @keyframes slideIn {
                from {
                    opacity: 0;
                    transform: translateX(-20px);
                }

                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes pulse {

                0%,
                100% {
                    transform: scale(1);
                }

                50% {
                    transform: scale(1.05);
                }
            }

            .animate-fadeIn {
                animation: fadeIn 0.5s ease-out;
            }

            .animate-slideIn {
                animation: slideIn 0.3s ease-out;
            }

            .animate-pulse-slow {
                animation: pulse 2s infinite;
            }

            /* Enhanced hover effects */
            .group:hover .group-hover\:animate-pulse {
                animation: pulse 1s infinite;
            }

            /* Custom scrollbar for image preview */
            #imagePreview::-webkit-scrollbar {
                width: 6px;
            }

            #imagePreview::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 3px;
            }

            #imagePreview::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 3px;
            }

            #imagePreview::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }
        </style>
        <script>
            function assetForm() {
                // Depreciation Schedule Data
                const depreciationSchedule = {
                    "country_context": "Malaysia",
                    "standard": "LHDN Capital Allowance & Common Accounting Practice",
                    "categories": [
                        { "category": "ICT & Software", "estimated_useful_life_years": 4 },
                        { "category": "Motor Vehicles", "estimated_useful_life_years": 5 },
                        { "category": "Office Equipment", "estimated_useful_life_years": 10 },
                        { "category": "Furniture & Fittings", "estimated_useful_life_years": 10 },
                        { "category": "General Plant & Machinery", "estimated_useful_life_years": 7 },
                        { "category": "Heavy Machinery", "estimated_useful_life_years": 5 },
                        { "category": "Industrial Buildings", "estimated_useful_life_years": 33 }
                    ]
                };

                const categoryMapping = {
                    'Elektronik': 'ICT & Software',
                    'Elektrikal': 'ICT & Software',
                    'Kenderaan': 'Motor Vehicles',
                    'Peralatan Pejabat': 'Office Equipment',
                    'Peralatan Pejabat - Alat tulis': 'Office Equipment',
                    'Perabot': 'Furniture & Fittings',
                    'Peralatan': 'General Plant & Machinery',
                    'Jentera': 'Heavy Machinery',
                    'Harta Tak Alih': 'Industrial Buildings'
                };

                return {
                    form: {
                        nama_aset: '{{ old("nama_aset") }}',
                        jenis_aset: '{{ old("jenis_aset") }}',
                        kategori_aset: '{{ old("kategori_aset") }}',
                        status_aset: '{{ old("status_aset") }}',
                        keadaan_fizikal: '{{ old("keadaan_fizikal") }}',
                        status_jaminan: '{{ old("status_jaminan") }}',
                        lokasi_penempatan: '{{ old("lokasi_penempatan") }}',
                        tarikh_pemeriksaan_terakhir: '{{ old("tarikh_pemeriksaan_terakhir") }}',
                        tarikh_penyelenggaraan_akan_datang: '{{ old("tarikh_penyelenggaraan_akan_datang") }}',
                        masjid_surau_id: '{{ old("masjid_surau_id", $default_masjid_surau_id) }}',
                        tarikh_perolehan: '{{ old("tarikh_perolehan") }}',
                        kaedah_perolehan: '{{ old("kaedah_perolehan") }}',
                        pembekal: '{{ old("pembekal") }}',
                        nilai_perolehan: '{{ old("nilai_perolehan") }}',
                        diskaun: '{{ old("diskaun", "0.00") }}',
                        no_resit: '{{ old("no_resit") }}',
                        tarikh_resit: '{{ old("tarikh_resit") }}',
                        pegawai_bertanggungjawab_lokasi: '{{ old("pegawai_bertanggungjawab_lokasi") }}',
                        jawatan_pegawai: '{{ old("jawatan_pegawai") }}',
                        umur_faedah_tahunan: '{{ old("umur_faedah_tahunan") }}',
                        susut_nilai_tahunan: '{{ old("susut_nilai_tahunan") }}',
                        catatan: '{{ old("catatan") }}',
                        catatan_jaminan: '{{ old("catatan_jaminan") }}'
                    },
                    calculatedDepreciation: null,

                    init() {
                        this.$watch('form.jenis_aset', (value) => {
                            this.updateDepreciationFromCategory(value);
                        });
                    },

                    updateDepreciationFromCategory(jenisAset) {
                        if (!jenisAset) return;

                        const mappedCategory = categoryMapping[jenisAset];
                        if (mappedCategory) {
                            const config = depreciationSchedule.categories.find(c => c.category === mappedCategory);
                            if (config) {
                                this.form.umur_faedah_tahunan = config.estimated_useful_life_years;
                                this.calculateAnnualDepreciation();
                            }
                        }
                    },

                    calculateAnnualDepreciation(force = false) {
                        // Straight-line method: (Cost - Discount) / Useful Life
                        const cost = parseFloat(this.form.nilai_perolehan) || 0;
                        const discount = parseFloat(this.form.diskaun) || 0;
                        const usefulLife = parseFloat(this.form.umur_faedah_tahunan) || 0;

                        if (cost > 0 && usefulLife > 0) {
                            const depreciableBase = cost - discount;
                            const annualDepreciation = depreciableBase / usefulLife;
                            this.calculatedDepreciation = annualDepreciation.toFixed(2);

                            // Auto-fill if field is empty OR force is true
                            if (force || !this.form.susut_nilai_tahunan || this.form.susut_nilai_tahunan === '') {
                                this.form.susut_nilai_tahunan = annualDepreciation.toFixed(2);
                                // Update display field
                                const displayField = document.getElementById('susut_nilai_tahunan_display');
                                if (displayField) {
                                    displayField.value = this.formatCurrency(annualDepreciation);
                                }
                            }
                        } else {
                            this.calculatedDepreciation = null;
                        }
                    },

                    // Format number with thousand separators and 2 decimals
                    formatCurrency(value) {
                        if (!value && value !== 0) return '';
                        const num = parseFloat(value.toString().replace(/,/g, ''));
                        if (isNaN(num)) return '';
                        return num.toLocaleString('en-US', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    },

                    // Remove commas and return numeric value
                    parseCurrency(value) {
                        if (!value) return 0;
                        return parseFloat(value.toString().replace(/,/g, '')) || 0;
                    },

                    // Format on input (allows partial entry)
                    formatPriceInput(event, fieldName) {
                        const input = event.target;
                        let value = input.value.replace(/,/g, '');

                        // Allow only numbers and decimal point
                        value = value.replace(/[^\d.]/g, '');

                        // Ensure only one decimal point
                        const parts = value.split('.');
                        if (parts.length > 2) {
                            value = parts[0] + '.' + parts.slice(1).join('');
                        }

                        // Limit to 2 decimal places
                        if (parts.length === 2 && parts[1].length > 2) {
                            value = parts[0] + '.' + parts[1].substring(0, 2);
                        }

                        // Update the display
                        input.value = value;

                        // Update hidden field with raw value
                        this.form[fieldName] = value;
                    },

                    // Format on blur (final formatting with commas and 2 decimals)
                    formatPriceBlur(event, fieldName) {
                        const input = event.target;
                        const rawValue = input.value.replace(/,/g, '');
                        const numValue = parseFloat(rawValue) || 0;

                        // Update visible input with formatted value
                        input.value = this.formatCurrency(numValue);

                        // Update hidden field with raw value (2 decimal places)
                        this.form[fieldName] = numValue.toFixed(2);

                        // Recalculate depreciation if needed
                        if (fieldName === 'nilai_perolehan' || fieldName === 'diskaun') {
                            this.calculateAnnualDepreciation();
                        }
                    },

                    updateWarrantyStatus(status) {
                        if (status === 'Baru') {
                            this.form.keadaan_fizikal = 'Cemerlang';
                            this.form.status_jaminan = 'Aktif';
                        }
                    },
                    setInspectionDate(receiptDate) {
                        if (receiptDate) {
                            // Create a new date from the receipt date
                            const date = new Date(receiptDate);
                            // Add 1 year
                            date.setFullYear(date.getFullYear() + 1);
                            // Format as YYYY-MM-DD for the date input
                            const inspectionDate = date.toISOString().split('T')[0];
                            // Set the inspection date
                            this.form.tarikh_pemeriksaan_terakhir = inspectionDate;
                        }
                    },
                    getMasjidName(masjidId) {
                        if (!masjidId) return '-';

                        // Get the masjid data from the select options
                        const selectElement = document.getElementById('masjid_surau_id');
                        const selectedOption = selectElement.querySelector(`option[value="${masjidId}"]`);

                        return selectedOption ? selectedOption.textContent : masjidId;
                    },
                    formatDate(dateString) {
                        if (!dateString) return '-';

                        // Convert yyyy-mm-dd to dd/mm/yyyy
                        const date = new Date(dateString);
                        if (isNaN(date.getTime())) return dateString; // Return original if invalid

                        const day = String(date.getDate()).padStart(2, '0');
                        const month = String(date.getMonth() + 1).padStart(2, '0');
                        const year = date.getFullYear();

                        return `${day}/${month}/${year}`;
                    }
                }
            }

            // Image upload handling
            document.addEventListener('DOMContentLoaded', function () {
                const fileInput = document.getElementById('gambar_aset');
                const dropZone = document.getElementById('dropZone');
                const imagePreview = document.getElementById('imagePreview');
                const maxFiles = 5;
                const minFiles = 1;

                // Handle file selection
                fileInput.addEventListener('change', function (e) {
                    handleFiles(e.target.files);
                });

                // Handle drag and drop
                dropZone.addEventListener('dragover', function (e) {
                    e.preventDefault();
                    dropZone.classList.add('border-emerald-400', 'bg-emerald-50');
                });

                dropZone.addEventListener('dragleave', function (e) {
                    e.preventDefault();
                    dropZone.classList.remove('border-emerald-400', 'bg-emerald-50');
                });

                dropZone.addEventListener('drop', function (e) {
                    e.preventDefault();
                    dropZone.classList.remove('border-emerald-400', 'bg-emerald-50');
                    handleFiles(e.dataTransfer.files);
                });

                function handleFiles(files) {
                    // Clear previous previews
                    imagePreview.innerHTML = '';
                    imagePreview.classList.add('hidden');

                    if (files.length === 0) return;

                    // Validate file count
                    if (files.length > maxFiles) {
                        alert(`Maksimum ${maxFiles} gambar sahaja dibenarkan.`);
                        return;
                    }

                    // Note: We don't enforce minimum here as user can add more later

                    // Validate file types and sizes
                    const validFiles = [];
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];

                        // Check file type
                        if (!file.type.startsWith('image/')) {
                            alert(`${file.name} bukan fail gambar yang sah.`);
                            continue;
                        }

                        // Check file size (2MB = 2 * 1024 * 1024 bytes)
                        if (file.size > 2 * 1024 * 1024) {
                            alert(`${file.name} terlalu besar. Maksimum 2MB setiap gambar.`);
                            continue;
                        }

                        validFiles.push(file);
                    }

                    if (validFiles.length === 0) return;

                    // Update file input
                    const dataTransfer = new DataTransfer();
                    validFiles.forEach(file => dataTransfer.items.add(file));
                    fileInput.files = dataTransfer.files;

                    // Show upload progress
                    const uploadProgress = document.getElementById('uploadProgress');
                    const progressBar = document.getElementById('progressBar');
                    if (uploadProgress && progressBar) {
                        uploadProgress.classList.remove('hidden');
                    }

                    // Show previews with enhanced animations
                    if (validFiles.length > 0) {
                        imagePreview.classList.remove('hidden');
                        validFiles.forEach((file, index) => {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                const previewDiv = document.createElement('div');
                                previewDiv.className = 'relative group animate-fadeIn';
                                previewDiv.innerHTML = `
                                                                                                                <div class="aspect-[4/3] bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl overflow-hidden border-2 border-gray-200 group-hover:border-emerald-300 transition-all duration-300 shadow-sm group-hover:shadow-lg transform group-hover:scale-105 cursor-pointer" onclick="openImageModal('${e.target.result}', '${file.name}')">
                                                                                                                    <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                                                                                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                                                                                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                                                                                            <div class="w-12 h-12 bg-white bg-opacity-90 rounded-full flex items-center justify-center">
                                                                                                                                <i class='bx bx-zoom-in text-gray-700 text-2xl'></i>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <button type="button" onclick="removeImage(${index})" class="absolute -top-3 -right-3 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center text-sm hover:bg-red-600 transition-all duration-200 opacity-0 group-hover:opacity-100 shadow-lg hover:shadow-xl transform hover:scale-110">
                                                                                                                    <i class='bx bx-x text-lg'></i>
                                                                                                                </button>
                                                                                                                <div class="mt-3 p-3 bg-white rounded-lg shadow-sm border border-gray-100">
                                                                                                                    <p class="text-sm text-gray-700 truncate font-medium">${file.name}</p>
                                                                                                                    <p class="text-sm text-emerald-600 mt-1 font-medium">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                                                                                                                </div>
                                                                                                            `;
                                imagePreview.appendChild(previewDiv);

                                // Update progress
                                if (progressBar) {
                                    const progress = ((index + 1) / validFiles.length) * 100;
                                    progressBar.style.width = progress + '%';
                                }
                            };
                            reader.readAsDataURL(file);
                        });

                        // Hide progress after all images are loaded
                        setTimeout(() => {
                            if (uploadProgress) {
                                uploadProgress.classList.add('hidden');
                            }
                            if (progressBar) {
                                progressBar.style.width = '0%';
                            }
                        }, 1000);
                    }
                }

                // Global function to remove image
                window.removeImage = function (index) {
                    const fileInput = document.getElementById('gambar_aset');
                    const files = Array.from(fileInput.files);
                    files.splice(index, 1);

                    const dataTransfer = new DataTransfer();
                    files.forEach(file => dataTransfer.items.add(file));
                    fileInput.files = dataTransfer.files;

                    handleFiles(fileInput.files);
                };

                // Global function to open image modal
                window.openImageModal = function (imageSrc, imageName) {
                    const modal = document.getElementById('imageModal');
                    const modalImage = document.getElementById('modalImage');
                    const modalImageName = document.getElementById('modalImageName');

                    modalImage.src = imageSrc;
                    modalImageName.textContent = imageName;
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden'; // Prevent background scrolling
                };

                // Close modal functionality
                document.getElementById('closeModal').addEventListener('click', function () {
                    const modal = document.getElementById('imageModal');
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto'; // Restore scrolling
                });

                // Close modal when clicking outside
                document.getElementById('imageModal').addEventListener('click', function (e) {
                    if (e.target === this) {
                        this.classList.add('hidden');
                        document.body.style.overflow = 'auto';
                    }
                });

                // Close modal with Escape key
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        const modal = document.getElementById('imageModal');
                        if (!modal.classList.contains('hidden')) {
                            modal.classList.add('hidden');
                            document.body.style.overflow = 'auto';
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection