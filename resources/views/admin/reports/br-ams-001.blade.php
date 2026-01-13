@extends('layouts.admin')

@section('title', 'BR-AMS 001 - Senarai Daftar Harta Modal')
@section('page-title', 'BR-AMS 001 - Senarai Daftar Harta Modal')
@section('page-description', 'Borang rasmi pendaftaran harta modal masjid dan surau')

@section('content')
    <div class="p-6">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">BR-AMS 001 - Senarai Daftar Harta Modal</h1>
                    <p class="text-emerald-100 text-lg">Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan
                        Surau Negeri Selangor</p>
                    <div class="flex items-center space-x-4 mt-4">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-list-ul text-emerald-200'></i>
                            <span class="text-emerald-100">Borang Rasmi</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-shield-check text-emerald-200'></i>
                            <span class="text-emerald-100">Negeri Selangor</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <i class='bx bx-list-ul text-6xl text-emerald-200 opacity-80'></i>
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class='bx bx-building mr-1'></i>
                            Masjid/Surau
                        </label>
                        <select name="masjid_surau_id"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            <option value="">Semua Masjid/Surau</option>
                            @foreach($masjidSurauList as $ms)
                                <option value="{{ $ms->id }}" {{ $masjidSurauId == $ms->id ? 'selected' : '' }}>
                                    {{ $ms->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class='bx bx-map mr-1'></i>
                            Daerah
                        </label>
                        <select name="daerah"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            <option value="">Semua Daerah</option>
                            @foreach($daerahList as $d)
                                <option value="{{ $d }}" {{ $daerah == $d ? 'selected' : '' }}>
                                    {{ $d }}
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
                            <option value="">Semua Lokasi</option>
                            @foreach($lokasiList as $lok)
                                <option value="{{ $lok }}" {{ $lokasi == $lok ? 'selected' : '' }}>
                                    {{ $lok }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class='bx bx-calendar mr-1'></i>
                            Bulan
                        </label>
                        <select name="bulan"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            <option value="">Semua Bulan</option>
                            <option value="1" {{ $bulan == '1' ? 'selected' : '' }}>Januari</option>
                            <option value="2" {{ $bulan == '2' ? 'selected' : '' }}>Februari</option>
                            <option value="3" {{ $bulan == '3' ? 'selected' : '' }}>Mac</option>
                            <option value="4" {{ $bulan == '4' ? 'selected' : '' }}>April</option>
                            <option value="5" {{ $bulan == '5' ? 'selected' : '' }}>Mei</option>
                            <option value="6" {{ $bulan == '6' ? 'selected' : '' }}>Jun</option>
                            <option value="7" {{ $bulan == '7' ? 'selected' : '' }}>Julai</option>
                            <option value="8" {{ $bulan == '8' ? 'selected' : '' }}>Ogos</option>
                            <option value="9" {{ $bulan == '9' ? 'selected' : '' }}>September</option>
                            <option value="10" {{ $bulan == '10' ? 'selected' : '' }}>Oktober</option>
                            <option value="11" {{ $bulan == '11' ? 'selected' : '' }}>November</option>
                            <option value="12" {{ $bulan == '12' ? 'selected' : '' }}>Disember</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            <i class='bx bx-calendar-alt mr-1'></i>
                            Tahun
                        </label>
                        <select name="tahun"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            <option value="">Semua Tahun</option>
                            @for($y = date('Y'); $y >= 2020; $y--)
                                <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-8 rounded-lg transition-colors flex items-center justify-center">
                        <i class='bx bx-search mr-2'></i>
                        Terapkan Penapis
                    </button>
                </div>
            </form>
        </div>

        <!-- Main Table -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-8">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Senarai Aset</h3>
                <p class="text-sm text-gray-600">Data aset mengikut kriteria yang dipilih</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead class="bg-emerald-50">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">
                                BIL.
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">
                                NOMBOR SIRI PENDAFTARAN
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">
                                KETERANGAN ASET
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">
                                CARA ASET DIPEROLEHI
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">
                                TARIKH PEMBELIAN
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">
                                HARGA PEMBELIAN (RM)
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">
                                PENEMPATAN
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">
                                STATUS ASET
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-emerald-800 uppercase tracking-wider">
                                JUMLAH (RM)
                            </th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($assets as $index => $asset)
                            <tr class="hover:bg-emerald-50 transition-colors">
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                                    {{ $index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200">
                                    <div class="font-medium text-gray-900">{{ $asset->no_siri_pendaftaran ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 border-r border-gray-200">
                                    <div class="font-medium text-gray-900">{{ $asset->nama_aset }}</div>
                                    <div class="text-gray-500 text-xs mt-1">{{ $asset->jenis_aset }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ ucfirst(str_replace('_', ' ', $asset->kaedah_perolehan ?? 'N/A')) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200">
                                    {{ $asset->tarikh_perolehan ? \Carbon\Carbon::parse($asset->tarikh_perolehan)->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td
                                    class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200 text-right">
                                    {{ number_format($asset->nilai_perolehan, 2) }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900 border-r border-gray-200">
                                    <div>{{ $asset->lokasi_penempatan ?? 'N/A' }}</div>
                                    @if($asset->masjidSurau)
                                        <div class="text-gray-500 text-xs">{{ $asset->masjidSurau->nama }}</div>
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm border-r border-gray-200">
                                    @if($asset->status_aset == 'dilupuskan')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Dilupuskan
                                        </span>
                                    @elseif($asset->status_aset == 'hapus_kira')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Hapus Kira
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ ucfirst(str_replace('_', ' ', $asset->status_aset)) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 text-right font-medium">
                                    {{ number_format($asset->nilai_perolehan, 2) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-4 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class='bx bx-package text-4xl text-gray-300 mb-4'></i>
                                        <p class="text-lg font-medium">Tiada aset ditemui</p>
                                        <p class="text-sm">Tiada aset yang memenuhi kriteria carian</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    <!-- Summary Rows -->
                    @if($assets->count() > 0)
                        <tfoot class="bg-gray-100">
                            <tr>
                                <td colspan="8"
                                    class="px-4 py-3 text-right text-sm font-medium text-gray-900 border-r border-gray-200">
                                    JUMLAH (RM)
                                </td>
                                <td class="px-4 py-3 text-right text-sm font-bold text-gray-900">
                                    {{ number_format($totalValue, 2) }}
                                </td>
                            </tr>
                            <tr class="bg-gray-200">
                                <td colspan="8"
                                    class="px-4 py-3 text-right text-sm font-bold text-gray-900 border-r border-gray-200">
                                    JUMLAH KESELURUHAN (RM)*
                                </td>
                                <td class="px-4 py-3 text-right text-sm font-bold text-gray-900">
                                    {{ number_format($totalValue, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
        </div>

        <!-- Note and Action Buttons -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <!-- Note -->
                <div class="flex-1">
                    <p class="text-sm text-gray-600">
                        <i class='bx bx-info-circle text-blue-500 mr-1'></i>
                        *NOTA: Laporan ini melaporkan kedudukan keseluruhan aset alih yang dimiliki oleh masjid/surau
                        merangkumi penerimaan serta maklumat pelupusan dan hapus kira yang telah dikemaskini
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3">
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
    </div>

    @push('scripts')
        <script>
            function exportToPDF() {
                // Get current filter parameters
                const urlParams = new URLSearchParams(window.location.search);
                const pdfUrl = '{{ route("admin.reports.br-ams-001.pdf") }}?' + urlParams.toString();

                // Open PDF in new window for preview
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
                @page {
                    margin: 15mm 12mm;
                    size: A4 landscape;
                }

                body {
                    font-size: 8px;
                    line-height: 1.4;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }

                /* Hide non-print elements */
                .no-print,
                nav,
                aside,
                button,
                .flex.flex-wrap.gap-3 {
                    display: none !important;
                }

                /* Header styling */
                .bg-gradient-to-r {
                    background: #059669 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    padding: 15px 18px !important;
                    margin-bottom: 12px !important;
                    page-break-after: avoid;
                }

                .bg-gradient-to-r h1 {
                    font-size: 14px !important;
                    margin-bottom: 5px !important;
                }

                .bg-gradient-to-r p {
                    font-size: 9px !important;
                }

                .bg-gradient-to-r .flex {
                    font-size: 7px !important;
                    margin-top: 8px !important;
                }

                /* Filter section - hide on print */
                .bg-white.rounded-2xl.border:first-of-type {
                    display: none !important;
                }

                /* Table styling */
                table {
                    page-break-inside: auto;
                    margin-top: 5px !important;
                    font-size: 8px !important;
                }

                thead {
                    display: table-header-group;
                    background: #10b981 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }

                thead tr {
                    page-break-inside: avoid;
                    page-break-after: avoid;
                }

                thead th {
                    background: #10b981 !important;
                    color: white !important;
                    font-size: 7px !important;
                    padding: 6px 4px !important;
                    border: 1px solid #059669 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                    line-height: 1.2;
                }

                tbody tr {
                    page-break-inside: avoid;
                    border-bottom: 1px solid #e5e7eb !important;
                }

                tbody td {
                    padding: 6px 5px !important;
                    border: 1px solid #e5e7eb !important;
                    font-size: 8px !important;
                }

                /* Status badges */
                .inline-flex.items-center.px-2\.5 {
                    padding: 2px 6px !important;
                    border-radius: 8px !important;
                    font-size: 6px !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }

                .bg-green-100 {
                    background: #d1fae5 !important;
                    color: #065f46 !important;
                }

                .bg-blue-100 {
                    background: #dbeafe !important;
                    color: #1e40af !important;
                }

                .bg-red-100 {
                    background: #fee2e2 !important;
                    color: #991b1b !important;
                }

                .bg-gray-100 {
                    background: #f3f4f6 !important;
                    color: #374151 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }

                .bg-yellow-100,
                .bg-amber-100 {
                    background: #fef3c7 !important;
                    color: #92400e !important;
                }

                /* Footer */
                tfoot {
                    display: table-footer-group;
                    background: #f9fafb !important;
                    border-top: 2px solid #059669 !important;
                    page-break-inside: avoid;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }

                tfoot td {
                    padding: 6px 4px !important;
                    font-weight: bold !important;
                    border: 1px solid #d1d5db !important;
                    font-size: 8px !important;
                }

                .bg-gray-200 {
                    background: #e5e7eb !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }

                /* Note section */
                .bg-white.rounded-2xl:last-of-type {
                    margin-top: 12px !important;
                    page-break-inside: avoid;
                }

                .bg-white.rounded-2xl:last-of-type p {
                    background: #eff6ff !important;
                    padding: 8px 10px !important;
                    border-left: 2px solid #3b82f6 !important;
                    font-size: 7px !important;
                    color: #1e40af !important;
                    line-height: 1.5 !important;
                    -webkit-print-color-adjust: exact;
                    print-color-adjust: exact;
                }

                /* Smaller fonts */
                .text-sm {
                    font-size: 7px !important;
                }

                .text-xs {
                    font-size: 6px !important;
                }

                /* Amount highlighting */
                .text-gray-900,
                .font-semibold,
                .font-bold {
                    color: #059669 !important;
                }
            }
        </style>
    @endpush
@endsection