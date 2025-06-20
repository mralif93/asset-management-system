@extends('layouts.admin')

@section('title', 'Maklumat Pergerakan Aset')
@section('page-title', 'Maklumat Pergerakan Aset')
@section('page-description', 'Paparan terperinci pergerakan aset')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Detail Pergerakan Aset</h1>
                <p class="text-emerald-100 text-lg">Paparan lengkap pergerakan {{ $assetMovement->asset->nama_aset }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-transfer text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $assetMovement->jenis_pergerakan }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 {{ $assetMovement->status_pergerakan === 'diluluskan' ? 'bg-green-400' : ($assetMovement->status_pergerakan === 'menunggu_kelulusan' ? 'bg-yellow-400' : 'bg-red-400') }} rounded-full"></div>
                        <span class="text-emerald-100">{{ ucfirst(str_replace('_', ' ', $assetMovement->status_pergerakan)) }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-calendar text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $assetMovement->tarikh_pergerakan ? $assetMovement->tarikh_pergerakan->format('d/m/Y') : 'Belum ditetapkan' }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-emerald-500 rounded-2xl flex items-center justify-center text-3xl font-bold text-white shadow-xl">
                    <i class='bx bx-transfer'></i>
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
        <a href="{{ route('admin.asset-movements.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Pergerakan Aset
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">{{ $assetMovement->asset->nama_aset }}</span>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end mb-8">
        <div class="flex space-x-3">
            @if($assetMovement->status_pergerakan === 'menunggu_kelulusan')
            <a href="{{ route('admin.asset-movements.edit', $assetMovement) }}" 
               class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                <i class='bx bx-edit mr-2'></i>
                Edit Pergerakan
            </a>
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
        <!-- Movement Type -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700">Jenis Pergerakan</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $assetMovement->jenis_pergerakan }}</p>
                    <p class="text-xs text-blue-600 mt-1">Kategori</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-transfer text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-700">Status Kelulusan</p>
                    <p class="text-2xl font-bold text-amber-900">{{ ucfirst(str_replace('_', ' ', $assetMovement->status_pergerakan)) }}</p>
                    <p class="text-xs text-amber-600 mt-1">Semasa</p>
                </div>
                <div class="w-12 h-12 bg-{{ $assetMovement->status_pergerakan === 'diluluskan' ? 'green' : ($assetMovement->status_pergerakan === 'menunggu_kelulusan' ? 'amber' : 'red') }}-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-{{ $assetMovement->status_pergerakan === 'diluluskan' ? 'check' : ($assetMovement->status_pergerakan === 'menunggu_kelulusan' ? 'time' : 'x') }} text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Movement Date -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-700">Tarikh Pergerakan</p>
                    <p class="text-2xl font-bold text-green-900">{{ $assetMovement->tarikh_pergerakan ? $assetMovement->tarikh_pergerakan->format('d/m') : '-' }}</p>
                    <p class="text-xs text-green-600 mt-1">{{ $assetMovement->tarikh_pergerakan ? $assetMovement->tarikh_pergerakan->format('Y') : 'Belum ditetapkan' }}</p>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-calendar text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Asset Value -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700">Nilai Aset</p>
                    <p class="text-2xl font-bold text-purple-900">RM {{ number_format($assetMovement->asset->nilai_perolehan ?? 0, 0) }}</p>
                    <p class="text-xs text-purple-600 mt-1">{{ $assetMovement->asset->jenis_aset }}</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-dollar text-white text-xl'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column - Main Information -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Movement Information Section -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-info-circle text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Pergerakan</h3>
                        <p class="text-sm text-emerald-700">Butiran utama pergerakan aset</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Movement Type -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-transfer text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Jenis Pergerakan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $assetMovement->jenis_pergerakan }}</dd>
                    </div>

                    <!-- Status -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-check-circle text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Status</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $assetMovement->status_pergerakan === 'diluluskan' ? 'bg-green-100 text-green-800' : ($assetMovement->status_pergerakan === 'menunggu_kelulusan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                <div class="w-2 h-2 {{ $assetMovement->status_pergerakan === 'diluluskan' ? 'bg-green-500' : ($assetMovement->status_pergerakan === 'menunggu_kelulusan' ? 'bg-yellow-500' : 'bg-red-500') }} rounded-full mr-2"></div>
                                {{ ucfirst(str_replace('_', ' ', $assetMovement->status_pergerakan)) }}
                            </span>
                        </dd>
                    </div>

                    <!-- Application Date -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar-plus text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Tarikh Permohonan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $assetMovement->tarikh_permohonan ? $assetMovement->tarikh_permohonan->format('d/m/Y') : '-' }}</dd>
                    </div>

                    <!-- Movement Date -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Tarikh Pergerakan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $assetMovement->tarikh_pergerakan ? $assetMovement->tarikh_pergerakan->format('d/m/Y') : '-' }}</dd>
                    </div>

                    @if($assetMovement->tarikh_jangka_pulangan)
                    <!-- Expected Return Date -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-time text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Tarikh Jangka Pulangan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $assetMovement->tarikh_jangka_pulangan->format('d/m/Y') }}</dd>
                    </div>
                    @endif

                    <!-- Responsible Person -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-user text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Pegawai Bertanggungjawab</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $assetMovement->nama_peminjam_pegawai_bertanggungjawab ?: '-' }}</dd>
                    </div>
                </div>
            </div>

            <!-- Location Information Section -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-map text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Lokasi</h3>
                        <p class="text-sm text-purple-700">Laluan pergerakan aset</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Source Location -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-map-pin text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Lokasi Asal</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $assetMovement->lokasi_asal }}</dd>
                    </div>

                    <!-- Destination -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-map text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Lokasi Destinasi</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $assetMovement->lokasi_destinasi }}</dd>
                    </div>
                </div>
            </div>

            <!-- Purpose and Notes Section -->
            @if($assetMovement->sebab_pergerakan || $assetMovement->catatan_pergerakan || $assetMovement->sebab_penolakan)
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-note text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Tujuan & Catatan</h3>
                        <p class="text-sm text-blue-700">Maklumat tambahan pergerakan</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 gap-6">
                    @if($assetMovement->sebab_pergerakan)
                    <!-- Purpose -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-target text-blue-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Sebab Pergerakan</dt>
                        </div>
                        <dd class="text-gray-900">{{ $assetMovement->sebab_pergerakan }}</dd>
                    </div>
                    @endif

                    @if($assetMovement->catatan_pergerakan)
                    <!-- Notes -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-note text-blue-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Catatan</dt>
                        </div>
                        <dd class="text-gray-900">{{ $assetMovement->catatan_pergerakan }}</dd>
                    </div>
                    @endif

                    @if($assetMovement->sebab_penolakan)
                    <!-- Rejection Reason -->
                    <div class="bg-white rounded-lg p-4 border border-red-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-x-circle text-red-600 mr-2'></i>
                            <dt class="text-sm font-medium text-red-600">Sebab Penolakan</dt>
                        </div>
                        <dd class="text-red-800">{{ $assetMovement->sebab_penolakan }}</dd>
                    </div>
                    @endif
                </div>
            </div>
            @endif

            <!-- Approval Activity Section -->
            @if($assetMovement->diluluskan_oleh || $assetMovement->tarikh_kelulusan)
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-time text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Aktiviti Kelulusan</h3>
                        <p class="text-sm text-blue-700">Rekod dan aktiviti kelulusan</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @if($assetMovement->diluluskan_oleh)
                    <!-- Approved By -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-user-check text-blue-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Diluluskan Oleh</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $assetMovement->approvedBy->name ?? 'N/A' }}</dd>
                        <p class="text-xs text-gray-500 mt-1">Pegawai yang memproses</p>
                    </div>
                    @endif

                    @if($assetMovement->tarikh_kelulusan)
                    <!-- Approval Date -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar-check text-blue-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Tarikh Kelulusan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $assetMovement->tarikh_kelulusan->format('d/m/Y') }}</dd>
                        <p class="text-xs text-gray-500 mt-1">{{ $assetMovement->tarikh_kelulusan->diffForHumans() }}</p>
                    </div>
                    @endif

                    <!-- Status -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-check-shield text-blue-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Status Kelulusan</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $assetMovement->status_pergerakan === 'diluluskan' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <div class="w-2 h-2 {{ $assetMovement->status_pergerakan === 'diluluskan' ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-2"></div>
                                {{ $assetMovement->status_pergerakan === 'diluluskan' ? 'Diluluskan' : 'Ditolak' }}
                            </span>
                        </dd>
                    </div>
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
                            <i class='bx bx-package text-emerald-700 text-2xl'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $assetMovement->asset->nama_aset }}</h3>
                        <p class="text-sm text-gray-600 font-mono">{{ $assetMovement->asset->no_siri_pendaftaran }}</p>
                        <div class="flex items-center justify-center space-x-2 mt-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                                {{ $assetMovement->asset->jenis_aset }}
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $assetMovement->asset->status_aset }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan Pantas</h3>
                    
                    <div class="space-y-3">
                        @if($assetMovement->status_pergerakan === 'menunggu_kelulusan')
                        <a href="{{ route('admin.asset-movements.edit', $assetMovement) }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg transition-colors">
                            <i class='bx bx-edit mr-2'></i>
                            Edit Pergerakan
                        </a>
                        
                        <form action="{{ route('admin.asset-movements.approve', $assetMovement) }}" method="POST" class="w-full">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full flex items-center justify-center px-4 py-3 bg-green-100 hover:bg-green-200 text-green-700 rounded-lg transition-colors"
                                    onclick="return confirm('Adakah anda pasti untuk meluluskan pergerakan ini?')">
                                <i class='bx bx-check mr-2'></i>
                                Luluskan
                            </button>
                        </form>
                        
                        <button onclick="showRejectModal()" 
                                class="w-full flex items-center justify-center px-4 py-3 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-colors">
                            <i class='bx bx-x mr-2'></i>
                            Tolak
                        </button>
                        @endif
                        
                        <a href="{{ route('admin.assets.show', $assetMovement->asset) }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                            <i class='bx bx-package mr-2'></i>
                            Lihat Aset
                        </a>
                        
                        <a href="{{ route('admin.asset-movements.index') }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                            <i class='bx bx-list-ul mr-2'></i>
                            Senarai Pergerakan
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
                            <span class="text-sm text-gray-600">Tarikh Dicipta:</span>
                            <span class="font-semibold text-green-700">{{ $assetMovement->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Kemaskini Terakhir:</span>
                            <span class="font-semibold text-green-700">{{ $assetMovement->updated_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Nilai Aset:</span>
                            <span class="font-semibold text-green-700">RM {{ number_format($assetMovement->asset->nilai_perolehan ?? 0, 0) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Umur Permohonan:</span>
                            <span class="font-semibold text-green-700">{{ $assetMovement->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                </div>

                <!-- System Info -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-100 rounded-xl p-6 border border-amber-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-info-circle text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Info Sistem</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center text-amber-700">
                            <i class='bx bx-check-circle mr-2'></i>
                            Rekod tersimpan selamat
                        </div>
                        <div class="flex items-center text-amber-700">
                            <i class='bx bx-shield-check mr-2'></i>
                            Data dilindungi SSL
                        </div>
                        <div class="flex items-center text-amber-700">
                            <i class='bx bx-time mr-2'></i>
                            Audit trail aktif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if($assetMovement->status_pergerakan === 'menunggu_kelulusan')
<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class='bx bx-x text-red-600 text-xl'></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-5">Tolak Pergerakan</h3>
            <form action="{{ route('admin.asset-movements.reject', $assetMovement) }}" method="POST" class="mt-2 px-7 py-3">
                @csrf
                @method('PATCH')
                <div class="text-left">
                    <label for="sebab_penolakan" class="block text-sm font-medium text-gray-700 mb-2">
                        Sebab Penolakan
                    </label>
                    <textarea name="sebab_penolakan" id="sebab_penolakan" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-emerald-500 focus:border-emerald-500" 
                              placeholder="Sila nyatakan sebab penolakan..." required></textarea>
                </div>
                <div class="items-center px-4 py-3 flex space-x-3">
                    <button type="button" onclick="hideRejectModal()" 
                            class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Tolak Pergerakan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
    document.getElementById('sebab_penolakan').value = '';
}

// Close modal when clicking outside
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideRejectModal();
    }
});
</script>
@endif
@endsection 