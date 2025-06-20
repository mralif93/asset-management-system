@extends('layouts.admin')

@section('title', 'Maklumat Pengguna')
@section('page-title', 'Maklumat Pengguna')
@section('page-description', 'Paparan terperinci maklumat pengguna')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Profil Pengguna</h1>
                <p class="text-emerald-100 text-lg">Paparan lengkap maklumat {{ $user->name }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-user-circle text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $user->role === 'admin' ? 'Pentadbir' : 'Pengguna' }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 {{ $user->email_verified_at ? 'bg-green-400' : 'bg-red-400' }} rounded-full"></div>
                        <span class="text-emerald-100">{{ $user->email_verified_at ? 'Aktif' : 'Tidak Aktif' }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-calendar text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $user->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-emerald-500 rounded-2xl flex items-center justify-center text-3xl font-bold text-white shadow-xl">
                    {{ substr($user->name, 0, 1) }}
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
        <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Pengguna
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">{{ $user->name }}</span>
    </div>

    <!-- Back Button & Actions -->
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('admin.users.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
            <i class='bx bx-arrow-back mr-2'></i>
            Kembali ke Senarai Pengguna
        </a>
        
        <div class="flex space-x-3">
            <a href="{{ route('admin.users.edit', $user) }}" 
               class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                <i class='bx bx-edit mr-2'></i>
                Edit Pengguna
            </a>
            @if($user->id !== auth()->id())
            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                @csrf
                @method('PATCH')
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 {{ $user->email_verified_at ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-lg transition-colors">
                    <i class='bx {{ $user->email_verified_at ? 'bx-toggle-left' : 'bx-toggle-right' }} mr-2'></i>
                    {{ $user->email_verified_at ? 'Nyahaktifkan' : 'Aktifkan' }}
                </button>
            </form>
            @endif
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
                    <p class="text-xs text-blue-600 mt-1">Diuruskan</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-package text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Pending Movements -->
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-700">Pergerakan Menunggu</p>
                    <p class="text-2xl font-bold text-amber-900">{{ $stats['pending_movements'] ?? 0 }}</p>
                    <p class="text-xs text-amber-600 mt-1">Tindakan diperlukan</p>
                </div>
                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-transfer text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Completed Inspections -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-700">Pemeriksaan</p>
                    <p class="text-2xl font-bold text-green-900">{{ $stats['completed_inspections'] ?? 0 }}</p>
                    <p class="text-xs text-green-600 mt-1">Selesai</p>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-check-shield text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-purple-700">Aktiviti Terkini</p>
                    <p class="text-2xl font-bold text-purple-900">{{ count($stats['recent_activities'] ?? []) }}</p>
                    <p class="text-xs text-purple-600 mt-1">Minggu ini</p>
                </div>
                <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-trending-up text-white text-xl'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column - Main Information -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Personal Information Section -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-user text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Peribadi</h3>
                        <p class="text-sm text-emerald-700">Data dan butiran pengguna</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-user text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nama Penuh</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $user->name }}</dd>
                    </div>

                    <!-- Email -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-envelope text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Alamat E-mel</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $user->email }}</dd>
                        @if($user->email_verified_at)
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-2">
                                <i class='bx bx-check-circle mr-1'></i>
                                Disahkan pada {{ $user->email_verified_at->format('d/m/Y') }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-2">
                                <i class='bx bx-x-circle mr-1'></i>
                                Belum disahkan
                            </span>
                        @endif
                    </div>

                    <!-- Phone -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-phone text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nombor Telefon</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $user->phone ?: '-' }}</dd>
                    </div>

                    <!-- Position -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-briefcase text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Jawatan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $user->position ?: '-' }}</dd>
                    </div>
                </div>
            </div>

            <!-- Role and Organization Section -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-shield text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Peranan & Organisasi</h3>
                        <p class="text-sm text-purple-700">Akses dan kewenangan sistem</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Role -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-shield text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Peranan</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-emerald-100 text-emerald-800' }}">
                                <i class='bx {{ $user->role === 'admin' ? 'bx-crown' : 'bx-user' }} mr-1'></i>
                                {{ $user->role === 'admin' ? 'Pentadbir' : 'Pengguna' }}
                            </span>
                        </dd>
                        <p class="text-xs text-gray-500 mt-2">
                            {{ $user->role === 'admin' ? 'Akses penuh kepada semua fungsi sistem' : 'Akses terhad mengikut peranan' }}
                        </p>
                    </div>

                    <!-- Masjid/Surau -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-building text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Masjid/Surau</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $user->masjidSurau->nama ?? 'Tidak ditetapkan' }}</dd>
                        @if($user->masjidSurau)
                            <p class="text-xs text-gray-500 mt-2">Bertanggungjawab terhadap aset organisasi ini</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Account Activity Section -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-time text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Aktiviti Akaun</h3>
                        <p class="text-sm text-blue-700">Rekod dan aktiviti terkini</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Account Created -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar-plus text-blue-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Akaun Dicipta</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $user->created_at->format('d/m/Y') }}</dd>
                        <p class="text-xs text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                    </div>

                    <!-- Last Updated -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-edit text-blue-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Kemaskini Terakhir</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $user->updated_at->format('d/m/Y') }}</dd>
                        <p class="text-xs text-gray-500 mt-1">{{ $user->updated_at->diffForHumans() }}</p>
                    </div>

                    <!-- Account Status -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-check-shield text-blue-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Status Akaun</dt>
                        </div>
                        <dd class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <div class="w-2 h-2 {{ $user->email_verified_at ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-2"></div>
                                {{ $user->email_verified_at ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Quick Info & Actions -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-6">
                
                <!-- User Card -->
                <div class="bg-gradient-to-br from-indigo-50 to-purple-100 rounded-xl p-6 border border-indigo-200">
                    <div class="text-center">
                        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-emerald-700 font-bold text-2xl">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $user->email }}</p>
                        <div class="flex items-center justify-center space-x-2 mt-3">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-emerald-100 text-emerald-800' }}">
                                {{ $user->role === 'admin' ? 'Pentadbir' : 'Pengguna' }}
                            </span>
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $user->email_verified_at ? 'Aktif' : 'Tidak Aktif' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan Pantas</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.users.edit', $user) }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 rounded-lg transition-colors">
                            <i class='bx bx-edit mr-2'></i>
                            Edit Maklumat
                        </a>
                        
                        @if($user->id !== auth()->id())
                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="w-full">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full flex items-center justify-center px-4 py-3 {{ $user->email_verified_at ? 'bg-red-100 hover:bg-red-200 text-red-700' : 'bg-green-100 hover:bg-green-200 text-green-700' }} rounded-lg transition-colors">
                                <i class='bx {{ $user->email_verified_at ? 'bx-toggle-left' : 'bx-toggle-right' }} mr-2'></i>
                                {{ $user->email_verified_at ? 'Nyahaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        @endif
                        
                        <a href="{{ route('admin.users.index') }}" 
                           class="w-full flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                            <i class='bx bx-list-ul mr-2'></i>
                            Senarai Pengguna
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
                            <span class="text-sm text-gray-600">Aset Diuruskan:</span>
                            <span class="font-semibold text-green-700">{{ $stats['total_assets'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Pemeriksaan:</span>
                            <span class="font-semibold text-green-700">{{ $stats['completed_inspections'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Pergerakan:</span>
                            <span class="font-semibold text-green-700">{{ $stats['pending_movements'] ?? 0 }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Aktiviti:</span>
                            <span class="font-semibold text-green-700">{{ count($stats['recent_activities'] ?? []) }}</span>
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
                            Sistem berfungsi normal
                        </div>
                        <div class="flex items-center text-amber-700">
                            <i class='bx bx-shield-check mr-2'></i>
                            Data dilindungi SSL
                        </div>
                        <div class="flex items-center text-amber-700">
                            <i class='bx bx-time mr-2'></i>
                            Backup harian aktif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 