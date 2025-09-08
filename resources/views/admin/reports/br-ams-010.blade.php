@extends('layouts.admin')

@section('title', 'BR-AMS 010 - Laporan Tahunan Pengurusan Aset Alih')
@section('page-title', 'BR-AMS 010 - Laporan Tahunan Pengurusan Aset Alih')
@section('page-description', 'Borang rasmi laporan tahunan pengurusan aset alih')

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
            <div class="text-left text-sm text-gray-600 mb-2">BR-AMS 010</div>
            <h1 class="text-3xl font-bold text-gray-900 mb-6">LAPORAN TAHUNAN PENGURUSAN ASET ALIH</h1>
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

    <!-- Main Table Section -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-300">
                <!-- Table Header -->
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            PERKARA
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            KUANTITI
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            JUMLAH NILAI PEMBELIAN (RM)
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            HARTA MODAL (BR-AMS 001) (a)
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            INVENTORI (BR-AMS 002) (b)
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            PELUPUSAN ASET (BR-AMS 007) (c)
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            HAPUS KIRA (BR-AMS 008) (d)
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">
                            JUMLAH KESELURUHAN (a) + (b) - (c) - (d)
                        </th>
                    </tr>
                </thead>
                
                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Row 1: Capital Assets -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 border-r border-gray-300">
                            Harta Modal
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $capitalAssetsCount }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-medium text-right">{{ number_format($capitalAssetsValue, 2) }}</div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-bold text-right">{{ number_format($capitalAssetsValue, 2) }}</div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="text-gray-400">-</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="text-gray-400">-</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="text-gray-400">-</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900">
                            <div class="font-bold text-right">{{ number_format($capitalAssetsValue, 2) }}</div>
                        </td>
                    </tr>
                    
                    <!-- Row 2: Inventory -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 border-r border-gray-300">
                            Inventori
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                {{ $inventoryCount }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-medium text-right">{{ number_format($inventoryValue, 2) }}</div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="text-gray-400">-</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-bold text-right">{{ number_format($inventoryValue, 2) }}</div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="text-gray-400">-</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="text-gray-400">-</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900">
                            <div class="font-bold text-right">{{ number_format($inventoryValue, 2) }}</div>
                        </td>
                    </tr>
                    
                    <!-- Row 3: Disposals -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 border-r border-gray-300">
                            Pelupusan Aset
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ $disposalsCount }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-medium text-right">{{ number_format($disposalsValue, 2) }}</div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="text-gray-400">-</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="text-gray-400">-</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-bold text-right text-red-600">-{{ number_format($disposalsValue, 2) }}</div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="text-gray-400">-</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900">
                            <div class="font-bold text-right text-red-600">-{{ number_format($disposalsValue, 2) }}</div>
                        </td>
                    </tr>
                    
                    <!-- Row 4: Write-offs -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm font-medium text-gray-900 border-r border-gray-300">
                            Hapus Kira
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                {{ $writeoffsCount }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-medium text-right">{{ number_format($writeoffsValue, 2) }}</div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="text-gray-400">-</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="text-gray-400">-</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="text-gray-400">-</span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-bold text-right text-red-600">-{{ number_format($writeoffsValue, 2) }}</div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900">
                            <div class="font-bold text-right text-red-600">-{{ number_format($writeoffsValue, 2) }}</div>
                        </td>
                    </tr>
                </tbody>
                
                <!-- Summary Row -->
                <tfoot class="bg-gray-100">
                    <tr>
                        <td class="px-4 py-3 text-sm font-bold text-gray-900 border-r border-gray-300">
                            JUMLAH KESELURUHAN
                        </td>
                        <td class="px-4 py-3 text-center text-sm font-bold text-gray-900 border-r border-gray-300">
                            {{ $capitalAssetsCount + $inventoryCount + $disposalsCount + $writeoffsCount }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm font-bold text-gray-900 border-r border-gray-300">
                            {{ number_format($capitalAssetsValue + $inventoryValue + $disposalsValue + $writeoffsValue, 2) }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm font-bold text-gray-900 border-r border-gray-300">
                            {{ number_format($capitalAssetsValue, 2) }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm font-bold text-gray-900 border-r border-gray-300">
                            {{ number_format($inventoryValue, 2) }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm font-bold text-gray-900 border-r border-gray-300">
                            {{ number_format($disposalsValue, 2) }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm font-bold text-gray-900 border-r border-gray-300">
                            {{ number_format($writeoffsValue, 2) }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm font-bold text-gray-900">
                            <div class="text-lg font-bold text-green-600">{{ number_format($grandTotal, 2) }}</div>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Harta Modal</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $capitalAssetsCount }}</p>
                    <p class="text-xs text-gray-500">RM {{ number_format($capitalAssetsValue, 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-building text-blue-600 text-xl'></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Inventori</p>
                    <p class="text-2xl font-bold text-green-600">{{ $inventoryCount }}</p>
                    <p class="text-xs text-gray-500">RM {{ number_format($inventoryValue, 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-package text-green-600 text-xl'></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Pelupusan</p>
                    <p class="text-2xl font-bold text-red-600">{{ $disposalsCount }}</p>
                    <p class="text-xs text-gray-500">RM {{ number_format($disposalsValue, 0) }}</p>
                </div>
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-trash text-red-600 text-xl'></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Nilai Bersih</p>
                    <p class="text-2xl font-bold text-green-600">RM {{ number_format($grandTotal, 0) }}</p>
                    <p class="text-xs text-gray-500">Tahun {{ $tahun }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-calculator text-green-600 text-xl'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Formula Explanation -->
    <div class="mt-8 bg-blue-50 rounded-xl border border-blue-200 p-6">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class='bx bx-info-circle text-blue-600 text-xl'></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800 mb-2">Formula Pengiraan</h3>
                <p class="text-sm text-blue-700">
                    <strong>Nilai Bersih = (Harta Modal + Inventori) - (Pelupusan + Hapus Kira)</strong><br>
                    <span class="text-xs text-blue-600">
                        ({{ number_format($capitalAssetsValue, 0) }} + {{ number_format($inventoryValue, 0) }}) - ({{ number_format($disposalsValue, 0) }} + {{ number_format($writeoffsValue, 0) }}) = RM {{ number_format($grandTotal, 2) }}
                    </span>
                </p>
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
    
    .bg-blue-50 {
        background-color: #eff6ff !important;
        -webkit-print-color-adjust: exact;
    }
}
</style>
@endpush
@endsection
