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
        // Base data seeders (must run first)
        $this->call([
            MasjidSurauSeeder::class,
            UserSeeder::class,
            AssetSeeder::class,
        ]);

        // Asset management module seeders (depend on assets and users)
        $this->call([
            AssetMovementSeeder::class,
            InspectionSeeder::class,
            MaintenanceRecordSeeder::class,
            DisposalSeeder::class,
            LossWriteoffSeeder::class, // Fixed column name issues
            ImmovableAssetSeeder::class,
        ]);

        $this->command->info('🎉 All asset management seeders completed successfully!');
        $this->command->line('');
        $this->command->info('📊 Database Summary:');
        $this->command->line('✅ Masjid/Surau data seeded');
        $this->command->line('✅ Users (Admin & Regular) seeded');
        $this->command->line('✅ Assets seeded');
        $this->command->line('✅ Asset movements seeded');
        $this->command->line('✅ Inspections seeded');
        $this->command->line('✅ Maintenance records seeded');
        $this->command->line('✅ Disposals seeded');
        $this->command->line('✅ Loss/writeoffs seeded');
        $this->command->line('✅ Immovable assets seeded');
        $this->command->line('');
        $this->command->info('🚀 Your Asset Management System is ready with comprehensive test data!');
    }
}
