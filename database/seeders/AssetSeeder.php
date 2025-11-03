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
                'jenis_aset' => 'Peralatan Pejabat',
                'kategori_aset' => 'asset',
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
                'keadaan_fizikal' => 'Baik',
                'status_jaminan' => 'Tamat',
                'catatan' => 'Komputer untuk kerja pentadbiran harian',
                'lokasi_penempatan' => 'Bilik Setiausaha',
                'pegawai_bertanggungjawab_lokasi' => 'Ahmad bin Abdullah',
                'jawatan_pegawai' => 'Setiausaha',
            ],
            [
                'nama_aset' => 'Kerusi Plastik',
                'jenis_aset' => 'Perabot',
                'kategori_aset' => 'asset',
                'tarikh_perolehan' => '2023-01-20',
                'kaedah_perolehan' => 'Pembelian',
                'nilai_perolehan' => 150.00,
                'pembekal' => 'Kedai Perabot Setia',
                'jenama' => 'Bufallo',
                'status_aset' => 'Sedang Digunakan',
                'keadaan_fizikal' => 'Baik',
                'status_jaminan' => 'Tiada Jaminan',
                'catatan' => 'Set 10 kerusi untuk majlis',
                'lokasi_penempatan' => 'Ruang Utama (tingkat atas, tingkat bawah)',
                'pegawai_bertanggungjawab_lokasi' => 'Siti Aminah binti Ahmad',
                'jawatan_pegawai' => 'Pegawai Aset',
            ],
            [
                'nama_aset' => 'Penyaman Udara Daikin 2.5HP',
                'jenis_aset' => 'Elektrikal',
                'kategori_aset' => 'asset',
                'tarikh_perolehan' => '2023-06-10',
                'kaedah_perolehan' => 'Hibah',
                'nilai_perolehan' => 3200.00,
                'pembekal' => 'Daikin Malaysia',
                'jenama' => 'Daikin',
                'tempoh_jaminan' => '5 tahun',
                'tarikh_tamat_jaminan' => '2028-06-10',
                'status_aset' => 'Sedang Digunakan',
                'keadaan_fizikal' => 'Sederhana',
                'status_jaminan' => 'Aktif',
                'catatan' => 'Sumbangan daripada Datuk Seri Abdullah',
                'lokasi_penempatan' => 'Ruang Utama (tingkat atas, tingkat bawah)',
                'pegawai_bertanggungjawab_lokasi' => 'Muhammad Hakim bin Ismail',
                'jawatan_pegawai' => 'Nazir',
            ],
            [
                'nama_aset' => 'Chainsaw Stihl MS 250',
                'jenis_aset' => 'Jentera',
                'kategori_aset' => 'asset',
                'tarikh_perolehan' => '2023-05-15',
                'kaedah_perolehan' => 'Pembelian',
                'nilai_perolehan' => 850.00,
                'pembekal' => 'Stihl Malaysia',
                'jenama' => 'Stihl',
                'tempoh_jaminan' => '2 tahun',
                'tarikh_tamat_jaminan' => '2025-05-15',
                'status_aset' => 'Sedang Digunakan',
                'keadaan_fizikal' => 'Baik',
                'status_jaminan' => 'Aktif',
                'catatan' => 'Alat untuk penyelenggaraan kawasan',
                'lokasi_penempatan' => 'Bangunan Jenazah',
                'pegawai_bertanggungjawab_lokasi' => 'Roslan bin Hassan',
                'jawatan_pegawai' => 'Pegawai Penyelenggaraan',
            ],
            [
                'nama_aset' => 'Van Jenazah',
                'jenis_aset' => 'Kenderaan',
                'kategori_aset' => 'asset',
                'tarikh_perolehan' => '2022-08-20',
                'kaedah_perolehan' => 'Pembelian',
                'nilai_perolehan' => 45000.00,
                'pembekal' => 'Perodua Sdn Bhd',
                'jenama' => 'Perodua Alza',
                'tempoh_jaminan' => '5 tahun',
                'tarikh_tamat_jaminan' => '2027-08-20',
                'status_aset' => 'Sedang Digunakan',
                'keadaan_fizikal' => 'Baik',
                'status_jaminan' => 'Aktif',
                'catatan' => 'Kenderaan untuk kegunaan jenazah',
                'lokasi_penempatan' => 'Bangunan Jenazah',
                'pegawai_bertanggungjawab_lokasi' => 'Ahmad Fauzi bin Mohd',
                'jawatan_pegawai' => 'Pemandu',
            ],
            
            // SAT - Surau At Taqwa
            [
                'nama_aset' => 'Meja Kayu Jati',
                'jenis_aset' => 'Perabot',
                'kategori_aset' => 'asset',
                'tarikh_perolehan' => '2023-02-15',
                'kaedah_perolehan' => 'Sumbangan',
                'nilai_perolehan' => 800.00,
                'pembekal' => 'Perabot Jati Sdn Bhd',
                'jenama' => 'Jati Classic',
                'status_aset' => 'Sedang Digunakan',
                'keadaan_fizikal' => 'Baik',
                'status_jaminan' => 'Tiada Jaminan',
                'catatan' => 'Meja untuk mesyuarat jawatankuasa',
                'lokasi_penempatan' => 'Bilik Mesyuarat',
                'pegawai_bertanggungjawab_lokasi' => 'Abdul Rahman bin Omar',
                'jawatan_pegawai' => 'Bendahari',
            ],
            [
                'nama_aset' => 'Kipas Siling Panasonic',
                'jenis_aset' => 'Elektrikal',
                'kategori_aset' => 'asset',
                'tarikh_perolehan' => '2023-03-01',
                'kaedah_perolehan' => 'Pembelian',
                'nilai_perolehan' => 350.00,
                'pembekal' => 'Panasonic Malaysia',
                'jenama' => 'Panasonic',
                'tempoh_jaminan' => '2 tahun',
                'tarikh_tamat_jaminan' => '2025-03-01',
                'status_aset' => 'Sedang Digunakan',
                'keadaan_fizikal' => 'Baik',
                'status_jaminan' => 'Aktif',
                'catatan' => 'Set 3 unit kipas siling',
                'lokasi_penempatan' => 'Ruang Utama (tingkat atas, tingkat bawah)',
                'pegawai_bertanggungjawab_lokasi' => 'Khadijah binti Ali',
                'jawatan_pegawai' => 'Pegawai Aset',
            ],
            [
                'nama_aset' => 'Set Sofa Ruang Tamu',
                'jenis_aset' => 'Perabot',
                'kategori_aset' => 'asset',
                'tarikh_perolehan' => '2023-04-10',
                'kaedah_perolehan' => 'Sumbangan',
                'nilai_perolehan' => 1200.00,
                'pembekal' => 'Perabot Mewah Sdn Bhd',
                'jenama' => 'Luxury Sofa',
                'status_aset' => 'Sedang Digunakan',
                'keadaan_fizikal' => 'Baik',
                'status_jaminan' => 'Tiada Jaminan',
                'catatan' => 'Set sofa untuk ruang tamu',
                'use_first_masjid' => false, // Use first surau
                'lokasi_penempatan' => 'Bilik Mesyuarat',
                'pegawai_bertanggungjawab_lokasi' => 'Hassan bin Abdul Malik',
                'jawatan_pegawai' => 'Setiausaha',
            ],
            // Non-Asset Examples
            [
                'nama_aset' => 'Set Peralatan Dapur Lengkap',
                'jenis_aset' => 'Barang-barang Dapur',
                'kategori_aset' => 'non-asset',
                'tarikh_perolehan' => '2023-07-01',
                'kaedah_perolehan' => 'Pembelian',
                'nilai_perolehan' => 500.00,
                'status_aset' => 'Sedang Digunakan',
                'keadaan_fizikal' => 'Baik',
                'status_jaminan' => 'Tiada Jaminan',
                'catatan' => 'Set peralatan dapur untuk majlis',
                'lokasi_penempatan' => 'Lain-lain',
                'pegawai_bertanggungjawab_lokasi' => 'Noriza binti Ahmad',
                'jawatan_pegawai' => 'Pegawai Dapur',
            ],
            [
                'nama_aset' => 'Alat Tulis Pejabat',
                'jenis_aset' => 'Peralatan Pejabat - Alat tulis',
                'kategori_aset' => 'non-asset',
                'tarikh_perolehan' => '2023-08-15',
                'kaedah_perolehan' => 'Pembelian',
                'nilai_perolehan' => 200.00,
                'status_aset' => 'Sedang Digunakan',
                'keadaan_fizikal' => 'Baik',
                'status_jaminan' => 'Tiada Jaminan',
                'catatan' => 'Alat tulis untuk kegunaan pejabat',
                'lokasi_penempatan' => 'Bilik Setiausaha',
                'pegawai_bertanggungjawab_lokasi' => 'Zainab binti Mohd',
                'jawatan_pegawai' => 'Setiausaha',
            ],
            [
                'nama_aset' => 'Set Alat Pertukangan',
                'jenis_aset' => 'Alat-alat Pertukangan',
                'kategori_aset' => 'non-asset',
                'tarikh_perolehan' => '2023-09-10',
                'kaedah_perolehan' => 'Pembelian',
                'nilai_perolehan' => 600.00,
                'status_aset' => 'Sedang Digunakan',
                'keadaan_fizikal' => 'Baik',
                'status_jaminan' => 'Tiada Jaminan',
                'catatan' => 'Set alat pertukangan untuk penyelenggaraan',
                'lokasi_penempatan' => 'Bangunan Jenazah',
                'pegawai_bertanggungjawab_lokasi' => 'Roslan bin Hassan',
                'jawatan_pegawai' => 'Pegawai Penyelenggaraan',
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
