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
            // Add missing fields based on user specifications
            
            // Add jenis field (Masjid/Surau type)
            $table->string('jenis')->default('Masjid')->after('singkatan_nama');
            
            // Add poskod field
            $table->string('poskod')->nullable()->after('alamat_baris_3');
            
            // Add bandar field
            $table->string('bandar')->nullable()->after('poskod');
            
            // Add negeri field
            $table->string('negeri')->nullable()->after('bandar');
            
            // Add no_telefon field
            $table->string('no_telefon')->nullable()->after('daerah');
            
            // Add imam_ketua field
            $table->string('imam_ketua')->nullable()->after('email');
            
            // Add bilangan_jemaah field
            $table->integer('bilangan_jemaah')->nullable()->after('imam_ketua');
            
            // Add tahun_dibina field
            $table->integer('tahun_dibina')->nullable()->after('bilangan_jemaah');
            
            // Add catatan field
            $table->text('catatan')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('masjids_suraus', function (Blueprint $table) {
            $table->dropColumn([
                'jenis',
                'poskod',
                'bandar', 
                'negeri',
                'no_telefon',
                'imam_ketua',
                'bilangan_jemaah',
                'tahun_dibina',
                'catatan'
            ]);
        });
    }
};
