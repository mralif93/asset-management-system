<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MasjidSurau;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting UserSeeder...');

        // Create superadmin user (System wide access)
        User::firstOrCreate(
            ['email' => 'superadmin@assetflow.test'],
            [
                'name' => 'System Super Administrator',
                'password' => bcrypt('password'),
                'role' => 'superadmin',
                'masjid_surau_id' => null, // Takes over all
                'phone' => '0123456789',
                'position' => 'Super Administrator',
                'email_verified_at' => Carbon::now(),
            ]
        );

        $this->command->info('Superadmin created.');

        // Define the target Masjids/Suraus
        $targets = [
            'Masjid Taman Melawati' => 'melawati',
            'Masjid Melawati' => 'melawati2',
            'Surau Al-Ikhlas' => 'alikhlas'
        ];

        $roles = ['admin', 'user', 'Asset Officer'];

        foreach ($targets as $namaMasjid => $emailSuffix) {
            $masjid = MasjidSurau::where('nama', $namaMasjid)->first();

            if ($masjid) {
                $this->command->info("Creating user roles for {$namaMasjid}...");

                foreach ($roles as $role) {
                    $emailPrefix = str_replace(' ', '', strtolower($role));
                    if ($emailPrefix === 'assetofficer') {
                        $emailPrefix = 'officer'; // Simplify for login convenience
                    }

                    User::firstOrCreate(
                        ['email' => $emailPrefix . '.' . $emailSuffix . '@assetflow.test'],
                        [
                            'name' => ucwords($role) . ' ' . $namaMasjid,
                            'password' => bcrypt('password'),
                            'role' => $role,
                            'masjid_surau_id' => $masjid->id,
                            'phone' => '01' . rand(10000000, 99999999),
                            'position' => ucwords($role),
                            'email_verified_at' => Carbon::now(),
                        ]
                    );
                }
                $this->command->info("Users for {$namaMasjid} created successfully.");
            } else {
                $this->command->error("{$namaMasjid} not found in database. Please run MasjidSurauSeeder first.");
            }
        }

        $this->command->info('Users seeded successfully!');
    }
}
