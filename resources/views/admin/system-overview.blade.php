@extends('layouts.admin')

@section('title', 'Gambaran Sistem')
@section('page-title', 'Gambaran Sistem')

@section('content')
<div class="p-6">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="bg-emerald-600 rounded-2xl p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Gambaran Keseluruhan Sistem</h1>
                    <p class="text-emerald-100 text-lg">Pantau prestasi dan statistik komprehensif sistem pengurusan aset</p>
                </div>
                <div class="hidden md:block">
                    <i class='bx bx-stats text-6xl text-emerald-200'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- System Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                 <!-- Total Assets -->
         <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
             <div class="flex items-center justify-between mb-4">
                 <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                     <i class='bx bx-box text-green-600 text-xl'></i>
                 </div>
                 <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">+12.3%</span>
             </div>
             <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($overview['system_stats']['total_assets'] ?? 0) }}</h3>
             <p class="text-sm text-gray-600">Jumlah Aset</p>
         </div>

         <!-- Total Masjid/Surau -->
         <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
             <div class="flex items-center justify-between mb-4">
                 <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                     <i class='bx bx-buildings text-emerald-600 text-xl'></i>
                 </div>
                 <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium">+2.1%</span>
             </div>
             <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $overview['masjids']->count() }}</h3>
             <p class="text-sm text-gray-600">Masjid/Surau</p>
         </div>

                 <!-- Active Users -->
         <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
             <div class="flex items-center justify-between mb-4">
                 <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                     <i class='bx bx-group text-emerald-600 text-xl'></i>
                 </div>
                 <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium">+5.2%</span>
             </div>
             <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($overview['system_stats']['active_users'] ?? 0) }}</h3>
             <p class="text-sm text-gray-600">Pengguna Aktif</p>
         </div>

        <!-- Pending Approvals -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-time text-amber-600 text-xl'></i>
                </div>
                <span class="text-sm text-amber-600 bg-amber-100 px-2 py-1 rounded-full font-medium">Pending</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($overview['system_stats']['pending_approvals'] ?? 0) }}</h3>
            <p class="text-sm text-gray-600">Kelulusan Tertangguh</p>
        </div>
    </div>

    <!-- Quick System Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- View All Assets -->
        <a href="{{ route('admin.assets.index') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                    <i class='bx bx-list-ul text-emerald-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-emerald-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Senarai Aset</h3>
            <p class="text-sm text-gray-600">Lihat semua aset dalam sistem</p>
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
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Masjids/Surau Overview -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Senarai Masjid/Surau</h2>
                            <p class="text-sm text-gray-600 mt-1">Gambaran keseluruhan semua masjid dan surau</p>
                        </div>
                                                 <a href="{{ route('admin.reports.index') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                             Lihat Semua
                         </a>
                    </div>
                </div>
                <div class="p-6">
                    @if($overview['masjids']->count() > 0)
                        <div class="space-y-4">
                            @foreach($overview['masjids'] as $masjid)
                            <div class="bg-gray-50 rounded-xl p-6 hover:bg-gray-100 transition-all duration-300 border border-gray-100">
                                <div class="flex items-start justify-between mb-4">
                                                                         <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                                         <i class='bx bx-check text-emerald-600 text-sm'></i>
                                     </div>
                                     <div class="flex-1">
                                         <h4 class="font-semibold text-gray-900">{{ $masjid->nama }}</h4>
                                         <p class="text-sm text-gray-600">{{ $masjid->alamat }} • {{ $masjid->jenis }}</p>
                                         <p class="text-xs text-gray-500 mt-1">{{ $masjid->assets_count ?? 0 }} aset • {{ $masjid->users_count ?? 0 }} pengguna</p>
                                     </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <i class='bx bx-buildings text-6xl text-gray-300 mb-4'></i>
                            <p class="text-lg font-medium text-gray-500 mb-2">Tiada Masjid/Surau</p>
                            <p class="text-sm text-gray-400">Masjid/surau akan dipaparkan setelah data dimasukkan</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Stats Sidebar -->
        <div class="space-y-6">
            <!-- Asset Status Distribution -->
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
                            <span class="text-sm font-medium text-gray-900">{{ $overview['asset_status']['active'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-amber-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">Maintenance</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $overview['asset_status']['maintenance'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">Rosak</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $overview['asset_status']['damaged'] ?? 0 }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-gray-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">Dilupuskan</span>
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $overview['asset_status']['disposed'] ?? 0 }}</span>
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
                            <span class="text-sm text-gray-700">Sistem Aktif</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-sm font-medium text-green-600">Online</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Backup Data</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-sm font-medium text-green-600">Updated</span>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-700">Security Status</span>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                <span class="text-sm font-medium text-green-600">Secure</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent System Activity -->
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Aktiviti Sistem</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-check text-green-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900">Sistem backup selesai</p>
                                <p class="text-xs text-gray-500">2 jam yang lalu</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-user text-blue-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900">Pengguna baharu didaftarkan</p>
                                <p class="text-xs text-gray-500">5 jam yang lalu</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-file text-purple-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900">Laporan bulanan dijana</p>
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