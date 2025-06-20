@extends('layouts.admin')

@section('title', 'Maklumat Masjid/Surau')
@section('page-title', 'Maklumat Masjid/Surau')
@section('page-description', 'Paparan terperinci maklumat masjid/surau')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Profil {{ $masjidSurau->jenis }}</h1>
                <p class="text-emerald-100 text-lg">Paparan lengkap maklumat {{ $masjidSurau->nama }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-building text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $masjidSurau->jenis }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 {{ $masjidSurau->status == 'Aktif' ? 'bg-green-400' : 'bg-red-400' }} rounded-full"></div>
                        <span class="text-emerald-100">{{ $masjidSurau->status }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-calendar text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $masjidSurau->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-emerald-500 rounded-2xl flex items-center justify-center text-3xl font-bold text-white shadow-xl">
                    {{ substr($masjidSurau->nama, 0, 1) }}
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
        <a href="{{ route('admin.masjid-surau.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Masjid/Surau
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">{{ $masjidSurau->nama }}</span>
    </div>

    <!-- Actions -->
    <div class="flex items-center justify-end mb-8">
        <div class="flex space-x-3">
            <a href="{{ route('admin.masjid-surau.edit', $masjidSurau) }}" 
               class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                <i class='bx bx-edit mr-2'></i>
                Edit Masjid/Surau
            </a>
            <form action="{{ route('admin.masjid-surau.toggle-status', $masjidSurau) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 {{ $masjidSurau->status == 'Aktif' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition-colors">
                    <i class='bx {{ $masjidSurau->status == 'Aktif' ? 'bx-toggle-left' : 'bx-toggle-right' }} mr-2'></i>
                    {{ $masjidSurau->status == 'Aktif' ? 'Nyahaktifkan' : 'Aktifkan' }}
                </button>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Assets -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700">Jumlah Aset</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $stats['total_assets'] ?? 0 }}</p>
                    <p class="text-xs text-blue-600 mt-1">Berdaftar</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-package text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Asset Movements -->
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-700">Pergerakan Aset</p>
                    <p class="text-2xl font-bold text-amber-900">{{ $stats['asset_movements'] ?? 0 }}</p>
                    <p class="text-xs text-amber-600 mt-1">Bulan ini</p>
                </div>
                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-transfer text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Inspections -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-700">Pemeriksaan</p>
                    <p class="text-2xl font-bold text-green-900">{{ $stats['inspections'] ?? 0 }}</p>
                    <p class="text-xs text-green-600 mt-1">Selesai</p>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-check-shield text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Maintenance Records -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700">Penyelenggaraan</p>
                    <p class="text-2xl font-bold text-purple-900">{{ $stats['maintenance_records'] ?? 0 }}</p>
                    <p class="text-xs text-purple-600 mt-1">Rekod</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-wrench text-white text-xl'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column - Main Information -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Basic Information Section -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-buildings text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Asas</h3>
                        <p class="text-sm text-emerald-700">Data dan butiran {{ strtolower($masjidSurau->jenis) }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-buildings text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nama {{ $masjidSurau->jenis }}</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $masjidSurau->nama }}</dd>
                    </div>

                    <!-- Singkatan Nama -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-tag text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Singkatan Nama</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $masjidSurau->singkatan_nama ?: '-' }}</dd>
                        @if($masjidSurau->singkatan_nama)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 mt-2">
                                <i class='bx bx-info-circle mr-1'></i>
                                Digunakan untuk kod aset
                            </span>
                        @endif
                    </div>

                    <!-- Jenis -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-category text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Jenis</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $masjidSurau->jenis == 'Masjid' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                <i class='bx {{ $masjidSurau->jenis == 'Masjid' ? 'bx-building' : 'bx-home-circle' }} mr-1'></i>
                                {{ $masjidSurau->jenis }}
                            </span>
                        </dd>
                    </div>

                    <!-- Status -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-check-circle text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Status</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $masjidSurau->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <div class="w-2 h-2 {{ $masjidSurau->status == 'Aktif' ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-2"></div>
                                {{ $masjidSurau->status }}
                            </span>
                        </dd>
                        <p class="text-xs text-gray-500 mt-2">
                            {{ $masjidSurau->status == 'Aktif' ? 'Operasi normal dan aset boleh diuruskan' : 'Operasi terhenti' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Organization & Details Section -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-shield text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Organisasi</h3>
                        <p class="text-sm text-purple-700">Pengurusan dan butiran organisasi</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Imam/Ketua -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-user text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Imam/Ketua</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $masjidSurau->imam_ketua ?: '-' }}</dd>
                        @if($masjidSurau->imam_ketua)
                            <p class="text-xs text-gray-500 mt-2">Bertanggungjawab terhadap pengurusan</p>
                        @endif
                    </div>

                    <!-- Bilangan Jemaah -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-group text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Bilangan Jemaah</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $masjidSurau->bilangan_jemaah ? number_format($masjidSurau->bilangan_jemaah) . ' orang' : '-' }}</dd>
                        @if($masjidSurau->bilangan_jemaah)
                            <p class="text-xs text-gray-500 mt-2">Anggaran kapasiti jemaah</p>
                        @endif
                    </div>

                    <!-- Tahun Dibina -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Tahun Dibina</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $masjidSurau->tahun_dibina ?: '-' }}</dd>
                        @if($masjidSurau->tahun_dibina)
                            <p class="text-xs text-gray-500 mt-2">{{ date('Y') - $masjidSurau->tahun_dibina }} tahun yang lalu</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Location Information Section -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-map text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Lokasi</h3>
                        <p class="text-sm text-blue-700">Alamat dan lokasi</p>
                    </div>
                </div>
                
                <div class="space-y-6">
                    <!-- Full Address -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-map text-blue-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Alamat Lengkap</dt>
                        </div>
                        <dd class="text-gray-900">
                            @if($masjidSurau->alamat_baris_1)
                                <div>{{ $masjidSurau->alamat_baris_1 }}</div>
                            @endif
                            @if($masjidSurau->alamat_baris_2)
                                <div>{{ $masjidSurau->alamat_baris_2 }}</div>
                            @endif
                            @if($masjidSurau->alamat_baris_3)
                                <div>{{ $masjidSurau->alamat_baris_3 }}</div>
                            @endif
                            @if($masjidSurau->poskod || $masjidSurau->bandar)
                                <div>{{ $masjidSurau->poskod }} {{ $masjidSurau->bandar }}</div>
                            @endif
                            @if($masjidSurau->negeri)
                                <div>{{ $masjidSurau->negeri }}</div>
                            @endif
                        </dd>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Poskod -->
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center mb-2">
                                <i class='bx bx-current-location text-blue-600 mr-2'></i>
                                <dt class="text-sm font-medium text-gray-600">Poskod</dt>
                            </div>
                            <dd class="text-lg font-semibold text-gray-900">{{ $masjidSurau->poskod ?: '-' }}</dd>
                        </div>

                        <!-- Bandar -->
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center mb-2">
                                <i class='bx bx-buildings text-blue-600 mr-2'></i>
                                <dt class="text-sm font-medium text-gray-600">Bandar</dt>
                            </div>
                            <dd class="text-lg font-semibold text-gray-900">{{ $masjidSurau->bandar ?: '-' }}</dd>
                        </div>

                        <!-- Negeri -->
                        <div class="bg-white rounded-lg p-4 border border-gray-200">
                            <div class="flex items-center mb-2">
                                <i class='bx bx-map text-blue-600 mr-2'></i>
                                <dt class="text-sm font-medium text-gray-600">Negeri</dt>
                            </div>
                            <dd class="text-lg font-semibold text-gray-900">{{ $masjidSurau->negeri ?: '-' }}</dd>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information Section -->
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-phone text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Hubungan</h3>
                        <p class="text-sm text-amber-700">Cara untuk menghubungi</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Phone -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-phone text-amber-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nombor Telefon</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $masjidSurau->no_telefon ?: '-' }}</dd>
                        @if($masjidSurau->no_telefon)
                            <a href="tel:{{ $masjidSurau->no_telefon }}" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 mt-2 hover:bg-amber-200 transition-colors">
                                <i class='bx bx-phone-call mr-1'></i>
                                Hubungi
                            </a>
                        @endif
                    </div>

                    <!-- Email -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-envelope text-amber-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Alamat Email</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $masjidSurau->email ?: '-' }}</dd>
                        @if($masjidSurau->email)
                            <a href="mailto:{{ $masjidSurau->email }}" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800 mt-2 hover:bg-amber-200 transition-colors">
                                <i class='bx bx-mail-send mr-1'></i>
                                Email
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Quick Info & Actions -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-6">
                
                <!-- Masjid/Surau Card -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-100 rounded-xl p-6 border border-indigo-200">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-emerald-700 font-bold text-2xl">{{ substr($masjidSurau->nama, 0, 1) }}</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $masjidSurau->nama }}</h3>
                        <p class="text-sm text-gray-600">{{ $masjidSurau->singkatan_nama ?: 'Tiada singkatan' }}</p>
                        <div class="flex items-center justify-center space-x-2 mt-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $masjidSurau->jenis == 'Masjid' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $masjidSurau->jenis }}
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $masjidSurau->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $masjidSurau->status }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan Pantas</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.masjid-surau.edit', $masjidSurau) }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg transition-colors">
                            <i class='bx bx-edit mr-2'></i>
                            Edit Maklumat
                        </a>
                        
                        <form action="{{ route('admin.masjid-surau.toggle-status', $masjidSurau) }}" method="POST" class="w-full">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full flex items-center justify-center px-4 py-3 {{ $masjidSurau->status == 'Aktif' ? 'bg-red-100 hover:bg-red-200 text-red-700' : 'bg-green-100 hover:bg-green-200 text-green-700' }} rounded-lg transition-colors">
                                <i class='bx {{ $masjidSurau->status == 'Aktif' ? 'bx-toggle-left' : 'bx-toggle-right' }} mr-2'></i>
                                {{ $masjidSurau->status == 'Aktif' ? 'Nyahaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        
                        <a href="{{ route('admin.assets.index', ['masjid_surau_id' => $masjidSurau->id]) }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                            <i class='bx bx-package mr-2'></i>
                            Lihat Aset
                        </a>
                        
                        <a href="{{ route('admin.masjid-surau.index') }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                            <i class='bx bx-list-ul mr-2'></i>
                            Senarai Masjid/Surau
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
                            <span class="text-sm text-gray-600">Jumlah Aset:</span>
                            <span class="font-semibold text-green-700">{{ $stats['total_assets'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Pergerakan:</span>
                            <span class="font-semibold text-green-700">{{ $stats['asset_movements'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Pemeriksaan:</span>
                            <span class="font-semibold text-green-700">{{ $stats['inspections'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Penyelenggaraan:</span>
                            <span class="font-semibold text-green-700">{{ $stats['maintenance_records'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>

                <!-- System Info -->
                <div class="bg-gradient-to-br from-amber-50 to-orange-100 rounded-xl p-6 border border-amber-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-info-circle text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Rekod</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between">
                            <span class="text-amber-700">Dicipta:</span>
                            <span class="font-medium text-amber-800">{{ $masjidSurau->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-amber-700">Dikemaskini:</span>
                            <span class="font-medium text-amber-800">{{ $masjidSurau->updated_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex items-center text-amber-700 pt-2 border-t border-amber-200">
                            <i class='bx bx-shield-check mr-2'></i>
                            Data dilindungi SSL
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

