@extends('layouts.admin')

@section('title', 'Pengurusan Aset')
@section('page-title', 'Pengurusan Aset')
@section('page-description', 'Urus semua aset dalam sistem')

@section('content')
    <div class="p-6">
        <!-- Welcome Header -->
        <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Pengurusan Aset</h1>
                    <p class="text-emerald-100 text-lg">Urus dan pantau semua aset dalam sistem</p>
                    <div class="flex items-center space-x-4 mt-4">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-package text-emerald-200'></i>
                            <span class="text-emerald-100">{{ $assets->total() }} aset</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-shield-check text-emerald-200'></i>
                            <span class="text-emerald-100">Sistem Aktif</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <i class='bx bx-package text-6xl text-emerald-200'></i>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Assets -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-package text-emerald-600 text-xl'></i>
                    </div>
                    <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium">+12.3%</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $assets->total() }}</h3>
                <p class="text-sm text-gray-600">Jumlah Aset</p>
            </div>

            <!-- Active Assets -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-check-circle text-green-600 text-xl'></i>
                    </div>
                    <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">Aktif</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">
                    {{ $assets->where('status_aset', 'Sedang Digunakan')->count() }}
                </h3>
                <p class="text-sm text-gray-600">Sedang Digunakan</p>
            </div>

            <!-- Maintenance Assets -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-wrench text-yellow-600 text-xl'></i>
                    </div>
                    <span class="text-sm text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full font-medium">+5.2%</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">
                    {{ $assets->where('status_aset', 'Dalam Penyelenggaraan')->count() }}
                </h3>
                <p class="text-sm text-gray-600">Dalam Penyelenggaraan</p>
            </div>

            <!-- Total Value -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-dollar text-purple-600 text-xl'></i>
                    </div>
                    <span class="text-sm text-purple-600 bg-purple-100 px-2 py-1 rounded-full font-medium">RM</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($assets->sum('nilai_perolehan'), 2) }}
                </h3>
                <p class="text-sm text-gray-600">Jumlah Nilai</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Add Asset -->
            <a href="{{ route('admin.assets.create') }}"
                class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                        <i class='bx bx-plus text-emerald-600 text-xl'></i>
                    </div>
                    <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-emerald-600 transition-colors'></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Tambah Aset</h3>
                <p class="text-sm text-gray-600">Daftar aset baharu</p>
            </a>

            <!-- Export Assets -->
            <a href="{{ route('admin.assets.export', request()->query()) }}"
                onclick="openExportConfirm(event, this.href, 'Adakah anda pasti mahu eksport data aset?')"
                class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <i class='bx bx-download text-blue-600 text-xl'></i>
                    </div>
                    <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-blue-600 transition-colors'></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Eksport Data</h3>
                <p class="text-sm text-gray-600">Muat turun senarai aset</p>
            </a>

            <!-- Asset Reports -->
            <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                        <i class='bx bx-bar-chart text-purple-600 text-xl'></i>
                    </div>
                    <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-purple-600 transition-colors'></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Laporan Aset</h3>
                <p class="text-sm text-gray-600">Analitik dan statistik</p>
            </div>

            <!-- Import Assets -->
            <a href="{{ route('admin.assets.import') }}"
                class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                        <i class='bx bx-cloud-upload text-amber-600 text-xl'></i>
                    </div>
                    <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-amber-600 transition-colors'></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Import Data</h3>
                <p class="text-sm text-gray-600">Muat naik senarai aset (Excel/CSV)</p>
            </a>
        </div>

        <!-- Search and Filters Card -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Penapis & Carian</h2>
                    <p class="text-sm text-gray-600">Gunakan penapis untuk mencari aset tertentu</p>
                </div>
                <i class='bx bx-filter-alt text-2xl text-gray-400'></i>
            </div>

            <form method="GET" action="{{ route('admin.assets.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                        <div class="relative">
                            <input type="text" id="search" name="search" value="{{ request('search') }}"
                                placeholder="Nama aset atau no. siri..."
                                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <i class='bx bx-search absolute left-3 top-2.5 text-gray-400'></i>
                        </div>
                    </div>

                    <!-- Asset Type Filter -->
                    <div>
                        <label for="jenis_aset" class="block text-sm font-medium text-gray-700 mb-2">Jenis Aset</label>
                        <select id="jenis_aset" name="jenis_aset"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Semua Jenis</option>
                            @foreach($assetTypes as $type)
                                <option value="{{ $type }}" {{ request('jenis_aset') === $type ? 'selected' : '' }}>{{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Type of Asset Filter -->
                    <div>
                        <label for="kategori_aset" class="block text-sm font-medium text-gray-700 mb-2">Kategori
                            Aset</label>
                        <select id="kategori_aset" name="kategori_aset"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Semua Kategori</option>
                            <option value="asset" {{ request('kategori_aset') === 'asset' ? 'selected' : '' }}>Asset</option>
                            <option value="non-asset" {{ request('kategori_aset') === 'non-asset' ? 'selected' : '' }}>
                                Non-Asset</option>
                        </select>
                    </div>

                    <!-- Location Filter -->
                    <div>
                        <label for="lokasi_penempatan" class="block text-sm font-medium text-gray-700 mb-2">Lokasi
                            Penempatan</label>
                        <select id="lokasi_penempatan" name="lokasi_penempatan"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Semua Lokasi</option>
                            <option value="Anjung kiri" {{ request('lokasi_penempatan') === 'Anjung kiri' ? 'selected' : '' }}>Anjung kiri</option>
                            <option value="Anjung kanan" {{ request('lokasi_penempatan') === 'Anjung kanan' ? 'selected' : '' }}>Anjung kanan</option>
                            <option value="Anjung Depan(Ruang Pengantin)" {{ request('lokasi_penempatan') === 'Anjung Depan(Ruang Pengantin)' ? 'selected' : '' }}>Anjung Depan(Ruang Pengantin)</option>
                            <option value="Ruang Utama (tingkat atas, tingkat bawah)" {{ request('lokasi_penempatan') === 'Ruang Utama (tingkat atas, tingkat bawah)' ? 'selected' : '' }}>Ruang Utama (tingkat atas, tingkat bawah)</option>
                            <option value="Bilik Mesyuarat" {{ request('lokasi_penempatan') === 'Bilik Mesyuarat' ? 'selected' : '' }}>Bilik Mesyuarat</option>
                            <option value="Bilik Kuliah" {{ request('lokasi_penempatan') === 'Bilik Kuliah' ? 'selected' : '' }}>Bilik Kuliah</option>
                            <option value="Bilik Bendahari" {{ request('lokasi_penempatan') === 'Bilik Bendahari' ? 'selected' : '' }}>Bilik Bendahari</option>
                            <option value="Bilik Setiausaha" {{ request('lokasi_penempatan') === 'Bilik Setiausaha' ? 'selected' : '' }}>Bilik Setiausaha</option>
                            <option value="Bilik Nazir & Imam" {{ request('lokasi_penempatan') === 'Bilik Nazir & Imam' ? 'selected' : '' }}>Bilik Nazir & Imam</option>
                            <option value="Bangunan Jenazah" {{ request('lokasi_penempatan') === 'Bangunan Jenazah' ? 'selected' : '' }}>Bangunan Jenazah</option>
                            <option value="Lain-lain" {{ request('lokasi_penempatan') === 'Lain-lain' ? 'selected' : '' }}>
                                Lain-lain</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="status" name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Semua Status</option>
                            <option value="Aktif" {{ request('status') === 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Sedang Digunakan" {{ request('status') === 'Sedang Digunakan' ? 'selected' : '' }}>
                                Sedang Digunakan</option>
                            <option value="Dalam Penyelenggaraan" {{ request('status') === 'Dalam Penyelenggaraan' ? 'selected' : '' }}>Dalam Penyelenggaraan</option>
                            <option value="Baru" {{ request('status') === 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Rosak" {{ request('status') === 'Rosak' ? 'selected' : '' }}>Rosak</option>
                        </select>
                    </div>

                    <!-- Physical Condition Filter -->
                    <div>
                        <label for="keadaan_fizikal" class="block text-sm font-medium text-gray-700 mb-2">Keadaan
                            Fizikal</label>
                        <select id="keadaan_fizikal" name="keadaan_fizikal"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Semua Keadaan</option>
                            <option value="Cemerlang" {{ request('keadaan_fizikal') === 'Cemerlang' ? 'selected' : '' }}>
                                Cemerlang</option>
                            <option value="Baik" {{ request('keadaan_fizikal') === 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Sederhana" {{ request('keadaan_fizikal') === 'Sederhana' ? 'selected' : '' }}>
                                Sederhana</option>
                            <option value="Rosak" {{ request('keadaan_fizikal') === 'Rosak' ? 'selected' : '' }}>Rosak
                            </option>
                            <option value="Tidak Boleh Digunakan" {{ request('keadaan_fizikal') === 'Tidak Boleh Digunakan' ? 'selected' : '' }}>Tidak Boleh Digunakan</option>
                        </select>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors flex items-center">
                            <i class='bx bx-search mr-2'></i>
                            Cari
                        </button>
                        <a href="{{ route('admin.assets.index') }}"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Assets Table Card -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <!-- Table Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Senarai Aset</h2>
                        <p class="text-sm text-gray-600">Urus dan pantau semua aset sistem</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="text-sm text-gray-500">{{ $assets->total() }} aset</span>
                        <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                    </div>
                </div>
            </div>

            <!-- Assets Table -->
            <div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aset</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jenis</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kategori</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Lokasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Keadaan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nilai</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tindakan</th>
                            </tr>
                        </thead>
                        @forelse($assets as $asset)
                            @if($asset->batch_siblings_count > 1)
                                <tbody class="bg-white border-b border-gray-200" x-data="{ expanded: false }">
                                    <tr class="hover:bg-emerald-50 transition-colors cursor-pointer bg-gray-50 group"
                                        @click="expanded = !expanded">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <i class='bx bx-chevron-right text-xl text-emerald-600 transition-transform duration-200 mr-2'
                                                    :class="expanded ? 'rotate-90' : ''"></i>
                                                <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                                    <i class='bx bx-package text-emerald-700 text-lg'></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $asset->nama_aset }}
                                                        <span
                                                            class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800"
                                                            title="Aset ini sebahagian daripada kumpulan {{ $asset->batch_siblings_count }} unit">
                                                            {{ $asset->batch_siblings_count }} Unit
                                                        </span>
                                                    </div>
                                                    <div class="text-sm text-gray-400 mt-1">
                                                        Klik untuk lihat siri
                                                    </div>
                                                    @if($asset->tarikh_perolehan)
                                                        <div class="text-xs text-gray-400 flex items-center mt-1">
                                                            <i class='bx bx-calendar mr-1'></i>
                                                            {{ $asset->tarikh_perolehan->format('d/m/Y') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $asset->jenis_aset }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                                                                    @if($asset->kategori_aset === 'asset') bg-emerald-100 text-emerald-800
                                                                                    @else bg-orange-100 text-orange-800 @endif">
                                                {{ $asset->kategori_aset === 'asset' ? 'Asset' : 'Non-Asset' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $asset->lokasi_penempatan }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                Pelbagai (Kumpulan)
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800">
                                                Pelbagai (Kumpulan)
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                            RM {{ number_format($asset->batch_siblings_sum_nilai_perolehan, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-3">
                                                <!-- Action buttons omitted for grouping header. Refer to rows below. -->
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Child Rows -->
                                    @foreach($asset->batchSiblings ?? [] as $sibling)
                                        <tr x-show="expanded" x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                                            x-transition:enter-end="opacity-100 transform translate-y-0"
                                            class="bg-emerald-50/30 hover:bg-emerald-50 transition-colors">
                                            <td class="px-6 py-3 whitespace-nowrap border-l-2 border-emerald-400 pl-16">
                                                <div class="flex items-center">
                                                    <div
                                                        class="text-sm font-mono text-gray-600 bg-white border border-gray-200 px-2 py-1 rounded shadow-sm">
                                                        {{ $sibling->no_siri_pendaftaran }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td colspan="3" class="px-6 py-3"></td>
                                            <td class="px-6 py-3 whitespace-nowrap">
                                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full 
                                                                                                @if($sibling->status_aset === 'Sedang Digunakan') bg-green-100 text-green-800
                                                                                                @elseif($sibling->status_aset === 'Aktif') bg-green-100 text-green-800
                                                                                                @elseif($sibling->status_aset === 'Dalam Penyelenggaraan') bg-yellow-100 text-yellow-800
                                                                                                @elseif($sibling->status_aset === 'Baru') bg-blue-100 text-blue-800
                                                                                                @else bg-red-100 text-red-800 @endif">
                                                    <div class="w-2 h-2 
                                                                                                    @if($sibling->status_aset === 'Sedang Digunakan') bg-green-500
                                                                                                    @elseif($sibling->status_aset === 'Aktif') bg-green-500
                                                                                                    @elseif($sibling->status_aset === 'Dalam Penyelenggaraan') bg-yellow-500
                                                                                                    @elseif($sibling->status_aset === 'Baru') bg-blue-500
                                                                                                    @else bg-red-500 @endif 
                                                                                                    rounded-full mr-2"></div>
                                                    {{ $sibling->status_aset }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-3 whitespace-nowrap">
                                                <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full 
                                                                                                @if($sibling->keadaan_fizikal === 'Cemerlang') bg-green-100 text-green-800
                                                                                                @elseif($sibling->keadaan_fizikal === 'Baik') bg-blue-100 text-blue-800
                                                                                                @elseif($sibling->keadaan_fizikal === 'Sederhana') bg-yellow-100 text-yellow-800
                                                                                                @elseif($sibling->keadaan_fizikal === 'Rosak') bg-orange-100 text-orange-800
                                                                                                @else bg-red-100 text-red-800 @endif">
                                                    {{ $sibling->keadaan_fizikal ?? 'Baik' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-3"></td>
                                            <td class="px-6 py-3 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex items-center justify-end space-x-3">
                                                    <a href="{{ route('admin.assets.show', $sibling) }}"
                                                        class="w-8 h-8 bg-emerald-100 hover:bg-emerald-200 text-emerald-600 rounded-lg flex items-center justify-center transition-colors"
                                                        title="Lihat">
                                                        <i class='bx bx-show text-sm'></i>
                                                    </a>
                                                    <a href="{{ route('admin.assets.edit', $sibling) }}"
                                                        class="w-8 h-8 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-lg flex items-center justify-center transition-colors"
                                                        title="Edit">
                                                        <i class='bx bx-edit text-sm'></i>
                                                    </a>

                                                    <form action="{{ route('admin.assets.destroy', $sibling) }}" method="POST"
                                                        class="inline"
                                                        onsubmit="return confirm('Adakah anda pasti ingin memadamkan aset ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg flex items-center justify-center transition-colors"
                                                            title="Padamkan">
                                                            <i class='bx bx-trash text-sm'></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            @else
                                <tbody class="bg-white border-b border-gray-200">
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                                    <i class='bx bx-package text-emerald-700 text-lg'></i>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $asset->nama_aset }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">{{ $asset->no_siri_pendaftaran }}</div>
                                                    @if($asset->tarikh_perolehan)
                                                        <div class="text-xs text-gray-400 flex items-center">
                                                            <i class='bx bx-calendar mr-1'></i>
                                                            {{ $asset->tarikh_perolehan->format('d/m/Y') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $asset->jenis_aset }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                                                                    @if($asset->kategori_aset === 'asset') bg-emerald-100 text-emerald-800
                                                                                    @else bg-orange-100 text-orange-800 @endif">
                                                {{ $asset->kategori_aset === 'asset' ? 'Asset' : 'Non-Asset' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $asset->lokasi_penempatan }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full 
                                                                                    @if($asset->status_aset === 'Sedang Digunakan') bg-green-100 text-green-800
                                                                                    @elseif($asset->status_aset === 'Aktif') bg-green-100 text-green-800
                                                                                    @elseif($asset->status_aset === 'Dalam Penyelenggaraan') bg-yellow-100 text-yellow-800
                                                                                    @elseif($asset->status_aset === 'Baru') bg-blue-100 text-blue-800
                                                                                    @else bg-red-100 text-red-800 @endif">
                                                <div class="w-2 h-2 
                                                                                        @if($asset->status_aset === 'Sedang Digunakan') bg-green-500
                                                                                        @elseif($asset->status_aset === 'Aktif') bg-green-500
                                                                                        @elseif($asset->status_aset === 'Dalam Penyelenggaraan') bg-yellow-500
                                                                                        @elseif($asset->status_aset === 'Baru') bg-blue-500
                                                                                        @else bg-red-500 @endif 
                                                                                        rounded-full mr-2"></div>
                                                {{ $asset->status_aset }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full 
                                                                                    @if($asset->keadaan_fizikal === 'Cemerlang') bg-green-100 text-green-800
                                                                                    @elseif($asset->keadaan_fizikal === 'Baik') bg-blue-100 text-blue-800
                                                                                    @elseif($asset->keadaan_fizikal === 'Sederhana') bg-yellow-100 text-yellow-800
                                                                                    @elseif($asset->keadaan_fizikal === 'Rosak') bg-orange-100 text-orange-800
                                                                                    @else bg-red-100 text-red-800 @endif">
                                                {{ $asset->keadaan_fizikal ?? 'Baik' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            RM {{ number_format($asset->nilai_perolehan, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-3">
                                                <a href="{{ route('admin.assets.show', $asset) }}"
                                                    class="w-8 h-8 bg-emerald-100 hover:bg-emerald-200 text-emerald-600 rounded-lg flex items-center justify-center transition-colors"
                                                    title="Lihat">
                                                    <i class='bx bx-show text-sm'></i>
                                                </a>
                                                <a href="{{ route('admin.assets.edit', $asset) }}"
                                                    class="w-8 h-8 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-lg flex items-center justify-center transition-colors"
                                                    title="Edit">
                                                    <i class='bx bx-edit text-sm'></i>
                                                </a>

                                                <form action="{{ route('admin.assets.destroy', $asset) }}" method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Adakah anda pasti ingin memadamkan aset ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg flex items-center justify-center transition-colors"
                                                        title="Padamkan">
                                                        <i class='bx bx-trash text-sm'></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            @endif
                        @empty
                            <tbody class="bg-white">
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center border-b border-gray-200">
                                        <div class="flex flex-col items-center">
                                            <i class='bx bx-package text-5xl text-gray-400 mb-4'></i>
                                            <p class="text-gray-500 text-lg">Tiada aset dijumpai</p>
                                            <p class="text-gray-400 text-sm">Cuba tukar kriteria carian anda</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        @endforelse
                    </table>
                </div>

                <!-- Pagination -->
                @if($assets->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                        {{ $assets->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Export Confirmation Modal -->
    <div id="exportConfirmModal" class="fixed inset-0 z-50 hidden">
        <div class="absolute inset-0 bg-black/40" onclick="closeExportConfirm()"></div>
        <div class="relative flex min-h-full items-center justify-center p-4">
            <div class="w-full max-w-md rounded-2xl bg-white shadow-2xl border border-gray-200">
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3">
                            <i class='bx bx-download text-xl'></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Sahkan Eksport Data</h3>
                            <p id="exportConfirmMessage" class="text-sm text-gray-600 mt-1">Adakah anda pasti?</p>
                        </div>
                    </div>
                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <button type="button" onclick="closeExportConfirm()"
                            class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium transition-colors">
                            Batal
                        </button>
                        <a id="exportConfirmAction" href="#"
                            class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium transition-colors inline-flex items-center">
                            <i class='bx bx-check mr-2'></i>
                            Ya, Eksport
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openExportConfirm(event, url, message) {
            event.preventDefault();
            document.getElementById('exportConfirmAction').setAttribute('href', url);
            document.getElementById('exportConfirmMessage').textContent = message;
            document.getElementById('exportConfirmModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeExportConfirm() {
            document.getElementById('exportConfirmModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    </script>
@endpush
