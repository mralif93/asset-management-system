@extends('layouts.admin')

@section('title', 'BR-AMS 008 - Laporan Tindakan Pelupusan Aset Alih')
@section('page-title', 'BR-AMS 008 - Laporan Tindakan Pelupusan Aset Alih')
@section('page-description', 'Borang rasmi laporan tindakan pelupusan aset alih')

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
            <div class="text-left text-sm text-gray-600 mb-2">BR-AMS 008</div>
            <h1 class="text-3xl font-bold text-gray-900 mb-6">LAPORAN TINDAKAN PELUPUSAN ASET ALIH</h1>
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

    <!-- Main Form Section -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 mb-8">
        <!-- Approval Line -->
        <div class="mb-8">
            <div class="text-sm text-gray-700">
                <p class="mb-4">
                    <strong>Disahkan Aset Alih di Masjid / Surau</strong> 
                    <span class="inline-block w-full h-6 border-b border-gray-400 ml-2"></span>
                </p>
            </div>
        </div>

        <!-- Asset Details Section -->
        <div class="space-y-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Butiran Aset</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan Aset :</label>
                    <div class="h-10 border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 flex items-center">
                        @if($disposals->count() > 0)
                            {{ $disposals->first()->asset->nama_aset ?? 'N/A' }}
                        @else
                            <span class="text-gray-400">Tiada data</span>
                        @endif
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kuantiti :</label>
                    <div class="h-10 border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 flex items-center">
                        @if($disposals->count() > 0)
                            {{ $disposals->first()->kuantiti ?? 1 }}
                        @else
                            <span class="text-gray-400">Tiada data</span>
                        @endif
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kaedah Pelupusan :</label>
                    <div class="h-10 border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 flex items-center">
                        @if($disposals->count() > 0)
                            {{ ucfirst(str_replace('_', ' ', $disposals->first()->kaedah_pelupusan ?? 'N/A')) }}
                        @else
                            <span class="text-gray-400">Tiada data</span>
                        @endif
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Hasil Pelupusan (RM)* :</label>
                    <div class="h-10 border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 flex items-center">
                        @if($disposals->count() > 0 && $disposals->first()->kaedah_pelupusan == 'jualan')
                            {{ number_format($disposals->first()->hasil_pelupusan ?? 0, 2) }}
                        @else
                            <span class="text-gray-400">Tidak berkenaan</span>
                        @endif
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarikh :</label>
                    <div class="h-10 border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 flex items-center">
                        @if($disposals->count() > 0)
                            {{ \Carbon\Carbon::parse($disposals->first()->tarikh_pelupusan)->format('d/m/Y') }}
                        @else
                            <span class="text-gray-400">Tiada data</span>
                        @endif
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tempat :</label>
                    <div class="h-10 border border-gray-300 rounded-lg px-3 py-2 bg-gray-50 flex items-center">
                        @if($disposals->count() > 0)
                            {{ $disposals->first()->tempat_pelupusan ?? 'N/A' }}
                        @else
                            <span class="text-gray-400">Tiada data</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Disposal Records Table -->
    @if($disposals->count() > 0)
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mb-8">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Rekod Pelupusan</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Bil</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Keterangan Aset</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Kuantiti</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Kaedah Pelupusan</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Hasil (RM)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tarikh</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tempat</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($disposals as $index => $disposal)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $index + 1 }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <div class="font-medium">{{ $disposal->asset->nama_aset ?? 'N/A' }}</div>
                            <div class="text-gray-500 text-xs">{{ $disposal->asset->jenis_aset ?? '' }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $disposal->kuantiti ?? 1 }}</td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                {{ ucfirst(str_replace('_', ' ', $disposal->kaedah_pelupusan ?? 'N/A')) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            @if($disposal->kaedah_pelupusan == 'jualan')
                                {{ number_format($disposal->hasil_pelupusan ?? 0, 2) }}
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ \Carbon\Carbon::parse($disposal->tarikh_pelupusan)->format('d/m/Y') }}
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">{{ $disposal->tempat_pelupusan ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Signature Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Left Signature Column -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tandatangan :</label>
                    <div class="h-20 border border-gray-300 rounded-lg bg-gray-50 flex items-center justify-center">
                        <span class="text-gray-400 text-sm">Tandatangan</span>
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Masjid/Surau :</label>
                    <div class="h-8 border-b border-gray-300"></div>
                </div>
            </div>
        </div>

        <!-- Right Signature Column -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tandatangan :</label>
                    <div class="h-20 border border-gray-300 rounded-lg bg-gray-50 flex items-center justify-center">
                        <span class="text-gray-400 text-sm">Tandatangan</span>
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Masjid/Surau :</label>
                    <div class="h-8 border-b border-gray-300"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Note Section -->
    <div class="bg-yellow-50 rounded-xl border border-yellow-200 p-6 mb-8">
        <div class="flex items-start">
            <div class="flex-shrink-0">
                <i class='bx bx-info-circle text-yellow-600 text-xl'></i>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-800">
                    <strong>*Nota:</strong> Hasil pelupusan diisi sekiranya kaedah pelupusan secara Jualan.
                </p>
            </div>
        </div>
    </div>

    <!-- Summary Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
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
                    <p class="text-sm text-gray-600">Hasil Jualan</p>
                    <p class="text-2xl font-bold text-green-600">RM {{ number_format($totalProceeds, 0) }}</p>
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

    <!-- Action Buttons -->
    <div class="flex flex-wrap gap-4 justify-center">
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
    
    .bg-gray-100 {
        background-color: #f3f4f6 !important;
        -webkit-print-color-adjust: exact;
    }
    
    .bg-gray-50 {
        background-color: #f9fafb !important;
        -webkit-print-color-adjust: exact;
    }
    
    .bg-yellow-50 {
        background-color: #fefce8 !important;
        -webkit-print-color-adjust: exact;
    }
}
</style>
@endpush
@endsection
