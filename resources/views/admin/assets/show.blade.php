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
                        <div class="w-3 h-3 {{ $asset->status_aset === 'Sedang Digunakan' ? 'bg-green-400' : ($asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-400' : ($asset->status_aset === 'Baru' ? 'bg-blue-400' : 'bg-red-400')) }} rounded-full"></div>
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
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-700">Nilai Aset</p>
                    <p class="text-2xl font-bold text-emerald-900">RM {{ number_format($asset->nilai_perolehan, 2) }}</p>
                    <p class="text-xs text-emerald-600 mt-1">Nilai Perolehan</p>
                </div>
                <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-dollar text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Asset Age -->
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-700">Umur Aset</p>
                    <p class="text-2xl font-bold text-emerald-900">
                        {{ $asset->tarikh_perolehan ? (int)$asset->tarikh_perolehan->diffInYears(now()) : 0 }}
                    </p>
                    <p class="text-xs text-emerald-600 mt-1">Tahun</p>
                </div>
                <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-time text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Depreciation -->
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-700">Susut Nilai</p>
                    <p class="text-2xl font-bold text-emerald-900">RM {{ number_format($asset->susut_nilai_tahunan ?? 0, 2) }}</p>
                    <p class="text-xs text-emerald-600 mt-1">Tahunan</p>
                </div>
                <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-trending-down text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Current Value -->
        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-emerald-700">Nilai Semasa</p>
                    @php
                        $currentValue = $asset->nilai_perolehan;
                        if ($asset->tarikh_perolehan && $asset->susut_nilai_tahunan) {
                            $yearsDepreciated = (int)$asset->tarikh_perolehan->diffInYears(now());
                            $totalDepreciation = $asset->susut_nilai_tahunan * $yearsDepreciated;
                            $currentValue = max(0, $asset->nilai_perolehan - $totalDepreciation);
                        }
                    @endphp
                    <p class="text-2xl font-bold text-emerald-900">RM {{ number_format($currentValue, 2) }}</p>
                    <p class="text-xs text-emerald-600 mt-1">Anggaran</p>
                </div>
                <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center">
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

                    <!-- Type of Asset -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-cube text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Kategori Aset</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if($asset->kategori_aset === 'asset') bg-emerald-100 text-emerald-800
                                @else bg-orange-100 text-orange-800 @endif">
                                {{ $asset->kategori_aset === 'asset' ? 'Asset' : 'Non-Asset' }}
                            </span>
                        </dd>
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
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $asset->status_aset === 'Sedang Digunakan' ? 'bg-green-100 text-green-800' : ($asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-100 text-yellow-800' : ($asset->status_aset === 'Baru' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                <div class="w-2 h-2 {{ $asset->status_aset === 'Sedang Digunakan' ? 'bg-green-500' : ($asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-500' : ($asset->status_aset === 'Baru' ? 'bg-blue-500' : 'bg-red-500')) }} rounded-full mr-2"></div>
                                {{ $asset->status_aset }}
                            </span>
                        </dd>
                    </div>

                    <!-- Physical Condition -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-health text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Keadaan Fizikal</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if($asset->keadaan_fizikal === 'Cemerlang') bg-green-100 text-green-800
                                @elseif($asset->keadaan_fizikal === 'Baik') bg-blue-100 text-blue-800
                                @elseif($asset->keadaan_fizikal === 'Sederhana') bg-yellow-100 text-yellow-800
                                @elseif($asset->keadaan_fizikal === 'Rosak') bg-orange-100 text-orange-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ $asset->keadaan_fizikal ?? 'Baik' }}
                            </span>
                        </dd>
                    </div>

                    <!-- Warranty Status -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-shield-check text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Status Jaminan</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if($asset->status_jaminan === 'Aktif') bg-green-100 text-green-800
                                @elseif($asset->status_jaminan === 'Tamat') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $asset->status_jaminan ?? 'Tiada Jaminan' }}
                            </span>
                        </dd>
                    </div>
                </div>
            </div>

            <!-- Acquisition Information Section -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-receipt text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Perolehan</h3>
                        <p class="text-sm text-emerald-700">Butiran cara dan masa perolehan aset</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Acquisition Date -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar text-emerald-600 mr-2'></i>
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
                            <i class='bx bx-transfer text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Kaedah Perolehan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->kaedah_perolehan }}</dd>
                    </div>

                    <!-- Acquisition Value -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-dollar text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nilai Perolehan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">RM {{ number_format($asset->nilai_perolehan, 2) }}</dd>
                    </div>

                    <!-- Discount -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-purchase-tag text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Diskaun</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">RM {{ number_format($asset->diskaun ?? 0, 2) }}</dd>
                    </div>

                    <!-- Receipt Number -->
                    @if($asset->no_resit)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-receipt text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">No. Resit</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->no_resit }}</dd>
                    </div>
                    @endif

                    <!-- Receipt Date -->
                    @if($asset->tarikh_resit)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Tarikh Resit</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->tarikh_resit->format('d/m/Y') }}</dd>
                        <p class="text-xs text-gray-500 mt-1">{{ $asset->tarikh_resit->diffForHumans() }}</p>
                    </div>
                    @endif

                    <!-- Masjid/Surau -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-building text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Masjid/Surau</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->masjidSurau->nama ?? '-' }}</dd>
                    </div>
                </div>
            </div>

            <!-- Location & Management Section -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-map text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Lokasi & Pengurusan</h3>
                        <p class="text-sm text-emerald-700">Penempatan dan tanggungjawab aset</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Location -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-map-pin text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Lokasi Penempatan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->lokasi_penempatan }}</dd>
                    </div>

                    <!-- Responsible Officer -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-user text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Pegawai Bertanggungjawab</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->pegawai_bertanggungjawab_lokasi ?: '-' }}</dd>
                    </div>

                    <!-- Officer Position -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-briefcase text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Jawatan Pegawai</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->jawatan_pegawai ?: '-' }}</dd>
                    </div>

                    <!-- Useful Life -->
                    @if($asset->umur_faedah_tahunan)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-time text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Tahun Dibeli</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->umur_faedah_tahunan }} tahun</dd>
                    </div>
                    @endif

                    <!-- Last Inspection Date -->
                    @if($asset->tarikh_pemeriksaan_terakhir)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar-check text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Pemeriksaan Terakhir</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->tarikh_pemeriksaan_terakhir->format('d/m/Y') }}</dd>
                        <p class="text-xs text-gray-500 mt-1">{{ $asset->tarikh_pemeriksaan_terakhir->diffForHumans() }}</p>
                    </div>
                    @endif

                    <!-- Next Maintenance Date -->
                    @if($asset->tarikh_penyelenggaraan_akan_datang)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar-plus text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Penyelenggaraan Akan Datang</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->tarikh_penyelenggaraan_akan_datang->format('d/m/Y') }}</dd>
                        <p class="text-xs text-gray-500 mt-1">{{ $asset->tarikh_penyelenggaraan_akan_datang->diffForHumans() }}</p>
                    </div>
                    @endif

                    <!-- Asset Record Updated -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-edit text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Kemaskini Terakhir</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $asset->updated_at->format('d/m/Y') }}</dd>
                        <p class="text-xs text-gray-500 mt-1">{{ $asset->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <!-- Notes Section -->
            @if($asset->catatan || $asset->catatan_jaminan)
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-note text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Catatan</h3>
                        <p class="text-sm text-emerald-700">Nota dan maklumat tambahan</p>
                    </div>
                </div>
                
                <div class="space-y-4">
                    @if($asset->catatan)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <h4 class="font-medium text-gray-900 mb-2">Catatan Umum</h4>
                        <p class="text-gray-900 leading-relaxed">{{ $asset->catatan }}</p>
                    </div>
                    @endif

                    @if($asset->catatan_jaminan)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <h4 class="font-medium text-gray-900 mb-2">Catatan Jaminan</h4>
                        <p class="text-gray-900 leading-relaxed">{{ $asset->catatan_jaminan }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Quick Info & Actions -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-6">
                
                <!-- Asset Card -->
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
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
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $asset->status_aset === 'Sedang Digunakan' ? 'bg-green-100 text-green-800' : ($asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-100 text-yellow-800' : ($asset->status_aset === 'Baru' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                {{ $asset->status_aset }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-bolt-circle text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Tindakan Pantas</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.assets.edit', $asset) }}" 
                           class="group w-full flex items-center justify-center px-4 py-3 bg-white hover:bg-emerald-50 text-emerald-700 hover:text-emerald-800 rounded-lg border border-emerald-200 hover:border-emerald-300 shadow-sm hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
                            <i class='bx bx-edit mr-2 text-lg group-hover:scale-110 transition-transform duration-200'></i>
                            <span class="font-medium">Edit Maklumat</span>
                        </a>
                        
                        <button onclick="window.print()" 
                                class="group w-full flex items-center justify-center px-4 py-3 bg-white hover:bg-emerald-50 text-emerald-700 hover:text-emerald-800 rounded-lg border border-emerald-200 hover:border-emerald-300 shadow-sm hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
                            <i class='bx bx-printer mr-2 text-lg group-hover:scale-110 transition-transform duration-200'></i>
                            <span class="font-medium">Cetak Maklumat</span>
                        </button>
                        
                        <a href="{{ route('admin.assets.index') }}" 
                           class="group w-full flex items-center justify-center px-4 py-3 bg-white hover:bg-emerald-50 text-emerald-700 hover:text-emerald-800 rounded-lg border border-emerald-200 hover:border-emerald-300 shadow-sm hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5">
                            <i class='bx bx-list-ul mr-2 text-lg group-hover:scale-110 transition-transform duration-200'></i>
                            <span class="font-medium">Senarai Aset</span>
                        </a>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-bar-chart text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Statistik Ringkas</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Umur Aset:</span>
                            <span class="font-semibold text-emerald-700">{{ $asset->tarikh_perolehan ? (int)$asset->tarikh_perolehan->diffInYears(now()) : 0 }} tahun</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Nilai Perolehan:</span>
                            <span class="font-semibold text-emerald-700">RM {{ number_format($asset->nilai_perolehan, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Nilai Semasa:</span>
                            <span class="font-semibold text-emerald-700">RM {{ number_format($currentValue, 2) }}</span>
                        </div>
                        @if($asset->susut_nilai_tahunan)
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Susut Nilai:</span>
                            <span class="font-semibold text-emerald-700">RM {{ number_format($asset->susut_nilai_tahunan, 2) }}/tahun</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Asset Images -->
                @if($asset->gambar_aset && count($asset->gambar_aset) > 0)
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
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
                                            <p class="text-center text-sm text-emerald-600 mt-3">
                        +{{ count($asset->gambar_aset) - 4 }} gambar lagi
                    </p>
                    @endif
                </div>
                @endif

                <!-- System Info -->
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-3">
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
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-6xl max-h-full bg-white rounded-xl shadow-2xl overflow-hidden">
        <button id="closeModal" class="absolute top-4 right-4 z-10 w-10 h-10 bg-black bg-opacity-50 text-white rounded-full flex items-center justify-center hover:bg-opacity-75 transition-all duration-200">
            <i class='bx bx-x text-2xl'></i>
        </button>
        <div class="p-4">
            <img id="modalImage" src="" alt="Full size image" class="max-w-full max-h-[80vh] object-contain mx-auto">
        </div>
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-50 text-white px-4 py-2 rounded-lg">
            <p id="modalImageName" class="text-sm font-medium">Gambar Aset</p>
        </div>
    </div>
</div>

<script>
function openImageModal(imageSrc) {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const modalImageName = document.getElementById('modalImageName');
    
    modalImage.src = imageSrc;
    modalImageName.textContent = 'Gambar Aset';
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto'; // Restore scrolling
}

// Close modal functionality
document.getElementById('closeModal').addEventListener('click', function() {
    closeImageModal();
});

// Close modal when clicking outside
document.getElementById('imageModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeImageModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('imageModal');
        if (!modal.classList.contains('hidden')) {
            closeImageModal();
        }
    }
});
</script>
@endsection 