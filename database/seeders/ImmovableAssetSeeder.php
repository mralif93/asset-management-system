<?php

namespace Database\Seeders;

use App\Models\ImmovableAsset;
use App\Models\MasjidSurau;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImmovableAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masjidSuraus = MasjidSurau::all();

        foreach ($masjidSuraus as $masjidSurau) {
            $this->createImmovableAssetsForMasjid($masjidSurau);
        }

        $this->command->info('Immovable assets seeded successfully!');
    }

    private function createImmovableAssetsForMasjid($masjidSurau)
    {
        // Base immovable assets for each masjid/surau
        $baseAssets = [
            [
                'nama_aset' => 'Bangunan Utama Masjid',
                'jenis_aset' => 'Bangunan',
                'alamat' => $masjidSurau->alamat,
                'no_hakmilik' => 'GM ' . rand(1000, 9999) . ' LOT ' . rand(100, 999),
                'no_lot' => 'LOT ' . rand(1000, 9999),
                'luas_tanah_bangunan' => rand(2000, 8000),
                'tarikh_perolehan' => Carbon::now()->subYears(rand(5, 25)),
                'sumber_perolehan' => 'Pembinaan Sendiri',
                'kos_perolehan' => rand(800000, 2000000),
                'keadaan_semasa' => 'Baik',
                'catatan' => 'Bangunan utama untuk aktiviti solat dan keagamaan. Bahan binaan: Konkrit Bertulang. ' . rand(1, 3) . ' tingkat.',
            ],
            [
                'nama_aset' => 'Dewan Serbaguna',
                'jenis_aset' => 'Bangunan',
                'alamat' => $masjidSurau->alamat,
                'no_hakmilik' => 'GM ' . rand(1000, 9999) . ' LOT ' . rand(100, 999),
                'no_lot' => 'LOT ' . rand(1000, 9999),
                'luas_tanah_bangunan' => rand(1000, 3000),
                'tarikh_perolehan' => Carbon::now()->subYears(rand(2, 15)),
                'sumber_perolehan' => 'Kontrak Pembinaan',
                'kos_perolehan' => rand(200000, 800000),
                'keadaan_semasa' => 'Baik',
                'catatan' => 'Dewan untuk majlis keramaian dan aktiviti masyarakat. Bahan binaan: Konkrit dan Bata. 1 tingkat.',
            ],
        ];

        // Create base assets
        foreach ($baseAssets as $assetData) {
            ImmovableAsset::create(array_merge($assetData, [
                'masjid_surau_id' => $masjidSurau->id,
            ]));
        }

        // Create additional infrastructure assets
        $this->createInfrastructureAssets($masjidSurau);
    }

    private function createInfrastructureAssets($masjidSurau)
    {
        $infrastructureAssets = [
            [
                'nama_aset' => 'Menara Air',
                'jenis_aset' => 'Infrastruktur',
                'alamat' => $masjidSurau->alamat,
                'no_hakmilik' => 'GM ' . rand(1000, 9999) . ' LOT ' . rand(100, 999),
                'no_lot' => 'LOT ' . rand(1000, 9999),
                'luas_tanah_bangunan' => 100,
                'tarikh_perolehan' => Carbon::now()->subYears(rand(3, 15)),
                'sumber_perolehan' => 'Kontrak Khas',
                'kos_perolehan' => rand(50000, 150000),
                'keadaan_semasa' => 'Baik',
                'catatan' => 'Menara air untuk bekalan air ke seluruh premis. Tinggi: 15 meter. Bahan: Konkrit Bertulang.',
            ],
            [
                'nama_aset' => 'Surau Kecil',
                'jenis_aset' => 'Bangunan',
                'alamat' => $masjidSurau->alamat,
                'no_hakmilik' => 'GM ' . rand(1000, 9999) . ' LOT ' . rand(100, 999),
                'no_lot' => 'LOT ' . rand(1000, 9999),
                'luas_tanah_bangunan' => rand(500, 1200),
                'tarikh_perolehan' => Carbon::now()->subYears(rand(1, 8)),
                'sumber_perolehan' => 'Gotong-royong Jemaah',
                'kos_perolehan' => rand(80000, 200000),
                'keadaan_semasa' => 'Baik',
                'catatan' => 'Surau tambahan untuk jemaah wanita atau aktiviti kecil. Bahan: Bata dan Simen. 1 tingkat.',
            ],
            [
                'nama_aset' => 'Blok Bilik Air',
                'jenis_aset' => 'Kemudahan',
                'alamat' => $masjidSurau->alamat,
                'no_hakmilik' => 'GM ' . rand(1000, 9999) . ' LOT ' . rand(100, 999),
                'no_lot' => 'LOT ' . rand(1000, 9999),
                'luas_tanah_bangunan' => rand(300, 700),
                'tarikh_perolehan' => Carbon::now()->subYears(rand(2, 10)),
                'sumber_perolehan' => 'Kontraktor Tempatan',
                'kos_perolehan' => rand(30000, 80000),
                'keadaan_semasa' => 'Baik',
                'catatan' => 'Kemudahan bilik air dan tempat wudhu untuk jemaah. Bahan: Bata dan Jubin. 1 tingkat.',
            ],
        ];

        // Create some infrastructure assets (not all for every masjid)
        $numAssets = rand(1, 3);
        for ($i = 0; $i < $numAssets; $i++) {
            if (isset($infrastructureAssets[$i])) {
                ImmovableAsset::create(array_merge($infrastructureAssets[$i], [
                    'masjid_surau_id' => $masjidSurau->id,
                ]));
            }
        }

        // Create parking and landscape assets
        if (rand(0, 1)) { // 50% chance
            ImmovableAsset::create([
                'masjid_surau_id' => $masjidSurau->id,
                'nama_aset' => 'Tempat Letak Kereta',
                'jenis_aset' => 'Infrastruktur',
                'alamat' => $masjidSurau->alamat,
                'no_hakmilik' => 'GM ' . rand(1000, 9999) . ' LOT ' . rand(100, 999),
                'no_lot' => 'LOT ' . rand(1000, 9999),
                'luas_tanah_bangunan' => rand(1000, 3000),
                'tarikh_perolehan' => Carbon::now()->subYears(rand(1, 5)),
                'sumber_perolehan' => 'Kerja Sendiri',
                'kos_perolehan' => rand(20000, 60000),
                'keadaan_semasa' => 'Baik',
                'catatan' => 'Kawasan parking untuk kereta jemaah, kapasiti ' . rand(20, 100) . ' kereta. Bahan: Tar dan Simen.',
            ]);
        }

        if (rand(0, 1)) { // 50% chance
            ImmovableAsset::create([
                'masjid_surau_id' => $masjidSurau->id,
                'nama_aset' => 'Taman Landskap',
                'jenis_aset' => 'Landskap',
                'alamat' => $masjidSurau->alamat,
                'no_hakmilik' => 'GM ' . rand(1000, 9999) . ' LOT ' . rand(100, 999),
                'no_lot' => 'LOT ' . rand(1000, 9999),
                'luas_tanah_bangunan' => rand(500, 2000),
                'tarikh_perolehan' => Carbon::now()->subYears(rand(1, 8)),
                'sumber_perolehan' => 'Kontraktor Landskap',
                'kos_perolehan' => rand(10000, 40000),
                'keadaan_semasa' => 'Baik',
                'catatan' => 'Taman hiasan dengan pokok dan tanaman hias untuk keindahan. Bahan: Tanaman dan Batu Hias.',
            ]);
        }
    }
}
