@extends('layouts.admin')

@section('title', 'BR-AMS 009 - Laporan Kehilangan / Hapus Kira Aset Alih')
@section('page-title', 'BR-AMS 009 - Laporan Kehilangan / Hapus Kira Aset Alih')
@section('page-description', 'Laporan rasmi laporan kehilangan / hapus kira aset alih')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">BR-AMS 009 - Laporan Kehilangan / Hapus Kira Aset Alih</h1>
                <p class="text-emerald-100 text-lg">Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan Surau Negeri Selangor</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-error-circle text-emerald-200'></i>
                        <span class="text-emerald-100">Laporan Rasmi</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-shield-check text-emerald-200'></i>
                        <span class="text-emerald-100">Negeri Selangor</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-error-circle text-6xl text-emerald-200 opacity-80'></i>
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
                    <select name="masjid_surau_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
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
                    <select name="daerah" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
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
                        <i class='bx bx-location-plus mr-1'></i>
                        Lokasi
                    </label>
                    <select name="lokasi" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
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
                    <select name="bulan" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
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
                        <i class='bx bx-calendar-year mr-1'></i>
                        Tahun
                    </label>
                    <select name="tahun" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                        <option value="">Semua Tahun</option>
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-6 rounded-lg transition-colors">
                    <i class='bx bx-search mr-2'></i>Terapkan Penapis
                </button>
            </div>
        </form>
    </div>

    <!-- Main Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Senarai Kehilangan / Hapus Kira Aset</h3>
            <p class="text-sm text-gray-600">Data kehilangan/hapus kira aset mengikut kriteria yang dipilih</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-emerald-50">
                    <tr>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">BIL</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">NOMBOR SIRI PENDAFTARAN</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">KETERANGAN ASET</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">KUANTITI KEHILANGAN</th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider">HARGA PEMBELIAN (RM)</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($lossWriteoffs as $index => $lossWriteoff)
                    <tr class="hover:bg-emerald-50 transition-colors">
                        <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-200">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-200">
                            <div class="font-medium">{{ $lossWriteoff->asset->no_siri_pendaftaran ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 border-r border-gray-200">
                            <div class="font-medium">{{ $lossWriteoff->asset->nama_aset ?? 'N/A' }}</div>
                            <div class="text-gray-500 text-xs">{{ $lossWriteoff->asset->jenis_aset ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-200">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $lossWriteoff->kuantiti_kehilangan ?? 1 }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900">
                            <div class="font-medium text-right">{{ number_format($lossWriteoff->asset->nilai_perolehan ?? 0, 2) }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="bg-emerald-50 rounded-full p-6 mb-4">
                                    <i class='bx bx-x-circle text-5xl text-emerald-400'></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tiada Rekod Kehilangan Ditemui</h3>
                                <p class="text-sm text-gray-500 max-w-md">Tiada rekod kehilangan/hapus kira yang memenuhi kriteria carian. Cuba ubah penapis untuk melihat data lain.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

                @if($lossWriteoffs->count() > 0)
                <tfoot class="bg-emerald-50">
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm font-bold text-gray-900 border-r border-emerald-200">JUMLAH KESELURUHAN</td>
                        <td class="px-6 py-4 text-center text-sm font-bold text-gray-900">{{ number_format($totalValue, 2) }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Kehilangan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $lossWriteoffs->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-x-circle text-red-600 text-xl'></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Jumlah Nilai</p>
                    <p class="text-2xl font-bold text-red-600">RM {{ number_format($totalValue, 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-dollar text-red-600 text-xl'></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <p class="text-lg font-bold text-blue-600">Aktif</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-check-circle text-blue-600 text-xl'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes Section -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Nota:</h3>
        <div class="space-y-4 text-sm text-gray-700">
            <div>
                <p><strong>Laporan Penerimaan Aset:</strong> Senarai ini memaparkan semua rekod penerimaan aset alih baru yang telah didaftarkan.</p>
            </div>
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                <p><strong>Maklumat Penting:</strong></p>
                <ul class="mt-2 space-y-1 text-xs">
                    <li>• <strong>Tarikh Penerimaan:</strong> Tarikh aset diterima</li>
                    <li>• <strong>Sumber:</strong> Sumber perolehan aset (dana awam/sumbangan)</li>
                    <li>• <strong>No. Rujukan:</strong> Nombor rujukan dokumen penerimaan</li>
                    <li>• <strong>Status:</strong> Status pendaftaran aset</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div class="flex-1">
                <p class="text-sm text-gray-600">
                    <i class='bx bx-info-circle text-blue-500 mr-1'></i>
                    *NOTA: Laporan ini melaporkan semua rekod penerimaan aset alih yang telah didaftarkan
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button onclick="exportToPDF()"
                    class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                    <i class='bx bx-file-blank mr-2'></i>
                    Muat Turun / Cetak Laporan
                </button>

                <a href="{{ route('admin.reports.br-ams-forms') }}"
                    class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <i class='bx bx-arrow-back mr-2'></i>
                    Kembali ke Senarai Laporan
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function exportToPDF() {
    const urlParams = new URLSearchParams(window.location.search);
    const pdfUrl = '{{ route("admin.reports.br-ams-009.pdf") }}?' + urlParams.toString();
    const previewWindow = window.open(pdfUrl, '_blank', 'width=1024,height=768');
    if (!previewWindow) {
        alert('Sila benarkan pop-up untuk melihat pratonton PDF');
    }
}

window.addEventListener('beforeprint', function() {
    const actionButtons = document.querySelector('.flex.flex-wrap.gap-4.justify-center');
    if (actionButtons) {
        actionButtons.style.display = 'none';
    }
});

window.addEventListener('afterprint', function() {
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
        font-size: 10px;
    }
    table {
        font-size: 9px;
    }
    .bg-emerald-50 {
        background-color: #ecfdf5 !important;
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
