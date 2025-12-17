@extends('layouts.admin')

@section('title', 'BR-AMS 003 - Senarai Aset Alih di Lokasi')
@section('page-title', 'BR-AMS 003 - Senarai Aset Alih di Lokasi')
@section('page-description', 'Borang rasmi senarai aset alih mengikut lokasi')

@section('content')
    <div class="p-6">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">BR-AMS 003 - Senarai Aset Alih di Lokasi</h1>
                    <p class="text-emerald-100 text-lg">Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan
                        Surau Negeri Selangor</p>
                    <div class="flex items-center space-x-4 mt-4">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-location-plus text-emerald-200'></i>
                            <span class="text-emerald-100">Borang Rasmi</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-shield-check text-emerald-200'></i>
                            <span class="text-emerald-100">Negeri Selangor</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <i class='bx bx-location-plus text-6xl text-emerald-200 opacity-80'></i>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-8">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-2">Penapis Laporan</h2>
                <p class="text-sm text-gray-600">Pilih kriteria untuk menapis data laporan</p>
            </div>

            <form method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class='bx bx-building mr-1'></i>
                            Masjid/Surau
                        </label>
                        <select name="masjid_surau_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            <option value="">Pilih Masjid/Surau</option>
                            @foreach($masjidSurauList as $ms)
                                <option value="{{ $ms->id }}" {{ $masjidSurauId == $ms->id ? 'selected' : '' }}>
                                    {{ $ms->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class='bx bx-map-pin mr-1'></i>
                            Lokasi
                        </label>
                        <select name="lokasi"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            <option value="">Pilih Lokasi</option>
                            @foreach($lokasiList as $l)
                                <option value="{{ $l }}" {{ $lokasi == $l ? 'selected' : '' }}>
                                    {{ $l }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                            <i class='bx bx-search mr-2'></i>
                            Terapkan Penapis
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Main Table -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Senarai Aset Alih di Lokasi</h3>
                <p class="text-sm text-gray-600">Data aset mengikut lokasi yang dipilih</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead class="bg-emerald-50">
                        <tr>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">
                                BIL
                            </th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">
                                NOMBOR SIRI PENDAFTARAN
                            </th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">
                                KETERANGAN ASET
                            </th>
                            <th
                                class="px-6 py-4 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider">
                                KUANTITI
                            </th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($assets as $index => $asset)
                            <tr class="hover:bg-emerald-50 transition-colors">
                                <td class="px-6 py-4 text-center text-sm font-medium text-gray-900 border-r border-gray-200">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-200">
                                    <div class="font-medium text-gray-900">{{ $asset->no_siri_pendaftaran ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 border-r border-gray-200">
                                    <div class="font-medium text-gray-900">{{ $asset->nama_aset }}</div>
                                    <div class="text-gray-500 text-xs mt-1">{{ $asset->jenis_aset }}</div>
                                    @if($asset->masjidSurau)
                                        <div class="text-gray-500 text-xs mt-1">{{ $asset->masjidSurau->nama }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-gray-900">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                        <i class='bx bx-package mr-1'></i>
                                        {{ $asset->kuantiti ?? 1 }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class='bx bx-package text-4xl text-gray-300 mb-4'></i>
                                        <p class="text-lg font-medium">Tiada aset ditemui</p>
                                        <p class="text-sm">Tiada aset yang memenuhi kriteria carian</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Signature and Approval Sections -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- Prepared by Section -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">(a) Disediakan oleh :</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tandatangan:</label>
                        <div
                            class="h-16 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400 text-sm">Tandatangan di sini</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama :</label>
                        <div class="h-8 border-b border-gray-300"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jawatan :</label>
                        <div class="h-8 border-b border-gray-300"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tarikh:</label>
                        <div class="h-8 border-b border-gray-300"></div>
                    </div>
                </div>
            </div>

            <!-- Verified by Section -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">(b) Disahkan oleh :</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tandatangan:</label>
                        <div
                            class="h-16 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400 text-sm">Tandatangan di sini</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama :</label>
                        <div class="h-8 border-b border-gray-300"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jawatan :</label>
                        <div class="h-8 border-b border-gray-300"></div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tarikh :</label>
                        <div class="h-8 border-b border-gray-300"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Combined Notes and Action Buttons -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <!-- Notes Section -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Nota</h3>
                <div class="space-y-3 text-sm text-gray-700 mb-4">
                    <p><strong>a) Disediakan oleh Pegawai Aset/ Pembantu Pegawai Aset.</strong></p>
                    <p class="ml-4">Pegawai yang mengesahkan ialah pegawai yang bertanggungjawab ke atas aset alih
                        berkenaan.</p>
                    <p class="ml-4"><strong>Contohnya:-</strong></p>
                    <p class="ml-8"><strong>i. Lokasi Bilik Mesyuarat - disahkan oleh pegawai yang menguruskan bilik
                            mesyuarat.</strong></p>
                    <p><strong>b) Dikemaskini apabila terdapat perubahan kuantiti, lokasi atau pegawai
                            bertanggungjawab.</strong></p>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3 justify-center">
                <button onclick="exportToPDF()"
                    class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                    <i class='bx bx-file-blank mr-2'></i>
                    Muat Turun / Cetak Laporan
                </button>

                <a href="{{ route('admin.reports.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <i class='bx bx-arrow-back mr-2'></i>
                    Kembali ke Senarai Borang
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function exportToPDF() {
                const urlParams = new URLSearchParams(window.location.search);
                const pdfUrl = '{{ route("admin.reports.br-ams-003.pdf") }}?' + urlParams.toString();
                const previewWindow = window.open(pdfUrl, '_blank', 'width=1024,height=768');
                if (!previewWindow) {
                    alert('Sila benarkan pop-up untuk melihat pratonton PDF');
                }
            }

            // Print styles
            window.addEventListener('beforeprint', function () {
                // Hide action buttons when printing
                const actionButtons = document.querySelector('.flex.flex-wrap.gap-4.justify-center');
                if (actionButtons) {
                    actionButtons.style.display = 'none';
                }
            });

            window.addEventListener('afterprint', function () {
                // Show action buttons after printing
                const actionButtons = document.querySelector('.flex.flex-wrap.gap-4.justify-center');
                if (actionButtons) {
                    actionButtons.style.display = 'flex';
                }
            });
        </script>

        <style>
            @media print {
                .no-print {
                    display: none !important;
                }

                body {
                    font-size: 12px;
                }

                table {
                    font-size: 11px;
                }

                .bg-gray-100 {
                    background-color: #f3f4f6 !important;
                    -webkit-print-color-adjust: exact;
                }

                .bg-gray-50 {
                    background-color: #f9fafb !important;
                    -webkit-print-color-adjust: exact;
                }
            }
        </style>
    @endpush
@endsection