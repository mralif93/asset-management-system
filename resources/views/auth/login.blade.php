<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Sign In - AssetFlow</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&family=outfit:400,500,600,700" rel="stylesheet" />

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            'sans': ['Poppins', 'ui-sans-serif', 'system-ui'],
                            'display': ['Outfit', 'ui-sans-serif', 'system-ui'],
                        }
                    }
                }
            }
        </script>
    </head>
    <body class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-emerald-50 font-sans">
        <!-- Navigation -->
        <nav class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 px-6 py-4 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-2xl font-display font-bold bg-gradient-to-r from-slate-800 to-emerald-600 bg-clip-text text-transparent">
                        AssetFlow
                    </a>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="{{ url('/') }}" class="text-slate-600 hover:text-emerald-600 font-medium transition-colors duration-200">
                        ← Back to Home
                    </a>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="max-w-md w-full space-y-8">
                <!-- Header -->
                <div class="text-center">
                    <div class="mx-auto h-16 w-16 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg shadow-emerald-500/25">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-display font-bold text-slate-900 mb-2">Welcome back</h2>
                    <p class="text-slate-600">Sign in to your AssetFlow account</p>
                </div>
                
                <!-- Login Form Card -->
                <div class="bg-white/70 backdrop-blur-sm py-8 px-6 shadow-xl shadow-slate-900/10 rounded-2xl border border-white/20 relative">
                    <!-- Decorative gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-amber-500/5 rounded-2xl"></div>
                    
                    <div class="relative">
                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                                <div class="text-sm text-emerald-600">{{ session('status') }}</div>
                            </div>
                        @endif

                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="mb-6">
                                <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <div class="font-medium text-sm text-red-600 mb-2">
                                        {{ __('Whoops! Something went wrong.') }}
                                    </div>
                                    <ul class="mt-3 list-disc list-inside text-sm text-red-600 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf

                            <!-- Email Address -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email address</label>
                                <input id="email" 
                                       name="email" 
                                       type="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus
                                       class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 placeholder-slate-400"
                                       placeholder="Enter your email">
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                                <input id="password" 
                                       name="password" 
                                       type="password" 
                                       required
                                       class="w-full px-4 py-3 bg-white/50 border border-slate-200 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all duration-200 placeholder-slate-400"
                                       placeholder="Enter your password">
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input id="remember_me" 
                                           name="remember" 
                                           type="checkbox" 
                                           class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-slate-300 rounded">
                                    <label for="remember_me" class="ml-2 block text-sm text-slate-600">
                                        Remember me
                                    </label>
                                </div>

                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-500 transition-colors duration-200">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button type="submit" 
                                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 transform hover:scale-[1.02]">
                                    Sign in to your account
                                </button>
                            </div>

                            <!-- Divider -->
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-slate-200"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-4 bg-white/70 text-slate-500">Don't have an account?</span>
                                </div>
                            </div>

                            <!-- Register Link -->
                            <div class="text-center">
                                <a href="{{ route('register') }}" class="font-medium text-emerald-600 hover:text-emerald-500 transition-colors duration-200">
                                    Create a new account →
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Features Preview -->
                <div class="text-center">
                    <p class="text-sm text-slate-500 mb-4">Trusted by 3,000+ companies worldwide</p>
                    <div class="flex justify-center space-x-6 text-xs text-slate-400">
                        <span class="flex items-center">
                            <svg class="w-3 h-3 text-emerald-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Enterprise Security
                        </span>
                        <span class="flex items-center">
                            <svg class="w-3 h-3 text-emerald-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            24/7 Support
                        </span>
                        <span class="flex items-center">
                            <svg class="w-3 h-3 text-emerald-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            99.9% Uptime
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html> 