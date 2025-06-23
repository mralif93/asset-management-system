@extends('layouts.user')

@section('title', 'User Dashboard')
@section('page-title', 'User Dashboard')

@section('content')
<div class="p-6">
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="bg-emerald-600 rounded-2xl p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Welcome, {{ Auth::user()->name }}!</h1>
                    <p class="text-emerald-100 text-lg">Masjid & Surau Asset Management System</p>
                </div>
                <div class="hidden md:block">
                    <i class='bx bx-user-check text-6xl text-emerald-200'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- User Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Profile Completion -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-user text-emerald-600 text-xl'></i>
                </div>
                <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium">Active</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ Auth::user()->role === 'user' ? '100' : '90' }}%</h3>
            <p class="text-sm text-gray-600">Profile Complete</p>
        </div>

        <!-- Account Status -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-shield-check text-green-600 text-xl'></i>
                </div>
                <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">Verified</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Active</h3>
            <p class="text-sm text-gray-600">Account Status</p>
        </div>

        <!-- User Role -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-id-card text-blue-600 text-xl'></i>
                </div>
                <span class="text-sm text-blue-600 bg-blue-100 px-2 py-1 rounded-full font-medium">{{ ucfirst(Auth::user()->role) }}</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ ucfirst(Auth::user()->role) }}</h3>
            <p class="text-sm text-gray-600">Role</p>
        </div>

        <!-- Last Login -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-time text-purple-600 text-xl'></i>
                </div>
                <span class="text-sm text-purple-600 bg-purple-100 px-2 py-1 rounded-full font-medium">Online</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">Today</h3>
            <p class="text-sm text-gray-600">Last Login</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Update Profile -->
                        <a href="{{ route('user.profile.edit') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                    <i class='bx bx-edit text-emerald-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-emerald-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Update Profile</h3>
            <p class="text-sm text-gray-600">Change your personal information</p>
        </a>

        <!-- Contact Admin -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <i class='bx bx-support text-blue-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-blue-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Contact Support</h3>
            <p class="text-sm text-gray-600">Help and technical support</p>
        </div>

        <!-- System Info -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <i class='bx bx-info-circle text-purple-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-purple-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">System Information</h3>
            <p class="text-sm text-gray-600">System guide and FAQ</p>
        </div>

        <!-- Security -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                    <i class='bx bx-lock text-amber-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-amber-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Security</h3>
            <p class="text-sm text-gray-600">Change password & security</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- User Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">User Information</h2>
                        <a href="{{ route('user.profile.edit') }}" class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                            Update
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-user text-emerald-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900 font-medium">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 mt-1">Full Name</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-envelope text-blue-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900 font-medium">{{ Auth::user()->email }}</p>
                                <p class="text-xs text-gray-500 mt-1">Email Address</p>
                            </div>
                        </div>
                        
                        @if(Auth::user()->phone)
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-phone text-green-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900 font-medium">{{ Auth::user()->phone }}</p>
                                <p class="text-xs text-gray-500 mt-1">Phone Number</p>
                            </div>
                        </div>
                        @endif
                        
                        @if(Auth::user()->position)
                        <div class="flex items-start space-x-3">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-briefcase text-purple-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-gray-900 font-medium">{{ Auth::user()->position }}</p>
                                <p class="text-xs text-gray-500 mt-1">Position</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats Sidebar -->
        <div class="space-y-6">
            <!-- Account Health -->
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Account Status</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">Active Account</span>
                            </div>
                            <span class="text-sm font-medium text-green-600">✓</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">Email Verified</span>
                            </div>
                            <span class="text-sm font-medium text-blue-600">✓</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                                <span class="text-sm text-gray-700">Profile Complete</span>
                            </div>
                            <span class="text-sm font-medium text-emerald-600">✓</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-white rounded-xl border border-gray-200">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Quick Links</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <a href="{{ route('user.profile.edit') }}" class="flex items-center space-x-3 text-sm text-gray-700 hover:text-emerald-600 transition-colors">
                            <i class='bx bx-edit text-gray-400'></i>
                            <span>Edit Profile</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 text-sm text-gray-700 hover:text-emerald-600 transition-colors">
                            <i class='bx bx-lock text-gray-400'></i>
                            <span>Change Password</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 text-sm text-gray-700 hover:text-emerald-600 transition-colors">
                            <i class='bx bx-help-circle text-gray-400'></i>
                            <span>Help & Support</span>
                        </a>
                        <a href="#" class="flex items-center space-x-3 text-sm text-gray-700 hover:text-emerald-600 transition-colors">
                            <i class='bx bx-log-out text-gray-400'></i>
                            <span>Logout</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 