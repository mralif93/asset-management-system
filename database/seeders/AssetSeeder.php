<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\MasjidSurau;
use App\Helpers\AssetRegistrationNumber;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $masjidSuraus = MasjidSurau::all();
        
        $sampleAssets = [
            // MTAJ - Masjid Tengku Ampuan Jemaah
            [
                'nama_aset' => 'Komputer Desktop Dell OptiPlex 7090',
                'jenis_aset' => 'Harta Modal',
                'tarikh_perolehan' => '2018-03-15',
                'kaedah_perolehan' => 'Pembelian',
                'nilai_perolehan' => 2500.00,
                'umur_faedah_tahunan' => 5,
                'susut_nilai_tahunan' => 500.00,
                'lokasi_penempatan' => 'Pejabat Imam',
                'pegawai_bertanggungjawab_lokasi' => 'Ustaz Ahmad bin Ali',
                'status_aset' => 'Sedang Digunakan',
                'catatan' => 'Komputer untuk kerja pentadbiran harian',
            ],
            [
                'nama_aset' => 'Kerusi Plastik',
                'jenis_aset' => 'Inventori',
                'tarikh_perolehan' => '2023-01-20',
                'kaedah_perolehan' => 'Pembelian',
                'nilai_perolehan' => 150.00,
                'lokasi_penempatan' => 'Dewan Solat Utama',
                'pegawai_bertanggungjawab_lokasi' => 'Encik Mahmud bin Hassan',
                'status_aset' => 'Sedang Digunakan',
                'catatan' => 'Set 10 kerusi untuk majlis',
            ],
            [
                'nama_aset' => 'Penyaman Udara Daikin 2.5HP',
                'jenis_aset' => 'Harta Modal',
                'tarikh_perolehan' => '2023-06-10',
                'kaedah_perolehan' => 'Hibah',
                'nilai_perolehan' => 3200.00,
                'umur_faedah_tahunan' => 10,
                'susut_nilai_tahunan' => 320.00,
                'lokasi_penempatan' => 'Dewan Solat Utama',
                'pegawai_bertanggungjawab_lokasi' => 'Ustaz Ahmad bin Ali',
                'status_aset' => 'Sedang Digunakan',
                'catatan' => 'Sumbangan daripada Datuk Seri Abdullah',
            ],
            
            // SAT - Surau At Taqwa
            [
                'nama_aset' => 'Meja Kayu Jati',
                'jenis_aset' => 'Inventori',
                'tarikh_perolehan' => '2023-02-15',
                'kaedah_perolehan' => 'Sumbangan',
                'nilai_perolehan' => 800.00,
                'lokasi_penempatan' => 'Bilik Mesyuarat',
                'pegawai_bertanggungjawab_lokasi' => 'Haji Ibrahim bin Yusof',
                'status_aset' => 'Sedang Digunakan',
                'catatan' => 'Meja untuk mesyuarat jawatankuasa',
            ],
            [
                'nama_aset' => 'Kipas Siling Panasonic',
                'jenis_aset' => 'Elektronik',
                'tarikh_perolehan' => '2023-03-01',
                'kaedah_perolehan' => 'Pembelian',
                'nilai_perolehan' => 350.00,
                'lokasi_penempatan' => 'Ruang Solat',
                'pegawai_bertanggungjawab_lokasi' => 'Encik Rosli bin Ahmad',
                'status_aset' => 'Sedang Digunakan',
                'catatan' => 'Set 3 unit kipas siling',
            ],
        ];

        // Create assets for the first masjid (first 3 assets)
        $firstMasjid = $masjidSuraus->where('jenis', 'Masjid')->first() ?? $masjidSuraus->first();
        if ($firstMasjid) {
            for ($i = 0; $i < 3; $i++) {
                $assetData = $sampleAssets[$i];
                $tarikhPerolehan = Carbon::parse($assetData['tarikh_perolehan']);
                
                Asset::create(array_merge($assetData, [
                    'masjid_surau_id' => $firstMasjid->id,
                    'no_siri_pendaftaran' => AssetRegistrationNumber::generate(
                        $firstMasjid->id, 
                        $assetData['jenis_aset'], 
                        $tarikhPerolehan->format('y')
                    ),
                ]));
            }
        }

        // Create assets for the first surau (last 2 assets)
        $firstSurau = $masjidSuraus->where('jenis', 'Surau')->first() ?? $masjidSuraus->skip(1)->first();
        if ($firstSurau) {
            for ($i = 3; $i < 5; $i++) {
                $assetData = $sampleAssets[$i];
                $tarikhPerolehan = Carbon::parse($assetData['tarikh_perolehan']);
                
                Asset::create(array_merge($assetData, [
                    'masjid_surau_id' => $firstSurau->id,
                    'no_siri_pendaftaran' => AssetRegistrationNumber::generate(
                        $firstSurau->id, 
                        $assetData['jenis_aset'], 
                        $tarikhPerolehan->format('y')
                    ),
                ]));
            }
        }

        // Create additional sample assets for demonstration
        $this->createAdditionalSampleAssets($masjidSuraus);
    }

    private function createAdditionalSampleAssets($masjidSuraus)
    {
        $additionalAssets = [
            // More assets for first masjid
            [
                'nama_aset' => 'Printer Canon ImageClass MF244dw',
                'jenis_aset' => 'Harta Modal',
                'tarikh_perolehan' => '2018-07-20',
                'kaedah_perolehan' => 'Pembelian',
                'nilai_perolehan' => 2100.00,
                'lokasi_penempatan' => 'Pejabat Imam',
                'pegawai_bertanggungjawab_lokasi' => 'Ustaz Ahmad bin Ali',
                'use_first_masjid' => true,
            ],
            [
                'nama_aset' => 'Lori Nissan Cabstar',
                'jenis_aset' => 'Kenderaan',
                'tarikh_perolehan' => '2023-08-15',
                'kaedah_perolehan' => 'Pembelian',
                'nilai_perolehan' => 45000.00,
                'umur_faedah_tahunan' => 8,
                'susut_nilai_tahunan' => 5625.00,
                'lokasi_penempatan' => 'Tempat Letak Kereta',
                'pegawai_bertanggungjawab_lokasi' => 'Encik Karim bin Osman',
                'use_first_masjid' => true,
            ],
            // Assets for first surau
            [
                'nama_aset' => 'Set Sofa Ruang Tamu',
                'jenis_aset' => 'Perabot',
                'tarikh_perolehan' => '2023-04-10',
                'kaedah_perolehan' => 'Sumbangan',
                'nilai_perolehan' => 1200.00,
                'lokasi_penempatan' => 'Ruang Tamu',
                'pegawai_bertanggungjawab_lokasi' => 'Haji Ibrahim bin Yusof',
                'use_first_masjid' => false, // Use first surau
            ],
        ];

        $firstMasjid = $masjidSuraus->where('jenis', 'Masjid')->first() ?? $masjidSuraus->first();
        $firstSurau = $masjidSuraus->where('jenis', 'Surau')->first() ?? $masjidSuraus->skip(1)->first();

        foreach ($additionalAssets as $assetData) {
            $useFirstMasjid = $assetData['use_first_masjid'] ?? true;
            $masjid = $useFirstMasjid ? $firstMasjid : $firstSurau;
            
            if ($masjid) {
                $tarikhPerolehan = Carbon::parse($assetData['tarikh_perolehan']);
                
                unset($assetData['use_first_masjid']); // Remove the helper key
                
                Asset::create(array_merge($assetData, [
                    'masjid_surau_id' => $masjid->id,
                    'no_siri_pendaftaran' => AssetRegistrationNumber::generate(
                        $masjid->id, 
                        $assetData['jenis_aset'], 
                        $tarikhPerolehan->format('y')
                    ),
                    'status_aset' => 'Sedang Digunakan',
                    'catatan' => 'Asset sampel untuk demonstrasi sistem',
                ]));
            }
        }
    }
}
