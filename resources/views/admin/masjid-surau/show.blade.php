@extends('layouts.admin')

@section('title', 'Maklumat Masjid/Surau')
@section('page-title', $masjidSurau->nama)

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">{{ $masjidSurau->nama }}</h1>
                @if($masjidSurau->singkatan_nama)
                    <p class="text-emerald-100 text-lg mb-2">{{ $masjidSurau->singkatan_nama }}</p>
                @endif
                <p class="text-emerald-100 text-lg">Maklumat lengkap {{ strtolower($masjidSurau->jenis) }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $masjidSurau->jenis == 'Masjid' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                            {{ $masjidSurau->jenis }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 {{ $masjidSurau->status == 'Aktif' ? 'bg-green-400' : 'bg-red-400' }} rounded-full"></div>
                        <span class="text-emerald-100">{{ $masjidSurau->status }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-map text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $masjidSurau->daerah }}, {{ $masjidSurau->negeri }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-buildings text-6xl text-emerald-200 opacity-80'></i>
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
            <a href="{{ route('admin.masjid-surau.index') }}" class="hover:text-emerald-600 transition-colors">
                Masjid/Surau
            </a>
            <i class='bx bx-chevron-right text-gray-400'></i>
            <span class="text-emerald-600 font-medium">{{ $masjidSurau->nama }}</span>
        </nav>
    </div>

    <!-- Action Buttons -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.masjid-surau.edit', $masjidSurau) }}" 
                   class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                    <i class='bx bx-edit mr-2'></i>
                    Edit Maklumat
                </a>
                
                <!-- Status Toggle -->
                <form action="{{ route('admin.masjid-surau.toggle-status', $masjidSurau) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="inline-flex items-center px-4 py-2 {{ $masjidSurau->status == 'Aktif' ? 'bg-red-100 hover:bg-red-200 text-red-700' : 'bg-green-100 hover:bg-green-200 text-green-700' }} font-medium rounded-lg transition-colors">
                        <i class='bx {{ $masjidSurau->status == 'Aktif' ? 'bx-x' : 'bx-check' }} mr-2'></i>
                        {{ $masjidSurau->status == 'Aktif' ? 'Nyahaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
            </div>

            <div class="flex items-center space-x-2">
                <span class="text-sm text-gray-500">Dicipta: {{ $masjidSurau->created_at->format('d/m/Y H:i') }}</span>
                @if($masjidSurau->updated_at->gt($masjidSurau->created_at))
                    <span class="text-sm text-gray-400">•</span>
                    <span class="text-sm text-gray-500">Dikemaskini: {{ $masjidSurau->updated_at->format('d/m/Y H:i') }}</span>
                @endif
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Basic Information -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <i class='bx bx-info-circle text-emerald-600 text-lg'></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Maklumat Asas</h2>
                            <p class="text-sm text-gray-600">Maklumat utama {{ strtolower($masjidSurau->jenis) }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                            <p class="text-gray-900 font-medium">{{ $masjidSurau->nama }}</p>
                        </div>

                        @if($masjidSurau->singkatan_nama)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Singkatan Nama</label>
                            <p class="text-gray-900">{{ $masjidSurau->singkatan_nama }}</p>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $masjidSurau->jenis == 'Masjid' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $masjidSurau->jenis }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $masjidSurau->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <div class="w-2 h-2 {{ $masjidSurau->status == 'Aktif' ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-2"></div>
                                {{ $masjidSurau->status }}
                            </span>
                        </div>

                        @if($masjidSurau->imam_ketua)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Imam/Ketua</label>
                            <p class="text-gray-900">{{ $masjidSurau->imam_ketua }}</p>
                        </div>
                        @endif

                        @if($masjidSurau->bilangan_jemaah)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bilangan Jemaah</label>
                            <p class="text-gray-900">{{ number_format($masjidSurau->bilangan_jemaah) }} orang</p>
                        </div>
                        @endif

                        @if($masjidSurau->tahun_dibina)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Dibina</label>
                            <p class="text-gray-900">{{ $masjidSurau->tahun_dibina }} ({{ date('Y') - $masjidSurau->tahun_dibina }} tahun)</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Location Information -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class='bx bx-map text-blue-600 text-lg'></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Maklumat Lokasi</h2>
                            <p class="text-sm text-gray-600">Alamat dan lokasi {{ strtolower($masjidSurau->jenis) }}</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Full Address -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                            <div class="bg-gray-50 rounded-lg p-4">
                                @if($masjidSurau->alamat_baris_1)
                                    <div class="text-gray-900">{{ $masjidSurau->alamat_baris_1 }}</div>
                                @endif
                                @if($masjidSurau->alamat_baris_2)
                                    <div class="text-gray-900">{{ $masjidSurau->alamat_baris_2 }}</div>
                                @endif
                                @if($masjidSurau->alamat_baris_3)
                                    <div class="text-gray-900">{{ $masjidSurau->alamat_baris_3 }}</div>
                                @endif
                                @if($masjidSurau->poskod || $masjidSurau->bandar)
                                    <div class="text-gray-900">{{ $masjidSurau->poskod }} {{ $masjidSurau->bandar }}</div>
                                @endif
                                @if($masjidSurau->negeri || $masjidSurau->negara)
                                    <div class="text-gray-900">{{ $masjidSurau->negeri }}{{ $masjidSurau->negara ? ', ' . $masjidSurau->negara : '' }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @if($masjidSurau->poskod)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Poskod</label>
                                <p class="text-gray-900">{{ $masjidSurau->poskod }}</p>
                            </div>
                            @endif

                            @if($masjidSurau->bandar)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Bandar</label>
                                <p class="text-gray-900">{{ $masjidSurau->bandar }}</p>
                            </div>
                            @endif

                            @if($masjidSurau->negeri)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Negeri</label>
                                <p class="text-gray-900">{{ $masjidSurau->negeri }}</p>
                            </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @if($masjidSurau->daerah)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Daerah</label>
                                <p class="text-gray-900">{{ $masjidSurau->daerah }}</p>
                            </div>
                            @endif

                            @if($masjidSurau->negara)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Negara</label>
                                <p class="text-gray-900">{{ $masjidSurau->negara }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class='bx bx-phone text-purple-600 text-lg'></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Maklumat Hubungan</h2>
                            <p class="text-sm text-gray-600">Maklumat untuk dihubungi</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($masjidSurau->no_telefon)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombor Telefon</label>
                            <div class="flex items-center space-x-2">
                                <i class='bx bx-phone text-gray-400'></i>
                                <a href="tel:{{ $masjidSurau->no_telefon }}" class="text-emerald-600 hover:text-emerald-700 font-medium">
                                    {{ $masjidSurau->no_telefon }}
                                </a>
                            </div>
                        </div>
                        @endif

                        @if($masjidSurau->email)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                            <div class="flex items-center space-x-2">
                                <i class='bx bx-envelope text-gray-400'></i>
                                <a href="mailto:{{ $masjidSurau->email }}" class="text-emerald-600 hover:text-emerald-700 font-medium">
                                    {{ $masjidSurau->email }}
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>

                    @if($masjidSurau->catatan)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-gray-900">{{ $masjidSurau->catatan }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Sidebar -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Statistik Pantas</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-box text-emerald-500'></i>
                            <span class="text-sm text-gray-600">Aset Terdaftar</span>
                        </div>
                        <span class="text-lg font-semibold text-gray-900">{{ $masjidSurau->assets->count() }}</span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-group text-blue-500'></i>
                            <span class="text-sm text-gray-600">Pengguna Aktif</span>
                        </div>
                        <span class="text-lg font-semibold text-gray-900">{{ $masjidSurau->users->count() }}</span>
                    </div>

                    @if($masjidSurau->immovableAssets && $masjidSurau->immovableAssets->count() > 0)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-home text-purple-500'></i>
                            <span class="text-sm text-gray-600">Aset Tak Alih</span>
                        </div>
                        <span class="text-lg font-semibold text-gray-900">{{ $masjidSurau->immovableAssets->count() }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-emerald-50 rounded-xl border border-emerald-200 p-6">
                <h3 class="text-lg font-semibold text-emerald-900 mb-4">Tindakan Pantas</h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.assets.create', ['masjid_surau_id' => $masjidSurau->id]) }}" 
                       class="flex items-center space-x-3 w-full px-4 py-3 bg-white hover:bg-emerald-50 border border-emerald-200 rounded-lg transition-colors">
                        <i class='bx bx-plus text-emerald-600'></i>
                        <span class="text-emerald-700 font-medium">Tambah Aset Baharu</span>
                    </a>
                    
                    <a href="{{ route('admin.users.create', ['masjid_surau_id' => $masjidSurau->id]) }}" 
                       class="flex items-center space-x-3 w-full px-4 py-3 bg-white hover:bg-emerald-50 border border-emerald-200 rounded-lg transition-colors">
                        <i class='bx bx-user-plus text-emerald-600'></i>
                        <span class="text-emerald-700 font-medium">Tambah Pengguna</span>
                    </a>
                    
                    <a href="{{ route('admin.inspections.create', ['masjid_surau_id' => $masjidSurau->id]) }}" 
                       class="flex items-center space-x-3 w-full px-4 py-3 bg-white hover:bg-emerald-50 border border-emerald-200 rounded-lg transition-colors">
                        <i class='bx bx-search-alt text-emerald-600'></i>
                        <span class="text-emerald-700 font-medium">Jadual Pemeriksaan</span>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            @if($masjidSurau->assets->count() > 0 || $masjidSurau->users->count() > 0)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Aktiviti Terkini</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @if($masjidSurau->assets->count() > 0)
                        @foreach($masjidSurau->assets->take(3) as $asset)
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class='bx bx-box text-blue-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $asset->nama_aset }}</p>
                                <p class="text-xs text-gray-500">Aset • {{ $asset->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                        @endif

                        @if($masjidSurau->users->count() > 0)
                        @foreach($masjidSurau->users->take(2) as $user)
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class='bx bx-user text-green-600 text-sm'></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">Pengguna • {{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>

                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <a href="{{ route('admin.assets.index', ['masjid_surau' => $masjidSurau->id]) }}" 
                           class="text-sm text-emerald-600 hover:text-emerald-700 font-medium">
                            Lihat semua aktiviti →
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- System Info -->
            <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Maklumat Sistem</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID:</span>
                        <span class="text-gray-900 font-mono">#{{ $masjidSurau->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dicipta:</span>
                        <span class="text-gray-900">{{ $masjidSurau->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @if($masjidSurau->updated_at->gt($masjidSurau->created_at))
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dikemaskini:</span>
                        <span class="text-gray-900">{{ $masjidSurau->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

