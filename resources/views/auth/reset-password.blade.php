<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Reset Kata Laluan - {{ config('app.name', 'AssetFlow') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Poppins', 'sans-serif'],
                        'display': ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669',
                            700: '#047857',
                            900: '#064e3b',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen">
    <!-- Background pattern -->
    <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.02"%3E%3Ccircle cx="30" cy="30" r="2"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-20"></div>

    <!-- Navigation -->
    <nav class="relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-6">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="text-white">
                        <h1 class="font-display font-bold text-2xl">AssetFlow</h1>
                        <p class="text-slate-300 text-sm">Sistem Pengurusan Aset</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-slate-300 hover:text-white font-medium transition-colors">
                        Log Masuk
                    </a>
                    <a href="{{ url('/') }}" class="text-slate-300 hover:text-white font-medium transition-colors">
                        Kembali ke Laman Utama
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">
            <!-- Reset Password Card -->
            <div class="bg-white/10 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/20 p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-display font-bold text-white mb-2">Reset Kata Laluan</h2>
                    <p class="text-slate-300">Masukkan kata laluan baru untuk akaun anda</p>
                </div>

                <!-- Reset Password Form -->
                <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf

                    <!-- Hidden Token -->
                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-200 mb-2">
                            Alamat Email
                        </label>
                        <input id="email" 
                               name="email" 
                               type="email" 
                               value="{{ $email ?? old('email') }}"
                               autocomplete="email" 
                               required 
                               readonly
                               class="block w-full px-4 py-3 rounded-xl border border-white/20 bg-white/5 backdrop-blur-sm text-white placeholder-slate-400 cursor-not-allowed"
                               placeholder="nama@email.com">
                        @error('email')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-200 mb-2">
                            Kata Laluan Baru
                        </label>
                        <input id="password" 
                               name="password" 
                               type="password" 
                               autocomplete="new-password" 
                               required 
                               class="block w-full px-4 py-3 rounded-xl border border-white/20 bg-white/10 backdrop-blur-sm text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                               placeholder="Minimum 8 aksara">
                        @error('password')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-200 mb-2">
                            Sahkan Kata Laluan Baru
                        </label>
                        <input id="password_confirmation" 
                               name="password_confirmation" 
                               type="password" 
                               autocomplete="new-password" 
                               required 
                               class="block w-full px-4 py-3 rounded-xl border border-white/20 bg-white/10 backdrop-blur-sm text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-200"
                               placeholder="Ulangi kata laluan baru">
                    </div>

                    <!-- Password Requirements -->
                    <div class="bg-blue-500/20 border border-blue-500/30 text-blue-100 px-4 py-3 rounded-xl backdrop-blur-sm">
                        <h4 class="text-sm font-medium mb-2">Keperluan kata laluan:</h4>
                        <ul class="text-xs space-y-1">
                            <li class="flex items-center">
                                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-2"></span>
                                Minimum 8 aksara
                            </li>
                            <li class="flex items-center">
                                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-2"></span>
                                Campuran huruf besar dan kecil (disyorkan)
                            </li>
                            <li class="flex items-center">
                                <span class="w-1.5 h-1.5 bg-blue-400 rounded-full mr-2"></span>
                                Sekurang-kurangnya satu nombor (disyorkan)
                            </li>
                        </ul>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-medium text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 transform hover:scale-[1.02]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path>
                        </svg>
                        Kemaskini Kata Laluan
                    </button>
                </form>

                <!-- Back to Login -->
                <div class="mt-8 text-center">
                    <p class="text-slate-300">
                        Sudah ingat kata laluan anda? 
                        <a href="{{ route('login') }}" class="text-primary-400 hover:text-primary-300 font-medium transition-colors">
                            Kembali ke log masuk
                        </a>
                    </p>
                </div>
            </div>

            <!-- Security Tips -->
            <div class="mt-8 bg-white/5 backdrop-blur-sm rounded-xl p-6 border border-white/10">
                <div class="flex items-center mb-4">
                    <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-white font-medium">Tips Keselamatan</h3>
                </div>
                <ul class="text-slate-300 text-sm space-y-2">
                    <li class="flex items-center">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-2"></span>
                        Gunakan kata laluan yang unik dan kuat
                    </li>
                    <li class="flex items-center">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-2"></span>
                        Jangan kongsikan kata laluan dengan orang lain
                    </li>
                    <li class="flex items-center">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full mr-2"></span>
                        Log keluar selepas menggunakan komputer awam
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html> 