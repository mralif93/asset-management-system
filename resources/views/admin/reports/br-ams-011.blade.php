@extends('layouts.admin')

@section('title', 'BR-AMS 011 - Senarai Rekod Aset Tak Alih')
@section('page-title', 'BR-AMS 011 - Senarai Rekod Aset Tak Alih')
@section('page-description', 'Laporan rasmi senarai rekod aset tak alih')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">BR-AMS 011 - Senarai Rekod Aset Tak Alih</h1>
                <p class="text-emerald-100 text-lg">Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan Surau Negeri Selangor</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-building text-emerald-200'></i>
                        <span class="text-emerald-100">Laporan Rasmi</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-shield-check text-emerald-200'></i>
                        <span class="text-emerald-100">Negeri Selangor</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-building text-6xl text-emerald-200 opacity-80'></i>
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
            <h3 class="text-lg font-semibold text-gray-900">Senarai Rekod Aset Tak Alih</h3>
            <p class="text-sm text-gray-600">Data aset tak alih mengikut kriteria yang dipilih</p>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-emerald-50">
                    <tr>
                        <th rowspan="2" class="px-6 py-4 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">BIL</th>
                        <th colspan="4" class="px-6 py-4 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">MAKLUMAT ASET TANAH</th>
                        <th colspan="4" class="px-6 py-4 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">MAKLUMAT ASET BANGUNAN</th>
                        <th colspan="3" class="px-6 py-4 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200">SUMBER PEROLEHAN</th>
                        <th rowspan="2" class="px-6 py-4 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider">KOS PEROLEHAN ASET</th>
                    </tr>
                    <tr class="bg-emerald-100/50">
                        <th class="px-6 py-3 text-center text-xs font-medium text-emerald-700 uppercase tracking-wider border-r border-emerald-200">NO. HAKMILIK</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-emerald-700 uppercase tracking-wider border-r border-emerald-200">NO. LOT</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-emerald-700 uppercase tracking-wider border-r border-emerald-200">STATUS TANAH MAIS</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-emerald-700 uppercase tracking-wider border-r border-emerald-200">KELUASAN TANAH</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-emerald-700 uppercase tracking-wider border-r border-emerald-200">JENIS ASET BANGUNAN</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-emerald-700 uppercase tracking-wider border-r border-emerald-200">ALAMAT BANGUNAN</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-emerald-700 uppercase tracking-wider border-r border-emerald-200">KELUASAN PREMIS (m²)</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-emerald-700 uppercase tracking-wider border-r border-emerald-200">KOS</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-emerald-700 uppercase tracking-wider border-r border-emerald-200">KERAJAAN NEGERI/ PERSEKUTUAN</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-emerald-700 uppercase tracking-wider border-r border-emerald-200">INDIVIDU/ ENTITI</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-emerald-700 uppercase tracking-wider border-r border-emerald-200">DANA AWAM</th>
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($immovableAssets as $index => $asset)
                    <tr class="hover:bg-emerald-50 transition-colors">
                        <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-200">{{ $index + 1 }}</td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-200">
                            <div class="font-medium">{{ $asset->no_hakmilik ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-200">
                            <div class="font-medium">{{ $asset->no_lot ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-200">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $asset->status_tanah_mais ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-200">
                            <div class="font-medium">{{ number_format($asset->keluasan_tanah ?? 0, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 border-r border-gray-200">
                            <div class="font-medium">{{ $asset->jenis_aset_bangunan ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 border-r border-gray-200">
                            <div class="font-medium">{{ $asset->alamat_bangunan ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-200">
                            <div class="font-medium">{{ $asset->keluasan_premis ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-200">
                            <div class="font-medium text-right">{{ number_format($asset->kos_bangunan ?? 0, 2) }}</div>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-200">
                            @if($asset->sumber_perolehan == 'kerajaan_negeri' || $asset->sumber_perolehan == 'kerajaan_persekutuan')
                                <i class='bx bx-check text-green-600 text-lg'></i>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-200">
                            @if($asset->sumber_perolehan == 'individu' || $asset->sumber_perolehan == 'entiti')
                                <i class='bx bx-check text-green-600 text-lg'></i>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-200">
                            @if($asset->sumber_perolehan == 'dana_awam')
                                <i class='bx bx-check text-green-600 text-lg'></i>
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900">
                            <div class="font-bold text-right">{{ number_format($asset->kos_perolehan ?? 0, 2) }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="13" class="px-8 py-16 text-center">
                            <div class="flex flex-col items-center">
                                <div class="bg-emerald-50 rounded-full p-6 mb-4">
                                    <i class='bx bx-building text-5xl text-emerald-400'></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tiada Rekod Aset Tak Alih Ditemui</h3>
                                <p class="text-sm text-gray-500 max-w-md">Tiada rekod aset tak alih yang memenuhi kriteria carian. Cuba ubah penapis untuk melihat data lain.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

                @if($immovableAssets->count() > 0)
                <tfoot class="bg-emerald-50">
                    <tr>
                        <td colspan="12" class="px-6 py-4 text-center text-sm font-bold text-gray-900 border-r border-emerald-200">JUMLAH KESELURUHAN</td>
                        <td class="px-6 py-4 text-center text-sm font-bold text-gray-900">{{ number_format($totalCost, 2) }}</td>
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
                    <p class="text-sm text-gray-600">Total Aset Tak Alih</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $immovableAssets->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-building text-blue-600 text-xl'></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Jumlah Kos</p>
                    <p class="text-2xl font-bold text-green-600">RM {{ number_format($totalCost, 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-dollar text-green-600 text-xl'></i>
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
                <p><strong>Laporan Aset Tak Alih:</strong> Senarai ini memaparkan semua aset tak alih yang dimiliki oleh masjid/surau termasuk tanah dan bangunan.</p>
            </div>
            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                <p><strong>Maklumat Penting:</strong></p>
                <ul class="mt-2 space-y-1 text-xs">
                    <li>• <strong>Jenis Aset:</strong> Kategori aset (tanah/bangunan)</li>
                    <li>• <strong>Lokasi:</strong> Alamat atau lokasi aset</li>
                    <li>• <strong>Luas:</strong> Saiz tanah atau bangunan</li>
                    <li>• <strong>Sumber:</strong> Sumber perolehan aset</li>
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
                    *NOTA: Laporan ini melaporkan kedudukan keseluruhan aset tak alih yang dimiliki oleh masjid/surau
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
    const pdfUrl = '{{ route("admin.reports.br-ams-011.pdf") }}?' + urlParams.toString();
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
        font-size: 8px;
    }
    table {
        font-size: 7px;
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
