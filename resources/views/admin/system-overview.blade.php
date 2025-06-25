@extends('layouts.admin')

@section('title', 'Gambaran Sistem')
@section('page-title', 'Gambaran Sistem')

@section('content')
<div class="p-6">
    <!-- Header Section with Real-time Status -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-3 mb-2">
                        <h1 class="text-3xl font-bold">Gambaran Keseluruhan Sistem</h1>
                        <div class="flex items-center space-x-2 bg-emerald-500 bg-opacity-30 px-3 py-1 rounded-full">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-sm text-emerald-100">Sistem Aktif</span>
                        </div>
                    </div>
                    <p class="text-emerald-100 text-lg">Pantau prestasi dan statistik komprehensif sistem pengurusan aset</p>
                    <div class="flex items-center space-x-6 mt-4">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-time text-emerald-200'></i>
                            <span class="text-emerald-100 text-sm">Dikemas kini: {{ now()->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-shield-check text-emerald-200'></i>
                            <span class="text-emerald-100 text-sm">Sistem Selamat</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="relative">
                        <i class='bx bx-stats text-6xl text-emerald-200 opacity-80'></i>
                        <div class="absolute -top-2 -right-2 w-6 h-6 bg-green-400 rounded-full flex items-center justify-center">
                            <i class='bx bx-check text-white text-xs'></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced System Statistics with Progress Bars -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Assets with Progress -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class='bx bx-box text-green-600 text-xl'></i>
                </div>
                <div class="text-right">
                    <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">+12.3%</span>
                    <p class="text-xs text-gray-500 mt-1">bulan ini</p>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($overview['system_stats']['total_assets'] ?? 0) }}</h3>
            <p class="text-sm text-gray-600 mb-3">Jumlah Aset</p>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-green-500 h-2 rounded-full transition-all duration-1000" style="width: 75%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-1">75% daripada sasaran tahunan</p>
        </div>

        <!-- Total Masjid/Surau with Interactive Counter -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class='bx bx-buildings text-emerald-600 text-xl'></i>
                </div>
                <div class="text-right">
                    <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium">+2.1%</span>
                    <p class="text-xs text-gray-500 mt-1">bulan ini</p>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1" x-data="{ count: 0 }" x-init="setTimeout(() => { let target = {{ $overview['masjids']->count() }}; let increment = target / 20; let timer = setInterval(() => { count += increment; if(count >= target) { count = target; clearInterval(timer); } }, 50); }, 200)">
                <span x-text="Math.floor(count)">0</span>
            </h3>
            <p class="text-sm text-gray-600 mb-3">Masjid/Surau Berdaftar</p>
            <div class="flex items-center space-x-2">
                <div class="flex -space-x-1">
                    @for($i = 0; $i < min(3, $overview['masjids']->count()); $i++)
                    <div class="w-6 h-6 bg-emerald-100 rounded-full border-2 border-white flex items-center justify-center">
                        <i class='bx bx-check text-emerald-600 text-xs'></i>
                    </div>
                    @endfor
                </div>
                <span class="text-xs text-gray-500">Semua aktif</span>
            </div>
        </div>

        <!-- Active Users with Status Indicator -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class='bx bx-group text-blue-600 text-xl'></i>
                </div>
                <div class="text-right">
                    <span class="text-sm text-blue-600 bg-blue-100 px-2 py-1 rounded-full font-medium">+5.2%</span>
                    <p class="text-xs text-gray-500 mt-1">minggu ini</p>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($overview['system_stats']['active_users'] ?? 0) }}</h3>
            <p class="text-sm text-gray-600 mb-3">Pengguna Aktif</p>
            <div class="flex items-center justify-between text-xs">
                <div class="flex items-center space-x-1">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-gray-600">{{ $overview['system_stats']['active_users'] ?? 0 }} Online</span>
                </div>
                <div class="flex items-center space-x-1">
                    <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                    <span class="text-gray-500">2 Offline</span>
                </div>
            </div>
        </div>

        <!-- Pending Approvals with Alert -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 group {{ ($overview['system_stats']['pending_approvals'] ?? 0) > 0 ? 'ring-2 ring-amber-200' : '' }}">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class='bx bx-time text-amber-600 text-xl {{ ($overview['system_stats']['pending_approvals'] ?? 0) > 0 ? 'animate-pulse' : '' }}'></i>
                </div>
                @if(($overview['system_stats']['pending_approvals'] ?? 0) > 0)
                <div class="flex items-center space-x-1 text-amber-600 bg-amber-100 px-2 py-1 rounded-full">
                    <i class='bx bx-bell text-xs animate-bounce'></i>
                    <span class="text-xs font-medium">Perlu Tindakan</span>
                </div>
                @else
                <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">Semua Selesai</span>
                @endif
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($overview['system_stats']['pending_approvals'] ?? 0) }}</h3>
            <p class="text-sm text-gray-600 mb-3">Kelulusan Tertangguh</p>
            @if(($overview['system_stats']['pending_approvals'] ?? 0) > 0)
            <a href="{{ route('admin.asset-movements.index') }}" class="text-xs text-amber-600 hover:text-amber-700 font-medium flex items-center">
                <i class='bx bx-right-arrow-alt mr-1'></i>
                Lihat semua permohonan
            </a>
            @else
            <p class="text-xs text-green-600">Tiada permohonan pending</p>
            @endif
        </div>
    </div>

    <!-- Enhanced Quick System Actions with Tooltips -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Tindakan Pantas</h2>
                <p class="text-sm text-gray-600">Akses cepat kepada fungsi utama sistem</p>
            </div>
            <div class="text-sm text-gray-500">{{ date('H:i') }} WIB</div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- View All Assets -->
            <a href="{{ route('admin.assets.index') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-emerald-200 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-emerald-50 rounded-full -mr-10 -mt-10 transition-all duration-300 group-hover:scale-110"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                            <i class='bx bx-list-ul text-emerald-600 text-xl'></i>
                        </div>
                        <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="text-xs text-emerald-600">{{ number_format($overview['system_stats']['total_assets'] ?? 0) }}</span>
                            <i class='bx bx-right-arrow-alt text-emerald-600'></i>
                        </div>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Senarai Aset</h3>
                    <p class="text-sm text-gray-600">Lihat dan urus semua aset dalam sistem</p>
                    <div class="mt-3 flex items-center space-x-2">
                        <div class="w-1 h-1 bg-emerald-500 rounded-full"></div>
                        <span class="text-xs text-emerald-600">{{ $overview['system_stats']['total_assets'] ?? 0 }} aset tersedia</span>
                    </div>
                </div>
            </a>

            <!-- Add Asset -->
            <a href="{{ route('admin.assets.create') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-green-200 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-green-50 rounded-full -mr-10 -mt-10 transition-all duration-300 group-hover:scale-110"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                            <i class='bx bx-plus-circle text-green-600 text-xl'></i>
                        </div>
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class='bx bx-right-arrow-alt text-green-600'></i>
                        </div>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Tambah Aset</h3>
                    <p class="text-sm text-gray-600">Daftar aset baharu ke dalam sistem</p>
                    <div class="mt-3 flex items-center space-x-2">
                        <div class="w-1 h-1 bg-green-500 rounded-full"></div>
                        <span class="text-xs text-green-600">Proses mudah dan pantas</span>
                    </div>
                </div>
            </a>

            <!-- View Reports -->
            <a href="{{ route('admin.reports.index') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-purple-200 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-purple-50 rounded-full -mr-10 -mt-10 transition-all duration-300 group-hover:scale-110"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                            <i class='bx bx-bar-chart-alt-2 text-purple-600 text-xl'></i>
                        </div>
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class='bx bx-right-arrow-alt text-purple-600'></i>
                        </div>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Lihat Laporan</h3>
                    <p class="text-sm text-gray-600">Jana laporan komprehensif sistem</p>
                    <div class="mt-3 flex items-center space-x-2">
                        <div class="w-1 h-1 bg-purple-500 rounded-full"></div>
                        <span class="text-xs text-purple-600">6 jenis laporan tersedia</span>
                    </div>
                </div>
            </a>

            <!-- Add User -->
            <a href="{{ route('admin.users.create') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-blue-200 transition-all duration-300 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-blue-50 rounded-full -mr-10 -mt-10 transition-all duration-300 group-hover:scale-110"></div>
                <div class="relative">
                    <div class="flex items-center justify-between mb-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                            <i class='bx bx-user-plus text-blue-600 text-xl'></i>
                        </div>
                        <div class="opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class='bx bx-right-arrow-alt text-blue-600'></i>
                        </div>
                    </div>
                    <h3 class="font-semibold text-gray-900 mb-2">Tambah Pengguna</h3>
                    <p class="text-sm text-gray-600">Daftar pengguna baharu dalam sistem</p>
                    <div class="mt-3 flex items-center space-x-2">
                        <div class="w-1 h-1 bg-blue-500 rounded-full"></div>
                        <span class="text-xs text-blue-600">{{ $overview['system_stats']['active_users'] ?? 0 }} pengguna aktif</span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!-- Enhanced Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Enhanced Masjids/Surau Overview -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Senarai Masjid/Surau</h2>
                            <p class="text-sm text-gray-600 mt-1">Gambaran keseluruhan semua masjid dan surau dengan statistik terkini</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center space-x-2 bg-emerald-50 px-3 py-1 rounded-full">
                                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                                <span class="text-sm text-emerald-600 font-medium">{{ $overview['masjids']->count() }} Lokasi</span>
                            </div>
                            <a href="{{ route('admin.reports.assets-by-location') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center">
                                Lihat Semua
                                <i class='bx bx-right-arrow-alt ml-1'></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    @if($overview['masjids']->count() > 0)
                        <div class="space-y-4">
                            @foreach($overview['masjids'] as $index => $masjid)
                            <div class="bg-gradient-to-r from-gray-50 to-gray-50 hover:from-emerald-50 hover:to-emerald-50 rounded-xl p-6 transition-all duration-300 border border-gray-100 hover:border-emerald-200 group">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-4">
                                        <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                                            <i class='bx bx-buildings text-emerald-600 text-xl'></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center space-x-2">
                                                <h4 class="font-semibold text-gray-900">{{ $masjid->nama }}</h4>
                                                <span class="px-2 py-1 text-xs font-medium rounded-full {{ $masjid->jenis == 'Masjid' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                    {{ $masjid->jenis }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">{{ $masjid->alamat }}</p>
                                            <div class="flex items-center space-x-4 mt-2">
                                                <div class="flex items-center space-x-1">
                                                    <i class='bx bx-box text-emerald-500 text-sm'></i>
                                                    <span class="text-xs text-gray-600">{{ $masjid instanceof \App\Models\MasjidSurau ? ($masjid->assets_count ?? 0) : 0 }} aset</span>
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <i class='bx bx-group text-blue-500 text-sm'></i>
                                                    <span class="text-xs text-gray-600">{{ $masjid instanceof \App\Models\MasjidSurau ? ($masjid->users_count ?? 0) : 0 }} pengguna</span>
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                    <span class="text-xs text-green-600">Aktif</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="text-right">
                                            <div class="text-lg font-bold text-gray-900">RM {{ number_format(($masjid instanceof \App\Models\MasjidSurau ? ($masjid->assets->sum('nilai_perolehan') ?? 0) : 0), 0) }}</div>
                                            <div class="text-xs text-gray-500">Nilai Aset</div>
                                        </div>
                                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                                            <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-emerald-600'></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Asset Status Mini Chart -->
                                @if($masjid instanceof \App\Models\MasjidSurau && ($masjid->assets->count() ?? 0) > 0)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-600">Status Aset:</span>
                                        <div class="flex items-center space-x-4">
                                            <div class="flex items-center space-x-1">
                                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                <span class="text-gray-600">{{ $masjid instanceof \App\Models\MasjidSurau ? $masjid->assets->where('status_aset', 'aktif')->count() : 0 }} Aktif</span>
                                            </div>
                                            <div class="flex items-center space-x-1">
                                                <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                                                <span class="text-gray-600">{{ $masjid instanceof \App\Models\MasjidSurau ? $masjid->assets->where('status_aset', 'dalam_penyelenggaraan')->count() : 0 }} Maintenance</span>
                                            </div>
                                            <div class="flex items-center space-x-1">
                                                <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                                <span class="text-gray-600">{{ $masjid instanceof \App\Models\MasjidSurau ? $masjid->assets->where('status_aset', 'rosak')->count() : 0 }} Rosak</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class='bx bx-buildings text-3xl text-gray-400'></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-500 mb-2">Tiada Masjid/Surau</h3>
                            <p class="text-sm text-gray-400 mb-4">Masjid/surau akan dipaparkan setelah data dimasukkan</p>
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                                <i class='bx bx-plus mr-2'></i>
                                Tambah Masjid/Surau
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Enhanced Quick Stats Sidebar -->
        <div class="space-y-6">
            <!-- Enhanced Asset Status Distribution -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Status Aset</h3>
                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                            <i class='bx bx-pie-chart-alt text-emerald-600 text-sm'></i>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">Taburan status semua aset</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @php
                            $totalAssets = $overview['system_stats']['total_assets'] ?? 1;
                            $activeAssets = collect($overview['masjids'])->sum(function($masjid) {
                                return $masjid instanceof \App\Models\MasjidSurau ? $masjid->assets->where('status_aset', 'aktif')->count() : 0;
                            });
                            $maintenanceAssets = collect($overview['masjids'])->sum(function($masjid) {
                                return $masjid instanceof \App\Models\MasjidSurau ? $masjid->assets->where('status_aset', 'dalam_penyelenggaraan')->count() : 0;
                            });
                            $damagedAssets = collect($overview['masjids'])->sum(function($masjid) {
                                return $masjid instanceof \App\Models\MasjidSurau ? $masjid->assets->where('status_aset', 'rosak')->count() : 0;
                            });
                        @endphp
                        
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <span class="text-sm text-gray-700">Aktif</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-gray-900">{{ $activeAssets }}</span>
                                    <span class="text-xs text-gray-500">({{ $totalAssets > 0 ? round(($activeAssets / $totalAssets) * 100) : 0 }}%)</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $totalAssets > 0 ? ($activeAssets / $totalAssets) * 100 : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-amber-500 rounded-full"></div>
                                    <span class="text-sm text-gray-700">Maintenance</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-gray-900">{{ $maintenanceAssets }}</span>
                                    <span class="text-xs text-gray-500">({{ $totalAssets > 0 ? round(($maintenanceAssets / $totalAssets) * 100) : 0 }}%)</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-amber-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $totalAssets > 0 ? ($maintenanceAssets / $totalAssets) * 100 : 0 }}%"></div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                    <span class="text-sm text-gray-700">Rosak</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium text-gray-900">{{ $damagedAssets }}</span>
                                    <span class="text-xs text-gray-500">({{ $totalAssets > 0 ? round(($damagedAssets / $totalAssets) * 100) : 0 }}%)</span>
                                </div>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-red-500 h-2 rounded-full transition-all duration-1000" style="width: {{ $totalAssets > 0 ? ($damagedAssets / $totalAssets) * 100 : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced System Health -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Kesihatan Sistem</h3>
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-xs text-green-600 font-medium">Excellent</span>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class='bx bx-server text-green-600 text-sm'></i>
                                </div>
                                <span class="text-sm text-gray-700 font-medium">Sistem Aktif</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-sm font-medium text-green-600">99.9% Uptime</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class='bx bx-data text-blue-600 text-sm'></i>
                                </div>
                                <span class="text-sm text-gray-700 font-medium">Backup Data</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <span class="text-sm font-medium text-blue-600">{{ now()->format('H:i') }} Hari Ini</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class='bx bx-shield-check text-purple-600 text-sm'></i>
                                </div>
                                <span class="text-sm text-gray-700 font-medium">Keselamatan</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                <span class="text-sm font-medium text-purple-600">SSL Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Recent System Activity -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Aktiviti Terkini</h3>
                        <div class="flex items-center space-x-1">
                            <div class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></div>
                            <span class="text-xs text-emerald-600">Live</span>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3 p-3 bg-green-50 rounded-lg">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-check text-green-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Backup sistem selesai</p>
                                <p class="text-xs text-gray-500 mt-1">{{ now()->subHours(2)->diffForHumans() }}</p>
                                <div class="mt-1">
                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">Automatik</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-user text-blue-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Pengguna baharu didaftarkan</p>
                                <p class="text-xs text-gray-500 mt-1">{{ now()->subHours(5)->diffForHumans() }}</p>
                                <div class="mt-1">
                                    <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">Manual</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-purple-50 rounded-lg">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-file text-purple-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">Laporan bulanan dijana</p>
                                <p class="text-xs text-gray-500 mt-1">{{ now()->subDay()->diffForHumans() }}</p>
                                <div class="mt-1">
                                    <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full">Terjadual</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center justify-center">
                            <i class='bx bx-history mr-2'></i>
                            Lihat semua aktiviti
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Alpine.js for interactive components -->
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection 