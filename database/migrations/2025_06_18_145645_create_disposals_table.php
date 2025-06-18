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
        Schema::create('disposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->date('tarikh_permohonan');
            $table->text('justifikasi_pelupusan');
            $table->string('kaedah_pelupusan_dicadang');
            $table->string('nombor_mesyuarat_jawatankuasa')->nullable();
            $table->date('tarikh_kelulusan_pelupusan')->nullable();
            $table->string('status_pelupusan')->default('Dimohon');
            $table->string('pegawai_pemohon');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disposals');
    }
};
