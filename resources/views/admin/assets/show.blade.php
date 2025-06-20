@extends('layouts.admin')

@section('title', 'Maklumat Aset')
@section('page-title', 'Maklumat Aset')
@section('page-description', 'Paparan terperinci maklumat aset')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Profil Aset</h1>
                <p class="text-emerald-100 text-lg">Paparan lengkap maklumat {{ $asset->nama_aset }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-package text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $asset->jenis_aset }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 {{ $asset->status_aset === 'Sedang Digunakan' ? 'bg-green-400' : ($asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-400' : 'bg-red-400') }} rounded-full"></div>
                        <span class="text-emerald-100">{{ $asset->status_aset }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-calendar text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $asset->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-emerald-500 rounded-2xl flex items-center justify-center text-3xl font-bold text-white shadow-xl">
                    <i class='bx bx-package text-4xl'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <div class="flex items-center space-x-2 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600">
            <i class='bx bx-home'></i>
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <a href="{{ route('admin.assets.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Aset
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">{{ $asset->nama_aset }}</span>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end mb-8">
        <div class="flex space-x-3">
            <a href="{{ route('admin.assets.edit', $asset) }}" 
               class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                <i class='bx bx-edit mr-2'></i>
                Edit Aset
            </a>
            <form action="{{ route('admin.assets.destroy', $asset) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        onclick="return confirm('Adakah anda pasti ingin memadamkan aset ini?')"
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                    <i class='bx bx-trash mr-2'></i>
                    Padamkan Aset
                </button>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Asset Value -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700">Nilai Aset</p>
                    <p class="text-2xl font-bold text-blue-900">RM {{ number_format($asset->nilai_perolehan, 2) }}</p>
                    <p class="text-xs text-blue-600 mt-1">Nilai Perolehan</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-dollar text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Asset Age -->
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-700">Umur Aset</p>
                    <p class="text-2xl font-bold text-amber-900">
                        {{ $asset->tarikh_perolehan ? $asset->tarikh_perolehan->diffInYears(now()) : 0 }}
                    </p>
                    <p class="text-xs text-amber-600 mt-1">Tahun</p>
                </div>
                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-time text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Depreciation -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-700">Susut Nilai</p>
                    <p class="text-2xl font-bold text-green-900">RM {{ number_format($asset->susut_nilai_tahunan ?? 0, 2) }}</p>
                    <p class="text-xs text-green-600 mt-1">Tahunan</p>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-trending-down text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Current Value -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700">Nilai Semasa</p>
                    @php
                        $currentValue = $asset->nilai_perolehan;
                        if ($asset->tarikh_perolehan && $asset->susut_nilai_tahunan) {
                            $yearsDepreciated = $asset->tarikh_perolehan->diffInYears(now());
                            $totalDepreciation = $asset->susut_nilai_tahunan * $yearsDepreciated;
                            $currentValue = max(0, $asset->nilai_perolehan - $totalDepreciation);
                        }
                    @endphp
                    <p class="text-2xl font-bold text-purple-900">RM {{ number_format($currentValue, 2) }}</p>
                    <p class="text-xs text-purple-600 mt-1">Anggaran</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-calculator text-white text-xl'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column - Main Information -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Basic Asset Information Section -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-package text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Asas</h3>
                        <p class="text-sm text-emerald-700">Data dan butiran aset</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Asset Name -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-package text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nama Aset</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->nama_aset }}</dd>
                    </div>

                    <!-- Asset Type -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-category text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Jenis Aset</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->jenis_aset }}</dd>
                    </div>

                    <!-- Serial Number -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-barcode text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">No. Siri Pendaftaran</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900 font-mono">{{ $asset->no_siri_pendaftaran }}</dd>
                    </div>

                    <!-- Status -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-check-circle text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Status</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $asset->status_aset === 'Sedang Digunakan' ? 'bg-green-100 text-green-800' : ($asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                <div class="w-2 h-2 {{ $asset->status_aset === 'Sedang Digunakan' ? 'bg-green-500' : ($asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-500' : 'bg-red-500') }} rounded-full mr-2"></div>
                                {{ $asset->status_aset }}
                            </span>
                        </dd>
                    </div>
                </div>
            </div>

            <!-- Acquisition Information Section -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-receipt text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Perolehan</h3>
                        <p class="text-sm text-purple-700">Butiran cara dan masa perolehan aset</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Acquisition Date -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Tarikh Perolehan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->tarikh_perolehan ? $asset->tarikh_perolehan->format('d/m/Y') : '-' }}</dd>
                        @if($asset->tarikh_perolehan)
                            <p class="text-xs text-gray-500 mt-1">{{ $asset->tarikh_perolehan->diffForHumans() }}</p>
                        @endif
                    </div>

                    <!-- Acquisition Method -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-transfer text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Kaedah Perolehan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->kaedah_perolehan }}</dd>
                    </div>

                    <!-- Acquisition Value -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-dollar text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nilai Perolehan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">RM {{ number_format($asset->nilai_perolehan, 2) }}</dd>
                    </div>

                    <!-- Masjid/Surau -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-building text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Masjid/Surau</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->masjidSurau->nama ?? '-' }}</dd>
                    </div>
                </div>
            </div>

            <!-- Location & Management Section -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-map text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Lokasi & Pengurusan</h3>
                        <p class="text-sm text-blue-700">Penempatan dan tanggungjawab aset</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Location -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-map-pin text-blue-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Lokasi Penempatan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->lokasi_penempatan }}</dd>
                    </div>

                    <!-- Responsible Officer -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-user text-blue-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Pegawai Bertanggungjawab</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->pegawai_bertanggungjawab_lokasi ?: '-' }}</dd>
                    </div>

                    <!-- Useful Life -->
                    @if($asset->umur_faedah_tahunan)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-time text-blue-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Umur Faedah</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->umur_faedah_tahunan }} tahun</dd>
                    </div>
                    @endif

                    <!-- Asset Record Updated -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-edit text-blue-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Kemaskini Terakhir</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->updated_at->format('d/m/Y') }}</dd>
                        <p class="text-xs text-gray-500 mt-1">{{ $asset->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            @if($asset->catatan)
            <div class="bg-gradient-to-br from-yellow-50 to-amber-100 rounded-xl p-6 border border-yellow-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-note text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Catatan</h3>
                        <p class="text-sm text-amber-700">Nota dan maklumat tambahan</p>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg p-4 border border-gray-200">
                    <p class="text-gray-900 leading-relaxed">{{ $asset->catatan }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Quick Info & Actions -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-6">
                
                <!-- Asset Card -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-100 rounded-xl p-6 border border-indigo-200">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class='bx bx-package text-emerald-700 text-3xl'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $asset->nama_aset }}</h3>
                        <p class="text-sm text-gray-600">{{ $asset->no_siri_pendaftaran }}</p>
                        <div class="flex items-center justify-center space-x-2 mt-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $asset->jenis_aset }}
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $asset->status_aset === 'Sedang Digunakan' ? 'bg-green-100 text-green-800' : ($asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $asset->status_aset }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan Pantas</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.assets.edit', $asset) }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg transition-colors">
                            <i class='bx bx-edit mr-2'></i>
                            Edit Maklumat
                        </a>
                        
                        <button onclick="window.print()" 
                                class="w-full flex items-center justify-center px-4 py-3 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                            <i class='bx bx-printer mr-2'></i>
                            Cetak Maklumat
                        </button>
                        
                        <a href="{{ route('admin.assets.index') }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                            <i class='bx bx-list-ul mr-2'></i>
                            Senarai Aset
                        </a>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-6 border border-green-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-bar-chart text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Statistik Ringkas</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Umur Aset:</span>
                            <span class="font-semibold text-green-700">{{ $asset->tarikh_perolehan ? $asset->tarikh_perolehan->diffInYears(now()) : 0 }} tahun</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Nilai Perolehan:</span>
                            <span class="font-semibold text-green-700">RM {{ number_format($asset->nilai_perolehan, 0) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Nilai Semasa:</span>
                            <span class="font-semibold text-green-700">RM {{ number_format($currentValue, 0) }}</span>
                        </div>
                        @if($asset->susut_nilai_tahunan)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Susut Nilai:</span>
                            <span class="font-semibold text-green-700">RM {{ number_format($asset->susut_nilai_tahunan, 0) }}/tahun</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Asset Images -->
                @if($asset->gambar_aset && count($asset->gambar_aset) > 0)
                <div class="bg-gradient-to-br from-amber-50 to-orange-100 rounded-xl p-6 border border-amber-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-image text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Gambar Aset</h3>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($asset->gambar_aset as $index => $image)
                        <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                            <img src="{{ Storage::url($image) }}" 
                                 alt="Gambar Aset {{ $index + 1 }}"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform cursor-pointer"
                                 onclick="openImageModal('{{ Storage::url($image) }}')">
                        </div>
                        @if($index >= 3) @break @endif
                        @endforeach
                    </div>
                    
                    @if(count($asset->gambar_aset) > 4)
                    <p class="text-center text-sm text-amber-600 mt-3">
                        +{{ count($asset->gambar_aset) - 4 }} gambar lagi
                    </p>
                    @endif
                </div>
                @endif

                <!-- System Info -->
                <div class="bg-gradient-to-br from-gray-50 to-slate-100 rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-gray-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-info-circle text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Info Sistem</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center text-gray-700">
                            <i class='bx bx-calendar-check mr-2'></i>
                            Dicipta: {{ $asset->created_at->format('d/m/Y') }}
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class='bx bx-edit mr-2'></i>
                            Dikemaskini: {{ $asset->updated_at->format('d/m/Y') }}
                        </div>
                        <div class="flex items-center text-gray-700">
                            <i class='bx bx-shield-check mr-2'></i>
                            Data dilindungi SSL
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="max-w-4xl max-h-screen p-4">
        <div class="bg-white rounded-lg overflow-hidden">
            <div class="flex items-center justify-between p-4 border-b">
                <h3 class="text-lg font-semibold">Gambar Aset</h3>
                <button onclick="closeImageModal()" class="text-gray-500 hover:text-gray-700">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
            <div class="p-4">
                <img id="modalImage" src="" alt="Gambar Aset" class="max-w-full max-h-96 mx-auto">
            </div>
        </div>
    </div>
</div>

<script>
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});
</script>
@endsection 