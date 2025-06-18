<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Reset Password - AssetFlow</title>

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
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-emerald-600 font-medium transition-colors duration-200">
                        ← Back to Sign In
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-display font-bold text-slate-900 mb-2">Reset your password</h2>
                    <p class="text-slate-600">Enter your email address and we'll send you a link to reset your password</p>
                </div>
                
                <!-- Reset Password Form Card -->
                <div class="bg-white/70 backdrop-blur-sm py-8 px-6 shadow-xl shadow-slate-900/10 rounded-2xl border border-white/20 relative">
                    <!-- Decorative gradient -->
                    <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/5 to-amber-500/5 rounded-2xl"></div>
                    
                    <div class="relative">
                        <!-- Session Status -->
                        @if (session('status'))
                            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-lg">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-emerald-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm text-emerald-700 font-medium">{{ session('status') }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Validation Errors -->
                        @if ($errors->any())
                            <div class="mb-6">
                                <div class="p-4 bg-red-50 border border-red-200 rounded-lg">
                                    <div class="flex items-center mb-2">
                                        <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="font-medium text-sm text-red-600">Please check the following:</span>
                                    </div>
                                    <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <!-- Information Box -->
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                <div class="text-sm text-blue-700">
                                    <p class="font-medium mb-1">Forgot your password? No problem!</p>
                                    <p>Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
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
                                       placeholder="Enter your email address">
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button type="submit" 
                                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-semibold text-white bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all duration-200 transform hover:scale-[1.02]">
                                    Send Password Reset Link
                                </button>
                            </div>

                            <!-- Divider -->
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-slate-200"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-4 bg-white/70 text-slate-500">Remember your password?</span>
                                </div>
                            </div>

                            <!-- Back to Login Link -->
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="font-medium text-emerald-600 hover:text-emerald-500 transition-colors duration-200">
                                    Sign in to your account →
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Help Section -->
                <div class="text-center">
                    <p class="text-sm text-slate-500 mb-4">Need help? Contact our support team</p>
                    <div class="flex justify-center space-x-6 text-xs text-slate-400">
                        <span class="flex items-center">
                            <svg class="w-3 h-3 text-emerald-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            Secure & Private
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
                            Instant Reset
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html> 