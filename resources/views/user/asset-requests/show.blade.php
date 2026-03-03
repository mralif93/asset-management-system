@extends('layouts.user')

@section('title', 'Butiran Permohonan')
@section('page-title', 'Butiran Permohonan')

@section('content')
<div class="p-6 max-w-5xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Butiran Permohonan Pergerakan Aset</h2>
            <p class="text-gray-600 mt-1">Rujukan Permohonan: #{{ str_pad($assetRequest->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>
        <a href="{{ route('user.asset-requests.index') }}" class="text-gray-500 hover:text-gray-700 font-medium flex items-center gap-1">
            <i class='bx bx-arrow-back'></i> Kembali ke Senarai
        </a>
    </div>

    @if(session('success'))
        <div class="bg-emerald-50 text-emerald-600 p-4 rounded-lg mb-6 border border-emerald-100 flex items-center">
            <i class='bx bx-check-circle text-xl mr-3'></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Asset Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class='bx bx-box text-emerald-600 mr-2'></i> Maklumat Aset
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-y-4 gap-x-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Nama Aset</p>
                            <p class="font-medium text-gray-900">{{ $assetRequest->asset->nama_aset }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">No Siri Pendaftaran</p>
                            <p class="font-medium text-gray-900">{{ $assetRequest->asset->no_siri_pendaftaran }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Kategori</p>
                            <p class="font-medium text-gray-900">{{ $assetRequest->asset->kategori_aset ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Lokasi Semasa</p>
                            <p class="font-medium text-gray-900">{{ $assetRequest->lokasi_asal_spesifik ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Movement Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class='bx bx-current-location text-emerald-600 mr-2'></i> Maklumat Pergerakan
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-y-4 gap-x-6 mb-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Jenis Permohonan</p>
                            <p class="font-medium text-gray-900">{{ $assetRequest->jenis_pergerakan }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Tarikh Dimohon</p>
                            <p class="font-medium text-gray-900">{{ \Carbon\Carbon::parse($assetRequest->tarikh_permohonan)->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Destinasi (Masjid/Surau)</p>
                            <p class="font-medium text-gray-900">{{ $assetRequest->masjidSurauDestinasi->nama ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Lokasi Spesifik Tujuan</p>
                            <p class="font-medium text-gray-900">{{ $assetRequest->lokasi_destinasi_spesifik }}</p>
                        </div>
                        
                        @if($assetRequest->jenis_pergerakan === 'Peminjaman')
                            <div class="col-span-2 bg-blue-50 p-4 rounded-lg mt-2">
                                <p class="text-sm text-blue-600 mb-1 font-medium"><i class='bx bx-calendar-event mr-1'></i> Jangkaan Tarikh Pulang</p>
                                <p class="font-medium text-blue-900">{{ $assetRequest->tarikh_jangka_pulang ? \Carbon\Carbon::parse($assetRequest->tarikh_jangka_pulang)->format('d/m/Y') : 'Tidak ditetapkan' }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <div>
                        <p class="text-sm text-gray-500 mb-2">Tujuan Permohonan</p>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-gray-800 whitespace-pre-wrap">{{ $assetRequest->tujuan_pergerakan }}</div>
                    </div>
                </div>
            </div>
            
            @if($assetRequest->catatan)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <i class='bx bx-message-square-detail text-emerald-600 mr-2'></i> Catatan dari Pegawai Aset
                    </h3>
                </div>
                <div class="p-6">
                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100 text-gray-800 whitespace-pre-wrap">{{ $assetRequest->catatan }}</div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">Status Semasa</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-500">Status Permohonan:</span>
                        @if($assetRequest->status_pergerakan === 'Dimohon')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800">
                                SEDANG DIPROSES
                            </span>
                        @elseif($assetRequest->status_pergerakan === 'diluluskan_asal')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                DILULUSKAN
                            </span>
                        @elseif($assetRequest->status_pergerakan === 'ditolak_asal')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800">
                                DITOLAK
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800">
                                {{ strtoupper(str_replace('_', ' ', $assetRequest->status_pergerakan)) }}
                            </span>
                        @endif
                    </div>
                    
                    @if($assetRequest->status_pergerakan === 'Dimohon')
                        <div class="bg-blue-50 text-blue-800 p-3 rounded-md text-sm mb-6 border border-blue-100">
                            Permohonan anda sedang menunggu semakan dan kelulusan daripada Pegawai Aset lokasi anda.
                        </div>
                    @endif
                    
                    @if($assetRequest->pegawai_meluluskan)
                        <div class="pt-4 border-t border-gray-100 mt-4">
                            <p class="text-sm text-gray-500 mb-1">Diluluskan/Disemak Oleh</p>
                            <p class="font-medium text-gray-900">{{ $assetRequest->pegawai_meluluskan }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Action Card (Only if Dimohon) -->
            @if($assetRequest->status_pergerakan === 'Dimohon')
            <div class="bg-white rounded-xl shadow-sm border border-red-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-red-100 bg-red-50">
                    <h3 class="text-lg font-semibold text-red-800">Tindakan</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-4">Anda boleh membatalkan permohonan ini selagi ia belum diproses oleh Pegawai Aset.</p>
                    <form action="{{ route('user.asset-requests.destroy', $assetRequest->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-white border border-red-500 text-red-600 hover:bg-red-50 px-4 py-2.5 rounded-lg font-medium transition-colors" onclick="return confirm('Adakah anda pasti mahu membatalkan permohonan ini?')">
                            <i class='bx bx-x-circle mr-2'></i> Batalkan Permohonan
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
