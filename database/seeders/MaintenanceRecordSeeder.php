<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\MaintenanceRecord;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MaintenanceRecordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $assets = Asset::all();
        $users = User::all();

        foreach ($assets as $index => $asset) {
            if ($index % 2 == 0) { // Create maintenance record for every other asset
                $user = $users->where('masjid_surau_id', $asset->masjid_surau_id)->first() ?? $users->first();
                
                MaintenanceRecord::create([
                    'asset_id' => $asset->id,
                    'user_id' => $user->id,
                    'tarikh_penyelenggaraan' => Carbon::now()->subDays(60),
                    'jenis_penyelenggaraan' => 'Penyelenggaraan Pencegahan',
                    'butiran_kerja' => 'Pembersihan dalaman, kemas kini sistem operasi, scan virus',
                    'nama_syarikat_kontraktor' => 'IT Solutions Sdn Bhd',
                    'kos_penyelenggaraan' => 150.00,
                    'status_penyelenggaraan' => 'Selesai',
                    'pegawai_bertanggungjawab' => 'Ustaz Ahmad bin Ali',
                    'catatan' => 'Servis rutin 6 bulan sekali'
                ]);
            }
        }
    }
}
