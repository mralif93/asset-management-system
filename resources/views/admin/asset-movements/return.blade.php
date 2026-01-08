@extends('layouts.admin')

@section('page-title', 'Pengurusan Pergerakan Aset')

@section('content')
    <div class="container mx-auto px-6 py-4">
        <div class="max-w-5xl mx-auto">
            <!-- Breadcrumbs -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm text-gray-500">
                    <li class="inline-flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">
                            <i class='bx bxs-home mr-2'></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <i class='bx bx-chevron-right text-gray-400'></i>
                            <a href="{{ route('admin.asset-movements.index') }}"
                                class="ml-1 hover:text-blue-600 transition-colors">Pergerakan Aset</a>
                        </div>
                    </li>
                    <li aria-current="page">
                        <div class="flex items-center">
                            <i class='bx bx-chevron-right text-gray-400'></i>
                            <span class="ml-1 text-gray-700 font-medium">Pulangkan Aset</span>
                        </div>
                    </li>
                </ol>
            </nav>

        <div class="max-w-5xl mx-auto pb-12">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-700 to-indigo-800 px-8 py-8 flex justify-between items-center text-white">
                <div>
                    <h2 class="text-3xl font-extrabold mb-2 tracking-tight">Pulangkan Aset</h2>
                    <div class="flex items-center space-x-2 text-blue-100 text-sm">
                        <i class='bx bx-info-circle'></i>
                        <p>Sila lengkapkan butiran dan tandatangan di bawah untuk pengesahan.</p>
                    </div>
                </div>
                <a href="{{ route('admin.asset-movements.index') }}" 
                   class="bg-white/10 hover:bg-white/20 text-white px-5 py-2.5 rounded-xl backdrop-blur-md transition-all text-sm font-semibold flex items-center border border-white/10 shadow-sm hover:shadow-md">
                    <i class='bx bx-arrow-back mr-2'></i> Kembali
                </a>
            </div>

            <div class="p-8 md:p-10">
                <!-- Asset Details Card -->
                <div class="bg-indigo-50/50 rounded-2xl p-6 border border-indigo-100/80 mb-10">
                    <h3 class="text-indigo-900 font-bold mb-5 flex items-center text-lg">
                        <div class="w-8 h-8 rounded-lg bg-indigo-100 flex items-center justify-center mr-3 text-indigo-600">
                            <i class='bx bx-cube text-xl'></i>
                        </div>
                        Maklumat Aset & Pergerakan
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                        <div class="space-y-4">
                            <div class="flex justify-between items-center border-b border-indigo-100 pb-2 border-dashed">
                                <span class="text-gray-500 text-sm font-medium">Aset</span>
                                <span class="font-bold text-gray-900 text-right">{{ $assetMovement->asset->nama_aset }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-indigo-100 pb-2 border-dashed">
                                <span class="text-gray-500 text-sm font-medium">No. Siri</span>
                                <span class="font-bold text-gray-900 text-right font-mono text-xs bg-white px-2 py-1 rounded border border-indigo-100">{{ $assetMovement->asset->no_siri_pendaftaran }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-indigo-100 pb-2 border-dashed">
                                <span class="text-gray-500 text-sm font-medium">Jenis Pergerakan</span>
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold bg-blue-100 text-blue-700 uppercase tracking-wide">{{ $assetMovement->jenis_pergerakan }}</span>
                            </div>
                        </div>
                        <div class="space-y-4">
                             <div class="flex justify-between items-center border-b border-indigo-100 pb-2 border-dashed">
                                <span class="text-gray-500 text-sm font-medium">Lokasi Asal (Dari)</span>
                                <span class="font-semibold text-gray-900 text-right">{{ $assetMovement->masjidSurauAsal->nama }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-indigo-100 pb-2 border-dashed">
                                <span class="text-gray-500 text-sm font-medium">Lokasi Destinasi (Ke)</span>
                                <span class="font-semibold text-gray-900 text-right">{{ $assetMovement->masjidSurauDestinasi->nama }}</span>
                            </div>
                            <div class="flex justify-between items-center border-b border-indigo-100 pb-2 border-dashed">
                                <span class="text-gray-500 text-sm font-medium">Peminjam</span>
                                <div class="flex items-center justify-end">
                                    <div class="w-6 h-6 rounded-full bg-gray-200 flex items-center justify-center mr-2 text-xs font-bold text-gray-500">
                                        {{ substr($assetMovement->nama_peminjam_pegawai_bertanggungjawab, 0, 1) }}
                                    </div>
                                    <span class="font-semibold text-gray-900">{{ $assetMovement->nama_peminjam_pegawai_bertanggungjawab }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.asset-movements.process-return', $assetMovement) }}" method="POST" id="returnForm" class="space-y-10">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Return Date -->
                        <div class="group">
                            <label for="tarikh_pulang_sebenar" class="block text-sm font-bold text-gray-700 mb-2 group-hover:text-blue-600 transition-colors">
                                Tarikh Pulang Sebenar <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="date" name="tarikh_pulang_sebenar" id="tarikh_pulang_sebenar"
                                       value="{{ old('tarikh_pulang_sebenar', date('Y-m-d')) }}"
                                       class="w-full rounded-xl border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition duration-200 h-12 px-4 cursor-pointer"
                                       required>
                            </div>
                            @error('tarikh_pulang_sebenar')
                                <p class="text-red-500 text-xs mt-1 font-medium flex items-center"><i class='bx bx-error-circle mr-1'></i> {{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="md:col-span-2 group">
                            <label for="catatan" class="block text-sm font-bold text-gray-700 mb-2 group-hover:text-blue-600 transition-colors">
                                Catatan Pemulangan
                            </label>
                            <textarea name="catatan" id="catatan" rows="3"
                                      class="w-full rounded-xl border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition duration-200 resize-none p-4"
                                      placeholder="Sila nyatakan keadaan aset semasa dipulangkan...">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <p class="text-red-500 text-xs mt-1 font-medium flex items-center"><i class='bx bx-error-circle mr-1'></i> {{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Signatures Section -->
                    <div>
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 border border-blue-100 shadow-sm">
                                <i class='bx bx-pen text-xl'></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Pengesahan Penerimaan</h3>
                                <p class="text-sm text-gray-500">Sila turunkan tandatangan digital di bawah.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Receiver Signature -->
                            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200 hover:border-blue-300 transition-colors duration-300">
                                <label class="block text-sm font-medium text-gray-700 mb-3 flex justify-between items-center">
                                    <span class="font-bold text-gray-800">Tandatangan Penerima</span>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 bg-emerald-100 px-2 py-0.5 rounded border border-emerald-200">Staf Bertugas</span>
                                </label>
                                <div class="relative bg-white rounded-xl shadow-sm border border-gray-300 overflow-hidden group">
                                    <canvas id="receiver-pad" class="w-full h-56 cursor-crosshair hover:bg-gray-50/30 transition-colors"></canvas>
                                    <div class="absolute inset-0 pointer-events-none border-2 border-dashed border-gray-200 m-2 rounded opacity-40"></div>
                                    <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <button type="button" onclick="clearSignature('receiver')" 
                                                class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-100 transition border border-red-200 font-semibold shadow-sm flex items-center">
                                            <i class='bx bx-refresh mr-1'></i> Padam
                                        </button>
                                    </div>
                                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none text-gray-100 text-5xl font-black opacity-40 select-none tracking-widest rotate-[-5deg]">
                                        SIGN HERE
                                    </div>
                                </div>
                                <input type="hidden" name="tandatangan_penerima" id="tandatangan_penerima" required>
                                <p class="text-xs text-gray-400 mt-2 text-center">Peno. Pegawai Aset</p>
                            </div>

                            <!-- Borrower Signature -->
                            <div class="bg-gray-50 p-5 rounded-2xl border border-gray-200 hover:border-blue-300 transition-colors duration-300">
                                <label class="block text-sm font-medium text-gray-700 mb-3 flex justify-between items-center">
                                    <span class="font-bold text-gray-800">Tandatangan Peminjam</span>
                                    <span class="text-[10px] font-bold uppercase tracking-wider text-blue-600 bg-blue-100 px-2 py-0.5 rounded border border-blue-200">Peminjam</span>
                                </label>
                                <div class="relative bg-white rounded-xl shadow-sm border border-gray-300 overflow-hidden group">
                                    <canvas id="borrower-pad" class="w-full h-56 cursor-crosshair hover:bg-gray-50/30 transition-colors"></canvas>
                                    <div class="absolute inset-0 pointer-events-none border-2 border-dashed border-gray-200 m-2 rounded opacity-40"></div>
                                    <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <button type="button" onclick="clearSignature('borrower')" 
                                                class="text-xs bg-red-50 text-red-600 px-3 py-1.5 rounded-lg hover:bg-red-100 transition border border-red-200 font-semibold shadow-sm flex items-center">
                                            <i class='bx bx-refresh mr-1'></i> Padam
                                        </button>
                                    </div>
                                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-none text-gray-100 text-5xl font-black opacity-40 select-none tracking-widest rotate-[-5deg]">
                                        SIGN HERE
                                    </div>
                                </div>
                                <input type="hidden" name="tandatangan_pemulangan" id="tandatangan_pemulangan" required>
                                <p class="text-xs text-gray-400 mt-2 text-center">Individu yang meminjam aset</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end items-center space-x-4 pt-8 border-t border-gray-100">
                        <a href="{{ route('admin.asset-movements.index') }}" 
                           class="px-6 py-3 bg-white border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-gray-50 hover:text-gray-900 transition-all shadow-sm hover:shadow active:scale-95">
                            Batal
                        </a>
                        <button type="submit" onclick="submitReturnForm(event)"
                                class="px-8 py-3 bg-gradient-to-br from-blue-600 to-indigo-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 flex items-center active:scale-95">
                            <i class='bx bx-check-double mr-2 text-xl'></i> Sahkan Pemulangan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
        <script>
            let receiverPad, borrowerPad;

            document.addEventListener('DOMContentLoaded', function () {
                // Initialize Receiver Pad
                const receiverCanvas = document.getElementById('receiver-pad');
                resizeCanvas(receiverCanvas);
                receiverPad = new SignaturePad(receiverCanvas, {
                    backgroundColor: 'rgb(249, 250, 251)', // gray-50
                    penColor: 'rgb(0, 0, 0)'
                });

                // Initialize Borrower Pad
                const borrowerCanvas = document.getElementById('borrower-pad');
                resizeCanvas(borrowerCanvas);
                borrowerPad = new SignaturePad(borrowerCanvas, {
                    backgroundColor: 'rgb(249, 250, 251)', // gray-50
                    penColor: 'rgb(0, 0, 0)'
                });

                // Handle resize
                window.addEventListener('resize', function () {
                    resizeCanvas(receiverCanvas);
                    resizeCanvas(borrowerCanvas);
                });
            });

            function resizeCanvas(canvas) {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);

                // If we want to keep the content on resize, we'd need to save/restore data here
                // For now, simpler to clear or let it be (SignaturePad clears on resize by default usually unless handled)
            }

            function clearSignature(type) {
                if (type === 'receiver' && receiverPad) receiverPad.clear();
                if (type === 'borrower' && borrowerPad) borrowerPad.clear();
            }

            function submitReturnForm(event) {
                event.preventDefault();

                let valid = true;
                let errorMessage = '';

                if (receiverPad.isEmpty()) {
                    valid = false;
                    errorMessage = 'Sila pastikan tandatangan penerima dilengkapkan.';
                } else if (borrowerPad.isEmpty()) {
                    valid = false;
                    errorMessage = 'Sila pastikan tandatangan peminjam dilengkapkan.';
                }

                if (!valid) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Tandatangan Tidak Lengkap',
                        text: errorMessage,
                        confirmButtonColor: '#ef4444'
                    });
                    return;
                }

                // Set hidden inputs
                document.getElementById('tandatangan_penerima').value = receiverPad.toDataURL();
                document.getElementById('tandatangan_pemulangan').value = borrowerPad.toDataURL();

                // Submit form
                document.getElementById('returnForm').submit();
            }
        </script>
    @endpush
@endsection