@extends('layouts.admin')

@section('title', 'Maklumat Penyelenggaraan')
@section('page-title', 'Maklumat Penyelenggaraan')
@section('page-description', 'Paparan terperinci rekod penyelenggaraan')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Rekod Penyelenggaraan</h1>
                <p class="text-emerald-100 text-lg">Paparan lengkap {{ $maintenanceRecord->asset->nama_aset ?? 'Aset' }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-wrench text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $maintenanceRecord->jenis_penyelenggaraan }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                        <span class="text-emerald-100">RM {{ number_format($maintenanceRecord->kos_penyelenggaraan, 2) }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-calendar text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $maintenanceRecord->tarikh_penyelenggaraan->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-emerald-500 rounded-2xl flex items-center justify-center text-3xl text-white shadow-xl">
                    <i class='bx bx-wrench'></i>
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
        <a href="{{ route('admin.maintenance-records.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Penyelenggaraan
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">{{ $maintenanceRecord->asset->nama_aset ?? 'Rekod' }}</span>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end mb-8">
        <div class="flex space-x-3">
            <a href="{{ route('admin.maintenance-records.edit', $maintenanceRecord) }}" 
               class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                <i class='bx bx-edit mr-2'></i>
                Edit Penyelenggaraan
            </a>
            <a href="{{ route('admin.assets.show', $maintenanceRecord->asset) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                <i class='bx bx-package mr-2'></i>
                Lihat Aset
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Maintenance Cost -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700">Kos Penyelenggaraan</p>
                    <p class="text-2xl font-bold text-blue-900">RM {{ number_format($maintenanceRecord->kos_penyelenggaraan, 2) }}</p>
                    <p class="text-xs text-blue-600 mt-1">Jumlah dibelanjakan</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-money text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Asset Age -->
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-700">Umur Aset</p>
                    @php
                        $assetAge = $maintenanceRecord->asset->tarikh_perolehan ? now()->diffInYears($maintenanceRecord->asset->tarikh_perolehan) : 0;
                    @endphp
                    <p class="text-2xl font-bold text-amber-900">{{ $assetAge }}</p>
                    <p class="text-xs text-amber-600 mt-1">Tahun</p>
                </div>
                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-time text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Days Since Maintenance -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-700">Hari Lepas</p>
                    @php
                        $daysSince = now()->diffInDays($maintenanceRecord->tarikh_penyelenggaraan);
                    @endphp
                    <p class="text-2xl font-bold text-green-900">{{ $daysSince }}</p>
                    <p class="text-xs text-green-600 mt-1">Hari sejak penyelenggaraan</p>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-calendar-check text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Next Maintenance -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
            <div class="flex items-center justify-between">
            <div>
                    <p class="text-sm font-medium text-purple-700">Penyelenggaraan Seterusnya</p>
                    @if($maintenanceRecord->tarikh_penyelenggaraan_akan_datang)
                        @php
                            $daysUntilNext = now()->diffInDays($maintenanceRecord->tarikh_penyelenggaraan_akan_datang, false);
                        @endphp
                        <p class="text-2xl font-bold text-purple-900">{{ abs($daysUntilNext) }}</p>
                        <p class="text-xs text-purple-600 mt-1">{{ $daysUntilNext > 0 ? 'Hari lagi' : ($daysUntilNext < 0 ? 'Hari tertunggak' : 'Hari ini') }}</p>
                    @else
                        <p class="text-2xl font-bold text-purple-900">-</p>
                        <p class="text-xs text-purple-600 mt-1">Tidak dijadualkan</p>
                    @endif
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-calendar-plus text-white text-xl'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column - Main Information -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Maintenance Details Section -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-wrench text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Butiran Penyelenggaraan</h3>
                        <p class="text-sm text-emerald-700">Maklumat kerja yang dilakukan</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Maintenance Type -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-cog text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Jenis Penyelenggaraan</dt>
                    </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if($maintenanceRecord->jenis_penyelenggaraan === 'Pencegahan') bg-green-100 text-green-800
                                @elseif($maintenanceRecord->jenis_penyelenggaraan === 'Pembaikan') bg-red-100 text-red-800
                                @elseif($maintenanceRecord->jenis_penyelenggaraan === 'Kalibrasi') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                <div class="w-2 h-2 
                                    @if($maintenanceRecord->jenis_penyelenggaraan === 'Pencegahan') bg-green-500
                                    @elseif($maintenanceRecord->jenis_penyelenggaraan === 'Pembaikan') bg-red-500
                                    @elseif($maintenanceRecord->jenis_penyelenggaraan === 'Kalibrasi') bg-blue-500
                                    @else bg-yellow-500 @endif rounded-full mr-2"></div>
                                {{ $maintenanceRecord->jenis_penyelenggaraan }}
                        </span>
                        </dd>
                    </div>
                    
                    <!-- Maintenance Date -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Tarikh Penyelenggaraan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $maintenanceRecord->tarikh_penyelenggaraan->format('d/m/Y') }}</dd>
                        <p class="text-xs text-gray-500 mt-1">{{ $maintenanceRecord->tarikh_penyelenggaraan->diffForHumans() }}</p>
                    </div>
                    
                    <!-- Cost -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-money text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Kos Penyelenggaraan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">RM {{ number_format($maintenanceRecord->kos_penyelenggaraan, 2) }}</dd>
                    </div>
                    
                    <!-- Service Provider -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-user-check text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Penyedia Perkhidmatan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $maintenanceRecord->penyedia_perkhidmatan ?: ($maintenanceRecord->nama_syarikat_kontraktor ?: 'Tidak dinyatakan') }}</dd>
                    </div>
                    
                    @if($maintenanceRecord->tarikh_penyelenggaraan_akan_datang)
                    <!-- Next Maintenance -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200 md:col-span-2">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar-plus text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Penyelenggaraan Akan Datang</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $maintenanceRecord->tarikh_penyelenggaraan_akan_datang->format('d/m/Y') }}</dd>
                        @php
                            $daysUntilNext = now()->diffInDays($maintenanceRecord->tarikh_penyelenggaraan_akan_datang, false);
                        @endphp
                        @if($daysUntilNext > 0)
                            <p class="text-sm text-blue-600 mt-1">{{ $daysUntilNext }} hari lagi</p>
                        @elseif($daysUntilNext < 0)
                            <p class="text-sm text-red-600 mt-1">{{ abs($daysUntilNext) }} hari tertunggak</p>
                        @else
                            <p class="text-sm text-orange-600 mt-1">Hari ini</p>
                        @endif
                    </div>
                    @endif
                    
                    <!-- Recorded By -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-user text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Direkod Oleh</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $maintenanceRecord->user->name ?? 'Tidak diketahui' }}</dd>
                        <p class="text-xs text-gray-500 mt-1">{{ $maintenanceRecord->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                
                @if($maintenanceRecord->catatan_penyelenggaraan)
                <div class="mt-6">
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-note text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Catatan Penyelenggaraan</dt>
                        </div>
                        <dd class="text-gray-900 leading-relaxed">{{ $maintenanceRecord->catatan_penyelenggaraan }}</dd>
                    </div>
                </div>
                @endif
            </div>

            <!-- Asset Information Section -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-package text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Aset</h3>
                        <p class="text-sm text-purple-700">Butiran aset yang diselenggara</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Asset Name -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-tag text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nama Aset</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $maintenanceRecord->asset->nama_aset }}</dd>
                        <p class="text-xs text-gray-500 mt-1">{{ $maintenanceRecord->asset->no_siri_pendaftaran }}</p>
                    </div>
                    
                    <!-- Asset Type -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-category text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Jenis Aset</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $maintenanceRecord->asset->jenis_aset }}</dd>
                    </div>
                    
                    <!-- Location -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-map text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Lokasi</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $maintenanceRecord->asset->lokasi_penempatan }}</dd>
                    </div>
                    
                    <!-- Asset Status -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-check-shield text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Status Aset</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                @if($maintenanceRecord->asset->status_aset === 'Aktif') bg-green-100 text-green-800
                                @elseif($maintenanceRecord->asset->status_aset === 'Dalam Penyelenggaraan') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                <div class="w-2 h-2 
                                    @if($maintenanceRecord->asset->status_aset === 'Aktif') bg-green-500
                                    @elseif($maintenanceRecord->asset->status_aset === 'Dalam Penyelenggaraan') bg-yellow-500
                                    @else bg-red-500 @endif rounded-full mr-2"></div>
                                {{ $maintenanceRecord->asset->status_aset }}
                            </span>
                        </dd>
                    </div>
                    
                    <!-- Asset Value -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-dollar text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nilai Aset</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">RM {{ number_format($maintenanceRecord->asset->nilai_perolehan, 2) }}</dd>
                    </div>
                    
                    <!-- Responsible Officer -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-user-pin text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Pegawai Bertanggungjawab</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $maintenanceRecord->asset->pegawai_bertanggungjawab_lokasi ?: 'Tidak dinyatakan' }}</dd>
                    </div>
                </div>
            </div>

            <!-- Images Section -->
            @if($maintenanceRecord->gambar_penyelenggaraan && count($maintenanceRecord->gambar_penyelenggaraan) > 0)
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-image text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Gambar Penyelenggaraan</h3>
                        <p class="text-sm text-amber-700">Dokumentasi visual kerja yang dilakukan</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($maintenanceRecord->gambar_penyelenggaraan as $image)
                    <div class="group cursor-pointer relative overflow-hidden rounded-lg border border-gray-200 hover:shadow-lg transition-all" onclick="openImageModal('{{ Storage::url($image) }}')">
                        <img src="{{ Storage::url($image) }}" 
                             alt="Gambar Penyelenggaraan" 
                             class="w-full h-32 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-25 transition-all flex items-center justify-center">
                            <i class='bx bx-expand text-white opacity-0 group-hover:opacity-100 text-2xl'></i>
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
                
                <!-- Maintenance Card -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-100 rounded-xl p-6 border border-indigo-200">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class='bx bx-wrench text-emerald-700 text-3xl'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $maintenanceRecord->jenis_penyelenggaraan }}</h3>
                        <p class="text-sm text-gray-600">{{ $maintenanceRecord->asset->nama_aset }}</p>
                        <div class="flex items-center justify-center space-x-2 mt-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                @if($maintenanceRecord->jenis_penyelenggaraan === 'Pencegahan') bg-green-100 text-green-800
                                @elseif($maintenanceRecord->jenis_penyelenggaraan === 'Pembaikan') bg-red-100 text-red-800
                                @elseif($maintenanceRecord->jenis_penyelenggaraan === 'Kalibrasi') bg-blue-100 text-blue-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $maintenanceRecord->jenis_penyelenggaraan }}
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                RM {{ number_format($maintenanceRecord->kos_penyelenggaraan, 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan Pantas</h3>
                    
                <div class="space-y-3">
                        <a href="{{ route('admin.maintenance-records.edit', $maintenanceRecord) }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg transition-colors">
                            <i class='bx bx-edit mr-2'></i>
                        Edit Penyelenggaraan
                    </a>
                    
                        <a href="{{ route('admin.assets.show', $maintenanceRecord->asset) }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                            <i class='bx bx-package mr-2'></i>
                        Lihat Aset
                    </a>
                    
                        @if($maintenanceRecord->tarikh_penyelenggaraan_akan_datang && now()->diffInDays($maintenanceRecord->tarikh_penyelenggaraan_akan_datang, false) <= 30)
                        <a href="{{ route('admin.maintenance-records.create', ['asset_id' => $maintenanceRecord->asset_id]) }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-orange-100 hover:bg-orange-200 text-orange-700 rounded-lg transition-colors">
                            <i class='bx bx-plus mr-2'></i>
                            Jadual Baru
                    </a>
                    @endif
                    
                        <form action="{{ route('admin.maintenance-records.destroy', $maintenanceRecord) }}" 
                          method="POST" 
                              onsubmit="return confirm('Adakah anda pasti untuk memadam rekod penyelenggaraan ini?')"
                              class="w-full">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                    class="w-full flex items-center justify-center px-4 py-3 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors">
                                <i class='bx bx-trash mr-2'></i>
                            Padam Rekod
                        </button>
                    </form>
                </div>
            </div>

            <!-- Cost Summary -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-6 border border-green-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-bar-chart text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Ringkasan Kos</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Kos Penyelenggaraan:</span>
                            <span class="font-semibold text-green-700">RM {{ number_format($maintenanceRecord->kos_penyelenggaraan, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Nilai Aset:</span>
                            <span class="font-semibold text-green-700">RM {{ number_format($maintenanceRecord->asset->nilai_perolehan, 2) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">% Daripada Nilai:</span>
                            <span class="font-semibold text-green-700">{{ number_format(($maintenanceRecord->kos_penyelenggaraan / $maintenanceRecord->asset->nilai_perolehan) * 100, 2) }}%</span>
                    </div>
                        <hr class="border-green-200">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Penyedia:</span>
                            <span class="font-semibold text-green-700 text-xs">{{ Str::limit($maintenanceRecord->penyedia_perkhidmatan ?: 'N/A', 15) }}</span>
                    </div>
                </div>
            </div>

                <!-- System Info -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-100 rounded-xl p-6 border border-amber-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-info-circle text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Info Rekod</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center text-amber-700">
                            <i class='bx bx-calendar-check mr-2'></i>
                            Dicipta: {{ $maintenanceRecord->created_at->format('d/m/Y') }}
                        </div>
                        <div class="flex items-center text-amber-700">
                            <i class='bx bx-edit mr-2'></i>
                            Dikemaskini: {{ $maintenanceRecord->updated_at->format('d/m/Y') }}
                        </div>
                        <div class="flex items-center text-amber-700">
                            <i class='bx bx-user mr-2'></i>
                            Oleh: {{ $maintenanceRecord->user->name ?? 'Sistem' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <img id="modalImage" src="" alt="Gambar Penyelenggaraan" class="max-w-full max-h-full object-contain rounded-lg">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl">
            <i class='bx bx-x'></i>
        </button>
    </div>
</div>

@push('scripts')
<script>
    // Image modal functions
function openImageModal(imageSrc) {
    document.getElementById('modalImage').src = imageSrc;
    document.getElementById('imageModal').classList.remove('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

    // Close modal on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });

    // Close modal on background click
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });
</script>
@endpush
@endsection 