@extends('layouts.admin')

@section('title', 'Panduan Pengguna')
@section('page-title', 'Panduan Pengguna Sistem')
@section('page-description', 'Rujukan langkah demi langkah dan contoh data untuk semua modul')

@section('content')
    <div class="p-6 space-y-6" x-data="{ openAll: false }">
        <div class="guide-hero rounded-2xl p-8 text-white shadow-lg relative overflow-hidden">
            <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/10 floating-orb"></div>
            <div class="absolute -left-6 -bottom-10 w-28 h-28 rounded-full bg-white/10 floating-orb-delayed"></div>
            <div class="relative z-10">
                <h1 class="text-3xl font-bold mb-2">Panduan Pengguna AssetFlow</h1>
                <p class="text-emerald-100">Ikuti langkah demi langkah bagi setiap modul. Gunakan contoh data sebagai
                    rujukan semasa daftar, import, semak dan eksport rekod.</p>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
                <h2 class="text-lg font-semibold text-gray-900">Aliran Kerja Cadangan</h2>
                <button type="button" @click="openAll = !openAll"
                    class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm rounded-lg transition-colors inline-flex items-center">
                    <i class='bx bx-expand-alt mr-2'></i>
                    <span x-text="openAll ? 'Tutup Semua Modul' : 'Buka Semua Modul'"></span>
                </button>
            </div>
            <p class="text-sm text-gray-600 mb-4">Aliran ini membantu pasukan mengurus data aset secara teratur dari
                pendaftaran hingga pelaporan rasmi.</p>
            <div class="space-y-3">
                <div class="p-4 rounded-lg bg-emerald-50 border border-emerald-100">
                    <div class="flex items-start">
                        <div class="w-9 h-9 rounded-lg bg-emerald-600 text-white flex items-center justify-center mr-3">
                            <i class='bx bx-box'></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-emerald-900">Fasa 1: Pendaftaran Aset</p>
                            <p class="text-sm text-emerald-800">Daftar Aset Alih dan Aset Tak Alih dengan maklumat lengkap
                                (jenis, nilai, lokasi, pegawai).</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 rounded-lg bg-blue-50 border border-blue-100">
                    <div class="flex items-start">
                        <div class="w-9 h-9 rounded-lg bg-blue-600 text-white flex items-center justify-center mr-3">
                            <i class='bx bx-cog'></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-blue-900">Fasa 2: Operasi Harian</p>
                            <p class="text-sm text-blue-800">Urus Pergerakan, Pemeriksaan, dan Penyelenggaraan untuk jejak
                                status aset serta tindakan susulan.</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 rounded-lg bg-amber-50 border border-amber-100">
                    <div class="flex items-start">
                        <div class="w-9 h-9 rounded-lg bg-amber-600 text-white flex items-center justify-center mr-3">
                            <i class='bx bx-shield-quarter'></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-amber-900">Fasa 3: Kawalan Risiko</p>
                            <p class="text-sm text-amber-800">Rekod Pelupusan dan Kehilangan/Hapus Kira mengikut prosedur
                                kelulusan dan dokumentasi sokongan.</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 rounded-lg bg-purple-50 border border-purple-100">
                    <div class="flex items-start">
                        <div class="w-9 h-9 rounded-lg bg-purple-600 text-white flex items-center justify-center mr-3">
                            <i class='bx bx-bar-chart-alt-2'></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-purple-900">Fasa 4: Pelaporan & Audit</p>
                            <p class="text-sm text-purple-800">Gunakan Export dan modul Laporan (BR-AMS/PDF) untuk semakan
                                pengurusan, audit dalaman, dan rujukan rasmi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @php
            $guides = [
                [
                    'icon' => 'bx-box',
                    'title' => 'Modul Aset Alih',
                    'steps' => [
                        'Klik Aset Alih > Tambah Aset.',
                        'Isi maklumat utama: Nama Aset, Jenis, Kategori, Nilai, Lokasi.',
                        'Simpan rekod dan semak di halaman senarai.',
                        'Gunakan Import Data untuk daftar pukal melalui template.',
                        'Gunakan Eksport Data untuk muat turun rekod semasa.',
                    ],
                    'sample' => [
                        'Nama Aset: Laptop Dell Latitude',
                        'No Siri: AMSM.001.ICT.26.0001',
                        'Jenis Aset: Peralatan ICT',
                        'Kategori: asset',
                        'Nilai: 3500.00',
                    ],
                ],
                [
                    'icon' => 'bx-transfer',
                    'title' => 'Modul Pergerakan Aset',
                    'steps' => [
                        'Klik Pergerakan Aset > Tambah Pergerakan.',
                        'Pilih aset, jenis pergerakan (Pemindahan/Peminjaman/Pulangan).',
                        'Isi lokasi asal, destinasi, tarikh dan pegawai bertanggungjawab.',
                        'Hantar permohonan dan proses kelulusan.',
                        'Eksport data mengikut filter status/jenis/lokasi.',
                    ],
                    'sample' => [
                        'Jenis: Peminjaman',
                        'Asal: MS001',
                        'Destinasi: MS014',
                        'Tarikh Pergerakan: 2026-03-07',
                        'Status: menunggu_kelulusan',
                    ],
                ],
                [
                    'icon' => 'bx-buildings',
                    'title' => 'Modul Aset Tak Alih',
                    'steps' => [
                        'Klik Aset Tak Alih > Tambah Aset Tak Alih.',
                        'Isi jenis (Tanah/Bangunan), alamat, no hakmilik/lot, kos perolehan.',
                        'Simpan rekod dan semak keadaan semasa aset.',
                        'Import untuk rekod pukal menggunakan template.',
                        'Eksport untuk laporan aset tak alih.',
                    ],
                    'sample' => [
                        'Nama: Bangunan Dewan Serbaguna',
                        'Jenis: Bangunan',
                        'No Hakmilik: GRN12345',
                        'No Lot: PT-778',
                        'Kos: 450000.00',
                    ],
                ],
                [
                    'icon' => 'bx-search-alt',
                    'title' => 'Modul Pemeriksaan',
                    'steps' => [
                        'Klik Pemeriksaan > Tambah Pemeriksaan.',
                        'Pilih aset dan isi tarikh serta kondisi aset.',
                        'Isi cadangan tindakan dan catatan pemeriksa.',
                        'Simpan untuk rekod audit dan tindakan susulan.',
                        'Import/eksport boleh guna filter kondisi dan tarikh.',
                    ],
                    'sample' => [
                        'Kondisi: Rosak',
                        'Tarikh: 2026-03-07',
                        'Cadangan: Penyelenggaraan',
                        'Pemeriksa: Ahmad Bin Ali',
                    ],
                ],
                [
                    'icon' => 'bx-wrench',
                    'title' => 'Modul Penyelenggaraan',
                    'steps' => [
                        'Klik Penyelenggaraan > Tambah Penyelenggaraan.',
                        'Pilih aset, jenis penyelenggaraan, tarikh dan kos.',
                        'Isi penyedia perkhidmatan, status dan butiran kerja.',
                        'Simpan rekod dan semak status (Selesai/Dalam Proses).',
                        'Eksport ikut jenis, status, bulan dan carian aset.',
                    ],
                    'sample' => [
                        'Jenis: Pembaikan',
                        'Kos: 250.00',
                        'Status: Dalam Proses',
                        'Penyedia: Syarikat Servis Maju',
                    ],
                ],
                [
                    'icon' => 'bx-trash',
                    'title' => 'Modul Pelupusan',
                    'steps' => [
                        'Klik Pelupusan > Mohon Pelupusan.',
                        'Pilih aset dan isi justifikasi serta kaedah dicadang.',
                        'Lengkapkan nilai pelupusan, catatan dan dokumen jika ada.',
                        'Hantar untuk kelulusan atau penolakan.',
                        'Eksport data menggunakan filter status dan tarikh.',
                    ],
                    'sample' => [
                        'Justifikasi: rosak_teruk',
                        'Kaedah: jualan',
                        'Status: Dimohon',
                        'Tarikh Permohonan: 2026-03-07',
                    ],
                ],
                [
                    'icon' => 'bx-error-circle',
                    'title' => 'Modul Kehilangan / Hapus Kira',
                    'steps' => [
                        'Klik Kehilangan > Tambah Laporan.',
                        'Pilih aset, jenis kejadian, sebab dan nilai kehilangan.',
                        'Isi tarikh laporan dan lampirkan dokumen sokongan.',
                        'Hantar untuk tindakan kelulusan.',
                        'Gunakan filter status/tarikh semasa eksport laporan.',
                    ],
                    'sample' => [
                        'Jenis: hilang',
                        'Sebab: kecurian',
                        'Status: Dilaporkan',
                        'Nilai Kehilangan: 1800.00',
                    ],
                ],
                [
                    'icon' => 'bx-bar-chart',
                    'title' => 'Modul Laporan',
                    'steps' => [
                        'Klik Laporan > pilih borang BR-AMS yang diperlukan.',
                        'Tetapkan filter seperti tahun/bulan/lokasi jika perlu.',
                        'Semak data ringkasan dan jadual.',
                        'Muat turun PDF untuk dokumentasi rasmi.',
                        'Gunakan export modul jika perlukan data mentah Excel.',
                    ],
                    'sample' => [
                        'BR-AMS-001: Senarai Aset Alih',
                        'BR-AMS-007: Laporan Pelupusan',
                        'BR-AMS-009: Kehilangan/Hapus Kira',
                    ],
                ],
                [
                    'icon' => 'bx-group',
                    'title' => 'Modul Pengguna & Tetapan',
                    'steps' => [
                        'Pentadbir: urus pengguna, peranan dan status akaun.',
                        'Tetapan Masjid/Surau: daftar lokasi dan kod rujukan.',
                        'Semak Log Audit untuk jejak aktiviti sistem.',
                        'Kemas kini profil dan kata laluan secara berkala.',
                    ],
                    'sample' => [
                        'Peranan: administrator / officer / user',
                        'Kod Masjid: MS001',
                        'Audit: Log masuk, cipta, kemas kini, padam',
                    ],
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 gap-6 items-start">
            @foreach($guides as $guide)
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden card-lift self-start"
                    x-data="{ open: false }"
                    x-effect="if (openAll) { open = true } else { open = false }">
                    <button type="button" @click="open = !open"
                        class="w-full p-6 text-left flex items-center justify-between transition-colors hover:bg-gray-50">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mr-3 icon-pulse">
                                <i class='bx {{ $guide['icon'] }} text-emerald-700 text-xl'></i>
                            </div>
                            <h3 class="font-semibold text-gray-900">{{ $guide['title'] }}</h3>
                        </div>
                        <i class='bx bx-chevron-down text-xl text-gray-400 transition-transform duration-300'
                            :class="open ? 'rotate-180 text-emerald-600' : ''"></i>
                    </button>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-1"
                        x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0"
                        x-transition:leave-end="opacity-0 -translate-y-1" class="px-6 pb-6">
                        <p class="text-sm font-semibold text-gray-700 mb-2">Langkah demi langkah:</p>
                        <ol class="list-decimal pl-5 text-sm text-gray-700 space-y-1 mb-4">
                            @foreach($guide['steps'] as $step)
                                <li>{{ $step }}</li>
                            @endforeach
                        </ol>

                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-600 mb-2">Contoh Data</p>
                            <ul class="text-sm text-gray-700 space-y-1">
                                @foreach($guide['sample'] as $sample)
                                    <li>• {{ $sample }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .guide-hero {
            background: linear-gradient(135deg, #059669, #10b981 55%, #34d399);
        }

        .card-lift {
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

        .card-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(16, 185, 129, .12);
            border-color: #a7f3d0;
        }

        .icon-pulse {
            animation: pulse-soft 1.8s ease-in-out infinite;
        }

        .floating-orb {
            animation: float-up 4s ease-in-out infinite;
        }

        .floating-orb-delayed {
            animation: float-up 5s ease-in-out infinite .6s;
        }

        @keyframes pulse-soft {
            0%,
            100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes float-up {
            0%,
            100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }
    </style>
@endpush
