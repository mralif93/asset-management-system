@extends('layouts.admin')

@section('title', 'Maklumat Pemeriksaan')
@section('page-title', 'Maklumat Pemeriksaan')
@section('page-description', 'Paparan terperinci maklumat pemeriksaan aset')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Butiran Pemeriksaan</h1>
                <p class="text-emerald-100 text-lg">Paparan lengkap pemeriksaan {{ $inspection->asset->nama_aset }} - {{ $inspection->tarikh_pemeriksaan->format('d/m/Y') }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-search-alt-2 text-emerald-200'></i>
                        <span class="text-emerald-100">Pemeriksaan Aset</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 {{ 
                            $inspection->kondisi_aset === 'Sangat Baik' || $inspection->kondisi_aset === 'Baik' ? 'bg-green-400' : 
                            ($inspection->kondisi_aset === 'Sederhana' ? 'bg-yellow-400' : 'bg-red-400') 
                        }} rounded-full"></div>
                        <span class="text-emerald-100">{{ $inspection->kondisi_aset }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-calendar text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $inspection->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-emerald-500 rounded-2xl flex items-center justify-center text-3xl text-white shadow-xl">
                    <i class='bx bx-search-alt-2'></i>
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
        <a href="{{ route('admin.inspections.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Pemeriksaan
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">{{ $inspection->asset->nama_aset }}</span>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end mb-8">
        <div class="flex space-x-3">
            <a href="{{ route('admin.inspections.edit', $inspection) }}" 
               class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                <i class='bx bx-edit mr-2'></i>
                Edit Pemeriksaan
            </a>
            <a href="{{ route('admin.assets.show', $inspection->asset) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                <i class='bx bx-package mr-2'></i>
                Lihat Aset
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Asset Value -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700">Nilai Aset</p>
                    <p class="text-2xl font-bold text-blue-900">RM {{ number_format($inspection->asset->nilai_perolehan, 0) }}</p>
                    <p class="text-xs text-blue-600 mt-1">Perolehan</p>
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
                    <p class="text-2xl font-bold text-amber-900">{{ $inspection->asset->tarikh_perolehan ? $inspection->asset->tarikh_perolehan->diffInYears(now()) : 0 }}</p>
                    <p class="text-xs text-amber-600 mt-1">Tahun</p>
                </div>
                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-time text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Condition Status -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-700">Status Kondisi</p>
                    <p class="text-2xl font-bold text-green-900">{{ $inspection->kondisi_aset }}</p>
                    <p class="text-xs text-green-600 mt-1">Semasa</p>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-check-shield text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Next Inspection -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700">Pemeriksaan Seterusnya</p>
                    @if($inspection->tarikh_pemeriksaan_akan_datang)
                        @php
                            $daysUntilNext = now()->diffInDays($inspection->tarikh_pemeriksaan_akan_datang, false);
                        @endphp
                        <p class="text-2xl font-bold text-purple-900">{{ abs($daysUntilNext) }}</p>
                        <p class="text-xs text-purple-600 mt-1">
                            @if($daysUntilNext > 0)
                                Hari lagi
                            @elseif($daysUntilNext < 0)
                                Hari tertunggak
                            @else
                                Hari ini
                            @endif
                        </p>
                    @else
                        <p class="text-2xl font-bold text-purple-900">-</p>
                        <p class="text-xs text-purple-600 mt-1">Belum dijadualkan</p>
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
            
            <!-- Inspection Details Section -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-search-alt text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Butiran Pemeriksaan</h3>
                        <p class="text-sm text-emerald-700">Maklumat dan hasil pemeriksaan</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Asset Name -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-package text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nama Aset</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $inspection->asset->nama_aset }}</dd>
                        <p class="text-xs text-gray-500 mt-1">{{ $inspection->asset->no_siri_pendaftaran }}</p>
                    </div>

                    <!-- Inspection Date -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Tarikh Pemeriksaan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $inspection->tarikh_pemeriksaan->format('d/m/Y') }}</dd>
                        <p class="text-xs text-gray-500 mt-1">{{ $inspection->tarikh_pemeriksaan->diffForHumans() }}</p>
                    </div>

                    <!-- Asset Condition -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-check-circle text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Kondisi Aset</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ 
                                $inspection->kondisi_aset === 'Sangat Baik' || $inspection->kondisi_aset === 'Baik' ? 'bg-green-100 text-green-800' : 
                                ($inspection->kondisi_aset === 'Sederhana' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') 
                            }}">
                                <div class="w-2 h-2 {{ 
                                    $inspection->kondisi_aset === 'Sangat Baik' || $inspection->kondisi_aset === 'Baik' ? 'bg-green-500' : 
                                    ($inspection->kondisi_aset === 'Sederhana' ? 'bg-yellow-500' : 'bg-red-500') 
                                }} rounded-full mr-2"></div>
                                {{ $inspection->kondisi_aset }}
                            </span>
                        </dd>
                    </div>

                    <!-- Inspector -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-user text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Pemeriksa</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $inspection->nama_pemeriksa ?: 'Tidak diketahui' }}</dd>
                    </div>

                    <!-- Next Inspection -->
                    @if($inspection->tarikh_pemeriksaan_akan_datang)
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar-plus text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Pemeriksaan Akan Datang</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $inspection->tarikh_pemeriksaan_akan_datang->format('d/m/Y') }}</dd>
                        @php
                            $daysUntilNext = now()->diffInDays($inspection->tarikh_pemeriksaan_akan_datang, false);
                        @endphp
                        @if($daysUntilNext > 0)
                            <p class="text-xs text-blue-600 mt-1">{{ $daysUntilNext }} hari lagi</p>
                        @elseif($daysUntilNext < 0)
                            <p class="text-xs text-red-600 mt-1">{{ abs($daysUntilNext) }} hari tertunggak</p>
                        @else
                            <p class="text-xs text-orange-600 mt-1">Hari ini</p>
                        @endif
                    </div>
                    @endif

                    <!-- Record Created -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-time text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Tarikh Dicatat</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $inspection->created_at->format('d/m/Y H:i') }}</dd>
                        <p class="text-xs text-gray-500 mt-1">{{ $inspection->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- Inspection Notes -->
                @if($inspection->catatan_pemeriksaan)
                <div class="mt-6 bg-white rounded-lg p-4 border border-gray-200">
                    <div class="flex items-center mb-3">
                        <i class='bx bx-note text-emerald-600 mr-2'></i>
                        <dt class="text-sm font-medium text-gray-600">Catatan Pemeriksaan</dt>
                    </div>
                    <dd class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $inspection->catatan_pemeriksaan }}</dd>
                </div>
                @endif

                <!-- Required Actions -->
                @if($inspection->tindakan_diperlukan)
                <div class="mt-6 bg-white rounded-lg p-4 border border-gray-200">
                    <div class="flex items-center mb-3">
                        <i class='bx bx-wrench text-emerald-600 mr-2'></i>
                        <dt class="text-sm font-medium text-gray-600">Tindakan Diperlukan</dt>
                    </div>
                    <dd class="text-gray-900 bg-orange-50 p-3 rounded-lg border-l-4 border-orange-400">{{ $inspection->tindakan_diperlukan }}</dd>
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
                        <p class="text-sm text-purple-700">Butiran dan spesifikasi aset</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Asset Type -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-category text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Jenis Aset</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $inspection->asset->jenis_aset }}</dd>
                    </div>

                    <!-- Location -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-map text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Lokasi</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $inspection->asset->lokasi_penempatan }}</dd>
                    </div>

                    <!-- Asset Status -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-check-shield text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Status Aset</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ 
                                $inspection->asset->status_aset === 'Aktif' ? 'bg-green-100 text-green-800' : 
                                ($inspection->asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') 
                            }}">
                                <div class="w-2 h-2 {{ 
                                    $inspection->asset->status_aset === 'Aktif' ? 'bg-green-500' : 
                                    ($inspection->asset->status_aset === 'Dalam Penyelenggaraan' ? 'bg-yellow-500' : 'bg-red-500') 
                                }} rounded-full mr-2"></div>
                                {{ $inspection->asset->status_aset }}
                            </span>
                        </dd>
                    </div>

                    <!-- Asset Value -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-money text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nilai Aset</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">RM {{ number_format($inspection->asset->nilai_perolehan, 2) }}</dd>
                    </div>
                </div>
            </div>

            <!-- Inspection Images Section -->
            @if($inspection->gambar_pemeriksaan && count($inspection->gambar_pemeriksaan) > 0)
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-images text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Gambar Pemeriksaan</h3>
                        <p class="text-sm text-blue-700">Dokumentasi visual pemeriksaan</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($inspection->gambar_pemeriksaan as $image)
                    <div class="group cursor-pointer relative" onclick="openImageModal('{{ Storage::url($image) }}')">
                        <img src="{{ Storage::url($image) }}" 
                             alt="Gambar Pemeriksaan" 
                             class="w-full h-32 object-cover rounded-lg border border-gray-200 group-hover:shadow-lg transition-all">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-25 rounded-lg transition-all flex items-center justify-center">
                            <i class='bx bx-expand text-white opacity-0 group-hover:opacity-100 text-xl'></i>
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
                
                <!-- Inspection Card -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-100 rounded-xl p-6 border border-indigo-200">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class='bx bx-search-alt text-emerald-700 text-3xl'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $inspection->asset->nama_aset }}</h3>
                        <p class="text-sm text-gray-600">{{ $inspection->tarikh_pemeriksaan->format('d/m/Y') }}</p>
                        <div class="flex items-center justify-center space-x-2 mt-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ 
                                $inspection->kondisi_aset === 'Sangat Baik' || $inspection->kondisi_aset === 'Baik' ? 'bg-green-100 text-green-800' : 
                                ($inspection->kondisi_aset === 'Sederhana' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') 
                            }}">
                                {{ $inspection->kondisi_aset }}
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $inspection->asset->jenis_aset }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan Pantas</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.inspections.edit', $inspection) }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg transition-colors">
                            <i class='bx bx-edit mr-2'></i>
                            Edit Pemeriksaan
                        </a>
                        
                        <a href="{{ route('admin.assets.show', $inspection->asset) }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                            <i class='bx bx-package mr-2'></i>
                            Lihat Aset
                        </a>

                        @if($inspection->kondisi_aset === 'Perlu Penyelenggaraan' || $inspection->kondisi_aset === 'Rosak')
                        <a href="{{ route('admin.maintenance-records.create', ['asset_id' => $inspection->asset_id]) }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-orange-100 hover:bg-orange-200 text-orange-700 rounded-lg transition-colors">
                            <i class='bx bx-wrench mr-2'></i>
                            Jadual Penyelenggaraan
                        </a>
                        @endif
                        
                        <a href="{{ route('admin.inspections.index') }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                            <i class='bx bx-list-ul mr-2'></i>
                            Senarai Pemeriksaan
                        </a>
                    </div>
                </div>

                <!-- Related Inspections -->
                @if($relatedInspections && $relatedInspections->count() > 0)
                <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-6 border border-green-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-history text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Pemeriksaan Lain</h3>
                    </div>
                    
                    <div class="space-y-3">
                        @foreach($relatedInspections as $related)
                        <div class="flex items-center justify-between p-3 bg-white rounded-lg border border-gray-200 hover:shadow-sm transition-shadow">
                            <div>
                                <p class="font-medium text-gray-900">{{ $related->tarikh_pemeriksaan->format('d/m/Y') }}</p>
                                <p class="text-sm text-gray-600">{{ $related->kondisi_aset }}</p>
                            </div>
                            <a href="{{ route('admin.inspections.show', $related) }}" 
                               class="text-green-600 hover:text-green-800 transition-colors">
                                <i class='bx bx-right-arrow-alt text-lg'></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Condition Analysis -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-100 rounded-xl p-6 border border-amber-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-analyze text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Analisis Kondisi</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        @if($inspection->kondisi_aset === 'Sangat Baik')
                            <div class="flex items-center text-green-700">
                                <i class='bx bx-check-circle mr-2'></i>
                                <span>Kondisi sangat baik - tiada tindakan diperlukan</span>
                            </div>
                        @elseif($inspection->kondisi_aset === 'Baik')
                            <div class="flex items-center text-blue-700">
                                <i class='bx bx-check-circle mr-2'></i>
                                <span>Kondisi baik - pemantauan berterusan</span>
                            </div>
                        @elseif($inspection->kondisi_aset === 'Sederhana')
                            <div class="flex items-center text-yellow-700">
                                <i class='bx bx-error-circle mr-2'></i>
                                <span>Kondisi sederhana - perlu perhatian</span>
                            </div>
                        @elseif($inspection->kondisi_aset === 'Perlu Penyelenggaraan')
                            <div class="flex items-center text-orange-700">
                                <i class='bx bx-error-circle mr-2'></i>
                                <span>Memerlukan penyelenggaraan segera</span>
                            </div>
                        @elseif($inspection->kondisi_aset === 'Rosak')
                            <div class="flex items-center text-red-700">
                                <i class='bx bx-x-circle mr-2'></i>
                                <span>Aset dalam keadaan rosak</span>
                            </div>
                        @endif
                        
                        <div class="mt-3 pt-3 border-t border-amber-200">
                            <p class="text-amber-700">Pemeriksaan: {{ $inspection->created_at->diffForHumans() }}</p>
                            @if($inspection->tarikh_pemeriksaan_akan_datang)
                                <p class="text-amber-700">Seterusnya: {{ $inspection->tarikh_pemeriksaan_akan_datang->format('d/m/Y') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
    <div class="relative max-w-4xl max-h-full">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
            <i class='bx bx-x text-3xl'></i>
        </button>
        <img id="modalImage" src="" alt="Gambar Pemeriksaan" class="max-w-full max-h-full object-contain rounded-lg">
    </div>
</div>

@push('scripts')
<script>
    function openImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Close modal when clicking outside the image
    document.getElementById('imageModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeImageModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeImageModal();
        }
    });
</script>
@endpush
@endsection 