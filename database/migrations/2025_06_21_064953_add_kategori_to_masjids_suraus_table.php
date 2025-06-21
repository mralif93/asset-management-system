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
            // Add kategori column after jenis
            $table->string('kategori', 100)->nullable()->after('jenis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('masjids_suraus', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};
