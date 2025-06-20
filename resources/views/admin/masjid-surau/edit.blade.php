@extends('layouts.admin')

@section('title', 'Edit Masjid/Surau')
@section('page-title', 'Edit Masjid/Surau')
@section('page-description', 'Kemaskini maklumat masjid/surau')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Edit Masjid/Surau</h1>
                <p class="text-emerald-100 text-lg">Kemaskini maklumat untuk {{ $masjidSurau->nama }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-edit text-emerald-200'></i>
                        <span class="text-emerald-100">Kemaskini Data</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 {{ $masjidSurau->status == 'Aktif' ? 'bg-green-400' : 'bg-red-400' }} rounded-full"></div>
                        <span class="text-emerald-100">{{ $masjidSurau->status }}</span>
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
        <a href="{{ route('admin.masjid-surau.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Masjid/Surau
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">Edit: {{ $masjidSurau->nama }}</span>
    </div>



    <!-- Form Card - Full Width -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <form action="{{ route('admin.masjid-surau.update', $masjidSurau) }}" method="POST" x-data="editMasjidForm()" class="space-y-0">
            @csrf
            @method('PUT')

            <!-- Form Header -->
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Kemaskini Maklumat Masjid/Surau</h2>
                        <p class="text-sm text-gray-600">Edit dan kemaskini maklumat masjid/surau dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $masjidSurau->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <div class="w-2 h-2 {{ $masjidSurau->status == 'Aktif' ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-2"></div>
                            {{ $masjidSurau->status }}
                        </span>
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $masjidSurau->jenis == 'Masjid' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ $masjidSurau->jenis }}
                        </span>
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
                                <p class="text-sm text-emerald-700">Kemaskini maklumat utama masjid/surau</p>
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
                                           value="{{ old('nama', $masjidSurau->nama) }}"
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
                                           value="{{ old('singkatan_nama', $masjidSurau->singkatan_nama) }}"
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
                                        <option value="Masjid" {{ old('jenis', $masjidSurau->jenis) == 'Masjid' ? 'selected' : '' }}>Masjid</option>
                                        <option value="Surau" {{ old('jenis', $masjidSurau->jenis) == 'Surau' ? 'selected' : '' }}>Surau</option>
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
                                        <option value="Aktif" {{ old('status', $masjidSurau->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Tidak Aktif" {{ old('status', $masjidSurau->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
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
                        </div>
                    </div>

                    <!-- Organization & Details Section -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-shield text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Maklumat Organisasi</h3>
                                <p class="text-sm text-purple-700">Kemaskini maklumat pengurusan dan organisasi</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                           value="{{ old('imam_ketua', $masjidSurau->imam_ketua) }}"
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
                                           value="{{ old('bilangan_jemaah', $masjidSurau->bilangan_jemaah) }}"
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
                                           value="{{ old('tahun_dibina', $masjidSurau->tahun_dibina) }}"
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
                                <p class="text-sm text-blue-700">Kemaskini alamat dan lokasi masjid/surau</p>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Address Lines -->
                            <div class="space-y-4">
                                <div>
                                    <label for="alamat_baris_1" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-map mr-1'></i>
                                        Alamat Baris 1 <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               id="alamat_baris_1" 
                                               name="alamat_baris_1" 
                                               value="{{ old('alamat_baris_1', $masjidSurau->alamat_baris_1) }}"
                                               required
                                               x-model="form.alamat_baris_1"
                                               class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('alamat_baris_1') border-red-500 @enderror bg-white"
                                               placeholder="Alamat baris pertama">
                                        <i class='bx bx-map absolute left-3 top-3.5 text-gray-400'></i>
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
                                        <i class='bx bx-map mr-1'></i>
                                        Alamat Baris 2
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               id="alamat_baris_2" 
                                               name="alamat_baris_2" 
                                               value="{{ old('alamat_baris_2', $masjidSurau->alamat_baris_2) }}"
                                               x-model="form.alamat_baris_2"
                                               class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('alamat_baris_2') border-red-500 @enderror bg-white"
                                               placeholder="Alamat baris kedua">
                                        <i class='bx bx-map absolute left-3 top-3.5 text-gray-400'></i>
                                    </div>
                                    @error('alamat_baris_2')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Poskod -->
                                <div>
                                    <label for="poskod" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-map mr-1'></i>
                                        Poskod
                                    </label>
                                    <div class="relative">
                                        <input type="text" 
                                               id="poskod" 
                                               name="poskod" 
                                               value="{{ old('poskod', $masjidSurau->poskod) }}"
                                               x-model="form.poskod"
                                               class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('poskod') border-red-500 @enderror bg-white"
                                               placeholder="Poskod">
                                        <i class='bx bx-map absolute left-3 top-3.5 text-gray-400'></i>
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
                                               value="{{ old('bandar', $masjidSurau->bandar) }}"
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
                                        <select id="negeri" 
                                                name="negeri" 
                                                required
                                                x-model="form.negeri"
                                                class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('negeri') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">Pilih Negeri</option>
                                            <option value="Johor" {{ old('negeri', $masjidSurau->negeri) == 'Johor' ? 'selected' : '' }}>Johor</option>
                                            <option value="Kedah" {{ old('negeri', $masjidSurau->negeri) == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                                            <option value="Kelantan" {{ old('negeri', $masjidSurau->negeri) == 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                                            <option value="Melaka" {{ old('negeri', $masjidSurau->negeri) == 'Melaka' ? 'selected' : '' }}>Melaka</option>
                                            <option value="Negeri Sembilan" {{ old('negeri', $masjidSurau->negeri) == 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                                            <option value="Pahang" {{ old('negeri', $masjidSurau->negeri) == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                                            <option value="Perak" {{ old('negeri', $masjidSurau->negeri) == 'Perak' ? 'selected' : '' }}>Perak</option>
                                            <option value="Perlis" {{ old('negeri', $masjidSurau->negeri) == 'Perlis' ? 'selected' : '' }}>Perlis</option>
                                            <option value="Pulau Pinang" {{ old('negeri', $masjidSurau->negeri) == 'Pulau Pinang' ? 'selected' : '' }}>Pulau Pinang</option>
                                            <option value="Sabah" {{ old('negeri', $masjidSurau->negeri) == 'Sabah' ? 'selected' : '' }}>Sabah</option>
                                            <option value="Sarawak" {{ old('negeri', $masjidSurau->negeri) == 'Sarawak' ? 'selected' : '' }}>Sarawak</option>
                                            <option value="Selangor" {{ old('negeri', $masjidSurau->negeri) == 'Selangor' ? 'selected' : '' }}>Selangor</option>
                                            <option value="Terengganu" {{ old('negeri', $masjidSurau->negeri) == 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                                            <option value="Wilayah Persekutuan Kuala Lumpur" {{ old('negeri', $masjidSurau->negeri) == 'Wilayah Persekutuan Kuala Lumpur' ? 'selected' : '' }}>Wilayah Persekutuan Kuala Lumpur</option>
                                            <option value="Wilayah Persekutuan Labuan" {{ old('negeri', $masjidSurau->negeri) == 'Wilayah Persekutuan Labuan' ? 'selected' : '' }}>Wilayah Persekutuan Labuan</option>
                                            <option value="Wilayah Persekutuan Putrajaya" {{ old('negeri', $masjidSurau->negeri) == 'Wilayah Persekutuan Putrajaya' ? 'selected' : '' }}>Wilayah Persekutuan Putrajaya</option>
                                        </select>
                                        <i class='bx bx-map absolute left-3 top-3.5 text-gray-400'></i>
                                        <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                    </div>
                                    @error('negeri')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Section -->
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-phone text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Maklumat Hubungan</h3>
                                <p class="text-sm text-amber-700">Kemaskini maklumat untuk dihubungi</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                           value="{{ old('no_telefon', $masjidSurau->no_telefon) }}"
                                           x-model="form.no_telefon"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('no_telefon') border-red-500 @enderror bg-white"
                                           placeholder="Nombor telefon">
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
                                    Alamat Email
                                </label>
                                <div class="relative">
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $masjidSurau->email) }}"
                                           x-model="form.email"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('email') border-red-500 @enderror bg-white"
                                           placeholder="alamat@email.com">
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

                        <!-- Notice -->
                        <div class="mt-4 p-4 bg-emerald-50 rounded-lg border border-emerald-200">
                            <div class="flex">
                                <i class='bx bx-info-circle text-emerald-600 text-lg mt-0.5'></i>
                                <div class="ml-3">
                                    <p class="text-sm text-emerald-800">
                                        <strong>Nota:</strong> Maklumat hubungan ini akan digunakan untuk urusan pentadbiran dan komunikasi rasmi.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Preview & Info -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        
                        <!-- Current Masjid/Surau Preview -->
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-100 rounded-xl p-6 border border-indigo-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-building text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Pratonton Masjid/Surau</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                        <span class="text-emerald-700 font-medium" x-text="form.nama ? form.nama.charAt(0).toUpperCase() : '{{ substr($masjidSurau->nama, 0, 1) }}'">{{ substr($masjidSurau->nama, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900" x-text="form.nama || '{{ $masjidSurau->nama }}'">{{ $masjidSurau->nama }}</p>
                                        <p class="text-sm text-gray-500" x-text="form.singkatan_nama || '{{ $masjidSurau->singkatan_nama ?: 'Tiada singkatan' }}'">{{ $masjidSurau->singkatan_nama ?: 'Tiada singkatan' }}</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Jenis:</span>
                                        <span class="text-sm font-medium" x-text="form.jenis || '{{ $masjidSurau->jenis }}'">{{ $masjidSurau->jenis }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Status:</span>
                                        <span class="text-sm font-medium" x-text="form.status || '{{ $masjidSurau->status }}'">{{ $masjidSurau->status }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Bandar:</span>
                                        <span class="text-sm font-medium" x-text="form.bandar || '{{ $masjidSurau->bandar ?: '-' }}'">{{ $masjidSurau->bandar ?: '-' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Negeri:</span>
                                        <span class="text-sm font-medium" x-text="form.negeri || '{{ $masjidSurau->negeri ?: '-' }}'">{{ $masjidSurau->negeri ?: '-' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Summary -->
                        <div class="bg-white rounded-xl p-6 border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Maklumat</h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Status:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $masjidSurau->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        <div class="w-2 h-2 {{ $masjidSurau->status == 'Aktif' ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-1"></div>
                                        {{ $masjidSurau->status }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Jenis:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $masjidSurau->jenis == 'Masjid' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                        {{ $masjidSurau->jenis }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Bilangan Jemaah:</span>
                                    <span class="text-sm font-medium">{{ $masjidSurau->bilangan_jemaah ?: '-' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Tahun Dibina:</span>
                                    <span class="text-sm font-medium">{{ $masjidSurau->tahun_dibina ?: '-' }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Dicipta:</span>
                                    <span class="text-sm font-medium">{{ $masjidSurau->created_at->format('d/m/Y') }}</span>
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
                                <a href="{{ route('admin.masjid-surau.show', $masjidSurau) }}" 
                                   class="w-full flex items-center justify-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg transition-colors">
                                    <i class='bx bx-show mr-2'></i>
                                    Lihat Detail
                                </a>
                                
                                <a href="{{ route('admin.assets.index', ['masjid_surau_id' => $masjidSurau->id]) }}" 
                                   class="w-full flex items-center justify-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                                    <i class='bx bx-package mr-2'></i>
                                    Lihat Aset
                                </a>

                                @if($masjidSurau->status == 'Aktif')
                                <form action="#" method="POST" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full flex items-center justify-center px-4 py-2 bg-amber-100 hover:bg-amber-200 text-amber-700 rounded-lg transition-colors">
                                        <i class='bx bx-toggle-left mr-2'></i>
                                        Nyahaktifkan
                                    </button>
                                </form>
                                @else
                                <form action="#" method="POST" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full flex items-center justify-center px-4 py-2 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg transition-colors">
                                        <i class='bx bx-toggle-right mr-2'></i>
                                        Aktifkan
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
                        Kemaskini terakhir: {{ $masjidSurau->updated_at->format('d/m/Y H:i') }}
                    </div>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.masjid-surau.index') }}" 
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
    function editMasjidForm() {
        return {
            form: {
                nama: '{{ old('nama', $masjidSurau->nama) }}',
                singkatan_nama: '{{ old('singkatan_nama', $masjidSurau->singkatan_nama) }}',
                jenis: '{{ old('jenis', $masjidSurau->jenis) }}',
                status: '{{ old('status', $masjidSurau->status) }}',
                imam_ketua: '{{ old('imam_ketua', $masjidSurau->imam_ketua) }}',
                bilangan_jemaah: '{{ old('bilangan_jemaah', $masjidSurau->bilangan_jemaah) }}',
                tahun_dibina: '{{ old('tahun_dibina', $masjidSurau->tahun_dibina) }}',
                alamat_baris_1: '{{ old('alamat_baris_1', $masjidSurau->alamat_baris_1) }}',
                alamat_baris_2: '{{ old('alamat_baris_2', $masjidSurau->alamat_baris_2) }}',
                poskod: '{{ old('poskod', $masjidSurau->poskod) }}',
                bandar: '{{ old('bandar', $masjidSurau->bandar) }}',
                negeri: '{{ old('negeri', $masjidSurau->negeri) }}',
                no_telefon: '{{ old('no_telefon', $masjidSurau->no_telefon) }}',
                email: '{{ old('email', $masjidSurau->email) }}'
            }
        }
    }
</script>
@endpush
@endsection