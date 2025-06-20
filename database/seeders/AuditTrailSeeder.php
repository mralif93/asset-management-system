<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AuditTrail;
use App\Models\User;
use App\Models\Asset;
use App\Models\MasjidSurau;

class AuditTrailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get sample data
        $users = User::all();
        $assets = Asset::take(5)->get();
        $masjidSuraus = MasjidSurau::take(3)->get();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        $sampleIPs = ['192.168.1.100', '10.0.0.50', '172.16.1.25', '203.116.122.1'];
        $userAgents = [
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15',
            'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1',
        ];

        $activities = [];

        // Login activities
        foreach ($users as $user) {
            for ($i = 0; $i < rand(3, 8); $i++) {
                $activities[] = [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'user_role' => $user->role,
                    'action' => 'LOGIN',
                    'description' => 'Pengguna berjaya log masuk: ' . $user->name,
                    'ip_address' => $sampleIPs[array_rand($sampleIPs)],
                    'user_agent' => $userAgents[array_rand($userAgents)],
                    'method' => 'POST',
                    'url' => 'http://localhost:8000/login',
                    'route_name' => 'login.submit',
                    'event_type' => 'web',
                    'status' => 'success',
                    'created_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                    'updated_at' => now(),
                ];
            }
        }

        // Failed login attempts
        for ($i = 0; $i < 15; $i++) {
            $user = $users->random();
            $activities[] = [
                'user_id' => null,
                'user_name' => null,
                'user_email' => $user->email,
                'user_role' => null,
                'action' => 'LOGIN',
                'description' => 'Cubaan log masuk gagal untuk: ' . $user->email,
                'ip_address' => $sampleIPs[array_rand($sampleIPs)],
                'user_agent' => $userAgents[array_rand($userAgents)],
                'method' => 'POST',
                'url' => 'http://localhost:8000/login',
                'route_name' => 'login.submit',
                'event_type' => 'web',
                'status' => 'failed',
                'created_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                'updated_at' => now(),
            ];
        }

        // Asset activities
        if ($assets->isNotEmpty()) {
            foreach ($assets as $asset) {
                $user = $users->random();
                
                // Asset created
                $activities[] = [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'user_role' => $user->role,
                    'action' => 'CREATE',
                    'model_type' => Asset::class,
                    'model_id' => $asset->id,
                    'model_name' => $asset->nama_aset,
                    'description' => 'Rekod baharu dicipta: ' . $asset->nama_aset,
                    'new_values' => $asset->toArray(),
                    'ip_address' => $sampleIPs[array_rand($sampleIPs)],
                    'user_agent' => $userAgents[array_rand($userAgents)],
                    'method' => 'POST',
                    'url' => 'http://localhost:8000/admin/assets',
                    'route_name' => 'admin.assets.store',
                    'event_type' => 'web',
                    'status' => 'success',
                    'created_at' => now()->subDays(rand(5, 25))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                    'updated_at' => now(),
                ];

                // Asset viewed
                for ($j = 0; $j < rand(2, 5); $j++) {
                    $viewUser = $users->random();
                    $activities[] = [
                        'user_id' => $viewUser->id,
                        'user_name' => $viewUser->name,
                        'user_email' => $viewUser->email,
                        'user_role' => $viewUser->role,
                        'action' => 'VIEW',
                        'model_type' => Asset::class,
                        'model_id' => $asset->id,
                        'model_name' => $asset->nama_aset,
                        'description' => 'Rekod dilihat: ' . $asset->nama_aset,
                        'ip_address' => $sampleIPs[array_rand($sampleIPs)],
                        'user_agent' => $userAgents[array_rand($userAgents)],
                        'method' => 'GET',
                        'url' => 'http://localhost:8000/admin/assets/' . $asset->id,
                        'route_name' => 'admin.assets.show',
                        'event_type' => 'web',
                        'status' => 'success',
                        'created_at' => now()->subDays(rand(0, 20))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                        'updated_at' => now(),
                    ];
                }

                // Asset updated
                if (rand(0, 1)) {
                    $updateUser = $users->random();
                    $oldValues = $asset->toArray();
                    $newValues = $asset->toArray();
                    $newValues['status_aset'] = 'Diselenggara';
                    
                    $activities[] = [
                        'user_id' => $updateUser->id,
                        'user_name' => $updateUser->name,
                        'user_email' => $updateUser->email,
                        'user_role' => $updateUser->role,
                        'action' => 'UPDATE',
                        'model_type' => Asset::class,
                        'model_id' => $asset->id,
                        'model_name' => $asset->nama_aset,
                        'description' => 'Rekod dikemaskini: ' . $asset->nama_aset,
                        'old_values' => $oldValues,
                        'new_values' => $newValues,
                        'ip_address' => $sampleIPs[array_rand($sampleIPs)],
                        'user_agent' => $userAgents[array_rand($userAgents)],
                        'method' => 'PUT',
                        'url' => 'http://localhost:8000/admin/assets/' . $asset->id,
                        'route_name' => 'admin.assets.update',
                        'event_type' => 'web',
                        'status' => 'success',
                        'created_at' => now()->subDays(rand(0, 10))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                        'updated_at' => now(),
                    ];
                }
            }
        }

        // Masjid/Surau activities
        if ($masjidSuraus->isNotEmpty()) {
            foreach ($masjidSuraus as $masjidSurau) {
                $user = $users->where('role', 'admin')->first() ?? $users->first();
                
                $activities[] = [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'user_role' => $user->role,
                    'action' => 'VIEW',
                    'model_type' => MasjidSurau::class,
                    'model_id' => $masjidSurau->id,
                    'model_name' => $masjidSurau->nama,
                    'description' => 'Rekod dilihat: ' . $masjidSurau->nama,
                    'ip_address' => $sampleIPs[array_rand($sampleIPs)],
                    'user_agent' => $userAgents[array_rand($userAgents)],
                    'method' => 'GET',
                    'url' => 'http://localhost:8000/admin/masjid-surau/' . $masjidSurau->id,
                    'route_name' => 'admin.masjid-surau.show',
                    'event_type' => 'web',
                    'status' => 'success',
                    'created_at' => now()->subDays(rand(0, 15))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                    'updated_at' => now(),
                ];
            }
        }

        // Export activities
        for ($i = 0; $i < 5; $i++) {
            $user = $users->where('role', 'admin')->random();
            $activities[] = [
                'user_id' => $user->id,
                'user_name' => $user->name,
                'user_email' => $user->email,
                'user_role' => $user->role,
                'action' => 'EXPORT',
                'description' => 'Data dieksport: Laporan Aset',
                'ip_address' => $sampleIPs[array_rand($sampleIPs)],
                'user_agent' => $userAgents[array_rand($userAgents)],
                'method' => 'GET',
                'url' => 'http://localhost:8000/admin/reports/assets-by-location',
                'route_name' => 'admin.reports.assets-by-location',
                'event_type' => 'web',
                'status' => 'success',
                'additional_data' => [
                    'export_type' => 'Laporan Aset',
                    'filters' => ['lokasi' => 'Semua'],
                    'exported_at' => now()->toISOString()
                ],
                'created_at' => now()->subDays(rand(0, 7))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                'updated_at' => now(),
            ];
        }

        // Logout activities
        foreach ($users as $user) {
            for ($i = 0; $i < rand(2, 6); $i++) {
                $activities[] = [
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'user_email' => $user->email,
                    'user_role' => $user->role,
                    'action' => 'LOGOUT',
                    'description' => 'Pengguna log keluar: ' . $user->name,
                    'ip_address' => $sampleIPs[array_rand($sampleIPs)],
                    'user_agent' => $userAgents[array_rand($userAgents)],
                    'method' => 'POST',
                    'url' => 'http://localhost:8000/logout',
                    'route_name' => 'logout',
                    'event_type' => 'web',
                    'status' => 'success',
                    'created_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                    'updated_at' => now(),
                ];
            }
        }

        // Sort activities by created_at
        usort($activities, function($a, $b) {
            return $a['created_at']->timestamp - $b['created_at']->timestamp;
        });

        // Insert activities one by one to avoid SQL issues
        foreach ($activities as $activity) {
            AuditTrail::create($activity);
        }

        $this->command->info('Created ' . count($activities) . ' audit trail records');
    }
}
