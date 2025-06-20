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
        Schema::table('inspections', function (Blueprint $table) {
            // Rename fields to match application usage
            $table->renameColumn('keadaan_aset', 'kondisi_aset');
            $table->renameColumn('pegawai_pemeriksa', 'nama_pemeriksa');
            $table->renameColumn('catatan_pemeriksa', 'catatan_pemeriksaan');
            $table->renameColumn('cadangan_tindakan', 'tindakan_diperlukan');
            
            // Remove unused field
            $table->dropColumn('lokasi_semasa_pemeriksaan');
            
            // Add new fields that the application expects
            $table->date('tarikh_pemeriksaan_akan_datang')->nullable()->after('kondisi_aset');
            $table->json('gambar_pemeriksaan')->nullable()->after('tindakan_diperlukan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            // Reverse the changes
            $table->renameColumn('kondisi_aset', 'keadaan_aset');
            $table->renameColumn('nama_pemeriksa', 'pegawai_pemeriksa');
            $table->renameColumn('catatan_pemeriksaan', 'catatan_pemeriksa');
            $table->renameColumn('tindakan_diperlukan', 'cadangan_tindakan');
            
            // Add back the removed field
            $table->string('lokasi_semasa_pemeriksaan')->after('keadaan_aset');
            
            // Remove the added fields
            $table->dropColumn(['tarikh_pemeriksaan_akan_datang', 'gambar_pemeriksaan']);
        });
    }
};
