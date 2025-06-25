@extends('layouts.admin')

@section('title', 'Tambah Aset Tak Alih')
@section('page-title', 'Tambah Aset Tak Alih Baru')
@section('page-description', 'Daftar aset tak alih baharu dalam sistem')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Tambah Aset Tak Alih Baru</h1>
                <p class="text-emerald-100 text-lg">Daftar aset tak alih baharu dalam sistem</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-buildings text-emerald-200'></i>
                        <span class="text-emerald-100">Daftar Aset</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-shield-check text-emerald-200'></i>
                        <span class="text-emerald-100">Sistem Selamat</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-buildings text-6xl text-emerald-200'></i>
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
                    <span class="ml-2 text-sm font-medium text-emerald-600">Maklumat Aset</span>
                </div>
                <div class="w-16 h-1 bg-gray-200 rounded"></div>
                
                <!-- Step 2 -->
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">
                        2
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-500">Hakmilik & Lokasi</span>
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
        <form action="{{ route('admin.immovable-assets.store') }}" method="POST" enctype="multipart/form-data" x-data="assetForm()" class="space-y-0">
            @csrf

            <!-- Form Header -->
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Daftar Aset Tak Alih Baru</h2>
                        <p class="text-sm text-gray-600">Isikan semua maklumat yang diperlukan untuk mendaftar aset tak alih</p>
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
                    
                    <!-- Asset Information Section -->
                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-buildings text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Maklumat Aset</h3>
                                <p class="text-sm text-emerald-700">Maklumat asas aset tak alih</p>
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
                                        <option value="Tanah" {{ old('jenis_aset') === 'Tanah' ? 'selected' : '' }}>Tanah</option>
                                        <option value="Bangunan" {{ old('jenis_aset') === 'Bangunan' ? 'selected' : '' }}>Bangunan</option>
                                        <option value="Tanah dan Bangunan" {{ old('jenis_aset') === 'Tanah dan Bangunan' ? 'selected' : '' }}>Tanah dan Bangunan</option>
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
                                    <select id="masjid_surau_id" 
                                            name="masjid_surau_id" 
                                            required
                                            x-model="form.masjid_surau_id"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('masjid_surau_id') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Masjid/Surau</option>
                                        @foreach($masjidSuraus as $masjidSurau)
                                            <option value="{{ $masjidSurau->id }}" {{ old('masjid_surau_id') == $masjidSurau->id ? 'selected' : '' }}>
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
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-map text-gray-400'></i>
                                    </div>
                                    <textarea id="alamat" 
                                              name="alamat" 
                                              rows="3"
                                              x-model="form.alamat"
                                              class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('alamat') border-red-500 @enderror bg-white"
                                              placeholder="Masukkan alamat lengkap aset">{{ old('alamat') }}</textarea>
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
                                <i class='bx bx-file text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Hakmilik & Ukuran</h3>
                                <p class="text-sm text-purple-700">Maklumat hakmilik dan saiz aset</p>
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
                                    <input type="text" 
                                           id="no_hakmilik" 
                                           name="no_hakmilik" 
                                           value="{{ old('no_hakmilik') }}"
                                           x-model="form.no_hakmilik"
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
                                    <input type="text" 
                                           id="no_lot" 
                                           name="no_lot" 
                                           value="{{ old('no_lot') }}"
                                           x-model="form.no_lot"
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
                                    Keluasan Tanah
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-area text-gray-400'></i>
                                    </div>
                                    <input type="text" 
                                           id="keluasan_tanah" 
                                           name="keluasan_tanah" 
                                           value="{{ old('keluasan_tanah') }}"
                                           x-model="form.keluasan_tanah"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('keluasan_tanah') border-red-500 @enderror bg-white"
                                           placeholder="Masukkan keluasan tanah">
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
                                    Keluasan Bangunan
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-building-house text-gray-400'></i>
                                    </div>
                                    <input type="text" 
                                           id="keluasan_bangunan" 
                                           name="keluasan_bangunan" 
                                           value="{{ old('keluasan_bangunan') }}"
                                           x-model="form.keluasan_bangunan"
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
                            <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-folder text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Perolehan & Keadaan</h3>
                                <p class="text-sm text-amber-700">Maklumat perolehan dan keadaan semasa</p>
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

                            <!-- Acquisition Source -->
                            <div>
                                <label for="sumber_perolehan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-info-circle mr-1'></i>
                                    Sumber Perolehan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-info-circle text-gray-400'></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class='bx bx-chevron-down text-gray-400'></i>
                                    </div>
                                    <select id="sumber_perolehan" 
                                            name="sumber_perolehan" 
                                            required
                                            x-model="form.sumber_perolehan"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('sumber_perolehan') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Sumber Perolehan</option>
                                        <option value="Pembelian" {{ old('sumber_perolehan') === 'Pembelian' ? 'selected' : '' }}>Pembelian</option>
                                        <option value="Hibah" {{ old('sumber_perolehan') === 'Hibah' ? 'selected' : '' }}>Hibah</option>
                                        <option value="Wakaf" {{ old('sumber_perolehan') === 'Wakaf' ? 'selected' : '' }}>Wakaf</option>
                                        <option value="Derma" {{ old('sumber_perolehan') === 'Derma' ? 'selected' : '' }}>Derma</option>
                                        <option value="Lain-lain" {{ old('sumber_perolehan') === 'Lain-lain' ? 'selected' : '' }}>Lain-lain</option>
                                    </select>
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
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-dollar text-gray-400'></i>
                                    </div>
                                    <input type="number" 
                                           step="0.01"
                                           id="kos_perolehan" 
                                           name="kos_perolehan" 
                                           value="{{ old('kos_perolehan') }}"
                                           required
                                           x-model="form.kos_perolehan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kos_perolehan') border-red-500 @enderror bg-white"
                                           placeholder="0.00">
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
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-check-circle text-gray-400'></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class='bx bx-chevron-down text-gray-400'></i>
                                    </div>
                                    <select id="keadaan_semasa" 
                                            name="keadaan_semasa" 
                                            required
                                            x-model="form.keadaan_semasa"
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('keadaan_semasa') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Keadaan Semasa</option>
                                        <option value="Sangat Baik" {{ old('keadaan_semasa') === 'Sangat Baik' ? 'selected' : '' }}>Sangat Baik</option>
                                        <option value="Baik" {{ old('keadaan_semasa') === 'Baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="Sederhana" {{ old('keadaan_semasa') === 'Sederhana' ? 'selected' : '' }}>Sederhana</option>
                                        <option value="Perlu Pembaikan" {{ old('keadaan_semasa') === 'Perlu Pembaikan' ? 'selected' : '' }}>Perlu Pembaikan</option>
                                        <option value="Rosak" {{ old('keadaan_semasa') === 'Rosak' ? 'selected' : '' }}>Rosak</option>
                                    </select>
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
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class='bx bx-images text-gray-400'></i>
                                </div>
                                <input type="file" 
                                       id="gambar_aset" 
                                       name="gambar_aset[]" 
                                       multiple 
                                       accept="image/*"
                                       class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('gambar_aset') border-red-500 @enderror bg-white">
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
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class='bx bx-note text-gray-400'></i>
                                </div>
                                <textarea id="catatan" 
                                          name="catatan" 
                                          rows="4"
                                          x-model="form.catatan"
                                          class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('catatan') border-red-500 @enderror bg-white"
                                          placeholder="Masukkan catatan tambahan jika ada">{{ old('catatan') }}</textarea>
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

                <!-- Right Column - Preview & Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        
                        <!-- Preview Card -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl p-6 border border-blue-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-show text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Pratonton Aset</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                        <i class='bx bx-buildings text-emerald-700 text-lg'></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900" x-text="form.nama_aset || 'Nama Aset'">Nama Aset</p>
                                        <p class="text-sm text-gray-500" x-text="form.jenis_aset || 'Jenis Aset'">Jenis Aset</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Luas:</span>
                                        <span class="text-sm font-medium" x-text="form.keluasan_tanah ? form.keluasan_tanah + ' m²' : '-'">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Kos:</span>
                                        <span class="text-sm font-medium" x-text="form.kos_perolehan ? 'RM ' + parseFloat(form.kos_perolehan).toLocaleString() : '-'">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Keadaan:</span>
                                        <span class="text-sm font-medium" x-text="form.keadaan_semasa || '-'">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Sumber:</span>
                                        <span class="text-sm font-medium" x-text="form.sumber_perolehan || '-'">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Card -->
                        <div class="bg-gradient-to-br from-gray-50 to-white-100 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-gray-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-file text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Kemajuan Borang</h3>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Maklumat Aset</span>
                                    <div class="flex items-center" x-show="form.nama_aset && form.jenis_aset && form.masjid_surau_id">
                                        <i class='bx bx-check text-green-500'></i>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Hakmilik & Ukuran</span>
                                    <div class="flex items-center" x-show="form.keluasan_tanah">
                                        <i class='bx bx-check text-green-500'></i>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Perolehan & Keadaan</span>
                                    <div class="flex items-center" x-show="form.tarikh_perolehan && form.sumber_perolehan && form.kos_perolehan && form.keadaan_semasa">
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
                                    Pastikan maklumat hakmilik adalah tepat
                                </li>
                                <li class="flex items-start">
                                    <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                    Sertakan gambar aset yang jelas
                                </li>
                                <li class="flex items-start">
                                    <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                    Periksa semula ukuran dan kos
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
                        <a href="{{ route('admin.immovable-assets.index') }}" 
                           class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                            <i class='bx bx-x mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-8 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                            <i class='bx bx-plus mr-2'></i>
                            Daftar Aset
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function assetForm() {
        return {
            form: {
                nama_aset: '{{ old('nama_aset') }}',
                jenis_aset: '{{ old('jenis_aset') }}',
                masjid_surau_id: '{{ old('masjid_surau_id') }}',
                alamat: '{{ old('alamat') }}',
                no_hakmilik: '{{ old('no_hakmilik') }}',
                no_lot: '{{ old('no_lot') }}',
                keluasan_tanah: '{{ old('keluasan_tanah') }}',
                keluasan_bangunan: '{{ old('keluasan_bangunan') }}',
                tarikh_perolehan: '{{ old('tarikh_perolehan') }}',
                sumber_perolehan: '{{ old('sumber_perolehan') }}',
                kos_perolehan: '{{ old('kos_perolehan') }}',
                keadaan_semasa: '{{ old('keadaan_semasa') }}',
                catatan: '{{ old('catatan') }}'
            }
        }
    }

    // Form validation
    document.getElementById('keluasan_tanah').addEventListener('input', function() {
        const value = parseFloat(this.value);
        if (value < 0) {
            this.setCustomValidity('Luas tidak boleh negatif');
        } else {
            this.setCustomValidity('');
        }
    });

    document.getElementById('kos_perolehan').addEventListener('input', function() {
        const value = parseFloat(this.value);
        if (value < 0) {
            this.setCustomValidity('Kos tidak boleh negatif');
        } else {
            this.setCustomValidity('');
        }
    });
</script>
@endpush
@endsection 