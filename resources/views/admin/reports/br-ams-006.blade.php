@extends('layouts.admin')

@section('title', 'BR-AMS 006 - Rekod Penyelenggaraan Aset Alih')
@section('page-title', 'BR-AMS 006 - Rekod Penyelenggaraan Aset Alih')
@section('page-description', 'Borang rasmi rekod penyelenggaraan aset alih')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">BR-AMS 006 - Rekod Penyelenggaraan Aset Alih</h1>
                <p class="text-emerald-100 text-lg">Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan Surau Negeri Selangor</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-wrench text-emerald-200'></i>
                        <span class="text-emerald-100">Borang Rasmi</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-shield-check text-emerald-200'></i>
                        <span class="text-emerald-100">Negeri Selangor</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-wrench text-6xl text-emerald-200 opacity-80'></i>
            </div>
        </div>
    </div>

        <!-- Filter Section -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                            TARIKH
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            NO SIRI PENDAFTARAN
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            BUTIR-BUTIR KERJA
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            SYARIKAT PENYELENGGARA
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            KOS (RM)
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">
                            CATATAN
                        </th>
                    </tr>
                </thead>
                
                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($maintenanceRecords as $index => $record)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            {{ $record->tarikh_penyelenggaraan ? \Carbon\Carbon::parse($record->tarikh_penyelenggaraan)->format('d/m/Y') : 'N/A' }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-medium">{{ $record->asset->no_siri_pendaftaran ?? 'N/A' }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-medium">{{ $record->butiran_penyelenggaraan ?? 'N/A' }}</div>
                            @if($record->asset)
                                <div class="text-gray-500 text-xs">{{ $record->asset->nama_aset }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            {{ $record->syarikat_penyelenggara ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-medium text-right">{{ number_format($record->kos_penyelenggaraan ?? 0, 2) }}</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-900">
                            {{ $record->catatan ?? 'N/A' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class='bx bx-wrench text-4xl text-gray-300 mb-4'></i>
                                <p class="text-lg font-medium">Tiada rekod penyelenggaraan ditemui</p>
                                <p class="text-sm">Tiada rekod penyelenggaraan yang memenuhi kriteria carian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                
                <!-- Summary Row -->
                @if($maintenanceRecords->count() > 0)
                <tfoot class="bg-gray-100">
                    <tr>
                        <td colspan="4" class="px-4 py-3 text-right text-sm font-bold text-gray-900 border-r border-gray-300">
                            JUMLAH KESELURUHAN (RM)
                        </td>
                        <td class="px-4 py-3 text-center text-sm font-bold text-gray-900 border-r border-gray-300">
                            {{ number_format($totalCost, 2) }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900">
                            -
                        </td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <!-- Left Side Fields Section -->
    <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Side Fields -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Maklumat Tambahan</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis / Aset:</label>
                        <div class="h-10 border border-gray-300 rounded-lg flex items-center px-3 bg-gray-50">
                            <span class="text-gray-500 text-sm">Pilih aset untuk maklumat</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Penyelenggaraan :</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" name="jenis_penyelenggaraan" value="pencegahan" class="mr-2">
                                <span class="text-sm text-gray-700">Pencegahan</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="jenis_penyelenggaraan" value="pembaikan" class="mr-2">
                                <span class="text-sm text-gray-700">Pembaikan</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl border border-gray-200 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600">Total Rekod</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $maintenanceRecords->count() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class='bx bx-wrench text-blue-600 text-xl'></i>
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
        </div>
    </div>

    <!-- Signature Section -->
    <div class="mt-8 bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex justify-end">
            <div class="text-right">
                <div class="h-12 border-b-2 border-dashed border-gray-400 mb-2 w-64"></div>
                <p class="text-sm text-gray-600">(Tandatangan)</p>
                <div class="h-8 border-b-2 border-dashed border-gray-400 mb-2 w-64 mt-4"></div>
                <p class="text-sm text-gray-600">(Nama Bendahari)</p>
                <div class="flex items-center space-x-4 mt-4">
                    <span class="text-sm font-medium text-gray-700">Tarikh :</span>
                    <div class="h-8 w-32 border-b-2 border-dashed border-gray-400"></div>
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
}
</style>
@endpush
@endsection
