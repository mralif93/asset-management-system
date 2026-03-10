@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Admin Dashboard')

@section('content')
    <div class="p-6">
        <!-- Welcome Section -->
        <div class="mb-8">
            <div class="bg-emerald-600 rounded-2xl p-8 text-white animate__animated animate__fadeInDown">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Selamat datang, {{ Auth::user()->name }}!</h1>
                        <p class="text-emerald-100 text-lg">Kelola aset organisasi anda dengan mudah dan efisien</p>
                        <div class="flex items-center space-x-4 mt-4">
                            <span class="bg-emerald-500/30 px-3 py-1 rounded-full text-sm">
                                <i class='bx bx-calendar mr-1'></i>
                                {{ now()->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="hidden md:block animate__animated animate__bounce animate__infinite animate__slow">
                        <i class='bx bx-shield-check text-6xl text-emerald-200'></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Add User -->
            <a href="{{ route('admin.users.create') }}"
                class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 animate__animated animate__fadeInUp animate__delay-1s">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                        <i class='bx bx-user-plus text-emerald-600 text-xl'></i>
                    </div>
                    <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-emerald-600 transition-colors group-hover:translate-x-1'></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Tambah Pengguna</h3>
                <p class="text-sm text-gray-600">Daftar pengguna baharu dalam sistem</p>
            </a>

            <!-- Add Asset -->
            <a href="{{ route('admin.assets.create') }}"
                class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 animate__animated animate__fadeInUp animate__delay-2s">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                        <i class='bx bx-plus-circle text-green-600 text-xl'></i>
                    </div>
                    <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-green-600 transition-colors group-hover:translate-x-1'></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Tambah Aset</h3>
                <p class="text-sm text-gray-600">Daftar aset baharu ke dalam sistem</p>
            </a>

            <!-- View Reports -->
            <a href="{{ route('admin.reports.index') }}"
                class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 animate__animated animate__fadeInUp animate__delay-3s">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                        <i class='bx bx-bar-chart-alt-2 text-purple-600 text-xl'></i>
                    </div>
                    <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-purple-600 transition-colors group-hover:translate-x-1'></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Lihat Laporan</h3>
                <p class="text-sm text-gray-600">Jana laporan komprehensif sistem</p>
            </a>

            <!-- System Overview -->
            <a href="{{ route('admin.system-overview') }}"
                class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 animate__animated animate__fadeInUp animate__delay-4s">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                        <i class='bx bx-stats text-amber-600 text-xl'></i>
                    </div>
                    <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-amber-600 transition-colors group-hover:translate-x-1'></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Gambaran Sistem</h3>
                <p class="text-sm text-gray-600">Lihat status keseluruhan sistem</p>
            </a>
        </div>

        <!-- Statistics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Users -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 animate__animated animate__fadeInLeft">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-group text-emerald-600 text-xl animate__animated animate__pulse animate__infinite'></i>
                    </div>
                    <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium animate__animated animate__fadeIn animate__delay-1s">+5.2%</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1 animate__animated animate__flipInX">{{ number_format($totalUsers ?? 0) }}</h3>
                <p class="text-sm text-gray-600">Jumlah Pengguna</p>
            </div>

            <!-- Total Assets -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 animate__animated animate__fadeInLeft animate__delay-1s">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-box text-green-600 text-xl animate__animated animate__pulse animate__infinite'></i>
                    </div>
                    <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">+12.3%</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1 animate__animated animate__flipInX">{{ number_format($totalAssets ?? 0) }}</h3>
                <p class="text-sm text-gray-600">Jumlah Aset</p>
            </div>

            <!-- Total Buildings -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 animate__animated animate__fadeInRight animate__delay-2s">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-buildings text-emerald-600 text-xl animate__animated animate__pulse animate__infinite'></i>
                    </div>
                    <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium">+2.1%</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1 animate__animated animate__flipInX">{{ number_format($totalMasjids ?? 0) }}</h3>
                <p class="text-sm text-gray-600">Masjid/Surau</p>
            </div>

            <!-- Pending Inspections -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:-translate-y-1 animate__animated animate__fadeInRight animate__delay-3s">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-time text-amber-600 text-xl animate__animated animate__pulse animate__infinite'></i>
                    </div>
                    <span class="text-sm text-amber-600 bg-amber-100 px-2 py-1 rounded-full font-medium animate__animated animate__shake animate__infinite">Pending</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1 animate__animated animate__flipInX">{{ number_format($stats['assets_needing_inspection'] ?? 0) }}</h3>
                <p class="text-sm text-gray-600">Pemeriksaan Pending</p>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Recent Activity -->
            <div class="lg:col-span-2 animate__animated animate__fadeInUp animate__delay-2s">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow">
                    <div class="p-6 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-semibold text-gray-900">Aktiviti Terkini <span class="animate__animated animate__flash animate__infinite animate__slow text-xs bg-emerald-100 text-emerald-600 px-2 py-0.5 rounded-full ml-2">Baru</span></h2>
                            <a href="{{ route('admin.reports.index') }}"
                                class="text-sm text-emerald-600 hover:text-emerald-700 font-medium hover:underline">
                                Lihat Semua <i class='bx bx-right-arrow-alt'></i>
                            </a>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @if(isset($recentAssets) && $recentAssets->count() > 0)
                                @foreach($recentAssets as $index => $asset)
                                    <div class="flex items-start space-x-3 hover:bg-emerald-50 p-2 rounded-lg transition-colors animate__animated animate__slideInLeft" style="animation-delay: {{ $index * 0.1 }}s">
                                        <div
                                            class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0 animate__animated animate__rotateIn">
                                            <i class='bx bx-box text-emerald-600 text-lg'></i>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">{{ $asset->nama_aset ?? 'Aset baharu' }}</p>
                                            <p class="text-xs text-gray-500 mt-0.5">
                                                <span class="bg-emerald-100 text-emerald-600 px-2 py-0.5 rounded text-xs">{{ $asset->no_siri_pendaftaran ?? '' }}</span>
                                                <span class="ml-2">{{ $asset->created_at->diffForHumans() ?? 'Baru sahaja' }}</span>
                                            </p>
                                        </div>
                                        <div class="text-emerald-500 animate__animated animate__bounce animate__infinite">
                                            <i class='bx bx-plus-circle'></i>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-center py-8 animate__animated animate__fadeIn">
                                    <i class='bx bx-info-circle text-5xl text-gray-300 mb-3 animate__animated animate__pulse animate__infinite'></i>
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
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow animate__animated animate__fadeInRight animate__delay-3s">
                    <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-white">
                        <h3 class="text-lg font-semibold text-gray-900">Status Aset</h3>
                    </div>
                    <div class="p-6">
                        @php
                            $activeCount = $assetsByStatus->where('status_aset', 'Sedang Digunakan')->first()->count ?? 0;
                            $maintenanceCount = $assetsByStatus->where('status_aset', 'Dalam Penyelenggaraan')->first()->count ?? 0;
                            $damagedCount = $assetsByStatus->where('status_aset', 'Rosak')->first()->count ?? 0;
                        @endphp
                        <div class="space-y-4">
                            <div class="flex items-center justify-between group hover:bg-green-50 p-2 rounded-lg transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-green-500 rounded-full animate__animated animate__pulse animate__infinite"></div>
                                    <span class="text-sm text-gray-700">Aktif</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900 bg-green-100 px-3 py-1 rounded-full">{{ number_format($activeCount) }}</span>
                            </div>
                            <div class="flex items-center justify-between group hover:bg-amber-50 p-2 rounded-lg transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-amber-500 rounded-full animate__animated animate__pulse animate__infinite"></div>
                                    <span class="text-sm text-gray-700">Maintenance</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900 bg-amber-100 px-3 py-1 rounded-full">{{ number_format($maintenanceCount) }}</span>
                            </div>
                            <div class="flex items-center justify-between group hover:bg-red-50 p-2 rounded-lg transition-colors">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-red-500 rounded-full animate__animated animate__pulse animate__infinite"></div>
                                    <span class="text-sm text-gray-700">Rosak</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900 bg-red-100 px-3 py-1 rounded-full">{{ number_format($damagedCount) }}</span>
                            </div>
                        </div>
                        <!-- Progress Bar -->
                        <div class="mt-4">
                            <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                @php $total = $activeCount + $maintenanceCount + $damagedCount; @endphp
                                @if($total > 0)
                                    <div class="h-full flex">
                                        <div class="bg-green-500 animate__animated animate__fadeInLeft" style="width: {{ ($activeCount/$total)*100 }}%"></div>
                                        <div class="bg-amber-500 animate__animated animate__fadeInLeft animate__delay-1s" style="width: {{ ($maintenanceCount/$total)*100 }}%"></div>
                                        <div class="bg-red-500 animate__animated animate__fadeInLeft animate__delay-2s" style="width: {{ ($damagedCount/$total)*100 }}%"></div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Health -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow animate__animated animate__fadeInRight animate__delay-4s">
                    <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-white">
                        <h3 class="text-lg font-semibold text-gray-900">Kesihatan Sistem</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-database text-green-600'></i>
                                    </div>
                                    <span class="text-sm text-gray-700">Database</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate__animated animate__pulse animate__infinite"></div>
                                    <span class="text-sm font-medium text-green-600">Online</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-server text-blue-600'></i>
                                    </div>
                                    <span class="text-sm text-gray-700">Server</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-green-500 rounded-full animate__animated animate__pulse animate__infinite"></div>
                                    <span class="text-sm font-medium text-green-600">Stabil</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded-lg transition-colors">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class='bx bx-hdd text-purple-600'></i>
                                    </div>
                                    <span class="text-sm text-gray-700">Storage</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate__animated animate__pulse animate__infinite"></div>
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
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow animate__animated animate__fadeInUp animate__delay-3s">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Pengguna Terkini</h2>
                        <a href="{{ route('admin.users.index') }}"
                            class="text-sm text-emerald-600 hover:text-emerald-700 font-medium hover:underline">
                            Lihat Semua <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @if(isset($recentUsers) && $recentUsers->count() > 0)
                            @foreach($recentUsers->take(5) as $index => $user)
                                <div class="flex items-center space-x-3 hover:bg-blue-50 p-2 rounded-lg transition-colors animate__animated animate__slideInLeft" style="animation-delay: {{ $index * 0.1 }}s">
                                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                        <i class='bx bx-user text-emerald-600'></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->email }}</p>
                                    </div>
                                    <span class="text-xs bg-blue-100 text-blue-600 px-2 py-1 rounded-full">{{ $user->role }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-8">
                                <i class='bx bx-user-plus text-4xl text-gray-300 mb-3 animate__animated animate__pulse animate__infinite'></i>
                                <p class="text-gray-500">Tiada pengguna terkini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Maintenance Schedule -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition-shadow animate__animated animate__fadeInUp animate__delay-4s">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-amber-50 to-white">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Jadual Penyelenggaraan</h2>
                        <a href="{{ route('admin.maintenance-records.index') }}"
                            class="text-sm text-emerald-600 hover:text-emerald-700 font-medium hover:underline">
                            Lihat Semua <i class='bx bx-right-arrow-alt'></i>
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @if(isset($upcomingMaintenance) && $upcomingMaintenance->count() > 0)
                            @foreach($upcomingMaintenance as $index => $maintenance)
                                <div class="flex items-center space-x-3 hover:bg-amber-50 p-2 rounded-lg transition-colors animate__animated animate__slideInRight" style="animation-delay: {{ $index * 0.1 }}s">
                                    <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center">
                                        <i class='bx bx-wrench text-amber-600'></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $maintenance->jenis_penyelenggaraan ?? 'Penyelenggaraan Rutin' }}</p>
                                        <p class="text-xs text-gray-500">{{ $maintenance->asset->nama_aset ?? 'Aset' }}</p>
                                    </div>
                                    <span class="text-xs bg-amber-100 text-amber-600 px-2 py-1 rounded-full">
                                        <i class='bx bx-calendar mr-1'></i>
                                        {{ $maintenance->tarikh_penyelenggaraan_akan_datang ? \Carbon\Carbon::parse($maintenance->tarikh_penyelenggaraan_akan_datang)->format('d M') : 'TBD' }}
                                    </span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-8">
                                <i class='bx bx-calendar text-4xl text-gray-300 mb-3 animate__animated animate__pulse animate__infinite'></i>
                                <p class="text-gray-500">Tiada jadual penyelenggaraan</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Stats -->
        <div class="mt-8 bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-6 text-white animate__animated animate__fadeInUp animate__delay-5s">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                <div>
                    <p class="text-3xl font-bold animate__animated animate__zoomIn">{{ number_format($totalAssets ?? 0) }}</p>
                    <p class="text-emerald-200 text-sm">Jumlah Aset</p>
                </div>
                <div>
                    <p class="text-3xl font-bold animate__animated animate__zoomIn animate__delay-1s">{{ number_format($totalUsers ?? 0) }}</p>
                    <p class="text-emerald-200 text-sm">Pengguna Aktif</p>
                </div>
                <div>
                    <p class="text-3xl font-bold animate__animated animate__zoomIn animate__delay-2s">{{ number_format($totalMasjids ?? 0) }}</p>
                    <p class="text-emerald-200 text-sm">Masjid/Surau</p>
                </div>
                <div>
                    <p class="text-3xl font-bold animate__animated animate__zoomIn animate__delay-3s">{{ number_format($stats['pending_disposals'] ?? 0) }}</p>
                    <p class="text-emerald-200 text-sm">Pending Approval</p>
                </div>
            </div>
        </div>
    </div>
@endsection
