@extends('layouts.admin')

@section('title', 'Maklumat Laporan Kehilangan')
@section('page-title', 'Maklumat Laporan Kehilangan')
@section('page-description', 'Paparan terperinci laporan kehilangan aset')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Laporan Kehilangan</h1>
                <p class="text-emerald-100 text-lg">Paparan lengkap laporan kehilangan {{ $lossWriteoff->asset->nama_aset }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-error-circle text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $lossWriteoff->jenis_kehilangan }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 
                            @if($lossWriteoff->status_kelulusan === 'menunggu') bg-amber-400
                            @elseif($lossWriteoff->status_kelulusan === 'diluluskan') bg-green-400
                            @else bg-red-400 @endif rounded-full"></div>
                        <span class="text-emerald-100">{{ ucfirst($lossWriteoff->status_kelulusan) }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-calendar text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $lossWriteoff->tarikh_kehilangan->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-red-500 rounded-2xl flex items-center justify-center text-3xl font-bold text-white shadow-xl">
                    <i class='bx bx-error-circle'></i>
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
        <a href="{{ route('admin.loss-writeoffs.index') }}" class="text-gray-500 hover:text-emerald-600">
            Kehilangan & Hapus Kira
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">{{ $lossWriteoff->asset->nama_aset }}</span>
    </div>

    <!-- Back Button & Actions -->
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('admin.loss-writeoffs.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
            <i class='bx bx-arrow-back mr-2'></i>
            Kembali ke Senarai Laporan
        </a>
        
        <div class="flex space-x-3">
            <a href="{{ route('admin.loss-writeoffs.edit', $lossWriteoff) }}" 
               class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                <i class='bx bx-edit mr-2'></i>
                Edit Laporan
            </a>
            
            @if($lossWriteoff->status_kelulusan === 'menunggu' && auth()->user()->role === 'admin')
            <form action="{{ route('admin.loss-writeoffs.approve', $lossWriteoff) }}" method="POST" class="inline">
                @csrf
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors"
                        onclick="return confirm('Luluskan laporan kehilangan ini?')">
                    <i class='bx bx-check mr-2'></i>
                    Luluskan Laporan
                </button>
            </form>
            
            <button type="button" 
                    onclick="openRejectModal()"
                    class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                <i class='bx bx-x mr-2'></i>
                Tolak Laporan
            </button>
            @endif
            
            <button onclick="window.print()" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                <i class='bx bx-printer mr-2'></i>
                Cetak
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Asset Value -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700">Nilai Aset</p>
                    <p class="text-2xl font-bold text-blue-900">RM {{ number_format($lossWriteoff->asset->nilai_semasa ?? $lossWriteoff->asset->nilai_perolehan, 2) }}</p>
                    <p class="text-xs text-blue-600 mt-1">Nilai semasa</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-package text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Loss Value -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 border border-red-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-red-700">Nilai Kerugian</p>
                    <p class="text-2xl font-bold text-red-900">RM {{ number_format($lossWriteoff->nilai_kehilangan, 2) }}</p>
                    <p class="text-xs text-red-600 mt-1">Kerugian dilaporkan</p>
                </div>
                <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-trending-down text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Asset Age -->
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-700">Umur Aset</p>
                    <p class="text-2xl font-bold text-amber-900">{{ $lossWriteoff->asset->created_at->diffInYears(now()) }}</p>
                    <p class="text-xs text-amber-600 mt-1">Tahun</p>
                </div>
                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-time text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Days Since Loss -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700">Hari Berlalu</p>
                    <p class="text-2xl font-bold text-purple-900">{{ $lossWriteoff->tarikh_kehilangan->diffInDays(now()) }}</p>
                    <p class="text-xs text-purple-600 mt-1">Sejak kehilangan</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-calendar-minus text-white text-xl'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column - Main Information -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Loss Information Section -->
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 border border-red-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-error-circle text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Kehilangan</h3>
                        <p class="text-sm text-red-700">Butiran terperinci mengenai kehilangan</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Loss Type -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-error text-red-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Jenis Kehilangan</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if($lossWriteoff->jenis_kehilangan === 'Kehilangan') bg-yellow-100 text-yellow-800
                                @elseif($lossWriteoff->jenis_kehilangan === 'Kecurian') bg-red-100 text-red-800
                                @elseif($lossWriteoff->jenis_kehilangan === 'Kerosakan') bg-orange-100 text-orange-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $lossWriteoff->jenis_kehilangan }}
                            </span>
                        </dd>
                    </div>

                    <!-- Loss Date -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar text-red-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Tarikh Kehilangan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $lossWriteoff->tarikh_kehilangan->format('d/m/Y') }}</dd>
                        <p class="text-xs text-gray-500 mt-1">{{ $lossWriteoff->tarikh_kehilangan->diffForHumans() }}</p>
                    </div>

                    <!-- Loss Reason -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-message-detail text-red-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Sebab Kehilangan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $lossWriteoff->sebab_kehilangan }}</dd>
                    </div>

                    <!-- Loss Value -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-money text-red-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nilai Kerugian</dt>
                        </div>
                        <dd class="text-lg font-semibold text-red-600">RM {{ number_format($lossWriteoff->nilai_kehilangan, 2) }}</dd>
                    </div>

                    <!-- Loss Location -->
                    @if($lossWriteoff->lokasi_kehilangan)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-map text-red-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Lokasi Kehilangan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $lossWriteoff->lokasi_kehilangan }}</dd>
                    </div>
                    @endif

                    <!-- Police Report -->
                    @if($lossWriteoff->laporan_polis)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-shield text-red-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">No. Laporan Polis</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $lossWriteoff->laporan_polis }}</dd>
                    </div>
                    @endif
                </div>

                <!-- Notes -->
                @if($lossWriteoff->catatan)
                <div class="mt-6 bg-white rounded-lg p-4 border border-gray-200">
                    <div class="flex items-center mb-2">
                        <i class='bx bx-note text-red-600 mr-2'></i>
                        <dt class="text-sm font-medium text-gray-600">Catatan Tambahan</dt>
                    </div>
                    <dd class="text-gray-900">{{ $lossWriteoff->catatan }}</dd>
                </div>
                @endif
            </div>

            <!-- Asset Information Section -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-cube text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Aset</h3>
                        <p class="text-sm text-emerald-700">Butiran aset yang hilang</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Asset Name -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-cube text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nama Aset</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $lossWriteoff->asset->nama_aset }}</dd>
                    </div>

                    <!-- Serial Number -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-barcode text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">No. Siri Pendaftaran</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $lossWriteoff->asset->no_siri_pendaftaran }}</dd>
                    </div>

                    <!-- Category -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-category text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Kategori</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $lossWriteoff->asset->kategori }}</dd>
                    </div>

                    <!-- Location -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-building text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Lokasi</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $lossWriteoff->asset->masjidSurau->nama ?? 'Tidak ditetapkan' }}</dd>
                    </div>

                    <!-- Current Value -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-money text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nilai Semasa</dt>
                        </div>
                        <dd class="text-lg font-semibold text-emerald-600">RM {{ number_format($lossWriteoff->asset->nilai_semasa ?? $lossWriteoff->asset->nilai_perolehan, 2) }}</dd>
                    </div>

                    <!-- Purchase Date -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar-plus text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Tarikh Perolehan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $lossWriteoff->asset->tarikh_perolehan->format('d/m/Y') }}</dd>
                    </div>
                </div>
            </div>

            <!-- Documents Section -->
            @if($lossWriteoff->dokumen_kehilangan)
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-file text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Dokumen Sokongan</h3>
                        <p class="text-sm text-blue-700">Dokumen berkaitan laporan kehilangan</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach(json_decode($lossWriteoff->dokumen_kehilangan, true) as $index => $document)
                        <div class="bg-white rounded-lg p-4 border border-gray-200 hover:border-blue-300 transition-colors">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i class='bx bx-file text-blue-500 text-2xl mr-3'></i>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">Dokumen {{ $index + 1 }}</p>
                                        <p class="text-xs text-gray-500">{{ basename($document) }}</p>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($document) }}" target="_blank" 
                                   class="text-blue-600 hover:text-blue-800 p-2 rounded-lg hover:bg-blue-50 transition-colors">
                                    <i class='bx bx-download text-lg'></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Quick Info & Actions -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-6">
                
                <!-- Loss Report Card -->
                <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 border border-red-200">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class='bx bx-error-circle text-red-700 text-3xl'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $lossWriteoff->asset->nama_aset }}</h3>
                        <p class="text-sm text-gray-600">{{ $lossWriteoff->asset->no_siri_pendaftaran }}</p>
                        <div class="flex items-center justify-center space-x-2 mt-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                @if($lossWriteoff->jenis_kehilangan === 'Kehilangan') bg-yellow-100 text-yellow-800
                                @elseif($lossWriteoff->jenis_kehilangan === 'Kecurian') bg-red-100 text-red-800
                                @elseif($lossWriteoff->jenis_kehilangan === 'Kerosakan') bg-orange-100 text-orange-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $lossWriteoff->jenis_kehilangan }}
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                @if($lossWriteoff->status_kelulusan === 'menunggu') bg-amber-100 text-amber-800
                                @elseif($lossWriteoff->status_kelulusan === 'diluluskan') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($lossWriteoff->status_kelulusan) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan Pantas</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.loss-writeoffs.edit', $lossWriteoff) }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg transition-colors">
                            <i class='bx bx-edit mr-2'></i>
                            Edit Laporan
                        </a>
                        
                        @if($lossWriteoff->status_kelulusan === 'menunggu' && auth()->user()->role === 'admin')
                        <form action="{{ route('admin.loss-writeoffs.approve', $lossWriteoff) }}" method="POST" class="w-full">
                            @csrf
                            <button type="submit" 
                                    class="w-full flex items-center justify-center px-4 py-3 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors"
                                    onclick="return confirm('Luluskan laporan kehilangan ini?')">
                                <i class='bx bx-check mr-2'></i>
                                Luluskan Laporan
                            </button>
                        </form>
                        
                        <button type="button" 
                                onclick="openRejectModal()"
                                class="w-full flex items-center justify-center px-4 py-3 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors">
                            <i class='bx bx-x mr-2'></i>
                            Tolak Laporan
                        </button>
                        @endif
                        
                        <button onclick="window.print()" 
                                class="w-full flex items-center justify-center px-4 py-3 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                            <i class='bx bx-printer mr-2'></i>
                            Cetak Laporan
                        </button>
                        
                        <a href="{{ route('admin.loss-writeoffs.index') }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                            <i class='bx bx-list-ul mr-2'></i>
                            Senarai Laporan
                        </a>
                    </div>
                </div>

                <!-- Financial Summary -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-100 rounded-xl p-6 border border-amber-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-money text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Ringkasan Kewangan</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Nilai Aset:</span>
                            <span class="font-semibold text-blue-700">RM {{ number_format($lossWriteoff->asset->nilai_semasa ?? $lossWriteoff->asset->nilai_perolehan, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Nilai Kerugian:</span>
                            <span class="font-semibold text-red-700">RM {{ number_format($lossWriteoff->nilai_kehilangan, 2) }}</span>
                        </div>
                        <hr class="border-amber-200">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-700">Perbezaan:</span>
                            @php
                                $difference = ($lossWriteoff->asset->nilai_semasa ?? $lossWriteoff->asset->nilai_perolehan) - $lossWriteoff->nilai_kehilangan;
                            @endphp
                            <span class="font-bold {{ $difference >= 0 ? 'text-green-700' : 'text-red-700' }}">
                                RM {{ number_format(abs($difference), 2) }}
                                @if($difference >= 0) (Lebih rendah) @else (Lebih tinggi) @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- System Info -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-6 border border-green-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-info-circle text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Info Sistem</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center text-green-700">
                            <i class='bx bx-user mr-2'></i>
                            Dilaporkan oleh: {{ $lossWriteoff->user->name }}
                        </div>
                        <div class="flex items-center text-green-700">
                            <i class='bx bx-calendar mr-2'></i>
                            Dicipta: {{ $lossWriteoff->created_at->format('d/m/Y H:i') }}
                        </div>
                        <div class="flex items-center text-green-700">
                            <i class='bx bx-edit mr-2'></i>
                            Dikemaskini: {{ $lossWriteoff->updated_at->format('d/m/Y H:i') }}
                        </div>
                        @if($lossWriteoff->diluluskan_oleh)
                        <div class="flex items-center text-green-700">
                            <i class='bx bx-check-circle mr-2'></i>
                            Diluluskan oleh: {{ $lossWriteoff->approver->name ?? 'Sistem' }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
@if($lossWriteoff->status_kelulusan === 'menunggu' && auth()->user()->role === 'admin')
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Tolak Laporan Kehilangan</h3>
                <button onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                    <i class='bx bx-x text-xl'></i>
                </button>
            </div>
            
            <form action="{{ route('admin.loss-writeoffs.reject', $lossWriteoff) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="sebab_penolakan" class="block text-sm font-medium text-gray-700 mb-2">
                        Sebab Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="sebab_penolakan" 
                              id="sebab_penolakan" 
                              rows="4"
                              required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                              placeholder="Nyatakan sebab penolakan laporan ini..."></textarea>
                </div>
                
                <div class="flex space-x-3">
                    <button type="button" 
                            onclick="closeRejectModal()"
                            class="flex-1 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 rounded-lg transition-colors">
                        Batal
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                        Tolak Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@push('scripts')
<script>
    function openRejectModal() {
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('sebab_penolakan').value = '';
    }

    // Close modal when clicking outside
    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRejectModal();
        }
    });
</script>
@endpush
@endsection
