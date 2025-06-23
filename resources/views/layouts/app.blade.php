<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AssetFlow') }} - @yield('title', 'Asset Management System')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'sage': '#CDC392',
                        'cream': '#E8E5DA',
                        'light-blue': '#9EB7E5',
                        'medium-blue': '#648DE5',
                        'dark-blue': '#304C89'
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="font-sans antialiased bg-white">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-2xl font-bold text-dark-blue">AssetFlow Pro</h1>
                        </div>
                        @auth
                            <div class="hidden md:block ml-10">
                                <div class="flex items-baseline space-x-8">
                                    <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-sage px-3 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-sage' : '' }}">Dashboard</a>
                                    
                                    @if(auth()->user()->role === 'admin')
                                        <div class="relative" x-data="{ open: false }">
                                            <button @click="open = !open" class="text-gray-700 hover:text-sage px-3 py-2 text-sm font-medium inline-flex items-center">
                                                Assets
                                                <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                            <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                                                <a href="{{ route('assets.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">All Assets</a>
                                                <a href="{{ route('assets.create') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Add Asset</a>
                                                <a href="{{ route('asset-movements.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Asset Movements</a>
                                                <a href="{{ route('inspections.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Inspections</a>
                                                <a href="{{ route('maintenance-records.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Maintenance</a>
                                            </div>
                                        </div>
                                        
                                        <a href="{{ route('reports.index') }}" class="text-gray-700 hover:text-sage px-3 py-2 text-sm font-medium {{ request()->routeIs('reports.*') ? 'text-sage' : '' }}">Reports</a>
                                        <a href="{{ route('users.index') }}" class="text-gray-700 hover:text-sage px-3 py-2 text-sm font-medium {{ request()->routeIs('users.*') ? 'text-sage' : '' }}">Users</a>
                                        <a href="{{ route('masjid-surau.index') }}" class="text-gray-700 hover:text-sage px-3 py-2 text-sm font-medium {{ request()->routeIs('masjid-surau.*') ? 'text-sage' : '' }}">Locations</a>
                                    @endif
                                </div>
                            </div>
                        @endauth
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        @guest
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-sage px-3 py-2 text-sm font-medium">Login</a>
                            <a href="{{ route('register') }}" class="bg-sage text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-medium-blue transition-colors">Register</a>
                        @else
                            <!-- User Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center text-gray-700 hover:text-sage px-3 py-2 text-sm font-medium">
                                    <span>{{ auth()->user()->name }}</span>
                                    <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold text-gray-900">
                        {{ $header }}
                    </h1>
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main class="py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Flash Messages -->
                @if (session('success'))
                    <div class="mb-4 bg-sage bg-opacity-10 border border-sage text-sage px-4 py-3 rounded-md" role="alert">
                        <div class="flex">
                            <div class="py-1">
                                <svg class="fill-current h-6 w-6 text-sage mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/>
                                </svg>
                            </div>
                            <div>
                                {{ session('success') }}
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md" role="alert">
                        <div class="flex">
                            <div class="py-1">
                                <svg class="fill-current h-6 w-6 text-red-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 5h2v6H9V5zm0 8h2v2H9v-2z"/>
                                </svg>
                            </div>
                            <div>
                                {{ session('error') }}
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html> 