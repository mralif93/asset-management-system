<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>AssetFlow - Streamline Your Asset Management Workflow</title>

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
    <body class="bg-gray-50 text-gray-900 font-sans">
        <!-- Navigation -->
        <nav class="bg-white border-b border-gray-200 py-4 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">
                <div class="flex items-center space-x-8">
                    <h1 class="text-2xl font-bold font-display text-slate-900">AssetFlow</h1>
                    <div class="hidden md:flex space-x-8">
                        <a href="#features" class="text-gray-600 hover:text-emerald-600 transition-colors">Features</a>
                        <a href="#solutions" class="text-gray-600 hover:text-emerald-600 transition-colors">Solutions</a>
                        <a href="#pricing" class="text-gray-600 hover:text-emerald-600 transition-colors">Pricing</a>
                        <a href="#about" class="text-gray-600 hover:text-emerald-600 transition-colors">About</a>
                    </div>
                </div>
                
                @if (Route::has('login'))
                    <div class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-gray-600 hover:text-emerald-600 transition-colors">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-emerald-600 transition-colors">Sign In</a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 transition-colors font-semibold">Get Started Free</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 text-white py-20">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <div class="inline-flex items-center px-4 py-2 bg-emerald-100 text-emerald-800 text-sm font-medium rounded-full mb-8">
                    <span class="mr-2">✨</span>
                    New: AI-Powered Asset Intelligence
                </div>
                <h1 class="text-5xl md:text-6xl font-bold font-display mb-6 leading-tight">
                    Transform Your Asset<br>
                    <span class="text-emerald-400">Management Experience</span>
                </h1>
                <p class="text-xl text-gray-300 mb-12 max-w-3xl mx-auto leading-relaxed">
                    Discover the future of asset management with intelligent tracking, predictive analytics, and seamless workflow automation that scales with your business.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-16">
                    <a href="{{ route('register') }}" class="bg-emerald-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-emerald-700 transition-all duration-200 transform hover:scale-105">
                        Daftar Akaun Percuma
                    </a>
                    <a href="{{ route('login') }}" class="bg-transparent text-white px-8 py-4 rounded-lg text-lg font-semibold border-2 border-emerald-400 hover:bg-emerald-400 hover:text-slate-900 transition-all duration-200">
                        Log Masuk
                    </a>
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-center text-gray-300 space-y-2 sm:space-y-0 sm:space-x-8">
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl font-bold text-emerald-400">5,000+</span>
                        <span>companies trust AssetFlow</span>
                    </div>
                    <div class="hidden sm:block w-1 h-1 bg-gray-500 rounded-full"></div>
                    <div class="flex items-center space-x-2">
                        <span class="text-2xl font-bold text-emerald-400">99.9%</span>
                        <span>uptime guaranteed</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Preview -->
        <section id="features" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold font-display text-slate-900 mb-4">
                        Everything You Need in One Platform
                    </h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                        From real-time tracking to predictive maintenance, AssetFlow provides comprehensive tools to optimize your asset lifecycle management.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Smart Tracking -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 text-center hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 mb-4">Smart Asset Tracking</h3>
                        <p class="text-gray-600">
                            Real-time location tracking with IoT integration, QR codes, and GPS monitoring for complete visibility of your assets.
                        </p>
                    </div>

                    <!-- Predictive Analytics -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 text-center hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 mb-4">Predictive Analytics</h3>
                        <p class="text-gray-600">
                            AI-powered insights predict maintenance needs, optimize utilization, and prevent costly downtime before it happens.
                        </p>
                    </div>

                    <!-- Automated Workflows -->
                    <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 text-center hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-slate-900 mb-4">Automated Workflows</h3>
                        <p class="text-gray-600">
                            Streamline operations with automated check-in/out, maintenance scheduling, and compliance reporting workflows.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dashboard Preview -->
        <section class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold font-display text-slate-900 mb-4">
                        Beautiful, Intuitive Dashboard
                    </h2>
                    <p class="text-xl text-gray-600">
                        Get instant insights with our clean, modern interface designed for efficiency.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-8 shadow-xl border border-gray-200">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Asset Overview -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-slate-900">Asset Overview</h3>
                                <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full">Live Data</span>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-3xl font-bold text-slate-900">2,847</p>
                                        <p class="text-sm text-gray-500">Total Assets</p>
                                    </div>
                                    <span class="text-emerald-600 text-sm font-medium bg-emerald-100 px-2 py-1 rounded">+12.5%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-3xl font-bold text-slate-900">2,654</p>
                                        <p class="text-sm text-gray-500">Active</p>
                                    </div>
                                    <span class="text-emerald-600 text-sm font-medium bg-emerald-100 px-2 py-1 rounded">+8.3%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-3xl font-bold text-slate-900">193</p>
                                        <p class="text-sm text-gray-500">In Maintenance</p>
                                    </div>
                                    <span class="text-amber-600 text-sm font-medium bg-amber-100 px-2 py-1 rounded">-3.2%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Metrics -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-slate-900">Performance</h3>
                                <span class="text-sm text-gray-500">This Month</span>
                            </div>
                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-slate-900">Utilization Rate</p>
                                        <p class="text-sm text-gray-500">Average across all assets</p>
                                    </div>
                                    <span class="bg-emerald-600 text-white px-3 py-1 rounded-full text-sm font-medium">87%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-slate-900">Maintenance Score</p>
                                        <p class="text-sm text-gray-500">Preventive vs reactive</p>
                                    </div>
                                    <span class="bg-emerald-600 text-white px-3 py-1 rounded-full text-sm font-medium">94%</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-slate-900">Cost Efficiency</p>
                                        <p class="text-sm text-gray-500">vs industry average</p>
                                    </div>
                                    <span class="bg-emerald-600 text-white px-3 py-1 rounded-full text-sm font-medium">+23%</span>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="bg-gray-50 rounded-xl p-6">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-lg font-semibold text-slate-900">Recent Activity</h3>
                                <span class="text-sm text-gray-500">Last 24h</span>
                            </div>
                            <div class="space-y-4">
                                <div class="border-l-4 border-emerald-500 pl-4">
                                    <p class="text-sm font-medium text-slate-900">Asset MBP-2024-1247 checked out</p>
                                    <p class="text-xs text-gray-500">Sarah Chen • Engineering • 2 hours ago</p>
                                </div>
                                <div class="border-l-4 border-amber-500 pl-4">
                                    <p class="text-sm font-medium text-slate-900">Maintenance completed on Server Rack #8</p>
                                    <p class="text-xs text-gray-500">Tech Team • Data Center • 4 hours ago</p>
                                </div>
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <p class="text-sm font-medium text-slate-900">15 new assets added to inventory</p>
                                    <p class="text-xs text-gray-500">Admin • Bulk Import • 6 hours ago</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Social Proof -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <p class="text-gray-600 mb-8">Trusted by industry leaders worldwide</p>
                <div class="flex flex-wrap justify-center items-center gap-8 opacity-60">
                    <div class="text-2xl font-bold text-gray-400">Microsoft</div>
                    <div class="text-2xl font-bold text-gray-400">Spotify</div>
                    <div class="text-2xl font-bold text-gray-400">Shopify</div>
                    <div class="text-2xl font-bold text-gray-400">Slack</div>
                    <div class="text-2xl font-bold text-gray-400">Airbnb</div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-gradient-to-r from-emerald-600 to-emerald-700 text-white py-20">
            <div class="max-w-7xl mx-auto px-6 text-center">
                <h2 class="text-4xl font-bold font-display mb-6">
                    Ready to Transform Your Asset Management?
                </h2>
                <p class="text-xl text-emerald-100 mb-8 max-w-2xl mx-auto">
                    Join thousands of companies already using AssetFlow to optimize their operations and reduce costs.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-8">
                    <a href="{{ route('register') }}" class="bg-white text-emerald-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-gray-100 transition-all duration-200 transform hover:scale-105">
                        Daftar Akaun Percuma
                    </a>
                    <a href="{{ route('login') }}" class="bg-transparent text-white px-8 py-4 rounded-lg text-lg font-semibold border-2 border-white hover:bg-white hover:text-emerald-600 transition-all duration-200">
                        Log Masuk
                    </a>
                </div>
                <div class="flex flex-col sm:flex-row items-center justify-center space-y-2 sm:space-y-0 sm:space-x-6 text-sm text-emerald-100">
                    <span>✓ 14-day free trial</span>
                    <span>✓ Setup in under 5 minutes</span>
                    <span>✓ Cancel anytime</span>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-slate-900 text-white py-12">
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <div>
                        <h3 class="text-2xl font-bold font-display mb-4">AssetFlow</h3>
                        <p class="text-gray-400 mb-4">
                            The modern asset management platform that scales with your business.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-emerald-400 transition-colors">LinkedIn</a>
                            <a href="#" class="text-gray-400 hover:text-emerald-400 transition-colors">Twitter</a>
                            <a href="#" class="text-gray-400 hover:text-emerald-400 transition-colors">GitHub</a>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Product</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-emerald-400 transition-colors">Features</a></li>
                            <li><a href="#" class="hover:text-emerald-400 transition-colors">Pricing</a></li>
                            <li><a href="#" class="hover:text-emerald-400 transition-colors">Integrations</a></li>
                            <li><a href="#" class="hover:text-emerald-400 transition-colors">API</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Solutions</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-emerald-400 transition-colors">Enterprise</a></li>
                            <li><a href="#" class="hover:text-emerald-400 transition-colors">Small Business</a></li>
                            <li><a href="#" class="hover:text-emerald-400 transition-colors">Healthcare</a></li>
                            <li><a href="#" class="hover:text-emerald-400 transition-colors">Education</a></li>
                        </ul>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-4">Support</h4>
                        <ul class="space-y-2 text-gray-400">
                            <li><a href="#" class="hover:text-emerald-400 transition-colors">Help Center</a></li>
                            <li><a href="#" class="hover:text-emerald-400 transition-colors">Documentation</a></li>
                            <li><a href="#" class="hover:text-emerald-400 transition-colors">Contact</a></li>
                            <li><a href="#" class="hover:text-emerald-400 transition-colors">Status</a></li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; 2024 AssetFlow. All rights reserved. Built with ❤️ for modern businesses.</p>
                </div>
            </div>
        </footer>
    </body>
</html>
