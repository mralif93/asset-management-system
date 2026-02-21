@extends('layouts.admin')

@section('title', 'Laporan Sistem BR-AMS')
@section('page-title', 'Laporan Sistem BR-AMS')
@section('page-description', 'Laporan Aset Masjid dan Surau (BR-AMS) - Garis Panduan Negeri Selangor')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Laporan Aset Masjid dan Surau (BR-AMS)</h1>
                <p class="text-emerald-100 text-lg">Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan Surau Negeri Selangor</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-file-blank text-emerald-200'></i>
                        <span class="text-emerald-100">11 Laporan Tersedia</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-shield-check text-emerald-200'></i>
                        <span class="text-emerald-100">Rasmi Negeri Selangor</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-file-blank text-6xl text-emerald-200 opacity-80'></i>
            </div>
        </div>
    </div>


    <!-- BR-AMS Reports Grid -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Semua Laporan BR-AMS</h2>
                <p class="text-gray-600">Klik pada borang untuk mengakses dan menjana laporan</p>
            </div>
            <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
        </div>

        <!-- BR-AMS Reports Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <!-- BR-AMS 001 -->
            <div class="group bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-emerald-200">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                <i class='bx bx-list-ul text-emerald-600 text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">BR-AMS 001</h3>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    <i class='bx bx-check-circle text-xs mr-1'></i>
                                    Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Senarai Daftar Harta Modal</h4>
                        <p class="text-sm text-gray-600 mb-3">List of Capital Asset Register</p>
                    </div>
                    <a href="{{ route('admin.reports.br-ams-001') }}" 
                       class="group/btn w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <i class='bx bx-right-arrow-alt text-lg mr-2 group-hover/btn:translate-x-1 transition-transform'></i>
                        Akses Laporan
                    </a>
                </div>
            </div>

            <!-- BR-AMS 002 -->
            <div class="group bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-emerald-200">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                <i class='bx bx-package text-emerald-600 text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">BR-AMS 002</h3>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    <i class='bx bx-check-circle text-xs mr-1'></i>
                                    Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Senarai Daftar Inventori</h4>
                        <p class="text-sm text-gray-600 mb-3">List of Inventory Register</p>
                    </div>
                    <a href="{{ route('admin.reports.br-ams-002') }}" 
                       class="group/btn w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <i class='bx bx-right-arrow-alt text-lg mr-2 group-hover/btn:translate-x-1 transition-transform'></i>
                        Akses Laporan
                    </a>
                </div>
            </div>

            <!-- BR-AMS 003 -->
            <div class="group bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-emerald-200">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                <i class='bx bx-map text-emerald-600 text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">BR-AMS 003</h3>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    <i class='bx bx-check-circle text-xs mr-1'></i>
                                    Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Senarai Aset Alih di Lokasi</h4>
                        <p class="text-sm text-gray-600 mb-3">List of Movable Assets at Location</p>
                    </div>
                    <a href="{{ route('admin.reports.br-ams-003') }}" 
                       class="group/btn w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <i class='bx bx-right-arrow-alt text-lg mr-2 group-hover/btn:translate-x-1 transition-transform'></i>
                        Akses Laporan
                    </a>
                </div>
            </div>

            <!-- BR-AMS 004 -->
            <div class="group bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-emerald-200">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                <i class='bx bx-transfer text-emerald-600 text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">BR-AMS 004</h3>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    <i class='bx bx-check-circle text-xs mr-1'></i>
                                    Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Laporan Pergerakan / Pinjaman Aset Alih</h4>
                        <p class="text-sm text-gray-600 mb-3">Movable Asset Movement/Loan Report</p>
                    </div>
                    <a href="{{ route('admin.reports.br-ams-004') }}" 
                       class="group/btn w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <i class='bx bx-right-arrow-alt text-lg mr-2 group-hover/btn:translate-x-1 transition-transform'></i>
                        Akses Laporan
                    </a>
                </div>
            </div>

            <!-- BR-AMS 005 -->
            <div class="group bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-emerald-200">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                <i class='bx bx-search text-emerald-600 text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">BR-AMS 005</h3>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    <i class='bx bx-check-circle text-xs mr-1'></i>
                                    Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Laporan Pemeriksaan Aset Alih</h4>
                        <p class="text-sm text-gray-600 mb-3">Movable Asset Inspection Report</p>
                    </div>
                    <a href="{{ route('admin.reports.br-ams-005') }}" 
                       class="group/btn w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <i class='bx bx-right-arrow-alt text-lg mr-2 group-hover/btn:translate-x-1 transition-transform'></i>
                        Akses Laporan
                    </a>
                </div>
            </div>

            <!-- BR-AMS 006 -->
            <div class="group bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-emerald-200">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                <i class='bx bx-wrench text-emerald-600 text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">BR-AMS 006</h3>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    <i class='bx bx-check-circle text-xs mr-1'></i>
                                    Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Rekod Penyelenggaraan Aset Alih</h4>
                        <p class="text-sm text-gray-600 mb-3">Movable Asset Maintenance Record</p>
                    </div>
                    <a href="{{ route('admin.reports.br-ams-006') }}" 
                       class="group/btn w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <i class='bx bx-right-arrow-alt text-lg mr-2 group-hover/btn:translate-x-1 transition-transform'></i>
                        Akses Laporan
                    </a>
                </div>
            </div>

            <!-- BR-AMS 007 -->
            <div class="group bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-emerald-200">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                <i class='bx bx-trash text-emerald-600 text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">BR-AMS 007</h3>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    <i class='bx bx-check-circle text-xs mr-1'></i>
                                    Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Rekod Pelupusan Aset Alih</h4>
                        <p class="text-sm text-gray-600 mb-3">Record of Disposal of Movable Assets</p>
                    </div>
                    <a href="{{ route('admin.reports.br-ams-007') }}" 
                       class="group/btn w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <i class='bx bx-right-arrow-alt text-lg mr-2 group-hover/btn:translate-x-1 transition-transform'></i>
                        Akses Laporan
                    </a>
                </div>
            </div>

            <!-- BR-AMS 008 -->
            <div class="group bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-emerald-200">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                <i class='bx bx-file-blank text-emerald-600 text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">BR-AMS 008</h3>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    <i class='bx bx-check-circle text-xs mr-1'></i>
                                    Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Laporan Tindakan Pelupusan Aset Alih</h4>
                        <p class="text-sm text-gray-600 mb-3">Asset Disposal Action Report</p>
                    </div>
                    <a href="{{ route('admin.reports.br-ams-008') }}" 
                       class="group/btn w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <i class='bx bx-right-arrow-alt text-lg mr-2 group-hover/btn:translate-x-1 transition-transform'></i>
                        Akses Laporan
                    </a>
                </div>
            </div>

            <!-- BR-AMS 009 -->
            <div class="group bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-emerald-200">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                <i class='bx bx-x-circle text-emerald-600 text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">BR-AMS 009</h3>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    <i class='bx bx-check-circle text-xs mr-1'></i>
                                    Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Laporan Kehilangan / Hapus Kira Aset Alih</h4>
                        <p class="text-sm text-gray-600 mb-3">Report of Loss / Write-off of Movable Assets</p>
                    </div>
                    <a href="{{ route('admin.reports.br-ams-009') }}" 
                       class="group/btn w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <i class='bx bx-right-arrow-alt text-lg mr-2 group-hover/btn:translate-x-1 transition-transform'></i>
                        Akses Laporan
                    </a>
                </div>
            </div>

            <!-- BR-AMS 010 -->
            <div class="group bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-emerald-200">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                <i class='bx bx-calendar text-emerald-600 text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">BR-AMS 010</h3>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    <i class='bx bx-check-circle text-xs mr-1'></i>
                                    Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Laporan Tahunan Pengurusan Aset Alih</h4>
                        <p class="text-sm text-gray-600 mb-3">Annual Report on Movable Asset Management</p>
                    </div>
                    <a href="{{ route('admin.reports.br-ams-010') }}" 
                       class="group/btn w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <i class='bx bx-right-arrow-alt text-lg mr-2 group-hover/btn:translate-x-1 transition-transform'></i>
                        Akses Laporan
                    </a>
                </div>
            </div>

            <!-- BR-AMS 011 -->
            <div class="group bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-emerald-200">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                <i class='bx bx-building text-emerald-600 text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">BR-AMS 011</h3>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                    <i class='bx bx-check-circle text-xs mr-1'></i>
                                    Tersedia
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">Senarai Rekod Aset Tak Alih</h4>
                        <p class="text-sm text-gray-600 mb-3">List of Immovable Asset Records</p>
                    </div>
                    <a href="{{ route('admin.reports.br-ams-011') }}" 
                       class="group/btn w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-colors">
                        <i class='bx bx-right-arrow-alt text-lg mr-2 group-hover/btn:translate-x-1 transition-transform'></i>
                        Akses Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-2xl p-8 border border-emerald-200">
        <div class="flex items-start space-x-4">
            <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class='bx bx-info-circle text-emerald-600 text-xl'></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Maklumat Penting</h3>
                <div class="space-y-2 text-sm text-gray-600">
                    <p>• Semua borang BR-AMS mengikut garis panduan rasmi Negeri Selangor</p>
                    <p>• Laporan ini digunakan untuk pengurusan aset masjid dan surau di seluruh Selangor</p>
                    <p>• Setiap borang mempunyai fungsi dan kegunaan yang spesifik dalam kitaran hayat aset</p>
                    <p>• Pastikan data yang dimasukkan adalah tepat dan lengkap mengikut keperluan</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Add some interactive effects
document.addEventListener('DOMContentLoaded', function() {
    // Animate form cards on load
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

    // Add hover effects for better UX
    const formCards = document.querySelectorAll('.group');
    formCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Add click animation to buttons
    const buttons = document.querySelectorAll('a[href*="br-ams"]');
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Add loading state
            const originalContent = this.innerHTML;
            this.innerHTML = `
                <i class='bx bx-loader-alt animate-spin text-lg mr-2'></i>
                Memproses...
            `;
            this.classList.add('opacity-75', 'cursor-not-allowed');
            
            // Reset after a short delay (in case of navigation issues)
            setTimeout(() => {
                this.innerHTML = originalContent;
                this.classList.remove('opacity-75', 'cursor-not-allowed');
            }, 3000);
        });
    });
});
</script>
@endpush
@endsection 