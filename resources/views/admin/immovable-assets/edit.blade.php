@extends('layouts.admin')

@section('title', 'Edit Aset Tak Alih')
@section('page-title', 'Edit Aset Tak Alih')
@section('page-description', 'Kemaskini maklumat aset tak alih')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Edit Aset Tak Alih</h1>
                <p class="text-emerald-100 text-lg">Kemaskini maklumat untuk {{ $immovableAsset->nama_aset }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-edit text-emerald-200'></i>
                        <span class="text-emerald-100">Kemaskini Data</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 
                            @if($immovableAsset->keadaan_semasa === 'Sangat Baik' || $immovableAsset->keadaan_semasa === 'Baik') bg-green-400
                            @elseif($immovableAsset->keadaan_semasa === 'Sederhana') bg-yellow-400
                            @else bg-red-400 @endif rounded-full"></div>
                        <span class="text-emerald-100">{{ $immovableAsset->keadaan_semasa }}</span>
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
        <a href="{{ route('admin.immovable-assets.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Aset Tak Alih
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">Edit: {{ $immovableAsset->nama_aset }}</span>
    </div>



    <!-- Form Card - Full Width -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <form action="{{ route('admin.immovable-assets.update', $immovableAsset) }}" method="POST" enctype="multipart/form-data" x-data="editAssetForm()" class="space-y-0">
            @csrf
            @method('PUT')

            <!-- Form Header -->
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Kemaskini Maklumat Aset Tak Alih</h2>
                        <p class="text-sm text-gray-600">Edit dan kemaskini maklumat aset tak alih dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                            @if($immovableAsset->keadaan_semasa === 'Sangat Baik' || $immovableAsset->keadaan_semasa === 'Baik') bg-green-100 text-green-800
                            @elseif($immovableAsset->keadaan_semasa === 'Sederhana') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            <div class="w-2 h-2 
                                @if($immovableAsset->keadaan_semasa === 'Sangat Baik' || $immovableAsset->keadaan_semasa === 'Baik') bg-green-500
                                @elseif($immovableAsset->keadaan_semasa === 'Sederhana') bg-yellow-500
                                @else bg-red-500 @endif rounded-full mr-2"></div>
                            {{ $immovableAsset->keadaan_semasa }}
                        </span>
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                            {{ $immovableAsset->jenis_aset }}
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
                                <i class='bx bx-buildings text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Maklumat Aset</h3>
                                <p class="text-sm text-emerald-700">Kemaskini maklumat asas aset tak alih</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Asset Name -->
                            <div>
                                <label for="nama_aset" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-buildings mr-1'></i>
                                    Nama Aset <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="nama_aset" 
                                           name="nama_aset" 
                                           value="{{ old('nama_aset', $immovableAsset->nama_aset) }}"
                                           required
                                           x-model="form.nama_aset"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nama_aset') border-red-500 @enderror bg-white"
                                           placeholder="Masukkan nama aset">
                                    <i class='bx bx-buildings absolute left-3 top-3.5 text-gray-400'></i>
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
                                    <select id="jenis_aset" 
                                            name="jenis_aset" 
                                            required
                                            x-model="form.jenis_aset"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jenis_aset') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Jenis Aset</option>
                                        <option value="Tanah" {{ old('jenis_aset', $immovableAsset->jenis_aset) === 'Tanah' ? 'selected' : '' }}>Tanah</option>
                                        <option value="Bangunan" {{ old('jenis_aset', $immovableAsset->jenis_aset) === 'Bangunan' ? 'selected' : '' }}>Bangunan</option>
                                        <option value="Tanah dan Bangunan" {{ old('jenis_aset', $immovableAsset->jenis_aset) === 'Tanah dan Bangunan' ? 'selected' : '' }}>Tanah dan Bangunan</option>
                                    </select>
                                    <i class='bx bx-category absolute left-3 top-3.5 text-gray-400'></i>
                                    <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('jenis_aset')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Masjid/Surau -->
                            <div class="md:col-span-2">
                                <label for="masjid_surau_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-building mr-1'></i>
                                    Masjid/Surau <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="masjid_surau_id" 
                                            name="masjid_surau_id" 
                                            required
                                            x-model="form.masjid_surau_id"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('masjid_surau_id') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Masjid/Surau</option>
                                        @foreach($masjidSuraus as $masjidSurau)
                                            <option value="{{ $masjidSurau->id }}" {{ old('masjid_surau_id', $immovableAsset->masjid_surau_id) == $masjidSurau->id ? 'selected' : '' }}>
                                                {{ $masjidSurau->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class='bx bx-building absolute left-3 top-3.5 text-gray-400'></i>
                                    <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('masjid_surau_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="md:col-span-2">
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-map mr-1'></i>
                                    Alamat
                                </label>
                                <div class="relative">
                                    <textarea id="alamat" 
                                              name="alamat" 
                                              rows="3"
                                              x-model="form.alamat"
                                              class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('alamat') border-red-500 @enderror bg-white"
                                              placeholder="Masukkan alamat lengkap aset">{{ old('alamat', $immovableAsset->alamat) }}</textarea>
                                    <i class='bx bx-map absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('alamat')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Ownership and Property Details Section -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-file-contract text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Hakmilik & Ukuran</h3>
                                <p class="text-sm text-purple-700">Kemaskini maklumat hakmilik dan saiz aset</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Title Number -->
                            <div>
                                <label for="no_hakmilik" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-file mr-1'></i>
                                    No. Hakmilik
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="no_hakmilik" 
                                           name="no_hakmilik" 
                                           value="{{ old('no_hakmilik', $immovableAsset->no_hakmilik) }}"
                                           x-model="form.no_hakmilik"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('no_hakmilik') border-red-500 @enderror bg-white"
                                           placeholder="Masukkan no. hakmilik">
                                    <i class='bx bx-file absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('no_hakmilik')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Lot Number -->
                            <div>
                                <label for="no_lot" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-map-pin mr-1'></i>
                                    No. Lot
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="no_lot" 
                                           name="no_lot" 
                                           value="{{ old('no_lot', $immovableAsset->no_lot) }}"
                                           x-model="form.no_lot"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('no_lot') border-red-500 @enderror bg-white"
                                           placeholder="Masukkan no. lot">
                                    <i class='bx bx-map-pin absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('no_lot')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Area -->
                            <div>
                                <label for="luas_tanah_bangunan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-vector mr-1'></i>
                                    Luas (meter persegi) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           step="0.01"
                                           id="luas_tanah_bangunan" 
                                           name="luas_tanah_bangunan" 
                                           value="{{ old('luas_tanah_bangunan', $immovableAsset->luas_tanah_bangunan) }}"
                                           required
                                           x-model="form.luas_tanah_bangunan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('luas_tanah_bangunan') border-red-500 @enderror bg-white"
                                           placeholder="0.00">
                                    <i class='bx bx-vector absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('luas_tanah_bangunan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-1 text-xs text-purple-600 flex items-center">
                                    <i class='bx bx-info-circle mr-1'></i>
                                    Ukuran dalam meter persegi (m²)
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Acquisition and Condition Section -->
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-handshake text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Perolehan & Keadaan</h3>
                                <p class="text-sm text-amber-700">Kemaskini maklumat perolehan dan keadaan semasa</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
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
                                           value="{{ old('tarikh_perolehan', $immovableAsset->tarikh_perolehan ? $immovableAsset->tarikh_perolehan->format('Y-m-d') : '') }}"
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

                            <!-- Acquisition Source -->
                            <div>
                                <label for="sumber_perolehan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-source mr-1'></i>
                                    Sumber Perolehan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="sumber_perolehan" 
                                            name="sumber_perolehan" 
                                            required
                                            x-model="form.sumber_perolehan"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('sumber_perolehan') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Sumber Perolehan</option>
                                        <option value="Pembelian" {{ old('sumber_perolehan', $immovableAsset->sumber_perolehan) === 'Pembelian' ? 'selected' : '' }}>Pembelian</option>
                                        <option value="Hibah" {{ old('sumber_perolehan', $immovableAsset->sumber_perolehan) === 'Hibah' ? 'selected' : '' }}>Hibah</option>
                                        <option value="Wakaf" {{ old('sumber_perolehan', $immovableAsset->sumber_perolehan) === 'Wakaf' ? 'selected' : '' }}>Wakaf</option>
                                        <option value="Derma" {{ old('sumber_perolehan', $immovableAsset->sumber_perolehan) === 'Derma' ? 'selected' : '' }}>Derma</option>
                                        <option value="Lain-lain" {{ old('sumber_perolehan', $immovableAsset->sumber_perolehan) === 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                                    </select>
                                    <i class='bx bx-source absolute left-3 top-3.5 text-gray-400'></i>
                                    <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('sumber_perolehan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Acquisition Cost -->
                            <div>
                                <label for="kos_perolehan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-dollar mr-1'></i>
                                    Kos Perolehan (RM) <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           step="0.01"
                                           id="kos_perolehan" 
                                           name="kos_perolehan" 
                                           value="{{ old('kos_perolehan', $immovableAsset->kos_perolehan) }}"
                                           required
                                           x-model="form.kos_perolehan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kos_perolehan') border-red-500 @enderror bg-white"
                                           placeholder="0.00">
                                    <i class='bx bx-dollar absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('kos_perolehan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Current Condition -->
                            <div>
                                <label for="keadaan_semasa" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-check-circle mr-1'></i>
                                    Keadaan Semasa <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="keadaan_semasa" 
                                            name="keadaan_semasa" 
                                            required
                                            x-model="form.keadaan_semasa"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('keadaan_semasa') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Keadaan Semasa</option>
                                        <option value="Sangat Baik" {{ old('keadaan_semasa', $immovableAsset->keadaan_semasa) === 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik</option>
                                        <option value="Baik" {{ old('keadaan_semasa', $immovableAsset->keadaan_semasa) === 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Sederhana" {{ old('keadaan_semasa', $immovableAsset->keadaan_semasa) === 'Sederhana' ? 'selected' : '' }}>Sederhana</option>
                                        <option value="Perlu Pembaikan" {{ old('keadaan_semasa', $immovableAsset->keadaan_semasa) === 'Perlu Pembaikan' ? 'selected' : '' }}>Perlu Pembaikan</option>
                                        <option value="Rosak" {{ old('keadaan_semasa', $immovableAsset->keadaan_semasa) === 'Rosak' ? 'selected' : '' }}>Rosak</option>
                                    </select>
                                    <i class='bx bx-check-circle absolute left-3 top-3.5 text-gray-400'></i>
                                    <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('keadaan_semasa')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-1 text-xs text-amber-600 flex items-center">
                                    <i class='bx bx-info-circle mr-1'></i>
                                    Penilaian keadaan fizikal aset pada masa ini
                                </p>
                            </div>
                        </div>

                        <!-- Images -->
                        <div class="mb-6">
                            <label for="gambar_aset" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-images mr-1'></i>
                                Gambar Aset
                            </label>
                            
                            @if($immovableAsset->gambar_aset && count($immovableAsset->gambar_aset) > 0)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Gambar Sedia Ada:</p>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                    @foreach($immovableAsset->gambar_aset as $index => $gambar)
                                    <div class="relative group">
                                        <img src="{{ Storage::url($gambar) }}" 
                                             alt="Gambar Aset" 
                                             class="w-full h-24 object-cover rounded-lg">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity rounded-lg flex items-center justify-center">
                                            <button type="button" onclick="removeImage({{ $index }})"
                                                    class="text-white opacity-0 group-hover:opacity-100 transition-opacity bg-red-500 rounded-full p-2">
                                                <i class='bx bx-trash text-sm'></i>
                                            </button>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            <div class="relative">
                                <input type="file" 
                                       id="gambar_aset" 
                                       name="gambar_aset[]" 
                                       multiple 
                                       accept="image/*"
                                       class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('gambar_aset') border-red-500 @enderror bg-white">
                                <i class='bx bx-images absolute left-3 top-3.5 text-gray-400'></i>
                            </div>
                            <p class="mt-1 text-xs text-amber-600">Format yang diterima: JPEG, PNG, JPG. Maksimum 2MB setiap fail.</p>
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
                            <div class="relative">
                                <textarea id="catatan" 
                                          name="catatan" 
                                          rows="4"
                                          x-model="form.catatan"
                                          class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('catatan') border-red-500 @enderror bg-white"
                                          placeholder="Masukkan catatan tambahan jika ada">{{ old('catatan', $immovableAsset->catatan) }}</textarea>
                                <i class='bx bx-note absolute left-3 top-3.5 text-gray-400'></i>
                            </div>
                            @error('catatan')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class='bx bx-error-circle mr-1'></i>
                                    {{ $message }}
                                </p>
                            @enderror
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
                                    <i class='bx bx-buildings text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Pratonton Aset</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                        <i class='bx bx-buildings text-emerald-700 text-xl'></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900" x-text="form.nama_aset || '{{ $immovableAsset->nama_aset }}'">{{ $immovableAsset->nama_aset }}</p>
                                        <p class="text-sm text-gray-500" x-text="form.jenis_aset || '{{ $immovableAsset->jenis_aset }}'">{{ $immovableAsset->jenis_aset }}</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Luas:</span>
                                        <span class="text-sm font-medium" x-text="(form.luas_tanah_bangunan || '{{ $immovableAsset->luas_tanah_bangunan }}') + ' m²'">{{ $immovableAsset->luas_tanah_bangunan }} m²</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Keadaan:</span>
                                        <span class="text-sm font-medium" x-text="form.keadaan_semasa || '{{ $immovableAsset->keadaan_semasa }}'">{{ $immovableAsset->keadaan_semasa }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Kos Perolehan:</span>
                                        <span class="text-sm font-medium" x-text="'RM ' + (form.kos_perolehan || '{{ number_format($immovableAsset->kos_perolehan, 2) }}')">RM {{ number_format($immovableAsset->kos_perolehan, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Asset Summary -->
                        <div class="bg-white rounded-xl p-6 border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Aset</h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Status Keadaan:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                        @if($immovableAsset->keadaan_semasa === 'Sangat Baik' || $immovableAsset->keadaan_semasa === 'Baik') bg-green-100 text-green-800
                                        @elseif($immovableAsset->keadaan_semasa === 'Sederhana') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        <div class="w-2 h-2 
                                            @if($immovableAsset->keadaan_semasa === 'Sangat Baik' || $immovableAsset->keadaan_semasa === 'Baik') bg-green-500
                                            @elseif($immovableAsset->keadaan_semasa === 'Sederhana') bg-yellow-500
                                            @else bg-red-500 @endif rounded-full mr-1"></div>
                                        {{ $immovableAsset->keadaan_semasa }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Jenis Aset:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        {{ $immovableAsset->jenis_aset }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Dicipta:</span>
                                    <span class="text-sm font-medium">{{ $immovableAsset->created_at->format('d/m/Y') }}</span>
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
                                <a href="{{ route('admin.immovable-assets.show', $immovableAsset) }}" 
                                   class="w-full flex items-center justify-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg transition-colors">
                                    <i class='bx bx-show mr-2'></i>
                                    Lihat Detail
                                </a>
                                
                                <a href="{{ route('admin.immovable-assets.index') }}" 
                                   class="w-full flex items-center justify-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                                    <i class='bx bx-list-ul mr-2'></i>
                                    Senarai Aset
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
                        Kemaskini terakhir: {{ $immovableAsset->updated_at->format('d/m/Y H:i') }}
                    </div>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.immovable-assets.index') }}" 
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
                nama_aset: '{{ old('nama_aset', $immovableAsset->nama_aset) }}',
                jenis_aset: '{{ old('jenis_aset', $immovableAsset->jenis_aset) }}',
                masjid_surau_id: '{{ old('masjid_surau_id', $immovableAsset->masjid_surau_id) }}',
                alamat: '{{ old('alamat', $immovableAsset->alamat) }}',
                no_hakmilik: '{{ old('no_hakmilik', $immovableAsset->no_hakmilik) }}',
                no_lot: '{{ old('no_lot', $immovableAsset->no_lot) }}',
                luas_tanah_bangunan: '{{ old('luas_tanah_bangunan', $immovableAsset->luas_tanah_bangunan) }}',
                tarikh_perolehan: '{{ old('tarikh_perolehan', $immovableAsset->tarikh_perolehan ? $immovableAsset->tarikh_perolehan->format('Y-m-d') : '') }}',
                sumber_perolehan: '{{ old('sumber_perolehan', $immovableAsset->sumber_perolehan) }}',
                kos_perolehan: '{{ old('kos_perolehan', $immovableAsset->kos_perolehan) }}',
                keadaan_semasa: '{{ old('keadaan_semasa', $immovableAsset->keadaan_semasa) }}',
                catatan: '{{ old('catatan', $immovableAsset->catatan) }}'
            }
        }
    }

    // Image removal function
    function removeImage(index) {
        if (confirm('Adakah anda pasti mahu membuang gambar ini?')) {
            // Add logic to remove image
            console.log('Remove image at index:', index);
        }
    }

    // File upload validation
    document.getElementById('gambar_aset').addEventListener('change', function() {
        const files = this.files;
        const maxSize = 2 * 1024 * 1024; // 2MB
        
        for (let i = 0; i < files.length; i++) {
            if (files[i].size > maxSize) {
                alert('Fail ' + files[i].name + ' melebihi saiz maksimum 2MB');
                this.value = '';
                return;
            }
        }
    });
</script>
@endpush
@endsection 