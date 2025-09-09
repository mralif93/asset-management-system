<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\MasjidSurau;
use App\Helpers\AssetRegistrationNumber;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
                'pembekal' => 'Dell Malaysia',
                'jenama' => 'Dell',
                'no_pesanan_kerajaan' => 'PO2018/03/001',
                'no_rujukan_kontrak' => 'CTR2018/03/001',
                'tempoh_jaminan' => '3 tahun',
                'tarikh_tamat_jaminan' => '2021-03-15',
                'status_aset' => 'Aktif',
                'keadaan_fizikal' => 'Sedang Digunakan',
                'catatan' => 'Komputer untuk kerja pentadbiran harian',
                'lokasi_penempatan' => 'Pejabat Pentadbiran',
                'pegawai_bertanggungjawab_lokasi' => 'Ahmad bin Abdullah',
            ],
            [
                'nama_aset' => 'Kerusi Plastik',
                'jenis_aset' => 'Inventori',
                'tarikh_perolehan' => '2023-01-20',
                'kaedah_perolehan' => 'Pembelian',
                'nilai_perolehan' => 150.00,
                'pembekal' => 'Kedai Perabot Setia',
                'jenama' => 'Bufallo',
                'status_aset' => 'Aktif',
                'keadaan_fizikal' => 'Sedang Digunakan',
                'catatan' => 'Set 10 kerusi untuk majlis',
                'lokasi_penempatan' => 'Stor Peralatan',
                'pegawai_bertanggungjawab_lokasi' => 'Siti Aminah binti Ahmad',
            ],
            [
                'nama_aset' => 'Penyaman Udara Daikin 2.5HP',
                'jenis_aset' => 'Harta Modal',
                'tarikh_perolehan' => '2023-06-10',
                'kaedah_perolehan' => 'Hibah',
                'nilai_perolehan' => 3200.00,
                'pembekal' => 'Daikin Malaysia',
                'jenama' => 'Daikin',
                'tempoh_jaminan' => '5 tahun',
                'tarikh_tamat_jaminan' => '2028-06-10',
                'status_aset' => 'Aktif',
                'keadaan_fizikal' => 'Rosak',
                'catatan' => 'Sumbangan daripada Datuk Seri Abdullah',
                'lokasi_penempatan' => 'Dewan Solat Utama',
                'pegawai_bertanggungjawab_lokasi' => 'Muhammad Hakim bin Ismail',
            ],
            
            // SAT - Surau At Taqwa
            [
                'nama_aset' => 'Meja Kayu Jati',
                'jenis_aset' => 'Inventori',
                'tarikh_perolehan' => '2023-02-15',
                'kaedah_perolehan' => 'Sumbangan',
                'nilai_perolehan' => 800.00,
                'pembekal' => 'Perabot Jati Sdn Bhd',
                'jenama' => 'Jati Classic',
                'status_aset' => 'Aktif',
                'keadaan_fizikal' => 'Sedang Digunakan',
                'catatan' => 'Meja untuk mesyuarat jawatankuasa',
                'lokasi_penempatan' => 'Bilik Mesyuarat',
                'pegawai_bertanggungjawab_lokasi' => 'Abdul Rahman bin Omar',
            ],
            [
                'nama_aset' => 'Kipas Siling Panasonic',
                'jenis_aset' => 'Elektronik',
                'tarikh_perolehan' => '2023-03-01',
                'kaedah_perolehan' => 'Pembelian',
                'nilai_perolehan' => 350.00,
                'pembekal' => 'Panasonic Malaysia',
                'jenama' => 'Panasonic',
                'tempoh_jaminan' => '2 tahun',
                'tarikh_tamat_jaminan' => '2025-03-01',
                'status_aset' => 'Aktif',
                'keadaan_fizikal' => 'Sedang Diselenggara',
                'catatan' => 'Set 3 unit kipas siling',
                'lokasi_penempatan' => 'Dewan Solat',
                'pegawai_bertanggungjawab_lokasi' => 'Khadijah binti Ali',
            ],
            [
                'nama_aset' => 'Set Sofa Ruang Tamu',
                'jenis_aset' => 'Perabot',
                'tarikh_perolehan' => '2023-04-10',
                'kaedah_perolehan' => 'Sumbangan',
                'nilai_perolehan' => 1200.00,
                'pembekal' => 'Perabot Mewah Sdn Bhd',
                'jenama' => 'Luxury Sofa',
                'status_aset' => 'Aktif',
                'keadaan_fizikal' => 'Tidak Digunakan',
                'catatan' => 'Set sofa untuk ruang tamu',
                'use_first_masjid' => false, // Use first surau
                'lokasi_penempatan' => 'Ruang Tamu',
                'pegawai_bertanggungjawab_lokasi' => 'Hassan bin Abdul Malik',
            ],
        ];

        $firstMasjid = $masjidSuraus->where('jenis', 'Masjid')->first() ?? $masjidSuraus->first();
        $firstSurau = $masjidSuraus->where('jenis', 'Surau')->first() ?? $masjidSuraus->skip(1)->first();

        foreach ($sampleAssets as $assetData) {
            $useFirstMasjid = $assetData['use_first_masjid'] ?? true;
            $masjid = $useFirstMasjid ? $firstMasjid : $firstSurau;
            
            if ($masjid) {
                $tarikhPerolehan = Carbon::parse($assetData['tarikh_perolehan']);
                
                unset($assetData['use_first_masjid']); // Remove the helper key
                
                $noSiriPendaftaran = AssetRegistrationNumber::generate(
                    $masjid->id, 
                    $assetData['jenis_aset'], 
                    $tarikhPerolehan->format('y')
                );

                Asset::create(array_merge($assetData, [
                    'masjid_surau_id' => $masjid->id,
                    'no_siri_pendaftaran' => $noSiriPendaftaran,
                ]));
            }
        }
    }
}
