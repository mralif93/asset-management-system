@extends('layouts.admin')

@section('title', 'Tambah Rekod Penyelenggaraan')
@section('page-title', 'Tambah Rekod Penyelenggaraan Baru')
@section('page-description', 'Cipta rekod penyelenggaraan baru untuk aset')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Tambah Rekod Penyelenggaraan</h1>
                <p class="text-emerald-100 text-lg">Cipta rekod penyelenggaraan baharu untuk aset</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-wrench text-emerald-200'></i>
                        <span class="text-emerald-100">Penyelenggaraan Aset</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-calendar-check text-emerald-200'></i>
                        <span class="text-emerald-100">Jadual Teratur</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-wrench text-6xl text-emerald-200'></i>
            </div>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <div class="flex items-center space-x-2 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600">
            <i class='bx bx-home'></i>
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <a href="{{ route('admin.maintenance-records.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Penyelenggaraan
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">Tambah Rekod</span>
    </div>

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.maintenance-records.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
            <i class='bx bx-arrow-back mr-2'></i>
            Kembali ke Senarai Penyelenggaraan
        </a>
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
                    <span class="ml-2 text-sm font-medium text-emerald-600">Maklumat Aset</span>
                </div>
                <div class="w-16 h-1 bg-gray-200 rounded"></div>
                
                <!-- Step 2 -->
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">
                        2
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-500">Butiran Penyelenggaraan</span>
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
        <form action="{{ route('admin.maintenance-records.store') }}" method="POST" enctype="multipart/form-data" x-data="maintenanceForm()" class="space-y-0">
            @csrf

            <!-- Form Header -->
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Cipta Rekod Penyelenggaraan Baru</h2>
                        <p class="text-sm text-gray-600">Isikan semua maklumat yang diperlukan untuk mencipta rekod penyelenggaraan</p>
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
                    
                    <!-- Asset Selection Section -->
                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-package text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Pemilihan Aset</h3>
                                <p class="text-sm text-emerald-700">Pilih aset yang akan diselenggara</p>
                            </div>
                        </div>
                        
                        <div>
                            <!-- Asset Selection -->
                            <div>
                                <label for="asset_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-package mr-1'></i>
                                    Aset <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="asset_id" 
                                            name="asset_id" 
                                            required
                                            x-model="form.asset_id"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('asset_id') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Aset</option>
                                        @foreach($assets as $asset)
                                            <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                                                {{ $asset->nama_aset }} - {{ $asset->no_siri_pendaftaran }} ({{ $asset->masjidSurau->nama ?? '' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class='bx bx-package absolute left-3 top-3.5 text-gray-400'></i>
                                    <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('asset_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Maintenance Details Section -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-wrench text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Butiran Penyelenggaraan</h3>
                                <p class="text-sm text-purple-700">Maklumat kerja penyelenggaraan</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Jenis Penyelenggaraan -->
                            <div>
                                <label for="jenis_penyelenggaraan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-cog mr-1'></i>
                                    Jenis Penyelenggaraan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="jenis_penyelenggaraan" 
                                            name="jenis_penyelenggaraan" 
                                            required
                                            x-model="form.jenis_penyelenggaraan"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jenis_penyelenggaraan') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Jenis</option>
                                        <option value="Pencegahan" {{ old('jenis_penyelenggaraan') == 'Pencegahan' ? 'selected' : '' }}>Pencegahan</option>
                                        <option value="Pembaikan" {{ old('jenis_penyelenggaraan') == 'Pembaikan' ? 'selected' : '' }}>Pembaikan</option>
                                        <option value="Kalibrasi" {{ old('jenis_penyelenggaraan') == 'Kalibrasi' ? 'selected' : '' }}>Kalibrasi</option>
                                        <option value="Pembersihan" {{ old('jenis_penyelenggaraan') == 'Pembersihan' ? 'selected' : '' }}>Pembersihan</option>
                                        <option value="Upgrade" {{ old('jenis_penyelenggaraan') == 'Upgrade' ? 'selected' : '' }}>Upgrade</option>
                                    </select>
                                    <i class='bx bx-cog absolute left-3 top-3.5 text-gray-400'></i>
                                    <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('jenis_penyelenggaraan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Tarikh Penyelenggaraan -->
                            <div>
                                <label for="tarikh_penyelenggaraan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-calendar mr-1'></i>
                                    Tarikh Penyelenggaraan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="date" 
                                           id="tarikh_penyelenggaraan" 
                                           name="tarikh_penyelenggaraan" 
                                           value="{{ old('tarikh_penyelenggaraan', date('Y-m-d')) }}" 
                                           required
                                           x-model="form.tarikh_penyelenggaraan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_penyelenggaraan') border-red-500 @enderror bg-white">
                                    <i class='bx bx-calendar absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('tarikh_penyelenggaraan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Kos Penyelenggaraan -->
                            <div>
                                <label for="kos_penyelenggaraan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-money mr-1'></i>
                                    Kos Penyelenggaraan (RM) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           id="kos_penyelenggaraan" 
                                           name="kos_penyelenggaraan" 
                                           value="{{ old('kos_penyelenggaraan') }}" 
                                           step="0.01" 
                                           min="0" 
                                           required
                                           x-model="form.kos_penyelenggaraan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kos_penyelenggaraan') border-red-500 @enderror bg-white"
                                           placeholder="0.00">
                                    <i class='bx bx-money absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('kos_penyelenggaraan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Penyedia Perkhidmatan -->
                            <div>
                                <label for="penyedia_perkhidmatan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-user-check mr-1'></i>
                                    Penyedia Perkhidmatan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="penyedia_perkhidmatan" 
                                           name="penyedia_perkhidmatan" 
                                           value="{{ old('penyedia_perkhidmatan') }}" 
                                           required
                                           x-model="form.penyedia_perkhidmatan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('penyedia_perkhidmatan') border-red-500 @enderror bg-white"
                                           placeholder="Nama syarikat atau individu">
                                    <i class='bx bx-user-check absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('penyedia_perkhidmatan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Tarikh Penyelenggaraan Akan Datang -->
                            <div class="md:col-span-2">
                                <label for="tarikh_penyelenggaraan_akan_datang" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-calendar-plus mr-1'></i>
                                    Tarikh Penyelenggaraan Akan Datang
                                </label>
                                <div class="relative">
                                    <input type="date" 
                                           id="tarikh_penyelenggaraan_akan_datang" 
                                           name="tarikh_penyelenggaraan_akan_datang" 
                                           value="{{ old('tarikh_penyelenggaraan_akan_datang') }}"
                                           x-model="form.tarikh_penyelenggaraan_akan_datang"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_penyelenggaraan_akan_datang') border-red-500 @enderror bg-white">
                                    <i class='bx bx-calendar-plus absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('tarikh_penyelenggaraan_akan_datang')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-1 text-xs text-purple-600 flex items-center">
                                    <i class='bx bx-info-circle mr-1'></i>
                                    Opsional: Tetapkan jadual penyelenggaraan seterusnya
                                </p>
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
                                <p class="text-sm text-amber-700">Catatan dan gambar penyelenggaraan</p>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Catatan Penyelenggaraan -->
                            <div>
                                <label for="catatan_penyelenggaraan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-note mr-1'></i>
                                    Catatan Penyelenggaraan
                                </label>
                                <textarea id="catatan_penyelenggaraan" 
                                          name="catatan_penyelenggaraan" 
                                          rows="4"
                                          x-model="form.catatan_penyelenggaraan"
                                          class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('catatan_penyelenggaraan') border-red-500 @enderror bg-white"
                                          placeholder="Butiran kerja yang dilakukan, masalah yang ditemui, dll...">{{ old('catatan_penyelenggaraan') }}</textarea>
                                @error('catatan_penyelenggaraan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Gambar Penyelenggaraan -->
                            <div>
                                <label for="gambar_penyelenggaraan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-image mr-1'></i>
                                    Gambar Penyelenggaraan
                                </label>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-emerald-400 transition-colors">
                                    <input type="file" 
                                           id="gambar_penyelenggaraan" 
                                           name="gambar_penyelenggaraan[]" 
                                           multiple 
                                           accept="image/*"
                                           class="hidden"
                                           x-model="form.gambar_penyelenggaraan">
                                    <div class="space-y-2">
                                        <i class='bx bx-cloud-upload text-4xl text-gray-400'></i>
                                        <div>
                                            <label for="gambar_penyelenggaraan" class="cursor-pointer text-emerald-600 hover:text-emerald-700 font-medium">
                                                Klik untuk pilih gambar
                                            </label>
                                            <p class="text-gray-500"> atau seret dan lepas di sini</p>
                                        </div>
                                        <p class="text-xs text-gray-400">JPG, PNG hingga 2MB setiap gambar</p>
                                    </div>
                                </div>
                                @error('gambar_penyelenggaraan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Preview & Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        
                        <!-- Preview Card -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl p-6 border border-blue-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-show text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Pratonton Penyelenggaraan</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                        <i class='bx bx-wrench text-emerald-700'></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900" x-text="form.jenis_penyelenggaraan || 'Jenis Penyelenggaraan'">Jenis Penyelenggaraan</p>
                                        <p class="text-sm text-gray-500" x-text="form.tarikh_penyelenggaraan || 'Tarikh penyelenggaraan'">Tarikh penyelenggaraan</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Kos:</span>
                                        <span class="text-sm font-medium" x-text="form.kos_penyelenggaraan ? 'RM ' + parseFloat(form.kos_penyelenggaraan).toFixed(2) : 'RM 0.00'">RM 0.00</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Penyedia:</span>
                                        <span class="text-sm font-medium" x-text="form.penyedia_perkhidmatan || '-'">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Seterusnya:</span>
                                        <span class="text-sm font-medium" x-text="form.tarikh_penyelenggaraan_akan_datang || '-'">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Card -->
                        <div class="bg-white rounded-xl p-6 border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Kemajuan Borang</h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Pemilihan Aset</span>
                                    <div class="flex items-center" x-show="form.asset_id">
                                        <i class='bx bx-check text-green-500'></i>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Butiran Penyelenggaraan</span>
                                    <div class="flex items-center" x-show="form.jenis_penyelenggaraan && form.tarikh_penyelenggaraan && form.kos_penyelenggaraan">
                                        <i class='bx bx-check text-green-500'></i>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Penyedia Perkhidmatan</span>
                                    <div class="flex items-center" x-show="form.penyedia_perkhidmatan">
                                        <i class='bx bx-check text-green-500'></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Tips -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-6 border border-green-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-bulb text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Tips Berguna</h3>
                            </div>
                            
                            <ul class="space-y-2 text-sm text-green-800">
                                <li class="flex items-start">
                                    <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                    Sertakan gambar sebelum dan selepas kerja
                                </li>
                                <li class="flex items-start">
                                    <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                    Catat butiran kerja yang dilakukan
                                </li>
                                <li class="flex items-start">
                                    <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                    Tetapkan jadual penyelenggaraan seterusnya
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class='bx bx-info-circle mr-1'></i>
                        Semua medan bertanda (*) adalah wajib diisi
                    </div>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.maintenance-records.index') }}" 
                           class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                            <i class='bx bx-x mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-8 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                            <i class='bx bx-plus mr-2'></i>
                            Simpan Penyelenggaraan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function maintenanceForm() {
        return {
            form: {
                asset_id: '{{ old('asset_id') }}',
                jenis_penyelenggaraan: '{{ old('jenis_penyelenggaraan') }}',
                tarikh_penyelenggaraan: '{{ old('tarikh_penyelenggaraan', date('Y-m-d')) }}',
                kos_penyelenggaraan: '{{ old('kos_penyelenggaraan') }}',
                penyedia_perkhidmatan: '{{ old('penyedia_perkhidmatan') }}',
                tarikh_penyelenggaraan_akan_datang: '{{ old('tarikh_penyelenggaraan_akan_datang') }}',
                catatan_penyelenggaraan: '{{ old('catatan_penyelenggaraan') }}',
                gambar_penyelenggaraan: null
            }
        }
    }

    // File upload preview
    document.getElementById('gambar_penyelenggaraan').addEventListener('change', function(e) {
        const fileList = this.files;
        const fileNames = Array.from(fileList).map(file => file.name);
        
        if (fileNames.length > 0) {
            console.log('Files selected:', fileNames);
        }
    });

    // Cost formatting
    document.getElementById('kos_penyelenggaraan').addEventListener('input', function() {
        const value = this.value;
        if (value < 0) {
            this.value = 0;
        }
    });
</script>
@endpush
@endsection 