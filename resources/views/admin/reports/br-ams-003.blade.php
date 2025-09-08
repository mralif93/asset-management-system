@extends('layouts.admin')

@section('title', 'BR-AMS 003 - Senarai Aset Alih di Lokasi')
@section('page-title', 'BR-AMS 003 - Senarai Aset Alih di Lokasi')
@section('page-description', 'Borang rasmi senarai aset alih mengikut lokasi')

@section('content')
<div class="p-6">
    <!-- Header Section -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 mb-8">
        <!-- Official Header -->
        <div class="text-left text-sm text-gray-600 mb-4">
            Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan Surau Negeri Selangor
        </div>
        
        <!-- Form Title -->
        <div class="text-center mb-8">
            <div class="text-right text-sm text-gray-600 mb-2">BR-AMS 003</div>
            <h1 class="text-3xl font-bold text-gray-900 mb-6">SENARAI ASET ALIH DI LOKASI</h1>
            
            <!-- Filter Section -->
            <div class="bg-gray-50 rounded-lg p-6 mb-6">
                <form method="GET" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">MASJID / SURAU:</label>
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
                        <label class="block text-sm font-medium text-gray-700 mb-2">LOKASI:</label>
                        <select name="lokasi" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Pilih Lokasi</option>
                            @foreach($lokasiList as $l)
                                <option value="{{ $l }}" {{ $lokasi == $l ? 'selected' : '' }}>
                                    {{ $l }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="md:col-span-2 flex justify-center">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors">
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
                        <th class="px-6 py-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            BIL
                        </th>
                        <th class="px-6 py-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            NOMBOR SIRI PENDAFTARAN
                        </th>
                        <th class="px-6 py-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider border-r border-gray-300">
                            KETERANGAN ASET
                        </th>
                        <th class="px-6 py-4 text-center text-sm font-medium text-gray-700 uppercase tracking-wider">
                            KUANTITI
                        </th>
                    </tr>
                </thead>
                
                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($assets as $index => $asset)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-medium">{{ $asset->nombor_siri_pendaftaran ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-medium">{{ $asset->nama_aset }}</div>
                            <div class="text-gray-500 text-xs">{{ $asset->jenis_aset }}</div>
                            @if($asset->masjidSurau)
                                <div class="text-gray-500 text-xs">{{ $asset->masjidSurau->nama }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $asset->kuantiti ?? 1 }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class='bx bx-package text-4xl text-gray-300 mb-4'></i>
                                <p class="text-lg font-medium">Tiada aset ditemui</p>
                                <p class="text-sm">Tiada aset yang memenuhi kriteria carian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Signature and Approval Sections -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Prepared by Section -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">(a) Disediakan oleh :</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tandatangan:</label>
                    <div class="h-16 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400 text-sm">Tandatangan di sini</span>
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarikh:</label>
                    <div class="h-8 border-b border-gray-300"></div>
                </div>
            </div>
        </div>

        <!-- Verified by Section -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">(b) Disahkan oleh :</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tandatangan:</label>
                    <div class="h-16 border-2 border-dashed border-gray-300 rounded-lg flex items-center justify-center">
                        <span class="text-gray-400 text-sm">Tandatangan di sini</span>
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
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarikh :</label>
                    <div class="h-8 border-b border-gray-300"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notes Section -->
    <div class="mt-8 bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Nota</h3>
        <div class="space-y-3 text-sm text-gray-700">
            <p><strong>a) Disediakan oleh Pegawai Aset/ Pembantu Pegawai Aset.</strong></p>
            <p class="ml-4">Pegawai yang mengesahkan ialah pegawai yang bertanggungjawab ke atas aset alih berkenaan.</p>
            <p class="ml-4"><strong>Contohnya:-</strong></p>
            <p class="ml-8"><strong>i. Lokasi Bilik Mesyuarat - disahkan oleh pegawai yang menguruskan bilik mesyuarat.</strong></p>
            <p><strong>b) Dikemaskini apabila terdapat perubahan kuantiti, lokasi atau pegawai bertanggungjawab.</strong></p>
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
