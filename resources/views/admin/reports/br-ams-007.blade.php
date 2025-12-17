@extends('layouts.admin')

@section('title', 'BR-AMS 007 - Rekod Pelupusan Aset Alih')
@section('page-title', 'BR-AMS 007 - Rekod Pelupusan Aset Alih')
@section('page-description', 'Borang rasmi rekod pelupusan aset alih')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">BR-AMS 007 - Rekod Pelupusan Aset Alih</h1>
                <p class="text-emerald-100 text-lg">Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan Surau Negeri Selangor</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-trash text-emerald-200'></i>
                        <span class="text-emerald-100">Borang Rasmi</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-shield-check text-emerald-200'></i>
                        <span class="text-emerald-100">Negeri Selangor</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-trash text-6xl text-emerald-200 opacity-80'></i>
            </div>
        </div>
    </div>

        <!-- Filter Section -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Masjid / Surau :</label>
                    <select name="masjid_surau_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Masjid/Surau</option>
                        @foreach($masjidSurauList as $ms)
                            <option value="{{ $ms->id }}" {{ $masjidSurauId == $ms->id ? 'selected' : '' }}>
                                {{ $ms->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Daerah :</label>
                    <select name="daerah" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Daerah</option>
                        @foreach($daerahList as $d)
                            <option value="{{ $d }}" {{ $daerah == $d ? 'selected' : '' }}>
                                {{ $d }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun :</label>
                    <input type="number" name="tahun" value="{{ $tahun }}" 
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                           placeholder="Cth: 2024">
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                        <i class='bx bx-search mr-2'></i>Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-300">
                <!-- Table Header -->
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            BIL
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            NOMBOR SIRI PENDAFTARAN ASET
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            KETERANGAN ASET
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            KUANTITI
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            USIA ASET DIGUNAKAN
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            TARIKH PEMBELIAN
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            HARGA PEMBELIAN (RM)
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            JUSTIFIKASI
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">
                            KAEDAH PELUPUSAN
                        </th>
                    </tr>
                </thead>
                
                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($disposals as $index => $disposal)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-medium">{{ $disposal->asset->no_siri_pendaftaran ?? 'N/A' }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-medium">{{ $disposal->asset->nama_aset ?? 'N/A' }}</div>
                            <div class="text-gray-500 text-xs">{{ $disposal->asset->jenis_aset ?? '' }}</div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $disposal->kuantiti ?? 1 }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            @if($disposal->asset && $disposal->asset->tarikh_perolehan)
                                @php
                                    $usia = \Carbon\Carbon::parse($disposal->asset->tarikh_perolehan)->diffInYears($disposal->tarikh_pelupusan);
                                @endphp
                                {{ $usia }} tahun
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            {{ $disposal->asset && $disposal->asset->tarikh_perolehan ? \Carbon\Carbon::parse($disposal->asset->tarikh_perolehan)->format('d/m/Y') : 'N/A' }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-medium text-right">{{ number_format($disposal->asset->nilai_perolehan ?? 0, 2) }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 border-r border-gray-300">
                            {{ $disposal->sebab_pelupusan ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ ucfirst(str_replace('_', ' ', $disposal->kaedah_pelupusan ?? 'N/A')) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class='bx bx-trash text-4xl text-gray-300 mb-4'></i>
                                <p class="text-lg font-medium">Tiada rekod pelupusan ditemui</p>
                                <p class="text-sm">Tiada rekod pelupusan yang memenuhi kriteria carian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                
                <!-- Summary Row -->
                @if($disposals->count() > 0)
                <tfoot class="bg-gray-100">
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-right text-sm font-bold text-gray-900 border-r border-gray-300">
                            JUMLAH KESELURUHAN (RM)
                        </td>
                        <td class="px-4 py-3 text-center text-sm font-bold text-gray-900 border-r border-gray-300">
                            {{ number_format($totalValue, 2) }}
                        </td>
                        <td colspan="2" class="px-4 py-3 text-center text-sm text-gray-900">
                            -
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <!-- Approval Section -->
    <div class="mt-8 bg-gray-50 rounded-xl p-6">
        <div class="text-sm text-gray-700">
            <p class="mb-4">
                <strong>Kelulusan pelupusan ini dibuat berdasarkan keputusan Mesyuarat Jawatankuasa Bil.</strong> 
                <span class="inline-block w-24 h-6 border-b border-gray-400 mx-2"></span>
                <strong>/ Tahun</strong> 
                <span class="inline-block w-24 h-6 border-b border-gray-400 mx-2"></span>
                <strong>bertarikh</strong> 
                <span class="inline-block w-32 h-6 border-b border-gray-400 mx-2"></span>
            </p>
        </div>
    </div>

    <!-- Signature Section -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Prepared by Section -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Disediakan oleh:</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-2">Pegawai Aset:</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama :</label>
                    <div class="h-8 border-b border-gray-300"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarikh :</label>
                    <div class="h-8 border-b border-gray-300"></div>
                </div>
            </div>
        </div>

        <!-- Certified by Section -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Disahkan oleh :</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm font-medium text-gray-700 mb-2">Pengerusi Jawatankuasa:</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama :</label>
                    <div class="h-8 border-b border-gray-300"></div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarikh :</label>
                    <div class="h-8 border-b border-gray-300"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Total Pelupusan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $disposals->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-trash text-red-600 text-xl'></i>
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

    <!-- Action Buttons -->
    <div class="mt-8 flex flex-wrap gap-4 justify-center">
        <button onclick="window.print()" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
            <i class='bx bx-printer mr-2'></i>
            Cetak Laporan
        </button>
        
        <button onclick="exportToPDF()" class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
            <i class='bx bx-download mr-2'></i>
            Muat Turun PDF
        </button>
        
        <a href="{{ route('admin.reports.br-ams-forms') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
            <i class='bx bx-arrow-back mr-2'></i>
            Kembali ke Senarai Borang
        </a>
    </div>
</div>

@push('scripts')
<script>
function exportToPDF() {
    const urlParams = new URLSearchParams(window.location.search);
    const pdfUrl = '{{ route("admin.reports.br-ams-007.pdf") }}?' + urlParams.toString();
    const previewWindow = window.open(pdfUrl, '_blank', 'width=1024,height=768');
    if (!previewWindow) {
        alert('Sila benarkan pop-up untuk melihat pratonton PDF');
    }
}, 2000);
}

// Print styles
window.addEventListener('beforeprint', function() {
    // Hide action buttons when printing
    const actionButtons = document.querySelector('.flex.flex-wrap.gap-4.justify-center');
    if (actionButtons) {
        actionButtons.style.display = 'none';
    }
});

window.addEventListener('afterprint', function() {
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
