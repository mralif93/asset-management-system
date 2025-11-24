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
        Schema::table('assets', function (Blueprint $table) {
            $table->enum('keadaan_fizikal', ['Cemerlang', 'Baik', 'Sederhana', 'Rosak', 'Tidak Boleh Digunakan'])->default('Baik')->after('status_aset');
            $table->enum('status_jaminan', ['Aktif', 'Tamat', 'Tiada Jaminan'])->default('Tiada Jaminan')->after('keadaan_fizikal');
            $table->date('tarikh_pemeriksaan_terakhir')->nullable()->after('status_jaminan');
            $table->date('tarikh_penyelenggaraan_akan_datang')->nullable()->after('tarikh_pemeriksaan_terakhir');
            $table->text('catatan_jaminan')->nullable()->after('tarikh_penyelenggaraan_akan_datang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            $table->dropColumn([
                'keadaan_fizikal',
                'status_jaminan',
                'tarikh_pemeriksaan_terakhir',
                'tarikh_penyelenggaraan_akan_datang',
                'catatan_jaminan'
            ]);
        });
    }
};
