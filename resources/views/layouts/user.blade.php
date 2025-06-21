<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ sidebarOpen: false, profileDropdown: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- TailwindCSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }
        
        /* Custom scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        
        /* Elegant sidebar animations */
        .nav-item {
            position: relative;
            overflow: hidden;
        }
        
        .nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s;
        }
        
        .nav-item:hover::before {
            left: 100%;
        }
        
        /* Smooth hover effects */
        .nav-link {
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            transform: translateX(8px);
            background: rgba(255, 255, 255, 0.1);
        }
        
        .nav-link.active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #10b981;
            transform: translateX(4px);
        }
        
        /* Logo animation */
        .logo-icon {
            transition: transform 0.3s ease;
        }
        
        .logo-icon:hover {
            transform: rotate(360deg);
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <div class="flex h-screen overflow-hidden">
        <!-- Mobile sidebar overlay -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-30 bg-gray-900 bg-opacity-50 lg:hidden"
             @click="sidebarOpen = false">
        </div>

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-40 w-72 bg-gradient-to-b from-emerald-700 via-emerald-600 to-emerald-800 shadow-2xl transform transition-transform duration-300 ease-in-out lg:translate-x-0 flex flex-col"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
               
            <!-- Logo Area - Fixed -->
            <div class="p-8 border-b border-emerald-500/30 flex-shrink-0">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg logo-icon">
                        <i class='bx bx-cube text-emerald-600 text-2xl'></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-white">AssetFlow</h1>
                        <p class="text-emerald-200 text-sm font-medium">User Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation - Scrollable -->
            <nav class="flex-1 overflow-y-auto sidebar p-6 space-y-2">
                <!-- Dashboard Section -->
                <div class="mb-8">
                    <h3 class="px-4 text-xs font-bold text-emerald-200 uppercase tracking-widest mb-4 flex items-center">
                        <i class='bx bx-grid-alt text-emerald-300 mr-2'></i>
                        Dashboard
                    </h3>
                    
                    <a href="{{ route('user.dashboard') }}" 
                       class="nav-item nav-link flex items-center px-4 py-3 text-white rounded-xl font-medium {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                        <i class='bx bxs-dashboard text-xl mr-4'></i>
                        <span>Papan Pemuka</span>
                        @if(request()->routeIs('user.dashboard'))
                            <i class='bx bx-chevron-right ml-auto text-emerald-300'></i>
                        @endif
                    </a>
                </div>

                <!-- Profile Section -->
                <div class="mb-8">
                    <h3 class="px-4 text-xs font-bold text-emerald-200 uppercase tracking-widest mb-4 flex items-center">
                        <i class='bx bx-user text-emerald-300 mr-2'></i>
                        Profil
                    </h3>
                    
                    <a href="{{ route('user.profile.edit') }}" 
                       class="nav-item nav-link flex items-center px-4 py-3 text-white rounded-xl font-medium {{ request()->routeIs('user.profile.*') ? 'active' : '' }}">
                        <i class='bx bx-user-circle text-xl mr-4'></i>
                        <span>Kemaskini Profil</span>
                        @if(request()->routeIs('user.profile.*'))
                            <i class='bx bx-chevron-right ml-auto text-emerald-300'></i>
                        @endif
                    </a>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-72 h-screen flex flex-col overflow-hidden">
            <!-- Top Header -->
            <header class="bg-white border-b border-gray-200 shadow-sm flex-shrink-0 z-20">
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between">
                        <!-- Mobile menu button -->
                        <button @click="sidebarOpen = !sidebarOpen" 
                                class="lg:hidden text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out">
                            <i class='bx bx-menu text-2xl'></i>
                        </button>
                        
                        <!-- Page title area -->
                        <div class="hidden lg:block">
                            <h1 class="text-2xl font-bold text-gray-900">@yield('page-title', 'User Panel')</h1>
                        </div>

                        <!-- User Profile & Notifications -->
                        <div class="flex items-center space-x-4">
                            <!-- User Profile Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" 
                                        class="flex items-center space-x-3 p-2 rounded-lg hover:bg-gray-50 focus:outline-none focus:bg-gray-50 transition duration-150 ease-in-out">
                                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                        <i class='bx bx-user text-emerald-600 text-lg'></i>
                                    </div>
                                    <div class="hidden md:block text-left">
                                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-gray-500">Pengguna</p>
                                    </div>
                                    <i class='bx bx-chevron-down text-gray-400'></i>
                                </button>

                                <!-- Dropdown Menu -->
                                <div x-show="open" 
                                     @click.away="open = false"
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-56 rounded-xl shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                    <div class="py-2">
                                        <div class="px-4 py-3 border-b border-gray-100">
                                            <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                            <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                        </div>
                                        
                                        <a href="{{ route('user.profile.edit') }}" 
                                           class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 transition duration-150 ease-in-out">
                                            <i class='bx bx-user text-gray-400 mr-3'></i>
                                            Profil Saya
                                        </a>
                                        
                                        <div class="border-t border-gray-100 my-1"></div>
                                        
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" 
                                                    class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition duration-150 ease-in-out">
                                                <i class='bx bx-log-out text-red-500 mr-3'></i>
                                                Log Keluar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content Area -->
            <div class="flex-1 overflow-y-auto bg-gray-50">
                <div class="min-h-full flex flex-col">
                    <!-- Page Content -->
                    <div class="flex-1 p-8">
                        <!-- Flash Messages -->
                        @if (session('success'))
                            <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-400 text-emerald-700 px-6 py-4 rounded-r-xl shadow-sm">
                                <div class="flex items-center">
                                    <i class='bx bx-check-circle text-emerald-600 text-lg mr-3'></i>
                                    <span class="font-medium">{{ session('success') }}</span>
                                </div>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="mb-6 bg-red-50 border-l-4 border-red-400 text-red-700 px-6 py-4 rounded-r-xl shadow-sm">
                                <div class="flex items-center">
                                    <i class='bx bx-error-circle text-red-600 text-lg mr-3'></i>
                                    <span class="font-medium">{{ session('error') }}</span>
                                </div>
                            </div>
                        @endif

                        @yield('content')
                    </div>

                    <!-- Footer -->
                    <footer class="bg-white border-t border-gray-200 py-6 px-8 flex-shrink-0">
                        <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                            <div class="flex items-center space-x-4">
                                <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                                    <i class='bx bx-cube text-emerald-600 text-lg'></i>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">AssetFlow Management System</p>
                                    <p class="text-xs text-gray-500">Sistem Pengurusan Aset Komprehensif</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center space-x-6 text-sm text-gray-500">
                                <p>&copy; {{ date('Y') }} AssetFlow. Semua hak terpelihara.</p>
                                <div class="flex items-center space-x-4">
                                    <span class="flex items-center">
                                        <i class='bx bx-shield-check text-emerald-500 mr-1'></i>
                                        Selamat
                                    </span>
                                    <span class="flex items-center">
                                        <div class="w-2 h-2 bg-emerald-400 rounded-full mr-2"></div>
                                        Sistem Aktif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </footer>
                </div>
            </div>
        </main>
    </div>
</body>
</html> 