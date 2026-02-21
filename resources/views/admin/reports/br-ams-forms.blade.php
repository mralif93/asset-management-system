@extends('layouts.admin')

@section('title', 'Laporan Aset Masjid dan Surau (BR-AMS)')
@section('page-title', 'Laporan Aset Masjid dan Surau (BR-AMS)')
@section('page-description', 'Senarai lengkap borang rasmi pengurusan aset mengikut garis panduan Negeri Selangor')

@section('content')
<div class="p-6">
    <!-- Header Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Laporan Aset Masjid dan Surau (BR-AMS)</h1>
                <p class="text-blue-100 text-lg">Garis Panduan Pengurusan Kewangan, Perolehan Dan Aset Masjid Dan Surau Negeri Selangor</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-file-blank text-blue-200'></i>
                        <span class="text-blue-100">{{ count($brAmsForms) }} borang tersedia</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-shield-check text-blue-200'></i>
                        <span class="text-blue-100">Rasmi Negeri Selangor</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-file-blank text-6xl text-blue-200 opacity-80'></i>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Jumlah Laporan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ count($brAmsForms) }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-file-blank text-blue-600 text-xl'></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Kategori</p>
                    <p class="text-2xl font-bold text-gray-900">{{ count($formsByCategory) }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-category text-green-600 text-xl'></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Tersedia</p>
                    <p class="text-2xl font-bold text-emerald-600">{{ count(array_filter($brAmsForms, fn($form) => $form['available'])) }}</p>
                </div>
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-check-circle text-emerald-600 text-xl'></i>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl p-6 border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600">Status</p>
                    <p class="text-lg font-bold text-blue-600">Aktif</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-shield-check text-blue-600 text-xl'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Forms by Category -->
    @foreach($formsByCategory as $category => $forms)
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    @switch($category)
                        @case('Registration')
                            Pendaftaran Aset
                            @break
                        @case('Location')
                            Lokasi Aset
                            @break
                        @case('Movement')
                            Pergerakan Aset
                            @break
                        @case('Inspection')
                            Pemeriksaan Aset
                            @break
                        @case('Maintenance')
                            Penyelenggaraan Aset
                            @break
                        @case('Disposal')
                            Pelupusan Aset
                            @break
                        @case('Loss')
                            Kehilangan Aset
                            @break
                        @case('Annual')
                            Laporan Tahunan
                            @break
                        @case('Immovable')
                            Aset Tak Alih
                            @break
                        @default
                            {{ $category }}
                    @endswitch
                </h2>
                <p class="text-gray-600">{{ count($forms) }} borang dalam kategori ini</p>
            </div>
            <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($forms as $form)
            <div class="group bg-white rounded-xl border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-{{ $form['color'] }}-200">
                <div class="p-6">
                    <!-- Form Header -->
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 bg-{{ $form['color'] }}-100 rounded-lg flex items-center justify-center group-hover:bg-{{ $form['color'] }}-200 transition-colors">
                                <i class='bx {{ $form['icon'] }} text-{{ $form['color'] }}-600 text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">{{ $form['code'] }}</h3>
                                <div class="flex items-center space-x-2">
                                    @if($form['available'])
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                            <i class='bx bx-check-circle text-xs mr-1'></i>
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <i class='bx bx-time text-xs mr-1'></i>
                                            Dalam Pembangunan
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Details -->
                    <div class="mb-4">
                        <h4 class="font-semibold text-gray-900 mb-2">{{ $form['title'] }}</h4>
                        <p class="text-sm text-gray-600 mb-3">{{ $form['description'] }}</p>
                    </div>

                    <!-- Action Button -->
                    @if($form['available'])
                        <a href="{{ route($form['route']) }}" 
                           class="group/btn w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-{{ $form['color'] }}-600 hover:bg-{{ $form['color'] }}-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-{{ $form['color'] }}-500 transition-colors">
                            <i class='bx bx-right-arrow-alt text-lg mr-2 group-hover/btn:translate-x-1 transition-transform'></i>
                            Akses Laporan
                        </a>
                    @else
                        <button disabled 
                                class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-400 bg-gray-100 cursor-not-allowed">
                            <i class='bx bx-lock text-lg mr-2'></i>
                            Akan Datang
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <!-- Additional Information -->
    <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-2xl p-8 border border-gray-200">
        <div class="flex items-start space-x-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <i class='bx bx-info-circle text-blue-600 text-xl'></i>
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
});
</script>
@endpush
@endsection
