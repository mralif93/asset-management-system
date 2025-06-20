@extends('layouts.admin')

@section('title', 'Butiran Pelupusan Aset')
@section('page-title', 'Butiran Pelupusan Aset')
@section('page-description', 'Paparan terperinci maklumat pelupusan aset')

@section('content')
<div class="p-6">
    <!-- Welcome Header -->
    <div class="bg-emerald-600 rounded-2xl p-8 text-white mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Pelupusan Aset</h1>
                <p class="text-emerald-100 text-lg">{{ $disposal->asset->nama_aset ?? 'Aset Tidak Diketahui' }}</p>
                <div class="flex items-center space-x-4 mt-4">
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-trash text-emerald-200'></i>
                        <span class="text-emerald-100">{{ $disposal->kaedah_pelupusan ?? $disposal->kaedah_pelupusan_dicadang ?? 'Kaedah Belum Ditentukan' }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 
                            @if(($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') === 'menunggu') bg-amber-400
                            @elseif(($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') === 'diluluskan') bg-green-400
                            @else bg-red-400 @endif rounded-full"></div>
                        <span class="text-emerald-100">{{ ucfirst($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <i class='bx bx-calendar text-emerald-200'></i>
                        <span class="text-emerald-100">{{ ($disposal->tarikh_pelupusan ?? $disposal->tarikh_permohonan ?? $disposal->created_at)->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-red-500 rounded-2xl flex items-center justify-center text-white shadow-xl">
                    <i class='bx bx-recycle text-4xl'></i>
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
        <a href="{{ route('admin.disposals.index') }}" class="text-gray-500 hover:text-emerald-600">
            Pengurusan Pelupusan
        </a>
        <i class='bx bx-chevron-right text-gray-400'></i>
        <span class="text-emerald-600 font-medium">Butiran Pelupusan</span>
    </div>

    <!-- Back Button & Actions -->
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('admin.disposals.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-colors">
            <i class='bx bx-arrow-back mr-2'></i>
            Kembali ke Senarai Pelupusan
        </a>
        
        <div class="flex space-x-3">
            @if(($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') === 'menunggu')
                <a href="{{ route('admin.disposals.edit', $disposal) }}" 
                   class="inline-flex items-center px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors">
                    <i class='bx bx-edit mr-2'></i>
                    Edit Pelupusan
                </a>
            @endif
            <button onclick="window.print()" 
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                <i class='bx bx-printer mr-2'></i>
                Cetak
            </button>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <!-- Asset Value -->
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 border border-blue-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-700">Nilai Asal Aset</p>
                    <p class="text-2xl font-bold text-blue-900">RM {{ number_format($disposal->asset->nilai_perolehan ?? 0, 2) }}</p>
                    <p class="text-xs text-blue-600 mt-1">Perolehan asal</p>
                </div>
                <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-dollar text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Disposal Value -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-green-700">Nilai Pelupusan</p>
                    <p class="text-2xl font-bold text-green-900">RM {{ number_format($disposal->nilai_pelupusan ?? 0, 2) }}</p>
                    <p class="text-xs text-green-600 mt-1">Nilai diperoleh</p>
                </div>
                <div class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-trending-up text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Asset Age -->
        <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-amber-700">Umur Aset</p>
                    @php
                        $disposalDate = $disposal->tarikh_pelupusan ?? $disposal->tarikh_permohonan ?? $disposal->created_at;
                        $acquisitionDate = $disposal->asset->tarikh_perolehan ?? $disposal->asset->created_at;
                        $assetAge = $disposalDate->diffInYears($acquisitionDate);
                    @endphp
                    <p class="text-2xl font-bold text-amber-900">{{ $assetAge }}</p>
                    <p class="text-xs text-amber-600 mt-1">Tahun digunakan</p>
                </div>
                <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center">
                    <i class='bx bx-time text-white text-xl'></i>
                </div>
            </div>
        </div>

        <!-- Loss Amount -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 border border-red-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-red-700">Kerugian/Keuntungan</p>
                    @php
                        $originalValue = $disposal->asset->nilai_perolehan ?? 0;
                        $disposalValue = $disposal->nilai_pelupusan ?? 0;
                        $loss = $originalValue - $disposalValue;
                    @endphp
                    <p class="text-2xl font-bold {{ $loss >= 0 ? 'text-red-900' : 'text-green-900' }}">
                        {{ $loss >= 0 ? '-' : '+' }}RM {{ number_format(abs($loss), 2) }}
                    </p>
                    <p class="text-xs {{ $loss >= 0 ? 'text-red-600' : 'text-green-600' }} mt-1">
                        {{ $loss >= 0 ? 'Kerugian' : 'Keuntungan' }}
                    </p>
                </div>
                <div class="w-12 h-12 {{ $loss >= 0 ? 'bg-red-500' : 'bg-green-500' }} rounded-xl flex items-center justify-center">
                    <i class='bx {{ $loss >= 0 ? 'bx-trending-down' : 'bx-trending-up' }} text-white text-xl'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column - Main Information -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Disposal Information Section -->
            <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-xl p-6 border border-emerald-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-emerald-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-trash text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Pelupusan</h3>
                        <p class="text-sm text-emerald-700">Butiran permohonan pelupusan aset</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Disposal Date -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Tarikh Pelupusan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">
                            {{ ($disposal->tarikh_pelupusan ?? $disposal->tarikh_permohonan ?? $disposal->created_at)->format('d/m/Y') }}
                        </dd>
                    </div>

                    <!-- Status -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-info-circle text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Status Kelulusan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">
                            @php
                                $status = $disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($status === 'menunggu') bg-amber-100 text-amber-800
                                @elseif($status === 'diluluskan') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($status) }}
                            </span>
                        </dd>
                    </div>

                    <!-- Reason -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-question-mark text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Sebab Pelupusan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">
                            {{ $disposal->sebab_pelupusan ?? $disposal->justifikasi_pelupusan ?? '-' }}
                        </dd>
                    </div>

                    <!-- Method -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-recycle text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Kaedah Pelupusan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">
                            @php
                                $method = $disposal->kaedah_pelupusan ?? $disposal->kaedah_pelupusan_dicadang ?? '-';
                            @endphp
                            <span class="px-3 py-1 rounded-full text-sm font-medium
                                @if($method === 'Dijual') bg-green-100 text-green-800
                                @elseif($method === 'Disumbangkan') bg-blue-100 text-blue-800
                                @elseif($method === 'Dikitar semula') bg-purple-100 text-purple-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ $method }}
                            </span>
                        </dd>
                    </div>

                    <!-- Disposal Value -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-dollar text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nilai Pelupusan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">
                            RM {{ number_format($disposal->nilai_pelupusan ?? 0, 2) }}
                        </dd>
                    </div>

                    <!-- Remaining Value -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calculator text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nilai Baki</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">
                            RM {{ number_format($disposal->nilai_baki ?? 0, 2) }}
                        </dd>
                    </div>

                    <!-- Requester -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200 md:col-span-2">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-user text-emerald-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Direkod Oleh</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">
                            {{ $disposal->user->name ?? $disposal->pegawai_pemohon ?? 'Tidak diketahui' }}
                            <span class="text-sm text-gray-500 block">{{ $disposal->created_at->format('d/m/Y H:i') }}</span>
                        </dd>
                    </div>
                </div>

                <!-- Notes -->
                @if($disposal->catatan ?? $disposal->catatan_pelupusan)
                <div class="mt-6 bg-white rounded-lg p-4 border border-gray-200">
                    <div class="flex items-center mb-2">
                        <i class='bx bx-note text-emerald-600 mr-2'></i>
                        <dt class="text-sm font-medium text-gray-600">Catatan Tambahan</dt>
                    </div>
                    <dd class="text-gray-900 mt-2">
                        {{ $disposal->catatan ?? $disposal->catatan_pelupusan }}
                    </dd>
                </div>
                @endif

                <!-- Rejection Reason -->
                @if($disposal->sebab_penolakan && ($disposal->status_kelulusan ?? $disposal->status_pelupusan) === 'ditolak')
                <div class="mt-6 bg-red-50 rounded-lg p-4 border border-red-200">
                    <div class="flex items-center mb-2">
                        <i class='bx bx-x-circle text-red-600 mr-2'></i>
                        <dt class="text-sm font-medium text-red-700">Sebab Penolakan</dt>
                    </div>
                    <dd class="text-red-900 mt-2">
                        {{ $disposal->sebab_penolakan }}
                    </dd>
                </div>
                @endif
            </div>

            <!-- Asset Information Section -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 border border-purple-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-purple-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-package text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Aset</h3>
                        <p class="text-sm text-purple-700">Butiran aset yang dilupuskan</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Asset Name -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-tag text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nama Aset</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $disposal->asset->nama_aset ?? '-' }}</dd>
                    </div>

                    <!-- Serial Number -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-barcode text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">No. Siri Pendaftaran</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $disposal->asset->no_siri_pendaftaran ?? '-' }}</dd>
                    </div>

                    <!-- Asset Type -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-category text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Jenis Aset</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $disposal->asset->jenis_aset ?? '-' }}</dd>
                    </div>

                    <!-- Original Value -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-dollar text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Nilai Perolehan Asal</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">RM {{ number_format($disposal->asset->nilai_perolehan ?? 0, 2) }}</dd>
                    </div>

                    <!-- Acquisition Date -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-calendar text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Tarikh Perolehan</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">
                            {{ $disposal->asset->tarikh_perolehan ? $disposal->asset->tarikh_perolehan->format('d/m/Y') : '-' }}
                        </dd>
                    </div>

                    <!-- Location -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-map text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Lokasi Terakhir</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $disposal->asset->lokasi_penempatan ?? '-' }}</dd>
                    </div>

                    <!-- Responsible Officer -->
                    <div class="bg-white rounded-lg p-4 border border-gray-200 md:col-span-2">
                        <div class="flex items-center mb-2">
                            <i class='bx bx-user-check text-purple-600 mr-2'></i>
                            <dt class="text-sm font-medium text-gray-600">Pegawai Bertanggungjawab</dt>
                        </div>
                        <dd class="text-lg font-semibold text-gray-900">{{ $disposal->asset->pegawai_bertanggungjawab_lokasi ?? '-' }}</dd>
                    </div>
                </div>
            </div>

            <!-- Images Section -->
            @if($disposal->gambar_pelupusan && count($disposal->gambar_pelupusan) > 0)
            <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl p-6 border border-amber-200">
                <div class="flex items-center mb-6">
                    <div class="w-12 h-12 bg-amber-500 rounded-xl flex items-center justify-center mr-4 shadow-lg">
                        <i class='bx bx-image text-white text-xl'></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Gambar/Dokumen Pelupusan</h3>
                        <p class="text-sm text-amber-700">Dokumentasi pelupusan aset</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($disposal->gambar_pelupusan as $index => $image)
                    <div class="relative group cursor-pointer" onclick="openImageModal('{{ Storage::url($image) }}', '{{ basename($image) }}')">
                        @if(in_array(strtolower(pathinfo($image, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                        <img src="{{ Storage::url($image) }}" 
                             alt="Gambar Pelupusan {{ $index + 1 }}" 
                             class="w-full h-32 object-cover rounded-lg border border-gray-200 group-hover:shadow-lg transition-shadow">
                        @else
                        <div class="w-full h-32 bg-gray-100 rounded-lg border border-gray-200 flex flex-col items-center justify-center group-hover:shadow-lg transition-shadow">
                            <i class='bx bx-file text-3xl text-gray-400 mb-2'></i>
                            <span class="text-xs text-gray-600 text-center px-2">{{ basename($image) }}</span>
                        </div>
                        @endif
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 rounded-lg transition-all flex items-center justify-center">
                            <i class='bx bx-search-alt text-white opacity-0 group-hover:opacity-100 text-2xl transition-opacity'></i>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Sidebar -->
        <div class="lg:col-span-1">
            <div class="sticky top-6 space-y-6">
                
                <!-- Disposal Card -->
                <div class="bg-gradient-to-br from-red-50 to-pink-100 rounded-xl p-6 border border-red-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-red-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-trash text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Kad Pelupusan</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">ID Pelupusan:</span>
                            <span class="text-sm font-medium">#{{ str_pad($disposal->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Tarikh Mohon:</span>
                            <span class="text-sm font-medium">{{ $disposal->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Kaedah:</span>
                            <span class="text-sm font-medium">{{ $disposal->kaedah_pelupusan ?? $disposal->kaedah_pelupusan_dicadang ?? '-' }}</span>
                        </div>
                        <hr class="border-red-200">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Status:</span>
                            <span class="text-sm font-medium">{{ ucfirst($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tindakan Pantas</h3>
                    
                    <div class="space-y-3">
                        @if(($disposal->status_kelulusan ?? $disposal->status_pelupusan ?? 'menunggu') === 'menunggu')
                        <form action="{{ route('admin.disposals.approve', $disposal) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 flex items-center justify-center gap-2 transition-colors">
                                <i class='bx bx-check'></i>
                                Luluskan
                            </button>
                        </form>
                        
                        <button onclick="showRejectModal()" 
                                class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 flex items-center justify-center gap-2 transition-colors">
                            <i class='bx bx-x'></i>
                            Tolak
                        </button>
                        @endif
                        
                        <a href="{{ route('admin.assets.show', $disposal->asset) }}" 
                           class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 flex items-center justify-center gap-2 transition-colors">
                            <i class='bx bx-package'></i>
                            Lihat Aset
                        </a>
                        
                        <button onclick="window.print()" 
                                class="w-full bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 flex items-center justify-center gap-2 transition-colors">
                            <i class='bx bx-printer'></i>
                            Cetak Laporan
                        </button>
                    </div>
                </div>

                <!-- Financial Summary -->
                <div class="bg-gradient-to-br from-green-50 to-emerald-100 rounded-xl p-6 border border-green-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-calculator text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Ringkasan Kewangan</h3>
                    </div>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Nilai Asal:</span>
                            <span class="text-sm font-medium">RM {{ number_format($disposal->asset->nilai_perolehan ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Nilai Pelupusan:</span>
                            <span class="text-sm font-medium">RM {{ number_format($disposal->nilai_pelupusan ?? 0, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">Nilai Baki:</span>
                            <span class="text-sm font-medium">RM {{ number_format($disposal->nilai_baki ?? 0, 2) }}</span>
                        </div>
                        <hr class="border-green-200">
                        @php
                            $originalValue = $disposal->asset->nilai_perolehan ?? 0;
                            $disposalValue = $disposal->nilai_pelupusan ?? 0;
                            $loss = $originalValue - $disposalValue;
                        @endphp
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-600">{{ $loss >= 0 ? 'Kerugian:' : 'Keuntungan:' }}</span>
                            <span class="text-sm font-medium {{ $loss >= 0 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $loss >= 0 ? '-' : '+' }}RM {{ number_format(abs($loss), 2) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- System Info -->
                <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200">
                    <div class="flex items-center mb-4">
                        <div class="w-10 h-10 bg-gray-500 rounded-lg flex items-center justify-center mr-3">
                            <i class='bx bx-info-circle text-white'></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">Maklumat Sistem</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dicipta:</span>
                            <span class="font-medium">{{ $disposal->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Dikemaskini:</span>
                            <span class="font-medium">{{ $disposal->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                        @if($disposal->tarikh_kelulusan ?? $disposal->tarikh_kelulusan_pelupusan)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tarikh Kelulusan:</span>
                            <span class="font-medium">{{ ($disposal->tarikh_kelulusan ?? $disposal->tarikh_kelulusan_pelupusan)->format('d/m/Y') }}</span>
                        </div>
                        @endif
                        @if($disposal->approver)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Diluluskan Oleh:</span>
                            <span class="font-medium">{{ $disposal->approver->name }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Tolak Permohonan Pelupusan</h3>
        <form action="{{ route('admin.disposals.reject', $disposal) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="sebab_penolakan" class="block text-sm font-medium text-gray-700 mb-2">
                    Sebab Penolakan <span class="text-red-500">*</span>
                </label>
                <textarea name="sebab_penolakan" 
                          id="sebab_penolakan" 
                          rows="4" 
                          required
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500"
                          placeholder="Nyatakan sebab penolakan..."></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" 
                        onclick="hideRejectModal()"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                    Batal
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                    Tolak Permohonan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-10 mx-auto p-5 w-11/12 max-w-4xl">
        <div class="bg-white rounded-lg shadow-lg">
            <div class="flex justify-between items-center p-4 border-b">
                <h3 id="imageModalTitle" class="text-lg font-semibold text-gray-900">Gambar Pelupusan</h3>
                <button onclick="closeImageModal()" class="text-gray-400 hover:text-gray-600">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
            <div class="p-4 text-center">
                <img id="imageModalContent" src="" alt="" class="max-w-full max-h-96 mx-auto rounded-lg">
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function showRejectModal() {
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function hideRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }

    function openImageModal(src, title) {
        document.getElementById('imageModalContent').src = src;
        document.getElementById('imageModalTitle').textContent = title;
        document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }

    // Close modals when clicking outside
    window.onclick = function(event) {
        const rejectModal = document.getElementById('rejectModal');
        const imageModal = document.getElementById('imageModal');
        
        if (event.target === rejectModal) {
            hideRejectModal();
        }
        if (event.target === imageModal) {
            closeImageModal();
        }
    }
</script>
@endpush
@endsection 