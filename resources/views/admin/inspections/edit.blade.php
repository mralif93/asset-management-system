@extends('layouts.admin')

@section('title', 'Edit Pemeriksaan')
@section('page-title', 'Edit Pemeriksaan')
@section('page-description', 'Kemaskini maklumat pemeriksaan aset')

@section('content')
    <div class="p-6">
        <!-- Welcome Header -->
        <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Edit Pemeriksaan</h1>
                    <p class="text-emerald-100 text-lg">Kemaskini maklumat untuk {{ $inspection->asset->nama_aset }} -
                        {{ $inspection->tarikh_pemeriksaan->format('d/m/Y') }}</p>
                    <div class="flex items-center space-x-4 mt-4">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-edit text-emerald-200'></i>
                            <span class="text-emerald-100">Kemaskini Data</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 {{ 
                                $inspection->kondisi_aset === 'Sangat Baik' || $inspection->kondisi_aset === 'Baik' ? 'bg-green-400' :
        ($inspection->kondisi_aset === 'Sederhana' ? 'bg-yellow-400' : 'bg-red-400') 
                            }} rounded-full"></div>
                            <span class="text-emerald-100">{{ $inspection->kondisi_aset }}</span>
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
            <span class="text-emerald-600 font-medium">Edit: {{ $inspection->asset->nama_aset }}</span>
        </div>

        <!-- Form Card - Full Width -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <form action="{{ route('admin.inspections.update', $inspection) }}" method="POST" enctype="multipart/form-data"
                x-data="editInspectionForm()" class="space-y-0">
                @csrf
                @method('PUT')

                <!-- Form Header -->
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Kemaskini Maklumat Pemeriksaan</h2>
                            <p class="text-sm text-gray-600">Edit dan kemaskini maklumat pemeriksaan dalam sistem</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ 
                                $inspection->kondisi_aset === 'Sangat Baik' || $inspection->kondisi_aset === 'Baik' ? 'bg-green-100 text-green-800' : ($inspection->kondisi_aset === 'Sederhana' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') 
                            }}">
                                <div class="w-2 h-2 {{ 
                                    $inspection->kondisi_aset === 'Sangat Baik' || $inspection->kondisi_aset === 'Baik' ? 'bg-green-500' : ($inspection->kondisi_aset === 'Sederhana' ? 'bg-yellow-500' : 'bg-red-500') 
                                }} rounded-full mr-2"></div>
                                {{ $inspection->kondisi_aset }}
                            </span>
                            <span
                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $inspection->tarikh_pemeriksaan->format('d/m/Y') }}
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
                                    <h3 class="text-lg font-semibold text-gray-900">Pemilihan Aset</h3>
                                    <p class="text-sm text-emerald-700">Kemaskini aset yang diperiksa</p>
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
                                            @change="updateAssetName($event)"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('asset_id') border-red-500 @enderror appearance-none bg-white">
                                            <option value="">Pilih Aset</option>
                                            @foreach($assets as $asset)
                                                <option value="{{ $asset->id }}" data-name="{{ $asset->nama_aset }}" {{ old('asset_id', $inspection->asset_id) == $asset->id ? 'selected' : '' }}>
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
                                    <p class="text-sm text-purple-700">Kemaskini maklumat tarikh dan kondisi aset</p>
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
                                            value="{{ old('tarikh_pemeriksaan', $inspection->tarikh_pemeriksaan ? $inspection->tarikh_pemeriksaan->format('Y-m-d') : '') }}"
                                            required x-model="form.tarikh_pemeriksaan"
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
                                            <option value="Sedang Digunakan" {{ old('kondisi_aset', $inspection->kondisi_aset) == 'Sedang Digunakan' ? 'selected' : '' }}>Sedang
                                                Digunakan</option>
                                            <option value="Tidak Digunakan" {{ old('kondisi_aset', $inspection->kondisi_aset) == 'Tidak Digunakan' ? 'selected' : '' }}>Tidak
                                                Digunakan</option>
                                            <option value="Rosak" {{ old('kondisi_aset', $inspection->kondisi_aset) == 'Rosak' ? 'selected' : '' }}>Rosak</option>
                                            <option value="Sedang Diselenggara" {{ old('kondisi_aset', $inspection->kondisi_aset) == 'Sedang Diselenggara' ? 'selected' : '' }}>
                                                Sedang Diselenggara</option>
                                            <option value="Hilang" {{ old('kondisi_aset', $inspection->kondisi_aset) == 'Hilang' ? 'selected' : '' }}>Hilang</option>
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
                                            value="{{ old('tarikh_pemeriksaan_akan_datang', $inspection->tarikh_pemeriksaan_akan_datang ? $inspection->tarikh_pemeriksaan_akan_datang->format('Y-m-d') : '') }}"
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
                                            value="{{ old('nama_pemeriksa', $inspection->pegawai_pemeriksa) }}"
                                            x-model="form.nama_pemeriksa"
                                            required
                                            class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('nama_pemeriksa') border-red-500 @enderror bg-white"
                                            placeholder="Nama pemeriksa">
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
                                            value="{{ old('jawatan_pemeriksa', $inspection->jawatan_pemeriksa) }}" required
                                            x-model="form.jawatan_pemeriksa"
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
                            
                            <!-- Signature Section -->
                            <div class="mt-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-pen mr-1'></i>
                                    Tandatangan Pemeriksa <span class="text-red-500">*</span>
                                </label>

                                <!-- Existing Signature Display -->
                                @if($inspection->signature && !old('signature'))
                                    <div class="mb-4 bg-white p-4 rounded-lg border border-gray-200" x-show="!form.showSignaturePad">
                                        <p class="text-sm text-gray-500 mb-2">Tandatangan Semasa:</p>
                                        <img src="{{ $inspection->signature }}" alt="Tandatangan"
                                            class="w-full max-h-40 object-contain border border-blue-100 rounded bg-gray-50 mb-3">
                                        <button type="button" @click="toggleSignaturePad()"
                                            class="text-sm flex items-center text-emerald-600 hover:text-emerald-700 font-medium">
                                            <i class='bx bx-edit mr-1'></i> Kemaskini Tandatangan
                                        </button>
                                        <input type="hidden" name="existing_signature_valid" value="1">
                                    </div>
                                @endif

                                <div x-show="form.showSignaturePad" x-transition>
                                    <div class="border border-gray-300 rounded-lg bg-white overflow-hidden relative">
                                        <canvas id="signature-pad" class="w-full h-48 cursor-crosshair touch-none"></canvas>
                                        <div class="absolute bottom-2 right-2 flex space-x-2">
                                            <button type="button" @click="clearSignature()"
                                                class="px-3 py-1 text-xs bg-gray-200 hover:bg-gray-300 text-gray-700 rounded transition-colors">
                                                <i class='bx bx-reset mr-1'></i> Padam
                                            </button>
                                            @if($inspection->signature)
                                            <button type="button" @click="cancelUpdateSignature()"
                                                class="px-3 py-1 text-xs bg-red-100 hover:bg-red-200 text-red-700 rounded transition-colors">
                                                <i class='bx bx-x mr-1'></i> Batal
                                            </button>
                                            @endif
                                        </div>
                                        <div x-show="!form.hasSignature"
                                            class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                            <div class="text-gray-400 text-sm flex flex-col items-center opacity-50">
                                                <i class='bx bx-edit text-3xl mb-1'></i>
                                                <span>Tandatangan di sini</span>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="signature" x-model="form.signature">
                                    <p class="mt-1 text-xs text-gray-500">Sila tandatangan di dalam kotak di atas</p>
                                    @error('signature')
                                        <p class="mt-1 text-sm text-red-600 flex items-center">
                                            <i class='bx bx-error-circle mr-1'></i>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
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
                                    <p class="text-sm text-amber-700">Kemaskini maklumat tambahan dan tindakan diperlukan
                                    </p>
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
                                            placeholder="Catatan mengenai kondisi aset...">{{ old('catatan_pemeriksaan', $inspection->catatan_pemeriksa) }}</textarea>
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
                                            placeholder="Tindakan yang perlu diambil...">{{ old('tindakan_diperlukan', $inspection->cadangan_tindakan) }}</textarea>
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
                                    Tambah Gambar Pemeriksaan Baru
                                </label>
                                <div class="relative">
                                    <input type="file" id="gambar_pemeriksaan" name="gambar_pemeriksaan[]" multiple
                                        accept="image/*"
                                        class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('gambar_pemeriksaan') border-red-500 @enderror bg-white">
                                    <i class='bx bx-images absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                <p class="mt-1 text-xs text-amber-600">Boleh pilih beberapa gambar sekaligus (format:
                                    JPG, PNG, maksimum 2MB setiap gambar)</p>
                                @error('gambar_pemeriksaan')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror

                                <!-- Current Images -->
                                @if($inspection->gambar_pemeriksaan && count($inspection->gambar_pemeriksaan) > 0)
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Sedia Ada</label>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            @foreach($inspection->gambar_pemeriksaan as $image)
                                                <div class="relative group">
                                                    <img src="{{ Storage::url($image) }}" alt="Gambar Pemeriksaan"
                                                        class="w-full h-24 object-cover rounded-lg border border-gray-200 cursor-pointer hover:opacity-75 transition-opacity"
                                                        onclick="openImageModal('{{ Storage::url($image) }}')">
                                                    <div
                                                        class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-25 rounded-lg transition-all flex items-center justify-center">
                                                        <i
                                                            class='bx bx-expand text-white opacity-0 group-hover:opacity-100 text-xl'></i>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
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

                    <!-- Right Column - Preview & Info -->
                    <div class="lg:col-span-1">
                        <div class="sticky top-6 space-y-6">

                            <!-- Current Inspection Preview -->
                            <div
                                class="bg-gradient-to-br from-indigo-50 to-purple-100 rounded-xl p-6 border border-indigo-200">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center mr-3">
                                        <i class='bx bx-search-alt text-white'></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Pratonton Pemeriksaan</h3>
                                </div>

                                <div class="space-y-4">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                            <i class='bx bx-package text-emerald-700 text-xl'></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-900" x-text="form.asset_name || '{{ $inspection->asset->nama_aset }}'">{{ $inspection->asset->nama_aset }}</p>
                                            <p class="text-sm text-gray-500"
                                                x-text="formatDate(form.tarikh_pemeriksaan) || '{{ $inspection->tarikh_pemeriksaan->format('d/m/Y') }}'">
                                                {{ $inspection->tarikh_pemeriksaan->format('d/m/Y') }}</p>
                                        </div>
                                    </div>

                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Kondisi:</span>
                                            <span class="text-sm font-medium"
                                                x-text="form.kondisi_aset || '{{ $inspection->kondisi_aset }}'">{{ $inspection->kondisi_aset }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Pemeriksa:</span>
                                            <span class="text-sm font-medium"
                                                x-text="form.nama_pemeriksa || '{{ $inspection->pegawai_pemeriksa ?: '-' }}'">{{ $inspection->pegawai_pemeriksa ?: '-' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Jawatan:</span>
                                            <span class="text-sm font-medium"
                                                x-text="form.jawatan_pemeriksa || '{{ $inspection->jawatan_pemeriksa ?: '-' }}'">{{ $inspection->jawatan_pemeriksa ?: '-' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-sm text-gray-600">Pemeriksaan Seterusnya:</span>
                                            <span class="text-sm font-medium"
                                                x-text="formatDate(form.tarikh_pemeriksaan_akan_datang) || '{{ $inspection->tarikh_pemeriksaan_akan_datang ? $inspection->tarikh_pemeriksaan_akan_datang->format('d/m/Y') : '-' }}'">{{ $inspection->tarikh_pemeriksaan_akan_datang ? $inspection->tarikh_pemeriksaan_akan_datang->format('d/m/Y') : '-' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Activity Summary -->
                            <div class="bg-white rounded-xl p-6 border border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pemeriksaan</h3>

                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Status Kondisi:</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ 
                                            $inspection->kondisi_aset === 'Sangat Baik' || $inspection->kondisi_aset === 'Baik' ? 'bg-green-100 text-green-800' :
                                            ($inspection->kondisi_aset === 'Sederhana' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') 
                                        }}">
                                            <div class="w-2 h-2 {{ 
                                                $inspection->kondisi_aset === 'Sangat Baik' || $inspection->kondisi_aset === 'Baik' ? 'bg-green-500' :
                                                ($inspection->kondisi_aset === 'Sederhana' ? 'bg-yellow-500' : 'bg-red-500') 
                                            }} rounded-full mr-1"></div>
                                            {{ $inspection->kondisi_aset }}
                                        </span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Aset:</span>
                                        <span class="text-sm font-medium">{{ $inspection->asset->nama_aset }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm text-gray-600">Dicipta:</span>
                                        <span
                                            class="text-sm font-medium">{{ $inspection->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div
                                class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-6 border border-green-200">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                        <i class='bx bx-cog text-white'></i>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900">Tindakan Pantas</h3>
                                </div>

                                <div class="space-y-3">
                                    <a href="{{ route('admin.inspections.show', $inspection) }}"
                                        class="w-full flex items-center justify-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg transition-colors">
                                        <i class='bx bx-show mr-2'></i>
                                        Lihat Detail
                                    </a>

                                    <a href="{{ route('admin.assets.show', $inspection->asset) }}"
                                        class="w-full flex items-center justify-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                                        <i class='bx bx-package mr-2'></i>
                                        Lihat Aset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Footer -->
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
                            <div class="flex items-center text-sm text-gray-500">
                                <i class='bx bx-info-circle mr-1'></i>
                                Kemaskini terakhir: {{ $inspection->updated_at->format('d/m/Y H:i') }}
                            </div>

                            <div class="flex space-x-3">
                                <a href="{{ route('admin.inspections.show', $inspection) }}"
                                    class="inline-flex items-center px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors whitespace-nowrap">
                                    <i class='bx bx-x mr-2'></i>
                                    Batal
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-8 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors whitespace-nowrap">
                                    <i class='bx bx-save mr-2'></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <i class='bx bx-x text-3xl'></i>
            </button>
            <img id="modalImage" src="" alt="Gambar Pemeriksaan" class="max-w-full max-h-full object-contain rounded-lg">
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
        <script>
            function editInspectionForm() {
                return {
                    form: {
                        asset_id: '{{ old('asset_id', $inspection->asset_id) }}',
                        asset_name: '{{ addslashes($inspection->asset->nama_aset) }}',
                        tarikh_pemeriksaan: '{{ old('tarikh_pemeriksaan', $inspection->tarikh_pemeriksaan ? $inspection->tarikh_pemeriksaan->format('Y-m-d') : '') }}',
                        kondisi_aset: '{{ old('kondisi_aset', $inspection->kondisi_aset) }}',
                        nama_pemeriksa: '{{ old('nama_pemeriksa', $inspection->pegawai_pemeriksa) }}',
                        jawatan_pemeriksa: '{{ old('jawatan_pemeriksa', $inspection->jawatan_pemeriksa) }}',
                        tarikh_pemeriksaan_akan_datang: '{{ old('tarikh_pemeriksaan_akan_datang', $inspection->tarikh_pemeriksaan_akan_datang ? $inspection->tarikh_pemeriksaan_akan_datang->format('Y-m-d') : '') }}',
                        catatan_pemeriksaan: '{{ old('catatan_pemeriksaan', $inspection->catatan_pemeriksa) }}',
                        tindakan_diperlukan: '{{ old('tindakan_diperlukan', $inspection->cadangan_tindakan) }}',
                        signature: '{{ old('signature') }}',
                        hasSignature: {{ $inspection->signature ? 'true' : 'false' }},
                        showSignaturePad: {{ $inspection->signature ? 'false' : 'true' }}
                    },
                    signaturePad: null,
                    init() {
                         // Initialize signature pad if visible
                         if (this.form.showSignaturePad) {
                             this.$nextTick(() => {
                                 this.initSignaturePad();
                             });
                         }

                         // Watch for changes and update missing next inspection date
                         this.$watch('form.tarikh_pemeriksaan', (value) => {
                             if(value && !this.form.tarikh_pemeriksaan_akan_datang) {
                                 const date = new Date(value);
                                 date.setMonth(date.getMonth() + 6);
                                 this.form.tarikh_pemeriksaan_akan_datang = date.toISOString().split('T')[0];
                             }
                         });
                    },
                    toggleSignaturePad() {
                        this.form.showSignaturePad = true;
                        this.$nextTick(() => {
                            this.initSignaturePad();
                        });
                    },
                    cancelUpdateSignature() {
                        this.form.showSignaturePad = false;
                        this.form.signature = ''; // Clear new signature
                    },
                    updateAssetName(event) {
                        const selectedOption = event.target.options[event.target.selectedIndex];
                        this.form.asset_name = selectedOption.dataset.name || '';
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
                            
                            // If there's a signature in form.signature field (e.g. from failed submission), restore it
                            if (this.form.signature && this.form.signature.startsWith('data:image')) {
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
                        return new Date(dateString).toLocaleDateString('en-GB', options);
                    }
                }
            }

            function openImageModal(imageUrl) {
                const modal = document.getElementById('imageModal');
                const modalImage = document.getElementById('modalImage');
                modalImage.src = imageUrl;
                modal.classList.remove('hidden');
            }

            function closeImageModal() {
                const modal = document.getElementById('imageModal');
                modal.classList.add('hidden');
            }
        </script>
    @endpush
@endsection