@extends('layouts.admin')

@section('title', 'BR-AMS 003 - Senarai Aset Alih di Lokasi')
@section('page-title', 'BR-AMS 003 - Senarai Aset Alih di Lokasi')
@section('page-description', 'Laporan rasmi senarai aset alih mengikut lokasi')

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
                            <span class="text-emerald-100">Laporan Rasmi</span>
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
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
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
                            <i class='bx bx-map-pin mr-1'></i>
                            Lokasi
                        </label>
                        <select name="lokasi"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            <option value="">Semua Lokasi</option>
                            @foreach($lokasiList as $l)
                                <option value="{{ $l }}" {{ $lokasi == $l ? 'selected' : '' }}>
                                    {{ $l }}
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
                        @php
                            $groupedAssets = $assets->groupBy(function ($item) {
                                return $item->batch_id ?? 'SINGLE_' . $item->id;
                            });
                            $bil = 1;
                        @endphp

                        @forelse($groupedAssets as $groupKey => $group)
                                @if($group->count() > 1 && !str_starts_with($groupKey, 'SINGLE_'))
                                        <!-- Parent Row (Group Summary) -->
                                    <tbody class="bg-white border-b border-gray-200" x-data="{ expanded: false }">
                                        <tr class="hover:bg-emerald-50 transition-colors cursor-pointer bg-gray-50 group"
                                            @click="expanded = !expanded">
                                            <td
                                                class="px-6 py-4 text-center text-sm font-medium text-gray-900 border-r border-gray-200 align-top">
                                                {{ $bil++ }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200 align-top">
                                                <div class="flex items-center justify-center text-emerald-700 font-bold">
                                                    <i class='bx bx-chevron-right text-xl transition-transform duration-200'
                                                        :class="expanded ? 'rotate-90' : ''"></i>
                                                    <span class="ml-1">{{ $group->count() }} Unit</span>
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1 text-center">
                                                    Klik untuk lihat No. Siri
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 border-r border-gray-200 align-top">
                                                <div class="font-bold text-gray-900">{{ $group->first()->nama_aset }}</div>
                                                <div class="text-gray-500 text-xs mt-1">{{ $group->first()->jenis_aset }}</div>
                                                @if($group->first()->masjidSurau)
                                                    <div class="text-gray-500 text-xs mt-1">{{ $group->first()->masjidSurau->nama }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-center text-sm text-gray-900 align-top">
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800">
                                                    <i class='bx bx-package mr-1'></i>
                                                    {{ $group->count() }}
                                                </span>
                                            </td>
                                        </tr>

                                        <!-- Child Rows -->
                                        @foreach($group as $index => $asset)
                                            <tr x-show="expanded" x-transition:enter="transition ease-out duration-100"
                                                x-transition:enter-start="opacity-0 transform -translate-y-2"
                                                x-transition:enter-end="opacity-100 transform translate-y-0"
                                                class="bg-white hover:bg-emerald-50/50">
                                                <td
                                                    class="px-6 py-3 whitespace-nowrap text-sm text-gray-400 border-r border-gray-100 text-right pl-12 font-mono">
                                                    {{ $loop->iteration }}.
                                                </td>
                                                <td
                                                    class="px-6 py-3 whitespace-nowrap text-sm text-gray-600 border-r border-gray-100 font-mono text-center">
                                                    {{ $asset->no_siri_pendaftaran ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-3 text-sm text-gray-500 border-r border-gray-100">
                                                    {{ $asset->nama_aset }}
                                                </td>
                                                <td class="px-6 py-3 text-center text-sm text-gray-400">
                                                    1
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                @else
                                <!-- Single Item Row (Standard) -->
                                <tbody class="bg-white border-b border-gray-200">
                                    <tr class="hover:bg-emerald-50 transition-colors">
                                        <td class="px-6 py-4 text-center text-sm font-medium text-gray-900 border-r border-gray-200">
                                            {{ $bil++ }}
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-200">
                                            <div class="font-medium text-gray-900">{{ $group->first()->no_siri_pendaftaran ?? 'N/A' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 border-r border-gray-200">
                                            <div class="font-medium text-gray-900">{{ $group->first()->nama_aset }}</div>
                                            <div class="text-gray-500 text-xs mt-1">{{ $group->first()->jenis_aset }}</div>
                                            @if($group->first()->masjidSurau)
                                                <div class="text-gray-500 text-xs mt-1">{{ $group->first()->masjidSurau->nama }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center text-sm text-gray-900">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                                <i class='bx bx-package mr-1'></i>
                                                {{ $group->first()->kuantiti ?? 1 }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            @endif
                        @empty
                        <tbody>
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <i class='bx bx-package text-4xl text-gray-300 mb-4'></i>
                                        <p class="text-lg font-medium">Tiada aset ditemui</p>
                                        <p class="text-sm">Tiada aset yang memenuhi kriteria carian</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Action Buttons (Moved up since Signature and Notes are removed/adjusted) -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mt-8">
            <div class="flex flex-wrap gap-3 justify-end">
                <button onclick="exportToPDF()"
                    class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                    <i class='bx bx-file-blank mr-2'></i>
                    Muat Turun / Cetak Laporan
                </button>

                <a href="{{ route('admin.reports.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <i class='bx bx-arrow-back mr-2'></i>
                    Kembali ke Senarai Laporan
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