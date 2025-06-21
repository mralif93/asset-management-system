<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AssetFlow') }} - Sistem Pengurusan Aset</title>

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
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            200: '#a7f3d0',
                            300: '#6ee7b7',
                            400: '#34d399',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            800: '#065f46',
                            900: '#064e3b',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.8s ease-in-out',
                        'slide-up': 'slideUp 0.8s ease-out',
                        'float': 'float 6s ease-in-out infinite',
                        'float-reverse': 'float 8s ease-in-out infinite reverse',
                        'pulse-slow': 'pulse 3s infinite',
                        'bounce-slow': 'bounce 2s infinite'
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        slideUp: {
                            '0%': { transform: 'translateY(30px)', opacity: '0' },
                            '100%': { transform: 'translateY(0)', opacity: '1' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' }
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Alpine.js for interactivity -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { 
            font-family: 'Inter', sans-serif; 
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .glass-feature {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.4);
        }
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        .floating-shapes::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: linear-gradient(45deg, rgba(16, 185, 129, 0.1), rgba(5, 150, 105, 0.1));
            border-radius: 50%;
            top: 10%;
            left: 10%;
            animation: float 6s ease-in-out infinite;
        }
        .floating-shapes::after {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            background: linear-gradient(45deg, rgba(59, 130, 246, 0.1), rgba(37, 99, 235, 0.1));
            border-radius: 50%;
            bottom: 10%;
            right: 10%;
            animation: float 8s ease-in-out infinite reverse;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
    </style>
</head>
<body class="min-h-screen gradient-bg relative overflow-hidden">
    <!-- Floating Background Shapes -->
    <div class="floating-shapes"></div>

    <!-- Hero Section -->
    <section class="relative z-10 min-h-screen flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="animate-fade-in text-white">
                    <!-- Logo Section -->
                    <div class="mb-8">
                        <div class="w-20 h-20 bg-white/20 backdrop-blur-sm rounded-3xl flex items-center justify-center mb-6 shadow-xl">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <span class="inline-block bg-emerald-500/20 backdrop-blur-sm text-emerald-300 px-6 py-3 rounded-full text-sm font-semibold shadow-lg animate-pulse-slow">
                            ✨ Sistem Terkini untuk Masjid & Surau
                        </span>
                    </div>
                    
                    <h1 class="text-5xl lg:text-6xl font-bold mb-6 leading-tight animate-slide-up">
                        Sistem Pengurusan 
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-300 via-primary-300 to-emerald-400">
                            Aset Digital
                        </span>
                    </h1>
                    
                    <p class="text-xl text-white/80 mb-8 leading-relaxed animate-slide-up font-medium" style="animation-delay: 0.2s;">
                        Kelola aset masjid dan surau dengan mudah. Pantau inventori, jadual penyelenggaraan, 
                        pemeriksaan berkala, dan laporan kewangan dalam satu platform yang komprehensif dan mudah digunakan.
                    </p>
                    
                    <!-- Interactive Features List -->
                    <div class="mb-8 animate-slide-up" style="animation-delay: 0.4s;" x-data="{ activeFeature: 0 }">
                        <div class="grid grid-cols-2 gap-4">
                            <div @mouseenter="activeFeature = 1" 
                                 class="flex items-center space-x-3 p-4 rounded-2xl transition-all duration-300 cursor-pointer glass-feature hover:bg-white/20"
                                 :class="activeFeature === 1 ? 'bg-white/20 transform scale-105' : ''">
                                <div class="w-12 h-12 bg-emerald-500/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg">
                                    <span class="text-emerald-300 text-xl">📊</span>
                                </div>
                                <span class="text-sm font-semibold text-white">Dashboard Interaktif</span>
                            </div>
                            
                            <div @mouseenter="activeFeature = 2" 
                                 class="flex items-center space-x-3 p-4 rounded-2xl transition-all duration-300 cursor-pointer glass-feature hover:bg-white/20"
                                 :class="activeFeature === 2 ? 'bg-white/20 transform scale-105' : ''">
                                <div class="w-12 h-12 bg-primary-500/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg">
                                    <span class="text-primary-300 text-xl">🔧</span>
                                </div>
                                <span class="text-sm font-semibold text-white">Penyelenggaraan Auto</span>
                            </div>
                            
                            <div @mouseenter="activeFeature = 3" 
                                 class="flex items-center space-x-3 p-4 rounded-2xl transition-all duration-300 cursor-pointer glass-feature hover:bg-white/20"
                                 :class="activeFeature === 3 ? 'bg-white/20 transform scale-105' : ''">
                                <div class="w-12 h-12 bg-emerald-500/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg">
                                    <span class="text-emerald-300 text-xl">📱</span>
                                </div>
                                <span class="text-sm font-semibold text-white">Akses Mobile</span>
                            </div>
                            
                            <div @mouseenter="activeFeature = 4" 
                                 class="flex items-center space-x-3 p-4 rounded-2xl transition-all duration-300 cursor-pointer glass-feature hover:bg-white/20"
                                 :class="activeFeature === 4 ? 'bg-white/20 transform scale-105' : ''">
                                <div class="w-12 h-12 bg-primary-500/20 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-lg">
                                    <span class="text-primary-300 text-xl">📈</span>
                                </div>
                                <span class="text-sm font-semibold text-white">Laporan Realtime</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Interactive Login Button -->
                    <div class="animate-slide-up" style="animation-delay: 0.6s;" x-data="{ isHovered: false }">
                        <a href="{{ route('login') }}" @mouseenter="isHovered = true" 
                                @mouseleave="isHovered = false"
                                class="group btn-primary text-white px-10 py-4 rounded-2xl text-lg font-bold transition-all duration-300 transform hover:scale-105 overflow-hidden inline-flex items-center shadow-2xl">
                            <svg class="w-6 h-6 mr-3 transition-transform duration-300" 
                                 :class="isHovered ? 'translate-x-1' : ''" 
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            Login to System
                        </a>
                    </div>
                </div>
                
                <!-- Interactive Dashboard Preview -->
                <div class="animate-slide-up" style="animation-delay: 0.8s;" x-data="{ 
                    stats: {
                        assets: 847,
                        value: 1.8,
                        maintenance: 12,
                        inspections: 8
                    },
                    animateStats: false,
                    mounted() {
                        setTimeout(() => { this.animateStats = true }, 1000)
                    }
                }">
                    <div class="glass-card rounded-3xl shadow-2xl p-8 transform hover:scale-105 transition-all duration-500">
                        <!-- Dashboard Header -->
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xl font-bold text-gray-900 flex items-center">
                                <span class="w-4 h-4 bg-emerald-400 rounded-full mr-3 animate-pulse shadow-sm"></span>
                                Dashboard Pengurusan Aset
                            </h3>
                            <div class="flex space-x-2">
                                <div class="w-4 h-4 bg-red-400 rounded-full shadow-sm"></div>
                                <div class="w-4 h-4 bg-yellow-400 rounded-full shadow-sm"></div>
                                <div class="w-4 h-4 bg-emerald-400 rounded-full shadow-sm"></div>
                            </div>
                        </div>
                        
                        <!-- Animated Stats -->
                        <div class="grid grid-cols-2 gap-6 mb-8">
                            <div class="bg-gradient-to-br from-primary-50 to-primary-100 p-6 rounded-2xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-primary-200">
                                <div class="text-sm font-semibold text-gray-600 mb-2">Jumlah Aset</div>
                                <div class="text-3xl font-bold text-gray-900 transition-all duration-1000 mb-1" 
                                     x-text="animateStats ? stats.assets : 0"></div>
                                <div class="text-xs text-gray-500 flex items-center">
                                    <span class="w-2 h-2 bg-emerald-400 rounded-full mr-2 group-hover:animate-pulse"></span>
                                    Peralatan & Kemudahan
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 p-6 rounded-2xl hover:shadow-lg transition-all duration-300 cursor-pointer group border border-emerald-200">
                                <div class="text-sm font-semibold text-gray-600 mb-2">Nilai Aset</div>
                                <div class="text-3xl font-bold text-gray-900 transition-all duration-1000 mb-1" 
                                     x-text="'RM' + (animateStats ? stats.value : 0) + 'M'"></div>
                                <div class="text-xs text-gray-500 flex items-center">
                                    <span class="w-2 h-2 bg-emerald-400 rounded-full mr-2 group-hover:animate-pulse"></span>
                                    Jumlah Keseluruhan
                                </div>
                            </div>
                        </div>
                        
                        <!-- Interactive Mini Stats -->
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 p-4 rounded-xl hover:shadow-md transition-all duration-300 cursor-pointer hover:bg-emerald-100 border border-emerald-200">
                                <div class="text-xs font-semibold text-gray-600">Penyelenggaraan</div>
                                <div class="text-lg font-bold text-gray-900 flex items-center mt-1">
                                    <span x-text="animateStats ? stats.maintenance : 0"></span>
                                    <span class="ml-2 text-sm">📅</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">Dijadualkan</div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-red-50 to-red-100 p-4 rounded-xl hover:shadow-md transition-all duration-300 cursor-pointer hover:bg-red-100 border border-red-200">
                                <div class="text-xs font-semibold text-gray-600">Pemeriksaan</div>
                                <div class="text-lg font-bold text-gray-900 flex items-center mt-1">
                                    <span x-text="animateStats ? stats.inspections : 0"></span>
                                    <span class="ml-2 text-sm">⚠️</span>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">Tertunggak</div>
                            </div>
                        </div>
                        
                        <!-- Interactive Activity Feed -->
                        <div x-data="{ showAll: false }">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-sm font-bold text-gray-900">Aktiviti Terkini</h4>
                                <button @click="showAll = !showAll" 
                                        class="text-emerald-600 text-sm hover:text-emerald-500 transition-colors duration-200 flex items-center font-semibold">
                                    <span x-text="showAll ? 'Sembunyikan' : 'Lihat Semua'"></span>
                                    <svg class="w-4 h-4 ml-1 transition-transform duration-200" 
                                         :class="showAll ? 'rotate-180' : ''" 
                                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition-colors duration-200 cursor-pointer border border-transparent hover:border-emerald-200">
                                    <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse shadow-sm"></div>
                                    <div class="text-sm text-gray-900 flex-1 font-medium">Penyelenggaraan AC Dewan selesai</div>
                                    <span class="text-xs text-gray-500 font-medium">2 min</span>
                                </div>
                                
                                <div class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition-colors duration-200 cursor-pointer border border-transparent hover:border-primary-200">
                                    <div class="w-3 h-3 bg-primary-500 rounded-full animate-pulse shadow-sm" style="animation-delay: 0.5s;"></div>
                                    <div class="text-sm text-gray-900 flex-1 font-medium">Aset baru: Karpet Solat (50 unit)</div>
                                    <span class="text-xs text-gray-500 font-medium">5 min</span>
                                </div>
                                
                                <div x-show="showAll" x-transition class="space-y-3">
                                    <div class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition-colors duration-200 cursor-pointer border border-transparent hover:border-yellow-200">
                                        <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse shadow-sm" style="animation-delay: 1s;"></div>
                                        <div class="text-sm text-gray-900 flex-1 font-medium">Pemeriksaan CCTV perlu dilakukan</div>
                                        <span class="text-xs text-gray-500 font-medium">1 jam</span>
                                    </div>
                                    
                                    <div class="flex items-center space-x-3 p-3 rounded-xl hover:bg-gray-50 transition-colors duration-200 cursor-pointer border border-transparent hover:border-emerald-200">
                                        <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse shadow-sm" style="animation-delay: 1.5s;"></div>
                                        <div class="text-sm text-gray-900 flex-1 font-medium">Laporan bulanan telah dijana</div>
                                        <span class="text-xs text-gray-500 font-medium">2 jam</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>
