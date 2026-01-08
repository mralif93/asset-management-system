<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetMovement;
use App\Models\MasjidSurau;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AssetMovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = Asset::all();
        $users = User::all();
        $masjidSuraus = MasjidSurau::all();

        foreach ($assets as $index => $asset) {
            if ($index % 2 == 0) { // Create movement for every second asset
                $destinationMasjid = $masjidSuraus->where('id', '!=', $asset->masjid_surau_id)->random();
                $user = $users->where('masjid_surau_id', $asset->masjid_surau_id)->first() ?? $users->first();

                // Randomly select status, heavily weighted towards 'menunggu_kelulusan' as requested
                $statuses = ['menunggu_kelulusan', 'menunggu_kelulusan', 'menunggu_kelulusan', 'diluluskan', 'ditolak'];
                $status = $statuses[array_rand($statuses)];

                // Randomly select movement type
                $types = ['Pemindahan', 'Peminjaman', 'Pulangan'];
                $type = $types[array_rand($types)];

                $pegawaiMeluluskan = $status === 'menunggu_kelulusan' ? null : 'Siti Aminah binti Ahmad';

                // Dummy signature (1x1 pixel base64 png)
                $dummySignature = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+P+/HgAFhAJ/wlseKgAAAABJRU5ErkJggg==';

                AssetMovement::create([
                    'asset_id' => $asset->id,
                    'user_id' => $user->id,
                    'origin_masjid_surau_id' => $asset->masjid_surau_id,
                    'destination_masjid_surau_id' => $destinationMasjid->id,
                    'tarikh_permohonan' => Carbon::now()->subDays(rand(1, 30)),
                    'jenis_pergerakan' => $type,
                    'lokasi_asal_spesifik' => 'Stor Utama',
                    'lokasi_destinasi_spesifik' => 'Pejabat Pentadbiran',
                    'nama_peminjam_pegawai_bertanggungjawab' => 'Ahmad bin Abdullah',
                    'tujuan_pergerakan' => 'Pergerakan untuk kegunaan program',
                    'tarikh_pergerakan' => Carbon::now()->addDays(rand(1, 15)), // Future date for pending
                    'tarikh_jangka_pulang' => $type === 'Peminjaman' ? Carbon::now()->addDays(rand(16, 45)) : null,
                    'status_pergerakan' => $status,
                    'pegawai_meluluskan' => $pegawaiMeluluskan,
                    'catatan' => 'Catatan percubaan',
                    'pegawai_bertanggungjawab_signature' => $dummySignature,
                    'kuantiti' => 1,
                    'pembekal' => 'Pembekal Demo'
                ]);
            }
        }
    }
}
