@extends('layouts.admin')

@section('title', 'Import Pelupusan')
@section('page-title', 'Import Pelupusan')
@section('page-description', 'Muat naik permohonan pelupusan aset dari fail Excel/CSV')

@section('content')
    <div class="p-6">
        <!-- Welcome Header -->
        <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Import Pelupusan</h1>
                    <p class="text-emerald-100 text-lg">Muat naik permohonan pelupusan aset secara pukal dari fail Excel/CSV
                    </p>
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
                    <i class='bx bx-trash text-6xl text-emerald-200'></i>
                </div>
            </div>
        </div>

        <!-- Navigation Breadcrumb -->
        <div class="flex items-center space-x-2 mb-6">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600">
                <i class='bx bx-home'></i>
            </a>
            <i class='bx bx-chevron-right text-gray-400'></i>
            <a href="{{ route('admin.disposals.index') }}" class="text-gray-500 hover:text-emerald-600">
                Pelupusan Aset
            </a>
            <i class='bx bx-chevron-right text-gray-400'></i>
            <span class="text-emerald-600 font-medium">Import Pelupusan</span>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6 shadow-sm">
                <div class="flex items-center">
                    <i class='bx bx-check-circle text-green-600 text-xl mr-3'></i>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if(session('import_errors'))
            <div class="bg-red-50 border border-red-200 rounded-xl p-6 mb-6 shadow-sm">
                <div class="flex items-start mb-4">
                    <i class='bx bx-error-circle text-red-600 text-xl mr-3 mt-0.5'></i>
                    <div>
                        <h3 class="text-red-800 font-semibold mb-2">Ralat Import Ditemui</h3>
                        <p class="text-red-700 text-sm mb-4">Sila semak ralat berikut dan betulkan fail anda:</p>
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
                <div
                    class="bg-gradient-to-br from-emerald-50 to-green-100 rounded-xl p-6 border border-emerald-200 shadow-sm">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                            <i class='bx bx-info-circle text-white text-xl'></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Arahan Import</h3>
                            <p class="text-sm text-emerald-700">Ikuti langkah-langkah untuk import permohonan pelupusan</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-start">
                            <div
                                class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <span class="text-emerald-600 font-semibold">1</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 mb-1">Muat turun Template</p>
                                <p class="text-sm text-gray-600">Gunakan template Excel rasmi untuk format yang tepat</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <span class="text-emerald-600 font-semibold">2</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 mb-1">Isi Maklumat</p>
                                <p class="text-sm text-gray-600">Masukkan data pelupusan. Pastikan No. Siri Aset adalah
                                    tepat</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <span class="text-emerald-600 font-semibold">3</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 mb-1">Muat Naik</p>
                                <p class="text-sm text-gray-600">Pilih fail dan klik pratonton untuk semakan awal</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div
                                class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                <span class="text-emerald-600 font-semibold">4</span>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900 mb-1">Proses</p>
                                <p class="text-sm text-gray-600">Sahkan data dan klik import untuk simpan ke dalam sistem
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Import Form Card -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <form action="{{ route('admin.disposals.import.store') }}" method="POST" enctype="multipart/form-data"
                        id="importForm">
                        @csrf

                        <!-- Form Header -->
                        <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-green-50">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900">Muat Naik Fail Rekod</h2>
                                    <p class="text-sm text-gray-600">Pilih fail CSV/Excel yang mengandungi data pelupusan
                                    </p>
                                </div>
                                <div
                                    class="hidden sm:flex items-center space-x-2 px-3 py-1 bg-white rounded-full border border-emerald-100 shadow-sm">
                                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                                    <span class="text-xs font-medium text-gray-600 uppercase tracking-wider">Ready for
                                        upload</span>
                                </div>
                            </div>
                        </div>

                        <!-- Form Content -->
                        <div class="p-6 space-y-6">
                            <!-- File Upload -->
                            <div>
                                <label for="csv_file" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-file mr-1 text-emerald-500'></i>
                                    Fail CSV/Excel <span class="text-red-500">*</span>
                                </label>
                                <div class="mt-1 flex justify-center px-8 pt-8 pb-8 border-2 border-dashed border-gray-300 rounded-xl hover:border-emerald-400 transition-all duration-300 bg-gradient-to-br from-gray-50 to-emerald-50 hover:from-emerald-50 hover:to-emerald-100 group cursor-pointer"
                                    id="dropZone">
                                    <div class="space-y-4 text-center">
                                        <div class="relative">
                                            <i
                                                class='bx bx-cloud-upload text-5xl text-gray-400 mb-2 group-hover:text-emerald-500 transition-all duration-300 transform group-hover:scale-110'></i>
                                        </div>
                                        <div class="space-y-2">
                                            <div
                                                class="flex text-sm text-gray-600 group-hover:text-emerald-700 transition-colors duration-300 justify-center items-center">
                                                <label for="csv_file"
                                                    class="relative cursor-pointer bg-white rounded-lg px-4 py-2 font-medium text-emerald-600 hover:text-emerald-500 hover:bg-emerald-50 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500 transition-all duration-200 shadow-sm hover:shadow-md border border-emerald-100">
                                                    <span class="flex items-center">
                                                        <i class='bx bx-upload mr-2'></i>
                                                        Pilih fail
                                                    </span>
                                                    <input id="csv_file" name="csv_file" type="file" class="sr-only"
                                                        accept=".csv,.xlsx,.xls" required>
                                                </label>
                                                <p class="pl-3 text-gray-500 group-hover:text-emerald-600 hidden sm:block">
                                                    atau tarik fail ke sini</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- File Name Display -->
                                <div id="fileNameDisplay" class="mt-4 hidden">
                                    <div
                                        class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 transition-all duration-300 animate-fadeIn">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                                                    <i class='bx bx-file text-emerald-600 text-xl'></i>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-emerald-900" id="fileName"></p>
                                                    <p class="text-xs text-emerald-600" id="fileSize"></p>
                                                </div>
                                            </div>
                                            <button type="button" id="removeFile"
                                                class="p-2 hover:bg-red-50 text-red-600 rounded-full transition-colors">
                                                <i class='bx bx-trash text-xl'></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                @error('csv_file')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Tips Card -->
                            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl shadow-sm p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center"><i class='bx bx-bulb text-blue-600 text-lg'></i></div>
                                    </div>
                                    <div class="ml-3">
                                        <p class="font-semibold text-blue-800 mb-1">💡 Tip Berguna:</p>
                                        <div class="text-blue-700 leading-relaxed space-y-1">
                                            <p>• Gunakan <strong>No. Siri Pendaftaran Aset</strong> yang sah (rujuk sheet
                                                Rujukan dalam template)</p>
                                            <p>• Justifikasi: <strong>rosak_teruk, usang, tidak_ekonomi, tiada_penggunaan,
                                                    lain_lain</strong></p>
                                            <p>• Kaedah: <strong>jualan, buangan, hadiah, tukar_beli, hapus_kira</strong>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div
                                class="flex items-center space-x-4">
                                <button type="button" id="previewBtn"
                                    class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                                    <i class='bx bx-show mr-2'></i>
                                    Pratonton Data
                                </button>
                                <button type="submit" id="importBtn"
                                    class="hidden flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                                    <i class='bx bx-upload mr-2'></i>
                                    Muat Naik & Import
                                </button>
                                <a href="{{ route('admin.disposals.index') }}"
                                    class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                                    <i class='bx bx-x mr-2'></i>
                                    Batal
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Preview UI -->
                <div id="previewContainer" class="hidden animate-fadeIn space-y-4">
                    <div
                        class="bg-white border border-gray-200 rounded-2xl shadow-lg overflow-hidden flex flex-col min-h-[500px]">
                        <div
                            class="p-6 border-b border-gray-200 bg-gray-50 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                            <div class="flex items-center">
                                <div
                                    class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center mr-4 border border-gray-100 text-emerald-600">
                                    <i class='bx bx-table text-2xl'></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg">Pratonton Data Import</h3>
                                    <p class="text-sm text-gray-600">Semak ketepatan data sebelum proses import dijalankan
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div
                                    class="flex items-center px-4 py-2 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100 shadow-sm">
                                    <i class='bx bx-check-circle mr-2 text-xl'></i>
                                    <span class="font-bold text-lg mr-1" id="validCount">0</span>
                                    <span class="text-xs uppercase font-semibold">SAH</span>
                                </div>
                                <div
                                    class="flex items-center px-4 py-2 bg-amber-50 text-amber-700 rounded-xl border border-amber-100 shadow-sm">
                                    <i class='bx bx-warning mr-2 text-xl'></i>
                                    <span class="font-bold text-lg mr-1" id="warningsCount">0</span>
                                    <span class="text-xs uppercase font-semibold">AMARAN</span>
                                </div>
                                <div
                                    class="flex items-center px-4 py-2 bg-red-50 text-red-700 rounded-xl border border-red-100 shadow-sm">
                                    <i class='bx bx-error-circle mr-2 text-xl'></i>
                                    <span class="font-bold text-lg mr-1" id="invalidCount">0</span>
                                    <span class="text-xs uppercase font-semibold">RALAT</span>
                                </div>
                            </div>
                        </div>

                        <div class="overflow-x-auto flex-grow">
                            <table class="w-full text-sm text-left">
                                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b tracking-wider">
                                    <tr>
                                        <th class="px-6 py-4 font-bold">Baris</th>
                                        <th class="px-6 py-4 font-bold">Status</th>
                                        <th class="px-6 py-4 font-bold">No. Siri Aset</th>
                                        <th class="px-6 py-4 font-bold">Nama Aset</th>
                                        <th class="px-6 py-4 font-bold">Justifikasi</th>
                                        <th class="px-6 py-4 font-bold">Amaran</th>
                                        <th class="px-6 py-4 font-bold">Tarikh / Ralat</th>
                                    </tr>
                                </thead>
                                <tbody id="previewTableBody" class="divide-y divide-gray-100">
                                    <!-- Populated by JavaScript -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination (Client Side) -->
                        <div id="paginationControls"
                            class="hidden p-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between">
                            <p class="text-xs text-gray-500">
                                Memaparkan <span class="font-bold text-gray-900" id="pageStart">0</span> - <span
                                    class="font-bold text-gray-900" id="pageEnd">0</span>
                                daripada <span class="font-bold text-gray-900" id="totalRows">0</span> rekod
                            </p>
                            <div class="flex space-x-2">
                                <button id="prevBtn" type="button"
                                    class="p-2 border rounded-lg bg-white hover:bg-gray-50 disabled:opacity-30 disabled:cursor-not-allowed">
                                    <i class='bx bx-chevron-left text-xl'></i>
                                </button>
                                <button id="nextBtn" type="button"
                                    class="p-2 border rounded-lg bg-white hover:bg-gray-50 disabled:opacity-30 disabled:cursor-not-allowed">
                                    <i class='bx bx-chevron-right text-xl'></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Sidebar -->
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

                    <a href="{{ route('admin.disposals.import.template') }}"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors flex items-center justify-center">
                        <i class='bx bx-download mr-2'></i>
                        Muat Turun Template
                    </a>
                </div>

                <!-- Cari Masjid/Surau Card -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-gray-700 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-search text-white'></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Cari Masjid/Surau</h3>
                    </div>
                    <p class="text-sm text-gray-600 mb-3">Cari nama atau kod, kemudian klik item untuk salin ID.</p>
                    <div class="relative">
                        <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400'></i>
                        <input type="text" id="masjidSearchSide" placeholder="Cari nama atau kod..."
                            class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-lg text-sm focus:ring-2 focus:ring-emerald-500">
                    </div>

                    <div id="masjidResultsSide"
                        class="mt-3 space-y-2 max-h-80 overflow-y-auto scrollbar-thin scrollbar-thumb-gray-200">
                        @foreach($masjidSuraus as $masjid)
                            <div class="masjid-item-side group p-3 bg-white rounded-lg border border-gray-100 hover:border-emerald-300 hover:shadow-sm transition-all cursor-pointer"
                                data-id="{{ $masjid->id }}" data-name="{{ strtolower($masjid->nama) }}"
                                onclick="copyToClipboard('{{ $masjid->id }}', '{{ addslashes($masjid->nama) }}')">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <span
                                                class="text-xs font-bold px-1.5 py-0.5 bg-emerald-600 text-white rounded">{{ $masjid->id }}</span>
                                            <span
                                                class="text-[10px] font-bold text-gray-400 uppercase">{{ $masjid->jenis ?? 'Surau' }}</span>
                                        </div>
                                        <p class="text-xs font-semibold text-gray-800 leading-tight">{{ $masjid->nama }}</p>
                                    </div>
                                    <i class='bx bx-copy text-gray-300 group-hover:text-emerald-500'></i>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-[10px] text-gray-400 mt-2 italic">* Klik pada item untuk salin ID</p>
                </div>

                <!-- Justifikasi Card -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-help-circle text-white'></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Justifikasi Sah</h3>
                    </div>

                    <div class="space-y-2">
                        @foreach(['rosak_teruk', 'usang', 'tidak_ekonomi', 'tiada_penggunaan', 'lain_lain'] as $opt)
                            <div class="flex items-center text-sm text-gray-700">
                                <i class='bx bx-check-circle text-emerald-600 mr-2'></i>
                                <span>{{ $opt }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Kaedah Card -->
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-cog text-white'></i>
                        </div>
                        <h3 class="font-semibold text-gray-900">Kaedah Sah</h3>
                    </div>

                    <div class="space-y-2">
                        @foreach(['jualan', 'buangan', 'hadiah', 'tukar_beli', 'hapus_kira'] as $opt)
                            <div class="flex items-center text-sm text-gray-700">
                                <i class='bx bx-check-circle text-blue-600 mr-2'></i>
                                <span>{{ $opt }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notification Toast Container -->
    <div id="toastContainer" class="fixed top-24 right-6 z-[9999] space-y-3 pointer-events-none"></div>

    <style>
        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 4px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 20px;
        }

        .masjid-item-side:hover .bx-copy {
            color: #10b981;
            transform: scale(1.1);
        }
    </style>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const fileInput = document.getElementById('csv_file');
                const dropZone = document.getElementById('dropZone');
                const previewBtn = document.getElementById('previewBtn');
                const importBtn = document.getElementById('importBtn');
                const previewContainer = document.getElementById('previewContainer');
                const tableBody = document.getElementById('previewTableBody');

                let allRows = [];
                let currentPage = 1;
                const rowsPerPage = 10;

                fileInput.addEventListener('change', e => e.target.files[0] && displayFile(e.target.files[0]));
                dropZone.addEventListener('dragover', e => (e.preventDefault(), dropZone.classList.add('border-emerald-400', 'bg-emerald-50')));
                dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-emerald-400', 'bg-emerald-50'));
                dropZone.addEventListener('drop', e => {
                    e.preventDefault();
                    dropZone.classList.remove('border-emerald-400', 'bg-emerald-50');
                    if (e.dataTransfer.files.length) {
                        fileInput.files = e.dataTransfer.files;
                        displayFile(e.dataTransfer.files[0]);
                    }
                });

                document.getElementById('removeFile').onclick = () => {
                    fileInput.value = '';
                    document.getElementById('fileNameDisplay').classList.add('hidden');
                    previewContainer.classList.add('hidden');
                    importBtn.classList.add('hidden');
                };

                function displayFile(file) {
                    document.getElementById('fileName').textContent = file.name;
                    document.getElementById('fileSize').textContent = (file.size / 1024).toFixed(2) + ' KB';
                    document.getElementById('fileNameDisplay').classList.remove('hidden');
                }

                previewBtn.onclick = async () => {
                    const file = fileInput.files[0];
                    if (!file) return showToast('Sila pilih fail terlebih dahulu', 'error');

                    const formData = new FormData();
                    formData.append('csv_file', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    previewBtn.disabled = true;
                    previewBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i> Memproses...';

                    try {
                        const response = await fetch('{{ route("admin.disposals.import.preview") }}', {
                            method: 'POST',
                            body: formData
                        });
                        const result = await response.json();

                        if (result.success) {
                            allRows = result.data;
                            document.getElementById('validCount').textContent = result.summary.valid;
                            document.getElementById('invalidCount').textContent = result.summary.invalid;
                            document.getElementById('warningsCount').textContent = result.summary.warnings || 0;
                            document.getElementById('totalRows').textContent = result.summary.total;

                            currentPage = 1;
                            renderTable();

                            previewContainer.classList.remove('hidden');
                            document.getElementById('paginationControls').classList.toggle('hidden', allRows.length <= rowsPerPage);

                            if (result.summary.valid > 0 && result.summary.invalid === 0) {
                                importBtn.classList.remove('hidden');
                                showToast('Semua data sah!', 'success');
                            } else if (result.summary.invalid > 0) {
                                importBtn.classList.add('hidden');
                                showToast('Terdapat ralat dalam data!', 'error');
                            }
                        } else {
                            showToast(result.message, 'error');
                        }
                    } catch (e) {
                        showToast('Ralat sistem berlaku semasa memproses fail', 'error');
                    } finally {
                        previewBtn.disabled = false;
                        previewBtn.innerHTML = '<i class="bx bx-show-alt mr-2"></i> Pratonton Data';
                    }
                };

                function renderTable() {
                    const start = (currentPage - 1) * rowsPerPage;
                    const end = start + rowsPerPage;
                    const pageRows = allRows.slice(start, end);

                    tableBody.innerHTML = pageRows.map(row => {
                        // Determine status badge
                        let statusBadge = '';
                        if (row.warnings && row.warnings.length > 0) {
                            statusBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800">AMARAN</span>';
                        } else if (row.valid) {
                            statusBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">SAH</span>';
                        } else {
                            statusBadge = '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800">RALAT</span>';
                        }

                        // Warnings column
                        const warningsHtml = row.warnings ? `<span class="text-amber-600 text-xs">${row.warnings}</span>` : '-';

                        return `
                                <tr class="${row.valid ? 'hover:bg-gray-50' : 'bg-red-50'}">
                                    <td class="px-6 py-4 font-mono text-xs text-gray-500">${row.row}</td>
                                    <td class="px-6 py-4">
                                        ${statusBadge}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900">${row.display_data?.no_siri || '-'}</div>
                                    </td>
                                    <td class="px-6 py-4 text-gray-700">${row.display_data?.nama_aset || '-'}</td>
                                    <td class="px-6 py-4 text-gray-700">${row.display_data?.justifikasi || '-'}</td>
                                    <td class="px-6 py-4">${warningsHtml}</td>
                                    <td class="px-6 py-4 ${row.valid ? 'text-gray-500 italic' : 'text-red-600 font-semibold'}">
                                        ${row.valid ? row.display_data?.tarikh : row.errors.join('<br>')}
                                    </td>
                                </tr>
                            `;
                    }).join('');

                    document.getElementById('pageStart').textContent = allRows.length ? start + 1 : 0;
                    document.getElementById('pageEnd').textContent = Math.min(end, allRows.length);
                    document.getElementById('prevBtn').disabled = currentPage === 1;
                    document.getElementById('nextBtn').disabled = end >= allRows.length;
                }

                document.getElementById('prevBtn').onclick = () => currentPage > 1 && (currentPage--, renderTable());
                document.getElementById('nextBtn').onclick = () => (currentPage * rowsPerPage) < allRows.length && (currentPage++, renderTable());

                const masjidInput = document.getElementById('masjidSearchSide');
                masjidInput.oninput = function () {
                    const q = this.value.toLowerCase();
                    document.querySelectorAll('.masjid-item-side').forEach(item => {
                        const text = item.getAttribute('data-name') + ' ' + item.getAttribute('data-id');
                        item.classList.toggle('hidden', !text.includes(q));
                    });
                };

                window.copyToClipboard = (id, name) => {
                    navigator.clipboard.writeText(id).then(() => {
                        showToast(`ID ${id} disalin ke clipboard!`, 'info');
                        const item = document.querySelector(`[data-id="${id}"]`);
                        item.classList.add('bg-emerald-50', 'ring-2', 'ring-emerald-400');
                        setTimeout(() => item.classList.remove('bg-emerald-50', 'ring-2', 'ring-emerald-400'), 1500);
                    });
                };

                function showToast(msg, type = 'info') {
                    const container = document.getElementById('toastContainer');
                    const toast = document.createElement('div');
                    const colors = { success: 'bg-emerald-600', error: 'bg-red-600', info: 'bg-emerald-600' };
                    toast.className = `${colors[type]} text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center space-x-3 pointer-events-auto animate-fadeIn border border-white/20`;
                    toast.innerHTML = `<i class='bx bx-${type === 'error' ? 'error-circle' : 'info-circle'} text-2xl'></i><span class="font-bold text-sm">${msg}</span>`;
                    container.appendChild(toast);
                    setTimeout(() => {
                        toast.style.opacity = '0';
                        toast.style.transform = 'translateX(20px)';
                        setTimeout(() => toast.remove(), 300);
                    }, 4000);
                }
            });
        </script>
    @endpush
@endsection
