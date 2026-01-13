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
            <form action="{{ route('admin.immovable-assets.update', $immovableAsset) }}" method="POST"
                enctype="multipart/form-data" class="space-y-0">
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
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
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
                        <div
                            class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
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
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-buildings text-gray-400'></i>
                                        </div>
                                        <input type="text" id="nama_aset" name="nama_aset"
                                            value="{{ old('nama_aset', $immovableAsset->nama_aset) }}" required
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
                                        <select id="jenis_aset" name="jenis_aset" required
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jenis_aset') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">Pilih Jenis Aset</option>
                                            <option value="Tanah" {{ old('jenis_aset', $immovableAsset->jenis_aset) === 'Tanah' ? 'selected' : '' }}>Tanah</option>
                                            <option value="Bangunan" {{ old('jenis_aset', $immovableAsset->jenis_aset) === 'Bangunan' ? 'selected' : '' }}>Bangunan
                                            </option>
                                            <option value="Tanah dan Bangunan" {{ old('jenis_aset', $immovableAsset->jenis_aset) === 'Tanah dan Bangunan' ? 'selected' : '' }}>
                                                Tanah dan Bangunan</option>
                                        </select>
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
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-building text-gray-400'></i>
                                        </div>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class='bx bx-chevron-down text-gray-400'></i>
                                        </div>
                                        <select id="masjid_surau_id" name="masjid_surau_id" required
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('masjid_surau_id') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">Pilih Masjid/Surau</option>
                                            @foreach($masjidSuraus as $masjidSurau)
                                                <option value="{{ $masjidSurau->id }}" {{ old('masjid_surau_id', $immovableAsset->masjid_surau_id) == $masjidSurau->id ? 'selected' : '' }}>
                                                    {{ $masjidSurau->nama }}
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

                                <!-- Address -->
                                <div class="md:col-span-2">
                                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-map mr-1'></i>
                                        Alamat
                                    </label>
                                    <div class="relative">
                                        <div class="absolute top-0 left-0 pl-3 pt-4 flex pointer-events-none">
                                            <i class='bx bx-map text-gray-400'></i>
                                        </div>
                                        <textarea id="alamat" name="alamat" rows="3"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('alamat') border-red-500 @enderror bg-white"
                                            placeholder="Masukkan alamat lengkap aset">{{ old('alamat', $immovableAsset->alamat) }}</textarea>
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
                                <div
                                    class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
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
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-file text-gray-400'></i>
                                        </div>
                                        <input type="text" id="no_hakmilik" name="no_hakmilik"
                                            value="{{ old('no_hakmilik', $immovableAsset->no_hakmilik) }}"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('no_hakmilik') border-red-500 @enderror bg-white"
                                            placeholder="Masukkan no. hakmilik">
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
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-map-pin text-gray-400'></i>
                                        </div>
                                        <input type="text" id="no_lot" name="no_lot"
                                            value="{{ old('no_lot', $immovableAsset->no_lot) }}"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('no_lot') border-red-500 @enderror bg-white"
                                            placeholder="Masukkan no. lot">
                                    </div>
                                    @error('no_lot')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Land Area -->
                                <div>
                                    <label for="keluasan_tanah" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-area mr-1'></i>
                                        Keluasan Tanah (m²)
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-area text-gray-400'></i>
                                        </div>
                                        <input type="text" id="keluasan_tanah" name="keluasan_tanah"
                                            value="{{ old('keluasan_tanah', $immovableAsset->keluasan_tanah) }}"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('keluasan_tanah') border-red-500 @enderror bg-white"
                                            placeholder="0.00">
                                    </div>
                                    @error('keluasan_tanah')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Building Area -->
                                <div>
                                    <label for="keluasan_bangunan" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-building-house mr-1'></i>
                                        Keluasan Bangunan (m²)
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-building-house text-gray-400'></i>
                                        </div>
                                        <input type="text" id="keluasan_bangunan" name="keluasan_bangunan"
                                            value="{{ old('keluasan_bangunan', $immovableAsset->keluasan_bangunan) }}"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('keluasan_bangunan') border-red-500 @enderror bg-white"
                                            placeholder="Masukkan keluasan bangunan">
                                    </div>
                                    @error('keluasan_bangunan')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Acquisition and Condition Section -->
                        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
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
                                        <input type="date" id="tarikh_perolehan" name="tarikh_perolehan"
                                            value="{{ old('tarikh_perolehan', $immovableAsset->tarikh_perolehan ? $immovableAsset->tarikh_perolehan->format('Y-m-d') : '') }}"
                                            required
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
                                        <select id="sumber_perolehan" name="sumber_perolehan" required
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('sumber_perolehan') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">Pilih Sumber Perolehan</option>
                                            @foreach(\App\Helpers\SystemData::getAcquisitionSources() as $source)
                                                <option value="{{ $source }}" {{ old('sumber_perolehan', $immovableAsset->sumber_perolehan) === $source ? 'selected' : '' }}>
                                                    {{ $source }}
                                                </option>
                                            @endforeach
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
                                        <input type="text" id="kos_perolehan" name="kos_perolehan"
                                            value="{{ old('kos_perolehan', $immovableAsset->kos_perolehan) }}" required
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
                                        <select id="keadaan_semasa" name="keadaan_semasa" required
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('keadaan_semasa') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">Pilih Keadaan Semasa</option>
                                            @foreach(\App\Helpers\SystemData::getPhysicalConditions() as $condition)
                                                <option value="{{ $condition }}" {{ old('keadaan_semasa', $immovableAsset->keadaan_semasa) === $condition ? 'selected' : '' }}>
                                                    {{ $condition }}
                                                </option>
                                            @endforeach
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
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4" id="existingImages">
                                            @foreach($immovableAsset->gambar_aset as $index => $gambar)
                                                <div class="relative group image-container" data-image-path="{{ $gambar }}">
                                                    <img src="{{ Storage::url($gambar) }}" alt="Gambar Aset"
                                                        class="w-full h-24 object-cover rounded-lg">
                                                    <div
                                                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-opacity rounded-lg flex items-center justify-center">
                                                        <button type="button" onclick="removeImage('{{ $gambar }}')"
                                                            class="text-white opacity-0 group-hover:opacity-100 transition-opacity bg-red-500 rounded-full p-2">
                                                            <i class='bx bx-trash text-sm'></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div id="deleteImagesContainer"></div>
                                    </div>
                                @endif

                                <div class="relative">
                                    <input type="file" id="gambar_aset" name="gambar_aset[]" multiple accept="image/*"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('gambar_aset') border-red-500 @enderror bg-white">
                                    <i class='bx bx-images absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                <p class="mt-1 text-xs text-amber-600">Format yang diterima: JPEG, PNG, JPG. Maksimum 2MB
                                    setiap fail.</p>
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
                                    <div class="absolute top-0 left-0 pl-3 pt-4 flex pointer-events-none">
                                        <i class='bx bx-note text-gray-400'></i>
                                    </div>
                                    <textarea id="catatan" name="catatan" rows="4"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('catatan') border-red-500 @enderror bg-white"
                                        placeholder="Masukkan catatan tambahan jika ada">{{ old('catatan', $immovableAsset->catatan) }}</textarea>
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
                            <div
                                class="bg-gradient-to-br from-indigo-50 to-purple-100 rounded-xl p-6 border border-indigo-200">
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
                                            <p class="font-medium text-gray-900">{{ $immovableAsset->nama_aset }}</p>
                                            <p class="text-sm text-gray-500">{{ $immovableAsset->jenis_aset }}</p>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Luas:</span>
                                            <span class="text-sm font-medium">{{ $immovableAsset->keluasan_tanah }}
                                                m²</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Keadaan:</span>
                                            <span class="text-sm font-medium">{{ $immovableAsset->keadaan_semasa }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Kos Perolehan:</span>
                                            <span class="text-sm font-medium">RM
                                                {{ number_format($immovableAsset->kos_perolehan, 2) }}</span>
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
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            {{ $immovableAsset->jenis_aset }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Dicipta:</span>
                                        <span
                                            class="text-sm font-medium">{{ $immovableAsset->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div
                                class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-6 border border-green-200">
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

            // Currency formatting functions
            function formatCurrency(value) {
                if (!value) return '';
                // Remove non-numeric characters except dot
                let number = value.replace(/[^\d.]/g, '');
                // Ensure only one dot
                const parts = number.split('.');
                number = parts[0] + (parts.length > 1 ? '.' + parts[1] : '');

                // Parse float and format
                const floatVal = parseFloat(number);
                if (isNaN(floatVal)) return '';

                return floatVal.toLocaleString('en-MY', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            function stripCurrency(value) {
                if (!value) return '';
                return value.replace(/,/g, '');
            }

            function setupCurrencyInput(elementId) {
                const element = document.getElementById(elementId);
                if (!element) return;

                // Format on blur
                element.addEventListener('blur', function () {
                    this.value = formatCurrency(this.value);
                });

                // Strip formatting on focus
                element.addEventListener('focus', function () {
                    this.value = stripCurrency(this.value);
                });

                // Allow only numbers and dot on input
                element.addEventListener('input', function (e) {
                    this.value = this.value.replace(/[^0-9.]/g, '');
                });

                // Format initial value if exists
                if (element.value) {
                    element.value = formatCurrency(element.value);
                }
            }

            // Clean values before submit
            document.querySelector('form').addEventListener('submit', function (e) {
                const fields = ['keluasan_tanah', 'keluasan_bangunan', 'kos_perolehan'];
                fields.forEach(id => {
                    const element = document.getElementById(id);
                    if (element) {
                        element.value = stripCurrency(element.value);
                    }
                });
            });

            // Initialize inputs
            document.addEventListener('DOMContentLoaded', function () {
                setupCurrencyInput('keluasan_tanah');
                setupCurrencyInput('keluasan_bangunan');
                setupCurrencyInput('kos_perolehan');
            });

            // Image removal function
            function removeImage(imagePath) {
                if (confirm('Adakah anda pasti mahu membuang gambar ini?')) {
                    // Hide the image container
                    const imageContainer = document.querySelector(`[data-image-path="${imagePath}"]`);
                    if (imageContainer) {
                        imageContainer.style.display = 'none';
                    }

                    // Add hidden input to mark image for deletion
                    const deleteContainer = document.getElementById('deleteImagesContainer');
                    if (deleteContainer) {
                        const hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'delete_images[]';
                        hiddenInput.value = imagePath;
                        deleteContainer.appendChild(hiddenInput);
                    }
                }
            }

            // File upload validation
            document.getElementById('gambar_aset').addEventListener('change', function () {
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