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
        Schema::create('inspections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->timestamp('tarikh_pemeriksaan');
            $table->string('kondisi_aset');
            $table->string('lokasi_semasa_pemeriksaan');
            $table->string('cadangan_tindakan');
            $table->string('pegawai_pemeriksa');
            $table->text('catatan_pemeriksa')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('asset_id')
                  ->references('id')
                  ->on('assets')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
}; 