@extends('layouts.admin')

@section('title', 'Edit Pergerakan Aset')
@section('page-title', 'Edit Pergerakan Aset')
@section('page-description', 'Kemaskini maklumat pergerakan aset')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Edit Pergerakan Aset</h1>
                <p class="text-emerald-100 text-lg">Kemaskini maklumat pergerakan untuk {{ $assetMovement->asset->nama_aset }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-edit text-emerald-200'></i>
                        <span class="text-emerald-100">Kemaskini Data</span>
                    </div>
                    <div class="flex items-center space-x-2">
                                            <div class="w-3 h-3 {{ $assetMovement->status_pergerakan === 'diluluskan' ? 'bg-green-400' : ($assetMovement->status_pergerakan === 'menunggu_kelulusan' ? 'bg-yellow-400' : 'bg-red-400') }} rounded-full"></div>
                    <span class="text-emerald-100">{{ ucfirst($assetMovement->status_pergerakan) }}</span>
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
        <a href="{{ route('admin.asset-movements.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Pergerakan Aset
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">Edit: {{ $assetMovement->jenis_pergerakan }}</span>
    </div>



    <!-- Form Card - Full Width -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <form action="{{ route('admin.asset-movements.update', $assetMovement) }}" method="POST" x-data="editMovementForm()" class="space-y-0">
            @csrf
            @method('PUT')

            <!-- Form Header -->
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Kemaskini Maklumat Pergerakan</h2>
                        <p class="text-sm text-gray-600">Edit maklumat pergerakan aset dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $assetMovement->status_pergerakan === 'diluluskan' ? 'bg-green-100 text-green-800' : ($assetMovement->status_pergerakan === 'menunggu_kelulusan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        <div class="w-2 h-2 {{ $assetMovement->status_pergerakan === 'diluluskan' ? 'bg-green-500' : ($assetMovement->status_pergerakan === 'menunggu_kelulusan' ? 'bg-yellow-500' : 'bg-red-500') }} rounded-full mr-2"></div>
                        {{ ucfirst($assetMovement->status_pergerakan) }}
                        </span>
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $assetMovement->jenis_pergerakan }}
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
                                <h3 class="text-lg font-semibold text-gray-900">Maklumat Aset</h3>
                                <p class="text-sm text-emerald-700">Aset yang terlibat dalam pergerakan</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 gap-6">
                            <!-- Asset Selection (Read-only) -->
                            <div>
                                <label for="asset_display" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-package mr-1'></i>
                                    Aset <span class="text-gray-500">(Read-only)</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="asset_display" 
                                           value="{{ $assetMovement->asset->nama_aset }} - {{ $assetMovement->asset->no_siri_pendaftaran }}"
                                           readonly
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                                    <i class='bx bx-package absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                <input type="hidden" name="asset_id" value="{{ $assetMovement->asset_id }}">
                            </div>

                            <!-- Asset Info Display -->
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <h4 class="text-sm font-medium text-gray-900 mb-3">Maklumat Aset</h4>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-600">Lokasi Semasa:</span>
                                        <span class="font-medium text-gray-900">{{ $assetMovement->asset->lokasi_penempatan }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Status:</span>
                                        <span class="font-medium text-gray-900">{{ $assetMovement->asset->status_aset }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Jenis:</span>
                                        <span class="font-medium text-gray-900">{{ $assetMovement->asset->jenis_aset }}</span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Nilai:</span>
                                        <span class="font-medium text-gray-900">RM {{ number_format($assetMovement->asset->nilai_perolehan, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Movement Details Section -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-transfer text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Butiran Pergerakan</h3>
                                <p class="text-sm text-purple-700">Kemaskini maklumat pergerakan</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Movement Type -->
                            <div>
                                <label for="jenis_pergerakan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-category mr-1'></i>
                                    Jenis Pergerakan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="jenis_pergerakan" 
                                            name="jenis_pergerakan" 
                                            required
                                            x-model="form.jenis_pergerakan"
                                            @change="toggleReturnDate()"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jenis_pergerakan') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Jenis</option>
                                        <option value="Pemindahan" {{ old('jenis_pergerakan', $assetMovement->jenis_pergerakan) === 'Pemindahan' ? 'selected' : '' }}>Pemindahan</option>
                                        <option value="Peminjaman" {{ old('jenis_pergerakan', $assetMovement->jenis_pergerakan) === 'Peminjaman' ? 'selected' : '' }}>Peminjaman</option>
                                        <option value="Pulangan" {{ old('jenis_pergerakan', $assetMovement->jenis_pergerakan) === 'Pulangan' ? 'selected' : '' }}>Pulangan</option>
                                    </select>
                                    <i class='bx bx-category absolute left-3 top-3.5 text-gray-400'></i>
                                    <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('jenis_pergerakan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Movement Date -->
                            <div>
                                <label for="tarikh_pergerakan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-calendar mr-1'></i>
                                    Tarikh Pergerakan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="date" 
                                           id="tarikh_pergerakan" 
                                           name="tarikh_pergerakan" 
                                           value="{{ old('tarikh_pergerakan', $assetMovement->tarikh_pergerakan ? $assetMovement->tarikh_pergerakan->format('Y-m-d') : '') }}"
                                           required
                                           x-model="form.tarikh_pergerakan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_pergerakan') border-red-500 @enderror bg-white">
                                    <i class='bx bx-calendar absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('tarikh_pergerakan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Source Masjid/Surau -->
                            <div>
                                <label for="masjid_surau_asal_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-building-house mr-1'></i>
                                    Masjid/Surau Asal <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="masjid_surau_asal_id" 
                                            name="masjid_surau_asal_id" 
                                            required
                                            x-model="form.masjid_surau_asal_id"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('masjid_surau_asal_id') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Masjid/Surau Asal</option>
                                        @foreach($masjidSuraus as $masjid)
                                            <option value="{{ $masjid->id }}" {{ old('masjid_surau_asal_id', $assetMovement->masjid_surau_asal_id) == $masjid->id ? 'selected' : '' }}>
                                                {{ $masjid->nama }} ({{ $masjid->jenis }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class='bx bx-building-house absolute left-3 top-3.5 text-gray-400'></i>
                                    <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('masjid_surau_asal_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Destination Masjid/Surau -->
                            <div>
                                <label for="masjid_surau_destinasi_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-building-house mr-1'></i>
                                    Masjid/Surau Destinasi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="masjid_surau_destinasi_id" 
                                            name="masjid_surau_destinasi_id" 
                                            required
                                            x-model="form.masjid_surau_destinasi_id"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('masjid_surau_destinasi_id') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Masjid/Surau Destinasi</option>
                                        @foreach($masjidSuraus as $masjid)
                                            <option value="{{ $masjid->id }}" {{ old('masjid_surau_destinasi_id', $assetMovement->masjid_surau_destinasi_id) == $masjid->id ? 'selected' : '' }}>
                                                {{ $masjid->nama }} ({{ $masjid->jenis }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class='bx bx-building-house absolute left-3 top-3.5 text-gray-400'></i>
                                    <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('masjid_surau_destinasi_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Detailed Source Location -->
                            <div>
                                <label for="lokasi_terperinci_asal" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-map-pin mr-1'></i>
                                    Lokasi Terperinci Asal <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="lokasi_terperinci_asal" 
                                           name="lokasi_terperinci_asal" 
                                           value="{{ old('lokasi_terperinci_asal', $assetMovement->lokasi_terperinci_asal) }}"
                                           required
                                           placeholder="Contoh: Bilik Stor Tingkat 1"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('lokasi_terperinci_asal') border-red-500 @enderror bg-white">
                                    <i class='bx bx-map-pin absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('lokasi_terperinci_asal')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Detailed Destination Location -->
                            <div>
                                <label for="lokasi_terperinci_destinasi" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-map-pin mr-1'></i>
                                    Lokasi Terperinci Destinasi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="lokasi_terperinci_destinasi" 
                                           name="lokasi_terperinci_destinasi" 
                                           value="{{ old('lokasi_terperinci_destinasi', $assetMovement->lokasi_terperinci_destinasi) }}"
                                           required
                                           placeholder="Contoh: Ruang Solat Utama"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('lokasi_terperinci_destinasi') border-red-500 @enderror bg-white">
                                    <i class='bx bx-map-pin absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('lokasi_terperinci_destinasi')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Application Date -->
                            <div>
                                <label for="tarikh_permohonan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-calendar-plus mr-1'></i>
                                    Tarikh Permohonan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="date" 
                                           id="tarikh_permohonan" 
                                           name="tarikh_permohonan" 
                                           value="{{ old('tarikh_permohonan', $assetMovement->tarikh_permohonan ? $assetMovement->tarikh_permohonan->format('Y-m-d') : '') }}"
                                           required
                                           x-model="form.tarikh_permohonan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_permohonan') border-red-500 @enderror bg-white">
                                    <i class='bx bx-calendar-plus absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('tarikh_permohonan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Expected Return Date (for borrowing) -->
                            <div x-show="form.jenis_pergerakan === 'Peminjaman'">
                                <label for="tarikh_jangka_pulangan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-time mr-1'></i>
                                    Tarikh Jangka Pulangan
                                </label>
                                <div class="relative">
                                    <input type="date" 
                                           id="tarikh_jangka_pulangan" 
                                           name="tarikh_jangka_pulangan" 
                                           value="{{ old('tarikh_jangka_pulangan', $assetMovement->tarikh_jangka_pulangan ? $assetMovement->tarikh_jangka_pulangan->format('Y-m-d') : '') }}"
                                           x-model="form.tarikh_jangka_pulangan"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_jangka_pulangan') border-red-500 @enderror bg-white">
                                    <i class='bx bx-time absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('tarikh_jangka_pulangan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Responsible Person Section -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-user text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Pegawai Bertanggungjawab</h3>
                                <p class="text-sm text-blue-700">Kemaskini maklumat pegawai</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Responsible Person -->
                            <div>
                                <label for="nama_peminjam_pegawai_bertanggungjawab" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-user mr-1'></i>
                                    Pegawai Bertanggungjawab <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="nama_peminjam_pegawai_bertanggungjawab" 
                                           name="nama_peminjam_pegawai_bertanggungjawab" 
                                           value="{{ old('nama_peminjam_pegawai_bertanggungjawab', $assetMovement->nama_peminjam_pegawai_bertanggungjawab) }}"
                                           required
                                           x-model="form.nama_peminjam_pegawai_bertanggungjawab"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nama_peminjam_pegawai_bertanggungjawab') border-red-500 @enderror bg-white"
                                           placeholder="Nama pegawai yang bertanggungjawab">
                                    <i class='bx bx-user absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('nama_peminjam_pegawai_bertanggungjawab')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>


                        </div>
                    </div>

                    <!-- Additional Notes Section -->
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-note text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Catatan Tambahan</h3>
                                <p class="text-sm text-amber-700">Kemaskini maklumat tambahan</p>
                            </div>
                        </div>
                        
                        <div class="space-y-6">
                            <!-- Purpose -->
                            <div>
                                <label for="sebab_pergerakan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-target mr-1'></i>
                                    Sebab Pergerakan <span class="text-red-500">*</span>
                                </label>
                                <textarea id="sebab_pergerakan" 
                                          name="sebab_pergerakan" 
                                          rows="3"
                                          required
                                          x-model="form.sebab_pergerakan"
                                          class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('sebab_pergerakan') border-red-500 @enderror bg-white"
                                          placeholder="Sebab dan tujuan pergerakan aset ini...">{{ old('sebab_pergerakan', $assetMovement->sebab_pergerakan) }}</textarea>
                                @error('sebab_pergerakan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Remarks -->
                            <div>
                                <label for="catatan_pergerakan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-note mr-1'></i>
                                    Catatan Pergerakan
                                </label>
                                <textarea id="catatan_pergerakan" 
                                          name="catatan_pergerakan" 
                                          rows="3"
                                          x-model="form.catatan_pergerakan"
                                          class="w-full px-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('catatan_pergerakan') border-red-500 @enderror bg-white"
                                          placeholder="Catatan tambahan (pilihan)">{{ old('catatan_pergerakan', $assetMovement->catatan_pergerakan) }}</textarea>
                                @error('catatan_pergerakan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Preview & Info -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        
                        <!-- Movement Preview -->
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-100 rounded-xl p-6 border border-indigo-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-transfer text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Pratonton Pergerakan</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                        <i class='bx bx-transfer text-emerald-700 text-xl'></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900" x-text="form.jenis_pergerakan || '{{ $assetMovement->jenis_pergerakan }}'">{{ $assetMovement->jenis_pergerakan }}</p>
                                        <p class="text-sm text-gray-500">Permohonan: <span x-text="form.tarikh_permohonan || '{{ $assetMovement->tarikh_permohonan ? $assetMovement->tarikh_permohonan->format('d/m/Y') : '' }}'">{{ $assetMovement->tarikh_permohonan ? $assetMovement->tarikh_permohonan->format('d/m/Y') : '' }}</span></p>
                                        <p class="text-sm text-gray-500">Pergerakan: <span x-text="form.tarikh_pergerakan || '{{ $assetMovement->tarikh_pergerakan ? $assetMovement->tarikh_pergerakan->format('d/m/Y') : '' }}'">{{ $assetMovement->tarikh_pergerakan ? $assetMovement->tarikh_pergerakan->format('d/m/Y') : '' }}</span></p>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Dari:</span>
                                        <span class="text-sm font-medium" x-text="form.lokasi_terperinci_asal || '{{ $assetMovement->lokasi_terperinci_asal }}'">{{ $assetMovement->lokasi_terperinci_asal }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Ke:</span>
                                        <span class="text-sm font-medium" x-text="form.lokasi_terperinci_destinasi || '{{ $assetMovement->lokasi_terperinci_destinasi }}'">{{ $assetMovement->lokasi_terperinci_destinasi }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Pegawai:</span>
                                        <span class="text-sm font-medium" x-text="form.nama_peminjam_pegawai_bertanggungjawab || '{{ $assetMovement->nama_peminjam_pegawai_bertanggungjawab }}'">{{ $assetMovement->nama_peminjam_pegawai_bertanggungjawab }}</span>
                                    </div>
                                    @if($assetMovement->tarikh_jangka_pulangan || $assetMovement->jenis_pergerakan === 'Peminjaman')
                                    <div x-show="form.jenis_pergerakan === 'Peminjaman'" class="flex justify-between">
                                        <span class="text-sm text-gray-600">Pulang:</span>
                                        <span class="text-sm font-medium" x-text="form.tarikh_jangka_pulangan || '{{ $assetMovement->tarikh_jangka_pulangan ? $assetMovement->tarikh_jangka_pulangan->format('Y-m-d') : '-' }}'">{{ $assetMovement->tarikh_jangka_pulangan ? $assetMovement->tarikh_jangka_pulangan->format('Y-m-d') : '-' }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Movement Summary -->
                        <div class="bg-white rounded-xl p-6 border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pergerakan</h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Status:</span>
                                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $assetMovement->status_pergerakan === 'diluluskan' ? 'bg-green-100 text-green-800' : ($assetMovement->status_pergerakan === 'menunggu_kelulusan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    <div class="w-2 h-2 {{ $assetMovement->status_pergerakan === 'diluluskan' ? 'bg-green-500' : ($assetMovement->status_pergerakan === 'menunggu_kelulusan' ? 'bg-yellow-500' : 'bg-red-500') }} rounded-full mr-1"></div>
                                    {{ ucfirst($assetMovement->status_pergerakan) }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Jenis:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $assetMovement->jenis_pergerakan }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Dicipta:</span>
                                    <span class="text-sm font-medium">{{ $assetMovement->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Aset:</span>
                                    <span class="text-sm font-medium">{{ $assetMovement->asset->nama_aset }}</span>
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
                                <a href="{{ route('admin.asset-movements.show', $assetMovement) }}" 
                                   class="w-full flex items-center justify-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg transition-colors">
                                    <i class='bx bx-show mr-2'></i>
                                    Lihat Detail
                                </a>
                                
                                <button type="button" onclick="window.print()"
                                        class="w-full flex items-center justify-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                                    <i class='bx bx-printer mr-2'></i>
                                    Cetak
                                </button>
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
                        Kemaskini terakhir: {{ $assetMovement->updated_at->format('d/m/Y H:i') }}
                    </div>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.asset-movements.index') }}" 
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
    function editMovementForm() {
        return {
            form: {
                jenis_pergerakan: '{{ old('jenis_pergerakan', $assetMovement->jenis_pergerakan) }}',
                tarikh_permohonan: '{{ old('tarikh_permohonan', $assetMovement->tarikh_permohonan ? $assetMovement->tarikh_permohonan->format('Y-m-d') : '') }}',
                tarikh_pergerakan: '{{ old('tarikh_pergerakan', $assetMovement->tarikh_pergerakan ? $assetMovement->tarikh_pergerakan->format('Y-m-d') : '') }}',
                masjid_surau_asal_id: '{{ old('masjid_surau_asal_id', $assetMovement->masjid_surau_asal_id) }}',
                masjid_surau_destinasi_id: '{{ old('masjid_surau_destinasi_id', $assetMovement->masjid_surau_destinasi_id) }}',
                lokasi_terperinci_asal: '{{ old('lokasi_terperinci_asal', $assetMovement->lokasi_terperinci_asal) }}',
                lokasi_terperinci_destinasi: '{{ old('lokasi_terperinci_destinasi', $assetMovement->lokasi_terperinci_destinasi) }}',
                tarikh_jangka_pulangan: '{{ old('tarikh_jangka_pulangan', $assetMovement->tarikh_jangka_pulangan ? $assetMovement->tarikh_jangka_pulangan->format('Y-m-d') : '') }}',
                nama_peminjam_pegawai_bertanggungjawab: '{{ old('nama_peminjam_pegawai_bertanggungjawab', $assetMovement->nama_peminjam_pegawai_bertanggungjawab) }}',
                sebab_pergerakan: '{{ old('sebab_pergerakan', $assetMovement->sebab_pergerakan) }}',
                catatan_pergerakan: '{{ old('catatan_pergerakan', $assetMovement->catatan_pergerakan) }}'
            },
            
            toggleReturnDate() {
                if (this.form.jenis_pergerakan !== 'Peminjaman') {
                    this.form.tarikh_jangka_pulangan = '';
                }
            }
        }
    }

    // Form validation
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form');
        const requiredFields = form.querySelectorAll('[required]');
        
        form.addEventListener('submit', function(e) {
            let hasErrors = false;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    hasErrors = true;
                    field.classList.add('border-red-500');
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            if (hasErrors) {
                e.preventDefault();
                alert('Sila lengkapkan semua medan yang diperlukan.');
            }
        });
    });
</script>
@endpush
@endsection 