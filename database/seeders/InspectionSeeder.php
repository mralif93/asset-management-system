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
                'keadaan_aset' => 'Baik',
                'lokasi_semasa_pemeriksaan' => 'Pejabat Pentadbiran',
                'cadangan_tindakan' => 'Kemas kini antivirus',
                'catatan_pemeriksa' => 'Komputer berfungsi dengan baik, perlu kemas kini antivirus',
            ],
            [
                'tarikh_pemeriksaan' => Carbon::now()->subDays(25),
                'pegawai_pemeriksa' => 'Encik Mahmud bin Hassan',
                'keadaan_aset' => 'Baik',
                'lokasi_semasa_pemeriksaan' => 'Stor Peralatan',
                'cadangan_tindakan' => 'Tiada tindakan diperlukan',
                'catatan_pemeriksa' => 'Kerusi dalam keadaan baik dan bersih',
            ],
            [
                'tarikh_pemeriksaan' => Carbon::now()->subDays(20),
                'pegawai_pemeriksa' => 'Ustaz Ahmad bin Ali',
                'keadaan_aset' => 'Rosak Kecil',
                'lokasi_semasa_pemeriksaan' => 'Dewan Solat Utama',
                'cadangan_tindakan' => 'Servis pembersihan filter',
                'catatan_pemeriksa' => 'Penyaman udara perlu servis filter, bunyi agak bising',
            ],
            [
                'tarikh_pemeriksaan' => Carbon::now()->subDays(15),
                'pegawai_pemeriksa' => 'Haji Ibrahim bin Yusof',
                'keadaan_aset' => 'Baik',
                'lokasi_semasa_pemeriksaan' => 'Bilik Mesyuarat',
                'cadangan_tindakan' => 'Tiada tindakan diperlukan',
                'catatan_pemeriksa' => 'Meja dalam keadaan baik, permukaannya licin dan bersih',
            ],
            [
                'tarikh_pemeriksaan' => Carbon::now()->subDays(10),
                'pegawai_pemeriksa' => 'Encik Rosli bin Ahmad',
                'keadaan_aset' => 'Baik',
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
        $keadaanAset = ['Baik', 'Rosak Kecil', 'Rosak Teruk'];
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
            'Baik' => [
                'Tiada tindakan diperlukan',
                'Pembersihan berkala',
                'Penjagaan rutin',
                'Simpan di tempat selamat'
            ],
            'Rosak Kecil' => [
                'Servis pembersihan',
                'Pemeriksaan lanjut diperlukan',
                'Baik pulih kecil',
                'Ganti bahagian kecil'
            ],
            'Rosak Teruk' => [
                'Baik pulih segera',
                'Hantar ke kedai pembaikan',
                'Ganti bahagian utama',
                'Pemeriksaan pakar'
            ]
        ];

        $catatanTemplate = [
            'Baik' => [
                'Aset dalam keadaan baik dan berfungsi normal',
                'Tiada masalah ditemui semasa pemeriksaan',
                'Aset well-maintained dan bersih',
                'Prestasi aset memuaskan'
            ],
            'Rosak Kecil' => [
                'Terdapat masalah yang perlu diberi perhatian',
                'Aset masih boleh digunakan tetapi perlu servis',
                'Beberapa bahagian menunjukkan tanda-tanda haus',
                'Perlu pemantauan berkala'
            ],
            'Rosak Teruk' => [
                'Aset mengalami kerosakan dan tidak boleh digunakan',
                'Memerlukan pembaikan segera sebelum boleh digunakan',
                'Kerosakan menjejaskan fungsi utama aset',
                'Perlu tindakan pembaikan profesional'
            ]
        ];

        // Create multiple inspections for each asset (historical data)
        foreach ($assets as $asset) {
            $numInspections = rand(1, 3); // 1-3 additional inspections per asset
            
            for ($i = 0; $i < $numInspections; $i++) {
                $keadaan = $keadaanAset[array_rand($keadaanAset)];
                $tarikhPemeriksaan = Carbon::now()->subDays(rand(5, 180));
                
                $inspection = [
                    'asset_id' => $asset->id,
                    'tarikh_pemeriksaan' => $tarikhPemeriksaan,
                    'pegawai_pemeriksa' => $pegawaiPemeriksa[array_rand($pegawaiPemeriksa)],
                    'keadaan_aset' => $keadaan,
                    'lokasi_semasa_pemeriksaan' => $lokasiPemeriksaan[array_rand($lokasiPemeriksaan)],
                    'cadangan_tindakan' => $cadanganTindakan[$keadaan][array_rand($cadanganTindakan[$keadaan])],
                    'catatan_pemeriksa' => $catatanTemplate[$keadaan][array_rand($catatanTemplate[$keadaan])],
                ];

                Inspection::create($inspection);
            }
        }
    }
}
