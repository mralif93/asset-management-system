@extends('layouts.admin')

@section('title', 'BR-AMS 004 - Laporan Pergerakan / Pinjaman Aset Alih')
@section('page-title', 'BR-AMS 004 - Laporan Pergerakan / Pinjaman Aset Alih')
@section('page-description', 'Laporan rasmi pergerakan dan pinjaman aset alih')

@section('content')
    <div class="p-6">
        <!-- Welcome Header -->
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">BR-AMS 004 - Laporan Pergerakan / Pinjaman Aset Alih</h1>
                    <p class="text-emerald-100 text-lg">Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan
                        Surau Negeri Selangor</p>
                    <div class="flex items-center space-x-4 mt-4">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-transfer text-emerald-200'></i>
                            <span class="text-emerald-100">Laporan Rasmi</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-shield-check text-emerald-200'></i>
                            <span class="text-emerald-100">Negeri Selangor</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <i class='bx bx-transfer text-6xl text-emerald-200 opacity-80'></i>
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
                            <i class='bx bx-check-circle mr-1'></i>
                            Status
                        </label>
                        <select name="status"
                            class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                            <option value="">Semua Status</option>
                            @foreach($statusOptions as $key => $label)
                                <option value="{{ $key }}" {{ $status == $key ? 'selected' : '' }}>
                                    {{ $label }}
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
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <!-- Table Header -->
                    <thead class="bg-gray-100">
                        <tr>
                            <th
                                class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                                Bil.
                            </th>
                            <th
                                class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                                Nama Pemohon
                            </th>
                            <th
                                class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                                Jawatan
                            </th>
                            <th
                                class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                                Tujuan
                            </th>
                            <th
                                class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                                Nombor Siri Pendaftaran
                            </th>
                            <th
                                class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                                Keterangan Aset
                            </th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300"
                                colspan="4">
                                Dipinjam
                            </th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider"
                                colspan="4">
                                Dipulangkan
                            </th>
                        </tr>
                        <tr class="bg-gray-50">
                            <th
                                class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            </th>
                            <th
                                class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            </th>
                            <th
                                class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            </th>
                            <th
                                class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            </th>
                            <th
                                class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            </th>
                            <th
                                class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            </th>
                            <th
                                class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                                Tarikh
                            </th>
                            <th
                                class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                                Kuantiti
                            </th>
                            <th
                                class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                                Tandatangan Penyerah
                            </th>
                            <th
                                class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                                Tandatangan Peminjam
                            </th>
                            <th
                                class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                                Tarikh
                            </th>
                            <th
                                class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                                Kuantiti
                            </th>
                            <th
                                class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                                Tandatangan Penerima
                            </th>
                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">
                                Tandatangan Peminjam
                            </th>
                        </tr>
                    </thead>

                    <!-- Table Body -->
                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($groupedMovements as $groupKey => $movements)
                        @php
                            $firstMovement = $movements->first();
                            $totalQuantity = $movements->sum('kuantiti');
                            $asset = $firstMovement->asset;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                                <div class="font-medium">{{ $firstMovement->user->name ?? 'N/A' }}</div>
                            </td>
                            <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                                {{ $firstMovement->user->jawatan ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                                {{ $firstMovement->tujuan_pergerakan ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                                <div class="font-medium">{{ $asset->no_siri_pendaftaran ?? 'N/A' }}</div>
                                @if($movements->count() > 1)
                                    <div class="text-xs text-gray-500 italic mt-1">(+{{ $movements->count() - 1 }} item lain)</div>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-900 border-r border-gray-300">
                                <div class="font-medium">{{ $asset->nama_aset ?? 'N/A' }}</div>
                                <div class="text-gray-500 text-xs">{{ $asset->jenis_aset ?? '' }}</div>
                            </td>

                            <!-- Dipinjam Section -->
                            <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                                {{ $firstMovement->tarikh_mula ? \Carbon\Carbon::parse($firstMovement->tarikh_mula)->format('d/m/Y') : 'N/A' }}
                            </td>
                            <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $totalQuantity }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                                <div class="text-xs text-gray-500">
                                    {{ $firstMovement->approver->name ?? 'System' }} <!-- Assuming relation exists or just display text -->
                                </div>
                            </td>
                            <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                                @if($firstMovement->pegawai_bertanggungjawab_signature)
                                    <div class="flex justify-center">
                                        <img src="{{ $firstMovement->pegawai_bertanggungjawab_signature }}" alt="Signature" class="h-8 object-contain">
                                    </div>
                                @else
                                    <div
                                        class="h-8 border-2 border-dashed border-gray-300 rounded flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">Tiada</span>
                                    </div>
                                @endif
                            </td>

                            <!-- Dipulangkan Section -->
                            <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                                {{ $firstMovement->tarikh_pulang_sebenar ? \Carbon\Carbon::parse($firstMovement->tarikh_pulang_sebenar)->format('d/m/Y') : 'Belum Dipulangkan' }}
                            </td>
                            <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                                @if($firstMovement->tarikh_pulang_sebenar)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        {{ $totalQuantity }}
                                    </span>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                                @if($firstMovement->tandatangan_penerima)
                                    <div class="flex justify-center">
                                        <img src="{{ $firstMovement->tandatangan_penerima }}" alt="Receiver Sign" class="h-8 object-contain">
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                                    @if($firstMovement->tandatangan_pemulangan)
                                    <div class="flex justify-center">
                                        <img src="{{ $firstMovement->tandatangan_pemulangan }}" alt="Returner Sign" class="h-8 object-contain">
                                    </div>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="14" class="px-4 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class='bx bx-transfer text-4xl text-gray-300 mb-4'></i>
                                    <p class="text-lg font-medium">Tiada pergerakan aset ditemui</p>
                                    <p class="text-sm">Tiada pergerakan aset yang memenuhi kriteria carian</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>

        <!-- Summary Information -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Permohonan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $movements->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-file-blank text-blue-600 text-xl'></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Belum Dipulangkan</p>
                        <p class="text-2xl font-bold text-orange-600">
                            {{ $movements->where('status_pergerakan', '!=', 'dipulangkan')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-time text-orange-600 text-xl'></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Telah Dipulangkan</p>
                        <p class="text-2xl font-bold text-green-600">
                            {{ $movements->where('status_pergerakan', 'dipulangkan')->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-check-circle text-green-600 text-xl'></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 flex flex-wrap gap-4 justify-end">
            <button onclick="window.print()"
                class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                <i class='bx bx-printer mr-2'></i>
                Cetak Laporan
            </button>

            <button onclick="exportToPDF()"
                class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                <i class='bx bx-download mr-2'></i>
                Muat Turun PDF
            </button>

            <a href="{{ route('admin.reports.br-ams-forms') }}"
                class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                <i class='bx bx-arrow-back mr-2'></i>
                Kembali ke Senarai Laporan
            </a>
        </div>
    </div>

    @push('scripts')
        <script>
            function exportToPDF() {
                const urlParams = new URLSearchParams(window.location.search);
                const pdfUrl = '{{ route("admin.reports.br-ams-004.pdf") }}?' + urlParams.toString();
                const previewWindow = window.open(pdfUrl, '_blank', 'width=1024,height=768');
                if (!previewWindow) {
                    alert('Sila benarkan pop-up untuk melihat pratonton PDF');
                }
            }

            // Print styles
            window.addEventListener('beforeprint', function () {
                // Hide action buttons when printing
                const actionButtons = document.querySelector('.flex.flex-wrap.gap-4.justify-end');
                if (actionButtons) {
                    actionButtons.style.display = 'none';
                }
            });

            window.addEventListener('afterprint', function () {
                // Show action buttons after printing
                const actionButtons = document.querySelector('.flex.flex-wrap.gap-4.justify-end');
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
                    font-size: 10px;
                }

                table {
                    font-size: 9px;
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