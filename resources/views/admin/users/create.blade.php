@extends('layouts.admin')

@section('title', 'Tambah Pengguna')
@section('page-title', 'Tambah Pengguna Baru')
@section('page-description', 'Cipta akaun pengguna baru dalam sistem')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Tambah Pengguna Baru</h1>
                <p class="text-emerald-100 text-lg">Cipta akaun pengguna baharu dalam sistem</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-user-plus text-emerald-200'></i>
                        <span class="text-emerald-100">Daftar Pengguna</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-shield-check text-emerald-200'></i>
                        <span class="text-emerald-100">Sistem Selamat</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-user-plus text-6xl text-emerald-200'></i>
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
        <span class="text-emerald-600 font-medium">Tambah Pengguna</span>
    </div>



    <!-- Progress Steps -->
    <div class="mb-8">
        <div class="flex items-center justify-center">
            <div class="flex items-center space-x-4">
                <!-- Step 1 -->
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-semibold">
                        1
                    </div>
                    <span class="ml-2 text-sm font-medium text-emerald-600">Maklumat Peribadi</span>
                </div>
                <div class="w-16 h-1 bg-gray-200 rounded"></div>
                
                <!-- Step 2 -->
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">
                        2
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-500">Peranan & Keselamatan</span>
                </div>
                <div class="w-16 h-1 bg-gray-200 rounded"></div>
                
                <!-- Step 3 -->
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-200 text-gray-500 rounded-full flex items-center justify-center font-semibold">
                        3
                    </div>
                    <span class="ml-2 text-sm font-medium text-gray-500">Semak & Simpan</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Card - Full Width -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-0">
            @csrf

            <!-- Form Header -->
            <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-emerald-50 to-blue-50">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Cipta Akaun Pengguna Baru</h2>
                        <p class="text-sm text-gray-600">Isikan semua maklumat yang diperlukan untuk mencipta akaun pengguna</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        <span class="text-sm text-gray-600">Sistem Online</span>
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
                                <p class="text-sm text-emerald-700">Maklumat asas pengguna</p>
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
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-user text-gray-400'></i>
                                    </div>
                                    <input type="text" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name') }}"
                                           required
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('name') border-red-500 @enderror bg-white"
                                           placeholder="Masukkan nama penuh">
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
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-envelope text-gray-400'></i>
                                    </div>
                                    <input type="email" 
                                           id="email" 
                                           name="email" 
                                           value="{{ old('email') }}"
                                           required
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('email') border-red-500 @enderror bg-white"
                                           placeholder="contoh@email.com">
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
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-phone text-gray-400'></i>
                                    </div>
                                    <input type="text" 
                                           id="phone" 
                                           name="phone" 
                                           value="{{ old('phone') }}"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('phone') border-red-500 @enderror bg-white"
                                           placeholder="010-1234567">
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
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-briefcase text-gray-400'></i>
                                    </div>
                                    <input type="text" 
                                           id="position" 
                                           name="position" 
                                           value="{{ old('position') }}"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('position') border-red-500 @enderror bg-white"
                                           placeholder="Cth: Setiausaha, Bendahari">
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
                                <p class="text-sm text-purple-700">Tetapan akses dan organisasi</p>
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
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-shield text-gray-400'></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class='bx bx-chevron-down text-gray-400'></i>
                                    </div>
                                    <select id="role" 
                                            name="role" 
                                            required
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('role') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Peranan</option>
                                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Pentadbir</option>
                                        <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>Pengguna</option>
                                    </select>
                                </div>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <i class='bx bx-error-circle mr-1'></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-1 text-xs text-purple-600 flex items-center">
                                    <i class='bx bx-info-circle mr-1'></i>
                                    Pentadbir: Akses penuh | Pengguna: Akses terhad
                                </p>
                            </div>

                            <!-- Masjid/Surau -->
                            <div>
                                <label for="masjid_surau_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-building-house mr-1'></i>
                                    Masjid/Surau <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-building-house text-gray-400'></i>
                                    </div>
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                        <i class='bx bx-chevron-down text-gray-400'></i>
                                    </div>
                                    <select id="masjid_surau_id" 
                                            name="masjid_surau_id" 
                                            required
                                            class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('masjid_surau_id') border-red-500 @enderror appearance-none bg-white">
                                        <option value="">Pilih Masjid/Surau</option>
                                        @foreach($masjidSuraus as $masjid)
                                            <option value="{{ $masjid->id }}" {{ old('masjid_surau_id') == $masjid->id ? 'selected' : '' }}>
                                                {{ $masjid->nama }}
                                            </option>
                                        @endforeach
                                    </select>
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

                    <!-- Password Section -->
                    <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                                <i class='bx bx-lock text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Tetapan Keselamatan</h3>
                                <p class="text-sm text-amber-700">Kata laluan dan keselamatan akaun</p>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    <i class='bx bx-lock mr-1'></i>
                                    Kata Laluan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-lock text-gray-400'></i>
                                    </div>
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           required
                                           minlength="8"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 @error('password') border-red-500 @enderror bg-white"
                                           placeholder="Minimum 8 aksara">
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
                                    Sahkan Kata Laluan <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class='bx bx-lock-alt text-gray-400'></i>
                                    </div>
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           required
                                           minlength="8"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 bg-white"
                                           placeholder="Sahkan kata laluan">
                                </div>
                            </div>
                        </div>

                        <!-- Email Verification Option -->
                        <div class="bg-white rounded-lg p-4 border border-gray-200 mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="email_verified_at" value="1" 
                                       class="w-4 h-4 text-emerald-600 border-gray-300 rounded focus:ring-emerald-500">
                                <div class="ml-3">
                                    <span class="text-sm font-medium text-gray-700">Sahkan email secara automatik</span>
                                    <p class="text-xs text-gray-500">Pengguna boleh log masuk terus tanpa perlu sahkan email</p>
                                </div>
                            </label>
                        </div>

                        <!-- Security Notice -->
                        <div class="p-4 bg-emerald-50 rounded-lg border border-emerald-200">
                            <div class="flex">
                                <i class='bx bx-shield-check text-emerald-600 text-lg mt-0.5'></i>
                                <div class="ml-3">
                                    <p class="text-sm text-emerald-800">
                                        <strong>Nota Keselamatan:</strong> Pastikan kata laluan yang kuat dan beritahu pengguna untuk mengubah kata laluan mereka selepas log masuk pertama.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Preview & Summary -->
                <div class="lg:col-span-1">
                    <div class="sticky top-6 space-y-6">
                        
                        <!-- Preview Card -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-xl p-6 border border-blue-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-user text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Pratonton Pengguna</h3>
                            </div>
                            
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                        <span class="text-emerald-700 font-medium">?</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Nama Pengguna</p>
                                        <p class="text-sm text-gray-500">email@example.com</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Telefon:</span>
                                        <span class="text-sm font-medium">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Jawatan:</span>
                                        <span class="text-sm font-medium">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Peranan:</span>
                                        <span class="text-sm font-medium">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Progress Card -->
                        <div class="bg-white rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-gray-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-file text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Kemajuan Borang</h3>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Maklumat Peribadi</span>
                                    <div class="flex items-center">
                                        <i class='bx bx-check text-green-500'></i>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Peranan & Organisasi</span>
                                    <div class="flex items-center">
                                        <i class='bx bx-check text-green-500'></i>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span class="text-sm text-gray-600">Kata Laluan</span>
                                    <div class="flex items-center">
                                        <i class='bx bx-check text-green-500'></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Tips -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-6 border border-green-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                                    <i class='bx bx-bulb text-white'></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Tips Berguna</h3>
                            </div>
                            
                            <ul class="space-y-2 text-sm text-green-800">
                                <li class="flex items-start">
                                    <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                    Gunakan kata laluan yang kuat (min. 8 aksara)
                                </li>
                                <li class="flex items-start">
                                    <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                    Pastikan alamat email adalah betul
                                </li>
                                <li class="flex items-start">
                                    <i class='bx bx-check mr-2 text-green-600 mt-0.5'></i>
                                    Pilih peranan yang sesuai untuk pengguna
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Footer -->
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
                    <div class="flex items-center text-sm text-gray-500">
                        <i class='bx bx-info-circle mr-1'></i>
                        Semua medan bertanda (*) adalah wajib diisi
                    </div>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.users.index') }}" 
                           class="px-6 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                            <i class='bx bx-x mr-2'></i>
                            Batal
                        </a>
                        <button type="submit" 
                                class="px-8 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                            <i class='bx bx-plus mr-2'></i>
                            Cipta Pengguna
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Password strength and validation
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const confirmPassword = document.getElementById('password_confirmation');
        
        if (password.length < 8) {
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