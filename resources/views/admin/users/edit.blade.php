@extends('layouts.admin')

@section('title', 'Edit Pengguna')
@section('page-title', 'Edit Pengguna')
@section('page-description', 'Kemaskini maklumat pengguna')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Edit Pengguna</h1>
                <p class="text-emerald-100 text-lg">Kemaskini maklumat untuk {{ $user->name }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-edit text-emerald-200'></i>
                        <span class="text-emerald-100">Kemaskini Data</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 {{ $user->email_verified_at ? 'bg-green-400' : 'bg-red-400' }} rounded-full"></div>
                        <span class="text-emerald-100">{{ $user->email_verified_at ? 'Aktif' : 'Tidak Aktif' }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-edit-alt text-6xl text-emerald-200'></i>
            </div>
        </div>
    </div>

    <!-- Navigation Breadcrumb -->
    <div class="flex items-center space-x-2 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600">
            <i class='bx bx-home'></i>
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Pengguna
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">Edit: {{ $user->name }}</span>
    </div>



    <!-- Form Card - Full Width -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" x-data="editUserForm()" class="space-y-0">
            @csrf
            @method('PUT')

            <!-- Form Header -->
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Kemaskini Maklumat Pengguna</h2>
                        <p class="text-sm text-gray-600">Edit dan kemaskini maklumat pengguna dalam sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            <div class="w-2 h-2 {{ $user->email_verified_at ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-2"></div>
                            {{ $user->email_verified_at ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                        <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-emerald-100 text-emerald-800' }}">
                            {{ $user->role === 'admin' ? 'Pentadbir' : 'Pengguna' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Form Content - Two Column Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-6">
                
                <!-- Left Column - Main Form -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Personal Information Section -->
                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-user text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Maklumat Peribadi</h3>
                                <p class="text-sm text-emerald-700">Kemaskini maklumat asas pengguna</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-user mr-1'></i>
                                    Nama Penuh <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $user->name) }}"
                                           required
                                           x-model="form.name"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror bg-white"
                                           placeholder="Masukkan nama penuh">
                                    <i class='bx bx-user absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-envelope mr-1'></i>
                                    Alamat E-mel <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email', $user->email) }}"
                                           required
                                           x-model="form.email"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('email') border-red-500 @enderror bg-white"
                                           placeholder="contoh@email.com">
                                    <i class='bx bx-envelope absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-phone mr-1'></i>
                                    Nombor Telefon
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone', $user->phone) }}"
                                           x-model="form.phone"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('phone') border-red-500 @enderror bg-white"
                                           placeholder="010-1234567">
                                    <i class='bx bx-phone absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Position -->
                            <div>
                                <label for="position" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-briefcase mr-1'></i>
                                    Jawatan
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="position" 
                                           name="position" 
                                           value="{{ old('position', $user->position) }}"
                                           x-model="form.position"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('position') border-red-500 @enderror bg-white"
                                           placeholder="Cth: Setiausaha, Bendahari">
                                    <i class='bx bx-briefcase absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('position')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Role and Organization Section -->
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-shield text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Peranan & Organisasi</h3>
                                <p class="text-sm text-purple-700">Kemaskini peranan dan organisasi</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Role -->
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-shield mr-1'></i>
                                    Peranan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="role" 
                                            name="role" 
                                            required
                                            x-model="form.role"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('role') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Peranan</option>
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Pentadbir</option>
                                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Pengguna</option>
                                    </select>
                                    <i class='bx bx-shield absolute left-3 top-3.5 text-gray-400'></i>
                                    <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                @if($user->role === 'admin' && \App\Models\User::where('role', 'admin')->count() <= 1)
                                    <p class="mt-1 text-xs text-amber-600 flex items-center">
                                        <i class='bx bx-warning mr-1'></i>
                                        Ini adalah pentadbir terakhir dalam sistem
                                    </p>
                                @endif
                            </div>

                            <!-- Masjid/Surau -->
                            <div>
                                <label for="masjid_surau_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-building mr-1'></i>
                                    Masjid/Surau <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="masjid_surau_id" 
                                            name="masjid_surau_id" 
                                            required
                                            x-model="form.masjid_surau_id"
                                            class="w-full pl-10 pr-8 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('masjid_surau_id') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Masjid/Surau</option>
                                        @foreach($masjidSuraus as $masjid)
                                            <option value="{{ $masjid->id }}" {{ old('masjid_surau_id', $user->masjid_surau_id) == $masjid->id ? 'selected' : '' }}>
                                                {{ $masjid->nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <i class='bx bx-building absolute left-3 top-3.5 text-gray-400'></i>
                                    <i class='bx bx-chevron-down absolute right-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('masjid_surau_id')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Account Status Section -->
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-shield-check text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Status Akaun</h3>
                                <p class="text-sm text-blue-700">Kemaskini status dan maklumat akaun</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Email Verification Status -->
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <label class="flex items-center">
                                    <input type="checkbox" name="email_verified_at" value="1" 
                                           {{ $user->email_verified_at ? 'checked' : '' }}
                                           x-model="form.email_verified_at"
                                           class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                                    <div class="ml-3">
                                        <span class="text-sm font-medium text-gray-700">Email disahkan</span>
                                        <p class="text-xs text-gray-500">
                                            @if($user->email_verified_at)
                                                Disahkan pada {{ $user->email_verified_at->format('d/m/Y H:i') }}
                                            @else
                                                Email belum disahkan
                                            @endif
                                        </p>
                                    </div>
                                </label>
                            </div>

                            <!-- Account Created -->
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center mb-2">
                                    <i class='bx bx-calendar text-blue-600 mr-2'></i>
                                    <span class="text-sm font-medium text-gray-700">Akaun Dicipta</span>
                                </div>
                                <p class="text-sm text-gray-600">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                                <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Password Section -->
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-lock text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Tukar Kata Laluan</h3>
                                <p class="text-sm text-amber-700">Biarkan kosong jika tidak mahu mengubah kata laluan</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-lock mr-1'></i>
                                    Kata Laluan Baru
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           id="password" 
                                           name="password"
                                           minlength="8"
                                           x-model="form.password"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('password') border-red-500 @enderror bg-white"
                                           placeholder="Minimum 8 aksara">
                                    <i class='bx bx-lock absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-lock-alt mr-1'></i>
                                    Sahkan Kata Laluan
                                </label>
                                <div class="relative">
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation"
                                           minlength="8"
                                           x-model="form.password_confirmation"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white"
                                           placeholder="Sahkan kata laluan">
                                    <i class='bx bx-lock-alt absolute left-3 top-3.5 text-gray-400'></i>
                                </div>
                            </div>
                        </div>

                        <!-- Password Notice -->
                        <div class="mt-4 p-4 bg-emerald-50 rounded-lg border border-emerald-200">
                            <div class="flex">
                                <i class='bx bx-info-circle text-emerald-600 text-lg mt-0.5'></i>
                                <div class="ml-3">
                                    <p class="text-sm text-emerald-800">
                                        <strong>Nota:</strong> Jika anda mengubah kata laluan, pastikan memberitahu pengguna tentang kata laluan baru mereka.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Preview & Info -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        
                        <!-- Current User Preview -->
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-100 rounded-xl p-6 border border-indigo-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-indigo-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-user text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Pratonton Pengguna</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                        <span class="text-emerald-700 font-medium" x-text="form.name ? form.name.charAt(0).toUpperCase() : '{{ substr($user->name, 0, 1) }}'">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900" x-text="form.name || '{{ $user->name }}'">{{ $user->name }}</p>
                                        <p class="text-sm text-gray-500" x-text="form.email || '{{ $user->email }}'">{{ $user->email }}</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Telefon:</span>
                                        <span class="text-sm font-medium" x-text="form.phone || '{{ $user->phone ?: '-' }}'">{{ $user->phone ?: '-' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Jawatan:</span>
                                        <span class="text-sm font-medium" x-text="form.position || '{{ $user->position ?: '-' }}'">{{ $user->position ?: '-' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Peranan:</span>
                                        <span class="text-sm font-medium" x-text="form.role || '{{ $user->role }}'">{{ $user->role }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Activity Summary -->
                        <div class="bg-white rounded-xl p-6 border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Aktiviti</h3>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Status Akaun:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $user->email_verified_at ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        <div class="w-2 h-2 {{ $user->email_verified_at ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-1"></div>
                                        {{ $user->email_verified_at ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Peranan:</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-emerald-100 text-emerald-800' }}">
                                        {{ $user->role === 'admin' ? 'Pentadbir' : 'Pengguna' }}
                                    </span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Dicipta:</span>
                                    <span class="text-sm font-medium">{{ $user->created_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-6 border border-green-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-cog text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Tindakan Pantas</h3>
                            </div>
                            
                            <div class="space-y-3">
                                <a href="{{ route('admin.users.show', $user) }}" 
                                   class="w-full flex items-center justify-center px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg transition-colors">
                                    <i class='bx bx-show mr-2'></i>
                                    Lihat Detail
                                </a>
                                
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full flex items-center justify-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 rounded-lg transition-colors">
                                        <i class='bx {{ $user->email_verified_at ? 'bx-toggle-left' : 'bx-toggle-right' }} mr-2'></i>
                                        {{ $user->email_verified_at ? 'Nyahaktifkan' : 'Aktifkan' }}
                                    </button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class='bx bx-info-circle mr-1'></i>
                        Kemaskini terakhir: {{ $user->updated_at->format('d/m/Y H:i') }}
                    </div>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.users.index') }}" 
                           class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                            <i class='bx bx-x mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-8 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                            <i class='bx bx-save mr-2'></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function editUserForm() {
        return {
            form: {
                name: '{{ old('name', $user->name) }}',
                email: '{{ old('email', $user->email) }}',
                phone: '{{ old('phone', $user->phone) }}',
                position: '{{ old('position', $user->position) }}',
                role: '{{ old('role', $user->role) }}',
                masjid_surau_id: '{{ old('masjid_surau_id', $user->masjid_surau_id) }}',
                password: '',
                password_confirmation: '',
                email_verified_at: {{ $user->email_verified_at ? 'true' : 'false' }}
            }
        }
    }

    // Password validation
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const confirmPassword = document.getElementById('password_confirmation');
        
        if (password.length > 0 && password.length < 8) {
            this.setCustomValidity('Kata laluan mestilah sekurang-kurangnya 8 aksara');
        } else {
            this.setCustomValidity('');
        }
        
        if (confirmPassword.value && password !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Kata laluan tidak sepadan');
        } else {
            confirmPassword.setCustomValidity('');
        }
    });

    document.getElementById('password_confirmation').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        
        if (this.value && password !== this.value) {
            this.setCustomValidity('Kata laluan tidak sepadan');
        } else {
            this.setCustomValidity('');
        }
    });
</script>
@endpush
@endsection 