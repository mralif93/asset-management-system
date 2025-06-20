@extends('layouts.admin')

@section('title', 'Pengurusan Masjid/Surau')
@section('page-title', 'Pengurusan Masjid/Surau')
@section('page-description', 'Urus maklumat masjid dan surau dalam sistem')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 rounded-2xl p-8 text-white mb-8 shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Pengurusan Masjid/Surau</h1>
                <p class="text-emerald-100 text-lg">Urus maklumat dan tetapan masjid serta surau</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-buildings text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $statistics['total_masjid_surau'] }} lokasi</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-box text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $statistics['total_assets'] }} aset</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <i class='bx bx-buildings text-6xl text-emerald-200 opacity-80'></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Total Masjid/Surau -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-buildings text-emerald-600 text-xl'></i>
                </div>
                <span class="text-sm text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full font-medium">Total</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $statistics['total_masjid_surau'] }}</h3>
            <p class="text-sm text-gray-600">Jumlah Lokasi</p>
        </div>

        <!-- Total Masjid -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-building text-blue-600 text-xl'></i>
                </div>
                <span class="text-sm text-blue-600 bg-blue-100 px-2 py-1 rounded-full font-medium">Masjid</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $statistics['total_masjid'] }}</h3>
            <p class="text-sm text-gray-600">Masjid</p>
        </div>

        <!-- Total Surau -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-home text-purple-600 text-xl'></i>
                </div>
                <span class="text-sm text-purple-600 bg-purple-100 px-2 py-1 rounded-full font-medium">Surau</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $statistics['total_surau'] }}</h3>
            <p class="text-sm text-gray-600">Surau</p>
        </div>

        <!-- Total Assets -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-box text-green-600 text-xl'></i>
                </div>
                <span class="text-sm text-green-600 bg-green-100 px-2 py-1 rounded-full font-medium">Aset</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $statistics['total_assets'] }}</h3>
            <p class="text-sm text-gray-600">Total Aset</p>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Add New Masjid/Surau -->
        <a href="{{ route('admin.masjid-surau.create') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-emerald-200 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center group-hover:bg-emerald-200 transition-colors">
                    <i class='bx bx-plus-circle text-emerald-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-emerald-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Tambah Masjid/Surau</h3>
            <p class="text-sm text-gray-600">Daftar lokasi baharu</p>
        </a>

        <!-- Export Data -->
        <button class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-blue-200 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <i class='bx bx-download text-blue-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-blue-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Eksport Data</h3>
            <p class="text-sm text-gray-600">Muat turun senarai</p>
        </button>

        <!-- Generate Report -->
        <a href="{{ route('admin.reports.assets-by-location') }}" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-purple-200 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                    <i class='bx bx-bar-chart-alt-2 text-purple-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-purple-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Laporan Lokasi</h3>
            <p class="text-sm text-gray-600">Aset mengikut lokasi</p>
        </a>

        <!-- Bulk Actions -->
        <button onclick="toggleBulkActions()" class="group bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg hover:border-amber-200 transition-all duration-300">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-amber-100 rounded-lg flex items-center justify-center group-hover:bg-amber-200 transition-colors">
                    <i class='bx bx-check-square text-amber-600 text-xl'></i>
                </div>
                <i class='bx bx-right-arrow-alt text-gray-400 group-hover:text-amber-600 transition-colors'></i>
            </div>
            <h3 class="font-semibold text-gray-900 mb-2">Tindakan Pukal</h3>
            <p class="text-sm text-gray-600">Pilih berbilang item</p>
        </button>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8 shadow-sm">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Carian dan Penapis</h2>
                <p class="text-sm text-gray-600">Cari dan tapis masjid/surau</p>
            </div>
            <i class='bx bx-search text-2xl text-gray-400'></i>
        </div>
        
        <form method="GET" action="{{ route('admin.masjid-surau.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Nama</label>
                <div class="relative">
                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                           placeholder="Nama masjid/surau..." 
                           class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center">
                        <i class='bx bx-search text-gray-400'></i>
                    </div>
                </div>
            </div>

            <div>
                <label for="jenis" class="block text-sm font-medium text-gray-700 mb-2">Jenis</label>
                <select name="jenis" id="jenis" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Semua Jenis</option>
                    <option value="Masjid" {{ request('jenis') == 'Masjid' ? 'selected' : '' }}>Masjid</option>
                    <option value="Surau" {{ request('jenis') == 'Surau' ? 'selected' : '' }}>Surau</option>
                </select>
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <select name="status" id="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    <option value="">Semua Status</option>
                    <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Tidak Aktif" {{ request('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg transition-colors flex items-center justify-center">
                    <i class='bx bx-search mr-2'></i>
                    Cari
                </button>
                <a href="{{ route('admin.masjid-surau.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium py-2 px-4 rounded-lg transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Masjid/Surau Table -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <!-- Table Header -->
        <div class="p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-gray-900">Senarai Masjid/Surau</h2>
                    <p class="text-sm text-gray-600">{{ $masjidSuraus->total() }} jumlah rekod</p>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-500">Halaman {{ $masjidSuraus->currentPage() }} dari {{ $masjidSuraus->lastPage() }}</span>
                    <div class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></div>
                </div>
            </div>
        </div>

        <!-- Bulk Actions Bar (Hidden by default) -->
        <div id="bulkActionsBar" class="hidden p-4 bg-amber-50 border-b border-amber-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <span class="text-sm font-medium text-amber-800">
                        <span id="selectedCount">0</span> item dipilih
                    </span>
                    <button onclick="selectAll()" class="text-sm text-amber-600 hover:text-amber-700">Pilih Semua</button>
                    <button onclick="clearSelection()" class="text-sm text-amber-600 hover:text-amber-700">Kosongkan</button>
                </div>
                <div class="flex items-center space-x-2">
                    <button onclick="bulkDelete()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                        <i class='bx bx-trash mr-1'></i>
                        Padam Terpilih
                    </button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" id="selectAllCheckbox" onchange="toggleAllSelection()" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Masjid/Surau</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aset</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($masjidSuraus as $masjidSurau)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" name="selected_ids[]" value="{{ $masjidSurau->id }}" 
                                   class="row-checkbox rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                                   onchange="updateBulkActions()">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center">
                                    <i class='bx bx-buildings text-emerald-600'></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $masjidSurau->nama }}</div>
                                    <div class="text-sm text-gray-500">{{ $masjidSurau->imam_ketua ?? 'Tiada maklumat' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full {{ $masjidSurau->jenis == 'Masjid' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                {{ $masjidSurau->jenis }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $masjidSurau->bandar }}, {{ $masjidSurau->negeri }}</div>
                            <div class="text-sm text-gray-500">{{ $masjidSurau->poskod }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-1">
                                <i class='bx bx-box text-emerald-500 text-sm'></i>
                                <span class="text-sm font-medium text-gray-900">{{ $masjidSurau->assets_count }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-1">
                                <i class='bx bx-group text-blue-500 text-sm'></i>
                                <span class="text-sm font-medium text-gray-900">{{ $masjidSurau->users_count }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.masjid-surau.toggle-status', $masjidSurau) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-full transition-colors {{ $masjidSurau->status == 'Aktif' ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                    <div class="w-2 h-2 {{ $masjidSurau->status == 'Aktif' ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-2"></div>
                                    {{ $masjidSurau->status }}
                                </button>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('admin.masjid-surau.show', $masjidSurau) }}" 
                               class="inline-flex items-center px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs font-medium rounded-lg transition-colors">
                                <i class='bx bx-show mr-1'></i>
                                Lihat
                            </a>
                            <a href="{{ route('admin.masjid-surau.edit', $masjidSurau) }}" 
                               class="inline-flex items-center px-3 py-1 bg-emerald-100 hover:bg-emerald-200 text-emerald-700 text-xs font-medium rounded-lg transition-colors">
                                <i class='bx bx-edit mr-1'></i>
                                Edit
                            </a>
                            <button onclick="confirmDelete({{ $masjidSurau->id }}, '{{ $masjidSurau->nama }}')" 
                                    class="inline-flex items-center px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 text-xs font-medium rounded-lg transition-colors">
                                <i class='bx bx-trash mr-1'></i>
                                Padam
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <i class='bx bx-buildings text-3xl text-gray-400'></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Tiada Masjid/Surau</h3>
                                <p class="text-gray-500 text-sm mb-4">Belum ada masjid atau surau didaftarkan.</p>
                                <a href="{{ route('admin.masjid-surau.create') }}" 
                                   class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition-colors">
                                    <i class='bx bx-plus mr-2'></i>
                                    Tambah Masjid/Surau
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($masjidSuraus->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $masjidSuraus->links() }}
        </div>
        @endif
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
        <p class="text-gray-700 mb-6">Adakah anda pasti untuk memadamkan <strong id="deleteName"></strong>?</p>
        <div class="flex justify-end space-x-3">
            <button onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-700 font-medium rounded-lg transition-colors">
                Batal
            </button>
            <form id="deleteForm" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                    Ya, Padam
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Bulk Delete Form -->
<form id="bulkDeleteForm" action="{{ route('admin.masjid-surau.bulk-delete') }}" method="POST" class="hidden">
    @csrf
    <div id="bulkDeleteIds"></div>
</form>

<script>
// Bulk actions functionality
let selectedIds = [];

function toggleBulkActions() {
    const bar = document.getElementById('bulkActionsBar');
    bar.classList.toggle('hidden');
}

function updateBulkActions() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    selectedIds = Array.from(checkboxes).map(cb => cb.value);
    
    const count = selectedIds.length;
    document.getElementById('selectedCount').textContent = count;
    
    if (count > 0) {
        document.getElementById('bulkActionsBar').classList.remove('hidden');
    } else {
        document.getElementById('bulkActionsBar').classList.add('hidden');
    }
    
    // Update select all checkbox
    const allCheckboxes = document.querySelectorAll('.row-checkbox');
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    selectAllCheckbox.checked = count === allCheckboxes.length;
    selectAllCheckbox.indeterminate = count > 0 && count < allCheckboxes.length;
}

function toggleAllSelection() {
    const selectAllCheckbox = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.row-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });
    
    updateBulkActions();
}

function selectAll() {
    document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = true);
    updateBulkActions();
}

function clearSelection() {
    document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = false);
    document.getElementById('selectAllCheckbox').checked = false;
    updateBulkActions();
}

function bulkDelete() {
    if (selectedIds.length === 0) return;
    
    if (confirm(`Adakah anda pasti untuk memadamkan ${selectedIds.length} item yang dipilih?`)) {
        const form = document.getElementById('bulkDeleteForm');
        const idsContainer = document.getElementById('bulkDeleteIds');
        
        idsContainer.innerHTML = '';
        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'ids[]';
            input.value = id;
            idsContainer.appendChild(input);
        });
        
        form.submit();
    }
}

// Delete confirmation modal
function confirmDelete(id, name) {
    document.getElementById('deleteName').textContent = name;
    document.getElementById('deleteForm').action = `/admin/masjid-surau/${id}`;
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