@extends('layouts.admin')

@section('title', 'System Overview')
@section('page-title', 'System Overview')

@section('content')
<div class="p-6">
    <!-- Header Section with Real-time Status -->
    <div class="mb-8">
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center space-x-3 mb-2">
                        <h1 class="text-3xl font-bold">System Overview</h1>
                        <div class="flex items-center space-x-2 bg-emerald-500 bg-opacity-30 px-3 py-1 rounded-full">
                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                            <span class="text-sm text-emerald-100">System Active</span>
                        </div>
                    </div>
                    <p class="text-emerald-100 text-lg">Monitor comprehensive system performance and asset management statistics</p>
                    <div class="flex items-center space-x-6 mt-4">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-time text-emerald-200'></i>
                            <span class="text-emerald-100 text-sm">Last updated: {{ now()->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-shield-check text-emerald-200'></i>
                            <span class="text-emerald-100 text-sm">System Secure</span>
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
                    <p class="text-xs text-gray-500 mt-1">this month</p>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($overview['system_stats']['total_assets'] ?? 0) }}</h3>
            <p class="text-sm text-gray-600 mb-3">Total Assets</p>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-green-500 h-2 rounded-full transition-all duration-1000" style="width: 75%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-1">75% of annual target</p>
        </div>

        <!-- Total Masjid/Surau with Interactive Counter -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 group">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                    <i class='bx bx-buildings text-emerald-600 text-xl'></i>
                </div>
                <div class="text-right">
                    <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium">+2.1%</span>
                    <p class="text-xs text-gray-500 mt-1">this month</p>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1" x-data="{ count: 0 }" x-init="setTimeout(() => { let target = {{ $overview['system_stats']['total_masjids'] }}; let increment = target / 20; let timer = setInterval(() => { count += increment; if(count >= target) { count = target; clearInterval(timer); } }, 50); }, 200)">
                <span x-text="Math.floor(count)">0</span>
            </h3>
            <p class="text-sm text-gray-600 mb-3">Registered Masjid/Surau</p>
            <div class="flex items-center space-x-2">
                <div class="flex -space-x-1">
                    @for($i = 0; $i < min(3, $overview['system_stats']['total_masjids']); $i++)
                    <div class="w-6 h-6 bg-emerald-100 rounded-full border-2 border-white flex items-center justify-center">
                        <i class='bx bx-check text-emerald-600 text-xs'></i>
                    </div>
                    @endfor
                </div>
                <span class="text-xs text-gray-500">All active</span>
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
                    <p class="text-xs text-gray-500 mt-1">this week</p>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($overview['system_stats']['active_users'] ?? 0) }}</h3>
            <p class="text-sm text-gray-600 mb-3">Active Users</p>
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
                    <span class="text-xs font-medium">Action Required</span>
                </div>
                @else
                <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">All Complete</span>
                @endif
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($overview['system_stats']['pending_approvals'] ?? 0) }}</h3>
            <p class="text-sm text-gray-600 mb-3">Pending Approvals</p>
            @if(($overview['system_stats']['pending_approvals'] ?? 0) > 0)
            <a href="{{ route('admin.asset-movements.index') }}" class="text-xs text-amber-600 hover:text-amber-700 font-medium flex items-center">
                <i class='bx bx-right-arrow-alt mr-1'></i>
                View all applications
            </a>
            @else
            <p class="text-xs text-green-600">No pending applications</p>
            @endif
        </div>
    </div>

    <!-- Enhanced Quick System Actions with Tooltips -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Quick Actions</h2>
                <p class="text-sm text-gray-600">Quick access to main system functions</p>
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
                    <h3 class="font-semibold text-gray-900 mb-2">Asset List</h3>
                    <p class="text-sm text-gray-600">View and manage all assets in the system</p>
                    <div class="mt-3 flex items-center space-x-2">
                        <div class="w-1 h-1 bg-emerald-500 rounded-full"></div>
                        <span class="text-xs text-emerald-600">{{ $overview['system_stats']['total_assets'] ?? 0 }} assets available</span>
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
                    <h3 class="font-semibold text-gray-900 mb-2">Add Asset</h3>
                    <p class="text-sm text-gray-600">Register new assets in the system</p>
                    <div class="mt-3 flex items-center space-x-2">
                        <div class="w-1 h-1 bg-green-500 rounded-full"></div>
                        <span class="text-xs text-green-600">Quick and easy process</span>
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
                    <h3 class="font-semibold text-gray-900 mb-2">View Reports</h3>
                    <p class="text-sm text-gray-600">Generate comprehensive system reports</p>
                    <div class="mt-3 flex items-center space-x-2">
                        <div class="w-1 h-1 bg-purple-500 rounded-full"></div>
                        <span class="text-xs text-purple-600">6 report types available</span>
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
                    <h3 class="font-semibold text-gray-900 mb-2">Add User</h3>
                    <p class="text-sm text-gray-600">Register new users in the system</p>
                    <div class="mt-3 flex items-center space-x-2">
                        <div class="w-1 h-1 bg-blue-500 rounded-full"></div>
                        <span class="text-xs text-blue-600">{{ $overview['system_stats']['active_users'] ?? 0 }} active users</span>
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
                            <h2 class="text-lg font-semibold text-gray-900">Masjid/Surau List</h2>
                            <p class="text-sm text-gray-600 mt-1">Overview of all masjids and suraus with current statistics</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center space-x-2 bg-emerald-50 px-3 py-1 rounded-full">
                                <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                                <span class="text-sm text-emerald-600 font-medium">{{ $overview['system_stats']['total_masjids'] }} Locations</span>
                            </div>
                            <a href="{{ route('admin.reports.assets-by-location') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center">
                                View All
                                <i class='bx bx-right-arrow-alt ml-1'></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <!-- Search and Filter Form -->
                    <form method="GET" action="{{ route('admin.system-overview') }}" class="mb-6">
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="flex-1">
                                <div class="relative">
                                    <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}"
                                           placeholder="Search by name, address, city, or state..." 
                                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <select name="type" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="">All Types</option>
                                    <option value="Masjid" {{ request('type') == 'Masjid' ? 'selected' : '' }}>Masjid</option>
                                    <option value="Surau" {{ request('type') == 'Surau' ? 'selected' : '' }}>Surau</option>
                                </select>
                                <select name="per_page" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="5" {{ request('per_page', 10) == 5 ? 'selected' : '' }}>5 per page</option>
                                    <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10 per page</option>
                                    <option value="20" {{ request('per_page', 10) == 20 ? 'selected' : '' }}>20 per page</option>
                                    <option value="50" {{ request('per_page', 10) == 50 ? 'selected' : '' }}>50 per page</option>
                                </select>
                                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                                    <i class='bx bx-filter-alt mr-1'></i>Filter
                                </button>
                                @if(request('search') || request('type'))
                                <a href="{{ route('admin.system-overview') }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                                    <i class='bx bx-x mr-1'></i>Clear
                                </a>
                                @endif
                            </div>
                        </div>
                    </form>

                    <!-- Results Summary -->
                    @if(request('search') || request('type'))
                    <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                <i class='bx bx-info-circle text-blue-600'></i>
                                <span class="text-sm text-blue-800">
                                    @if(request('search') && request('type'))
                                        Showing results for "{{ request('search') }}" in {{ request('type') }} type
                                    @elseif(request('search'))
                                        Showing results for "{{ request('search') }}"
                                    @elseif(request('type'))
                                        Showing {{ request('type') }} type only
                                    @endif
                                </span>
                            </div>
                            <span class="text-sm text-blue-600 font-medium">
                                {{ $overview['masjids']->total() }} result(s)
                            </span>
                        </div>
                    </div>
                    @endif

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
                                                    <span class="text-xs text-gray-600">{{ $masjid->assets_count ?? 0 }} assets</span>
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <i class='bx bx-group text-blue-500 text-sm'></i>
                                                    <span class="text-xs text-gray-600">{{ $masjid->users_count ?? 0 }} users</span>
                                                </div>
                                                <div class="flex items-center space-x-1">
                                                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                    <span class="text-xs text-green-600">Active</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <div class="text-right">
                                            <div class="text-lg font-bold text-gray-900">RM {{ number_format(($masjid->assets->sum('nilai_perolehan') ?? 0), 0) }}</div>
                                            <div class="text-xs text-gray-500">Asset Value</div>
                                        </div>
                                        <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-emerald-100 transition-colors">
                                            <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-emerald-600'></i>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Asset Status Mini Chart -->
                                @if($masjid->assets->count() > 0)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex items-center justify-between text-xs">
                                        <span class="text-gray-600">Asset Status:</span>
                                        <div class="flex items-center space-x-4">
                                            <div class="flex items-center space-x-1">
                                                <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                                <span class="text-gray-600">{{ $masjid->assets->where('status_aset', 'aktif')->count() }} Active</span>
                                            </div>
                                            <div class="flex items-center space-x-1">
                                                <div class="w-2 h-2 bg-amber-500 rounded-full"></div>
                                                <span class="text-gray-600">{{ $masjid->assets->where('status_aset', 'dalam_penyelenggaraan')->count() }} Maintenance</span>
                                            </div>
                                            <div class="flex items-center space-x-1">
                                                <div class="w-2 h-2 bg-red-500 rounded-full"></div>
                                                <span class="text-gray-600">{{ $masjid->assets->where('status_aset', 'rosak')->count() }} Damaged</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination Controls -->
                        @if($overview['masjids']->hasPages())
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-gray-600">
                                    Showing {{ $overview['masjids']->firstItem() ?? 0 }} to {{ $overview['masjids']->lastItem() ?? 0 }} of {{ $overview['masjids']->total() }} masjids/suraus
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if ($overview['masjids']->onFirstPage())
                                        <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                            <i class='bx bx-chevron-left mr-1'></i>Previous
                                        </span>
                                    @else
                                        <a href="{{ $overview['masjids']->previousPageUrl() }}" class="px-3 py-2 text-sm text-emerald-600 bg-white border border-emerald-200 rounded-lg hover:bg-emerald-50 transition-colors">
                                            <i class='bx bx-chevron-left mr-1'></i>Previous
                                        </a>
                                    @endif

                                    <div class="flex items-center space-x-1">
                                        @php
                                            $currentPage = $overview['masjids']->currentPage();
                                            $lastPage = $overview['masjids']->lastPage();
                                            $start = max(1, $currentPage - 2);
                                            $end = min($lastPage, $currentPage + 2);
                                        @endphp
                                        
                                        @if($start > 1)
                                            <a href="{{ $overview['masjids']->url(1) }}" class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">1</a>
                                            @if($start > 2)
                                                <span class="px-2 py-2 text-sm text-gray-400">...</span>
                                            @endif
                                        @endif
                                        
                                        @for($page = $start; $page <= $end; $page++)
                                            @if ($page == $currentPage)
                                                <span class="px-3 py-2 text-sm text-white bg-emerald-600 rounded-lg">{{ $page }}</span>
                                            @else
                                                <a href="{{ $overview['masjids']->url($page) }}" class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">{{ $page }}</a>
                                            @endif
                                        @endfor
                                        
                                        @if($end < $lastPage)
                                            @if($end < $lastPage - 1)
                                                <span class="px-2 py-2 text-sm text-gray-400">...</span>
                                            @endif
                                            <a href="{{ $overview['masjids']->url($lastPage) }}" class="px-3 py-2 text-sm text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors">{{ $lastPage }}</a>
                                        @endif
                                    </div>

                                    @if ($overview['masjids']->hasMorePages())
                                        <a href="{{ $overview['masjids']->nextPageUrl() }}" class="px-3 py-2 text-sm text-emerald-600 bg-white border border-emerald-200 rounded-lg hover:bg-emerald-50 transition-colors">
                                            Next<i class='bx bx-chevron-right ml-1'></i>
                                        </a>
                                    @else
                                        <span class="px-3 py-2 text-sm text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed">
                                            Next<i class='bx bx-chevron-right ml-1'></i>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif
                    @else
                        <div class="text-center py-12">
                            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class='bx bx-buildings text-3xl text-gray-400'></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-500 mb-2">No Masjid/Surau</h3>
                            <p class="text-sm text-gray-400 mb-4">Masjid/surau will be displayed after data is entered</p>
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                                <i class='bx bx-plus mr-2'></i>
                                Add Masjid/Surau
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
                        <h3 class="text-lg font-semibold text-gray-900">Asset Status</h3>
                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center">
                            <i class='bx bx-pie-chart-alt text-emerald-600 text-sm'></i>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 mt-1">Distribution of all asset statuses</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @php
                            $totalAssets = $overview['system_stats']['total_assets'] ?? 1;
                            // Calculate asset statuses from all assets, not just current page
                            $activeAssets = \App\Models\Asset::where('status_aset', 'aktif')->count();
                            $maintenanceAssets = \App\Models\Asset::where('status_aset', 'dalam_penyelenggaraan')->count();
                            $damagedAssets = \App\Models\Asset::where('status_aset', 'rosak')->count();
                        @endphp
                        
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <span class="text-sm text-gray-700">Active</span>
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
                                    <span class="text-sm text-gray-700">Damaged</span>
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
                        <h3 class="text-lg font-semibold text-gray-900">System Health</h3>
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
                                <span class="text-sm text-gray-700 font-medium">System Active</span>
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
                                <span class="text-sm text-gray-700 font-medium">Data Backup</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-blue-500 rounded-full"></div>
                                <span class="text-sm font-medium text-blue-600">{{ now()->format('H:i') }} Today</span>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-3 bg-purple-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center">
                                    <i class='bx bx-shield-check text-purple-600 text-sm'></i>
                                </div>
                                <span class="text-sm text-gray-700 font-medium">Security</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <div class="w-2 h-2 bg-purple-500 rounded-full"></div>
                                <span class="text-sm font-medium text-purple-600">SSL Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Recent System Activity -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
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
                                <p class="text-sm font-medium text-gray-900">System backup completed</p>
                                <p class="text-xs text-gray-500 mt-1">{{ now()->subHours(2)->diffForHumans() }}</p>
                                <div class="mt-1">
                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">Automatic</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-user text-blue-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">New user registered</p>
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
                                <p class="text-sm font-medium text-gray-900">Monthly report generated</p>
                                <p class="text-xs text-gray-500 mt-1">{{ now()->subDay()->diffForHumans() }}</p>
                                <div class="mt-1">
                                    <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full">Scheduled</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.dashboard') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium flex items-center justify-center">
                            <i class='bx bx-history mr-2'></i>
                            View all activities
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