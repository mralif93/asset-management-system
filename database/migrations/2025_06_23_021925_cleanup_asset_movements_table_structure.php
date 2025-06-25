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
            
            // Add foreign keys for source and destination masjid/surau
            $table->foreignId('masjid_surau_asal_id')->nullable()->after('asset_id')
                  ->constrained('masjid_surau')->onDelete('set null');
            $table->foreignId('masjid_surau_destinasi_id')->nullable()->after('masjid_surau_asal_id')
                  ->constrained('masjid_surau')->onDelete('set null');
            
            // Add specific location within masjid/surau
            $table->string('lokasi_terperinci_asal')->nullable()->after('lokasi_asal')
                  ->comment('Lokasi spesifik dalam masjid/surau asal');
            $table->string('lokasi_terperinci_destinasi')->nullable()->after('lokasi_destinasi')
                  ->comment('Lokasi spesifik dalam masjid/surau destinasi');
            
            // Add approval fields for both source and destination masjid/surau
            $table->foreignId('diluluskan_oleh_asal')->nullable()->after('diluluskan_oleh')
                  ->constrained('users')->onDelete('set null')
                  ->comment('Pegawai yang meluluskan dari lokasi asal');
            $table->foreignId('diluluskan_oleh_destinasi')->nullable()->after('diluluskan_oleh_asal')
                  ->constrained('users')->onDelete('set null')
                  ->comment('Pegawai yang meluluskan dari lokasi destinasi');
            
            // Add approval dates for both locations
            $table->timestamp('tarikh_kelulusan_asal')->nullable()->after('tarikh_kelulusan')
                  ->comment('Tarikh kelulusan dari lokasi asal');
            $table->timestamp('tarikh_kelulusan_destinasi')->nullable()->after('tarikh_kelulusan_asal')
                  ->comment('Tarikh kelulusan dari lokasi destinasi');
            
            // Add status for both approvals
            $table->string('status_kelulusan_asal')->nullable()->after('status_pergerakan')
                  ->comment('Status kelulusan dari lokasi asal');
            $table->string('status_kelulusan_destinasi')->nullable()->after('status_kelulusan_asal')
                  ->comment('Status kelulusan dari lokasi destinasi');
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
            
            // Remove foreign keys
            $table->dropForeign(['masjid_surau_asal_id']);
            $table->dropForeign(['masjid_surau_destinasi_id']);
            $table->dropForeign(['diluluskan_oleh_asal']);
            $table->dropForeign(['diluluskan_oleh_destinasi']);
            
            // Remove columns
            $table->dropColumn([
                'masjid_surau_asal_id',
                'masjid_surau_destinasi_id',
                'lokasi_terperinci_asal',
                'lokasi_terperinci_destinasi',
                'diluluskan_oleh_asal',
                'diluluskan_oleh_destinasi',
                'tarikh_kelulusan_asal',
                'tarikh_kelulusan_destinasi',
                'status_kelulusan_asal',
                'status_kelulusan_destinasi'
            ]);
        });
    }
};
