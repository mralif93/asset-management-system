@extends('layouts.user')

@section('title', 'Mohon Pergerakan Aset')
@section('page-title', 'Mohon Pergerakan Aset')

@section('content')
    <div class="p-6">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-800">Borang Permohonan</h2>
                <p class="text-gray-600 mt-1">Sila lengkapkan butiran di bawah untuk memohon pergerakan atau pinjaman aset.
                </p>
            </div>
            <a href="{{ route('user.asset-requests.index') }}"
                class="text-gray-500 hover:text-gray-700 font-medium flex items-center gap-1">
                <i class='bx bx-arrow-back'></i> Kembali
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden max-w-4xl">
            <form action="{{ route('user.asset-requests.store') }}" method="POST" class="p-8">
                @csrf

                <!-- Asset Information Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4"><i
                            class='bx bx-box text-emerald-600 mr-2'></i>Maklumat Aset</h3>
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label for="asset_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Aset <span
                                    class="text-red-500">*</span></label>
                            <select name="asset_id" id="asset_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                                <option value="">Pilih aset dari senarai...</option>
                                @foreach($assets as $asset)
                                    <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                                        {{ $asset->no_siri_pendaftaran }} - {{ $asset->nama_aset }} (Lokasi Semasa:
                                        {{ $asset->lokasi_penempatan ?? 'Tidak dinyatakan' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('asset_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Movement Details Section -->
                <div class="mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4"><i
                            class='bx bx-transfer text-emerald-600 mr-2'></i>Butiran Pergerakan</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="jenis_pergerakan" class="block text-sm font-medium text-gray-700 mb-2">Jenis
                                Permohonan <span class="text-red-500">*</span></label>
                            <select name="jenis_pergerakan" id="jenis_pergerakan"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                                <option value="">Pilih Jenis...</option>
                                <option value="Pemindahan" {{ old('jenis_pergerakan') == 'Pemindahan' ? 'selected' : '' }}>
                                    Pemindahan (Kekal)</option>
                                <option value="Peminjaman" {{ old('jenis_pergerakan') == 'Peminjaman' ? 'selected' : '' }}>
                                    Peminjaman (Sementara)</option>
                            </select>
                            @error('jenis_pergerakan') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div id="return_date_container"
                            style="display: {{ old('jenis_pergerakan') == 'Peminjaman' ? 'block' : 'none' }};">
                            <label for="tarikh_jangka_pulang" class="block text-sm font-medium text-gray-700 mb-2">Jangkaan
                                Tarikh Pulang <span class="text-red-500">*</span></label>
                            <input type="date" name="tarikh_jangka_pulang" id="tarikh_jangka_pulang"
                                value="{{ old('tarikh_jangka_pulang') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 min="
                                {{ now()->format('Y-m-d') }}">
                            @error('tarikh_jangka_pulang') <span
                            class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="destination_masjid_surau_id"
                                class="block text-sm font-medium text-gray-700 mb-2">Masjid/Surau Destinasi <span
                                    class="text-red-500">*</span></label>
                            <select name="destination_masjid_surau_id" id="destination_masjid_surau_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                required>
                                <option value="">Pilih Lokasi Destinasi...</option>
                                @foreach($masjidSuraus as $ms)
                                    <option value="{{ $ms->id }}" {{ old('destination_masjid_surau_id') == $ms->id ? 'selected' : '' }}>{{ $ms->nama }}</option>
                                @endforeach
                            </select>
                            @error('destination_masjid_surau_id') <span
                            class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="lokasi_destinasi_spesifik"
                                class="block text-sm font-medium text-gray-700 mb-2">Lokasi Spesifik (Bilik/Kawasan) <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="lokasi_destinasi_spesifik" id="lokasi_destinasi_spesifik"
                                value="{{ old('lokasi_destinasi_spesifik') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                                placeholder="Cth: Bilik Mesyuarat Utama" required>
                            @error('lokasi_destinasi_spesifik') <span
                            class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="tujuan_pergerakan" class="block text-sm font-medium text-gray-700 mb-2">Tujuan
                            Permohonan <span class="text-red-500">*</span></label>
                        <textarea name="tujuan_pergerakan" id="tujuan_pergerakan" rows="3"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 placeholder-gray-400"
                            placeholder="Terangkan tujuan penggunaan dengan jelas untuk pertimbangan kelulusan..."
                            required>{{ old('tujuan_pergerakan') }}</textarea>
                        @error('tujuan_pergerakan') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t border-gray-100">
                    <a href="{{ route('user.asset-requests.index') }}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-lg font-medium transition-colors shadow-sm">
                        <i class='bx bx-send mr-2'></i> Hantar Permohonan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jenisSelect = document.getElementById('jenis_pergerakan');
            const returnDateContainer = document.getElementById('return_date_container');
            const returnDateInput = document.getElementById('tarikh_jangka_pulang');

            jenisSelect.addEventListener('change', function () {
                if (this.value === 'Peminjaman') {
                    returnDateContainer.style.display = 'block';
                    returnDateInput.setAttribute('required', 'required');
                } else {
                    returnDateContainer.style.display = 'none';
                    returnDateInput.removeAttribute('required');
                    returnDateInput.value = '';
                }
            });
        });
    </script>
@endsection