@extends('layouts.admin')

@section('title', 'Edit Laporan Kehilangan')
@section('page-title', 'Edit Laporan Kehilangan')
@section('page-description', 'Kemaskini maklumat laporan kehilangan')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Edit Laporan Kehilangan</h1>
                <p class="text-emerald-100 text-lg">Kemaskini maklumat untuk {{ $lossWriteoff->asset->nama_aset }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-edit text-emerald-200'></i>
                        <span class="text-emerald-100">Kemaskini Laporan</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 
                            @if($lossWriteoff->status_kelulusan === 'menunggu') bg-amber-400
                            @elseif($lossWriteoff->status_kelulusan === 'diluluskan') bg-green-400
                            @else bg-red-400 @endif rounded-full"></div>
                        <span class="text-emerald-100">{{ ucfirst($lossWriteoff->status_kelulusan) }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-error-circle text-6xl text-emerald-200'></i>
            </div>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <div class="flex items-center space-x-2 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600">
            <i class='bx bx-home'></i>
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <a href="{{ route('admin.loss-writeoffs.index') }}" class="text-gray-500 hover:text-emerald-600">
            Kehilangan & Hapus Kira
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">Edit: {{ $lossWriteoff->asset->nama_aset }}</span>
    </div>

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.loss-writeoffs.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
            <i class='bx bx-arrow-back mr-2'></i>
            Kembali ke Senarai Laporan
        </a>
    </div>

    <!-- Form Card - Full Width -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <form action="{{ route('admin.loss-writeoffs.update', $lossWriteoff) }}" method="POST" enctype="multipart/form-data" x-data="editLossForm()" class="space-y-0">
            @csrf
            @method('PUT')

            <!-- Form Header -->
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-red-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Kemaskini Laporan Kehilangan</h2>
                        <p class="text-sm text-gray-600">Edit dan kemaskini maklumat laporan kehilangan dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                            @if($lossWriteoff->status_kelulusan === 'menunggu') bg-amber-100 text-amber-800
                            @elseif($lossWriteoff->status_kelulusan === 'diluluskan') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            <div class="w-2 h-2 
                                @if($lossWriteoff->status_kelulusan === 'menunggu') bg-amber-500
                                @elseif($lossWriteoff->status_kelulusan === 'diluluskan') bg-green-500
                                @else bg-red-500 @endif rounded-full mr-2"></div>
                            {{ ucfirst($lossWriteoff->status_kelulusan) }}
                        </span>
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                            @if($lossWriteoff->jenis_kehilangan === 'Kehilangan') bg-yellow-100 text-yellow-800
                            @elseif($lossWriteoff->jenis_kehilangan === 'Kecurian') bg-red-100 text-red-800
                            @elseif($lossWriteoff->jenis_kehilangan === 'Kerosakan') bg-orange-100 text-orange-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $lossWriteoff->jenis_kehilangan }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Form Content - Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-6">
                
                <!-- Left Column - Main Form -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Asset Information Section -->
                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-cube text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Maklumat Aset</h3>
                                <p class="text-sm text-emerald-700">Aset yang dilaporkan hilang</p>
                            </div>
                        </div>
                        
                        <div>
                            <label for="asset_id" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-cube mr-1'></i>
                                Aset <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="asset_id" 
                                        id="asset_id" 
                                        required
                                        x-model="form.asset_id"
                                        @change="updateAssetInfo()"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('asset_id') border-red-500 @enderror bg-white">
                                    <option value="">Pilih Aset</option>
                                    @foreach($assets as $asset)
                                        <option value="{{ $asset->id }}" 
                                                data-name="{{ $asset->nama_aset }}"
                                                data-serial="{{ $asset->no_siri_pendaftaran }}"
                                                data-value="{{ $asset->nilai_semasa ?? $asset->nilai_perolehan }}"
                                                data-location="{{ $asset->masjidSurau->nama ?? '' }}"
                                                {{ old('asset_id', $lossWriteoff->asset_id) == $asset->id ? 'selected' : '' }}>
                                            {{ $asset->nama_aset }} - {{ $asset->no_siri_pendaftaran }} ({{ $asset->masjidSurau->nama ?? '' }})
                                        </option>
                                    @endforeach
                                </select>
                                <i class='bx bx-cube absolute left-3 top-3.5 text-gray-400'></i>
                            </div>
                            @error('asset_id')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class='bx bx-error-circle mr-1'></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Loss Details Section -->
                    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 border border-red-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-error-circle text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Butiran Kehilangan</h3>
                                <p class="text-sm text-red-700">Kemaskini maklumat terperinci mengenai kehilangan aset</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Loss Type -->
                            <div>
                                <label for="jenis_kehilangan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-error mr-1'></i>
                                    Jenis Kehilangan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="jenis_kehilangan" 
                                            id="jenis_kehilangan" 
                                            required
                                            x-model="form.jenis_kehilangan"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jenis_kehilangan') border-red-500 @enderror bg-white">
                                        <option value="">Pilih Jenis</option>
                                        <option value="Kehilangan" {{ old('jenis_kehilangan', $lossWriteoff->jenis_kehilangan) == 'Kehilangan' ? 'selected' : '' }}>Kehilangan</option>
                                        <option value="Kecurian" {{ old('jenis_kehilangan', $lossWriteoff->jenis_kehilangan) == 'Kecurian' ? 'selected' : '' }}>Kecurian</option>
                                        <option value="Kerosakan" {{ old('jenis_kehilangan', $lossWriteoff->jenis_kehilangan) == 'Kerosakan' ? 'selected' : '' }}>Kerosakan</option>
                                        <option value="Kemalangan" {{ old('jenis_kehilangan', $lossWriteoff->jenis_kehilangan) == 'Kemalangan' ? 'selected' : '' }}>Kemalangan</option>
                                        <option value="Hapus Kira" {{ old('jenis_kehilangan', $lossWriteoff->jenis_kehilangan) == 'Hapus Kira' ? 'selected' : '' }}>Hapus Kira</option>
                                    </select>
                                    <i class='bx bx-error absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('jenis_kehilangan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Loss Date -->
                            <div>
                                <label for="tarikh_kehilangan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-calendar mr-1'></i>
                                    Tarikh Kehilangan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="date" 
                                           name="tarikh_kehilangan" 
                                           id="tarikh_kehilangan" 
                                           value="{{ old('tarikh_kehilangan', $lossWriteoff->tarikh_kehilangan->format('Y-m-d')) }}" 
                                           required
                                           x-model="form.tarikh_kehilangan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_kehilangan') border-red-500 @enderror bg-white">
                                    <i class='bx bx-calendar absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('tarikh_kehilangan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Loss Reason -->
                            <div>
                                <label for="sebab_kehilangan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-message-detail mr-1'></i>
                                    Sebab Kehilangan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           name="sebab_kehilangan" 
                                           id="sebab_kehilangan" 
                                           value="{{ old('sebab_kehilangan', $lossWriteoff->sebab_kehilangan) }}" 
                                           required
                                           x-model="form.sebab_kehilangan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('sebab_kehilangan') border-red-500 @enderror bg-white"
                                           placeholder="Contoh: Cuaca buruk, kegagalan sistem, kecuaian...">
                                    <i class='bx bx-message-detail absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('sebab_kehilangan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Loss Value -->
                            <div>
                                <label for="nilai_kehilangan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-money mr-1'></i>
                                    Nilai Kerugian (RM) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           name="nilai_kehilangan" 
                                           id="nilai_kehilangan" 
                                           value="{{ old('nilai_kehilangan', $lossWriteoff->nilai_kehilangan) }}" 
                                           step="0.01" 
                                           min="0" 
                                           required
                                           x-model="form.nilai_kehilangan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nilai_kehilangan') border-red-500 @enderror bg-white">
                                    <i class='bx bx-money absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('nilai_kehilangan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Loss Location -->
                            <div>
                                <label for="lokasi_kehilangan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-map mr-1'></i>
                                    Lokasi Kehilangan
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           name="lokasi_kehilangan" 
                                           id="lokasi_kehilangan" 
                                           value="{{ old('lokasi_kehilangan', $lossWriteoff->lokasi_kehilangan) }}"
                                           x-model="form.lokasi_kehilangan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('lokasi_kehilangan') border-red-500 @enderror bg-white"
                                           placeholder="Lokasi di mana aset hilang">
                                    <i class='bx bx-map absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('lokasi_kehilangan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Police Report Number -->
                            <div>
                                <label for="laporan_polis" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-shield mr-1'></i>
                                    No. Laporan Polis
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           name="laporan_polis" 
                                           id="laporan_polis" 
                                           value="{{ old('laporan_polis', $lossWriteoff->laporan_polis) }}"
                                           x-model="form.laporan_polis"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('laporan_polis') border-red-500 @enderror bg-white"
                                           placeholder="Diperlukan untuk kecurian">
                                    <i class='bx bx-shield absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('laporan_polis')
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
                                      placeholder="Butiran tambahan mengenai kehilangan aset...">{{ old('catatan', $lossWriteoff->catatan) }}</textarea>
                            @error('catatan')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class='bx bx-error-circle mr-1'></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Documentation Section -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-file text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Dokumen Sokongan</h3>
                                <p class="text-sm text-blue-700">Kemaskini dokumen yang berkaitan</p>
                            </div>
                        </div>
                        
                        <!-- Existing Documents -->
                        @if($lossWriteoff->dokumen_kehilangan)
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Dokumen Sedia Ada</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    @foreach(json_decode($lossWriteoff->dokumen_kehilangan, true) as $index => $document)
                                        <div class="flex items-center p-3 bg-white rounded-lg border border-gray-200">
                                            <i class='bx bx-file text-blue-500 text-xl mr-3'></i>
                                            <div class="flex-1">
                                                <p class="text-sm font-medium text-gray-900">Dokumen {{ $index + 1 }}</p>
                                                <p class="text-xs text-gray-500">{{ basename($document) }}</p>
                                            </div>
                                            <a href="{{ Storage::url($document) }}" target="_blank" 
                                               class="text-blue-600 hover:text-blue-800">
                                                <i class='bx bx-download'></i>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Upload New Documents -->
                        <div>
                            <label for="dokumen_kehilangan" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-file mr-1'></i>
                                Tambah Dokumen Baharu
                            </label>
                            <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 hover:border-blue-400 transition-colors">
                                <input type="file" 
                                       name="dokumen_kehilangan[]" 
                                       id="dokumen_kehilangan" 
                                       multiple 
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                       @change="handleFileUpload($event)">
                                <div class="text-center">
                                    <i class='bx bx-cloud-upload text-4xl text-gray-400 mb-2'></i>
                                    <p class="text-sm text-gray-600 mb-1">Klik untuk memilih fail atau seret ke sini</p>
                                    <p class="text-xs text-gray-500">PDF, DOC, JPG, PNG (Maksimum 5MB setiap fail)</p>
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Dokumen baharu akan ditambah kepada dokumen sedia ada</p>
                            @error('dokumen_kehilangan')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class='bx bx-error-circle mr-1'></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Status Notice -->
                        @if($lossWriteoff->status_kelulusan === 'menunggu')
                            <div class="mt-6 bg-amber-50 border border-amber-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <i class='bx bx-time text-amber-600 text-xl mr-3 mt-0.5'></i>
                                    <div>
                                        <h4 class="text-sm font-medium text-amber-800 mb-1">Status: Menunggu Kelulusan</h4>
                                        <p class="text-sm text-amber-700">
                                            Laporan ini masih menunggu kelulusan. Anda boleh mengemaskini maklumat sebelum ia diluluskan.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @elseif($lossWriteoff->status_kelulusan === 'diluluskan')
                            <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-start">
                                    <i class='bx bx-check-circle text-green-600 text-xl mr-3 mt-0.5'></i>
                                    <div>
                                        <h4 class="text-sm font-medium text-green-800 mb-1">Status: Diluluskan</h4>
                                        <p class="text-sm text-green-700">
                                            Laporan ini telah diluluskan. Sebarang perubahan memerlukan kelulusan semula.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Preview & Info -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        
                        <!-- Current Loss Preview -->
                        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 border border-red-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-error-circle text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Pratonton Laporan</h3>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Nama Aset:</span>
                                    <span class="text-sm font-medium" x-text="form.asset_name || '{{ $lossWriteoff->asset->nama_aset }}'">{{ $lossWriteoff->asset->nama_aset }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">No. Siri:</span>
                                    <span class="text-sm font-medium" x-text="form.asset_serial || '{{ $lossWriteoff->asset->no_siri_pendaftaran }}'">{{ $lossWriteoff->asset->no_siri_pendaftaran }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Jenis:</span>
                                    <span class="text-sm font-medium" x-text="form.jenis_kehilangan || '{{ $lossWriteoff->jenis_kehilangan }}'">{{ $lossWriteoff->jenis_kehilangan }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-gray-600">Nilai Kerugian:</span>
                                    <span class="text-sm font-medium text-red-600" x-text="form.nilai_kehilangan ? 'RM ' + parseFloat(form.nilai_kehilangan).toLocaleString() : 'RM {{ number_format($lossWriteoff->nilai_kehilangan, 2) }}'">RM {{ number_format($lossWriteoff->nilai_kehilangan, 2) }}</span>
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
                                        @if($lossWriteoff->status_kelulusan === 'menunggu') bg-amber-100 text-amber-800
                                        @elseif($lossWriteoff->status_kelulusan === 'diluluskan') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        <div class="w-2 h-2 
                                            @if($lossWriteoff->status_kelulusan === 'menunggu') bg-amber-500
                                            @elseif($lossWriteoff->status_kelulusan === 'diluluskan') bg-green-500
                                            @else bg-red-500 @endif rounded-full mr-1"></div>
                                        {{ ucfirst($lossWriteoff->status_kelulusan) }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Jenis:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        @if($lossWriteoff->jenis_kehilangan === 'Kehilangan') bg-yellow-100 text-yellow-800
                                        @elseif($lossWriteoff->jenis_kehilangan === 'Kecurian') bg-red-100 text-red-800
                                        @elseif($lossWriteoff->jenis_kehilangan === 'Kerosakan') bg-orange-100 text-orange-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ $lossWriteoff->jenis_kehilangan }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Dilaporkan:</span>
                                    <span class="text-sm font-medium">{{ $lossWriteoff->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Tarikh Kehilangan:</span>
                                    <span class="text-sm font-medium">{{ $lossWriteoff->tarikh_kehilangan->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-gradient-to-br from-emerald-50 to-green-100 rounded-xl p-6 border border-emerald-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-cog text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Tindakan Pantas</h3>
                            </div>
                            
                            <div class="space-y-3">
                                <a href="{{ route('admin.loss-writeoffs.show', $lossWriteoff) }}" 
                                   class="w-full flex items-center justify-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg transition-colors">
                                    <i class='bx bx-show mr-2'></i>
                                    Lihat Detail
                                </a>
                                
                                @if($lossWriteoff->status_kelulusan === 'menunggu' && auth()->user()->role === 'admin')
                                <form action="{{ route('admin.loss-writeoffs.approve', $lossWriteoff) }}" method="POST" class="w-full">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full flex items-center justify-center px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors"
                                            onclick="return confirm('Luluskan laporan kehilangan ini?')">
                                        <i class='bx bx-check mr-2'></i>
                                        Luluskan Laporan
                                    </button>
                                </form>
                                @endif
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
                        Kemaskini terakhir: {{ $lossWriteoff->updated_at->format('d/m/Y H:i') }}
                    </div>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.loss-writeoffs.index') }}" 
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
    function editLossForm() {
        return {
            form: {
                asset_id: '{{ old('asset_id', $lossWriteoff->asset_id) }}',
                asset_name: '{{ $lossWriteoff->asset->nama_aset }}',
                asset_serial: '{{ $lossWriteoff->asset->no_siri_pendaftaran }}',
                asset_value: '{{ $lossWriteoff->asset->nilai_semasa ?? $lossWriteoff->asset->nilai_perolehan }}',
                asset_location: '{{ $lossWriteoff->asset->masjidSurau->nama ?? '' }}',
                jenis_kehilangan: '{{ old('jenis_kehilangan', $lossWriteoff->jenis_kehilangan) }}',
                tarikh_kehilangan: '{{ old('tarikh_kehilangan', $lossWriteoff->tarikh_kehilangan->format('Y-m-d')) }}',
                sebab_kehilangan: '{{ old('sebab_kehilangan', $lossWriteoff->sebab_kehilangan) }}',
                nilai_kehilangan: '{{ old('nilai_kehilangan', $lossWriteoff->nilai_kehilangan) }}',
                lokasi_kehilangan: '{{ old('lokasi_kehilangan', $lossWriteoff->lokasi_kehilangan) }}',
                laporan_polis: '{{ old('laporan_polis', $lossWriteoff->laporan_polis) }}',
                catatan: '{{ old('catatan', $lossWriteoff->catatan) }}'
            },
            
            updateAssetInfo() {
                const select = document.getElementById('asset_id');
                const selectedOption = select.options[select.selectedIndex];
                
                if (selectedOption && selectedOption.value) {
                    this.form.asset_name = selectedOption.dataset.name || '';
                    this.form.asset_serial = selectedOption.dataset.serial || '';
                    this.form.asset_value = selectedOption.dataset.value || '';
                    this.form.asset_location = selectedOption.dataset.location || '';
                } else {
                    // Keep original values if no selection
                    this.form.asset_name = '{{ $lossWriteoff->asset->nama_aset }}';
                    this.form.asset_serial = '{{ $lossWriteoff->asset->no_siri_pendaftaran }}';
                    this.form.asset_value = '{{ $lossWriteoff->asset->nilai_semasa ?? $lossWriteoff->asset->nilai_perolehan }}';
                    this.form.asset_location = '{{ $lossWriteoff->asset->masjidSurau->nama ?? '' }}';
                }
            },
            
            handleFileUpload(event) {
                const files = event.target.files;
                console.log('Files selected:', files.length);
                // You can add file validation here if needed
            }
        }
    }
</script>
@endpush
@endsection
