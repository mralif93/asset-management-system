@extends('layouts.admin')

@section('title', 'Edit Pelupusan Aset')
@section('page-title', 'Edit Pelupusan Aset')
@section('page-description', 'Kemaskini maklumat pelupusan aset')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Edit Pelupusan Aset</h1>
                <p class="text-emerald-100 text-lg">Kemaskini maklumat untuk {{ $disposal->asset->nama_aset ?? 'Aset' }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-edit text-emerald-200'></i>
                        <span class="text-emerald-100">Kemaskini Data</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 
                            @if(($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') === 'menunggu') bg-amber-400
                            @elseif(($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') === 'diluluskan') bg-green-400
                            @else bg-red-400 @endif rounded-full"></div>
                        <span class="text-emerald-100">{{ ucfirst($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') }}</span>
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
        <a href="{{ route('admin.disposals.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Pelupusan
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">Edit: {{ $disposal->asset->nama_aset ?? 'Pelupusan' }}</span>
    </div>



    <!-- Form Card - Full Width -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <form action="{{ route('admin.disposals.update', $disposal) }}" method="POST" enctype="multipart/form-data" x-data="editDisposalForm()" class="space-y-0">
            @csrf
            @method('PUT')

            <!-- Form Header -->
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Kemaskini Maklumat Pelupusan</h2>
                        <p class="text-sm text-gray-600">Edit dan kemaskini maklumat pelupusan aset dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                            @if(($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') === 'menunggu') bg-amber-100 text-amber-800
                            @elseif(($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') === 'diluluskan') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            <div class="w-2 h-2 
                                @if(($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') === 'menunggu') bg-amber-500
                                @elseif(($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') === 'diluluskan') bg-green-500
                                @else bg-red-500 @endif rounded-full mr-2"></div>
                            {{ ucfirst($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') }}
                        </span>
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                            ID: #{{ str_pad($disposal->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
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
                                <p class="text-sm text-emerald-700">Kemaskini aset yang akan dilupuskan</p>
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
                                                    {{ old('asset_id', $disposal->asset_id) == $asset->id ? 'selected' : '' }}>
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
                                <p class="text-sm text-purple-700">Kemaskini maklumat pelupusan aset</p>
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
                                           value="{{ old('tarikh_pelupusan', ($disposal->tarikh_pelupusan ?? $disposal->tarikh_permohonan)?->format('Y-m-d')) }}" 
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
                                        <option value="Rosak dan tidak boleh dibaiki" {{ old('sebab_pelupusan', $disposal->sebab_pelupusan ?? $disposal->justifikasi_pelupusan) == 'Rosak dan tidak boleh dibaiki' ? 'selected' : '' }}>Rosak dan tidak boleh dibaiki</option>
                                        <option value="Sudah usang/lapuk" {{ old('sebab_pelupusan', $disposal->sebab_pelupusan ?? $disposal->justifikasi_pelupusan) == 'Sudah usang/lapuk' ? 'selected' : '' }}>Sudah usang/lapuk</option>
                                        <option value="Tidak diperlukan lagi" {{ old('sebab_pelupusan', $disposal->sebab_pelupusan ?? $disposal->justifikasi_pelupusan) == 'Tidak diperlukan lagi' ? 'selected' : '' }}>Tidak diperlukan lagi</option>
                                        <option value="Kos penyelenggaraan tinggi" {{ old('sebab_pelupusan', $disposal->sebab_pelupusan ?? $disposal->justifikasi_pelupusan) == 'Kos penyelenggaraan tinggi' ? 'selected' : '' }}>Kos penyelenggaraan tinggi</option>
                                        <option value="Diganti dengan yang baru" {{ old('sebab_pelupusan', $disposal->sebab_pelupusan ?? $disposal->justifikasi_pelupusan) == 'Diganti dengan yang baru' ? 'selected' : '' }}>Diganti dengan yang baru</option>
                                        <option value="Lain-lain" {{ old('sebab_pelupusan', $disposal->sebab_pelupusan ?? $disposal->justifikasi_pelupusan) == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
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
                                        <option value="Dijual" {{ old('kaedah_pelupusan', $disposal->kaedah_pelupusan ?? $disposal->kaedah_pelupusan_dicadang) == 'Dijual' ? 'selected' : '' }}>Dijual</option>
                                        <option value="Dibuang" {{ old('kaedah_pelupusan', $disposal->kaedah_pelupusan ?? $disposal->kaedah_pelupusan_dicadang) == 'Dibuang' ? 'selected' : '' }}>Dibuang</option>
                                        <option value="Dikitar semula" {{ old('kaedah_pelupusan', $disposal->kaedah_pelupusan ?? $disposal->kaedah_pelupusan_dicadang) == 'Dikitar semula' ? 'selected' : '' }}>Dikitar semula</option>
                                        <option value="Disumbangkan" {{ old('kaedah_pelupusan', $disposal->kaedah_pelupusan ?? $disposal->kaedah_pelupusan_dicadang) == 'Disumbangkan' ? 'selected' : '' }}>Disumbangkan</option>
                                        <option value="Dipindahkan" {{ old('kaedah_pelupusan', $disposal->kaedah_pelupusan ?? $disposal->kaedah_pelupusan_dicadang) == 'Dipindahkan' ? 'selected' : '' }}>Dipindahkan</option>
                                        <option value="Lain-lain" {{ old('kaedah_pelupusan', $disposal->kaedah_pelupusan ?? $disposal->kaedah_pelupusan_dicadang) == 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
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
                                    <input type="text" 
                                           id="nilai_pelupusan_display"
                                           value="{{ old('nilai_pelupusan', $disposal->nilai_pelupusan) ? number_format(old('nilai_pelupusan', $disposal->nilai_pelupusan), 2) : '' }}" 
                                           oninput="formatDisposalPriceEdit(event, 'nilai_pelupusan')"
                                           onblur="formatDisposalPriceBlurEdit(event, 'nilai_pelupusan')"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nilai_pelupusan') border-red-500 @enderror bg-white"
                                           placeholder="0.00">
                                    <input type="hidden"
                                           name="nilai_pelupusan" 
                                           id="nilai_pelupusan" 
                                           x-model="form.nilai_pelupusan">
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
                                    <input type="text" 
                                           id="nilai_baki_display"
                                           value="{{ old('nilai_baki', $disposal->nilai_baki) ? number_format(old('nilai_baki', $disposal->nilai_baki), 2) : '' }}" 
                                           oninput="formatDisposalPriceEdit(event, 'nilai_baki')"
                                           onblur="formatDisposalPriceBlurEdit(event, 'nilai_baki')"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nilai_baki') border-red-500 @enderror bg-white"
                                           placeholder="0.00">
                                    <input type="hidden"
                                           name="nilai_baki" 
                                           id="nilai_baki" 
                                           x-model="form.nilai_baki">
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
                                      placeholder="Masukkan catatan tambahan jika ada...">{{ old('catatan', $disposal->catatan ?? $disposal->catatan_pelupusan) }}</textarea>
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
                                <p class="text-sm text-amber-700">Kemaskini gambar atau dokumen sokongan</p>
                            </div>
                        </div>

                        <!-- Current Images -->
                        @if($disposal->gambar_pelupusan && count($disposal->gambar_pelupusan) > 0)
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                <i class='bx bx-image mr-1'></i>
                                Gambar/Dokumen Sedia Ada
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($disposal->gambar_pelupusan as $index => $image)
                                <div class="relative group">
                                    @if(in_array(strtolower(pathinfo($image, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                                    <img src="{{ Storage::url($image) }}" 
                                         alt="Gambar Pelupusan {{ $index + 1 }}" 
                                         class="w-full h-24 object-cover rounded-lg border border-gray-200">
                                    @else
                                    <div class="w-full h-24 bg-gray-100 rounded-lg border border-gray-200 flex flex-col items-center justify-center">
                                        <i class='bx bx-file text-2xl text-gray-400 mb-1'></i>
                                        <span class="text-xs text-gray-600 text-center px-1">{{ basename($image) }}</span>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- File Upload -->
                        <div>
                            <label for="gambar_pelupusan" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-upload mr-1'></i>
                                Tambah Gambar/Dokumen Baru
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

                        <!-- Notice -->
                        <div class="mt-6 p-4 bg-amber-50 rounded-lg border border-amber-200">
                            <div class="flex">
                                <i class='bx bx-info-circle text-amber-600 text-lg mt-0.5'></i>
                                <div class="ml-3">
                                    <p class="text-sm text-amber-800">
                                        <strong>Nota:</strong> Fail baru yang dimuat naik akan ditambah kepada dokumentasi sedia ada. Untuk menggantikan fail lama, sila hubungi pentadbir sistem.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Preview & Info -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        
                        <!-- Current Disposal Preview -->
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-100 rounded-xl p-6 border border-indigo-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-trash text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Pratonton Pelupusan</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                        <i class='bx bx-recycle text-red-600'></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900" x-text="selectedAsset.name || '{{ $disposal->asset->nama_aset ?? 'Nama Aset' }}'">{{ $disposal->asset->nama_aset ?? 'Nama Aset' }}</p>
                                        <p class="text-sm text-gray-500" x-text="selectedAsset.serial || '{{ $disposal->asset->no_siri_pendaftaran ?? 'No. Siri' }}'">{{ $disposal->asset->no_siri_pendaftaran ?? 'No. Siri' }}</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Tarikh:</span>
                                        <span class="text-sm font-medium" x-text="form.tarikh_pelupusan || '{{ ($disposal->tarikh_pelupusan ?? $disposal->tarikh_permohonan)?->format('d/m/Y') }}'">{{ ($disposal->tarikh_pelupusan ?? $disposal->tarikh_permohonan)?->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Sebab:</span>
                                        <span class="text-sm font-medium" x-text="form.sebab_pelupusan || '{{ $disposal->sebab_pelupusan ?? $disposal->justifikasi_pelupusan ?? '-' }}'">{{ $disposal->sebab_pelupusan ?? $disposal->justifikasi_pelupusan ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Kaedah:</span>
                                        <span class="text-sm font-medium" x-text="form.kaedah_pelupusan || '{{ $disposal->kaedah_pelupusan ?? $disposal->kaedah_pelupusan_dicadang ?? '-' }}'">{{ $disposal->kaedah_pelupusan ?? $disposal->kaedah_pelupusan_dicadang ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Nilai:</span>
                                        <span class="text-sm font-medium" x-text="form.nilai_pelupusan ? 'RM ' + parseFloat(form.nilai_pelupusan).toLocaleString() : 'RM {{ number_format($disposal->nilai_pelupusan ?? 0, 2) }}'">RM {{ number_format($disposal->nilai_pelupusan ?? 0, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Summary -->
                        <div class="bg-white rounded-xl p-6 border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Aktiviti</h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Status:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        @if(($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') === 'menunggu') bg-amber-100 text-amber-800
                                        @elseif(($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') === 'diluluskan') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        <div class="w-2 h-2 
                                            @if(($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') === 'menunggu') bg-amber-500
                                            @elseif(($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') === 'diluluskan') bg-green-500
                                            @else bg-red-500 @endif rounded-full mr-1"></div>
                                        {{ ucfirst($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">ID Pelupusan:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        #{{ str_pad($disposal->id, 4, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Dicipta:</span>
                                    <span class="text-sm font-medium">{{ $disposal->created_at->format('d/m/Y') }}</span>
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
                                <a href="{{ route('admin.disposals.show', $disposal) }}" 
                                   class="w-full flex items-center justify-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg transition-colors">
                                    <i class='bx bx-show mr-2'></i>
                                    Lihat Detail
                                </a>
                                
                                <a href="{{ route('admin.assets.show', $disposal->asset) }}" 
                                   class="w-full flex items-center justify-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                                    <i class='bx bx-package mr-2'></i>
                                    Lihat Aset
                                </a>
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
                        Kemaskini terakhir: {{ $disposal->updated_at->format('d/m/Y H:i') }}
                    </div>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.disposals.show', $disposal) }}" 
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
    function editDisposalForm() {
        return {
            form: {
                asset_id: '{{ old('asset_id', $disposal->asset_id) }}',
                tarikh_pelupusan: '{{ old('tarikh_pelupusan', ($disposal->tarikh_pelupusan ?? $disposal->tarikh_permohonan)?->format('Y-m-d')) }}',
                sebab_pelupusan: '{{ old('sebab_pelupusan', $disposal->sebab_pelupusan ?? $disposal->justifikasi_pelupusan) }}',
                kaedah_pelupusan: '{{ old('kaedah_pelupusan', $disposal->kaedah_pelupusan ?? $disposal->kaedah_pelupusan_dicadang) }}',
                nilai_pelupusan: '{{ old('nilai_pelupusan', $disposal->nilai_pelupusan) }}',
                nilai_baki: '{{ old('nilai_baki', $disposal->nilai_baki) }}',
                catatan: '{{ old('catatan', $disposal->catatan ?? $disposal->catatan_pelupusan) }}'
            },
            selectedAsset: {
                name: '{{ $disposal->asset->nama_aset ?? '' }}',
                serial: '{{ $disposal->asset->no_siri_pendaftaran ?? '' }}',
                type: '{{ $disposal->asset->jenis_aset ?? '' }}',
                value: '{{ $disposal->asset->nilai_perolehan ?? '' }}',
                location: '{{ $disposal->asset->lokasi_penempatan ?? '' }}',
                masjid: '{{ $disposal->asset->masjidSurau->nama ?? '' }}'
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
                }
            }
        }
    }

    // File upload validation
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

    // Format number with thousand separators and 2 decimals
    function formatCurrency(value) {
        if (!value && value !== 0) return '';
        const num = parseFloat(value.toString().replace(/,/g, ''));
        if (isNaN(num)) return '';
        return num.toLocaleString('en-US', { 
            minimumFractionDigits: 2, 
            maximumFractionDigits: 2 
        });
    }

    // Price formatting - during input
    function formatDisposalPriceEdit(event, fieldName) {
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
        
        // Validate min value
        const numValue = parseFloat(value);
        if (numValue < 0) {
            value = '0';
        }
        
        // Update the display
        input.value = value;
        
        // Update hidden field
        const hiddenField = document.getElementById(fieldName);
        if (hiddenField) {
            hiddenField.value = value;
            // Trigger Alpine.js model update
            hiddenField.dispatchEvent(new Event('input'));
        }
    }

    // Price formatting - on blur (final formatting)
    function formatDisposalPriceBlurEdit(event, fieldName) {
        const input = event.target;
        const rawValue = input.value.replace(/,/g, '');
        const numValue = parseFloat(rawValue) || 0;
        
        // Update visible input with formatted value
        input.value = formatCurrency(numValue);
        
        // Update hidden field with raw value
        const hiddenField = document.getElementById(fieldName);
        if (hiddenField) {
            hiddenField.value = numValue.toFixed(2);
            // Trigger Alpine.js model update
            hiddenField.dispatchEvent(new Event('input'));
        }
    }

    // Auto-calculate remaining value suggestion
    document.getElementById('nilai_pelupusan').addEventListener('input', function() {
        const assetSelect = document.getElementById('asset_id');
        const selectedOption = assetSelect.options[assetSelect.selectedIndex];
        const nilaiBalakInput = document.getElementById('nilai_baki');
        
        if (selectedOption && selectedOption.dataset.value && this.value) {
            const originalValue = parseFloat(selectedOption.dataset.value);
            const disposalValue = parseFloat(this.value);
            const remainingValue = Math.max(0, originalValue - disposalValue);
            
            if (!nilaiBalakInput.value || nilaiBalakInput.value == 0) {
                nilaiBalakInput.value = remainingValue.toFixed(2);
                // Update Alpine.js model
                nilaiBalakInput.dispatchEvent(new Event('input'));
            }
        }
    });
</script>
@endpush
@endsection 