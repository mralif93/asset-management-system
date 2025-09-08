@extends('layouts.admin')

@section('title', 'BR-AMS 005 - Borang Pemeriksaan Aset Alih')
@section('page-title', 'BR-AMS 005 - Borang Pemeriksaan Aset Alih')
@section('page-description', 'Borang rasmi pemeriksaan aset alih oleh pegawai pemeriksa')

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
            <div class="text-left text-sm text-gray-600 mb-2">BR-AMS 005</div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">BORANG PEMERIKSAAN ASET ALIH</h1>
            <p class="text-lg text-gray-700">(Diisi oleh Pegawai Pemeriksa)</p>
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
                        <th rowspan="2" class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-b border-gray-300">
                            Bil.
                        </th>
                        <th rowspan="2" class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-b border-gray-300">
                            No. Siri Pendaftaran
                        </th>
                        <th rowspan="2" class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-b border-gray-300">
                            Jenis Aset
                        </th>
                        <th colspan="2" class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-b border-gray-300">
                            Lokasi
                        </th>
                        <th colspan="5" class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-b border-gray-300">
                            Status Aset
                        </th>
                        <th rowspan="2" class="px-4 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider border-b border-gray-300">
                            Catatan
                        </th>
                    </tr>
                    <tr class="bg-gray-50">
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            Mengikut BR-AMS 001/BR-AMS 002
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            Sebenar
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            A
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            B
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            C
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            D
                        </th>
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-600 uppercase tracking-wider border-r border-gray-300">
                            E
                        </th>
                    </tr>
                </thead>
                
                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($assets as $index => $asset)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="font-medium">{{ $asset->nombor_siri_pendaftaran ?? 'N/A' }}</div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            {{ $asset->jenis_aset ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            {{ $asset->lokasi_penempatan ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="h-8 border border-gray-300 rounded flex items-center justify-center">
                                <span class="text-gray-400 text-xs">Lokasi Sebenar</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="h-6 w-6 border border-gray-300 rounded flex items-center justify-center mx-auto">
                                <span class="text-gray-400 text-xs">√</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="h-6 w-6 border border-gray-300 rounded flex items-center justify-center mx-auto">
                                <span class="text-gray-400 text-xs">√</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="h-6 w-6 border border-gray-300 rounded flex items-center justify-center mx-auto">
                                <span class="text-gray-400 text-xs">√</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="h-6 w-6 border border-gray-300 rounded flex items-center justify-center mx-auto">
                                <span class="text-gray-400 text-xs">√</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-300">
                            <div class="h-6 w-6 border border-gray-300 rounded flex items-center justify-center mx-auto">
                                <span class="text-gray-400 text-xs">√</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900">
                            <div class="h-8 border border-gray-300 rounded flex items-center justify-center">
                                <span class="text-gray-400 text-xs">Catatan</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="px-4 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class='bx bx-search text-4xl text-gray-300 mb-4'></i>
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

    <!-- Notes Section -->
    <div class="mt-8 bg-gray-50 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Nota:</h3>
        <div class="space-y-3 text-sm text-gray-700">
            <div>
                <p><strong>Lokasi:</strong> Nyatakan lokasi aset mengikut Senarai Daftar Harta Modal (GPA-1) / Senarai Daftar Inventori (GPA-2) dan lokasi aset semasa pemeriksaan (sebenar).</p>
            </div>
            <div>
                <p><strong>Status Aset:</strong> Tandakan (√) pada yang berkenaan.</p>
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mt-2">
                    <div class="flex items-center space-x-2">
                        <span class="font-medium">A.</span>
                        <span>Sedang Digunakan</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="font-medium">B.</span>
                        <span>Tidak Digunakan</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="font-medium">C.</span>
                        <span>Rosak</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="font-medium">D.</span>
                        <span>Sedang Diselenggara</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="font-medium">E.</span>
                        <span>Hilang</span>
                    </div>
                </div>
            </div>
            <div>
                <p><strong>Catatan:</strong> Apa-apa maklumat tambahan berkenaan aset tersebut.</p>
            </div>
        </div>
    </div>

    <!-- Signature Section -->
    <div class="mt-8 bg-white rounded-xl border border-gray-200 p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <div class="h-12 border-b-2 border-dashed border-gray-400 mb-2"></div>
                <p class="text-sm text-gray-600">(Tandatangan)</p>
            </div>
            <div>
                <div class="h-12 border-b-2 border-dashed border-gray-400 mb-2"></div>
                <p class="text-sm text-gray-600">(Nama Bendahari)</p>
            </div>
            <div class="md:col-span-2 mt-4">
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-gray-700">Tarikh :</span>
                    <div class="h-8 w-48 border-b-2 border-dashed border-gray-400"></div>
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
