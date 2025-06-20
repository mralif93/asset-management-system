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
            // Drop old columns if they exist
            if (Schema::hasColumn('masjids_suraus', 'singkatan_nama')) {
                $table->dropColumn('singkatan_nama');
            }
            if (Schema::hasColumn('masjids_suraus', 'daerah')) {
                $table->dropColumn('daerah');
            }
            if (Schema::hasColumn('masjids_suraus', 'no_telefon')) {
                $table->dropColumn('no_telefon');
            }
            
            // Add new columns with default values for NOT NULL columns
            $table->enum('jenis', ['Masjid', 'Surau'])->default('Masjid')->after('nama');
            $table->string('poskod', 10)->default('00000')->after('alamat');
            $table->string('bandar', 100)->default('')->after('poskod');
            $table->string('negeri', 100)->default('')->after('bandar');
            $table->string('telefon', 20)->nullable()->after('negeri');
            $table->string('imam_ketua')->nullable()->after('email');
            $table->integer('bilangan_jemaah')->nullable()->after('imam_ketua');
            $table->integer('tahun_dibina')->nullable()->after('bilangan_jemaah');
            $table->text('catatan')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('masjids_suraus', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn([
                'jenis', 'poskod', 'bandar', 'negeri', 'telefon',
                'imam_ketua', 'bilangan_jemaah', 'tahun_dibina', 'catatan'
            ]);
            
            // Add back old columns
            $table->string('singkatan_nama')->nullable()->after('nama');
            $table->string('daerah')->after('alamat');
            $table->string('no_telefon')->nullable()->after('email');
        });
    }
};
