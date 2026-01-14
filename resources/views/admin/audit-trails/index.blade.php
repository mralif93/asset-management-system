@extends('layouts.admin')

@section('title', 'Log Audit')
@section('page-title', 'Log Audit')
@section('page-description', 'Pantau semua aktiviti sistem dan pengguna')

@section('content')
    <div class="p-6">
        <!-- Welcome Header -->
        <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Sistem Log Audit</h1>
                    <p class="text-emerald-100 text-lg">Pantau dan jejak semua aktiviti dalam sistem</p>
                    <div class="flex items-center space-x-4 mt-4">
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-history text-emerald-200'></i>
                            <span class="text-emerald-100">{{ number_format($stats['total_trails']) }} jumlah log</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="w-3 h-3 bg-green-400 rounded-full"></div>
                            <span class="text-emerald-100">{{ number_format($stats['today_count']) }} hari ini</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class='bx bx-user text-emerald-200'></i>
                            <span class="text-emerald-100">{{ number_format($stats['unique_users']) }} pengguna aktif</span>
                        </div>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div
                        class="w-20 h-20 bg-emerald-500 rounded-2xl flex items-center justify-center text-3xl font-bold text-white shadow-xl">
                        <i class='bx bx-shield-check text-4xl'></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Navigation Breadcrumb -->
        <div class="flex items-center space-x-2 mb-6">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600">
                <i class='bx bx-home'></i>
            </a>
            <i class='bx bx-chevron-right text-gray-400'></i>
            <span class="text-emerald-600 font-medium">Log Audit</span>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Today's Activities -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-blue-700">Aktiviti Hari Ini</p>
                        <p class="text-2xl font-bold text-blue-900">{{ number_format($stats['today_count']) }}</p>
                        <p class="text-xs text-blue-600 mt-1">
                            @if($stats['yesterday_count'] > 0)
                                @php $change = (($stats['today_count'] - $stats['yesterday_count']) / $stats['yesterday_count']) * 100 @endphp
                                {{ $change > 0 ? '+' : '' }}{{ number_format($change, 1) }}% dari semalam
                            @else
                                Log hari ini
                            @endif
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                        <i class='bx bx-trending-up text-white text-xl'></i>
                    </div>
                </div>
            </div>

            <!-- Weekly Activities -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-green-700">Minggu Ini</p>
                        <p class="text-2xl font-bold text-green-900">{{ number_format($stats['week_count']) }}</p>
                        <p class="text-xs text-green-600 mt-1">7 hari terakhir</p>
                    </div>
                    <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                        <i class='bx bx-calendar-week text-white text-xl'></i>
                    </div>
                </div>
            </div>

            <!-- Failed Activities -->
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 border border-red-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-red-700">Aktiviti Gagal</p>
                        <p class="text-2xl font-bold text-red-900">{{ number_format($stats['failed_count']) }}</p>
                        <p class="text-xs text-red-600 mt-1">Perlu perhatian</p>
                    </div>
                    <div class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center">
                        <i class='bx bx-error-circle text-white text-xl'></i>
                    </div>
                </div>
            </div>

            <!-- Unique IPs -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-purple-700">IP Address Unik</p>
                        <p class="text-2xl font-bold text-purple-900">{{ number_format($stats['unique_ips']) }}</p>
                        <p class="text-xs text-purple-600 mt-1">Akses dari lokasi</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center">
                        <i class='bx bx-map text-white text-xl'></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Actions -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm mb-8">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Penapis & Tindakan</h3>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.audit-trails.export', request()->query()) }}"
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                            <i class='bx bx-download mr-2'></i>
                            Export Excel
                        </a>
                        <button type="button" onclick="openCleanupModal()"
                            class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                            <i class='bx bx-trash mr-2'></i>
                            Bersihkan Log Lama
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filter Form -->
            <form method="GET" action="{{ route('admin.audit-trails.index') }}" class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class='bx bx-search mr-1'></i>
                            Carian Umum
                        </label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama, email, penerangan..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <!-- User Filter -->
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class='bx bx-user mr-1'></i>
                            Pengguna
                        </label>
                        <select id="user_id" name="user_id"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Semua Pengguna</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Action Filter -->
                    <div>
                        <label for="action" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class='bx bx-cog mr-1'></i>
                            Tindakan
                        </label>
                        <select id="action" name="action"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Semua Tindakan</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ $action }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class='bx bx-check-circle mr-1'></i>
                            Status
                        </label>
                        <select id="status" name="status"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Semua Status</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date From -->
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class='bx bx-calendar mr-1'></i>
                            Dari Tarikh
                        </label>
                        <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>

                    <!-- Date To -->
                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class='bx bx-calendar mr-1'></i>
                            Hingga Tarikh
                        </label>
                        <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
                    <div class="flex space-x-3">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                            <i class='bx bx-filter mr-2'></i>
                            Tapis
                        </button>
                        <a href="{{ route('admin.audit-trails.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                            <i class='bx bx-x mr-2'></i>
                            Reset
                        </a>
                    </div>
                    <div class="text-sm text-gray-500">
                        Menunjukkan {{ $auditTrails->count() }} daripada {{ $auditTrails->total() }} rekod
                    </div>
                </div>
            </form>
        </div>

        <!-- Audit Trails Table -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Log Aktiviti Sistem</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tarikh/Masa
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pengguna
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tindakan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Model
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                IP Address
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tindakan
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($auditTrails as $trail)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>
                                        <div class="font-medium">{{ $trail->created_at->format('d/m/Y') }}</div>
                                        <div class="text-gray-500">{{ $trail->created_at->format('H:i:s') }}</div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-emerald-100 rounded-full flex items-center justify-center mr-3">
                                            <i class='bx bx-user text-emerald-600'></i>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $trail->user_name ?? 'Sistem' }}
                                            </div>
                                            @if($trail->user_email)
                                                <div class="text-sm text-gray-500">{{ $trail->user_email }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if($trail->action == 'CREATE') bg-green-100 text-green-800
                                            @elseif($trail->action == 'UPDATE') bg-blue-100 text-blue-800
                                            @elseif($trail->action == 'DELETE') bg-red-100 text-red-800
                                            @elseif($trail->action == 'LOGIN') bg-purple-100 text-purple-800
                                            @elseif($trail->action == 'LOGOUT') bg-gray-100 text-gray-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ $trail->formatted_action }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($trail->model_name)
                                        <div class="font-medium">{{ $trail->model_name }}</div>
                                        <div class="text-gray-500">{{ class_basename($trail->model_type) }}</div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if($trail->status == 'success') bg-green-100 text-green-800
                                            @elseif($trail->status == 'failed') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($trail->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <div>
                                        <div class="font-mono">{{ $trail->ip_address ?? '-' }}</div>
                                        @if($trail->user_agent)
                                            <div class="text-gray-500 text-xs">{{ $trail->browser }} / {{ $trail->platform }}</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.audit-trails.show', $trail) }}"
                                        class="text-emerald-600 hover:text-emerald-900">
                                        <i class='bx bx-show'></i>
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class='bx bx-history text-gray-400 text-4xl mb-4'></i>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tiada Log Audit</h3>
                                        <p class="text-gray-500">Belum ada aktiviti yang direkodkan mengikut kriteria yang
                                            dipilih.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($auditTrails->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $auditTrails->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Cleanup Modal -->
    <div id="cleanupModal" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-xl max-w-md w-full p-6">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                        <i class='bx bx-trash text-red-600'></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">Bersihkan Log Lama</h3>
                </div>

                <p class="text-gray-600 mb-6">
                    Pilih berapa hari log audit yang ingin dikekalkan. Log yang lebih lama akan dipadam secara kekal.
                </p>

                <form action="{{ route('admin.audit-trails.cleanup') }}" method="POST">
                    @csrf
                    <div class="mb-6">
                        <label for="days" class="block text-sm font-medium text-gray-700 mb-2">
                            Kekalkan log untuk berapa hari
                        </label>
                        <select id="days" name="days"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500">
                            <option value="30">30 hari</option>
                            <option value="60">60 hari</option>
                            <option value="90" selected>90 hari</option>
                            <option value="180">180 hari</option>
                            <option value="365">365 hari</option>
                        </select>
                    </div>

                    <div class="flex space-x-3">
                        <button type="submit"
                            class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors">
                            <i class='bx bx-trash mr-2'></i>
                            Padam Log Lama
                        </button>
                        <button type="button" onclick="closeCleanupModal()"
                            class="flex-1 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCleanupModal() {
            document.getElementById('cleanupModal').classList.remove('hidden');
        }

        function closeCleanupModal() {
            document.getElementById('cleanupModal').classList.add('hidden');
        }

        // Close modal on escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeCleanupModal();
            }
        });
    </script>
@endsection