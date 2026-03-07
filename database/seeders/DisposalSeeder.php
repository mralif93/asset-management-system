<?php

namespace Database\Seeders;

use App\Models\Disposal;
use App\Models\Asset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DisposalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all assets
        $assets = Asset::all();
        $users = User::where('role', 'administrator')->get();

        if ($assets->isEmpty()) {
            $this->command->error('No assets found. Please run AssetSeeder first.');
            return;
        }

        if ($users->isEmpty()) {
            $this->command->error('No admin users found. Please run UserSeeder first.');
            return;
        }

        $adminUser = $users->first();

        // Clear existing disposals
        Disposal::query()->delete();

        // Get first 3 assets for disposal
        $assetsToDispose = $assets->take(3);

        $disposalData = [
            [
                'kaedah_pelupusan' => 'Dijual',
                'tempat_pelupusan' => 'Syarikat Kitar Semula Elektronik Sdn Bhd',
                'hasil_pelupusan' => 150.00,
            ],
            [
                'kaedah_pelupusan' => 'Disumbangkan',
                'tempat_pelupusan' => 'Surau Al-Hidayah',
                'hasil_pelupusan' => 0,
            ],
            [
                'kaedah_pelupusan' => 'Dijual',
                'tempat_pelupusan' => 'Encik Abdullah bin Kassim',
                'hasil_pelupusan' => 200.00,
            ],
        ];

        foreach ($assetsToDispose as $index => $asset) {
            if (!isset($disposalData[$index])) {
                break;
            }

            $data = $disposalData[$index];
            $tarikhPelupusan = Carbon::now()->subDays(30 - ($index * 10));

            Disposal::create([
                'asset_id' => $asset->id,
                'kuantiti' => 1,
                'tarikh_permohonan' => $tarikhPelupusan->copy()->subDays(5),
                'justifikasi_pelupusan' => 'Aset sudah rosak dan tidak boleh dibaiki lagi',
                'kaedah_pelupusan_dicadang' => $data['kaedah_pelupusan'],
                'kaedah_pelupusan' => $data['kaedah_pelupusan'],
                'nombor_mesyuarat_jawatankuasa' => 'JWK/2025/' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'tarikh_kelulusan_pelupusan' => $tarikhPelupusan->copy()->subDays(2),
                'tarikh_pelupusan' => $tarikhPelupusan,
                'status_pelupusan' => 'Diluluskan',
                'pegawai_pemohon' => $adminUser->name,
                'tempat_pelupusan' => $data['tempat_pelupusan'],
                'hasil_pelupusan' => $data['hasil_pelupusan'],
                'nilai_pelupusan' => $asset->nilai_perolehan ?? 0,
                'catatan' => 'Pelupusan aset melalui ' . $data['kaedah_pelupusan'],
                'user_id' => $adminUser->id,
            ]);

            // Update asset status to disposed
            $asset->update(['status_aset' => Asset::STATUS_DISPOSED]);

            $this->command->info("Created disposal for asset: {$asset->nama_aset}");
        }

        $this->command->info('Disposal seeding completed! Total disposals: ' . Disposal::count());
    }
}
