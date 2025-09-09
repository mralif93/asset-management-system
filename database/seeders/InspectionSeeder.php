<?php

namespace Database\Seeders;

use App\Models\Inspection;
use App\Models\Asset;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InspectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = Asset::all();

        // Sample inspection data
        $inspections = [
            [
                'tarikh_pemeriksaan' => Carbon::now()->subDays(30),
                'pegawai_pemeriksa' => 'Ustaz Ahmad bin Ali',
                'kondisi_aset' => 'Sedang Digunakan',
                'lokasi_semasa_pemeriksaan' => 'Pejabat Pentadbiran',
                'cadangan_tindakan' => 'Kemas kini antivirus',
                'catatan_pemeriksa' => 'Komputer berfungsi dengan baik, perlu kemas kini antivirus',
            ],
            [
                'tarikh_pemeriksaan' => Carbon::now()->subDays(25),
                'pegawai_pemeriksa' => 'Encik Mahmud bin Hassan',
                'kondisi_aset' => 'Sedang Digunakan',
                'lokasi_semasa_pemeriksaan' => 'Stor Peralatan',
                'cadangan_tindakan' => 'Tiada tindakan diperlukan',
                'catatan_pemeriksa' => 'Kerusi dalam keadaan baik dan bersih',
            ],
            [
                'tarikh_pemeriksaan' => Carbon::now()->subDays(20),
                'pegawai_pemeriksa' => 'Ustaz Ahmad bin Ali',
                'kondisi_aset' => 'Rosak',
                'lokasi_semasa_pemeriksaan' => 'Dewan Solat Utama',
                'cadangan_tindakan' => 'Servis pembersihan filter',
                'catatan_pemeriksa' => 'Penyaman udara perlu servis filter, bunyi agak bising',
            ],
            [
                'tarikh_pemeriksaan' => Carbon::now()->subDays(15),
                'pegawai_pemeriksa' => 'Haji Ibrahim bin Yusof',
                'kondisi_aset' => 'Sedang Digunakan',
                'lokasi_semasa_pemeriksaan' => 'Bilik Mesyuarat',
                'cadangan_tindakan' => 'Tiada tindakan diperlukan',
                'catatan_pemeriksa' => 'Meja dalam keadaan baik, permukaannya licin dan bersih',
            ],
            [
                'tarikh_pemeriksaan' => Carbon::now()->subDays(10),
                'pegawai_pemeriksa' => 'Encik Rosli bin Ahmad',
                'kondisi_aset' => 'Sedang Digunakan',
                'lokasi_semasa_pemeriksaan' => 'Dewan Solat',
                'cadangan_tindakan' => 'Pembersihan berkala',
                'catatan_pemeriksa' => 'Kipas berfungsi dengan baik, perlu dibersihkan',
            ],
        ];

        // Create inspections for existing assets
        foreach ($inspections as $index => $inspectionData) {
            if ($index < $assets->count()) {
                $asset = $assets[$index];
                
                Inspection::create(array_merge($inspectionData, [
                    'asset_id' => $asset->id,
                ]));
            }
        }

        // Create additional random inspections
        $this->createAdditionalInspections($assets);

        $this->command->info('Inspections seeded successfully!');
    }

    private function createAdditionalInspections($assets)
    {
        $kondisiAset = ['Sedang Digunakan', 'Tidak Digunakan', 'Rosak', 'Sedang Diselenggara', 'Hilang'];
        $pegawaiPemeriksa = [
            'Ustaz Ahmad bin Ali',
            'Haji Ibrahim bin Yusof',
            'Encik Mahmud bin Hassan',
            'Encik Rosli bin Ahmad',
            'Ustaz Rahman bin Omar',
            'Haji Abdullah bin Yusof'
        ];

        $lokasiPemeriksaan = [
            'Pejabat Pentadbiran',
            'Dewan Solat Utama',
            'Bilik Mesyuarat',
            'Ruang Tamu',
            'Bilik Stor',
            'Dewan Ceramah',
            'Ruang Kelas Tadika',
            'Tempat Letak Kereta',
            'Kedai Pembaikan',
            'Rumah Imam',
            'Surau Kawasan',
            'Dewan Majlis',
            'Bilik Wudhu',
            'Ruang Perpustakaan',
            'Dapur Masjid',
            'Tempat Wudu'
        ];

        $cadanganTindakan = [
            'Sedang Digunakan' => [
                'Tiada tindakan diperlukan',
                'Pembersihan berkala',
                'Penjagaan rutin',
                'Simpan di tempat selamat'
            ],
            'Tidak Digunakan' => [
                'Pindahkan ke lokasi yang sesuai',
                'Pemeriksaan berkala',
                'Simpan dengan selamat',
                'Tidak memerlukan tindakan segera'
            ],
            'Rosak' => [
                'Baik pulih segera',
                'Hantar ke kedai pembaikan',
                'Ganti bahagian yang rosak',
                'Pemeriksaan pakar'
            ],
            'Sedang Diselenggara' => [
                'Selesaikan penyelenggaraan',
                'Pemeriksaan selepas penyelenggaraan',
                'Ujian fungsi',
                'Dokumentasi penyelenggaraan'
            ],
            'Hilang' => [
                'Laporan kehilangan',
                'Pemeriksaan keselamatan',
                'Ganti aset jika perlu',
                'Kemaskini rekod aset'
            ]
        ];

        $catatanTemplate = [
            'Sedang Digunakan' => [
                'Aset dalam keadaan baik dan berfungsi normal',
                'Tiada masalah ditemui semasa pemeriksaan',
                'Aset well-maintained dan bersih',
                'Prestasi aset memuaskan'
            ],
            'Tidak Digunakan' => [
                'Aset tidak digunakan pada masa ini',
                'Disimpan dengan selamat di lokasi yang sesuai',
                'Tidak memerlukan tindakan segera',
                'Boleh digunakan apabila diperlukan'
            ],
            'Rosak' => [
                'Aset mengalami kerosakan dan tidak boleh digunakan',
                'Memerlukan pembaikan segera sebelum boleh digunakan',
                'Kerosakan menjejaskan fungsi utama aset',
                'Perlu tindakan pembaikan profesional'
            ],
            'Sedang Diselenggara' => [
                'Aset sedang dalam proses penyelenggaraan',
                'Penyelenggaraan dijalankan mengikut jadual',
                'Dijangka siap dalam masa terdekat',
                'Pemeriksaan berkala dijalankan'
            ],
            'Hilang' => [
                'Aset tidak ditemui di lokasi yang sepatutnya',
                'Laporan kehilangan telah dibuat',
                'Pemeriksaan keselamatan dijalankan',
                'Rekod aset perlu dikemaskini'
            ]
        ];

        // Create multiple inspections for each asset (historical data)
        foreach ($assets as $asset) {
            $numInspections = rand(1, 3); // 1-3 additional inspections per asset
            
            for ($i = 0; $i < $numInspections; $i++) {
                $kondisi = $kondisiAset[array_rand($kondisiAset)];
                $tarikhPemeriksaan = Carbon::now()->subDays(rand(5, 180));
                
                $inspection = [
                    'asset_id' => $asset->id,
                    'tarikh_pemeriksaan' => $tarikhPemeriksaan,
                    'pegawai_pemeriksa' => $pegawaiPemeriksa[array_rand($pegawaiPemeriksa)],
                    'kondisi_aset' => $kondisi,
                    'lokasi_semasa_pemeriksaan' => $lokasiPemeriksaan[array_rand($lokasiPemeriksaan)],
                    'cadangan_tindakan' => $cadanganTindakan[$kondisi][array_rand($cadanganTindakan[$kondisi])],
                    'catatan_pemeriksa' => $catatanTemplate[$kondisi][array_rand($catatanTemplate[$kondisi])],
                ];

                Inspection::create($inspection);
            }
        }
    }
}
