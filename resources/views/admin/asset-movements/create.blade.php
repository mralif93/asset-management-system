@extends('layouts.admin')

@section('title', 'Tambah Pergerakan Aset')
@section('page-title', 'Tambah Pergerakan Aset')
@section('page-description', 'Daftar pergerakan baru untuk aset')

@section('content')
    <div class="p-6">
        <!-- Welcome Header -->
        <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Tambah Pergerakan Aset</h1>
                    <p class="text-emerald-100 text-lg">Daftar pergerakan baru untuk pemindahan atau peminjaman aset</p>
                    <div class="flex items-center space-x-4 mt-4">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-plus text-emerald-200'></i>
                            <span class="text-emerald-100">Pergerakan Baru</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-time text-emerald-200'></i>
                            <span class="text-emerald-100">Menunggu Kelulusan</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <i class='bx bx-transfer text-6xl text-emerald-200'></i>
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
            <span class="text-emerald-600 font-medium">Tambah Pergerakan</span>
        </div>



        <!-- Form Card - Full Width -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <form action="{{ route('admin.asset-movements.store') }}" method="POST" x-data="createMovementForm()"
                class="space-y-0">
                @csrf

                <!-- Form Header -->
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Maklumat Pergerakan Aset</h2>
                            <p class="text-sm text-gray-600">Lengkapkan maklumat pergerakan aset yang akan dilakukan</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                                Menunggu Kelulusan
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Form Content - Two Column Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-6">

                    <!-- Left Column - Main Form -->
                    <div class="lg:col-span-2 space-y-8">

                        <!-- Asset Selection Section -->
                        <div
                            class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <i class='bx bx-package text-white text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Pilihan Aset</h3>
                                    <p class="text-sm text-emerald-700">Pilih aset yang akan digerakkan</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6">
                                <!-- Asset Selection -->
                                <div>
                                    <label for="asset_id" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-package mr-1'></i>
                                        Aset <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-package text-gray-400'></i>
                                        </div>
                                        <select id="asset_id" name="asset_id" required x-model="form.asset_id"
                                            @change="updateAssetInfo($event)"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('asset_id') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">Pilih Aset</option>
                                            @foreach($assets as $asset)
                                                <option value="{{ $asset->id }}"
                                                    data-quantity="{{ $asset->available_quantity ?? ($asset->batch_siblings_count ?? 1) }}"
                                                    data-original-quantity="{{ $asset->batch_siblings_count ?? 1 }}"
                                                    {{ (isset($asset->available_quantity) && $asset->available_quantity <= 0) ? 'disabled' : '' }}
                                                    {{ old('asset_id', request('asset_id')) == $asset->id ? 'selected' : '' }}>
                                                    {{ $asset->nama_aset }} - {{ $asset->no_siri_pendaftaran }}
                                                    ({{ $asset->available_quantity ?? ($asset->batch_siblings_count ?? 1) }} Unit Available)
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class='bx bx-chevron-down text-gray-400'></i>
                                        </div>
                                    </div>
                                    @error('asset_id')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Asset Info Display -->
                                <div x-show="form.asset_id" class="bg-white rounded-lg p-4 border border-gray-200">
                                    <h4 class="text-sm font-medium text-gray-900 mb-3">Maklumat Aset Dipilih</h4>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600">Lokasi Semasa:</span>
                                            <span class="font-medium text-gray-900"
                                                x-text="assetInfo.current_location || '-'"></span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Status:</span>
                                            <span class="font-medium text-gray-900" x-text="assetInfo.status || '-'"></span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Jenis:</span>
                                            <span class="font-medium text-gray-900" x-text="assetInfo.type || '-'"></span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Nilai:</span>
                                            <span class="font-medium text-gray-900" x-text="assetInfo.value || '-'"></span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Kuantiti Semasa:</span>
                                            <span class="font-medium text-emerald-600" x-text="assetInfo.quantity || '-'"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Movement Details Section -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <i class='bx bx-transfer text-white text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Butiran Pergerakan</h3>
                                    <p class="text-sm text-purple-700">Maklumat terperinci tentang pergerakan</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- ROW 1: Type & Quantity -->
                                <!-- Movement Type -->
                                <div>
                                    <label for="jenis_pergerakan" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-category mr-1'></i>
                                        Jenis Pergerakan <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-category text-gray-400'></i>
                                        </div>
                                        <select id="jenis_pergerakan" name="jenis_pergerakan" required
                                            x-model="form.jenis_pergerakan" @change="toggleReturnDate()"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jenis_pergerakan') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">Pilih Jenis</option>
                                            <option value="Pemindahan" {{ old('jenis_pergerakan') === 'Pemindahan' ? 'selected' : '' }}>Pemindahan</option>
                                            <option value="Peminjaman" {{ old('jenis_pergerakan') === 'Peminjaman' ? 'selected' : '' }}>Peminjaman</option>
                                            <option value="Pulangan" {{ old('jenis_pergerakan') === 'Pulangan' ? 'selected' : '' }}>Pulangan</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <i class='bx bx-chevron-down text-gray-400'></i>
                                        </div>
                                    </div>
                                    @error('jenis_pergerakan')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Quantity -->
                                <div>
                                    <label for="kuantiti" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-abacus mr-1'></i>
                                        Kuantiti <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-abacus text-gray-400'></i>
                                        </div>
                                        <input type="number" id="kuantiti" name="kuantiti" value="{{ old('kuantiti', 1) }}"
                                            min="1" required x-model="form.kuantiti"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kuantiti') border-red-500 @enderror bg-white"
                                            placeholder="1">
                                    </div>
                                    @error('kuantiti')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- ROW 2: Dates -->
                                <!-- Movement Date -->
                                <div class="col-span-1 md:col-span-2">
                                    <label for="tarikh_pergerakan" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-calendar mr-1'></i>
                                        Tarikh Pergerakan <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-calendar text-gray-400'></i>
                                        </div>
                                        <input type="date" id="tarikh_pergerakan" name="tarikh_pergerakan"
                                            value="{{ old('tarikh_pergerakan', date('Y-m-d')) }}" required
                                            x-model="form.tarikh_pergerakan"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_pergerakan') border-red-500 @enderror bg-white">
                                    </div>
                                    @error('tarikh_pergerakan')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Expected Return Date (for borrowing) - Moved here -->
                                <div x-show="form.jenis_pergerakan === 'Peminjaman'">
                                    <label for="tarikh_jangka_pulang" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-time mr-1'></i>
                                        Tarikh Jangka Pulangan
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-time text-gray-400'></i>
                                        </div>
                                        <input type="date" id="tarikh_jangka_pulang" name="tarikh_jangka_pulang"
                                            value="{{ old('tarikh_jangka_pulang') }}" x-model="form.tarikh_jangka_pulang"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_jangka_pulang') border-red-500 @enderror bg-white">
                                    </div>
                                    @error('tarikh_jangka_pulang')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- ROW 3: Masjids (Aligned) -->
                                <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Source Masjid/Surau -->
                                    <div>
                                        <label for="origin_masjid_surau_id"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class='bx bx-building-house mr-1'></i>
                                            Masjid/Surau Asal <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class='bx bx-building-house text-gray-400'></i>
                                            </div>
                                            <select id="origin_masjid_surau_id" name="origin_masjid_surau_id" required
                                                x-model="form.origin_masjid_surau_id"
                                                class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('origin_masjid_surau_id') border-red-500 @enderror appearance-none bg-white">
                                                <option value="">Pilih Masjid/Surau Asal</option>
                                                @foreach($masjidSuraus as $masjid)
                                                    <option value="{{ $masjid->id }}" {{ old('origin_masjid_surau_id', $default_masjid_surau_id) == $masjid->id ? 'selected' : '' }}>
                                                        {{ $masjid->nama }} {{ $masjid->nama !== 'Lain-lain' ? '('.$masjid->jenis.')' : '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <i class='bx bx-chevron-down text-gray-400'></i>
                                            </div>
                                        </div>
                                        @error('origin_masjid_surau_id')
                                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                                <i class='bx bx-error-circle mr-1'></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Destination Masjid/Surau -->
                                    <div>
                                        <label for="destination_masjid_surau_id"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class='bx bx-building-house mr-1'></i>
                                            Masjid/Surau Destinasi <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class='bx bx-building-house text-gray-400'></i>
                                            </div>
                                            <select id="destination_masjid_surau_id" name="destination_masjid_surau_id"
                                                required x-model="form.destination_masjid_surau_id"
                                                class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('destination_masjid_surau_id') border-red-500 @enderror appearance-none bg-white">
                                                <option value="">Pilih Masjid/Surau Destinasi</option>
                                                @foreach($masjidSuraus as $masjid)
                                                    <option value="{{ $masjid->id }}" {{ old('destination_masjid_surau_id', $default_destination_masjid_id ?? '') == $masjid->id ? 'selected' : '' }}>
                                                        {{ $masjid->nama }} {{ $masjid->nama !== 'Lain-lain' ? '('.$masjid->jenis.')' : '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <i class='bx bx-chevron-down text-gray-400'></i>
                                            </div>
                                        </div>
                                        @error('destination_masjid_surau_id')
                                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                                <i class='bx bx-error-circle mr-1'></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Valid Locations Datalist -->
                                <datalist id="locations">
                                    @foreach($validLocations ?? [] as $location)
                                        <option value="{{ $location }}">
                                    @endforeach
                                </datalist>

                                <!-- ROW 4: Locations (Aligned) -->
                                <div class="col-span-1 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Detailed Source Location -->
                                    <div>
                                        <label for="lokasi_asal_spesifik"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class='bx bx-map-pin mr-1'></i>
                                            Lokasi Terperinci Asal <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class='bx bx-map-pin text-gray-400'></i>
                                            </div>
                                            <select id="lokasi_asal_spesifik" name="lokasi_asal_spesifik" required
                                                x-model="form.lokasi_asal_spesifik"
                                                class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('lokasi_asal_spesifik') border-red-500 @enderror appearance-none bg-white">
                                                <option value="">Pilih Lokasi Asal</option>
                                                @foreach($validLocations ?? [] as $location)
                                                    <option value="{{ $location }}" {{ old('lokasi_asal_spesifik') == $location ? 'selected' : '' }}>
                                                        {{ $location }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <i class='bx bx-chevron-down text-gray-400'></i>
                                            </div>
                                        </div>
                                        @error('lokasi_asal_spesifik')
                                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                                <i class='bx bx-error-circle mr-1'></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Detailed Destination Location -->
                                    <div>
                                        <label for="lokasi_destinasi_spesifik"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class='bx bx-map-pin mr-1'></i>
                                            Lokasi Terperinci Destinasi <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class='bx bx-map-pin text-gray-400'></i>
                                            </div>
                                            <select id="lokasi_destinasi_spesifik" name="lokasi_destinasi_spesifik"
                                                required x-model="form.lokasi_destinasi_spesifik"
                                                class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('lokasi_destinasi_spesifik') border-red-500 @enderror appearance-none bg-white">
                                                <option value="">Pilih Lokasi Destinasi</option>
                                                @foreach($validLocations ?? [] as $location)
                                                    <option value="{{ $location }}" {{ old('lokasi_destinasi_spesifik') == $location ? 'selected' : '' }}>
                                                        {{ $location }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div
                                                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                <i class='bx bx-chevron-down text-gray-400'></i>
                                            </div>
                                        </div>
                                        @error('lokasi_destinasi_spesifik')
                                            <p class="mt-1 text-sm text-red-600 flex items-center">
                                                <i class='bx bx-error-circle mr-1'></i>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- ROW 5: Signature (Full Width) -->
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-pen mr-1'></i>
                                        Tandatangan Pegawai Bertanggungjawab <span class="text-red-500">*</span>
                                    </label>
                                    <div class="border border-gray-300 rounded-lg overflow-hidden bg-white relative">
                                        <canvas id="signature-pad" class="w-full h-40 touch-none" width="800"
                                            height="200"></canvas>
                                        <div class="absolute top-2 right-2">
                                            <button type="button" @click="clearSignature()"
                                                class="text-xs bg-gray-200 hover:bg-gray-300 text-gray-700 px-2 py-1 rounded transition-colors">
                                                Padam
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Sila tandatangan dalam kotak di atas.</p>
                                    <input type="hidden" id="pegawai_bertanggungjawab_signature"
                                        name="pegawai_bertanggungjawab_signature"
                                        x-model="form.pegawai_bertanggungjawab_signature" required>
                                    @error('pegawai_bertanggungjawab_signature')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- ROW 6: Responsible Person (Full Width, Below Signature) -->
                                <div class="col-span-1 md:col-span-2">
                                    <label for="nama_peminjam_pegawai_bertanggungjawab"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-user mr-1'></i>
                                        Pegawai Bertanggungjawab <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-user text-gray-400'></i>
                                        </div>
                                        <input type="text" id="nama_peminjam_pegawai_bertanggungjawab"
                                            name="nama_peminjam_pegawai_bertanggungjawab"
                                            value="{{ old('nama_peminjam_pegawai_bertanggungjawab') }}" required
                                            x-model="form.nama_peminjam_pegawai_bertanggungjawab"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nama_peminjam_pegawai_bertanggungjawab') border-red-500 @enderror bg-white"
                                            placeholder="Nama pegawai yang bertanggungjawab">
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
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <i class='bx bx-note text-white text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Catatan Tambahan</h3>
                                    <p class="text-sm text-blue-700">Maklumat tambahan tentang pergerakan</p>
                                </div>
                            </div>

                            <div class="space-y-6">
                                <!-- Purpose -->
                                <div>
                                    <label for="tujuan_pergerakan" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-comment-detail mr-1'></i>
                                        Sebab Pergerakan <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute top-0 left-0 pl-3 pt-4 flex pointer-events-none z-10">
                                            <i class='bx bx-comment-detail text-gray-400'></i>
                                        </div>
                                        <textarea id="tujuan_pergerakan" name="tujuan_pergerakan" rows="3" required
                                            x-model="form.tujuan_pergerakan"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tujuan_pergerakan') border-red-500 @enderror bg-white"
                                            placeholder="Sebab dan tujuan pergerakan aset ini...">{{ old('tujuan_pergerakan') }}</textarea>
                                    </div>
                                    @error('tujuan_pergerakan')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Pembekal / Vendor -->
                                <div>
                                    <label for="pembekal" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-building mr-1'></i>
                                        Pembekal / Vendor (Jika ada)
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                            <i class='bx bx-store-alt text-gray-400'></i>
                                        </div>
                                        <input type="text" id="pembekal" name="pembekal" x-model="form.pembekal"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('pembekal') border-red-500 @enderror bg-white"
                                            placeholder="Nama Syarikat Pembekal atau Vendor (Pilihan)"
                                            value="{{ old('pembekal') }}">
                                    </div>
                                    @error('pembekal')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Remarks -->
                                <div>
                                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-note mr-1'></i>
                                        Catatan Pergerakan
                                    </label>
                                    <div class="relative">
                                        <div class="absolute top-0 left-0 pl-3 pt-4 flex pointer-events-none z-10">
                                            <i class='bx bx-notepad text-gray-400'></i>
                                        </div>
                                        <textarea id="catatan" name="catatan" rows="3" x-model="form.catatan"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('catatan') border-red-500 @enderror bg-white"
                                            placeholder="Catatan tambahan (pilihan)">{{ old('catatan') }}</textarea>
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
                    </div>

                    <!-- Right Column - Preview & Info -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-6 space-y-6">

                            <!-- Movement Preview -->
                            <div
                                class="bg-gradient-to-br from-indigo-50 to-purple-100 rounded-xl p-6 border border-indigo-200">
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
                                            <p class="font-medium text-gray-900"
                                                x-text="form.jenis_pergerakan || 'Jenis pergerakan'">Jenis pergerakan</p>
                                            <p class="text-sm text-gray-500" x-text="form.tarikh_pergerakan || 'Tarikh'">
                                                Tarikh</p>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Dari:</span>
                                            <span class="text-sm font-medium"
                                                x-text="form.lokasi_asal_spesifik || '-'">-</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Ke:</span>
                                            <span class="text-sm font-medium"
                                                x-text="form.lokasi_destinasi_spesifik || '-'">-</span>
                                        </div>

                                        <div x-show="form.jenis_pergerakan === 'Peminjaman'" class="flex justify-between">
                                            <span class="text-sm text-gray-600">Pulang:</span>
                                            <span class="text-sm font-medium"
                                                x-text="form.tarikh_jangka_pulang || '-'">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Guidelines -->
                            <div class="bg-white rounded-xl p-6 border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Panduan Pergerakan</h3>

                                <div class="space-y-3 text-sm">
                                    <div class="flex items-start space-x-2">
                                        <i class='bx bx-check-circle text-green-500 mt-0.5'></i>
                                        <span class="text-gray-700">Pastikan aset dalam keadaan baik sebelum
                                            pergerakan</span>
                                    </div>
                                    <div class="flex items-start space-x-2">
                                        <i class='bx bx-check-circle text-green-500 mt-0.5'></i>
                                        <span class="text-gray-700">Dokumentasikan kondisi aset sebelum dan selepas
                                            pergerakan</span>
                                    </div>
                                    <div class="flex items-start space-x-2">
                                        <i class='bx bx-check-circle text-green-500 mt-0.5'></i>
                                        <span class="text-gray-700">Pastikan lokasi destinasi sesuai untuk aset</span>
                                    </div>
                                    <div class="flex items-start space-x-2">
                                        <i class='bx bx-check-circle text-green-500 mt-0.5'></i>
                                        <span class="text-gray-700">Untuk peminjaman, tetapkan tarikh pulangan yang
                                            jelas</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div
                                class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-6 border border-green-200">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                        <i class='bx bx-info-circle text-white'></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Maklumat</h3>
                                </div>

                                <div class="space-y-3 text-sm">
                                    <div class="p-3 bg-blue-50 rounded-lg border border-blue-200">
                                        <div class="flex items-center text-blue-800">
                                            <i class='bx bx-info-circle mr-2'></i>
                                            <span class="font-medium">Status Pergerakan</span>
                                        </div>
                                        <p class="text-blue-700 mt-1">Pergerakan akan berstatus "Menunggu Kelulusan" selepas
                                            didaftarkan</p>
                                    </div>
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
                            Pergerakan akan memerlukan kelulusan sebelum diproses
                        </div>

                        <div class="flex space-x-3">
                            <a href="{{ route('admin.asset-movements.index') }}"
                                class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                                <i class='bx bx-x mr-2'></i>
                                Batal
                            </a>
                            <button type="submit"
                                class="px-8 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                                <i class='bx bx-plus mr-2'></i>
                                Daftar Pergerakan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function createMovementForm() {
                return {
                    signaturePad: null,
                    init() {
                        const canvas = document.getElementById('signature-pad');

                        // Resize canvas to fit container
                        const resizeCanvas = () => {
                            const ratio = Math.max(window.devicePixelRatio || 1, 1);
                            canvas.width = canvas.offsetWidth * ratio;
                            canvas.height = canvas.offsetHeight * ratio;
                            canvas.getContext("2d").scale(ratio, ratio);
                        };

                        window.addEventListener("resize", resizeCanvas);
                        resizeCanvas();

                        // Simple drawing logic without external library to keep it lightweight
                        const ctx = canvas.getContext('2d');
                        let isDrawing = false;
                        let lastX = 0;
                        let lastY = 0;

                        function getPos(e) {
                            const rect = canvas.getBoundingClientRect();
                            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                            return {
                                x: clientX - rect.left,
                                y: clientY - rect.top
                            };
                        }

                        function startDrawing(e) {
                            isDrawing = true;
                            const pos = getPos(e);
                            lastX = pos.x;
                            lastY = pos.y;
                            e.preventDefault();
                        }

                        function stopDrawing() {
                            if (isDrawing) {
                                isDrawing = false;
                                this.updateSignatureField();
                            }
                        }

                        function draw(e) {
                            if (!isDrawing) return;

                            const pos = getPos(e);
                            ctx.beginPath();
                            ctx.moveTo(lastX, lastY);
                            ctx.lineTo(pos.x, pos.y);
                            ctx.strokeStyle = '#000';
                            ctx.lineWidth = 2;
                            ctx.lineCap = 'round';
                            ctx.stroke();

                            lastX = pos.x;
                            lastY = pos.y;
                            e.preventDefault();
                        }

                        // Mouse events
                        canvas.addEventListener('mousedown', startDrawing.bind(this));
                        canvas.addEventListener('mousemove', draw.bind(this));
                        canvas.addEventListener('mouseup', stopDrawing.bind(this));
                        canvas.addEventListener('mouseout', stopDrawing.bind(this));

                        // Touch events
                        canvas.addEventListener('touchstart', startDrawing.bind(this));
                        canvas.addEventListener('touchmove', draw.bind(this));
                        canvas.addEventListener('touchend', stopDrawing.bind(this));
                    },
                    clearSignature() {
                        const canvas = document.getElementById('signature-pad');
                        const ctx = canvas.getContext('2d');
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        this.form.pegawai_bertanggungjawab_signature = '';
                    },
                    updateSignatureField() {
                        const canvas = document.getElementById('signature-pad');
                        // Only save if canvas is not empty
                        if (this.isCanvasEmpty(canvas)) {
                            this.form.pegawai_bertanggungjawab_signature = '';
                        } else {
                            this.form.pegawai_bertanggungjawab_signature = canvas.toDataURL();
                        }
                    },
                    isCanvasEmpty(canvas) {
                        const blank = document.createElement('canvas');
                        blank.width = canvas.width;
                        blank.height = canvas.height;
                        return canvas.toDataURL() === blank.toDataURL();
                    },
                    form: {
                        asset_id: '{{ old('asset_id') }}',
                        jenis_pergerakan: '{{ old('jenis_pergerakan') }}',
                        kuantiti: '{{ old('kuantiti', 1) }}',
                        tarikh_pergerakan: '{{ old('tarikh_pergerakan', date('Y-m-d')) }}',
                        origin_masjid_surau_id: '{{ old('origin_masjid_surau_id', $default_masjid_surau_id ?? '') }}',
                                destination_masjid_surau_id: '{{ old('destination_masjid_surau_id', $default_destination_masjid_id ?? '') }}',
                                lokasi_asal_spesifik: '{{ old('lokasi_asal_spesifik') }}',
                                lokasi_destinasi_spesifik: '{{ old('lokasi_destinasi_spesifik') }}',
                                nama_peminjam_pegawai_bertanggungjawab: '{{ old('nama_peminjam_pegawai_bertanggungjawab') }}',
                                tarikh_jangka_pulang: '{{ old('tarikh_jangka_pulang') }}',
                                tujuan_pergerakan: '{{ old('tujuan_pergerakan') }}',
                                catatan: '{{ old('catatan') }}',
                                pembekal: '{{ old('pembekal') }}',
                                pegawai_bertanggungjawab_signature: ''
                            },
                            assetInfo: {
                                current_location: '',
                                status: '',
                                type: '',
                                value: '',
                                quantity: ''
                            },

                            updateAssetInfo(e) {
                                const selectedOption = e.target.options[e.target.selectedIndex];
                                if (selectedOption.value) {
                                    // Parse the quantity from the data attribute we will add
                                    const availableQty = parseInt(selectedOption.dataset.quantity) || 1;
                                    
                                    const assets = @json($assets->keyBy('id'));
                                    const selectedAsset = assets[selectedOption.value];
                                    
                                    if (selectedAsset) {
                                        this.assetInfo = {
                                            name: selectedOption.text.split(' - ')[0],
                                            regNo: selectedOption.text.split(' - ')[1],
                                            quantity: availableQty, // Use the real available quantity
                                            originalQty: parseInt(selectedOption.dataset.originalQuantity) || 1, // Keep original for reference
                                            
                                            // Restored fields
                                            current_location: selectedAsset.lokasi_penempatan || '-',
                                            status: selectedAsset.status_aset || '-',
                                            type: selectedAsset.jenis_aset || '-',
                                            value: 'RM ' + (selectedAsset.nilai_perolehan ? parseFloat(selectedAsset.nilai_perolehan).toLocaleString() : '0')
                                        };

                                        this.form.lokasi_asal_spesifik = selectedAsset.lokasi_penempatan || '';
                                        // Auto-fill origin masjid
                                        this.form.origin_masjid_surau_id = selectedAsset.masjid_surau_id || '';
                                    }
                                } else {
                                    this.assetInfo = {
                                        current_location: '',
                                        status: '',
                                        type: '',
                                        value: '',
                                        quantity: ''
                                    };
                                }
                            },

                            toggleReturnDate() {
                                if (this.form.jenis_pergerakan !== 'Peminjaman') {
                                    this.form.tarikh_jangka_pulang = '';
                                }
                            }
                        }
                    }

                    // Form validation
                    document.addEventListener('DOMContentLoaded', function () {
                        const form = document.querySelector('form');
                        const requiredFields = form.querySelectorAll('[required]');

                        form.addEventListener('submit', function (e) {
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