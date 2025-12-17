@extends('layouts.admin')

@section('title', 'Import Aset')
@section('page-title', 'Import Aset')
@section('page-description', 'Muat naik senarai aset dari fail CSV')

@section('content')
    <div class="p-6">
        <!-- Welcome Header -->
        <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Import Aset</h1>
                    <p class="text-emerald-100 text-lg">Muat naik senarai aset dari fail CSV</p>
                    <div class="flex items-center space-x-4 mt-4">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-cloud-upload text-emerald-200'></i>
                            <span class="text-emerald-100">Import Data</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-shield-check text-emerald-200'></i>
                            <span class="text-emerald-100">Validasi Automatik</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <i class='bx bx-import text-6xl text-emerald-200'></i>
                </div>
            </div>
        </div>

        <!-- Navigation Breadcrumb -->
        <div class="flex items-center space-x-2 mb-6">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600">
                <i class='bx bx-home'></i>
            </a>
            <i class='bx bx-chevron-right text-gray-400'></i>
            <a href="{{ route('admin.assets.index') }}" class="text-gray-500 hover:text-emerald-600">
                Pengurusan Aset
            </a>
            <i class='bx bx-chevron-right text-gray-400'></i>
            <span class="text-emerald-600 font-medium">Import Aset</span>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                <div class="flex items-center">
                    <i class='bx bx-check-circle text-green-600 text-xl mr-3'></i>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('import_errors'))
            <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-6">
                <div class="flex items-start mb-4">
                    <i class='bx bx-error-circle text-red-600 text-xl mr-3 mt-0.5'></i>
                    <div>
                        <h3 class="text-red-800 font-semibold mb-2">Ralat Import Ditemui</h3>
                        <p class="text-red-700 text-sm mb-4">Sila semak ralat berikut dan betulkan fail CSV anda:</p>
                        <ul class="space-y-2 max-h-60 overflow-y-auto">
                            @foreach(session('import_errors') as $error)
                                <li class="text-red-700 text-sm flex items-start">
                                    <span class="text-red-500 mr-2">•</span>
                                    <span>{{ $error }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column - Import Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Import Instructions Card -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                            <i class='bx bx-info-circle text-white text-xl'></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Arahan Import</h3>
                            <p class="text-sm text-blue-700">Ikuti langkah-langkah untuk import aset</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div
                                class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <span class="text-blue-600 font-semibold">1</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 mb-1">Muat turun Template</p>
                                <p class="text-sm text-gray-600">Muat turun template CSV untuk melihat format yang betul</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <span class="text-blue-600 font-semibold">2</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 mb-1">Isi Data Aset</p>
                                <p class="text-sm text-gray-600">Isi maklumat aset dalam template CSV. Pastikan format
                                    tarikh adalah YYYY-MM-DD</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <span class="text-blue-600 font-semibold">3</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 mb-1">Muat Naik Fail</p>
                                <p class="text-sm text-gray-600">Pilih fail CSV yang telah diisi dan muat naik ke sistem</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <span class="text-blue-600 font-semibold">4</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 mb-1">Semak Hasil</p>
                                <p class="text-sm text-gray-600">Sistem akan memproses dan memaparkan hasil import</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Import Form Card -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <form action="{{ route('admin.assets.import.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Form Header -->
                        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900">Muat Naik Fail CSV</h2>
                                    <p class="text-sm text-gray-600">Pilih fail CSV yang mengandungi data aset</p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <span class="text-sm text-gray-600">Sistem Online</span>
                                </div>
                            </div>
                        </div>

                        <!-- Form Content -->
                        <div class="p-6 space-y-6">
                            <!-- File Upload -->
                            <div>
                                <label for="csv_file" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-file mr-1'></i>
                                    Fail CSV <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 flex justify-center px-8 pt-8 pb-8 border-2 border-dashed border-gray-300 rounded-xl hover:border-emerald-400 transition-all duration-300 bg-gradient-to-br from-gray-50 to-emerald-50 hover:from-emerald-50 hover:to-emerald-100 group cursor-pointer"
                                    id="dropZone">
                                    <div class="space-y-4 text-center">
                                        <div class="relative">
                                            <i
                                                class='bx bx-cloud-upload text-5xl text-gray-400 mb-4 group-hover:text-emerald-500 transition-all duration-300 transform group-hover:scale-110'></i>
                                        </div>
                                        <div class="space-y-2">
                                            <div
                                                class="flex text-sm text-gray-600 group-hover:text-emerald-700 transition-colors duration-300 justify-center items-center">
                                                <label for="csv_file"
                                                    class="relative cursor-pointer bg-white rounded-lg px-4 py-2 font-medium text-emerald-600 hover:text-emerald-500 hover:bg-emerald-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500 transition-all duration-200 shadow-sm hover:shadow-md">
                                                    <span class="flex items-center">
                                                        <i class='bx bx-upload mr-2'></i>
                                                        Pilih fail CSV
                                                    </span>
                                                    <input id="csv_file" name="csv_file" type="file" class="sr-only"
                                                        accept=".csv,.txt" required>
                                                </label>
                                                <p class="pl-3 text-gray-500 group-hover:text-emerald-600">atau drag and
                                                    drop di sini</p>
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <p class="text-xs text-gray-500 flex items-center justify-center">
                                                <i class='bx bx-file-blank mr-1'></i>
                                                CSV, TXT hingga 10MB
                                            </p>
                                            <p
                                                class="text-xs text-emerald-600 font-medium flex items-center justify-center">
                                                <i class='bx bx-check-circle mr-1'></i>
                                                Format CSV dengan header diperlukan
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <!-- File Name Display -->
                                <div id="fileNameDisplay" class="mt-4 hidden">
                                    <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <i class='bx bx-file text-emerald-600 text-xl mr-3'></i>
                                                <div>
                                                    <p class="text-sm font-medium text-emerald-900" id="fileName"></p>
                                                    <p class="text-xs text-emerald-600" id="fileSize"></p>
                                                </div>
                                            </div>
                                            <button type="button" id="removeFile" class="text-red-600 hover:text-red-700">
                                                <i class='bx bx-x text-xl'></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                @error('csv_file')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Helpful Info -->
                            <div
                                class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl shadow-sm p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class='bx bx-bulb text-blue-600 text-lg'></i>
                                        </div>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <p class="font-semibold text-blue-800 mb-1">💡 Tip Berguna:</p>
                                        <ul class="text-blue-700 leading-relaxed space-y-1">
                                            <li>• Pastikan fail CSV menggunakan format UTF-8 untuk sokongan aksara Melayu
                                            </li>
                                            <li>• Format tarikh mesti YYYY-MM-DD (contoh: 2024-01-15)</li>
                                            <li>• Masjid/Surau ID mesti wujud dalam sistem</li>
                                            <li>• Jenis Aset mesti salah satu dari senarai yang sah</li>
                                            <li>• Nombor siri pendaftaran akan dijana secara automatik</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex items-center space-x-4">
                                <button type="submit"
                                    class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                                    <i class='bx bx-upload mr-2'></i>
                                    Muat Naik & Import
                                </button>
                                <a href="{{ route('admin.assets.index') }}"
                                    class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                                    <i class='bx bx-x mr-2'></i>
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column - Quick Actions & Info -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Download Template Card -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-download text-white'></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Template Import</h3>
                    </div>

                    <p class="text-sm text-gray-600 mb-4">Muat turun template CSV dengan format yang betul dan contoh data.
                    </p>

                    <a href="{{ route('admin.assets.import.template') }}"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center">
                        <i class='bx bx-download mr-2'></i>
                        Muat Turun Template
                    </a>
                </div>

                <!-- Asset Types Info -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-category text-white'></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Jenis Aset Sah</h3>
                    </div>

                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        @foreach($assetTypes as $type)
                            <div class="flex items-center text-sm text-gray-700">
                                <i class='bx bx-check-circle text-emerald-600 mr-2'></i>
                                <span>{{ $type }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Lokasi Penempatan List -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-map text-white'></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Lokasi Penempatan Sah</h3>
                    </div>

                    <div class="space-y-2 max-h-60 overflow-y-auto">
                        <div class="flex items-center text-sm text-gray-700">
                            <i class='bx bx-check-circle text-indigo-600 mr-2'></i>
                            <span>Anjung kiri</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class='bx bx-check-circle text-indigo-600 mr-2'></i>
                            <span>Anjung kanan</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class='bx bx-check-circle text-indigo-600 mr-2'></i>
                            <span>Anjung Depan(Ruang Pengantin)</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class='bx bx-check-circle text-indigo-600 mr-2'></i>
                            <span>Ruang Utama (tingkat atas, tingkat bawah)</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class='bx bx-check-circle text-indigo-600 mr-2'></i>
                            <span>Bilik Mesyuarat</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class='bx bx-check-circle text-indigo-600 mr-2'></i>
                            <span>Bilik Kuliah</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class='bx bx-check-circle text-indigo-600 mr-2'></i>
                            <span>Bilik Bendahari</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class='bx bx-check-circle text-indigo-600 mr-2'></i>
                            <span>Bilik Setiausaha</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class='bx bx-check-circle text-indigo-600 mr-2'></i>
                            <span>Bilik Nazir & Imam</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class='bx bx-check-circle text-indigo-600 mr-2'></i>
                            <span>Bangunan Jenazah</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class='bx bx-check-circle text-indigo-600 mr-2'></i>
                            <span>Lain-lain</span>
                        </div>
                    </div>
                </div>

                <!-- Physical Condition List -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-teal-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-health text-white'></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Keadaan Fizikal Sah</h3>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center text-sm text-gray-700">
                            <i class='bx bx-check-circle text-green-600 mr-2'></i>
                            <span class="font-medium text-green-700">Cemerlang</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class='bx bx-check-circle text-green-600 mr-2'></i>
                            <span class="font-medium text-green-600">Baik</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class='bx bx-check-circle text-yellow-600 mr-2'></i>
                            <span class="font-medium text-yellow-700">Sederhana</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class='bx bx-check-circle text-orange-600 mr-2'></i>
                            <span class="font-medium text-orange-700">Rosak</span>
                        </div>
                        <div class="flex items-center text-sm text-gray-700">
                            <i class='bx bx-check-circle text-red-600 mr-2'></i>
                            <span class="font-medium text-red-700">Tidak Boleh Digunakan</span>
                        </div>
                    </div>
                </div>

                <!-- Status & Acquisition Method List -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-orange-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-transfer text-white'></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Status & Kaedah</h3>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Status Aset:</p>
                            <div class="space-y-1">
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class='bx bx-check-circle text-orange-600 mr-2'></i>
                                    <span>Baru</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class='bx bx-check-circle text-orange-600 mr-2'></i>
                                    <span>Sedang Digunakan</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class='bx bx-check-circle text-orange-600 mr-2'></i>
                                    <span>Dalam Penyelenggaraan</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class='bx bx-check-circle text-orange-600 mr-2'></i>
                                    <span>Rosak</span>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-3">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Kaedah Perolehan:</p>
                            <div class="space-y-1">
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class='bx bx-check-circle text-orange-600 mr-2'></i>
                                    <span>Pembelian</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class='bx bx-check-circle text-orange-600 mr-2'></i>
                                    <span>Sumbangan</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class='bx bx-check-circle text-orange-600 mr-2'></i>
                                    <span>Hibah</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class='bx bx-check-circle text-orange-600 mr-2'></i>
                                    <span>Infaq</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class='bx bx-check-circle text-orange-600 mr-2'></i>
                                    <span>Lain-lain</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Warranty Status & Category List -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-pink-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-shield text-white'></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Kategori & Jaminan</h3>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Kategori Aset:</p>
                            <div class="space-y-1">
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class='bx bx-check-circle text-pink-600 mr-2'></i>
                                    <span class="font-medium">asset</span>
                                    <span class="ml-2 text-xs text-gray-500">(Aset bernilai)</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class='bx bx-check-circle text-pink-600 mr-2'></i>
                                    <span class="font-medium">non-asset</span>
                                    <span class="ml-2 text-xs text-gray-500">(Bukan aset)</span>
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-3">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Status Jaminan:</p>
                            <div class="space-y-1">
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class='bx bx-check-circle text-green-600 mr-2'></i>
                                    <span class="font-medium text-green-700">Aktif</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class='bx bx-check-circle text-red-600 mr-2'></i>
                                    <span class="font-medium text-red-700">Tamat</span>
                                </div>
                                <div class="flex items-center text-sm text-gray-700">
                                    <i class='bx bx-check-circle text-gray-600 mr-2'></i>
                                    <span class="font-medium text-gray-700">Tiada Jaminan</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Masjid/Surau Search -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-building text-white'></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Cari Masjid/Surau</h3>
                    </div>

                    <p class="text-sm text-gray-600 mb-4">Cari untuk mendapatkan ID Masjid/Surau:</p>

                    <!-- Search Input -->
                    <div class="mb-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class='bx bx-search text-gray-400'></i>
                            </div>
                            <input type="text" id="masjidSearch" placeholder="Cari nama masjid/surau..."
                                class="w-full pl-10 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <button type="button" id="clearSearch"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center hidden hover:text-purple-600 transition-colors">
                                <i class='bx bx-x text-gray-400 text-xl'></i>
                            </button>
                        </div>
                    </div>

                    <!-- Results Container -->
                    <div id="masjidResults"
                        class="space-y-2 max-h-64 overflow-y-auto border border-gray-200 rounded-lg p-3 bg-gray-50">
                        @foreach($masjidSuraus as $masjid)
                            <div class="masjid-item bg-white rounded-lg p-3 border border-gray-200 hover:border-purple-300 hover:shadow-sm transition-all cursor-pointer"
                                data-id="{{ $masjid->id }}" data-name="{{ strtolower($masjid->nama) }}"
                                data-jenis="{{ strtolower($masjid->jenis ?? '') }}"
                                onclick="copyMasjidId({{ $masjid->id }}, '{{ addslashes($masjid->nama) }}')">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-bold text-purple-600 text-lg">{{ $masjid->id }}</span>
                                            <span
                                                class="text-xs px-2 py-0.5 rounded-full {{ $masjid->jenis === 'Masjid' ? 'bg-blue-100 text-blue-800' : ($masjid->jenis === 'Surau Jumaat' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ $masjid->jenis ?? 'Surau' }}
                                            </span>
                                        </div>
                                        <p class="text-sm text-gray-700 mt-1 font-medium">{{ $masjid->nama }}</p>
                                        @if($masjid->daerah)
                                            <p class="text-xs text-gray-500 mt-1">{{ $masjid->daerah }}, {{ $masjid->negeri }}</p>
                                        @endif
                                    </div>
                                    <div class="ml-2">
                                        <i class='bx bx-copy text-gray-400 hover:text-purple-600'></i>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-3 p-2 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-xs text-blue-700 flex items-center">
                            <i class='bx bx-info-circle mr-1'></i>
                            Klik pada item untuk salin ID ke clipboard
                        </p>
                    </div>
                </div>

                <!-- Help & Tips -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                    <div class="flex items-start">
                        <i class='bx bx-info-circle text-blue-600 text-lg mr-3 mt-0.5'></i>
                        <div>
                            <h4 class="font-medium text-blue-900 mb-2">Bantuan Import</h4>
                            <ul class="text-sm text-blue-800 space-y-1">
                                <li>• Format CSV dengan header</li>
                                <li>• Maksimum 10MB fail</li>
                                <li>• Semak ralat selepas import</li>
                                <li>• Nombor siri auto-generate</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const fileInput = document.getElementById('csv_file');
                const dropZone = document.getElementById('dropZone');
                const fileNameDisplay = document.getElementById('fileNameDisplay');
                const fileName = document.getElementById('fileName');
                const fileSize = document.getElementById('fileSize');
                const removeFile = document.getElementById('removeFile');
                const masjidSearch = document.getElementById('masjidSearch');
                const masjidResults = document.getElementById('masjidResults');

                // Handle file selection
                fileInput.addEventListener('change', function (e) {
                    if (e.target.files.length > 0) {
                        displayFileInfo(e.target.files[0]);
                    }
                });

                // Handle drag and drop
                dropZone.addEventListener('dragover', function (e) {
                    e.preventDefault();
                    dropZone.classList.add('border-emerald-400', 'bg-emerald-50');
                });

                dropZone.addEventListener('dragleave', function (e) {
                    e.preventDefault();
                    dropZone.classList.remove('border-emerald-400', 'bg-emerald-50');
                });

                dropZone.addEventListener('drop', function (e) {
                    e.preventDefault();
                    dropZone.classList.remove('border-emerald-400', 'bg-emerald-50');

                    if (e.dataTransfer.files.length > 0) {
                        fileInput.files = e.dataTransfer.files;
                        displayFileInfo(e.dataTransfer.files[0]);
                    }
                });

                // Remove file
                removeFile.addEventListener('click', function () {
                    fileInput.value = '';
                    fileNameDisplay.classList.add('hidden');
                });

                function displayFileInfo(file) {
                    fileName.textContent = file.name;
                    fileSize.textContent = (file.size / 1024).toFixed(2) + ' KB';
                    fileNameDisplay.classList.remove('hidden');
                }

                // Masjid/Surau Search Functionality
                const clearSearchBtn = document.getElementById('clearSearch');

                function handleSearch() {
                    const searchTerm = masjidSearch.value.toLowerCase().trim();
                    const items = masjidResults.querySelectorAll('.masjid-item');

                    // Show/hide clear button
                    if (searchTerm === '') {
                        clearSearchBtn.classList.add('hidden');
                        items.forEach(item => item.style.display = 'block');
                        return;
                    } else {
                        clearSearchBtn.classList.remove('hidden');
                    }

                    // Filter items
                    items.forEach(item => {
                        const name = item.getAttribute('data-name');
                        const jenis = item.getAttribute('data-jenis');
                        const id = item.getAttribute('data-id');

                        if (name.includes(searchTerm) ||
                            jenis.includes(searchTerm) ||
                            id.includes(searchTerm)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                }

                masjidSearch.addEventListener('input', handleSearch);

                // Clear search button functionality
                clearSearchBtn.addEventListener('click', function () {
                    masjidSearch.value = '';
                    handleSearch();
                    masjidSearch.focus(); // Keep focus on input
                });

                // Copy Masjid ID to clipboard
                window.copyMasjidId = function (id, name) {
                    // Copy to clipboard
                    navigator.clipboard.writeText(id).then(function () {
                        // Show notification
                        showNotification('ID ' + id + ' telah disalin! (' + name + ')', 'success');

                        // Highlight the item briefly
                        const item = document.querySelector(`[data-id="${id}"]`);
                        if (item) {
                            item.classList.add('bg-green-50', 'border-green-300');
                            setTimeout(() => {
                                item.classList.remove('bg-green-50', 'border-green-300');
                            }, 1000);
                        }
                    }).catch(function (err) {
                        showNotification('Gagal menyalin ID. Sila salin secara manual: ' + id, 'error');
                    });
                };

                function showNotification(message, type) {
                    // Remove existing notification
                    const existing = document.querySelector('.notification-toast');
                    if (existing) {
                        existing.remove();
                    }

                    // Create notification
                    const notification = document.createElement('div');
                    notification.className = `notification-toast fixed top-4 right-4 z-50 px-6 py-4 rounded-lg shadow-lg flex items-center space-x-3 ${type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
                        }`;
                    notification.innerHTML = `
                    <i class='bx bx-${type === 'success' ? 'check-circle' : 'error-circle'} text-xl'></i>
                    <span class="font-medium">${message}</span>
                `;

                    document.body.appendChild(notification);

                    // Animate in
                    setTimeout(() => {
                        notification.style.opacity = '0';
                        notification.style.transform = 'translateX(100%)';
                        notification.style.transition = 'all 0.3s ease';
                    }, 3000);

                    // Remove after animation
                    setTimeout(() => {
                        notification.remove();
                    }, 3300);
                }
            });
        </script>
    @endpush
@endsection