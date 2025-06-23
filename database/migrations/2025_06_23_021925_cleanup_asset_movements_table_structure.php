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
            // Remove duplicate/legacy columns that are no longer needed
            
            // Remove the old date column (we're using tarikh_jangka_pulangan instead)
            if (Schema::hasColumn('asset_movements', 'tarikh_jangka_pulang')) {
                $table->dropColumn('tarikh_jangka_pulang');
            }
            
            // Remove legacy approval field (we're using diluluskan_oleh instead)
            if (Schema::hasColumn('asset_movements', 'pegawai_meluluskan')) {
                $table->dropColumn('pegawai_meluluskan');
            }
            
            // Ensure all required columns exist with proper types
            if (!Schema::hasColumn('asset_movements', 'user_id')) {
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->after('asset_id');
            }
            
            if (!Schema::hasColumn('asset_movements', 'tarikh_pergerakan')) {
                $table->date('tarikh_pergerakan')->nullable()->after('lokasi_destinasi');
            }
            
            if (!Schema::hasColumn('asset_movements', 'tarikh_jangka_pulangan')) {
                $table->date('tarikh_jangka_pulangan')->nullable()->after('tarikh_pergerakan');
            }
            
            if (!Schema::hasColumn('asset_movements', 'diluluskan_oleh')) {
                $table->foreignId('diluluskan_oleh')->nullable()->constrained('users')->onDelete('set null');
            }
            
            if (!Schema::hasColumn('asset_movements', 'tarikh_kelulusan')) {
                $table->timestamp('tarikh_kelulusan')->nullable();
            }
            
            if (!Schema::hasColumn('asset_movements', 'sebab_penolakan')) {
                $table->text('sebab_penolakan')->nullable();
            }
            
            if (!Schema::hasColumn('asset_movements', 'tarikh_kepulangan')) {
                $table->timestamp('tarikh_kepulangan')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_movements', function (Blueprint $table) {
            // Add back the removed columns
            $table->date('tarikh_jangka_pulang')->nullable();
            $table->string('pegawai_meluluskan')->nullable();
        });
    }
};
