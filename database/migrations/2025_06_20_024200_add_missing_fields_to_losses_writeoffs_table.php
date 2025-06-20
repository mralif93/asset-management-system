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
        Schema::table('losses_writeoffs', function (Blueprint $table) {
            // Add missing fields that the application expects
            $table->decimal('nilai_kehilangan', 15, 2)->default(0)->after('sebab_kehilangan');
            $table->string('laporan_polis')->nullable()->after('nilai_kehilangan');
            $table->json('dokumen_kehilangan')->nullable()->after('catatan_kehilangan');
            $table->foreignId('diluluskan_oleh')->nullable()->constrained('users')->after('tarikh_kelulusan');
            $table->text('sebab_penolakan')->nullable()->after('diluluskan_oleh');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('losses_writeoffs', function (Blueprint $table) {
            // Remove the added fields
            $table->dropForeign(['diluluskan_oleh']);
            $table->dropColumn(['nilai_kehilangan', 'laporan_polis', 'dokumen_kehilangan', 'diluluskan_oleh', 'sebab_penolakan']);
        });
    }
};
