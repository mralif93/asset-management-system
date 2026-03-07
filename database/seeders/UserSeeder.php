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
                'role' => 'administrator',
                'masjid_surau_id' => null, // Takes over all
                'phone' => '0123456789',
                'position' => 'Super Administrator',
                'email_verified_at' => Carbon::now(),
            ]
        );

        $this->command->info('Superadmin created.');

        $targetNames = [
            'Masjid Al-Hidayah, Taman Melawati' => 'melawati',
            'MASJID AS-SYAKIRIN PUCHONG UTAMA' => 'syakirin',
            'SURAU AL-HIDAYAH TITIWANGSA' => 'titiwangsa'
        ];

        $roles = ['administrator', 'user', 'officer'];

        foreach ($targetNames as $namaMasjid => $emailSuffix) {
            $masjid = MasjidSurau::where('nama', $namaMasjid)->first();

            if (!$masjid) {
                $masjid = MasjidSurau::where('nama', 'like', "%" . $namaMasjid . "%")->first();
            }

            if ($masjid) {
                $this->command->info("Creating user roles for {$masjid->nama}...");

                foreach ($roles as $role) {
                    $emailPrefix = str_replace(' ', '', strtolower($role));

                    User::firstOrCreate(
                        ['email' => $emailPrefix . '.' . $emailSuffix . '@assetflow.test'],
                        [
                            'name' => ucwords($role) . ' ' . $masjid->nama,
                            'password' => bcrypt('password'),
                            'role' => $role,
                            'masjid_surau_id' => $masjid->id,
                            'phone' => '01' . rand(10000000, 99999999),
                            'position' => ucwords($role),
                            'email_verified_at' => Carbon::now(),
                        ]
                    );
                }
                $this->command->info("Users for {$masjid->nama} created successfully.");
            } else {
                $this->command->error("{$namaMasjid} not found in database. Please ensure MasjidSurauSeeder has run.");
            }
        }

        $this->command->info('Users seeded successfully!');
    }
}
