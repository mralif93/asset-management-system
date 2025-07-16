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
            if ($index % 3 == 0) { // Create movement for every third asset
                $destinationMasjid = $masjidSuraus->where('id', '!=', $asset->masjid_surau_id)->random();
                $user = $users->where('masjid_surau_id', $asset->masjid_surau_id)->first() ?? $users->first();
                
                AssetMovement::create([
                    'asset_id' => $asset->id,
                    'user_id' => $user->id,
                    'origin_masjid_surau_id' => $asset->masjid_surau_id,
                    'destination_masjid_surau_id' => $destinationMasjid->id,
                    'tarikh_permohonan' => Carbon::now()->subDays(rand(1, 30)),
                    'jenis_pergerakan' => 'Pinjaman',
                    'lokasi_asal_spesifik' => 'Stor Utama',
                    'lokasi_destinasi_spesifik' => 'Pejabat Pentadbiran',
                    'nama_peminjam_pegawai_bertanggungjawab' => 'Ahmad bin Abdullah',
                    'tujuan_pergerakan' => 'Pinjaman untuk kegunaan program',
                    'tarikh_pergerakan' => Carbon::now()->subDays(rand(1, 15)),
                    'tarikh_jangka_pulang' => Carbon::now()->addDays(rand(1, 30)),
                    'status_pergerakan' => 'Dalam Pinjaman',
                    'pegawai_meluluskan' => 'Siti Aminah binti Ahmad',
                    'catatan' => 'Pinjaman untuk program bulanan'
                ]);
            }
        }
    }
}
