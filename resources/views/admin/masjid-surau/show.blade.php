@extends('layouts.admin')

@section('title', 'Lihat Masjid/Surau')
@section('page-title', 'Lihat Masjid/Surau')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">{{ $masjidSurau->nama }}</h1>
                <p class="text-emerald-100 text-lg">{{ $masjidSurau->jenis }} di {{ $masjidSurau->bandar }}, {{ $masjidSurau->negeri }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 {{ $masjidSurau->status == 'Aktif' ? 'bg-green-400' : 'bg-red-400' }} rounded-full"></div>
                        <span class="text-emerald-100">{{ $masjidSurau->status }}</span>
                    </div>
                    @if($masjidSurau->tahun_dibina)
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-calendar text-emerald-200'></i>
                        <span class="text-emerald-100">Dibina {{ $masjidSurau->tahun_dibina }}</span>
                    </div>
                    @endif
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

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Assets -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-box text-emerald-600 text-xl'></i>
                </div>
                <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium">Aset</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $assetStats['total_assets'] }}</h3>
            <p class="text-sm text-gray-600">Total Aset</p>
        </div>

        <!-- Asset Value -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-money text-blue-600 text-xl'></i>
                </div>
                <span class="text-sm text-blue-600 bg-blue-100 px-2 py-1 rounded-full font-medium">Nilai</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">RM{{ number_format($assetStats['total_value'], 2) }}</h3>
            <p class="text-sm text-gray-600">Nilai Aset</p>
        </div>

        <!-- Active Users -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-group text-purple-600 text-xl'></i>
                </div>
                <span class="text-sm text-purple-600 bg-purple-100 px-2 py-1 rounded-full font-medium">Pengguna</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $activeUsers }}</h3>
            <p class="text-sm text-gray-600">Pengguna Aktif</p>
        </div>

        <!-- Congregation -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-group text-green-600 text-xl'></i>
                </div>
                <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">Jemaah</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $masjidSurau->bilangan_jemaah ?? 'N/A' }}</h3>
            <p class="text-sm text-gray-600">Bilangan Jemaah</p>
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
                            <p class="text-sm text-gray-600">Maklumat utama masjid/surau</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nama</label>
                            <p class="text-gray-900 font-medium">{{ $masjidSurau->nama }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Jenis</label>
                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $masjidSurau->jenis == 'Masjid' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $masjidSurau->jenis }}
                            </span>
                        </div>
                        @if($masjidSurau->imam_ketua)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Imam/Ketua</label>
                            <p class="text-gray-900">{{ $masjidSurau->imam_ketua }}</p>
                        </div>
                        @endif
                        @if($masjidSurau->bilangan_jemaah)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Bilangan Jemaah</label>
                            <p class="text-gray-900">{{ number_format($masjidSurau->bilangan_jemaah) }} orang</p>
                        </div>
                        @endif
                        @if($masjidSurau->tahun_dibina)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Tahun Dibina</label>
                            <p class="text-gray-900">{{ $masjidSurau->tahun_dibina }} ({{ date('Y') - $masjidSurau->tahun_dibina }} tahun)</p>
                        </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Status</label>
                            <span class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full {{ $masjidSurau->status == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <div class="w-2 h-2 {{ $masjidSurau->status == 'Aktif' ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-2"></div>
                                {{ $masjidSurau->status }}
                            </span>
                        </div>
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
                            <p class="text-sm text-gray-600">Alamat dan lokasi masjid/surau</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Alamat Penuh</label>
                            <p class="text-gray-900">{{ $masjidSurau->alamat }}</p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Poskod</label>
                                <p class="text-gray-900">{{ $masjidSurau->poskod }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Bandar</label>
                                <p class="text-gray-900">{{ $masjidSurau->bandar }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 mb-1">Negeri</label>
                                <p class="text-gray-900">{{ $masjidSurau->negeri }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            @if($masjidSurau->telefon || $masjidSurau->email)
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
                        @if($masjidSurau->telefon)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Nombor Telefon</label>
                            <div class="flex items-center space-x-2">
                                <i class='bx bx-phone text-gray-400'></i>
                                <a href="tel:{{ $masjidSurau->telefon }}" class="text-emerald-600 hover:text-emerald-700">{{ $masjidSurau->telefon }}</a>
                            </div>
                        </div>
                        @endif
                        @if($masjidSurau->email)
                        <div>
                            <label class="block text-sm font-medium text-gray-500 mb-1">Alamat Email</label>
                            <div class="flex items-center space-x-2">
                                <i class='bx bx-envelope text-gray-400'></i>
                                <a href="mailto:{{ $masjidSurau->email }}" class="text-emerald-600 hover:text-emerald-700">{{ $masjidSurau->email }}</a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif

            <!-- Notes -->
            @if($masjidSurau->catatan)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                            <i class='bx bx-note text-amber-600 text-lg'></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Catatan</h2>
                            <p class="text-sm text-gray-600">Catatan tambahan</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <p class="text-gray-900 whitespace-pre-wrap">{{ $masjidSurau->catatan }}</p>
                </div>
            </div>
            @endif

            <!-- Recent Assets -->
            @if($recentAssets->count() > 0)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <i class='bx bx-box text-green-600 text-lg'></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">Aset Terkini</h2>
                                <p class="text-sm text-gray-600">5 aset yang didaftarkan terkini</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.assets.index', ['masjid_surau_id' => $masjidSurau->id]) }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                            Lihat Semua
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($recentAssets as $asset)
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                    <i class='bx bx-box text-emerald-600'></i>
                                </div>
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $asset->nama_aset }}</h4>
                                    <p class="text-sm text-gray-600">{{ $asset->kategori_aset }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">RM{{ number_format($asset->nilai_perolehan, 2) }}</p>
                                <p class="text-xs text-gray-500">{{ $asset->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Tindakan Pantas</h3>
                    <p class="text-sm text-gray-600">Tindakan yang boleh dilakukan</p>
                </div>
                <div class="p-6 space-y-3">
                    <a href="{{ route('admin.masjid-surau.edit', $masjidSurau) }}" 
                       class="w-full flex items-center justify-center px-4 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors">
                        <i class='bx bx-edit mr-2'></i>
                        Edit Maklumat
                    </a>
                    
                    <form action="{{ route('admin.masjid-surau.toggle-status', $masjidSurau) }}" method="POST" class="w-full">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="w-full flex items-center justify-center px-4 py-3 {{ $masjidSurau->status == 'Aktif' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white font-medium rounded-lg transition-colors">
                            <i class='bx {{ $masjidSurau->status == 'Aktif' ? 'bx-x-circle' : 'bx-check-circle' }} mr-2'></i>
                            {{ $masjidSurau->status == 'Aktif' ? 'Nyahaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                    
                    <button onclick="confirmDelete()" 
                            class="w-full flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                        <i class='bx bx-trash mr-2'></i>
                        Padam
                    </button>
                </div>
            </div>

            <!-- Asset Breakdown -->
            @if($assetStats['total_assets'] > 0)
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Pecahan Aset</h3>
                    <p class="text-sm text-gray-600">Status aset mengikut keadaan</p>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">Aktif</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $assetStats['active_assets'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">Penyelenggaraan</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $assetStats['maintenance_assets'] }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">Rosak</span>
                        </div>
                        <span class="text-sm font-medium text-gray-900">{{ $assetStats['damaged_assets'] }}</span>
                    </div>
                </div>
            </div>
            @endif

            <!-- System Information -->
            <div class="bg-gray-50 rounded-xl border border-gray-200 p-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-info-circle text-gray-600 text-lg'></i>
                    </div>
                    <h3 class="font-semibold text-gray-900">Maklumat Sistem</h3>
                </div>
                <div class="space-y-3 text-sm text-gray-600">
                    <div class="flex justify-between">
                        <span>Dicipta:</span>
                        <span>{{ $masjidSurau->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Dikemaskini:</span>
                        <span>{{ $masjidSurau->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>ID Sistem:</span>
                        <span class="font-mono">#{{ $masjidSurau->id }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4 shadow-xl">
        <div class="flex items-center mb-4">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                <i class='bx bx-trash text-red-600 text-xl'></i>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Padam Masjid/Surau</h3>
                <p class="text-sm text-gray-600">Tindakan ini tidak boleh dibatalkan</p>
            </div>
        </div>
        <p class="text-gray-700 mb-6">Adakah anda pasti untuk memadamkan <strong>{{ $masjidSurau->nama }}</strong>?</p>
        @if($assetStats['total_assets'] > 0 || $activeUsers > 0)
        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
            <p class="text-red-800 text-sm">
                <i class='bx bx-error-circle mr-1'></i>
                Masjid/Surau ini tidak boleh dipadamkan kerana masih mempunyai {{ $assetStats['total_assets'] }} aset dan {{ $activeUsers }} pengguna yang berkaitan.
            </p>
        </div>
        @endif
        <div class="flex justify-end space-x-3">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                Batal
            </button>
            @if($assetStats['total_assets'] == 0 && $activeUsers == 0)
            <form action="{{ route('admin.masjid-surau.destroy', $masjidSurau) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                    Ya, Padam
                </button>
            </form>
            @else
            <button disabled class="px-4 py-2 bg-gray-400 text-white font-medium rounded-lg cursor-not-allowed">
                Tidak Boleh Padam
            </button>
            @endif
        </div>
    </div>
</div>

<script>
function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
    document.getElementById('deleteModal').classList.add('flex');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
    document.getElementById('deleteModal').classList.remove('flex');
}

// Close modal when clicking outside
document.getElementById('deleteModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeleteModal();
    }
});
</script>
@endsection
