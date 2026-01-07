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
                            <div
                                class="w-3 h-3 {{ $asset->status_aset === 'Sedang Digunakan' ? 'bg-green-400' : ($asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-400' : ($asset->status_aset === 'Baru' ? 'bg-blue-400' : 'bg-red-400')) }} rounded-full">
                            </div>
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
            <form action="{{ route('admin.assets.update', $asset) }}" method="POST" enctype="multipart/form-data"
                class="space-y-0">
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
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $asset->status_aset === 'Sedang Digunakan' ? 'bg-green-100 text-green-800' : ($asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-100 text-yellow-800' : ($asset->status_aset === 'Baru' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                <div
                                    class="w-2 h-2 {{ $asset->status_aset === 'Sedang Digunakan' ? 'bg-green-500' : ($asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-500' : ($asset->status_aset === 'Baru' ? 'bg-blue-500' : 'bg-red-500')) }} rounded-full mr-2">
                                </div>
                                {{ $asset->status_aset }}
                            </span>
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
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
                        <div
                            class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <i class='bx bx-package text-white text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Maklumat Asas Aset</h3>
                                    <p class="text-sm text-emerald-700">Kemaskini maklumat asas dan identifikasi aset</p>
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
                                        <input type="text" id="nama_aset" name="nama_aset" required
                                            value="{{ old('nama_aset', $asset->nama_aset) }}"
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
                                        <input type="number" id="kuantiti" name="kuantiti"
                                            value="{{ old('kuantiti', $asset->kuantiti ?? 1) }}" required min="1"
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
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kategori_aset') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">-- Pilih --</option>
                                            <option value="asset" {{ old('kategori_aset', $asset->kategori_aset) == 'asset' ? 'selected' : '' }}>Asset</option>
                                            <option value="non-asset" {{ old('kategori_aset', $asset->kategori_aset) == 'non-asset' ? 'selected' : '' }}>Non-Asset</option>
                                        </select>
                                    </div>
                                    @error('kategori_aset')
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
                                        <select id="jenis_aset" name="jenis_aset" required
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jenis_aset') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">-- Pilih --</option>
                                            @foreach($assetTypes as $type)
                                                <option value="{{ $type }}" {{ old('jenis_aset', $asset->jenis_aset) == $type ? 'selected' : '' }}>{{ $type }}</option>
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
                                        <input type="text" id="no_siri_pendaftaran" name="no_siri_pendaftaran"
                                            value="{{ $asset->no_siri_pendaftaran }}" readonly
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
                                        <select id="status_aset" name="status_aset" required
                                            onchange="updateWarrantyStatus(this.value)"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('status_aset') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">-- Pilih --</option>
                                            <option value="Baru" {{ old('status_aset', $asset->status_aset) == 'Baru' ? 'selected' : '' }}>Baru</option>
                                            <option value="Aktif" {{ old('status_aset', $asset->status_aset) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="Sedang Digunakan" {{ old('status_aset', $asset->status_aset) == 'Sedang Digunakan' ? 'selected' : '' }}>Sedang
                                                Digunakan</option>
                                            <option value="Dalam Penyelenggaraan" {{ old('status_aset', $asset->status_aset) == 'Dalam Penyelenggaraan' ? 'selected' : '' }}>Dalam
                                                Penyelenggaraan</option>
                                            <option value="Rosak" {{ old('status_aset', $asset->status_aset) == 'Rosak' ? 'selected' : '' }}>Rosak</option>
                                            <option value="Dilupuskan" {{ old('status_aset', $asset->status_aset) == 'Dilupuskan' ? 'selected' : '' }}>Dilupuskan</option>
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
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('keadaan_fizikal') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">-- Pilih --</option>
                                            <option value="Cemerlang" {{ old('keadaan_fizikal', $asset->keadaan_fizikal) == 'Cemerlang' ? 'selected' : '' }}>Cemerlang
                                            </option>
                                            <option value="Baik" {{ old('keadaan_fizikal', $asset->keadaan_fizikal) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                            <option value="Sederhana" {{ old('keadaan_fizikal', $asset->keadaan_fizikal) == 'Sederhana' ? 'selected' : '' }}>Sederhana
                                            </option>
                                            <option value="Rosak" {{ old('keadaan_fizikal', $asset->keadaan_fizikal) == 'Rosak' ? 'selected' : '' }}>Rosak</option>
                                            <option value="Tidak Boleh Digunakan" {{ old('keadaan_fizikal', $asset->keadaan_fizikal) == 'Tidak Boleh Digunakan' ? 'selected' : '' }}>Tidak
                                                Boleh Digunakan</option>
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
                                        Status Jaminan <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-shield text-gray-400'></i>
                                        </div>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class='bx bx-chevron-down text-gray-400'></i>
                                        </div>
                                        <select id="status_jaminan" name="status_jaminan" required
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('status_jaminan') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">-- Pilih --</option>
                                            <option value="Aktif" {{ old('status_jaminan', $asset->status_jaminan) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="Tamat" {{ old('status_jaminan', $asset->status_jaminan) == 'Tamat' ? 'selected' : '' }}>Tamat</option>
                                            <option value="Tiada Jaminan" {{ old('status_jaminan', $asset->status_jaminan) == 'Tiada Jaminan' ? 'selected' : '' }}>Tiada Jaminan
                                            </option>
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
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('lokasi_penempatan') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">-- Pilih --</option>
                                            @foreach(\App\Helpers\SystemData::getValidLocations() as $location)
                                                <option value="{{ $location }}" {{ old('lokasi_penempatan', $asset->lokasi_penempatan) == $location ? 'selected' : '' }}>
                                                    {{ $location }}
                                                </option>
                                            @endforeach
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
                                            value="{{ old('tarikh_pemeriksaan_terakhir', $asset->tarikh_pemeriksaan_terakhir ? $asset->tarikh_pemeriksaan_terakhir->format('Y-m-d') : '') }}"
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
                                            value="{{ old('tarikh_penyelenggaraan_akan_datang', $asset->tarikh_penyelenggaraan_akan_datang ? $asset->tarikh_penyelenggaraan_akan_datang->format('Y-m-d') : '') }}"
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
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('masjid_surau_id') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">-- Pilih --</option>
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

                        <!-- Acquisition Information Section -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
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
                                        <input type="date" id="tarikh_perolehan" name="tarikh_perolehan" required
                                            value="{{ old('tarikh_perolehan', $asset->tarikh_perolehan ? $asset->tarikh_perolehan->format('Y-m-d') : '') }}"
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
                                        <select id="kaedah_perolehan" name="kaedah_perolehan" required
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kaedah_perolehan') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">-- Pilih --</option>
                                            <option value="Pembelian" {{ old('kaedah_perolehan', $asset->kaedah_perolehan) == 'Pembelian' ? 'selected' : '' }}>Pembelian
                                            </option>
                                            <option value="Sumbangan" {{ old('kaedah_perolehan', $asset->kaedah_perolehan) == 'Sumbangan' ? 'selected' : '' }}>Sumbangan
                                            </option>
                                            <option value="Hibah" {{ old('kaedah_perolehan', $asset->kaedah_perolehan) == 'Hibah' ? 'selected' : '' }}>Hibah</option>
                                            <option value="Infaq" {{ old('kaedah_perolehan', $asset->kaedah_perolehan) == 'Infaq' ? 'selected' : '' }}>Infaq</option>
                                            <option value="Lain-lain" {{ old('kaedah_perolehan', $asset->kaedah_perolehan) == 'Lain-lain' ? 'selected' : '' }}>Lain-lain
                                            </option>
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

                                <!-- Pembekal / Vendor -->
                                <div class="space-y-4">
                                    <div>
                                        <label for="pembekal" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class='bx bx-store mr-1'></i>
                                            Pembekal / Vendor <span class="text-gray-500 text-xs">(Jika ada)</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class='bx bx-store text-gray-400'></i>
                                            </div>
                                            <input type="text" id="pembekal" name="pembekal"
                                                value="{{ old('pembekal', $asset->pembekal) }}"
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

                                    <!-- Vendor Address -->
                                    <div>
                                        <label for="pembekal_alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class='bx bx-map-pin mr-1'></i>
                                            Alamat Pembekal
                                        </label>
                                        <div class="relative">
                                            <textarea id="pembekal_alamat" name="pembekal_alamat" rows="2"
                                                class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('pembekal_alamat') border-red-500 @enderror bg-white"
                                                placeholder="Alamat penuh pembekal">{{ old('pembekal_alamat', $asset->pembekal_alamat) }}</textarea>
                                        </div>
                                        @error('pembekal_alamat')
                                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                                <i class='bx bx-error-circle mr-1'></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Vendor Phone -->
                                    <div>
                                        <label for="pembekal_no_telefon"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class='bx bx-phone mr-1'></i>
                                            No. Telefon Pembekal
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class='bx bx-phone text-gray-400'></i>
                                            </div>
                                            <input type="text" id="pembekal_no_telefon" name="pembekal_no_telefon"
                                                value="{{ old('pembekal_no_telefon', $asset->pembekal_no_telefon) }}"
                                                class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('pembekal_no_telefon') border-red-500 @enderror bg-white"
                                                placeholder="Cth: 012-3456789">
                                        </div>
                                        @error('pembekal_no_telefon')
                                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                                <i class='bx bx-error-circle mr-1'></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Acquisition Value -->
                                <div>
                                    <label for="nilai_perolehan" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-dollar mr-1'></i>
                                        Nilai Perolehan (RM) <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" id="nilai_perolehan_display" required
                                            value="{{ old('nilai_perolehan', $asset->nilai_perolehan) ? number_format(old('nilai_perolehan', $asset->nilai_perolehan), 2) : '' }}"
                                            oninput="formatPriceInputEdit(event, 'nilai_perolehan')"
                                            onblur="formatPriceBlurEdit(event, 'nilai_perolehan')"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nilai_perolehan') border-red-500 @enderror bg-white"
                                            placeholder="0.00">
                                        <input type="hidden" id="nilai_perolehan" name="nilai_perolehan"
                                            value="{{ old('nilai_perolehan', $asset->nilai_perolehan) }}">
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
                                        <input type="text" id="diskaun_display"
                                            value="{{ old('diskaun', $asset->diskaun ?? 0) ? number_format(old('diskaun', $asset->diskaun ?? 0), 2) : '0.00' }}"
                                            oninput="formatPriceInputEdit(event, 'diskaun')"
                                            onblur="formatPriceBlurEdit(event, 'diskaun')"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('diskaun') border-red-500 @enderror bg-white"
                                            placeholder="0.00">
                                        <input type="hidden" id="diskaun" name="diskaun"
                                            value="{{ old('diskaun', $asset->diskaun ?? '0.00') }}">
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
                                        <input type="text" id="no_resit" name="no_resit"
                                            value="{{ old('no_resit', $asset->no_resit) }}"
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
                                            value="{{ old('tarikh_resit', $asset->tarikh_resit ? $asset->tarikh_resit->format('Y-m-d') : '') }}"
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
                                        Pegawai Bertanggungjawab <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" id="pegawai_bertanggungjawab_lokasi"
                                            name="pegawai_bertanggungjawab_lokasi" required
                                            value="{{ old('pegawai_bertanggungjawab_lokasi', $asset->pegawai_bertanggungjawab_lokasi) }}"
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
                                        <input type="text" id="jawatan_pegawai" name="jawatan_pegawai"
                                            value="{{ old('jawatan_pegawai', $asset->jawatan_pegawai) }}"
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
                                    <p class="text-sm text-amber-700">Susut nilai dan umur faedah aset(only for assets)</p>
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
                                        <input type="number" id="umur_faedah_tahunan" name="umur_faedah_tahunan" min="1"
                                            value="{{ old('umur_faedah_tahunan', $asset->umur_faedah_tahunan) }}"
                                            oninput="calculateDepreciationEdit()"
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
                                            value="{{ old('susut_nilai_tahunan', $asset->susut_nilai_tahunan) ? number_format(old('susut_nilai_tahunan', $asset->susut_nilai_tahunan), 2) : '' }}"
                                            oninput="formatPriceInputEdit(event, 'susut_nilai_tahunan')"
                                            onblur="formatPriceBlurEdit(event, 'susut_nilai_tahunan')"
                                            class="w-full pl-10 pr-20 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('susut_nilai_tahunan') border-red-500 @enderror bg-white"
                                            placeholder="Auto-calculate">
                                        <input type="hidden" id="susut_nilai_tahunan" name="susut_nilai_tahunan"
                                            value="{{ old('susut_nilai_tahunan', $asset->susut_nilai_tahunan) }}">
                                        <button type="button" onclick="calculateDepreciationEdit(true)"
                                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-emerald-600 hover:text-emerald-700"
                                            title="Kira semula (Paksa Kemaskini)">
                                            <i class='bx bx-calculator text-lg'></i>
                                        </button>
                                    </div>
                                    <p class="mt-1 text-xs text-emerald-600" id="calculatedDepreciationEdit"></p>
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
                                    <textarea id="catatan" name="catatan" rows="4"
                                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('catatan') border-red-500 @enderror bg-white"
                                        placeholder="Catatan tambahan tentang aset ini...">{{ old('catatan', $asset->catatan) }}</textarea>
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
                                        class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('catatan_jaminan') border-red-500 @enderror bg-white"
                                        placeholder="Catatan tentang jaminan aset...">{{ old('catatan_jaminan', $asset->catatan_jaminan) }}</textarea>
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
                                        Gambar Aset Baru (Opsional)
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
                                                            Upload gambar tambahan
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
                                                    Maksimum 5 gambar keseluruhan
                                                </p>
                                                <p class="text-xs text-blue-600 flex items-center justify-center">
                                                    <i class='bx bx-info-circle mr-1'></i>
                                                    Tambah gambar baru atau ganti yang sedia ada
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

                                    @if($asset->gambar_aset && count($asset->gambar_aset) > 0)
                                        <div class="mt-6">
                                            <div class="flex items-center mb-4">
                                                <div
                                                    class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                                                    <i class='bx bx-image text-emerald-600 text-lg'></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-semibold text-gray-800">Gambar Sedia Ada</p>
                                                    <p class="text-xs text-gray-500">{{ count($asset->gambar_aset) }} gambar
                                                        telah dimuat naik</p>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                                @foreach($asset->gambar_aset as $index => $image)
                                                    <div class="relative group animate-fadeIn">
                                                        <div class="aspect-[4/3] bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl overflow-hidden border-2 border-gray-200 group-hover:border-emerald-300 transition-all duration-300 shadow-sm group-hover:shadow-lg transform group-hover:scale-105 cursor-pointer"
                                                            onclick="openImageModal('{{ Storage::url($image) }}', 'Gambar {{ $index + 1 }}')">
                                                            <img src="{{ Storage::url($image) }}" alt="Gambar Aset {{ $index + 1 }}"
                                                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                                                            <div
                                                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                                                <div
                                                                    class="opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                                    <div
                                                                        class="w-12 h-12 bg-white bg-opacity-90 rounded-full flex items-center justify-center">
                                                                        <i class='bx bx-zoom-in text-gray-700 text-2xl'></i>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button type="button" onclick="removeExistingImage('{{ $image }}')"
                                                            class="absolute -top-3 -right-3 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center text-sm hover:bg-red-600 transition-all duration-200 opacity-0 group-hover:opacity-100 shadow-lg hover:shadow-xl transform hover:scale-110">
                                                            <i class='bx bx-x text-lg'></i>
                                                        </button>
                                                        <div class="mt-3 p-3 bg-white rounded-lg shadow-sm border border-gray-100">
                                                            <p class="text-sm text-gray-700 truncate font-medium">Gambar
                                                                {{ $index + 1 }}
                                                            </p>
                                                            <p class="text-sm text-emerald-600 mt-1 font-medium">Sedia ada</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

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
                                                <p class="text-blue-700 leading-relaxed">Anda boleh menambah gambar baru
                                                    atau menggantikan gambar yang sedia ada. Maksimum 5 gambar keseluruhan
                                                    untuk setiap aset.</p>
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
                                    <span class="font-medium text-gray-900">{{ $asset->nama_aset }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jenis:</span>
                                    <span class="font-medium text-gray-900">{{ $asset->jenis_aset }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Kategori:</span>
                                    <span
                                        class="text-sm font-medium">{{ $asset->kategori_aset === 'asset' ? 'Asset' : 'Non-Asset' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Status:</span>
                                    <span class="font-medium text-gray-900">{{ $asset->status_aset }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Lokasi:</span>
                                    <span class="font-medium text-gray-900">{{ $asset->lokasi_penempatan }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Nilai:</span>
                                    <span class="font-medium text-gray-900">RM
                                        {{ number_format($asset->nilai_perolehan, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Diskaun:</span>
                                    <span class="font-medium text-gray-900">RM
                                        {{ number_format($asset->diskaun ?? 0, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Pegawai:</span>
                                    <span
                                        class="font-medium text-gray-900">{{ $asset->pegawai_bertanggungjawab_lokasi ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jawatan:</span>
                                    <span class="font-medium text-gray-900">{{ $asset->jawatan_pegawai ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Keadaan:</span>
                                    <span class="font-medium text-gray-900">{{ $asset->keadaan_fizikal ?? 'Baik' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Jaminan:</span>
                                    <span
                                        class="font-medium text-gray-900">{{ $asset->status_jaminan ?? 'Tiada Jaminan' }}</span>
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
                                    Simpan Perubahan
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

            document.addEventListener('DOMContentLoaded', function () {
                const jenisAsetSelect = document.getElementById('jenis_aset');
                if (jenisAsetSelect) {
                    jenisAsetSelect.addEventListener('change', function (e) {
                        updateDepreciationFromCategory(e.target.value);
                    });
                }
            });

            function updateDepreciationFromCategory(jenisAset) {
                if (!jenisAset) return;
                const mappedCategory = categoryMapping[jenisAset];
                if (mappedCategory) {
                    const config = depreciationSchedule.categories.find(c => c.category === mappedCategory);
                    if (config) {
                        const usefulLifeField = document.getElementById('umur_faedah_tahunan');
                        if (usefulLifeField) {
                            usefulLifeField.value = config.estimated_useful_life_years;
                            // Trigger calculation if the function exists
                            if (typeof calculateDepreciationEdit === 'function') {
                                calculateDepreciationEdit(true);
                            }
                        }
                    }
                }
            }

            function updateWarrantyStatus(assetStatus) {
                if (assetStatus === 'Baru') {
                    // Set the field values
                    document.getElementById('status_jaminan').value = 'Aktif';
                    document.getElementById('keadaan_fizikal').value = 'Cemerlang';
                }
            }

            // Form validation
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.querySelector('form');
                const requiredFields = form.querySelectorAll('[required]');

                form.addEventListener('submit', function (e) {
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

            // Calculate annual depreciation using straight-line method
            function calculateDepreciationEdit(force = false) {
                const cost = parseFloat(document.getElementById('nilai_perolehan').value) || 0;
                const discount = parseFloat(document.getElementById('diskaun').value) || 0;
                const usefulLife = parseFloat(document.getElementById('umur_faedah_tahunan').value) || 0;
                const depreciationField = document.getElementById('susut_nilai_tahunan');
                const depreciationDisplayField = document.getElementById('susut_nilai_tahunan_display');
                const calculatedDisplay = document.getElementById('calculatedDepreciationEdit');

                if (cost > 0 && usefulLife > 0) {
                    const depreciableBase = cost - discount;
                    const annualDepreciation = depreciableBase / usefulLife;

                    // Show calculated value
                    calculatedDisplay.textContent = 'Dikira: RM ' + formatCurrencyEdit(annualDepreciation) + ' (Straight-Line Method)';
                    calculatedDisplay.style.display = 'block';

                    // Auto-fill if field is empty OR force is true
                    if (force || !depreciationField.value || depreciationField.value === '') {
                        depreciationField.value = annualDepreciation.toFixed(2);
                        if (depreciationDisplayField) {
                            depreciationDisplayField.value = formatCurrencyEdit(annualDepreciation);
                        }
                    }
                } else {
                    calculatedDisplay.style.display = 'none';
                }
            }

            // Format number with thousand separators and 2 decimals
            function formatCurrencyEdit(value) {
                if (!value && value !== 0) return '';
                const num = parseFloat(value.toString().replace(/,/g, ''));
                if (isNaN(num)) return '';
                return num.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            // Format on input (allows partial entry)
            function formatPriceInputEdit(event, fieldName) {
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
                const hiddenField = document.getElementById(fieldName);
                if (hiddenField) {
                    hiddenField.value = value;
                }
            }

            // Format on blur (final formatting with commas and 2 decimals)
            function formatPriceBlurEdit(event, fieldName) {
                const input = event.target;
                const rawValue = input.value.replace(/,/g, '');
                const numValue = parseFloat(rawValue) || 0;

                // Update visible input with formatted value
                input.value = formatCurrencyEdit(numValue);

                // Update hidden field with raw value (2 decimal places)
                const hiddenField = document.getElementById(fieldName);
                if (hiddenField) {
                    hiddenField.value = numValue.toFixed(2);
                }

                // Recalculate depreciation if needed
                if (fieldName === 'nilai_perolehan' || fieldName === 'diskaun') {
                    calculateDepreciationEdit();
                }
            }

            // Image upload handling for edit form
            const fileInput = document.getElementById('gambar_aset');
            const dropZone = document.getElementById('dropZone');
            const imagePreview = document.getElementById('imagePreview');
            const maxFiles = 5;
            const existingImages = {{ $asset->gambar_aset ? count($asset->gambar_aset) : 0 }};

            if (fileInput && dropZone && imagePreview) {
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

                    // Validate total file count (existing + new)
                    const totalFiles = existingImages + files.length;
                    if (totalFiles > maxFiles) {
                        alert(`Maksimum ${maxFiles} gambar sahaja dibenarkan. Anda sudah ada ${existingImages} gambar.`);
                        return;
                    }

                    // If no existing images and no new images, that's okay for edit form

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
                                                                                                        <button type="button" onclick="removeNewImage(${index})" class="absolute -top-3 -right-3 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center text-sm hover:bg-red-600 transition-all duration-200 opacity-0 group-hover:opacity-100 shadow-lg hover:shadow-xl transform hover:scale-110">
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

                // Global function to remove new image
                window.removeNewImage = function (index) {
                    const fileInput = document.getElementById('gambar_aset');
                    const files = Array.from(fileInput.files);
                    files.splice(index, 1);

                    const dataTransfer = new DataTransfer();
                    files.forEach(file => dataTransfer.items.add(file));
                    fileInput.files = dataTransfer.files;

                    handleFiles(fileInput.files);
                };

                // Global function to remove existing image (placeholder - would need backend implementation)
                window.removeExistingImage = function (imagePath) {
                    if (confirm('Adakah anda pasti ingin memadamkan gambar ini?')) {
                        // This would need to be implemented with AJAX to remove from server
                        alert('Fungsi memadam gambar sedia ada akan diimplementasikan kemudian.');
                    }
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
            }
        </script>
    @endpush
@endsection