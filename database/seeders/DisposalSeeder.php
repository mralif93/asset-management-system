<?php

namespace Database\Seeders;

use App\Models\Disposal;
use App\Models\Asset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DisposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = Asset::limit(3)->get(); // Only dispose some assets
        $users = User::where('role', 'admin')->get();
        
        if ($users->isEmpty()) {
            $this->command->error('No admin users found. Please run UserSeeder first.');
            return;
        }

        $adminUser = $users->first();

        // Sample disposal records
        $disposals = [
            [
                'tarikh_permohonan' => Carbon::now()->subDays(95),
                'kaedah_pelupusan_dicadang' => 'Dijual Sebagai Bahan Buangan',
                'justifikasi_pelupusan' => 'Komputer lama sudah tidak boleh dibaiki dan perlu dilupuskan',
                'nombor_mesyuarat_jawatankuasa' => 'JWK/2023/03/001',
                'tarikh_kelulusan_pelupusan' => Carbon::now()->subDays(90),
                'status_pelupusan' => 'Diluluskan',
                'pegawai_pemohon' => $adminUser->name,
                'catatan' => 'Dijual untuk kitar semula kepada Syarikat Kitar Semula Elektronik',
            ],
            [
                'tarikh_permohonan' => Carbon::now()->subDays(65),
                'kaedah_pelupusan_dicadang' => 'Disumbang',
                'justifikasi_pelupusan' => 'Kerusi lebihan tidak diperlukan lagi dan boleh disumbangkan',
                'nombor_mesyuarat_jawatankuasa' => 'JWK/2023/04/002',
                'tarikh_kelulusan_pelupusan' => Carbon::now()->subDays(60),
                'status_pelupusan' => 'Diluluskan',
                'pegawai_pemohon' => $adminUser->name,
                'catatan' => 'Disumbangkan kepada Surau Al-Hidayah yang memerlukan',
            ],
            [
                'tarikh_permohonan' => Carbon::now()->subDays(35),
                'kaedah_pelupusan_dicadang' => 'Dijual',
                'justifikasi_pelupusan' => 'Penyaman udara rosak dan kos pembaikan melebihi nilai aset',
                'nombor_mesyuarat_jawatankuasa' => 'JWK/2023/05/003',
                'tarikh_kelulusan_pelupusan' => Carbon::now()->subDays(30),
                'status_pelupusan' => 'Diluluskan',
                'pegawai_pemohon' => $adminUser->name,
                'catatan' => 'Dijual untuk spare part kepada Encik Abdullah bin Kassim',
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
        $this->createAdditionalDisposals($users);

        $this->command->info('Asset disposals seeded successfully!');
    }

    private function createAdditionalDisposals($users)
    {
        // Get some older assets for disposal
        $olderAssets = Asset::where('tarikh_perolehan', '<', Carbon::now()->subYears(5))
                           ->where('status_aset', '!=', 'Dilupuskan')
                           ->limit(5)
                           ->get();

        $justifikasi = [
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

        $statusPelupusan = ['Dimohon', 'Diluluskan', 'Ditolak'];

        foreach ($olderAssets as $index => $asset) {
            $status = $statusPelupusan[array_rand($statusPelupusan)];
            $kaedah = $kaedahPelupusan[array_rand($kaedahPelupusan)];
            $user = $users->random();
            $approver = $users->where('id', '!=', $user->id)->first() ?? $user;
            
            $tarikhPermohonan = Carbon::now()->subDays(rand(30, 180));
            $tarikhKelulusan = null;
            $noRujukan = null;

            if ($status === 'Diluluskan') {
                $tarikhKelulusan = $tarikhPermohonan->copy()->addDays(rand(1, 14));
                $noRujukan = 'JWK/' . date('Y') . '/' . str_pad($index + 4, 2, '0', STR_PAD_LEFT) . '/' . str_pad(rand(1, 10), 3, '0', STR_PAD_LEFT);
            } elseif ($status === 'Ditolak') {
                $tarikhKelulusan = $tarikhPermohonan->copy()->addDays(rand(1, 14));
            }

            Disposal::create([
                'asset_id' => $asset->id,
                'tarikh_permohonan' => $tarikhPermohonan,
                'kaedah_pelupusan_dicadang' => $kaedah,
                'justifikasi_pelupusan' => $justifikasi[array_rand($justifikasi)],
                'nombor_mesyuarat_jawatankuasa' => $noRujukan,
                'tarikh_kelulusan_pelupusan' => $tarikhKelulusan,
                'status_pelupusan' => $status,
                'pegawai_pemohon' => $user->name,
                'catatan' => $this->generateDisposalNote($kaedah),
            ]);

            // Update asset status if approved
            if ($status === 'Diluluskan') {
                $asset->update(['status_aset' => 'Dilupuskan']);
            }
        }
    }

    private function generateDisposalNote($kaedah)
    {
        switch ($kaedah) {
            case 'Dijual':
                return 'Aset dijual kepada pembeli yang berminat';
            case 'Disumbang':
                return 'Aset disumbangkan kepada organisasi yang memerlukan';
            case 'Dijual Sebagai Bahan Buangan':
                return 'Aset dijual sebagai bahan buangan untuk dikitar semula';
            case 'Kitar Semula':
                return 'Aset dihantar untuk dikitar semula';
            case 'Musnah':
                return 'Aset dimusnahkan dengan selamat';
            case 'Tukar Barter':
                return 'Aset ditukar dengan barang lain yang diperlukan';
            default:
                return 'Aset dilupuskan mengikut kaedah yang sesuai';
        }
    }
}
