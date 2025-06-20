@extends('layouts.admin')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Profil Saya</h1>
                <p class="text-emerald-100 text-lg">Kemaskini maklumat peribadi anda</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-user-circle text-emerald-200'></i>
                        <span class="text-emerald-100">{{ auth()->user()->role === 'admin' ? 'Pentadbir' : 'Pengguna' }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 {{ auth()->user()->email_verified_at ? 'bg-green-400' : 'bg-red-400' }} rounded-full"></div>
                        <span class="text-emerald-100">{{ auth()->user()->email_verified_at ? 'Aktif' : 'Tidak Aktif' }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-calendar text-emerald-200'></i>
                        <span class="text-emerald-100">Ahli sejak {{ auth()->user()->created_at->format('M Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-emerald-500 rounded-2xl flex items-center justify-center text-3xl font-bold text-white shadow-xl">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <div class="mb-6">
        <nav class="flex items-center space-x-2 text-sm text-gray-600">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 transition-colors">
                <i class='bx bx-home text-lg'></i>
            </a>
            <i class='bx bx-chevron-right text-gray-400'></i>
            <span class="text-emerald-600 font-medium">Profil Saya</span>
        </nav>
    </div>

    <!-- Success Messages -->
    @if (session('status') === 'profile-updated')
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class='bx bx-check-circle text-green-600 text-xl mr-3'></i>
                <div>
                    <h4 class="text-green-800 font-medium">Profil Dikemaskini</h4>
                    <p class="text-green-700 text-sm">Maklumat profil anda telah berjaya dikemaskini.</p>
                </div>
            </div>
        </div>
    @endif

    @if (session('status') === 'password-updated')
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class='bx bx-check-circle text-blue-600 text-xl mr-3'></i>
                <div>
                    <h4 class="text-blue-800 font-medium">Kata Laluan Dikemaskini</h4>
                    <p class="text-blue-700 text-sm">Kata laluan anda telah berjaya ditukar.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Profile Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <i class='bx bx-edit text-emerald-600 text-lg'></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Kemaskini Maklumat</h2>
                            <p class="text-sm text-gray-600">Edit maklumat peribadi dan akaun anda</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('profile.update') }}" class="p-6 space-y-6">
                    @csrf
                    @method('patch')

                    <!-- Basic Information Section -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Maklumat Asas</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Penuh *
                                </label>
                                <div class="relative">
                                    <input type="text" name="name" id="name" required
                                           value="{{ old('name', $user->name) }}"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror"
                                           placeholder="Masukkan nama penuh anda">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                        <i class='bx bx-user text-gray-400'></i>
                                    </div>
                                </div>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    Alamat Email *
                                </label>
                                <div class="relative">
                                    <input type="email" name="email" id="email" required
                                           value="{{ old('email', $user->email) }}"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('email') border-red-500 @enderror"
                                           placeholder="alamat@email.com">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                        <i class='bx bx-envelope text-gray-400'></i>
                                    </div>
                                </div>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombor Telefon
                                </label>
                                <div class="relative">
                                    <input type="text" name="phone" id="phone"
                                           value="{{ old('phone', $user->phone) }}"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('phone') border-red-500 @enderror"
                                           placeholder="Contoh: 012-3456789">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                        <i class='bx bx-phone text-gray-400'></i>
                                    </div>
                                </div>
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Position -->
                            <div>
                                <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jawatan
                                </label>
                                <div class="relative">
                                    <input type="text" name="position" id="position"
                                           value="{{ old('position', $user->position) }}"
                                           class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('position') border-red-500 @enderror"
                                           placeholder="Contoh: Pengurus Sistem">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                        <i class='bx bx-briefcase text-gray-400'></i>
                                    </div>
                                </div>
                                @error('position')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Masjid/Surau Information -->
                    @if($user->masjidSurau)
                    <div class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b border-gray-200 pb-2">Maklumat Organisasi</h3>
                        
                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                                    <i class='bx bx-buildings text-emerald-600 text-xl'></i>
                                </div>
                                <div>
                                    <h4 class="text-lg font-semibold text-gray-900">{{ $user->masjidSurau->nama }}</h4>
                                    <p class="text-sm text-gray-600">{{ $user->masjidSurau->jenis }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->masjidSurau->daerah }}, {{ $user->masjidSurau->negeri }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Form Actions -->
                    <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                        <div class="text-sm text-gray-600">
                            <span class="text-red-500">*</span> Medan wajib diisi
                        </div>
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('admin.dashboard') }}" 
                               class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                                <i class='bx bx-x mr-2'></i>
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                                <i class='bx bx-save mr-2'></i>
                                Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Password Update Section -->
            <div id="password-section" class="bg-white rounded-xl border border-gray-200 shadow-sm mt-8">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class='bx bx-lock text-blue-600 text-lg'></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Tukar Kata Laluan</h2>
                            <p class="text-sm text-gray-600">Pastikan akaun anda menggunakan kata laluan yang kuat</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('password.update') }}" class="p-6 space-y-6">
                    @csrf
                    @method('put')

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">
                                Kata Laluan Semasa *
                            </label>
                            <div class="relative">
                                <input type="password" name="current_password" id="current_password" required
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('current_password', 'updatePassword') border-red-500 @enderror"
                                       placeholder="Masukkan kata laluan semasa">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <i class='bx bx-lock text-gray-400'></i>
                                </div>
                            </div>
                            @error('current_password', 'updatePassword')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Kata Laluan Baharu *
                            </label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password', 'updatePassword') border-red-500 @enderror"
                                       placeholder="Masukkan kata laluan baharu">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <i class='bx bx-key text-gray-400'></i>
                                </div>
                            </div>
                            @error('password', 'updatePassword')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 aksara dengan kombinasi huruf dan nombor</p>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Sahkan Kata Laluan Baharu *
                            </label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password_confirmation', 'updatePassword') border-red-500 @enderror"
                                       placeholder="Sahkan kata laluan baharu">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <i class='bx bx-check text-gray-400'></i>
                                </div>
                            </div>
                            @error('password_confirmation', 'updatePassword')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Password Form Actions -->
                    <div class="flex items-center justify-end pt-6 border-t border-gray-200">
                        <button type="submit" 
                                class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                            <i class='bx bx-shield mr-2'></i>
                            Tukar Kata Laluan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="space-y-6">
            <!-- Profile Summary -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Ringkasan Profil</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="text-center">
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <span class="text-2xl font-bold text-emerald-600">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <h4 class="font-semibold text-gray-900">{{ $user->name }}</h4>
                        <p class="text-sm text-gray-600">{{ $user->role === 'admin' ? 'Pentadbir Sistem' : 'Pengguna' }}</p>
                        @if($user->position)
                        <p class="text-xs text-gray-500">{{ $user->position }}</p>
                        @endif
                    </div>
                    
                    <div class="space-y-3 text-sm border-t border-gray-200 pt-4">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-envelope text-gray-400'></i>
                            <span class="truncate">{{ $user->email }}</span>
                        </div>
                        @if($user->phone)
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-phone text-gray-400'></i>
                            <span>{{ $user->phone }}</span>
                        </div>
                        @endif
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-calendar text-gray-400'></i>
                            <span>Ahli sejak {{ $user->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Security -->
            <div class="bg-blue-50 rounded-xl border border-blue-200 p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-shield text-blue-600 text-lg'></i>
                    </div>
                    <h3 class="font-semibold text-blue-900">Keselamatan Akaun</h3>
                </div>
                <div class="space-y-3 text-sm text-blue-800">
                    <div class="flex items-center justify-between">
                        <span>Status Email:</span>
                        <span class="font-medium {{ $user->email_verified_at ? 'text-green-700' : 'text-red-700' }}">
                            {{ $user->email_verified_at ? 'Disahkan' : 'Belum Disahkan' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Log Masuk Terakhir:</span>
                        <span class="font-medium">{{ $user->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span>Tahap Akses:</span>
                        <span class="font-medium">{{ $user->role === 'admin' ? 'Pentadbir' : 'Pengguna' }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-emerald-50 rounded-xl border border-emerald-200 p-6">
                <h3 class="text-lg font-semibold text-emerald-900 mb-4">Tindakan Pantas</h3>
                <div class="space-y-3">
                    <a href="#password-section" 
                       class="flex items-center space-x-3 w-full px-4 py-3 bg-white hover:bg-emerald-50 border border-emerald-200 rounded-lg transition-colors">
                        <i class='bx bx-lock text-emerald-600'></i>
                        <span class="text-emerald-700 font-medium">Tukar Kata Laluan</span>
                    </a>
                    
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center space-x-3 w-full px-4 py-3 bg-white hover:bg-emerald-50 border border-emerald-200 rounded-lg transition-colors">
                        <i class='bx bx-home text-emerald-600'></i>
                        <span class="text-emerald-700 font-medium">Kembali ke Dashboard</span>
                    </a>
                </div>
            </div>

            <!-- Tips -->
            <div class="bg-amber-50 rounded-xl border border-amber-200 p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-lightbulb text-amber-600 text-lg'></i>
                    </div>
                    <h3 class="font-semibold text-amber-900">Tips Keselamatan</h3>
                </div>
                <ul class="space-y-2 text-sm text-amber-800">
                    <li class="flex items-start space-x-2">
                        <i class='bx bx-check text-amber-600 mt-0.5'></i>
                        <span>Gunakan kata laluan yang kuat</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <i class='bx bx-check text-amber-600 mt-0.5'></i>
                        <span>Jangan berkongsi maklumat log masuk</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <i class='bx bx-check text-amber-600 mt-0.5'></i>
                        <span>Log keluar selepas selesai</span>
                    </li>
                    <li class="flex items-start space-x-2">
                        <i class='bx bx-check text-amber-600 mt-0.5'></i>
                        <span>Kemaskini profil secara berkala</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection 