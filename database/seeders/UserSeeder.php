<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\MasjidSurau;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Starting UserSeeder...');

        // Create System Administrator (only if doesn't exist)
        User::firstOrCreate(
            ['email' => 'admin@assetflow.test'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'masjid_surau_id' => 1,
                'phone' => '0123456789',
                'position' => 'Pentadbir Sistem',
                'email_verified_at' => now(),
            ]
        );

        // Create additional admin users (only if doesn't exist)
        User::firstOrCreate(
            ['email' => 'ahmad.admin@assetflow.test'],
            [
                'name' => 'Ahmad bin Abdullah',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'masjid_surau_id' => 1,
                'phone' => '0198765432',
                'position' => 'Pentadbir Aset',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin users created.');

        // Get a limited sample of masjids/suraus for testing (first 50 records)
        // This prevents the seeder from hanging with 2,509 records
        $masjidSuraus = MasjidSurau::take(50)->get();
        $this->command->info("Creating users for {$masjidSuraus->count()} masjid/surau records...");

        // Sample user names for variety
        $userNames = [
            'Siti Aminah binti Ahmad',
            'Muhammad Hakim bin Ismail',
            'Fatimah binti Hassan',
            'Abdul Rahman bin Omar',
            'Khadijah binti Ali',
            'Zainab binti Yusof',
            'Ibrahim bin Mahmud',
            'Maryam binti Zakaria',
            'Hassan bin Abdul Malik',
            'Aisyah binti Ibrahim',
            'Omar bin Abdul Aziz',
            'Ruqayyah binti Umar',
            'Khalid bin Walid',
            'Safiyyah binti Huyayy',
            'Usman bin Affan',
            'Hafsa binti Umar',
            'Ali bin Abi Talib',
            'Zaynab binti Jahsh',
            'Abu Bakr bin Abu Quhafa',
            'Umm Salamah binti Abi Umayyah'
        ];

        // Sample positions
        $positions = [
            'Pegawai Aset',
            'Setiausaha',
            'Bendahari',
            'Pengerusi',
            'Pembantu Pentadbir',
            'Pengurus Fasiliti',
            'Imam',
            'Bilal',
            'Guru Kelas Agama',
            'Pengurus Canteen'
        ];

        // Create users for limited masjid/surau sample
        foreach ($masjidSuraus as $index => $masjidSurau) {
            // Create 2 users per masjid/surau (reduced from 2-3)
            $numUsers = 2;
            
            for ($i = 0; $i < $numUsers; $i++) {
                $userName = $userNames[($index * 2 + $i) % count($userNames)];
                $email = strtolower(str_replace([' ', 'bin ', 'binti '], ['', '', ''], $userName)) . 
                        $masjidSurau->id . '@' . 
                        strtolower(str_replace([' ', '-', '.', ','], '', $masjidSurau->nama)) . '.test';
                
                User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $userName,
                        'password' => Hash::make('password123'),
                        'role' => 'user',
                        'masjid_surau_id' => $masjidSurau->id,
                        'phone' => '01' . rand(10000000, 99999999),
                        'position' => $positions[array_rand($positions)],
                        'email_verified_at' => now(),
                    ]
                );
            }

            // Progress indicator every 10 records
            if (($index + 1) % 10 == 0) {
                $this->command->info("Processed " . ($index + 1) . " masjid/surau records...");
            }
        }

        $this->command->info('Regular users created for sample masjid/surau records.');

        // Create some specific test users
        User::firstOrCreate(
            ['email' => 'user@assetflow.test'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'masjid_surau_id' => 2,
                'phone' => '0123334444',
                'position' => 'Pegawai Ujian',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'pengurusan@masjidtaj.test'],
            [
                'name' => 'Pengurusan Masjid Tengku Ampuan Jemaah',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'masjid_surau_id' => 1,
                'phone' => '0195551234',
                'position' => 'Pengurus Masjid',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'pentadbir@surauattaqwa.test'],
            [
                'name' => 'Pentadbir Surau At-Taqwa',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'masjid_surau_id' => 2,
                'phone' => '0187776666',
                'position' => 'Pentadbir Surau',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Test users created.');
        $this->command->info('Users seeded successfully!');
    }
}
