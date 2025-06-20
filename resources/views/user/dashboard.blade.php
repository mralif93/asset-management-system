@extends('layouts.user')

@section('title', 'Dashboard Pengguna')
@section('page-title', 'Dashboard Pengguna')

@section('content')
<div class="p-6">
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-emerald-600 rounded-2xl p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Selamat datang, {{ Auth::user()->name }}!</h1>
                    <p class="text-emerald-100 text-lg">Sistem Pengurusan Aset Masjid & Surau</p>
                </div>
                <div class="hidden md:block">
                    <i class='bx bx-user-check text-6xl text-emerald-200'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- User Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Profile Completion -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-user text-emerald-600 text-xl'></i>
                </div>
                <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium">Aktif</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ Auth::user()->role === 'user' ? '100' : '90' }}%</h3>
            <p class="text-sm text-gray-600">Profil Lengkap</p>
        </div>

        <!-- Account Status -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-shield-check text-green-600 text-xl'></i>
                </div>
                <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">Verified</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Aktif</h3>
            <p class="text-sm text-gray-600">Status Akaun</p>
        </div>

        <!-- User Role -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-id-card text-blue-600 text-xl'></i>
                </div>
                <span class="text-sm text-blue-600 bg-blue-100 px-2 py-1 rounded-full font-medium">{{ ucfirst(Auth::user()->role) }}</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ ucfirst(Auth::user()->role) }}</h3>
            <p class="text-sm text-gray-600">Peranan</p>
        </div>

        <!-- Last Login -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-time text-purple-600 text-xl'></i>
                </div>
                <span class="text-sm text-purple-600 bg-purple-100 px-2 py-1 rounded-full font-medium">Online</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Hari Ini</h3>
            <p class="text-sm text-gray-600">Log Masuk Terakhir</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Update Profile -->
        <a href="{{ route('profile.edit') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                    <i class='bx bx-edit text-emerald-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-emerald-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Kemaskini Profil</h3>
            <p class="text-sm text-gray-600">Ubah maklumat peribadi anda</p>
        </a>

        <!-- Contact Admin -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <i class='bx bx-support text-blue-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-blue-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Hubungi Sokongan</h3>
            <p class="text-sm text-gray-600">Bantuan dan sokongan teknikal</p>
        </div>

        <!-- System Info -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <i class='bx bx-info-circle text-purple-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-purple-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Maklumat Sistem</h3>
            <p class="text-sm text-gray-600">Panduan dan FAQ sistem</p>
        </div>

        <!-- Security -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                    <i class='bx bx-lock text-amber-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-amber-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Keselamatan</h3>
            <p class="text-sm text-gray-600">Tukar kata laluan & keselamatan</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- User Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Maklumat Pengguna</h2>
                        <a href="{{ route('profile.edit') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                            Kemaskini
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-user text-emerald-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900 font-medium">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 mt-1">Nama Penuh</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-envelope text-blue-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900 font-medium">{{ Auth::user()->email }}</p>
                                <p class="text-xs text-gray-500 mt-1">Alamat Email</p>
                            </div>
                        </div>
                        
                        @if(Auth::user()->phone)
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-phone text-green-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900 font-medium">{{ Auth::user()->phone }}</p>
                                <p class="text-xs text-gray-500 mt-1">Nombor Telefon</p>
                            </div>
                        </div>
                        @endif
                        
                        @if(Auth::user()->position)
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-briefcase text-purple-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900 font-medium">{{ Auth::user()->position }}</p>
                                <p class="text-xs text-gray-500 mt-1">Jawatan</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Sidebar -->
        <div class="space-y-6">
            <!-- Account Health -->
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Status Akaun</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">Akaun Aktif</span>
                            </div>
                            <span class="text-sm font-medium text-green-600">Ya</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">Email Disahkan</span>
                            </div>
                            <span class="text-sm font-medium text-green-600">Ya</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">Profil Lengkap</span>
                            </div>
                            <span class="text-sm font-medium text-emerald-600">{{ Auth::user()->phone && Auth::user()->position ? 'Ya' : 'Sebahagian' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Status Sistem</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Sistem Online</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-sm font-medium text-green-600">Aktif</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Sambungan</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-sm font-medium text-green-600">Stabil</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Keselamatan</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-sm font-medium text-green-600">Selamat</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Aktiviti Terkini</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-log-in text-emerald-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900">Log masuk ke sistem</p>
                                <p class="text-xs text-gray-500">Baru sahaja</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-user text-blue-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900">Profil dilihat</p>
                                <p class="text-xs text-gray-500">5 minit yang lalu</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-check text-green-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900">Akaun disahkan</p>
                                <p class="text-xs text-gray-500">1 hari yang lalu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 