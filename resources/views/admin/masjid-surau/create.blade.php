@extends('layouts.admin')

@section('title', 'Tambah Masjid/Surau')
@section('page-title', 'Tambah Masjid/Surau Baru')
@section('page-description', 'Daftar masjid atau surau baharu dalam sistem')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Tambah Masjid/Surau Baru</h1>
                <p class="text-emerald-100 text-lg">Daftar masjid atau surau baharu dalam sistem pengurusan aset</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-buildings text-emerald-200'></i>
                        <span class="text-emerald-100">Pendaftaran Institusi</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-map text-emerald-200'></i>
                        <span class="text-emerald-100">Lokasi Terkini</span>
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
        <a href="{{ route('admin.masjid-surau.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Masjid/Surau
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">Tambah Masjid/Surau</span>
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
                    <span class="ml-2 text-sm font-medium text-gray-500">Lokasi & Alamat</span>
                </div>
                <div class="w-16 h-1 bg-gray-200 rounded"></div>
                
                <!-- Step 3 -->
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">
                        3
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-500">Maklumat Hubungan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card - Full Width -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <form action="{{ route('admin.masjid-surau.store') }}" method="POST" x-data="masjidForm()" class="space-y-0">
            @csrf

            <!-- Form Header -->
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Daftar Masjid/Surau Baru</h2>
                        <p class="text-sm text-gray-600">Isikan semua maklumat yang diperlukan untuk mendaftarkan masjid/surau</p>
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
                    
                    <!-- Basic Information Section -->
                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-buildings text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Maklumat Asas</h3>
                                <p class="text-sm text-emerald-700">Maklumat utama masjid/surau</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama -->
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-buildings mr-1'></i>
                                    Nama Masjid/Surau <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="nama" 
                                           name="nama" 
                                           value="{{ old('nama') }}"
                                           required
                                           x-model="form.nama"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nama') border-red-500 @enderror bg-white"
                                           placeholder="Masukkan nama masjid/surau">
                                    <i class='bx bx-buildings absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('nama')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Singkatan Nama -->
                            <div>
                                <label for="singkatan_nama" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-tag mr-1'></i>
                                    Singkatan Nama
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="singkatan_nama" 
                                           name="singkatan_nama" 
                                           value="{{ old('singkatan_nama') }}"
                                           maxlength="20"
                                           x-model="form.singkatan_nama"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('singkatan_nama') border-red-500 @enderror bg-white"
                                           placeholder="Contoh: MTAJ, SAT">
                                    <i class='bx bx-tag absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('singkatan_nama')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-1 text-xs text-emerald-600 flex items-center">
                                    <i class='bx bx-info-circle mr-1'></i>
                                    Digunakan untuk penjanaan nombor siri aset
                                </p>
                            </div>

                            <!-- Jenis -->
                            <div>
                                <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-category mr-1'></i>
                                    Jenis <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="jenis" 
                                            name="jenis" 
                                            required
                                            x-model="form.jenis"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jenis') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Jenis</option>
                                        <option value="Masjid" {{ old('jenis') == 'Masjid' ? 'selected' : '' }}>Masjid</option>
                                        <option value="Surau" {{ old('jenis') == 'Surau' ? 'selected' : '' }}>Surau</option>
                                    </select>
                                    <i class='bx bx-category absolute left-3 top-3.5 text-gray-400'></i>
                                    <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('jenis')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-check-circle mr-1'></i>
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="status" 
                                            name="status" 
                                            required
                                            x-model="form.status"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('status') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Status</option>
                                        <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                    <i class='bx bx-check-circle absolute left-3 top-3.5 text-gray-400'></i>
                                    <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Imam/Ketua -->
                            <div>
                                <label for="imam_ketua" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-user mr-1'></i>
                                    Imam/Ketua
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="imam_ketua" 
                                           name="imam_ketua" 
                                           value="{{ old('imam_ketua') }}"
                                           x-model="form.imam_ketua"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('imam_ketua') border-red-500 @enderror bg-white"
                                           placeholder="Nama imam atau ketua">
                                    <i class='bx bx-user absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('imam_ketua')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Bilangan Jemaah -->
                            <div>
                                <label for="bilangan_jemaah" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-group mr-1'></i>
                                    Bilangan Jemaah
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           id="bilangan_jemaah" 
                                           name="bilangan_jemaah" 
                                           value="{{ old('bilangan_jemaah') }}"
                                           min="0"
                                           x-model="form.bilangan_jemaah"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('bilangan_jemaah') border-red-500 @enderror bg-white"
                                           placeholder="Anggaran bilangan jemaah">
                                    <i class='bx bx-group absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('bilangan_jemaah')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Tahun Dibina -->
                            <div>
                                <label for="tahun_dibina" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-calendar mr-1'></i>
                                    Tahun Dibina
                                </label>
                                <div class="relative">
                                    <input type="number" 
                                           id="tahun_dibina" 
                                           name="tahun_dibina" 
                                           value="{{ old('tahun_dibina') }}"
                                           min="1800" max="{{ date('Y') }}"
                                           x-model="form.tahun_dibina"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tahun_dibina') border-red-500 @enderror bg-white"
                                           placeholder="Tahun dibina">
                                    <i class='bx bx-calendar absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('tahun_dibina')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Location Information Section -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-map text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Maklumat Lokasi</h3>
                                <p class="text-sm text-blue-700">Alamat dan lokasi masjid/surau</p>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Address Lines -->
                            <div class="space-y-4">
                                <div>
                                    <label for="alamat_baris_1" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-home mr-1'></i>
                                        Alamat Baris 1
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               id="alamat_baris_1" 
                                               name="alamat_baris_1" 
                                               value="{{ old('alamat_baris_1') }}"
                                               x-model="form.alamat_baris_1"
                                               class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('alamat_baris_1') border-red-500 @enderror bg-white"
                                               placeholder="Alamat baris pertama">
                                        <i class='bx bx-home absolute left-3 top-3.5 text-gray-400'></i>
                                    </div>
                                    @error('alamat_baris_1')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="alamat_baris_2" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-home mr-1'></i>
                                        Alamat Baris 2
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               id="alamat_baris_2" 
                                               name="alamat_baris_2" 
                                               value="{{ old('alamat_baris_2') }}"
                                               x-model="form.alamat_baris_2"
                                               class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('alamat_baris_2') border-red-500 @enderror bg-white"
                                               placeholder="Alamat baris kedua">
                                        <i class='bx bx-home absolute left-3 top-3.5 text-gray-400'></i>
                                    </div>
                                    @error('alamat_baris_2')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="alamat_baris_3" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-home mr-1'></i>
                                        Alamat Baris 3
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               id="alamat_baris_3" 
                                               name="alamat_baris_3" 
                                               value="{{ old('alamat_baris_3') }}"
                                               x-model="form.alamat_baris_3"
                                               class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('alamat_baris_3') border-red-500 @enderror bg-white"
                                               placeholder="Alamat baris ketiga (opsional)">
                                        <i class='bx bx-home absolute left-3 top-3.5 text-gray-400'></i>
                                    </div>
                                    @error('alamat_baris_3')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Location Details -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Poskod -->
                                <div>
                                    <label for="poskod" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-map-pin mr-1'></i>
                                        Poskod <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               id="poskod" 
                                               name="poskod" 
                                               value="{{ old('poskod') }}"
                                               required
                                               x-model="form.poskod"
                                               class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('poskod') border-red-500 @enderror bg-white"
                                               placeholder="Poskod">
                                        <i class='bx bx-map-pin absolute left-3 top-3.5 text-gray-400'></i>
                                    </div>
                                    @error('poskod')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Bandar -->
                                <div>
                                    <label for="bandar" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-buildings mr-1'></i>
                                        Bandar <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               id="bandar" 
                                               name="bandar" 
                                               value="{{ old('bandar') }}"
                                               required
                                               x-model="form.bandar"
                                               class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('bandar') border-red-500 @enderror bg-white"
                                               placeholder="Bandar">
                                        <i class='bx bx-buildings absolute left-3 top-3.5 text-gray-400'></i>
                                    </div>
                                    @error('bandar')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Negeri -->
                                <div>
                                    <label for="negeri" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-map mr-1'></i>
                                        Negeri <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               id="negeri" 
                                               name="negeri" 
                                               value="{{ old('negeri') }}"
                                               required
                                               x-model="form.negeri"
                                               class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('negeri') border-red-500 @enderror bg-white"
                                               placeholder="Negeri">
                                        <i class='bx bx-map absolute left-3 top-3.5 text-gray-400'></i>
                                    </div>
                                    @error('negeri')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Daerah -->
                                <div>
                                    <label for="daerah" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-location-plus mr-1'></i>
                                        Daerah <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               id="daerah" 
                                               name="daerah" 
                                               value="{{ old('daerah') }}"
                                               required
                                               x-model="form.daerah"
                                               class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('daerah') border-red-500 @enderror bg-white"
                                               placeholder="Daerah">
                                        <i class='bx bx-location-plus absolute left-3 top-3.5 text-gray-400'></i>
                                    </div>
                                    @error('daerah')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Country (Hidden) -->
                            <input type="hidden" name="negara" value="Malaysia">
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-phone text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Maklumat Hubungan</h3>
                                <p class="text-sm text-purple-700">Maklumat untuk dihubungi</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- No Telefon -->
                            <div>
                                <label for="no_telefon" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-phone mr-1'></i>
                                    Nombor Telefon
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="no_telefon" 
                                           name="no_telefon" 
                                           value="{{ old('no_telefon') }}"
                                           x-model="form.no_telefon"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('no_telefon') border-red-500 @enderror bg-white"
                                           placeholder="010-1234567">
                                    <i class='bx bx-phone absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('no_telefon')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-envelope mr-1'></i>
                                    Alamat E-mel
                                </label>
                                <div class="relative">
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}"
                                           x-model="form.email"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('email') border-red-500 @enderror bg-white"
                                           placeholder="contoh@email.com">
                                    <i class='bx bx-envelope absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Catatan -->
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
                                          placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
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

                <!-- Right Column - Preview & Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        
                        <!-- Preview Card -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl p-6 border border-blue-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-show text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Pratonton Masjid/Surau</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                        <i class='bx bx-buildings text-emerald-700 text-lg'></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900" x-text="form.nama || 'Nama Masjid/Surau'">Nama Masjid/Surau</p>
                                        <p class="text-sm text-gray-500" x-text="form.jenis || 'Jenis'">Jenis</p>
                                        <p class="text-xs text-gray-400" x-text="form.singkatan_nama ? '(' + form.singkatan_nama + ')' : ''"></p>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Imam/Ketua:</span>
                                        <span class="text-sm font-medium" x-text="form.imam_ketua || '-'">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Lokasi:</span>
                                        <span class="text-sm font-medium" x-text="(form.bandar && form.negeri) ? form.bandar + ', ' + form.negeri : '-'">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Status:</span>
                                        <span class="text-sm font-medium" x-text="form.status || '-'">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Card -->
                        <div class="bg-white rounded-xl p-6 border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Kemajuan Borang</h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Maklumat Asas</span>
                                    <div class="flex items-center" x-show="form.nama && form.jenis && form.status">
                                        <i class='bx bx-check text-green-500'></i>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Lokasi & Alamat</span>
                                    <div class="flex items-center" x-show="form.poskod && form.bandar && form.negeri && form.daerah">
                                        <i class='bx bx-check text-green-500'></i>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Maklumat Hubungan</span>
                                    <div class="flex items-center" x-show="form.no_telefon || form.email">
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
                                    Singkatan nama akan digunakan untuk nombor siri aset
                                </li>
                                <li class="flex items-start">
                                    <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                    Pastikan alamat lengkap dan tepat
                                </li>
                                <li class="flex items-start">
                                    <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                    Daerah diperlukan untuk pelaporan rasmi
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
                        <a href="{{ route('admin.masjid-surau.index') }}" 
                           class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                            <i class='bx bx-x mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-8 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                            <i class='bx bx-buildings mr-2'></i>
                            Daftar Masjid/Surau
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function masjidForm() {
        return {
            form: {
                nama: '{{ old('nama') }}',
                singkatan_nama: '{{ old('singkatan_nama') }}',
                jenis: '{{ old('jenis') }}',
                status: '{{ old('status') }}',
                imam_ketua: '{{ old('imam_ketua') }}',
                bilangan_jemaah: '{{ old('bilangan_jemaah') }}',
                tahun_dibina: '{{ old('tahun_dibina') }}',
                alamat_baris_1: '{{ old('alamat_baris_1') }}',
                alamat_baris_2: '{{ old('alamat_baris_2') }}',
                alamat_baris_3: '{{ old('alamat_baris_3') }}',
                poskod: '{{ old('poskod') }}',
                bandar: '{{ old('bandar') }}',
                negeri: '{{ old('negeri') }}',
                daerah: '{{ old('daerah') }}',
                no_telefon: '{{ old('no_telefon') }}',
                email: '{{ old('email') }}',
                catatan: '{{ old('catatan') }}'
            }
        }
    }
</script>
@endpush
@endsection
