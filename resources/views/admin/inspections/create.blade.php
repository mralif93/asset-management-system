@extends('layouts.admin')

@section('title', 'Tambah Pemeriksaan')
@section('page-title', 'Tambah Pemeriksaan Baru')
@section('page-description', 'Cipta rekod pemeriksaan aset baharu dalam sistem')

@section('content')
    <div class="p-6">
        <!-- Welcome Header -->
        <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Tambah Pemeriksaan Baru</h1>
                    <p class="text-emerald-100 text-lg">Cipta rekod pemeriksaan aset baharu dalam sistem</p>
                    <div class="flex items-center space-x-4 mt-4">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-search-alt-2 text-emerald-200'></i>
                            <span class="text-emerald-100">Rekod Pemeriksaan</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-shield-check text-emerald-200'></i>
                            <span class="text-emerald-100">Sistem Selamat</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <i class='bx bx-search-alt-2 text-6xl text-emerald-200'></i>
                </div>
            </div>
        </div>

        <!-- Navigation Breadcrumb -->
        <div class="flex items-center space-x-2 mb-6">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600">
                <i class='bx bx-home'></i>
            </a>
            <i class='bx bx-chevron-right text-gray-400'></i>
            <a href="{{ route('admin.inspections.index') }}" class="text-gray-500 hover:text-emerald-600">
                Pengurusan Pemeriksaan
            </a>
            <i class='bx bx-chevron-right text-gray-400'></i>
            <span class="text-emerald-600 font-medium">Tambah Pemeriksaan</span>
        </div>

        <!-- Progress Steps -->
        <div class="mb-8">
            <div class="flex items-center justify-center">
                <div class="flex items-center space-x-4">
                    <!-- Step 1 -->
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-semibold">
                            1
                        </div>
                        <span class="ml-2 text-sm font-medium text-emerald-600">Pilih Aset</span>
                    </div>
                    <div class="w-16 h-1 bg-gray-200 rounded"></div>

                    <!-- Step 2 -->
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">
                            2
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500">Maklumat Pemeriksaan</span>
                    </div>
                    <div class="w-16 h-1 bg-gray-200 rounded"></div>

                    <!-- Step 3 -->
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">
                            3
                        </div>
                        <span class="ml-2 text-sm font-medium text-gray-500">Semak & Simpan</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Card - Full Width -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <form action="{{ route('admin.inspections.store') }}" method="POST" enctype="multipart/form-data"
                x-data="inspectionForm()" class="space-y-0">
                @csrf

                <!-- Form Header -->
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Cipta Rekod Pemeriksaan Baru</h2>
                            <p class="text-sm text-gray-600">Isikan semua maklumat yang diperlukan untuk mencipta rekod
                                pemeriksaan</p>
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

                        <!-- Asset Selection Section -->
                        <div
                            class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <i class='bx bx-package text-white text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Pemilihan Aset</h3>
                                    <p class="text-sm text-emerald-700">Pilih aset yang akan diperiksa</p>
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
                                        <select id="asset_id" name="asset_id" required x-model="form.asset_id"
                                            @change="form.asset_name = $event.target.options[$event.target.selectedIndex].dataset.name"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('asset_id') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">Pilih Aset</option>
                                            @foreach($assets as $asset)
                                                <option value="{{ $asset->id }}" data-name="{{ $asset->nama_aset }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                                                    {{ $asset->nama_aset }} - {{ $asset->no_siri_pendaftaran }}
                                                    ({{ $asset->masjidSurau->nama ?? '' }})
                                                </option>
                                            @endforeach
                                        </select>
                                        <i class='bx bx-package absolute left-3 top-3.5 text-gray-400'></i>
                                        <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                    </div>
                                    @error('asset_id')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <p class="mt-1 text-xs text-emerald-600 flex items-center">
                                        <i class='bx bx-info-circle mr-1'></i>
                                        Pilih aset yang ingin diperiksa dari senarai yang tersedia
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Inspection Details Section -->
                        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <i class='bx bx-search-alt text-white text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Butiran Pemeriksaan</h3>
                                    <p class="text-sm text-purple-700">Maklumat tarikh dan kondisi aset</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Inspection Date -->
                                <div>
                                    <label for="tarikh_pemeriksaan" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-calendar mr-1'></i>
                                        Tarikh Pemeriksaan <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <input type="date" id="tarikh_pemeriksaan" name="tarikh_pemeriksaan"
                                            value="{{ old('tarikh_pemeriksaan', date('Y-m-d')) }}" required
                                            x-model="form.tarikh_pemeriksaan"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_pemeriksaan') border-red-500 @enderror bg-white">
                                        <i class='bx bx-calendar absolute left-3 top-3.5 text-gray-400'></i>
                                    </div>
                                    @error('tarikh_pemeriksaan')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Asset Condition -->
                                <div>
                                    <label for="kondisi_aset" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-check-circle mr-1'></i>
                                        Status Aset <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <select id="kondisi_aset" name="kondisi_aset" required x-model="form.kondisi_aset"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('kondisi_aset') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">Pilih Status Aset</option>
                                            <option value="Sedang Digunakan" {{ old('kondisi_aset') == 'Sedang Digunakan' ? 'selected' : '' }}>Sedang Digunakan</option>
                                            <option value="Tidak Digunakan" {{ old('kondisi_aset') == 'Tidak Digunakan' ? 'selected' : '' }}>Tidak Digunakan</option>
                                            <option value="Rosak" {{ old('kondisi_aset') == 'Rosak' ? 'selected' : '' }}>Rosak
                                            </option>
                                            <option value="Sedang Diselenggara" {{ old('kondisi_aset') == 'Sedang Diselenggara' ? 'selected' : '' }}>Sedang Diselenggara</option>
                                            <option value="Hilang" {{ old('kondisi_aset') == 'Hilang' ? 'selected' : '' }}>
                                                Hilang</option>
                                        </select>
                                        <i class='bx bx-check-circle absolute left-3 top-3.5 text-gray-400'></i>
                                        <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                    </div>
                                    @error('kondisi_aset')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Next Inspection Date -->
                                <div class="md:col-span-2 mt-4 border-t border-purple-200 pt-4">
                                    <label for="tarikh_pemeriksaan_akan_datang"
                                        class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-calendar-plus mr-1'></i>
                                        Cadangan Tarikh Pemeriksaan Seterusnya
                                    </label>
                                    <div class="relative">
                                        <input type="date" id="tarikh_pemeriksaan_akan_datang"
                                            name="tarikh_pemeriksaan_akan_datang"
                                            value="{{ old('tarikh_pemeriksaan_akan_datang') }}"
                                            x-model="form.tarikh_pemeriksaan_akan_datang"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tarikh_pemeriksaan_akan_datang') border-red-500 @enderror bg-white">
                                        <i class='bx bx-calendar-plus absolute left-3 top-3.5 text-gray-400'></i>
                                    </div>
                                    @error('tarikh_pemeriksaan_akan_datang')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    <!-- Inspector Details Section -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-user-check text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Butiran Pemeriksa</h3>
                                <p class="text-sm text-blue-700">Maklumat pegawai yang menjalankan pemeriksaan</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Inspector Name -->
                            <div>
                                <label for="nama_pemeriksa" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-user mr-1'></i>
                                    Nama Pemeriksa <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="nama_pemeriksa" name="nama_pemeriksa"
                                        value="{{ old('nama_pemeriksa', auth()->user()->name) }}" x-model="form.nama_pemeriksa"
                                        required
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nama_pemeriksa') border-red-500 @enderror bg-white">
                                    <i class='bx bx-user absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('nama_pemeriksa')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Position -->
                            <div>
                                <label for="jawatan_pemeriksa" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-id-card mr-1'></i>
                                    Jawatan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="jawatan_pemeriksa" name="jawatan_pemeriksa"
                                        value="{{ old('jawatan_pemeriksa') }}" x-model="form.jawatan_pemeriksa" required
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('jawatan_pemeriksa') border-red-500 @enderror bg-white"
                                        placeholder="Contoh: Pegawai Aset">
                                    <i class='bx bx-id-card absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('jawatan_pemeriksa')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Signature Pad -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-pen mr-1'></i>
                                Tandatangan Pemeriksa <span class="text-red-500">*</span>
                            </label>
                            <div class="border border-gray-300 rounded-lg bg-white overflow-hidden relative">
                                <canvas id="signature-pad" class="w-full h-48 cursor-crosshair"></canvas>
                                <div class="absolute bottom-2 right-2 flex space-x-2">
                                    <button type="button" @click="clearSignature()"
                                        class="px-3 py-1 text-xs bg-gray-200 hover:bg-gray-300 text-gray-700 rounded transition-colors">
                                        <i class='bx bx-reset mr-1'></i> Padam
                                    </button>
                                </div>
                                @if(!old('signature'))
                                <div x-show="!form.hasSignature"
                                    class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                    <div class="text-gray-400 text-sm flex flex-col items-center opacity-50">
                                        <i class='bx bx-edit text-3xl mb-1'></i>
                                        <span>Tandatangan di sini</span>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <input type="hidden" name="signature" id="signature-input" x-model="form.signature">
                            @error('signature')
                                <p class="mt-1 text-sm text-red-600 flex items-center">
                                    <i class='bx bx-error-circle mr-1'></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                        <!-- Notes and Actions Section -->
                        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                    <i class='bx bx-note text-white text-xl'></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Catatan & Tindakan</h3>
                                    <p class="text-sm text-amber-700">Maklumat tambahan dan tindakan diperlukan</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 mb-6">
                                <!-- Inspection Notes -->
                                <div>
                                    <label for="catatan_pemeriksaan" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-note mr-1'></i>
                                        Catatan Pemeriksaan
                                    </label>
                                    <div class="relative">
                                        <textarea id="catatan_pemeriksaan" name="catatan_pemeriksaan" rows="4"
                                            x-model="form.catatan_pemeriksaan"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('catatan_pemeriksaan') border-red-500 @enderror bg-white"
                                            placeholder="Catatan mengenai kondisi aset...">{{ old('catatan_pemeriksaan') }}</textarea>
                                        <i class='bx bx-note absolute left-3 top-4 text-gray-400'></i>
                                    </div>
                                    @error('catatan_pemeriksaan')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <!-- Required Actions -->
                                <div>
                                    <label for="tindakan_diperlukan" class="block text-sm font-medium text-gray-700 mb-2">
                                        <i class='bx bx-wrench mr-1'></i>
                                        Tindakan Diperlukan
                                    </label>
                                    <div class="relative">
                                        <textarea id="tindakan_diperlukan" name="tindakan_diperlukan" rows="4"
                                            x-model="form.tindakan_diperlukan"
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('tindakan_diperlukan') border-red-500 @enderror bg-white"
                                            placeholder="Tindakan yang perlu diambil...">{{ old('tindakan_diperlukan') }}</textarea>
                                        <i class='bx bx-wrench absolute left-3 top-4 text-gray-400'></i>
                                    </div>
                                    @error('tindakan_diperlukan')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Inspection Images -->
                            <div>
                                <label for="gambar_pemeriksaan" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-images mr-1'></i>
                                    Gambar Pemeriksaan
                                </label>
                                <div class="relative">
                                    <input type="file" id="gambar_pemeriksaan" name="gambar_pemeriksaan[]" multiple
                                        accept="image/*"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('gambar_pemeriksaan') border-red-500 @enderror bg-white">
                                    <i class='bx bx-images absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                <p class="mt-1 text-xs text-amber-600">Boleh pilih beberapa gambar sekaligus (format: JPG,
                                    PNG, maksimum 2MB setiap gambar)</p>
                                @error('gambar_pemeriksaan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Inspection Notice -->
                            <div class="mt-4 p-4 bg-emerald-50 rounded-lg border border-emerald-200">
                                <div class="flex">
                                    <i class='bx bx-info-circle text-emerald-600 text-lg mt-0.5'></i>
                                    <div class="ml-3">
                                        <p class="text-sm text-emerald-800">
                                            <strong>Nota:</strong> Pastikan semua maklumat pemeriksaan adalah tepat dan
                                            lengkap untuk rujukan masa hadapan.
                                        </p>
                                    </div>
                                </div>
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
                                    <h3 class="text-lg font-semibold text-gray-900">Pratonton Pemeriksaan</h3>
                                </div>

                                    <div class="space-y-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                            <i class='bx bx-search-alt text-emerald-700 text-xl'></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900"
                                                x-text="form.asset_name || 'Pilih Aset'">Pilih Aset</p>
                                            <p class="text-sm text-gray-500"
                                                x-text="formatDate(form.tarikh_pemeriksaan) || 'Tarikh pemeriksaan'">Tarikh pemeriksaan
                                            </p>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Kondisi:</span>
                                            <span class="text-sm font-medium" x-text="form.kondisi_aset || '-'">-</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Pemeriksa:</span>
                                            <span class="text-sm font-medium" x-text="form.nama_pemeriksa || '-'">-</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Pemeriksaan Seterusnya:</span>
                                            <span class="text-sm font-medium"
                                                x-text="formatDate(form.tarikh_pemeriksaan_akan_datang) || '-'">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Progress Card -->
                            <div class="bg-white rounded-xl p-6 border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Kemajuan Borang</h3>

                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Pemilihan Aset</span>
                                        <div class="flex items-center" x-show="form.asset_id">
                                            <i class='bx bx-check text-green-500'></i>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Butiran Pemeriksaan</span>
                                        <div class="flex items-center"
                                            x-show="form.tarikh_pemeriksaan && form.kondisi_aset">
                                            <i class='bx bx-check text-green-500'></i>
                                        </div>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Catatan (Opsional)</span>
                                        <div class="flex items-center"
                                            x-show="form.catatan_pemeriksaan || form.tindakan_diperlukan">
                                            <i class='bx bx-check text-green-500'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Tips -->
                            <div
                                class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-6 border border-green-200">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                        <i class='bx bx-bulb text-white'></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Tips Berguna</h3>
                                </div>

                                <ul class="space-y-2 text-sm text-green-800">
                                    <li class="flex items-start">
                                        <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                        Periksa aset dengan teliti dan objektif
                                    </li>
                                    <li class="flex items-start">
                                        <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                        Ambil gambar untuk dokumentasi
                                    </li>
                                    <li class="flex items-start">
                                        <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                        Catat tindakan diperlukan jika ada
                                    </li>
                                    <li class="flex items-start">
                                        <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                        Jadualkan pemeriksaan akan datang
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
                            <a href="{{ route('admin.inspections.index') }}"
                                class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                                <i class='bx bx-x mr-2'></i>
                                Batal
                            </a>
                            <button type="submit"
                                class="px-8 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                                <i class='bx bx-plus mr-2'></i>
                                Simpan Pemeriksaan
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            function inspectionForm() {
                return {
                    form: {
                        asset_id: '{{ old('asset_id') }}',
                        asset_name: '',
                        tarikh_pemeriksaan: '{{ old('tarikh_pemeriksaan', date('Y-m-d')) }}',
                        kondisi_aset: '{{ old('kondisi_aset') }}',
                        nama_pemeriksa: '{{ old('nama_pemeriksa', auth()->user()->name) }}',
                        jawatan_pemeriksa: '{{ old('jawatan_pemeriksa') }}',
                        signature: '{{ old('signature') }}',
                        tarikh_pemeriksaan_akan_datang: '{{ old('tarikh_pemeriksaan_akan_datang') }}',
                        catatan_pemeriksaan: '{{ old('catatan_pemeriksaan') }}',
                        tindakan_diperlukan: '{{ old('tindakan_diperlukan') }}',
                        hasSignature: false
                    },
                    signaturePad: null,
                    init() {
                         this.initSignaturePad();
                         // Watch for changes and update missing next inspection date
                         this.$watch('form.tarikh_pemeriksaan', (value) => {
                             if(value && !this.form.tarikh_pemeriksaan_akan_datang) {
                                 const date = new Date(value);
                                 date.setMonth(date.getMonth() + 6);
                                 this.form.tarikh_pemeriksaan_akan_datang = date.toISOString().split('T')[0];
                             }
                         });
                    },
                    initSignaturePad() {
                        const canvas = document.getElementById('signature-pad');
                        if (!canvas) return;

                        const ctx = canvas.getContext('2d');
                        let isDrawing = false;
                        let lastX = 0;
                        let lastY = 0;

                        // Set canvas size based on container
                        const resizeCanvas = () => {
                            const ratio = Math.max(window.devicePixelRatio || 1, 1);
                            canvas.width = canvas.offsetWidth * ratio;
                            canvas.height = canvas.offsetHeight * ratio;
                            ctx.scale(ratio, ratio);
                            
                            // If there's an existing signature, verify how to restore (complex with raw canvas, simpler to just require resign on resize or keep image data)
                            if (this.form.signature) {
                                const img = new Image();
                                img.onload = () => ctx.drawImage(img, 0, 0, canvas.offsetWidth, canvas.offsetHeight);
                                img.src = this.form.signature;
                                this.form.hasSignature = true;
                            }
                        };
                        
                        resizeCanvas();
                        window.addEventListener('resize', resizeCanvas);

                        const startDrawing = (e) => {
                            isDrawing = true;
                            [lastX, lastY] = getCoords(e);
                            this.form.hasSignature = true;
                        };

                        const draw = (e) => {
                            if (!isDrawing) return;
                            e.preventDefault();
                            
                            const [x, y] = getCoords(e);
                            
                            ctx.beginPath();
                            ctx.moveTo(lastX, lastY);
                            ctx.lineTo(x, y);
                            ctx.strokeStyle = '#000';
                            ctx.lineWidth = 2;
                            ctx.lineCap = 'round';
                            ctx.stroke();
                            
                            [lastX, lastY] = [x, y];
                        };

                        const stopDrawing = () => {
                            if (isDrawing) {
                                isDrawing = false;
                                this.form.signature = canvas.toDataURL();
                            }
                        };

                        const getCoords = (e) => {
                            const rect = canvas.getBoundingClientRect();
                            const clientX = e.touches ? e.touches[0].clientX : e.clientX;
                            const clientY = e.touches ? e.touches[0].clientY : e.clientY;
                            return [
                                clientX - rect.left,
                                clientY - rect.top
                            ];
                        };

                        canvas.addEventListener('mousedown', startDrawing);
                        canvas.addEventListener('mousemove', draw);
                        canvas.addEventListener('mouseup', stopDrawing);
                        canvas.addEventListener('mouseout', stopDrawing);

                        canvas.addEventListener('touchstart', startDrawing);
                        canvas.addEventListener('touchmove', draw);
                        canvas.addEventListener('touchend', stopDrawing);
                    },
                    clearSignature() {
                        const canvas = document.getElementById('signature-pad');
                        const ctx = canvas.getContext('2d');
                        ctx.clearRect(0, 0, canvas.width, canvas.height);
                        this.form.signature = '';
                        this.form.hasSignature = false;
                    },
                    formatDate(dateString) {
                        if (!dateString) return null;
                        const options = { day: '2-digit', month: '2-digit', year: 'numeric' };
                        return new Date(dateString).toLocaleDateString('en-GB', options); // dd/mm/yyyy
                    }
                }
            }

            // File upload validation
            document.getElementById('gambar_pemeriksaan').addEventListener('change', function () {
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