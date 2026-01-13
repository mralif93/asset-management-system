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
                    <p class="text-emerald-100 text-lg">Kemaskini maklumat pergerakan untuk
                        {{ $assetMovement->asset->nama_aset }}</p>
                    <div class="flex items-center space-x-4 mt-4">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-edit text-emerald-200'></i>
                            <span class="text-emerald-100">Kemaskini Data</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div
                                class="w-3 h-3 {{ $assetMovement->status_pergerakan === 'diluluskan' ? 'bg-green-400' : ($assetMovement->status_pergerakan === 'menunggu_kelulusan' ? 'bg-yellow-400' : 'bg-red-400') }} rounded-full">
                            </div>
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
            <form action="{{ route('admin.asset-movements.update', $assetMovement) }}" method="POST"
                x-data="editMovementForm()" class="space-y-0">
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
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $assetMovement->status_pergerakan === 'diluluskan' ? 'bg-green-100 text-green-800' : ($assetMovement->status_pergerakan === 'menunggu_kelulusan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                <div
                                    class="w-2 h-2 {{ $assetMovement->status_pergerakan === 'diluluskan' ? 'bg-green-500' : ($assetMovement->status_pergerakan === 'menunggu_kelulusan' ? 'bg-yellow-500' : 'bg-red-500') }} rounded-full mr-2">
                                </div>
                                {{ ucfirst($assetMovement->status_pergerakan) }}
                            </span>
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
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
                        <div
                            class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
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
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <i class='bx bx-package text-gray-400'></i>
                                        </div>
                                        <input type="text" id="asset_display"
                                            value="{{ $assetMovement->asset->nama_aset }} - {{ $assetMovement->asset->no_siri_pendaftaran }}"
                                            readonly
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg bg-gray-100 text-gray-600">
                                    </div>
                                    <input type="hidden" name="asset_id" value="{{ $assetMovement->asset_id }}">
                                </div>

                                <!-- Asset Info Display -->
                                <div class="bg-white rounded-lg p-4 border border-gray-200">
                                    <h4 class="text-sm font-medium text-gray-900 mb-3">Maklumat Aset</h4>
                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-600">Lokasi Semasa:</span>
                                            <span
                                                class="font-medium text-gray-900">{{ $assetMovement->asset->lokasi_penempatan }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Status:</span>
                                            <span
                                                class="font-medium text-gray-900">{{ $assetMovement->asset->status_aset }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Jenis:</span>
                                            <span
                                                class="font-medium text-gray-900">{{ $assetMovement->asset->jenis_aset }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Nilai:</span>
                                            <span class="font-medium text-gray-900">RM
                                                {{ number_format($assetMovement->asset->nilai_perolehan, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-600">Kuantiti Semasa:</span>
                                            <span class="font-medium text-emerald-600">{{ $assetMovement->asset->batch_siblings_count ?? 1 }} unit</span>
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
                                    <p class="text-sm text-purple-700">Kemaskini maklumat pergerakan</p>
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
                                            <option value="Pemindahan" {{ old('jenis_pergerakan', $assetMovement->jenis_pergerakan) === 'Pemindahan' ? 'selected' : '' }}>
                                                Pemindahan</option>
                                            <option value="Peminjaman" {{ old('jenis_pergerakan', $assetMovement->jenis_pergerakan) === 'Peminjaman' ? 'selected' : '' }}>
                                                Peminjaman</option>
                                            <option value="Pulangan" {{ old('jenis_pergerakan', $assetMovement->jenis_pergerakan) === 'Pulangan' ? 'selected' : '' }}>Pulangan
                                            </option>
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
                                        <input type="number" id="kuantiti" name="kuantiti" value="{{ old('kuantiti', $assetMovement->kuantiti ?? 1) }}"
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
                                            value="{{ old('tarikh_pergerakan', $assetMovement->tarikh_pergerakan ? $assetMovement->tarikh_pergerakan->format('Y-m-d') : '') }}"
                                            required x-model="form.tarikh_pergerakan"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_pergerakan') border-red-500 @enderror bg-white">
                                    </div>
                                    @error('tarikh_pergerakan')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Expected Return Date (for borrowing) -->
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
                                            value="{{ old('tarikh_jangka_pulang', $assetMovement->tarikh_jangka_pulang ? $assetMovement->tarikh_jangka_pulang->format('Y-m-d') : '') }}"
                                            x-model="form.tarikh_jangka_pulang"
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
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class='bx bx-building-house text-gray-400'></i>
                                            </div>
                                            <select id="origin_masjid_surau_id" name="origin_masjid_surau_id" required
                                                x-model="form.origin_masjid_surau_id"
                                                class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('origin_masjid_surau_id') border-red-500 @enderror appearance-none bg-white">
                                                <option value="">Pilih Masjid/Surau Asal</option>
                                                @foreach($masjidSuraus as $masjid)
                                                    <option value="{{ $masjid->id }}" {{ old('origin_masjid_surau_id', $assetMovement->origin_masjid_surau_id) == $masjid->id ? 'selected' : '' }}>
                                                        {{ $masjid->nama }} ({{ $masjid->jenis }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
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
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class='bx bx-building-house text-gray-400'></i>
                                            </div>
                                            <select id="destination_masjid_surau_id" name="destination_masjid_surau_id" required
                                                x-model="form.destination_masjid_surau_id"
                                                class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('destination_masjid_surau_id') border-red-500 @enderror appearance-none bg-white">
                                                <option value="">Pilih Masjid/Surau Destinasi</option>
                                                @foreach($masjidSuraus as $masjid)
                                                    <option value="{{ $masjid->id }}" {{ old('destination_masjid_surau_id', $assetMovement->destination_masjid_surau_id) == $masjid->id ? 'selected' : '' }}>
                                                        {{ $masjid->nama }} ({{ $masjid->jenis }})
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
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
                                        <label for="lokasi_asal_spesifik" class="block text-sm font-medium text-gray-700 mb-2">
                                            <i class='bx bx-map-pin mr-1'></i>
                                            Lokasi Terperinci Asal <span class="text-red-500">*</span>
                                        </label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class='bx bx-map-pin text-gray-400'></i>
                                            </div>
                                            <select id="lokasi_asal_spesifik" name="lokasi_asal_spesifik"
                                                required x-model="form.lokasi_asal_spesifik"
                                                class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('lokasi_asal_spesifik') border-red-500 @enderror appearance-none bg-white">
                                                <option value="">Pilih Lokasi Asal</option>
                                                @foreach($validLocations ?? [] as $location)
                                                    <option value="{{ $location }}" {{ old('lokasi_asal_spesifik', $assetMovement->lokasi_asal_spesifik) == $location ? 'selected' : '' }}>
                                                        {{ $location }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
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
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <i class='bx bx-map-pin text-gray-400'></i>
                                            </div>
                                            <select id="lokasi_destinasi_spesifik" name="lokasi_destinasi_spesifik"
                                                required x-model="form.lokasi_destinasi_spesifik"
                                                class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('lokasi_destinasi_spesifik') border-red-500 @enderror appearance-none bg-white">
                                                <option value="">Pilih Lokasi Destinasi</option>
                                                @foreach($validLocations ?? [] as $location)
                                                    <option value="{{ $location }}" {{ old('lokasi_destinasi_spesifik', $assetMovement->lokasi_destinasi_spesifik) == $location ? 'selected' : '' }}>
                                                        {{ $location }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
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
                                        Tandatangan Pegawai Bertanggungjawab
                                    </label>
                                    <div class="border border-gray-300 rounded-lg overflow-hidden bg-white relative">
                                        <canvas id="signature-pad" class="w-full h-40 touch-none" width="800" height="200"></canvas>
                                        <div class="absolute top-2 right-2">
                                            <button type="button" @click="clearSignature()"
                                                class="text-xs bg-gray-200 hover:bg-gray-300 text-gray-700 px-2 py-1 rounded transition-colors">
                                                Padam
                                            </button>
                                        </div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Sila tandatangan dalam kotak di atas jika ingin mengemaskini.</p>
                                    <input type="hidden" id="pegawai_bertanggungjawab_signature"
                                        name="pegawai_bertanggungjawab_signature"
                                        x-model="form.pegawai_bertanggungjawab_signature">
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
                                            value="{{ old('nama_peminjam_pegawai_bertanggungjawab', $assetMovement->nama_peminjam_pegawai_bertanggungjawab) }}"
                                            required x-model="form.nama_peminjam_pegawai_bertanggungjawab"
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
                        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
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
                                            placeholder="Sebab dan tujuan pergerakan aset ini...">{{ old('tujuan_pergerakan', $assetMovement->tujuan_pergerakan) }}</textarea>
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
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                                            <i class='bx bx-store-alt text-gray-400'></i>
                                        </div>
                                        <input type="text" id="pembekal" name="pembekal" x-model="form.pembekal"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('pembekal') border-red-500 @enderror bg-white"
                                            placeholder="Nama Syarikat Pembekal atau Vendor (Pilihan)"
                                            value="{{ old('pembekal', $assetMovement->pembekal) }}">
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
                                            placeholder="Catatan tambahan (pilihan)">{{ old('catatan', $assetMovement->catatan) }}</textarea>
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
                                                x-text="form.jenis_pergerakan || '{{ $assetMovement->jenis_pergerakan }}'">
                                                {{ $assetMovement->jenis_pergerakan }}</p>
                                            <p class="text-sm text-gray-500">Permohonan: <span
                                                    x-text="form.tarikh_permohonan || '{{ $assetMovement->tarikh_permohonan ? $assetMovement->tarikh_permohonan->format('d/m/Y') : '' }}'">{{ $assetMovement->tarikh_permohonan ? $assetMovement->tarikh_permohonan->format('d/m/Y') : '' }}</span>
                                            </p>
                                            <p class="text-sm text-gray-500">Pergerakan: <span
                                                    x-text="form.tarikh_pergerakan || '{{ $assetMovement->tarikh_pergerakan ? $assetMovement->tarikh_pergerakan->format('d/m/Y') : '' }}'">{{ $assetMovement->tarikh_pergerakan ? $assetMovement->tarikh_pergerakan->format('d/m/Y') : '' }}</span>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Dari:</span>
                                            <span class="text-sm font-medium"
                                                x-text="form.lokasi_asal_spesifik || '{{ $assetMovement->lokasi_asal_spesifik }}'">{{ $assetMovement->lokasi_asal_spesifik }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Ke:</span>
                                            <span class="text-sm font-medium"
                                                x-text="form.lokasi_destinasi_spesifik || '{{ $assetMovement->lokasi_destinasi_spesifik }}'">{{ $assetMovement->lokasi_destinasi_spesifik }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Pegawai:</span>
                                            <span class="text-sm font-medium"
                                                x-text="form.nama_peminjam_pegawai_bertanggungjawab || '{{ $assetMovement->nama_peminjam_pegawai_bertanggungjawab }}'">{{ $assetMovement->nama_peminjam_pegawai_bertanggungjawab }}</span>
                                        </div>
                                        @if($assetMovement->tarikh_jangka_pulang || $assetMovement->jenis_pergerakan === 'Peminjaman')
                                            <div x-show="form.jenis_pergerakan === 'Peminjaman'" class="flex justify-between">
                                                <span class="text-sm text-gray-600">Pulang:</span>
                                                <span class="text-sm font-medium"
                                                    x-text="form.tarikh_jangka_pulang || '{{ $assetMovement->tarikh_jangka_pulang ? $assetMovement->tarikh_jangka_pulang->format('Y-m-d') : '-' }}'">{{ $assetMovement->tarikh_jangka_pulang ? $assetMovement->tarikh_jangka_pulang->format('Y-m-d') : '-' }}</span>
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
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $assetMovement->status_pergerakan === 'diluluskan' ? 'bg-green-100 text-green-800' : ($assetMovement->status_pergerakan === 'menunggu_kelulusan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            <div
                                                class="w-2 h-2 {{ $assetMovement->status_pergerakan === 'diluluskan' ? 'bg-green-500' : ($assetMovement->status_pergerakan === 'menunggu_kelulusan' ? 'bg-yellow-500' : 'bg-red-500') }} rounded-full mr-1">
                                            </div>
                                            {{ ucfirst($assetMovement->status_pergerakan) }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Jenis:</span>
                                        <span
                                            class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $assetMovement->jenis_pergerakan }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Dicipta:</span>
                                        <span
                                            class="text-sm font-medium">{{ $assetMovement->created_at->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Aset:</span>
                                        <span class="text-sm font-medium">{{ $assetMovement->asset->nama_aset }}</span>
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
                        kuantiti: '{{ old('kuantiti', $assetMovement->kuantiti ?? 1) }}',
                        tarikh_permohonan: '{{ old('tarikh_permohonan', $assetMovement->tarikh_permohonan ? $assetMovement->tarikh_permohonan->format('Y-m-d') : '') }}',
                        tarikh_pergerakan: '{{ old('tarikh_pergerakan', $assetMovement->tarikh_pergerakan ? $assetMovement->tarikh_pergerakan->format('Y-m-d') : '') }}',
                        masjid_surau_asal_id: '{{ old('origin_masjid_surau_id', $assetMovement->origin_masjid_surau_id) }}',
                        destination_masjid_surau_id: '{{ old('destination_masjid_surau_id', $assetMovement->destination_masjid_surau_id) }}',
                        lokasi_asal_spesifik: '{{ old('lokasi_asal_spesifik', $assetMovement->lokasi_asal_spesifik) }}',
                        lokasi_destinasi_spesifik: '{{ old('lokasi_destinasi_spesifik', $assetMovement->lokasi_destinasi_spesifik) }}',
                        tarikh_jangka_pulang: '{{ old('tarikh_jangka_pulang', $assetMovement->tarikh_jangka_pulang ? $assetMovement->tarikh_jangka_pulang->format('Y-m-d') : '') }}',
                        nama_peminjam_pegawai_bertanggungjawab: '{{ old('nama_peminjam_pegawai_bertanggungjawab', $assetMovement->nama_peminjam_pegawai_bertanggungjawab) }}',
                        tujuan_pergerakan: '{{ old('tujuan_pergerakan', $assetMovement->tujuan_pergerakan) }}',
                        catatan: '{{ old('catatan', $assetMovement->catatan) }}',
                        pegawai_bertanggungjawab_signature: '{{ old('pegawai_bertanggungjawab_signature', $assetMovement->pegawai_bertanggungjawab_signature) }}'
                    },

                    toggleReturnDate() {
                        if (this.form.jenis_pergerakan !== 'Peminjaman') {
                            this.form.tarikh_jangka_pulang = '';
                        }
                    },
                    
                    signaturePad: null,
                    canvas: null,
                    ctx: null,
                    isDrawing: false,

                    init() {
                        this.canvas = document.getElementById('signature-pad');
                        if (this.canvas) {
                            this.ctx = this.canvas.getContext('2d');
                            this.resizeCanvas();
                            window.addEventListener('resize', () => this.resizeCanvas());

                            // Load existing signature if available
                            if (this.form.pegawai_bertanggungjawab_signature) {
                                const img = new Image();
                                img.onload = () => {
                                    this.ctx.drawImage(img, 0, 0, this.canvas.width, this.canvas.height);
                                };
                                img.src = this.form.pegawai_bertanggungjawab_signature;
                            }

                            // Mouse events
                            this.canvas.addEventListener('mousedown', (e) => this.startDrawing(e));
                            this.canvas.addEventListener('mousemove', (e) => this.draw(e));
                            this.canvas.addEventListener('mouseup', () => this.stopDrawing());
                            this.canvas.addEventListener('mouseout', () => this.stopDrawing());

                            // Touch events
                            this.canvas.addEventListener('touchstart', (e) => {
                                e.preventDefault();
                                this.startDrawing(e.touches[0]);
                            });
                            this.canvas.addEventListener('touchmove', (e) => {
                                e.preventDefault();
                                this.draw(e.touches[0]);
                            });
                            this.canvas.addEventListener('touchend', (e) => {
                                e.preventDefault();
                                this.stopDrawing();
                            });
                        }
                    },

                    resizeCanvas() {
                        if (this.canvas) {
                            const ratio = Math.max(window.devicePixelRatio || 1, 1);
                            this.canvas.width = this.canvas.offsetWidth * ratio;
                            this.canvas.height = this.canvas.offsetHeight * ratio;
                            this.ctx.scale(ratio, ratio);
                        }
                    },

                    startDrawing(e) {
                        this.isDrawing = true;
                        const rect = this.canvas.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;
                        this.ctx.beginPath();
                        this.ctx.moveTo(x, y);
                    },

                    draw(e) {
                        if (!this.isDrawing) return;
                        const rect = this.canvas.getBoundingClientRect();
                        const x = e.clientX - rect.left;
                        const y = e.clientY - rect.top;
                        this.ctx.lineWidth = 2;
                        this.ctx.lineCap = 'round';
                        this.ctx.strokeStyle = '#000';
                        this.ctx.lineTo(x, y);
                        this.ctx.stroke();
                    },

                    stopDrawing() {
                        if (this.isDrawing) {
                            this.isDrawing = false;
                            this.updateSignatureField();
                        }
                    },

                    clearSignature() {
                        if (this.ctx) {
                            this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
                            this.form.pegawai_bertanggungjawab_signature = '';
                            document.getElementById('pegawai_bertanggungjawab_signature').value = '';
                        }
                    },

                    updateSignatureField() {
                        if (!this.isCanvasEmpty()) {
                            this.form.pegawai_bertanggungjawab_signature = this.canvas.toDataURL();
                            document.getElementById('pegawai_bertanggungjawab_signature').value = this.form.pegawai_bertanggungjawab_signature;
                        }
                    },

                    isCanvasEmpty() {
                        const blank = document.createElement('canvas');
                        blank.width = this.canvas.width;
                        blank.height = this.canvas.height;
                        return this.canvas.toDataURL() === blank.toDataURL();
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