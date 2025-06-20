@extends('layouts.admin')

@section('title', 'Kehilangan & Hapus Kira')
@section('page-title', 'Kehilangan & Hapus Kira')
@section('page-description', 'Urus semua laporan kehilangan dan hapus kira aset')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Pengurusan Kehilangan & Hapus Kira</h1>
                <p class="text-emerald-100 text-lg">Urus dan pantau semua laporan kehilangan aset dalam sistem</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-error-circle text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $totalLosses }} laporan</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-shield-check text-emerald-200'></i>
                        <span class="text-emerald-100">Sistem Aktif</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-error-circle text-6xl text-emerald-200 opacity-80'></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Losses -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-red-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-error-circle text-red-600 text-xl'></i>
                </div>
                <span class="text-sm text-red-600 bg-red-100 px-2 py-1 rounded-full font-medium">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $totalLosses }}</h3>
            <p class="text-sm text-gray-600">Jumlah Kehilangan</p>
            <div class="mt-2 flex items-center text-xs text-gray-500">
                <i class='bx bx-trending-up mr-1'></i>
                <span>Keseluruhan rekod</span>
            </div>
        </div>

        <!-- Pending Approvals -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-amber-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-time text-amber-600 text-xl'></i>
                </div>
                <span class="text-sm text-amber-600 bg-amber-100 px-2 py-1 rounded-full font-medium">Menunggu</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $pendingLosses }}</h3>
            <p class="text-sm text-gray-600">Menunggu Kelulusan</p>
            <div class="mt-2 flex items-center text-xs text-gray-500">
                <i class='bx bx-clock mr-1'></i>
                <span>Perlu tindakan</span>
            </div>
        </div>

        <!-- Approved Losses -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-green-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-check-circle text-green-600 text-xl'></i>
                </div>
                <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">Selesai</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $approvedLosses }}</h3>
            <p class="text-sm text-gray-600">Diluluskan</p>
            <div class="mt-2 flex items-center text-xs text-gray-500">
                <i class='bx bx-check mr-1'></i>
                <span>Telah diproses</span>
            </div>
        </div>

        <!-- Total Loss Value -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-purple-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-money text-purple-600 text-xl'></i>
                </div>
                <span class="text-sm text-purple-600 bg-purple-100 px-2 py-1 rounded-full font-medium">RM</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ number_format($totalLossValue, 0) }}</h3>
            <p class="text-sm text-gray-600">Nilai Kerugian</p>
            <div class="mt-2 flex items-center text-xs text-gray-500">
                <i class='bx bx-money-withdraw mr-1'></i>
                <span>Jumlah kerugian</span>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Add Loss Report -->
        <a href="{{ route('admin.loss-writeoffs.create') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-red-200">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center group-hover:bg-red-200 transition-colors">
                    <i class='bx bx-plus text-red-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-red-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Tambah Laporan</h3>
            <p class="text-sm text-gray-600">Lapor kehilangan aset baharu</p>
        </a>

        <!-- Export Data -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-blue-200 cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <i class='bx bx-download text-blue-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-blue-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Eksport Data</h3>
            <p class="text-sm text-gray-600">Muat turun laporan kehilangan</p>
        </div>

        <!-- Loss Reports -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-purple-200 cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <i class='bx bx-bar-chart text-purple-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-purple-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Laporan Analisis</h3>
            <p class="text-sm text-gray-600">Statistik dan trend kehilangan</p>
        </div>

        <!-- Approval Queue -->
        <div class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300 hover:border-amber-200 cursor-pointer">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                    <i class='bx bx-list-check text-amber-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-amber-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Baris Gilir Kelulusan</h3>
            <p class="text-sm text-gray-600">{{ $pendingLosses }} menunggu kelulusan</p>
        </div>
    </div>

    <!-- Search and Filters Card -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Penapis & Carian</h2>
                <p class="text-sm text-gray-600">Gunakan penapis untuk mencari laporan kehilangan tertentu</p>
            </div>
            <i class='bx bx-filter-alt text-2xl text-gray-400'></i>
        </div>
        
        <form method="GET" action="{{ route('admin.loss-writeoffs.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Aset</label>
                    <div class="relative">
                        <input type="text" 
                               id="search" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Nama aset, sebab kehilangan..."
                               class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                        <i class='bx bx-search absolute left-3 top-2.5 text-gray-400'></i>
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <label for="status_kelulusan" class="block text-sm font-medium text-gray-700 mb-2">Status Kelulusan</label>
                    <select id="status_kelulusan" name="status_kelulusan" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                        <option value="">Semua Status</option>
                        <option value="menunggu" {{ request('status_kelulusan') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="diluluskan" {{ request('status_kelulusan') == 'diluluskan' ? 'selected' : '' }}>Diluluskan</option>
                        <option value="ditolak" {{ request('status_kelulusan') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>

                <!-- Date Filter -->
                <div>
                    <label for="date_filter" class="block text-sm font-medium text-gray-700 mb-2">Tarikh Kehilangan</label>
                    <input type="date" 
                           id="date_filter" 
                           name="date_filter" 
                           value="{{ request('date_filter') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                </div>

                <!-- Actions -->
                <div class="flex items-end space-x-2">
                    <button type="submit" 
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors flex items-center">
                        <i class='bx bx-search mr-2'></i>
                        Cari
                    </button>
                    <a href="{{ route('admin.loss-writeoffs.index') }}" 
                       class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    <!-- Loss Reports Table Card -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <!-- Table Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Senarai Laporan Kehilangan</h2>
                    <p class="text-sm text-gray-600">Urus dan pantau semua laporan kehilangan aset</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">{{ $lossWriteoffs->total() }} laporan</span>
                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Kehilangan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarikh</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Kerugian</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($lossWriteoffs as $loss)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                                    <i class='bx bx-error-circle text-red-600'></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $loss->asset->nama_aset }}</div>
                                    <div class="text-sm text-gray-500">{{ $loss->asset->no_siri_pendaftaran }}</div>
                                    @if($loss->asset->masjidSurau)
                                        <div class="text-xs text-gray-400 flex items-center mt-1">
                                            <i class='bx bx-map mr-1'></i>
                                            {{ $loss->asset->masjidSurau->nama }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-3 py-1 text-xs font-semibold rounded-full 
                                @if($loss->jenis_kehilangan === 'Kehilangan') bg-yellow-100 text-yellow-800
                                @elseif($loss->jenis_kehilangan === 'Kecurian') bg-red-100 text-red-800
                                @elseif($loss->jenis_kehilangan === 'Kerosakan') bg-orange-100 text-orange-800
                                @elseif($loss->jenis_kehilangan === 'Kemalangan') bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $loss->jenis_kehilangan }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $loss->tarikh_kehilangan->format('d/m/Y') }}
                            <div class="text-xs text-gray-500">
                                {{ $loss->tarikh_kehilangan->diffForHumans() }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            RM {{ number_format($loss->nilai_kehilangan, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full 
                                @if($loss->status_kelulusan === 'menunggu') bg-amber-100 text-amber-800
                                @elseif($loss->status_kelulusan === 'diluluskan') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                <div class="w-2 h-2 
                                    @if($loss->status_kelulusan === 'menunggu') bg-amber-500
                                    @elseif($loss->status_kelulusan === 'diluluskan') bg-green-500
                                    @else bg-red-500 @endif rounded-full mr-2"></div>
                                {{ ucfirst($loss->status_kelulusan) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-3">
                                <a href="{{ route('admin.loss-writeoffs.show', $loss) }}" 
                                   class="w-8 h-8 bg-emerald-100 hover:bg-emerald-200 text-emerald-600 rounded-lg flex items-center justify-center transition-colors"
                                   title="Lihat">
                                    <i class='bx bx-show text-sm'></i>
                                </a>
                                
                                <a href="{{ route('admin.loss-writeoffs.edit', $loss) }}" 
                                   class="w-8 h-8 bg-amber-100 hover:bg-amber-200 text-amber-600 rounded-lg flex items-center justify-center transition-colors"
                                   title="Edit">
                                    <i class='bx bx-edit text-sm'></i>
                                </a>
                                
                                @if($loss->status_kelulusan === 'menunggu')
                                <form action="{{ route('admin.loss-writeoffs.approve', $loss) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="w-8 h-8 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg flex items-center justify-center transition-colors"
                                            title="Luluskan"
                                            onclick="return confirm('Luluskan laporan kehilangan ini?')">
                                        <i class='bx bx-check text-sm'></i>
                                    </button>
                                </form>
                                
                                <button type="button" 
                                        class="w-8 h-8 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg flex items-center justify-center transition-colors"
                                        title="Tolak"
                                        onclick="openRejectModal({{ $loss->id }})">
                                    <i class='bx bx-x text-sm'></i>
                                </button>
                                @endif
                                
                                @if(auth()->user()->role === 'admin')
                                <form action="{{ route('admin.loss-writeoffs.destroy', $loss) }}" method="POST" class="inline" 
                                      onsubmit="return confirm('Adakah anda pasti ingin memadamkan laporan ini?')">
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
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class='bx bx-error-circle text-3xl text-gray-400'></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tiada Laporan Kehilangan</h3>
                                <p class="text-gray-500 text-sm mb-6 max-w-sm">
                                    Belum ada laporan kehilangan yang didaftarkan. Mulakan dengan menambah laporan kehilangan baharu.
                                </p>
                                <a href="{{ route('admin.loss-writeoffs.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded-lg transition-colors shadow-sm">
                                    <i class='bx bx-plus mr-2'></i>
                                    Tambah Laporan Kehilangan
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($lossWriteoffs->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 rounded-b-xl">
            {{ $lossWriteoffs->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-xl bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class='bx bx-x text-red-600 text-2xl'></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tolak Laporan Kehilangan</h3>
            <p class="text-sm text-gray-600 mb-4">Sila berikan sebab penolakan untuk laporan ini.</p>
            
            <form id="rejectForm" method="POST" class="mt-4">
                @csrf
                <div class="text-left">
                    <label for="sebab_penolakan" class="block text-sm font-medium text-gray-700 mb-2">Sebab Penolakan</label>
                    <textarea name="sebab_penolakan" 
                              id="sebab_penolakan" 
                              rows="3" 
                              required
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors"
                              placeholder="Masukkan sebab penolakan..."></textarea>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" 
                            onclick="closeRejectModal()"
                            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                        Batal
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                        Tolak Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openRejectModal(lossId) {
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        form.action = `/admin/loss-writeoffs/${lossId}/reject`;
        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeRejectModal() {
        const modal = document.getElementById('rejectModal');
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
        document.getElementById('sebab_penolakan').value = '';
    }

    // Close modal when clicking outside
    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRejectModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeRejectModal();
        }
    });
</script>
@endpush
@endsection 