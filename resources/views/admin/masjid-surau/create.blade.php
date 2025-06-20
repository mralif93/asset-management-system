@extends('layouts.admin')

@section('title', 'Tambah Masjid/Surau')
@section('page-title', 'Tambah Masjid/Surau')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Tambah Masjid/Surau</h1>
                <p class="text-emerald-100 text-lg">Daftar masjid atau surau baharu dalam sistem</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-plus-circle text-emerald-200'></i>
                        <span class="text-emerald-100">Pendaftaran baharu</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-buildings text-6xl text-emerald-200 opacity-80'></i>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition-colors">
                <i class='bx bx-home text-lg'></i>
            </a>
            <i class='bx bx-chevron-right text-gray-400'></i>
            <a href="{{ route('admin.masjid-surau.index') }}" class="hover:text-emerald-600 transition-colors">
                Masjid/Surau
            </a>
            <i class='bx bx-chevron-right text-gray-400'></i>
            <span class="text-emerald-600 font-medium">Tambah Baharu</span>
        </nav>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Form -->
        <div class="lg:col-span-2">
            <form action="{{ route('admin.masjid-surau.store') }}" method="POST" x-data="masjidForm()" class="space-y-8">
                @csrf

                <!-- Basic Information Section -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                <i class='bx bx-info-circle text-emerald-600 text-lg'></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Maklumat Asas</h2>
                                <p class="text-sm text-gray-600">Maklumat utama masjid/surau</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Nama -->
                            <div>
                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Masjid/Surau *
                                </label>
                                <div class="relative">
                                    <input type="text" name="nama" id="nama" x-model="formData.nama" required
                                           value="{{ old('nama') }}"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nama') border-red-500 @enderror"
                                           placeholder="Nama masjid atau surau">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                        <i class='bx bx-buildings text-gray-400'></i>
                                    </div>
                                </div>
                                @error('nama')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Singkatan Nama -->
                            <div>
                                <label for="singkatan_nama" class="block text-sm font-medium text-gray-700 mb-2">
                                    Singkatan Nama
                                </label>
                                <div class="relative">
                                    <input type="text" name="singkatan_nama" id="singkatan_nama" x-model="formData.singkatan_nama"
                                           value="{{ old('singkatan_nama') }}" maxlength="20"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('singkatan_nama') border-red-500 @enderror"
                                           placeholder="Contoh: MTAJ, SAT">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                        <i class='bx bx-tag text-gray-400'></i>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Digunakan untuk penjanaan nombor siri aset</p>
                                @error('singkatan_nama')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis -->
                            <div>
                                <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis *
                                </label>
                                <select name="jenis" id="jenis" x-model="formData.jenis" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jenis') border-red-500 @enderror">
                                    <option value="">Pilih Jenis</option>
                                    <option value="Masjid" {{ old('jenis') == 'Masjid' ? 'selected' : '' }}>Masjid</option>
                                    <option value="Surau" {{ old('jenis') == 'Surau' ? 'selected' : '' }}>Surau</option>
                                </select>
                                @error('jenis')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                                    Status *
                                </label>
                                <select name="status" id="status" x-model="formData.status" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('status') border-red-500 @enderror">
                                    <option value="">Pilih Status</option>
                                    <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Imam/Ketua -->
                            <div>
                                <label for="imam_ketua" class="block text-sm font-medium text-gray-700 mb-2">
                                    Imam/Ketua
                                </label>
                                <div class="relative">
                                    <input type="text" name="imam_ketua" id="imam_ketua" x-model="formData.imam_ketua"
                                           value="{{ old('imam_ketua') }}"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('imam_ketua') border-red-500 @enderror"
                                           placeholder="Nama imam atau ketua">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                        <i class='bx bx-user text-gray-400'></i>
                                    </div>
                                </div>
                                @error('imam_ketua')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bilangan Jemaah -->
                            <div>
                                <label for="bilangan_jemaah" class="block text-sm font-medium text-gray-700 mb-2">
                                    Bilangan Jemaah
                                </label>
                                <div class="relative">
                                    <input type="number" name="bilangan_jemaah" id="bilangan_jemaah" x-model="formData.bilangan_jemaah" min="0"
                                           value="{{ old('bilangan_jemaah') }}"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('bilangan_jemaah') border-red-500 @enderror"
                                           placeholder="Anggaran bilangan jemaah">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                        <i class='bx bx-group text-gray-400'></i>
                                    </div>
                                </div>
                                @error('bilangan_jemaah')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tahun Dibina -->
                            <div>
                                <label for="tahun_dibina" class="block text-sm font-medium text-gray-700 mb-2">
                                    Tahun Dibina
                                </label>
                                <div class="relative">
                                    <input type="number" name="tahun_dibina" id="tahun_dibina" x-model="formData.tahun_dibina" 
                                           min="1800" max="{{ date('Y') }}" value="{{ old('tahun_dibina') }}"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tahun_dibina') border-red-500 @enderror"
                                           placeholder="Tahun dibina">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                        <i class='bx bx-calendar text-gray-400'></i>
                                    </div>
                                </div>
                                @error('tahun_dibina')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location Information Section -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                <i class='bx bx-map text-blue-600 text-lg'></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Maklumat Lokasi</h2>
                                <p class="text-sm text-gray-600">Alamat dan lokasi masjid/surau</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Address Lines -->
                        <div class="space-y-4">
                            <div>
                                <label for="alamat_baris_1" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat Baris 1
                                </label>
                                <input type="text" name="alamat_baris_1" id="alamat_baris_1" x-model="formData.alamat_baris_1"
                                       value="{{ old('alamat_baris_1') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('alamat_baris_1') border-red-500 @enderror"
                                       placeholder="Alamat baris pertama">
                                @error('alamat_baris_1')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="alamat_baris_2" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat Baris 2
                                </label>
                                <input type="text" name="alamat_baris_2" id="alamat_baris_2" x-model="formData.alamat_baris_2"
                                       value="{{ old('alamat_baris_2') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('alamat_baris_2') border-red-500 @enderror"
                                       placeholder="Alamat baris kedua">
                                @error('alamat_baris_2')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="alamat_baris_3" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat Baris 3
                                </label>
                                <input type="text" name="alamat_baris_3" id="alamat_baris_3" x-model="formData.alamat_baris_3"
                                       value="{{ old('alamat_baris_3') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('alamat_baris_3') border-red-500 @enderror"
                                       placeholder="Alamat baris ketiga (opsional)">
                                @error('alamat_baris_3')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Poskod -->
                            <div>
                                <label for="poskod" class="block text-sm font-medium text-gray-700 mb-2">
                                    Poskod
                                </label>
                                <input type="text" name="poskod" id="poskod" x-model="formData.poskod"
                                       value="{{ old('poskod') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('poskod') border-red-500 @enderror"
                                       placeholder="Poskod">
                                @error('poskod')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bandar -->
                            <div>
                                <label for="bandar" class="block text-sm font-medium text-gray-700 mb-2">
                                    Bandar
                                </label>
                                <input type="text" name="bandar" id="bandar" x-model="formData.bandar"
                                       value="{{ old('bandar') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('bandar') border-red-500 @enderror"
                                       placeholder="Bandar">
                                @error('bandar')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Negeri -->
                            <div>
                                <label for="negeri" class="block text-sm font-medium text-gray-700 mb-2">
                                    Negeri
                                </label>
                                <select name="negeri" id="negeri" x-model="formData.negeri"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('negeri') border-red-500 @enderror">
                                    <option value="">Pilih Negeri</option>
                                    <option value="Johor" {{ old('negeri') == 'Johor' ? 'selected' : '' }}>Johor</option>
                                    <option value="Kedah" {{ old('negeri') == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                                    <option value="Kelantan" {{ old('negeri') == 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                                    <option value="Melaka" {{ old('negeri') == 'Melaka' ? 'selected' : '' }}>Melaka</option>
                                    <option value="Negeri Sembilan" {{ old('negeri') == 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                                    <option value="Pahang" {{ old('negeri') == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                                    <option value="Perak" {{ old('negeri') == 'Perak' ? 'selected' : '' }}>Perak</option>
                                    <option value="Perlis" {{ old('negeri') == 'Perlis' ? 'selected' : '' }}>Perlis</option>
                                    <option value="Pulau Pinang" {{ old('negeri') == 'Pulau Pinang' ? 'selected' : '' }}>Pulau Pinang</option>
                                    <option value="Sabah" {{ old('negeri') == 'Sabah' ? 'selected' : '' }}>Sabah</option>
                                    <option value="Sarawak" {{ old('negeri') == 'Sarawak' ? 'selected' : '' }}>Sarawak</option>
                                    <option value="Selangor" {{ old('negeri') == 'Selangor' ? 'selected' : '' }}>Selangor</option>
                                    <option value="Terengganu" {{ old('negeri') == 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                                    <option value="Wilayah Persekutuan Kuala Lumpur" {{ old('negeri') == 'Wilayah Persekutuan Kuala Lumpur' ? 'selected' : '' }}>Wilayah Persekutuan Kuala Lumpur</option>
                                    <option value="Wilayah Persekutuan Labuan" {{ old('negeri') == 'Wilayah Persekutuan Labuan' ? 'selected' : '' }}>Wilayah Persekutuan Labuan</option>
                                    <option value="Wilayah Persekutuan Putrajaya" {{ old('negeri') == 'Wilayah Persekutuan Putrajaya' ? 'selected' : '' }}>Wilayah Persekutuan Putrajaya</option>
                                </select>
                                @error('negeri')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Negara -->
                            <div>
                                <label for="negara" class="block text-sm font-medium text-gray-700 mb-2">
                                    Negara
                                </label>
                                <input type="text" name="negara" id="negara" x-model="formData.negara"
                                       value="{{ old('negara', 'Malaysia') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('negara') border-red-500 @enderror"
                                       placeholder="Negara">
                                @error('negara')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Daerah -->
                            <div>
                                <label for="daerah" class="block text-sm font-medium text-gray-700 mb-2">
                                    Daerah *
                                </label>
                                <input type="text" name="daerah" id="daerah" x-model="formData.daerah" required
                                       value="{{ old('daerah') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('daerah') border-red-500 @enderror"
                                       placeholder="Daerah">
                                @error('daerah')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information Section -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                <i class='bx bx-phone text-purple-600 text-lg'></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Maklumat Hubungan</h2>
                                <p class="text-sm text-gray-600">Maklumat untuk dihubungi</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- No Telefon -->
                            <div>
                                <label for="no_telefon" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombor Telefon
                                </label>
                                <div class="relative">
                                    <input type="text" name="no_telefon" id="no_telefon" x-model="formData.no_telefon"
                                           value="{{ old('no_telefon') }}"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('no_telefon') border-red-500 @enderror"
                                           placeholder="Nombor telefon">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                        <i class='bx bx-phone text-gray-400'></i>
                                    </div>
                                </div>
                                @error('no_telefon')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat Email
                                </label>
                                <div class="relative">
                                    <input type="email" name="email" id="email" x-model="formData.email"
                                           value="{{ old('email') }}"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('email') border-red-500 @enderror"
                                           placeholder="Alamat email">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                        <i class='bx bx-envelope text-gray-400'></i>
                                    </div>
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Catatan -->
                        <div>
                            <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan
                            </label>
                            <textarea name="catatan" id="catatan" rows="4" x-model="formData.catatan"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('catatan') border-red-500 @enderror"
                                      placeholder="Catatan tambahan...">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            <span class="text-red-500">*</span> Medan wajib diisi
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.masjid-surau.index') }}" 
                               class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                                <i class='bx bx-x mr-2'></i>
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                                <i class='bx bx-save mr-2'></i>
                                Simpan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right Sidebar -->
        <div class="space-y-6">
            <!-- Preview Card -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Pratonton</h3>
                    <p class="text-sm text-gray-600">Pratonton maklumat yang dimasukkan</p>
                </div>
                <div class="p-6">
                    <div class="text-center mb-4">
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class='bx bx-buildings text-emerald-600 text-2xl'></i>
                        </div>
                        <h4 class="font-semibold text-gray-900" x-text="formData.nama || 'Nama Masjid/Surau'"></h4>
                        <p class="text-sm text-gray-600" x-text="formData.jenis || 'Jenis'"></p>
                        <p class="text-xs text-gray-500" x-text="formData.singkatan_nama ? '(' + formData.singkatan_nama + ')' : ''"></p>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-map text-gray-400'></i>
                            <span x-text="(formData.bandar && formData.negeri) ? formData.bandar + ', ' + formData.negeri : 'Lokasi'"></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-buildings text-gray-400'></i>
                            <span x-text="formData.daerah || 'Daerah'"></span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-check-circle text-gray-400'></i>
                            <span x-text="formData.status || 'Status'"></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tips -->
            <div class="bg-blue-50 rounded-xl border border-blue-200 p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-lightbulb text-blue-600 text-lg'></i>
                    </div>
                    <h3 class="font-semibold text-blue-900">Tips Pengisian</h3>
                </div>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li class="flex items-start space-x-2">
                        <i class='bx bx-check text-blue-600 mt-0.5'></i>
                        <span>Singkatan nama akan digunakan untuk penjanaan nombor siri aset</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <i class='bx bx-check text-blue-600 mt-0.5'></i>
                        <span>Pastikan alamat lengkap dengan menggunakan 3 baris alamat</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <i class='bx bx-check text-blue-600 mt-0.5'></i>
                        <span>Daerah adalah medan wajib untuk keperluan pelaporan</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <i class='bx bx-check text-blue-600 mt-0.5'></i>
                        <span>Maklumat hubungan membantu komunikasi yang lebih baik</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function masjidForm() {
    return {
        formData: {
            nama: '{{ old('nama') }}',
            singkatan_nama: '{{ old('singkatan_nama') }}',
            jenis: '{{ old('jenis') }}',
            alamat_baris_1: '{{ old('alamat_baris_1') }}',
            alamat_baris_2: '{{ old('alamat_baris_2') }}',
            alamat_baris_3: '{{ old('alamat_baris_3') }}',
            poskod: '{{ old('poskod') }}',
            bandar: '{{ old('bandar') }}',
            negeri: '{{ old('negeri') }}',
            negara: '{{ old('negara', 'Malaysia') }}',
            daerah: '{{ old('daerah') }}',
            status: '{{ old('status') }}',
            imam_ketua: '{{ old('imam_ketua') }}',
            bilangan_jemaah: '{{ old('bilangan_jemaah') }}',
            tahun_dibina: '{{ old('tahun_dibina') }}',
            no_telefon: '{{ old('no_telefon') }}',
            email: '{{ old('email') }}',
            catatan: '{{ old('catatan') }}'
        }
    }
}
</script>
@endsection
