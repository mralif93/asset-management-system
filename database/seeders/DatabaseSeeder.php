<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First create masjids/suraus
        $this->call([
            MasjidSurauSeeder::class,
        ]);

        // Create test user only if it doesn't exist
        \App\Models\User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'masjid_surau_id' => 1, // MTAJ
            ]
        );

        // Then create assets
        $this->call([
            AssetSeeder::class,
        ]);
    }
}
