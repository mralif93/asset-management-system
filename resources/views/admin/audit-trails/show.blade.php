@extends('layouts.admin')

@section('title', 'Detail Log Audit')
@section('page-title', 'Detail Log Audit')
@section('page-description', 'Maklumat lengkap aktiviti sistem')

@section('content')
<div class="p-6">
    <!-- Navigation Breadcrumb -->
    <div class="flex items-center space-x-2 mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:text-emerald-600">
            <i class='bx bx-home'></i>
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <a href="{{ route('admin.audit-trails.index') }}" class="text-gray-500 hover:text-emerald-600">
            Log Audit
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">Detail #{{ $auditTrail->id }}</span>
    </div>

    <!-- Actions -->
    <div class="flex justify-end space-x-3 mb-6">
        <a href="{{ route('admin.audit-trails.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
            <i class='bx bx-arrow-back mr-2'></i>
            Kembali
        </a>
        @if($auditTrail->user_id)
            <a href="{{ route('admin.audit-trails.index', ['user_id' => $auditTrail->user_id]) }}" 
               class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                <i class='bx bx-user mr-2'></i>
                Lihat Log Pengguna Ini
            </a>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Audit Trail Details -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Aktiviti</h3>
                        <div class="flex items-center space-x-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($auditTrail->status == 'success') bg-green-100 text-green-800
                                @elseif($auditTrail->status == 'failed') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($auditTrail->status) }}
                            </span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($auditTrail->action == 'CREATE') bg-green-100 text-green-800
                                @elseif($auditTrail->action == 'UPDATE') bg-blue-100 text-blue-800
                                @elseif($auditTrail->action == 'DELETE') bg-red-100 text-red-800
                                @elseif($auditTrail->action == 'LOGIN') bg-purple-100 text-purple-800
                                @elseif($auditTrail->action == 'LOGOUT') bg-gray-100 text-gray-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $auditTrail->formatted_action }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">ID Aktiviti</label>
                                <p class="text-gray-900 font-mono">#{{ $auditTrail->id }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tarikh & Masa</label>
                                <p class="text-gray-900">{{ $auditTrail->created_at->format('d/m/Y H:i:s') }}</p>
                                <p class="text-sm text-gray-500">{{ $auditTrail->created_at->diffForHumans() }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Penerangan</label>
                                <p class="text-gray-900">{{ $auditTrail->description ?? '-' }}</p>
                            </div>

                            @if($auditTrail->error_message)
                                <div>
                                    <label class="block text-sm font-medium text-red-700 mb-1">Mesej Ralat</label>
                                    <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                        <p class="text-red-800 text-sm">{{ $auditTrail->error_message }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Model Information -->
                        <div class="space-y-4">
                            @if($auditTrail->model_type)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Model</label>
                                    <p class="text-gray-900">{{ class_basename($auditTrail->model_type) }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">ID Model</label>
                                    <p class="text-gray-900 font-mono">#{{ $auditTrail->model_id }}</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Model</label>
                                    <p class="text-gray-900">{{ $auditTrail->model_name ?? '-' }}</p>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Peristiwa</label>
                                <p class="text-gray-900 capitalize">{{ $auditTrail->event_type ?? 'web' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Information -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Maklumat Pengguna</h3>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pengguna</label>
                                <p class="text-gray-900">{{ $auditTrail->user_name ?? 'Sistem' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <p class="text-gray-900">{{ $auditTrail->user_email ?? '-' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Peranan</label>
                                <p class="text-gray-900">{{ $auditTrail->user_role ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">IP Address</label>
                                <p class="text-gray-900 font-mono">{{ $auditTrail->ip_address ?? '-' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pelayar</label>
                                <p class="text-gray-900">{{ $auditTrail->browser }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Platform</label>
                                <p class="text-gray-900">{{ $auditTrail->platform }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Request Information -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Maklumat Permintaan</h3>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kaedah HTTP</label>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                    @if($auditTrail->method == 'GET') bg-blue-100 text-blue-800
                                    @elseif($auditTrail->method == 'POST') bg-green-100 text-green-800
                                    @elseif($auditTrail->method == 'PUT') bg-yellow-100 text-yellow-800
                                    @elseif($auditTrail->method == 'DELETE') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ $auditTrail->method ?? '-' }}
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Route</label>
                                <p class="text-gray-900 font-mono text-sm">{{ $auditTrail->route_name ?? '-' }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            @if($auditTrail->url)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                        <p class="text-gray-900 font-mono text-sm break-all">{{ $auditTrail->url }}</p>
                                    </div>
                                </div>
                            @endif

                            @if($auditTrail->user_agent)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">User Agent</label>
                                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                                        <p class="text-gray-900 text-sm break-all">{{ $auditTrail->user_agent }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Changes Information -->
            @if($auditTrail->changes_summary)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Perubahan Data</h3>
                    </div>

                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($auditTrail->changes_summary as $change)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <h4 class="font-medium text-gray-900 mb-3">{{ ucfirst(str_replace('_', ' ', $change['field'])) }}</h4>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-red-700 mb-1">Nilai Lama</label>
                                            <div class="bg-red-50 border border-red-200 rounded p-2">
                                                <p class="text-red-800 text-sm">{{ $change['old'] ?? 'Kosong' }}</p>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-green-700 mb-1">Nilai Baharu</label>
                                            <div class="bg-green-50 border border-green-200 rounded p-2">
                                                <p class="text-green-800 text-sm">{{ $change['new'] ?? 'Kosong' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Raw Data -->
            @if($auditTrail->old_values || $auditTrail->new_values || $auditTrail->additional_data)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Data Mentah</h3>
                    </div>

                    <div class="p-6 space-y-6">
                        @if($auditTrail->old_values)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Lama (JSON)</label>
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <pre class="text-sm text-gray-900 whitespace-pre-wrap">{{ json_encode($auditTrail->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                </div>
                            </div>
                        @endif

                        @if($auditTrail->new_values)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Nilai Baharu (JSON)</label>
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <pre class="text-sm text-gray-900 whitespace-pre-wrap">{{ json_encode($auditTrail->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                </div>
                            </div>
                        @endif

                        @if($auditTrail->additional_data)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Data Tambahan (JSON)</label>
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                    <pre class="text-sm text-gray-900 whitespace-pre-wrap">{{ json_encode($auditTrail->additional_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Info -->
            <div class="bg-indigo-50 rounded-xl border border-indigo-200 p-6">
                <h3 class="text-lg font-semibold text-indigo-900 mb-4">Ringkasan Cepat</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-indigo-700">ID</span>
                        <span class="text-sm font-mono text-indigo-900">#{{ $auditTrail->id }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-indigo-700">Tindakan</span>
                        <span class="text-sm font-medium text-indigo-900">{{ $auditTrail->formatted_action }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-indigo-700">Status</span>
                        <span class="text-sm font-medium text-indigo-900">{{ ucfirst($auditTrail->status) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-indigo-700">Masa</span>
                        <span class="text-sm text-indigo-900">{{ $auditTrail->created_at->format('H:i:s') }}</span>
                    </div>
                </div>
            </div>

            <!-- Related Activities -->
            @if($relatedTrails->isNotEmpty())
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Aktiviti Berkaitan</h3>
                        <p class="text-sm text-gray-500 mt-1">
                            Aktiviti lain untuk {{ class_basename($auditTrail->model_type) }} #{{ $auditTrail->model_id }}
                        </p>
                    </div>

                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($relatedTrails as $related)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                                            @if($related->action == 'CREATE') bg-green-100 text-green-800
                                            @elseif($related->action == 'UPDATE') bg-blue-100 text-blue-800
                                            @elseif($related->action == 'DELETE') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ $related->formatted_action }}
                                        </span>
                                        <span class="text-xs text-gray-500">{{ $related->created_at->format('d/m H:i') }}</span>
                                    </div>
                                    <p class="text-sm text-gray-900">{{ $related->description }}</p>
                                    <p class="text-xs text-gray-500 mt-1">oleh {{ $related->user_name ?? 'Sistem' }}</p>
                                    <div class="mt-2">
                                        <a href="{{ route('admin.audit-trails.show', $related) }}" 
                                           class="text-xs text-emerald-600 hover:text-emerald-900">
                                            Lihat Detail →
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- System Info -->
            <div class="bg-amber-50 rounded-xl border border-amber-200 p-6">
                <h3 class="text-lg font-semibold text-amber-900 mb-4">Maklumat Sistem</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-amber-700">Jenis Peristiwa</span>
                        <span class="text-sm font-medium text-amber-900 capitalize">{{ $auditTrail->event_type ?? 'web' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-amber-700">Kaedah</span>
                        <span class="text-sm font-mono text-amber-900">{{ $auditTrail->method ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-amber-700">IP</span>
                        <span class="text-sm font-mono text-amber-900">{{ $auditTrail->ip_address ?? '-' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-amber-700">Dicipta</span>
                        <span class="text-sm text-amber-900">{{ $auditTrail->created_at->diffForHumans() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 