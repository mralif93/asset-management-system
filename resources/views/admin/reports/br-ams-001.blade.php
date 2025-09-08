@extends('layouts.admin')

@section('title', 'BR-AMS 001 - Senarai Daftar Harta Modal')
@section('page-title', 'BR-AMS 001 - Senarai Daftar Harta Modal')
@section('page-description', 'Borang rasmi pendaftaran harta modal masjid dan surau')

@section('content')
<div class="p-6">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 mb-8">
        <!-- Official Header -->
        <div class="text-right text-sm text-gray-600 mb-4">
            Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan Surau Negeri Selangor
        </div>
        
        <!-- Form Title -->
        <div class="text-center mb-8">
            <div class="text-left text-sm text-gray-600 mb-2">BR-AMS 001</div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">SENARAI DAFTAR HARTA MODAL</h1>
            
            <!-- Filter Section -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Masjid/Surau:</label>
                        <select name="masjid_surau_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Masjid/Surau</option>
                            @foreach($masjidSurauList as $ms)
                                <option value="{{ $ms->id }}" {{ $masjidSurauId == $ms->id ? 'selected' : '' }}>
                                    {{ $ms->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Daerah:</label>
                        <select name="daerah" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Daerah</option>
                            @foreach($daerahList as $d)
                                <option value="{{ $d }}" {{ $daerah == $d ? 'selected' : '' }}>
                                    {{ $d }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="flex items-end">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors">
                            <i class='bx bx-search mr-2'></i>Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Table -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <!-- Table Header -->
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">
                            BIL.
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">
                            NOMBOR SIRI PENDAFTARAN
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">
                            KETERANGAN ASET
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">
                            CARA ASET DIPEROLEHI
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">
                            TARIKH PEMBELIAN
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">
                            HARGA PEMBELIAN (RM)
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">
                            PENEMPATAN
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-r border-gray-200">
                            STATUS ASET (PELUPUSAN/HAPUS KIRA)
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            JUMLAH (RM)
                        </th>
                    </tr>
                </thead>
                
                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($assets as $index => $asset)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200">
                            <div class="font-medium">{{ $asset->nombor_siri_pendaftaran ?? 'N/A' }}</div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-900 border-r border-gray-200">
                            <div class="font-medium">{{ $asset->nama_aset }}</div>
                            <div class="text-gray-500 text-xs">{{ $asset->jenis_aset }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200">
                            {{ ucfirst(str_replace('_', ' ', $asset->cara_perolehan ?? 'N/A')) }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200">
                            {{ $asset->tarikh_perolehan ? \Carbon\Carbon::parse($asset->tarikh_perolehan)->format('d/m/Y') : 'N/A' }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 border-r border-gray-200 text-right">
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
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Dilupuskan
                                </span>
                            @elseif($asset->status_aset == 'hapus_kira')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Hapus Kira
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
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
                        <td colspan="8" class="px-4 py-3 text-right text-sm font-medium text-gray-900 border-r border-gray-200">
                            JUMLAH (RM)
                        </td>
                        <td class="px-4 py-3 text-right text-sm font-bold text-gray-900">
                            {{ number_format($totalValue, 2) }}
                        </td>
                    </tr>
                    <tr class="bg-gray-200">
                        <td colspan="8" class="px-4 py-3 text-right text-sm font-bold text-gray-900 border-r border-gray-200">
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

    <!-- Footer Note -->
    <div class="mt-6 text-right text-sm text-gray-600">
        <p>*NOTA: Laporan ini melaporkan kedudukan keseluruhan aset alih yang dimiliki oleh masjid/surau merangkumi penerimaan serta maklumat pelupusan dan hapus kira yang telah dikemaskini</p>
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
    // Show loading state
    const button = event.target;
    const originalContent = button.innerHTML;
    
    button.innerHTML = `
        <i class='bx bx-loader-alt animate-spin mr-2'></i>
        Memproses...
    `;
    button.disabled = true;
    
    // Simulate PDF generation
    setTimeout(() => {
        button.innerHTML = originalContent;
        button.disabled = false;
        alert('Fungsi export PDF akan dilaksanakan - fail PDF akan dimuat turun');
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
