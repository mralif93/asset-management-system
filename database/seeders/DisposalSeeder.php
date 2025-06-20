<?php

namespace Database\Seeders;

use App\Models\Disposal;
use App\Models\Asset;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DisposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = Asset::limit(3)->get(); // Only dispose some assets

        // Sample disposal records
        $disposals = [
            [
                'tarikh_permohonan' => Carbon::now()->subDays(95),
                'justifikasi_pelupusan' => 'Komputer lama sudah tidak boleh dibaiki dan perlu dilupuskan',
                'kaedah_pelupusan_dicadang' => 'Dijual Sebagai Bahan Buangan',
                'nombor_mesyuarat_jawatankuasa' => 'JWK/2023/03/001',
                'tarikh_kelulusan_pelupusan' => Carbon::now()->subDays(90),
                'status_pelupusan' => 'Diluluskan',
                'pegawai_pemohon' => 'Ustaz Ahmad bin Ali',
                'catatan' => 'Komputer lama sudah tidak boleh dibaiki, dijual untuk kitar semula kepada Syarikat Kitar Semula Elektronik dengan nilai RM50',
            ],
            [
                'tarikh_permohonan' => Carbon::now()->subDays(65),
                'justifikasi_pelupusan' => 'Kerusi lebihan tidak diperlukan lagi dan boleh disumbangkan',
                'kaedah_pelupusan_dicadang' => 'Disumbang',
                'nombor_mesyuarat_jawatankuasa' => 'JWK/2023/04/002',
                'tarikh_kelulusan_pelupusan' => Carbon::now()->subDays(60),
                'status_pelupusan' => 'Diluluskan',
                'pegawai_pemohon' => 'Encik Mahmud bin Hassan',
                'catatan' => 'Kerusi lebihan disumbangkan kepada Surau Al-Hidayah yang memerlukan',
            ],
            [
                'tarikh_permohonan' => Carbon::now()->subDays(35),
                'justifikasi_pelupusan' => 'Penyaman udara rosak dan kos pembaikan melebihi nilai aset',
                'kaedah_pelupusan_dicadang' => 'Dijual',
                'nombor_mesyuarat_jawatankuasa' => 'JWK/2023/05/003',
                'tarikh_kelulusan_pelupusan' => Carbon::now()->subDays(30),
                'status_pelupusan' => 'Diluluskan',
                'pegawai_pemohon' => 'Ustaz Ahmad bin Ali',
                'catatan' => 'Penyaman udara rosak dijual untuk spare part kepada Encik Abdullah bin Kassim dengan nilai RM800',
            ],
        ];

        // Create disposal records
        foreach ($disposals as $index => $disposalData) {
            if ($index < $assets->count()) {
                $asset = $assets[$index];
                
                Disposal::create(array_merge($disposalData, [
                    'asset_id' => $asset->id,
                ]));

                // Update asset status to disposed
                $asset->update(['status_aset' => 'Dilupuskan']);
            }
        }

        // Create additional sample disposals
        $this->createAdditionalDisposals();

        $this->command->info('Asset disposals seeded successfully!');
    }

    private function createAdditionalDisposals()
    {
        // Get some older assets for disposal
        $olderAssets = Asset::where('tarikh_perolehan', '<', Carbon::now()->subYears(5))
                           ->where('status_aset', '!=', 'Dilupuskan')
                           ->limit(5)
                           ->get();

        $justifikasiPelupusan = [
            'Aset sudah rosak dan tidak boleh dibaiki lagi',
            'Aset telah mencapai akhir hayat berguna',
            'Teknologi aset sudah lama dan perlu diganti',
            'Aset melebihi keperluan semasa organisasi',
            'Kos penyelenggaraan melebihi nilai aset',
            'Sistem telah dinaiktaraf dan aset tidak diperlukan',
            'Aset menimbulkan isu keselamatan',
            'Ruang simpanan tidak mencukupi untuk aset ini'
        ];

        $kaedahPelupusan = [
            'Dijual',
            'Disumbang',
            'Dijual Sebagai Bahan Buangan',
            'Kitar Semula',
            'Musnah',
            'Tukar Barter'
        ];

        $statusPelupusan = ['Diluluskan', 'Menunggu Kelulusan', 'Ditolak'];

        $pembeliPenerima = [
            'Syarikat Kitar Semula',
            'Sekolah Kebangsaan Taman Hijau',
            'Surau Al-Hidayah',
            'Encik Ahmad bin Hassan',
            'Syarikat Second Hand Electronics',
            'Madrasah Al-Furqan',
            'Pusat Pemulihan OKU',
            'Rumah Anak Yatim As-Salam',
            'Syarikat Waste Management',
            'Kedai Barangan Terpakai'
        ];

        $pegawaiBertanggungjawab = [
            'Ustaz Ahmad bin Ali',
            'Haji Ibrahim bin Yusof', 
            'Encik Mahmud bin Hassan',
            'Bendahari Masjid',
            'Setiausaha Jawatankuasa'
        ];

        foreach ($olderAssets as $index => $asset) {
            $justifikasi = $justifikasiPelupusan[array_rand($justifikasiPelupusan)];
            $kaedah = $kaedahPelupusan[array_rand($kaedahPelupusan)];
            $status = $statusPelupusan[array_rand($statusPelupusan)];
            
            $tarikhPermohonan = Carbon::now()->subDays(rand(30, 180));
            $tarikhKelulusan = null;
            $nomorMesyuarat = null;

            if ($status === 'Diluluskan') {
                $tarikhKelulusan = $tarikhPermohonan->copy()->addDays(rand(1, 14));
                $nomorMesyuarat = 'JWK/' . date('Y') . '/' . str_pad($index + 4, 2, '0', STR_PAD_LEFT) . '/' . str_pad(rand(1, 10), 3, '0', STR_PAD_LEFT);
            }

            Disposal::create([
                'asset_id' => $asset->id,
                'tarikh_permohonan' => $tarikhPermohonan,
                'justifikasi_pelupusan' => $justifikasi,
                'kaedah_pelupusan_dicadang' => $kaedah,
                'nombor_mesyuarat_jawatankuasa' => $nomorMesyuarat,
                'tarikh_kelulusan_pelupusan' => $tarikhKelulusan,
                'status_pelupusan' => $status,
                'pegawai_pemohon' => $pegawaiBertanggungjawab[array_rand($pegawaiBertanggungjawab)],
                'catatan' => $this->generateDisposalNote($justifikasi, $kaedah, $pembeliPenerima[array_rand($pembeliPenerima)]),
            ]);

            // Update asset status if disposal is approved
            if ($status === 'Diluluskan') {
                $asset->update(['status_aset' => 'Dilupuskan']);
            }
        }
    }

    private function generateDisposalNote($justifikasi, $kaedah, $penerima = null)
    {
        $baseNote = $justifikasi . '. ';
        
        switch ($kaedah) {
            case 'Dijual':
                $baseNote .= 'Aset akan dijual kepada pihak yang berminat';
                if ($penerima) {
                    $baseNote .= ' (' . $penerima . ')';
                }
                break;
            case 'Disumbang':
                $baseNote .= 'Aset akan disumbangkan kepada organisasi yang memerlukan';
                if ($penerima) {
                    $baseNote .= ' (' . $penerima . ')';
                }
                break;
            case 'Dijual Sebagai Bahan Buangan':
                $baseNote .= 'Aset akan dijual sebagai bahan buangan untuk dikitar semula';
                if ($penerima) {
                    $baseNote .= ' (' . $penerima . ')';
                }
                break;
            case 'Kitar Semula':
                $baseNote .= 'Aset akan dihantar untuk dikitar semula';
                break;
            case 'Musnah':
                $baseNote .= 'Aset akan dimusnahkan dengan selamat';
                break;
            case 'Tukar Barter':
                $baseNote .= 'Aset akan ditukar dengan barang lain yang diperlukan';
                break;
            default:
                $baseNote .= 'Aset akan dilupuskan mengikut kaedah yang sesuai';
        }
        
        return $baseNote;
    }
}
