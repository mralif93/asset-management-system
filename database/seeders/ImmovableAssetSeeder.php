<?php

namespace Database\Seeders;

use App\Models\ImmovableAsset;
use App\Models\MasjidSurau;
use App\Helpers\AssetRegistrationNumber;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImmovableAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masjidSuraus = MasjidSurau::limit(5)->get();

        foreach ($masjidSuraus as $masjidSurau) {
            $this->createImmovableAssetsForMasjid($masjidSurau);
            // Clear any cached data between iterations
            DB::statement('PRAGMA foreign_keys = OFF');
            DB::statement('PRAGMA foreign_keys = ON');
        }

        $this->command->info('Immovable assets seeded successfully!');
    }

    private function createImmovableAssetsForMasjid(MasjidSurau $masjidSurau)
    {
        $sampleAssets = [
            [
                'nama_aset' => 'Bangunan Utama Masjid',
                'jenis_aset' => 'Harta Tak Alih',
                'alamat' => 'Lot 7663, Jalan Masjid, Seksyen 7',
                'no_lot' => '7663',
                'luas_tanah_bangunan' => 4664.00,
                'tarikh_perolehan' => Carbon::now()->subYears(rand(5, 20)),
                'sumber_perolehan' => 'Pembinaan Sendiri',
                'kos_perolehan' => 1819535.00,
                'keadaan_semasa' => 'Baik',
                'catatan' => 'Bangunan utama untuk aktiviti solat dan keagamaan. Bahan binaan: Konkrit Bertulang. 1 tingkat.',
            ],
            [
                'nama_aset' => 'Dewan Solat Tambahan',
                'jenis_aset' => 'Harta Tak Alih',
                'alamat' => 'Lot 7663, Jalan Masjid, Seksyen 7',
                'no_lot' => '7663',
                'luas_tanah_bangunan' => 1200.00,
                'tarikh_perolehan' => Carbon::now()->subYears(rand(2, 8)),
                'sumber_perolehan' => 'Pembinaan Sendiri',
                'kos_perolehan' => 450000.00,
                'keadaan_semasa' => 'Baik',
                'catatan' => 'Dewan solat tambahan untuk menampung jemaah pada waktu solat Jumaat dan perayaan.',
            ],
            [
                'nama_aset' => 'Tanah Wakaf Masjid',
                'jenis_aset' => 'Harta Tak Alih',
                'alamat' => 'Lot 7663, Jalan Masjid, Seksyen 7',
                'no_lot' => '7663',
                'luas_tanah_bangunan' => 10000.00,
                'tarikh_perolehan' => Carbon::now()->subYears(rand(20, 40)),
                'sumber_perolehan' => 'Wakaf',
                'kos_perolehan' => 2500000.00,
                'keadaan_semasa' => 'Baik',
                'catatan' => 'Tanah wakaf untuk pembangunan masjid dan kemudahan berkaitan.',
            ],
            [
                'nama_aset' => 'Dewan Serba Guna',
                'jenis_aset' => 'Harta Tak Alih',
                'alamat' => 'Lot 7663, Jalan Masjid, Seksyen 7',
                'no_lot' => '7663',
                'luas_tanah_bangunan' => 800.00,
                'tarikh_perolehan' => Carbon::now()->subYears(rand(3, 10)),
                'sumber_perolehan' => 'Pembinaan Sendiri',
                'kos_perolehan' => 350000.00,
                'keadaan_semasa' => 'Baik',
                'catatan' => 'Dewan untuk aktiviti kemasyarakatan dan majlis keraian.',
            ],
            [
                'nama_aset' => 'Tempat Letak Kereta',
                'jenis_aset' => 'Harta Tak Alih',
                'alamat' => 'Lot 7663, Jalan Masjid, Seksyen 7',
                'no_lot' => '7663',
                'luas_tanah_bangunan' => 2000.00,
                'tarikh_perolehan' => Carbon::now()->subYears(rand(2, 8)),
                'sumber_perolehan' => 'Pembinaan Sendiri',
                'kos_perolehan' => 200000.00,
                'keadaan_semasa' => 'Baik',
                'catatan' => 'Tempat letak kereta berturap untuk kegunaan jemaah.',
            ],
        ];

        foreach ($sampleAssets as $assetData) {
            try {
                $noSiriPendaftaran = AssetRegistrationNumber::generateImmovable(
                    $masjidSurau->id,
                    date('y', strtotime($assetData['tarikh_perolehan']))
                );
                
                ImmovableAsset::create(array_merge($assetData, [
                    'masjid_surau_id' => $masjidSurau->id,
                    'no_siri_pendaftaran' => $noSiriPendaftaran,
                ]));
            } catch (\Exception $e) {
                // Log any errors but continue processing
                $this->command->warn("Failed to create immovable asset for {$masjidSurau->nama}: {$e->getMessage()}");
            }
        }
    }
}
