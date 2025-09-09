@extends('layouts.admin')

@section('title', 'BR-AMS 004 - Borang Permohonan Pergerakan / Pinjaman Aset Alih')
@section('page-title', 'BR-AMS 004 - Borang Permohonan Pergerakan / Pinjaman Aset Alih')
@section('page-description', 'Borang rasmi permohonan pergerakan dan pinjaman aset alih')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">BR-AMS 004 - Borang Permohonan Pergerakan / Pinjaman Aset Alih</h1>
                <p class="text-emerald-100 text-lg">Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan Surau Negeri Selangor</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-transfer text-emerald-200'></i>
                        <span class="text-emerald-100">Borang Rasmi</span>
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                        <i class='bx bx-check-circle mr-1'></i>
                        Status
                    </label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                        <option value="">Semua Status</option>
                        @foreach($statusOptions as $key => $label)
                            <option value="{{ $key }}" {{ $status == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                        <i class='bx bx-search mr-2'></i>
                        Terapkan Penapis
                    </button>
                </div>
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
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            Bil.
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            Nama Pemohon
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            Jawatan
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            Tujuan
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            Nombor Siri Pendaftaran
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            Keterangan Aset
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300" colspan="4">
                            Dipinjam
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider" colspan="4">
                            Dipulangkan
                        </th>
                    </tr>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300"></th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300"></th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300"></th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300"></th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300"></th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300"></th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            Tarikh
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            Kuantiti
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            Tandatangan Penyerah
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            Tandatangan Peminjam
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            Tarikh
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            Kuantiti
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            Tandatangan Penerima
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">
                            Tandatangan Peminjam
                        </th>
                    </tr>
                </thead>
                
                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($movements as $index => $movement)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-medium">{{ $movement->user->name ?? 'N/A' }}</div>
                        </td>
                        <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                            {{ $movement->user->jawatan ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                            {{ $movement->tujuan_pergerakan ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-medium">{{ $movement->asset->nombor_siri_pendaftaran ?? 'N/A' }}</div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-medium">{{ $movement->asset->nama_aset ?? 'N/A' }}</div>
                            <div class="text-gray-500 text-xs">{{ $movement->asset->jenis_aset ?? '' }}</div>
                        </td>
                        
                        <!-- Dipinjam Section -->
                        <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                            {{ $movement->tarikh_mula ? \Carbon\Carbon::parse($movement->tarikh_mula)->format('d/m/Y') : 'N/A' }}
                        </td>
                        <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $movement->kuantiti ?? 1 }}
                            </span>
                        </td>
                        <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="h-8 border-2 border-dashed border-gray-300 rounded flex items-center justify-center">
                                <span class="text-gray-400 text-xs">Tandatangan</span>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="h-8 border-2 border-dashed border-gray-300 rounded flex items-center justify-center">
                                <span class="text-gray-400 text-xs">Tandatangan</span>
                            </div>
                        </td>
                        
                        <!-- Dipulangkan Section -->
                        <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                            {{ $movement->tarikh_pulang ? \Carbon\Carbon::parse($movement->tarikh_pulang)->format('d/m/Y') : 'Belum Dipulangkan' }}
                        </td>
                        <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                            @if($movement->tarikh_pulang)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $movement->kuantiti ?? 1 }}
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                            @if($movement->tarikh_pulang)
                                <div class="h-8 border-2 border-dashed border-gray-300 rounded flex items-center justify-center">
                                    <span class="text-gray-400 text-xs">Tandatangan</span>
                                </div>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-center text-sm text-gray-900">
                            @if($movement->tarikh_pulang)
                                <div class="h-8 border-2 border-dashed border-gray-300 rounded flex items-center justify-center">
                                    <span class="text-gray-400 text-xs">Tandatangan</span>
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
                    <p class="text-2xl font-bold text-orange-600">{{ $movements->where('status_pergerakan', '!=', 'dipulangkan')->count() }}</p>
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
                    <p class="text-2xl font-bold text-green-600">{{ $movements->where('status_pergerakan', 'dipulangkan')->count() }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-check-circle text-green-600 text-xl'></i>
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
