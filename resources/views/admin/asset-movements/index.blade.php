@extends('layouts.admin')

@section('title', 'Pengurusan Pergerakan Aset')
@section('page-title', 'Pengurusan Pergerakan Aset')
@section('page-description', 'Urus semua pergerakan aset dalam sistem')

@section('content')
    <div class="p-6">
        <!-- Welcome Header -->
        <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Pengurusan Pergerakan Aset</h1>
                    <p class="text-emerald-100 text-lg">Urus dan pantau semua pergerakan aset dalam sistem</p>
                    <div class="flex items-center space-x-4 mt-4">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-transfer text-emerald-200'></i>
                            <span class="text-emerald-100">{{ $assetMovements->total() }} pergerakan</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-shield-check text-emerald-200'></i>
                            <span class="text-emerald-100">Sistem Aktif</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <i class='bx bx-transfer text-6xl text-emerald-200'></i>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Movements -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-transfer text-emerald-600 text-xl'></i>
                    </div>
                    <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium">+12.3%</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $assetMovements->total() }}</h3>
                <p class="text-sm text-gray-600">Jumlah Pergerakan</p>
            </div>

            <!-- Pending Approval -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-time text-yellow-600 text-xl'></i>
                    </div>
                    <span class="text-sm text-yellow-600 bg-yellow-100 px-2 py-1 rounded-full font-medium">Perlu
                        tindakan</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">
                    {{ $assetMovements->where('status_pergerakan', 'menunggu_kelulusan')->count() }}</h3>
                <p class="text-sm text-gray-600">Menunggu Kelulusan</p>
            </div>

            <!-- Approved -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-check text-green-600 text-xl'></i>
                    </div>
                    <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">+5.2%</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">
                    {{ $assetMovements->where('status_pergerakan', 'diluluskan')->count() }}</h3>
                <p class="text-sm text-gray-600">Diluluskan</p>
            </div>

            <!-- This Month -->
            <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class='bx bx-calendar text-blue-600 text-xl'></i>
                    </div>
                    <span class="text-sm text-blue-600 bg-blue-100 px-2 py-1 rounded-full font-medium">Bulan ini</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">
                    {{ $assetMovements->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                <p class="text-sm text-gray-600">Pergerakan Baru</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Add Movement -->
            <a href="{{ route('admin.asset-movements.create') }}"
                class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                        <i class='bx bx-plus text-emerald-600 text-xl'></i>
                    </div>
                    <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-emerald-600 transition-colors'></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Tambah Pergerakan</h3>
                <p class="text-sm text-gray-600">Daftar pergerakan aset baharu</p>
            </a>

            <!-- Export Data -->
            <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <i class='bx bx-download text-blue-600 text-xl'></i>
                    </div>
                    <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-blue-600 transition-colors'></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Eksport Data</h3>
                <p class="text-sm text-gray-600">Muat turun senarai pergerakan</p>
            </div>

            <!-- Movement Reports -->
            <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                        <i class='bx bx-bar-chart text-purple-600 text-xl'></i>
                    </div>
                    <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-purple-600 transition-colors'></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Laporan Pergerakan</h3>
                <p class="text-sm text-gray-600">Analitik dan statistik</p>
            </div>

            <!-- Backup Data -->
            <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                        <i class='bx bx-cloud-upload text-amber-600 text-xl'></i>
                    </div>
                    <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-amber-600 transition-colors'></i>
                </div>
                <h3 class="font-semibold text-gray-900 mb-2">Sandaran Data</h3>
                <p class="text-sm text-gray-600">Backup maklumat pergerakan</p>
            </div>
        </div>

        <!-- Search and Filters Card -->
        <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Penapis & Carian</h2>
                    <p class="text-sm text-gray-600">Gunakan penapis untuk mencari pergerakan tertentu</p>
                </div>
                <i class='bx bx-filter-alt text-2xl text-gray-400'></i>
            </div>

            <form method="GET" action="{{ route('admin.asset-movements.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari</label>
                        <div class="relative">
                            <input type="text" id="search" name="search" value="{{ request('search') }}"
                                placeholder="Nama aset atau lokasi..."
                                class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <i class='bx bx-search absolute left-3 top-2.5 text-gray-400'></i>
                        </div>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select id="status" name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Semua Status</option>
                            <option value="menunggu_kelulusan" {{ request('status') === 'menunggu_kelulusan' ? 'selected' : '' }}>Menunggu Kelulusan</option>
                            <option value="diluluskan" {{ request('status') === 'diluluskan' ? 'selected' : '' }}>Diluluskan
                            </option>
                            <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>

                    <!-- Movement Type Filter -->
                    <div>
                        <label for="jenis_pergerakan" class="block text-sm font-medium text-gray-700 mb-2">Jenis
                            Pergerakan</label>
                        <select id="jenis_pergerakan" name="jenis_pergerakan"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Semua Jenis</option>
                            <option value="Pemindahan" {{ request('jenis_pergerakan') === 'Pemindahan' ? 'selected' : '' }}>
                                Pemindahan</option>
                            <option value="Peminjaman" {{ request('jenis_pergerakan') === 'Peminjaman' ? 'selected' : '' }}>
                                Peminjaman</option>
                            <option value="Pulangan" {{ request('jenis_pergerakan') === 'Pulangan' ? 'selected' : '' }}>
                                Pulangan</option>
                        </select>
                    </div>

                    <!-- Source Masjid/Surau Filter -->
                    <div>
                        <label for="origin_masjid_surau_id"
                            class="block text-sm font-medium text-gray-700 mb-2">Masjid/Surau Asal</label>
                        <select id="origin_masjid_surau_id" name="origin_masjid_surau_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Semua Lokasi</option>
                            @foreach($masjidSuraus as $masjid)
                                <option value="{{ $masjid->id }}" {{ request('origin_masjid_surau_id') == $masjid->id ? 'selected' : '' }}>
                                    {{ $masjid->nama }} ({{ $masjid->jenis }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Destination Masjid/Surau Filter -->
                    <div>
                        <label for="destination_masjid_surau_id"
                            class="block text-sm font-medium text-gray-700 mb-2">Masjid/Surau Destinasi</label>
                        <select id="destination_masjid_surau_id" name="destination_masjid_surau_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Semua Lokasi</option>
                            @foreach($masjidSuraus as $masjid)
                                <option value="{{ $masjid->id }}" {{ request('destination_masjid_surau_id') == $masjid->id ? 'selected' : '' }}>
                                    {{ $masjid->nama }} ({{ $masjid->jenis }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-end space-x-2">
                        <button type="submit"
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors flex items-center">
                            <i class='bx bx-search mr-2'></i>
                            Cari
                        </button>
                        <a href="{{ route('admin.asset-movements.index') }}"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Movements Table Card -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <!-- Table Header -->
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Senarai Pergerakan Aset</h2>
                        <p class="text-sm text-gray-600">{{ $assetMovements->total() }} pergerakan dijumpai</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm text-gray-600">Terkini</span>
                        <i class='bx bx-chevron-down text-gray-400'></i>
                    </div>
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dari
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ke
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tarikh</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($assetMovements as $movement)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-10 w-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                            <i class='bx bx-package text-emerald-600'></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $movement->asset->nama_aset ?? 'Aset Tidak Ditemui' }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $movement->asset->no_siri_pendaftaran ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $movement->jenis_pergerakan === 'Pemindahan' ? 'bg-blue-100 text-blue-800' : ($movement->jenis_pergerakan === 'Peminjaman' ? 'bg-purple-100 text-purple-800' : 'bg-green-100 text-green-800') }}">
                                        {{ $movement->jenis_pergerakan }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $movement->masjidSurauAsal->nama ?? 'Tidak Ditetapkan' }}</div>
                                    <div class="text-xs text-gray-500">{{ $movement->lokasi_asal_spesifik }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $movement->masjidSurauDestinasi->nama ?? 'Tidak Ditetapkan' }}</div>
                                    <div class="text-xs text-gray-500">{{ $movement->lokasi_destinasi_spesifik }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $movement->tarikh_pergerakan ? $movement->tarikh_pergerakan->format('d/m/Y') : '-' }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $movement->tarikh_pergerakan ? $movement->tarikh_pergerakan->diffForHumans() : '' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $movement->status_pergerakan === 'diluluskan' ? 'bg-green-100 text-green-800' : ($movement->status_pergerakan === 'menunggu_kelulusan' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                        {{ ucfirst(str_replace('_', ' ', $movement->status_pergerakan)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- View Button -->
                                        <a href="{{ route('admin.asset-movements.show', $movement) }}"
                                            class="w-8 h-8 bg-emerald-100 hover:bg-emerald-200 text-emerald-600 rounded-lg flex items-center justify-center transition-colors"
                                            title="Lihat">
                                            <i class='bx bx-show text-sm'></i>
                                        </a>

                                        <!-- Edit Button -->
                                        @if($movement->status_pergerakan === 'menunggu_kelulusan')
                                            <a href="{{ route('admin.asset-movements.edit', $movement) }}"
                                                class="w-8 h-8 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-lg flex items-center justify-center transition-colors"
                                                title="Edit">
                                                <i class='bx bx-edit text-sm'></i>
                                            </a>
                                        @endif

                                        <!-- Approve Button -->
                                        @if($movement->status_pergerakan === 'menunggu_kelulusan')
                                            <form action="{{ route('admin.asset-movements.approve', $movement) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="w-8 h-8 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg flex items-center justify-center transition-colors"
                                                    title="Luluskan" onclick="return confirm('Luluskan pergerakan ini?')">
                                                    <i class='bx bx-check text-sm'></i>
                                                </button>
                                            </form>

                                            <!-- Reject Button -->
                                            <button onclick="showRejectModal({{ $movement->id }})"
                                                class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg flex items-center justify-center transition-colors"
                                                title="Tolak">
                                                <i class='bx bx-x text-sm'></i>
                                            </button>
                                        @endif

                                        <!-- Delete Button -->
                                        @if($movement->status_pergerakan === 'menunggu_kelulusan')
                                            <form action="{{ route('admin.asset-movements.destroy', $movement) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Adakah anda pasti ingin memadamkan pergerakan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg flex items-center justify-center transition-colors"
                                                    title="Padamkan">
                                                    <i class='bx bx-trash text-sm'></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    Tiada pergerakan aset dijumpai
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-6 border-t border-gray-200">
                {{ $assetMovements->links() }}
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div id="rejectModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
            <div class="mt-3">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4">
                        <i class='bx bx-x text-red-600 text-xl'></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Tolak Pergerakan</h3>
                </div>

                <form id="rejectForm" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                            Sebab Penolakan <span class="text-red-500">*</span>
                        </label>
                        <textarea id="catatan" name="catatan" rows="3" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                            placeholder="Masukkan sebab penolakan..."></textarea>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeRejectModal()"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                            <i class='bx bx-x mr-2'></i>
                            Tolak Pergerakan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function showRejectModal(movementId) {
                document.getElementById('rejectForm').action = `/admin/asset-movements/${movementId}/reject`;
                document.getElementById('rejectModal').classList.remove('hidden');
            }

            function closeRejectModal() {
                document.getElementById('rejectModal').classList.add('hidden');
                document.getElementById('catatan').value = '';
            }

            // Close modal when clicking outside
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('rejectModal').addEventListener('click', function (e) {
                    if (e.target === this) {
                        closeRejectModal();
                    }
                });
            });
        </script>
    @endpush

@endsection