@extends('layouts.admin')

@section('title', 'BR-AMS 005 - Borang Pemeriksaan Aset Alih')
@section('page-title', 'BR-AMS 005 - Borang Pemeriksaan Aset Alih')
@section('page-description', 'Borang rasmi pemeriksaan aset alih oleh pegawai pemeriksa')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">BR-AMS 005 - Borang Pemeriksaan Aset Alih</h1>
                <p class="text-emerald-100 text-lg">Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan Surau Negeri Selangor</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-search-alt text-emerald-200'></i>
                        <span class="text-emerald-100">Borang Rasmi</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-shield-check text-emerald-200'></i>
                        <span class="text-emerald-100">Negeri Selangor</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-search-alt text-6xl text-emerald-200 opacity-80'></i>
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
                        <option value="">Pilih Masjid/Surau</option>
                        @foreach($masjidSurauList as $ms)
                            <option value="{{ $ms->id }}" {{ $masjidSurauId == $ms->id ? 'selected' : '' }}>
                                {{ $ms->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class='bx bx-calendar mr-1'></i>
                        Tahun
                    </label>
                    <input type="number" name="tahun" value="{{ $tahun }}" 
                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                           placeholder="Cth: 2024">
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
    <div class="bg-white rounded-2xl border border-gray-200 shadow-lg overflow-hidden mb-8">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 flex items-center">
                        <i class='bx bx-clipboard text-emerald-600 mr-3'></i>
                        Borang Pemeriksaan Aset Alih
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">Form pemeriksaan aset mengikut kriteria yang dipilih</p>
                </div>
                <div class="hidden md:flex items-center space-x-2 text-sm text-gray-500">
                    <i class='bx bx-info-circle'></i>
                    <span>Total: {{ $assets->count() }} aset</span>
                </div>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full border-0 shadow-inner">
                <!-- Table Header -->
                <thead class="bg-emerald-50">
                    <tr>
                        <th rowspan="2" class="px-4 py-3 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200 border-b border-emerald-200 w-12">
                            BIL
                        </th>
                        <th rowspan="2" class="px-4 py-3 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200 border-b border-emerald-200 w-32">
                            NOMBOR SIRI PENDAFTARAN
                        </th>
                        <th rowspan="2" class="px-4 py-3 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200 border-b border-emerald-200 w-24">
                            KETERANGAN ASET
                        </th>
                        <th colspan="2" class="px-4 py-3 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200 border-b border-emerald-200">
                            LOKASI
                        </th>
                        <th colspan="5" class="px-4 py-3 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200 border-b border-emerald-200">
                            STATUS ASET
                        </th>
                        <th rowspan="2" class="px-4 py-3 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-b border-emerald-200 w-40">
                            CATATAN
                        </th>
                    </tr>
                    <tr class="bg-emerald-50">
                        <th class="px-4 py-3 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200 w-40">
                            MENGIKUT BR-AMS 001/BR-AMS 002
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200 w-40">
                            SEBENAR
                        </th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200 w-12">
                            A
                        </th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200 w-12">
                            B
                        </th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200 w-12">
                            C
                        </th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200 w-12">
                            D
                        </th>
                        <th class="px-3 py-3 text-center text-xs font-semibold text-emerald-800 uppercase tracking-wider border-r border-emerald-200 w-12">
                            E
                        </th>
                    </tr>
                </thead>
                
                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($assets as $index => $asset)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-center text-sm font-medium text-gray-900 border-r border-gray-200 w-12">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-200 w-32">
                            <div class="font-mono text-xs bg-gray-100 px-2 py-1 rounded">
                                {{ $asset->nombor_siri_pendaftaran ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-200 w-24">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                <i class='bx bx-package mr-1'></i>
                                {{ $asset->jenis_aset ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-200 w-40">
                            <div class="text-xs text-gray-600 flex items-center justify-center">
                                <i class='bx bx-map-pin mr-1 text-blue-500'></i>
                                {{ $asset->lokasi_penempatan ?? 'N/A' }}
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 border-r border-gray-200 w-40">
                            <div class="text-xs text-gray-500 italic">
                                Lokasi Sebenar
                            </div>
                        </td>
                        <td class="px-3 py-3 text-center text-sm text-gray-900 border-r border-gray-200 w-12">
                            <div class="flex justify-center">
                                <div class="h-4 w-4 border-2 border-gray-300 rounded"></div>
                            </div>
                        </td>
                        <td class="px-3 py-3 text-center text-sm text-gray-900 border-r border-gray-200 w-12">
                            <div class="flex justify-center">
                                <div class="h-4 w-4 border-2 border-gray-300 rounded"></div>
                            </div>
                        </td>
                        <td class="px-3 py-3 text-center text-sm text-gray-900 border-r border-gray-200 w-12">
                            <div class="flex justify-center">
                                <div class="h-4 w-4 border-2 border-gray-300 rounded"></div>
                            </div>
                        </td>
                        <td class="px-3 py-3 text-center text-sm text-gray-900 border-r border-gray-200 w-12">
                            <div class="flex justify-center">
                                <div class="h-4 w-4 border-2 border-gray-300 rounded"></div>
                            </div>
                        </td>
                        <td class="px-3 py-3 text-center text-sm text-gray-900 border-r border-gray-200 w-12">
                            <div class="flex justify-center">
                                <div class="h-4 w-4 border-2 border-gray-300 rounded"></div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-center text-sm text-gray-900 w-40">
                            <div class="text-xs text-gray-500 italic">
                                Catatan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="px-8 py-16 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <div class="bg-gray-100 rounded-full p-6 mb-4">
                                    <i class='bx bx-search text-6xl text-gray-400'></i>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-700 mb-2">Tiada aset ditemui</h3>
                                <p class="text-sm text-gray-500 max-w-md">Tiada aset yang memenuhi kriteria carian. Cuba ubah penapis atau tambah aset baru.</p>
                                <button class="mt-4 bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    <i class='bx bx-plus mr-1'></i>
                                    Tambah Aset
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Notes Section -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Nota:</h3>
        <div class="space-y-4 text-sm text-gray-700">
            <div>
                <p><strong>Lokasi:</strong> Nyatakan lokasi aset mengikut Senarai Daftar Harta Modal (GPA-1) / Senarai Daftar Inventori (GPA-2) dan lokasi aset semasa pemeriksaan (sebenar).</p>
            </div>
            <div>
                <p><strong>Status Aset:</strong> Tandakan (✔) pada yang berkenaan.</p>
                <ul class="mt-3 space-y-2">
                    <li class="flex items-center space-x-2">
                        <span class="font-medium text-emerald-600">A.</span>
                        <span>Sedang Digunakan</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="font-medium text-emerald-600">B.</span>
                        <span>Tidak Digunakan</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="font-medium text-emerald-600">C.</span>
                        <span>Rosak</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="font-medium text-emerald-600">D.</span>
                        <span>Sedang Diselenggara</span>
                    </li>
                    <li class="flex items-center space-x-2">
                        <span class="font-medium text-emerald-600">E.</span>
                        <span>Hilang</span>
                    </li>
                </ul>
            </div>
            <div>
                <p><strong>Catatan:</strong> Apa-apa maklumat tambahan berkenaan aset tersebut.</p>
            </div>
        </div>
    </div>

    <!-- Signature Section -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">(a) Disediakan oleh :</h3>
        
        <div class="space-y-6">
            <!-- Signature Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Tandatangan:</label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center bg-gray-50">
                    <div class="text-gray-400 text-sm">
                        <i class='bx bx-edit text-2xl mb-2 block'></i>
                        Tandatangan di sini
                    </div>
                </div>
            </div>
            
            <!-- Name Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama:</label>
                <div class="border-b-2 border-gray-300 pb-1">
                    <input type="text" class="w-full bg-transparent border-none outline-none text-gray-700" placeholder="Masukkan nama">
                </div>
            </div>
            
            <!-- Position Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jawatan:</label>
                <div class="border-b-2 border-gray-300 pb-1">
                    <input type="text" class="w-full bg-transparent border-none outline-none text-gray-700" placeholder="Masukkan jawatan">
                </div>
            </div>
            
            <!-- Date Field -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tarikh:</label>
                <div class="border-b-2 border-gray-300 pb-1">
                    <input type="date" class="w-full bg-transparent border-none outline-none text-gray-700">
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <!-- Note -->
            <div class="flex-1">
                <p class="text-sm text-gray-600">
                    <i class='bx bx-info-circle text-blue-500 mr-1'></i>
                    *NOTA: Laporan ini melaporkan kedudukan keseluruhan aset alih yang dimiliki oleh masjid/surau merangkumi penerimaan serta maklumat pelupusan dan hapus kira yang telah dikemaskini
                </p>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-wrap gap-3">
                <button onclick="window.print()" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <i class='bx bx-printer mr-2'></i>
                    Cetak Laporan
                </button>
                
                <button onclick="exportToPDF()" class="inline-flex items-center px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                    <i class='bx bx-download mr-2'></i>
                    Muat Turun PDF
                </button>
                
                <a href="{{ route('admin.reports.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition-colors">
                    <i class='bx bx-arrow-back mr-2'></i>
                    Kembali ke Senarai Borang
                </a>
            </div>
        </div>
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
/* Custom table enhancements */
.table-row-hover:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.checkbox-enhanced {
    position: relative;
}

.checkbox-enhanced input[type="checkbox"] {
    appearance: none;
    background: white;
    border: 2px solid #d1d5db;
    border-radius: 4px;
    width: 20px;
    height: 20px;
    cursor: pointer;
    transition: all 0.2s ease;
}

.checkbox-enhanced input[type="checkbox"]:checked {
    background: #10b981;
    border-color: #10b981;
}

.checkbox-enhanced input[type="checkbox"]:checked::after {
    content: '✓';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    color: white;
    font-size: 12px;
    font-weight: bold;
}

.input-enhanced {
    transition: all 0.2s ease;
}

.input-enhanced:focus {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
}

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
