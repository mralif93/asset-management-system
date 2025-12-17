@extends('layouts.admin')

@section('title', 'BR-AMS 002 - Senarai Daftar Inventori')
@section('page-title', 'BR-AMS 002 - Senarai Daftar Inventori')
@section('page-description', 'Borang rasmi pendaftaran inventori masjid dan surau')

@section('content')
    <div class="p-6">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">BR-AMS 002 - Senarai Daftar Inventori</h1>
                    <p class="text-emerald-100 text-lg">Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan
                        Surau Negeri Selangor</p>
                    <div class="flex items-center space-x-4 mt-4">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-package text-emerald-200'></i>
                            <span class="text-emerald-100">Borang Rasmi</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-shield-check text-emerald-200'></i>
                            <span class="text-emerald-100">Negeri Selangor</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <i class='bx bx-package text-6xl text-emerald-200 opacity-80'></i>
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
                <h3 class="text-lg font-semibold text-gray-900">Senarai Inventori</h3>
                <p class="text-sm text-gray-600">Data inventori mengikut kriteria yang dipilih</p>
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
                                        {{ ucfirst(str_replace('_', ' ', $asset->cara_perolehan ?? 'N/A')) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200">
                                    {{ $asset->tarikh_perolehan ? \Carbon\Carbon::parse($asset->tarikh_perolehan)->format('d/m/Y') : 'N/A' }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200 text-right">
                                    <span class="font-semibold text-gray-900">RM
                                        {{ number_format($asset->nilai_perolehan, 2) }}</span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900 border-r border-gray-200">
                                    <div class="font-medium text-gray-900">{{ $asset->lokasi_penempatan ?? 'N/A' }}</div>
                                    @if($asset->masjidSurau)
                                        <div class="text-gray-500 text-xs mt-1">{{ $asset->masjidSurau->nama }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm border-r border-gray-200">
                                    @if($asset->status_aset == 'dilupuskan')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class='bx bx-x-circle mr-1'></i>
                                            Dilupuskan
                                        </span>
                                    @elseif($asset->status_aset == 'hapus_kira')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class='bx bx-minus-circle mr-1'></i>
                                            Hapus Kira
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            <i class='bx bx-check-circle mr-1'></i>
                                            {{ ucfirst(str_replace('_', ' ', $asset->status_aset)) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                    <span class="font-semibold text-emerald-600">RM
                                        {{ number_format($asset->getCurrentValue(), 2) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class='bx bx-package text-4xl text-gray-300 mb-4'></i>
                                        <p class="text-lg font-medium">Tiada inventori ditemui</p>
                                        <p class="text-sm">Tiada inventori yang memenuhi kriteria carian</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>

                    <!-- Summary Rows -->
                    @if($assets->count() > 0)
                        <tfoot class="bg-emerald-50">
                            <tr>
                                <td colspan="8"
                                    class="px-6 py-4 text-right text-sm font-semibold text-emerald-800 border-r border-emerald-200">
                                    JUMLAH KESELURUHAN (RM)*
                                </td>
                                <td class="px-6 py-4 text-right text-sm font-bold text-emerald-600">
                                    RM {{ number_format($totalValue, 2) }}
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
                const pdfUrl = '{{ route("admin.reports.br-ams-002.pdf") }}?' + urlParams.toString();

                // Open PDF in new window for preview
                const previewWindow = window.open(pdfUrl, '_blank', 'width=1024,height=768');

                if (!previewWindow) {
                    alert('Sila benarkan pop-up untuk melihat pratonton PDF');
                }
            }

            // Print styles
            window.addEventListener('beforeprint', function () {
                // Hide action buttons when printing
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

                .bg-gray-200 {
                    background-color: #e5e7eb !important;
                    -webkit-print-color-adjust: exact;
                }
            }
        </style>
    @endpush
@endsection