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
        Schema::table('asset_movements', function (Blueprint $table) {
            // Add user_id column
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->after('asset_id');
            
            // Add missing date columns
            $table->date('tarikh_pergerakan')->nullable()->after('lokasi_destinasi');
            $table->date('tarikh_jangka_pulangan')->nullable()->after('tarikh_pergerakan');
            
            // Rename fields to match controller expectations
            $table->renameColumn('tujuan_pergerakan', 'sebab_pergerakan');
            $table->renameColumn('catatan', 'catatan_pergerakan');
            
            // Add approval/rejection related fields
            $table->foreignId('diluluskan_oleh')->nullable()->constrained('users')->onDelete('set null')->after('pegawai_meluluskan');
            $table->timestamp('tarikh_kelulusan')->nullable()->after('diluluskan_oleh');
            $table->text('sebab_penolakan')->nullable()->after('tarikh_kelulusan');
            $table->timestamp('tarikh_kepulangan')->nullable()->after('sebab_penolakan');
            
            // Update status values
            $table->string('status_pergerakan')->default('menunggu_kelulusan')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_movements', function (Blueprint $table) {
            // Remove added columns
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('tarikh_pergerakan');
            $table->dropColumn('tarikh_jangka_pulangan');
            $table->dropForeign(['diluluskan_oleh']);
            $table->dropColumn('diluluskan_oleh');
            $table->dropColumn('tarikh_kelulusan');
            $table->dropColumn('sebab_penolakan');
            $table->dropColumn('tarikh_kepulangan');
            
            // Rename back
            $table->renameColumn('sebab_pergerakan', 'tujuan_pergerakan');
            $table->renameColumn('catatan_pergerakan', 'catatan');
            
            // Revert status default
            $table->string('status_pergerakan')->default('Dimohon')->change();
        });
    }
};
