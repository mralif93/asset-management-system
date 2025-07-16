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

        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@assetflow.test'],
            [
                'name' => 'System Administrator',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'phone' => '0123456789',
                'position' => 'System Administrator',
                'email_verified_at' => Carbon::now(),
            ]
        );

        $this->command->info('Admin users created.');

        // Create regular users for each masjid/surau
        $masjidSuraus = MasjidSurau::limit(5)->get();
        $this->command->info('Creating users for ' . $masjidSuraus->count() . ' masjid/surau records...');

        foreach ($masjidSuraus as $masjidSurau) {
            // Create Asset Officer
            User::firstOrCreate(
                ['email' => 'officer.' . Str::slug($masjidSurau->nama) . '@assetflow.test'],
                [
                    'name' => 'Pegawai Aset ' . $masjidSurau->nama,
                    'password' => bcrypt('password'),
                    'role' => 'Asset Officer',
                    'masjid_surau_id' => $masjidSurau->id,
                    'phone' => '01' . rand(10000000, 99999999),
                    'position' => 'Pegawai Aset',
                    'email_verified_at' => Carbon::now(),
                ]
            );

            // Create Staff
            User::firstOrCreate(
                ['email' => 'staff.' . Str::slug($masjidSurau->nama) . '@assetflow.test'],
                [
                    'name' => 'Staf ' . $masjidSurau->nama,
                    'password' => bcrypt('password'),
                    'role' => 'Staff',
                    'masjid_surau_id' => $masjidSurau->id,
                    'phone' => '01' . rand(10000000, 99999999),
                    'position' => 'Staf',
                    'email_verified_at' => Carbon::now(),
                ]
            );
        }

        $this->command->info('Regular users created for sample masjid/surau records.');

        // Create test users
        User::firstOrCreate(
            ['email' => 'test.admin@assetflow.test'],
            [
                'name' => 'Test Admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'phone' => '0123456789',
                'position' => 'Test Admin',
                'email_verified_at' => Carbon::now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'test.officer@assetflow.test'],
            [
                'name' => 'Test Officer',
                'password' => bcrypt('password'),
                'role' => 'Asset Officer',
                'phone' => '0123456789',
                'position' => 'Test Officer',
                'email_verified_at' => Carbon::now(),
            ]
        );

        $this->command->info('Test users created.');
        $this->command->info('Users seeded successfully!');
    }
}
