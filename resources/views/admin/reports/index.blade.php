@extends('layouts.admin')

@section('title', 'Laporan Sistem')
@section('page-title', 'Laporan Sistem')
@section('page-description', 'Analisis dan statistik sistem pengurusan aset')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Pusat Laporan Sistem</h1>
                <p class="text-emerald-100 text-lg">Analisis komprehensif dan statistik sistem pengurusan aset</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-chart text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $totalAssets ?? 0 }} aset</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-shield-check text-emerald-200'></i>
                        <span class="text-emerald-100">Sistem Aktif</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-chart text-6xl text-emerald-200 opacity-80'></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Assets -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-blue-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-box text-blue-600 text-xl'></i>
                </div>
                <span class="text-sm text-blue-600 bg-blue-100 px-2 py-1 rounded-full font-medium">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalAssets ?? 0 }}</h3>
            <p class="text-sm text-gray-600">Jumlah Aset</p>
            <div class="mt-2 flex items-center text-xs text-gray-500">
                <i class='bx bx-trending-up mr-1'></i>
                <span>Keseluruhan sistem</span>
            </div>
        </div>

        <!-- Total Value -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-green-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-dollar text-green-600 text-xl'></i>
                </div>
                <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">RM</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($totalValue ?? 0, 0) }}</h3>
            <p class="text-sm text-gray-600">Nilai Keseluruhan</p>
            <div class="mt-2 flex items-center text-xs text-gray-500">
                <i class='bx bx-wallet mr-1'></i>
                <span>Nilai aset terkini</span>
            </div>
        </div>

        <!-- Maintenance Needed -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-orange-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-wrench text-orange-600 text-xl'></i>
                </div>
                <span class="text-sm text-orange-600 bg-orange-100 px-2 py-1 rounded-full font-medium">Perlu</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalMaintenance ?? 0 }}</h3>
            <p class="text-sm text-gray-600">Penyelenggaraan</p>
            <div class="mt-2 flex items-center text-xs text-gray-500">
                <i class='bx bx-time mr-1'></i>
                <span>Perlu tindakan</span>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-red-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-time text-red-600 text-xl'></i>
                </div>
                <span class="text-sm text-red-600 bg-red-100 px-2 py-1 rounded-full font-medium">Menunggu</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $pendingApprovals ?? 0 }}</h3>
            <p class="text-sm text-gray-600">Kelulusan</p>
            <div class="mt-2 flex items-center text-xs text-gray-500">
                <i class='bx bx-hourglass mr-1'></i>
                <span>Perlu kelulusan</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Generate Report -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-emerald-200 cursor-pointer" onclick="window.print()">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                    <i class='bx bx-printer text-emerald-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-emerald-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Cetak Laporan</h3>
            <p class="text-sm text-gray-600">Cetak ringkasan keseluruhan</p>
        </div>

        <!-- Export Data -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-blue-200 cursor-pointer" onclick="exportToCSV()">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <i class='bx bx-download text-blue-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-blue-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Eksport Data</h3>
            <p class="text-sm text-gray-600">Muat turun data CSV</p>
        </div>

        <!-- Analytics Dashboard -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-purple-200 cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <i class='bx bx-bar-chart text-purple-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-purple-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Dashboard Analitik</h3>
            <p class="text-sm text-gray-600">Visualisasi data interaktif</p>
        </div>

        <!-- Scheduled Reports -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-amber-200 cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                    <i class='bx bx-calendar text-amber-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-amber-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Laporan Terjadual</h3>
            <p class="text-sm text-gray-600">Jadual laporan automatik</p>
        </div>
    </div>

    <!-- BR-AMS Forms Section -->
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-200 p-8 mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Borang Aset Masjid dan Surau (BR-AMS)</h2>
                <p class="text-gray-600">Borang rasmi mengikut garis panduan Negeri Selangor</p>
            </div>
            <div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center">
                <i class='bx bx-file-blank text-blue-600 text-3xl'></i>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white rounded-lg p-4 border border-blue-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-list-ul text-blue-600'></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">11 Borang</p>
                        <p class="text-xs text-gray-600">BR-AMS 001-011</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg p-4 border border-blue-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-check-circle text-green-600'></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Tersedia</p>
                        <p class="text-xs text-gray-600">Semua borang aktif</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg p-4 border border-blue-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-shield-check text-purple-600'></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">Rasmi</p>
                        <p class="text-xs text-gray-600">Negeri Selangor</p>
                    </div>
                </div>
            </div>
        </div>
        
        <a href="{{ route('admin.reports.br-ams-forms') }}" 
           class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
            <i class='bx bx-right-arrow-alt text-lg mr-2'></i>
            Lihat Semua Borang BR-AMS
        </a>
    </div>

    <!-- Report Categories -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Asset Reports -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Laporan Aset</h2>
                    <p class="text-sm text-gray-600">Analisis komprehensif aset dan nilai</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-box text-blue-600 text-xl'></i>
                </div>
            </div>
            <div class="space-y-3">
                <a href="{{ route('admin.reports.annual-summary') }}" 
                   class="group block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-blue-200 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                <i class='bx bx-calendar text-blue-600 text-sm'></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">Ringkasan Tahunan</h3>
                                <p class="text-sm text-gray-600">Analisis lengkap prestasi aset tahunan</p>
                            </div>
                        </div>
                        <i class='bx bx-chevron-right text-gray-400 group-hover:text-blue-600 transition-colors'></i>
                    </div>
                </a>
                
                <a href="{{ route('admin.reports.movements-summary') }}" 
                   class="group block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-blue-200 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                <i class='bx bx-transfer text-blue-600 text-sm'></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">Pergerakan Aset</h3>
                                <p class="text-sm text-gray-600">Senarai pergerakan dan pemindahan aset</p>
                            </div>
                        </div>
                        <i class='bx bx-chevron-right text-gray-400 group-hover:text-blue-600 transition-colors'></i>
                    </div>
                </a>
                
                <a href="{{ route('admin.reports.asset-depreciation') }}" 
                   class="group block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-blue-200 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                <i class='bx bx-trending-down text-blue-600 text-sm'></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">Susut Nilai Aset</h3>
                                <p class="text-sm text-gray-600">Analisis susut nilai dan nilai semasa</p>
                            </div>
                        </div>
                        <i class='bx bx-chevron-right text-gray-400 group-hover:text-blue-600 transition-colors'></i>
                    </div>
                </a>

                <a href="{{ route('admin.reports.assets-by-location') }}" 
                   class="group block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-blue-200 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                <i class='bx bx-map text-blue-600 text-sm'></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">Aset Mengikut Lokasi</h3>
                                <p class="text-sm text-gray-600">Analisis distribusi aset mengikut lokasi</p>
                            </div>
                        </div>
                        <i class='bx bx-chevron-right text-gray-400 group-hover:text-blue-600 transition-colors'></i>
                    </div>
                </a>
            </div>
        </div>

        <!-- Maintenance Reports -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Laporan Penyelenggaraan</h2>
                    <p class="text-sm text-gray-600">Jadual dan analisis penyelenggaraan</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-wrench text-orange-600 text-xl'></i>
                </div>
            </div>
            <div class="space-y-3">
                <a href="{{ route('admin.reports.inspection-schedule') }}" 
                   class="group block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-orange-200 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                                <i class='bx bx-search text-orange-600 text-sm'></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">Jadual Pemeriksaan</h3>
                                <p class="text-sm text-gray-600">Senarai pemeriksaan yang perlu dilakukan</p>
                            </div>
                        </div>
                        <i class='bx bx-chevron-right text-gray-400 group-hover:text-orange-600 transition-colors'></i>
                    </div>
                </a>
                
                <a href="{{ route('admin.reports.maintenance-schedule') }}" 
                   class="group block p-4 border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-orange-200 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center group-hover:bg-orange-200 transition-colors">
                                <i class='bx bx-calendar-check text-orange-600 text-sm'></i>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">Jadual Penyelenggaraan</h3>
                                <p class="text-sm text-gray-600">Senarai penyelenggaraan yang dijadualkan</p>
                            </div>
                        </div>
                        <i class='bx bx-chevron-right text-gray-400 group-hover:text-orange-600 transition-colors'></i>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Analytics Overview -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Asset Status Chart -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Status Aset</h3>
                    <p class="text-sm text-gray-600">Distribusi status aset semasa</p>
                </div>
                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
            </div>
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                        <span class="text-gray-700 font-medium">Aktif</span>
                    </div>
                    <span class="font-bold text-green-600">{{ $statusCounts['aktif'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 bg-yellow-500 rounded-full"></div>
                        <span class="text-gray-700 font-medium">Dalam Penyelenggaraan</span>
                    </div>
                    <span class="font-bold text-yellow-600">{{ $statusCounts['maintenance'] ?? 0 }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-4 h-4 bg-red-500 rounded-full"></div>
                        <span class="text-gray-700 font-medium">Rosak</span>
                    </div>
                    <span class="font-bold text-red-600">{{ $statusCounts['rosak'] ?? 0 }}</span>
                </div>
            </div>
        </div>

        <!-- Asset Types Chart -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Jenis Aset</h3>
                    <p class="text-sm text-gray-600">Kategori aset dalam sistem</p>
                </div>
                <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
            </div>
            <div class="space-y-4">
                @if(isset($assetTypes) && count($assetTypes) > 0)
                    @foreach($assetTypes as $type => $count)
                    <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                        <span class="text-gray-700 font-medium">{{ $type }}</span>
                        <span class="font-bold text-blue-600">{{ $count }}</span>
                    </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class='bx bx-chart text-3xl text-gray-400'></i>
                        </div>
                        <p class="text-gray-500">Tiada data kategori tersedia</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Recent Activities -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Aktiviti Terkini</h3>
                <p class="text-sm text-gray-600">Aktiviti sistem dan transaksi terbaru</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="text-sm text-gray-500">Masa nyata</span>
                <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
            </div>
        </div>
        <div class="space-y-4">
            @if(isset($recentActivities) && count($recentActivities) > 0)
                @foreach($recentActivities as $activity)
                <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">
                    <div class="w-10 h-10 rounded-full bg-emerald-100 flex items-center justify-center">
                        <i class='bx {{ $activity['icon'] ?? "bx-box" }} text-emerald-600'></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-gray-900 font-medium">{{ $activity['description'] ?? 'Aktiviti sistem' }}</p>
                        <p class="text-sm text-gray-600">{{ $activity['time'] ?? 'Masa tidak diketahui' }}</p>
                    </div>
                    <div class="text-xs text-gray-400">
                        <i class='bx bx-time'></i>
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-12">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class='bx bx-history text-3xl text-gray-400'></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tiada Aktiviti Terkini</h3>
                    <p class="text-gray-500 text-sm">Aktiviti sistem akan dipaparkan di sini apabila tersedia</p>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function exportToCSV() {
    // Show loading state
    const button = event.target.closest('.group');
    const originalContent = button.innerHTML;
    
    // Simulate export process
    button.innerHTML = `
        <div class="flex items-center justify-center">
            <i class='bx bx-loader-alt animate-spin text-blue-600 text-xl mr-2'></i>
            <span>Memproses...</span>
        </div>
    `;
    
    setTimeout(() => {
        button.innerHTML = originalContent;
        alert('Fungsi export akan dilaksanakan - CSV akan dimuat turun');
    }, 2000);
}

// Add some interactive effects
document.addEventListener('DOMContentLoaded', function() {
    // Animate statistics cards on load
    const cards = document.querySelectorAll('.grid > div');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease';
            
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        }, index * 100);
    });
});
</script>
@endpush
@endsection 