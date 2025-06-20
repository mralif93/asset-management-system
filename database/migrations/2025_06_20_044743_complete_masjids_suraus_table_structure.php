<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('masjids_suraus', function (Blueprint $table) {
            // Add missing fields that were not included in the previous migration
            
            // Add singkatan_nama field (for asset serial generation)
            if (!Schema::hasColumn('masjids_suraus', 'singkatan_nama')) {
                $table->string('singkatan_nama', 20)->nullable()->after('nama');
            }
            
            // Add separate address lines
            if (!Schema::hasColumn('masjids_suraus', 'alamat_baris_1')) {
                $table->string('alamat_baris_1')->nullable()->after('jenis');
            }
            if (!Schema::hasColumn('masjids_suraus', 'alamat_baris_2')) {
                $table->string('alamat_baris_2')->nullable()->after('alamat_baris_1');
            }
            if (!Schema::hasColumn('masjids_suraus', 'alamat_baris_3')) {
                $table->string('alamat_baris_3')->nullable()->after('alamat_baris_2');
            }
            
            // Add negara field
            if (!Schema::hasColumn('masjids_suraus', 'negara')) {
                $table->string('negara')->default('Malaysia')->after('negeri');
            }
            
            // Add daerah field (required)
            if (!Schema::hasColumn('masjids_suraus', 'daerah')) {
                $table->string('daerah')->default('')->after('negara');
            }
            
            // Rename telefon to no_telefon if needed
            if (Schema::hasColumn('masjids_suraus', 'telefon') && !Schema::hasColumn('masjids_suraus', 'no_telefon')) {
                $table->renameColumn('telefon', 'no_telefon');
            }
            
            // Drop old alamat field since we have separate address lines now
            if (Schema::hasColumn('masjids_suraus', 'alamat')) {
                $table->dropColumn('alamat');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('masjids_suraus', function (Blueprint $table) {
            // Add back alamat field
            $table->text('alamat')->nullable()->after('jenis');
            
            // Drop the new fields
            $table->dropColumn([
                'singkatan_nama',
                'alamat_baris_1',
                'alamat_baris_2', 
                'alamat_baris_3',
                'negara',
                'daerah'
            ]);
            
            // Rename no_telefon back to telefon if needed
            if (Schema::hasColumn('masjids_suraus', 'no_telefon')) {
                $table->renameColumn('no_telefon', 'telefon');
            }
        });
    }
};
