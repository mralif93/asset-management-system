@extends('layouts.admin')

@section('title', 'Tambah Pelupusan Aset')
@section('page-title', 'Tambah Pelupusan Aset Baru')
@section('page-description', 'Cipta permohonan pelupusan aset')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Tambah Pelupusan Aset</h1>
                <p class="text-emerald-100 text-lg">Cipta permohonan pelupusan aset baharu</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-trash text-emerald-200'></i>
                        <span class="text-emerald-100">Permohonan Pelupusan</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-shield-check text-emerald-200'></i>
                        <span class="text-emerald-100">Sistem Selamat</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-recycle text-6xl text-emerald-200'></i>
            </div>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <div class="flex items-center space-x-2 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600">
            <i class='bx bx-home'></i>
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <a href="{{ route('admin.disposals.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Pelupusan
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">Tambah Pelupusan</span>
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
                    <span class="ml-2 text-sm font-medium text-emerald-600">Pilih Aset</span>
                </div>
                <div class="w-16 h-1 bg-gray-200 rounded"></div>
                
                <!-- Step 2 -->
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">
                        2
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-500">Butiran Pelupusan</span>
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
        <form action="{{ route('admin.disposals.store') }}" method="POST" enctype="multipart/form-data" x-data="disposalForm()" class="space-y-0">
            @csrf

            <!-- Form Header -->
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Cipta Permohonan Pelupusan Aset</h2>
                        <p class="text-sm text-gray-600">Isikan semua maklumat yang diperlukan untuk permohonan pelupusan</p>
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
                                <p class="text-sm text-emerald-700">Pilih aset yang akan dilupuskan</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Asset Selection -->
                            <div>
                                <label for="asset_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-package mr-1'></i>
                                    Aset untuk Dilupuskan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="asset_id" 
                                            id="asset_id" 
                                            required
                                            x-model="form.asset_id"
                                            @change="updateAssetPreview()"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('asset_id') border-red-500 @enderror bg-white">
                                        <option value="">Pilih Aset</option>
                                        @foreach($assets as $asset)
                                            <option value="{{ $asset->id }}" 
                                                    data-name="{{ $asset->nama_aset }}"
                                                    data-serial="{{ $asset->no_siri_pendaftaran }}"
                                                    data-type="{{ $asset->jenis_aset }}"
                                                    data-value="{{ $asset->nilai_perolehan }}"
                                                    data-location="{{ $asset->lokasi_penempatan }}"
                                                    data-masjid="{{ $asset->masjidSurau->nama ?? '' }}"
                                                    {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                                                {{ $asset->nama_aset }} - {{ $asset->no_siri_pendaftaran }} ({{ $asset->masjidSurau->nama ?? '' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class='bx bx-package absolute left-3 top-3.5 text-gray-400'></i>
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

                    <!-- Disposal Details Section -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-clipboard text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Butiran Pelupusan</h3>
                                <p class="text-sm text-purple-700">Maklumat pelupusan aset</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Disposal Date -->
                            <div>
                                <label for="tarikh_pelupusan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-calendar mr-1'></i>
                                    Tarikh Pelupusan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="date" 
                                           name="tarikh_pelupusan" 
                                           id="tarikh_pelupusan" 
                                           value="{{ old('tarikh_pelupusan') }}" 
                                           required
                                           x-model="form.tarikh_pelupusan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_pelupusan') border-red-500 @enderror bg-white">
                                    <i class='bx bx-calendar absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('tarikh_pelupusan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Disposal Reason -->
                            <div>
                                <label for="sebab_pelupusan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-info-circle mr-1'></i>
                                    Sebab Pelupusan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="sebab_pelupusan" 
                                            id="sebab_pelupusan" 
                                            required
                                            x-model="form.sebab_pelupusan"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('sebab_pelupusan') border-red-500 @enderror bg-white">
                                        <option value="">Pilih Sebab</option>
                                        <option value="Rosak dan tidak boleh dibaiki" {{ old('sebab_pelupusan') == 'Rosak dan tidak boleh dibaiki' ? 'selected' : '' }}>Rosak dan tidak boleh dibaiki</option>
                                        <option value="Sudah usang/lapuk" {{ old('sebab_pelupusan') == 'Sudah usang/lapuk' ? 'selected' : '' }}>Sudah usang/lapuk</option>
                                        <option value="Tidak diperlukan lagi" {{ old('sebab_pelupusan') == 'Tidak diperlukan lagi' ? 'selected' : '' }}>Tidak diperlukan lagi</option>
                                        <option value="Kos penyelenggaraan tinggi" {{ old('sebab_pelupusan') == 'Kos penyelenggaraan tinggi' ? 'selected' : '' }}>Kos penyelenggaraan tinggi</option>
                                        <option value="Diganti dengan yang baru" {{ old('sebab_pelupusan') == 'Diganti dengan yang baru' ? 'selected' : '' }}>Diganti dengan yang baru</option>
                                        <option value="Lain-lain" {{ old('sebab_pelupusan') == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                                    </select>
                                    <i class='bx bx-info-circle absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('sebab_pelupusan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Disposal Method -->
                            <div>
                                <label for="kaedah_pelupusan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-recycle mr-1'></i>
                                    Kaedah Pelupusan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="kaedah_pelupusan" 
                                            id="kaedah_pelupusan" 
                                            required
                                            x-model="form.kaedah_pelupusan"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kaedah_pelupusan') border-red-500 @enderror bg-white">
                                        <option value="">Pilih Kaedah</option>
                                        <option value="Dijual" {{ old('kaedah_pelupusan') == 'Dijual' ? 'selected' : '' }}>Dijual</option>
                                        <option value="Dibuang" {{ old('kaedah_pelupusan') == 'Dibuang' ? 'selected' : '' }}>Dibuang</option>
                                        <option value="Dikitar semula" {{ old('kaedah_pelupusan') == 'Dikitar semula' ? 'selected' : '' }}>Dikitar semula</option>
                                        <option value="Disumbangkan" {{ old('kaedah_pelupusan') == 'Disumbangkan' ? 'selected' : '' }}>Disumbangkan</option>
                                        <option value="Dipindahkan" {{ old('kaedah_pelupusan') == 'Dipindahkan' ? 'selected' : '' }}>Dipindahkan</option>
                                        <option value="Lain-lain" {{ old('kaedah_pelupusan') == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                                    </select>
                                    <i class='bx bx-recycle absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('kaedah_pelupusan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Disposal Value -->
                            <div>
                                <label for="nilai_pelupusan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-dollar mr-1'></i>
                                    Nilai Pelupusan (RM)
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="nilai_pelupusan" 
                                           id="nilai_pelupusan" 
                                           value="{{ old('nilai_pelupusan') }}" 
                                           step="0.01" 
                                           min="0"
                                           x-model="form.nilai_pelupusan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nilai_pelupusan') border-red-500 @enderror bg-white"
                                           placeholder="0.00">
                                    <i class='bx bx-dollar absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('nilai_pelupusan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Remaining Value -->
                            <div>
                                <label for="nilai_baki" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-calculator mr-1'></i>
                                    Nilai Baki (RM)
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="nilai_baki" 
                                           id="nilai_baki" 
                                           value="{{ old('nilai_baki') }}" 
                                           step="0.01" 
                                           min="0"
                                           x-model="form.nilai_baki"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nilai_baki') border-red-500 @enderror bg-white"
                                           placeholder="0.00">
                                    <i class='bx bx-calculator absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('nilai_baki')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="mt-6">
                            <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-note mr-1'></i>
                                Catatan Tambahan
                            </label>
                            <textarea name="catatan" 
                                      id="catatan" 
                                      rows="4"
                                      x-model="form.catatan"
                                      class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('catatan') border-red-500 @enderror bg-white"
                                      placeholder="Masukkan catatan tambahan jika ada...">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class='bx bx-error-circle mr-1'></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Documentation Section -->
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-image text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Dokumentasi</h3>
                                <p class="text-sm text-amber-700">Lampirkan gambar atau dokumen sokongan</p>
                            </div>
                        </div>

                        <!-- File Upload -->
                        <div>
                            <label for="gambar_pelupusan" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-upload mr-1'></i>
                                Gambar/Dokumen Pelupusan
                            </label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-emerald-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <i class='bx bx-cloud-upload text-4xl text-gray-400'></i>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="gambar_pelupusan" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                            <span>Muat naik fail</span>
                                            <input id="gambar_pelupusan" name="gambar_pelupusan[]" type="file" class="sr-only" multiple accept="image/*,.pdf,.doc,.docx">
                                        </label>
                                        <p class="pl-1">atau seret dan lepas</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, PDF sehingga 10MB (maksimum 5 fail)</p>
                                </div>
                            </div>
                            @error('gambar_pelupusan')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class='bx bx-error-circle mr-1'></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Security Notice -->
                        <div class="mt-6 p-4 bg-amber-50 rounded-lg border border-amber-200">
                            <div class="flex">
                                <i class='bx bx-shield-check text-amber-600 text-lg mt-0.5'></i>
                                <div class="ml-3">
                                    <p class="text-sm text-amber-800">
                                        <strong>Nota Penting:</strong> Pastikan semua dokumen yang dimuat naik adalah relevan dan mengandungi maklumat yang tepat. Permohonan ini akan dikaji semula oleh pihak yang berkaitan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Preview & Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        
                        <!-- Asset Preview Card -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl p-6 border border-blue-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-package text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Pratonton Aset</h3>
                            </div>
                            
                            <div class="space-y-4" x-show="form.asset_id">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                        <i class='bx bx-trash text-red-600'></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900" x-text="selectedAsset.name || 'Nama Aset'">Nama Aset</p>
                                        <p class="text-sm text-gray-500" x-text="selectedAsset.serial || 'No. Siri'">No. Siri</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Jenis:</span>
                                        <span class="text-sm font-medium" x-text="selectedAsset.type || '-'">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Nilai Asal:</span>
                                        <span class="text-sm font-medium" x-text="selectedAsset.value ? 'RM ' + parseFloat(selectedAsset.value).toLocaleString() : '-'">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Lokasi:</span>
                                        <span class="text-sm font-medium" x-text="selectedAsset.location || '-'">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Masjid/Surau:</span>
                                        <span class="text-sm font-medium" x-text="selectedAsset.masjid || '-'">-</span>
                                    </div>
                                </div>
                            </div>

                            <div x-show="!form.asset_id" class="text-center py-8">
                                <i class='bx bx-package text-4xl text-gray-400 mb-2'></i>
                                <p class="text-gray-500 text-sm">Pilih aset untuk melihat pratonton</p>
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
                                    <span class="text-sm text-gray-600">Butiran Pelupusan</span>
                                    <div class="flex items-center" x-show="form.tarikh_pelupusan && form.sebab_pelupusan && form.kaedah_pelupusan">
                                        <i class='bx bx-check text-green-500'></i>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Nilai & Catatan</span>
                                    <div class="flex items-center" x-show="form.nilai_pelupusan || form.catatan">
                                        <i class='bx bx-check text-green-500'></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Disposal Summary -->
                        <div class="bg-gradient-to-br from-red-50 to-pink-100 rounded-xl p-6 border border-red-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-info-circle text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Ringkasan Pelupusan</h3>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Tarikh:</span>
                                    <span class="text-sm font-medium" x-text="form.tarikh_pelupusan || '-'">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Sebab:</span>
                                    <span class="text-sm font-medium text-right" x-text="form.sebab_pelupusan || '-'">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Kaedah:</span>
                                    <span class="text-sm font-medium" x-text="form.kaedah_pelupusan || '-'">-</span>
                                </div>
                                <hr class="border-red-200">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Nilai Pelupusan:</span>
                                    <span class="text-sm font-medium" x-text="form.nilai_pelupusan ? 'RM ' + parseFloat(form.nilai_pelupusan).toLocaleString() : '-'">-</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Nilai Baki:</span>
                                    <span class="text-sm font-medium" x-text="form.nilai_baki ? 'RM ' + parseFloat(form.nilai_baki).toLocaleString() : '-'">-</span>
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
                                    Pastikan aset yang dipilih benar-benar perlu dilupuskan
                                </li>
                                <li class="flex items-start">
                                    <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                    Sediakan dokumentasi yang lengkap
                                </li>
                                <li class="flex items-start">
                                    <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                    Pastikan nilai pelupusan adalah munasabah
                                </li>
                                <li class="flex items-start">
                                    <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                    Permohonan akan dikaji semula sebelum diluluskan
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
                        <a href="{{ route('admin.disposals.index') }}" 
                           class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                            <i class='bx bx-x mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-8 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                            <i class='bx bx-plus mr-2'></i>
                            Mohon Pelupusan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function disposalForm() {
        return {
            form: {
                asset_id: '{{ old('asset_id') }}',
                tarikh_pelupusan: '{{ old('tarikh_pelupusan') }}',
                sebab_pelupusan: '{{ old('sebab_pelupusan') }}',
                kaedah_pelupusan: '{{ old('kaedah_pelupusan') }}',
                nilai_pelupusan: '{{ old('nilai_pelupusan') }}',
                nilai_baki: '{{ old('nilai_baki') }}',
                catatan: '{{ old('catatan') }}'
            },
            selectedAsset: {
                name: '',
                serial: '',
                type: '',
                value: '',
                location: '',
                masjid: ''
            },
            
            updateAssetPreview() {
                const select = document.getElementById('asset_id');
                const selectedOption = select.options[select.selectedIndex];
                
                if (selectedOption && selectedOption.value) {
                    this.selectedAsset = {
                        name: selectedOption.dataset.name || '',
                        serial: selectedOption.dataset.serial || '',
                        type: selectedOption.dataset.type || '',
                        value: selectedOption.dataset.value || '',
                        location: selectedOption.dataset.location || '',
                        masjid: selectedOption.dataset.masjid || ''
                    };
                } else {
                    this.selectedAsset = {
                        name: '',
                        serial: '',
                        type: '',
                        value: '',
                        location: '',
                        masjid: ''
                    };
                }
            }
        }
    }

    // Initialize asset preview if there's an old value
    document.addEventListener('DOMContentLoaded', function() {
        const assetSelect = document.getElementById('asset_id');
        if (assetSelect.value) {
            // Trigger the change event to update preview
            assetSelect.dispatchEvent(new Event('change'));
        }
    });

    // File upload preview
    document.getElementById('gambar_pelupusan').addEventListener('change', function(e) {
        const files = e.target.files;
        if (files.length > 5) {
            alert('Maksimum 5 fail sahaja dibenarkan');
            this.value = '';
            return;
        }
        
        for (let file of files) {
            if (file.size > 10 * 1024 * 1024) { // 10MB
                alert('Saiz fail tidak boleh melebihi 10MB');
                this.value = '';
                return;
            }
        }
    });

    // Auto-calculate remaining value suggestion
    document.getElementById('nilai_pelupusan').addEventListener('input', function() {
        const assetSelect = document.getElementById('asset_id');
        const selectedOption = assetSelect.options[assetSelect.selectedIndex];
        const nilaiBalakInput = document.getElementById('nilai_baki');
        
        if (selectedOption && selectedOption.dataset.value && this.value) {
            const originalValue = parseFloat(selectedOption.dataset.value);
            const disposalValue = parseFloat(this.value);
            const remainingValue = Math.max(0, originalValue - disposalValue);
            
            if (!nilaiBalakInput.value) {
                nilaiBalakInput.value = remainingValue.toFixed(2);
                // Update Alpine.js model
                nilaiBalakInput.dispatchEvent(new Event('input'));
            }
        }
    });
</script>
@endpush
@endsection 