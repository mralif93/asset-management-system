@extends('layouts.user')

@section('title', 'Permohonan Aset')
@section('page-title', 'Permohonan Aset')

@section('content')
    <div class="p-6">
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Senarai Permohonan Anda</h2>
                <p class="text-gray-600 mt-1">Pantau status permohonan pergerakan aset anda di sini.</p>
            </div>
            <a href="{{ route('user.asset-requests.create') }}"
                class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-lg flex items-center gap-2 transition-colors duration-200">
                <i class='bx bx-plus-circle'></i>
                <span>Permohonan Baru</span>
            </a>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-600 p-4 rounded-lg mb-6 border border-emerald-100 flex items-center">
                <i class='bx bx-check-circle text-xl mr-3'></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 border border-red-100 flex items-center">
                <i class='bx bx-x-circle text-xl mr-3'></i>
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead class="bg-gray-50 border-b border-gray-200 text-gray-600 font-medium">
                        <tr>
                            <th class="py-4 px-6">Tarikh Mohon</th>
                            <th class="py-4 px-6">Aset</th>
                            <th class="py-4 px-6">Jenis</th>
                            <th class="py-4 px-6">Destinasi</th>
                            <th class="py-4 px-6">Status</th>
                            <th class="py-4 px-6 text-right">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-gray-700">
                        @forelse($requests as $request)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="py-4 px-6">
                                    {{ \Carbon\Carbon::parse($request->tarikh_permohonan)->format('d/m/Y') }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-medium text-gray-900">{{ $request->asset->nama_aset }}</div>
                                    <div class="text-xs text-gray-500">{{ $request->asset->no_siri_pendaftaran }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $request->jenis_pergerakan }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-medium">
                                        {{ $request->masjidSurauDestinasi->nama ?? $request->lokasi_destinasi_spesifik }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    @if($request->status_pergerakan === 'Dimohon')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class='bx bx-time mr-1'></i> Sedang Diproses
                                        </span>
                                    @elseif($request->status_pergerakan === 'diluluskan_asal')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class='bx bx-check-circle mr-1'></i> Diluluskan
                                        </span>
                                    @elseif($request->status_pergerakan === 'ditolak_asal')
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class='bx bx-x-circle mr-1'></i> Ditolak
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ str_replace('_', ' ', Str::title($request->status_pergerakan)) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right">
                                    <a href="{{ route('user.asset-requests.show', $request->id) }}"
                                        class="text-blue-600 hover:text-blue-900 ml-3">
                                        <i class='bx bx-show text-lg'></i>
                                    </a>

                                    @if($request->status_pergerakan === 'Dimohon')
                                        <form action="{{ route('user.asset-requests.destroy', $request->id) }}" method="POST"
                                            class="inline-block ml-3">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700"
                                                onclick="return confirm('Adakah anda pasti mahu membatalkan permohonan ini?')">
                                                <i class='bx bx-trash text-lg'></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 px-6 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class='bx bx-folder-open text-4xl mb-2 text-gray-300'></i>
                                        <p>Tiada rekod permohonan dijumpai.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($requests->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $requests->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection