@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
<div class="p-6">
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-emerald-600 rounded-2xl p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Selamat datang, {{ Auth::user()->name }}!</h1>
                    <p class="text-emerald-100 text-lg">Kelola aset organisasi anda dengan mudah dan efisien</p>
                </div>
                <div class="hidden md:block">
                    <i class='bx bx-shield-check text-6xl text-emerald-200'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Add User -->
        <a href="{{ route('admin.users.create') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                    <i class='bx bx-user-plus text-emerald-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-emerald-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Tambah Pengguna</h3>
            <p class="text-sm text-gray-600">Daftar pengguna baharu dalam sistem</p>
        </a>

        <!-- Add Asset -->
        <a href="{{ route('admin.assets.create') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                    <i class='bx bx-plus-circle text-green-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-green-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Tambah Aset</h3>
            <p class="text-sm text-gray-600">Daftar aset baharu ke dalam sistem</p>
        </a>

        <!-- View Reports -->
        <a href="{{ route('admin.reports.index') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <i class='bx bx-bar-chart-alt-2 text-purple-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-purple-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Lihat Laporan</h3>
            <p class="text-sm text-gray-600">Jana laporan komprehensif sistem</p>
        </a>

        <!-- System Overview -->
        <a href="{{ route('admin.system-overview') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                    <i class='bx bx-stats text-amber-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-amber-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Gambaran Sistem</h3>
            <p class="text-sm text-gray-600">Lihat status keseluruhan sistem</p>
        </a>
    </div>

    <!-- Statistics Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-group text-emerald-600 text-xl'></i>
                </div>
                <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium">+5.2%</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalUsers ?? 0 }}</h3>
            <p class="text-sm text-gray-600">Jumlah Pengguna</p>
        </div>

        <!-- Total Assets -->
        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-box text-green-600 text-xl'></i>
                </div>
                <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">+12.3%</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalAssets ?? 0 }}</h3>
            <p class="text-sm text-gray-600">Jumlah Aset</p>
        </div>

        <!-- Total Buildings -->
        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-buildings text-emerald-600 text-xl'></i>
                </div>
                <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium">+2.1%</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalMasjidSurau ?? 0 }}</h3>
            <p class="text-sm text-gray-600">Masjid/Surau</p>
        </div>

        <!-- Pending Inspections -->
        <div class="bg-white rounded-xl p-6 border border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-time text-amber-600 text-xl'></i>
                </div>
                <span class="text-sm text-amber-600 bg-amber-100 px-2 py-1 rounded-full font-medium">Pending</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $pendingInspections ?? 0 }}</h3>
            <p class="text-sm text-gray-600">Pemeriksaan Pending</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Activity -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Aktiviti Terkini</h2>
                        <a href="{{ route('admin.reports.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @if(isset($recentActivities) && $recentActivities->count() > 0)
                            @foreach($recentActivities->take(5) as $activity)
                                <div class="flex items-start space-x-3">
                                    <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class='bx bx-check text-emerald-600 text-sm'></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-900">{{ $activity->description ?? 'Aktiviti sistem' }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $activity->created_at->diffForHumans() ?? 'Baru sahaja' }}</p>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-8">
                                <i class='bx bx-info-circle text-4xl text-gray-300 mb-3'></i>
                                <p class="text-gray-500">Tiada aktiviti terkini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="space-y-6">
            <!-- Asset Status -->
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Status Aset</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">Aktif</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $activeAssets ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-amber-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">Maintenance</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $maintenanceAssets ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">Rosak</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $damagedAssets ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Health -->
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Kesihatan Sistem</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Database</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-sm font-medium text-green-600">Online</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Server</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-sm font-medium text-green-600">Stabil</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Storage</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                                <span class="text-sm font-medium text-emerald-600">85% Digunakan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
        <!-- Recent Users -->
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Pengguna Terkini</h2>
                    <a href="{{ route('admin.users.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @if(isset($recentUsers) && $recentUsers->count() > 0)
                        @foreach($recentUsers->take(5) as $user)
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <i class='bx bx-user text-emerald-600'></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                </div>
                                <span class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <i class='bx bx-user-plus text-4xl text-gray-300 mb-3'></i>
                            <p class="text-gray-500">Tiada pengguna terkini</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Maintenance Schedule -->
        <div class="bg-white rounded-xl border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Jadual Penyelenggaraan</h2>
                    <a href="{{ route('admin.maintenance-records.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                        Lihat Semua
                    </a>
                </div>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @if(isset($upcomingMaintenance) && $upcomingMaintenance->count() > 0)
                        @foreach($upcomingMaintenance->take(5) as $maintenance)
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                                    <i class='bx bx-wrench text-amber-600'></i>
                                </div>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-gray-900">{{ $maintenance->title ?? 'Penyelenggaraan Rutin' }}</p>
                                    <p class="text-xs text-gray-500">{{ $maintenance->asset->name ?? 'Aset' }}</p>
                                </div>
                                <span class="text-xs text-gray-500">{{ $maintenance->scheduled_date->format('d M') ?? 'TBD' }}</span>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center py-8">
                            <i class='bx bx-calendar text-4xl text-gray-300 mb-3'></i>
                            <p class="text-gray-500">Tiada jadual penyelenggaraan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection