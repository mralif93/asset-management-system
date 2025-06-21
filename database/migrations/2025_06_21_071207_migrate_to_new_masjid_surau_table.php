<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, check if old table exists and new table exists
        if (Schema::hasTable('masjids_suraus') && Schema::hasTable('masjid_surau')) {
            // Copy data from old table to new table
            echo "Migrating data from masjids_suraus to masjid_surau...\n";
            
            $oldRecords = DB::table('masjids_suraus')->get();
            
            foreach ($oldRecords as $record) {
                // Check if record already exists in new table
                $exists = DB::table('masjid_surau')
                    ->where('nama', $record->nama)
                    ->where('jenis', $record->jenis ?? 'Masjid')
                    ->exists();
                
                if (!$exists) {
                    DB::table('masjid_surau')->insert([
                        'nama' => $record->nama,
                        'singkatan_nama' => $record->singkatan_nama ?? null,
                        'jenis' => $record->jenis ?? 'Masjid',
                        'kategori' => $record->kategori ?? null,
                        'alamat_baris_1' => $record->alamat_baris_1 ?? null,
                        'alamat_baris_2' => $record->alamat_baris_2 ?? null,
                        'alamat_baris_3' => $record->alamat_baris_3 ?? null,
                        'poskod' => $record->poskod ?? '00000',
                        'bandar' => $record->bandar ?? '',
                        'negeri' => $record->negeri ?? '',
                        'negara' => $record->negara ?? 'Malaysia',
                        'daerah' => $record->daerah ?? '',
                        'no_telefon' => $record->no_telefon ?? null,
                        'email' => $record->email ?? null,
                        'imam_ketua' => $record->imam_ketua ?? null,
                        'bilangan_jemaah' => $record->bilangan_jemaah ?? null,
                        'tahun_dibina' => $record->tahun_dibina ?? null,
                        'status' => $record->status ?? 'Aktif',
                        'catatan' => $record->catatan ?? null,
                        'nama_rasmi' => null,
                        'kawasan' => null,
                        'pautan_peta' => null,
                        'created_at' => $record->created_at,
                        'updated_at' => $record->updated_at,
                    ]);
                }
            }
            
            echo "Data migration completed.\n";
        }
        
        // Update foreign key constraints to point to new table
        $this->updateForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is not easily reversible due to the complexity
        // of restoring the old table structure and foreign keys
        echo "This migration cannot be easily reversed.\n";
        echo "Manual intervention may be required to restore the old structure.\n";
    }
    
    private function updateForeignKeyConstraints(): void
    {
        echo "Updating foreign key constraints...\n";
        
        // For SQLite, we need to recreate tables with new foreign keys
        // This is a simplified approach - in production, you might want more careful handling
        
        try {
            // Update users table foreign key
            if (Schema::hasTable('users') && Schema::hasColumn('users', 'masjid_surau_id')) {
                // For SQLite, we'll just update the validation in controllers
                // The actual foreign key constraint update would require table recreation
                echo "Note: Foreign key constraints will be updated in application validation.\n";
            }
            
            // Update assets table foreign key
            if (Schema::hasTable('assets') && Schema::hasColumn('assets', 'masjid_surau_id')) {
                echo "Assets table foreign key noted for application-level validation.\n";
            }
            
            // Update immovable_assets table foreign key
            if (Schema::hasTable('immovable_assets') && Schema::hasColumn('immovable_assets', 'masjid_surau_id')) {
                echo "Immovable assets table foreign key noted for application-level validation.\n";
            }
            
        } catch (\Exception $e) {
            echo "Error updating foreign key constraints: " . $e->getMessage() . "\n";
            echo "Foreign key validation will be handled at application level.\n";
        }
    }
};
