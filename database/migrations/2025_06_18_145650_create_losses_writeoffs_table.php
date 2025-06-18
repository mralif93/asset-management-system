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
        Schema::create('losses_writeoffs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->date('tarikh_laporan');
            $table->string('jenis_kejadian');
            $table->string('sebab_kejadian');
            $table->text('butiran_kejadian');
            $table->string('pegawai_pelapor');
            $table->date('tarikh_kelulusan_hapus_kira')->nullable();
            $table->string('status_kejadian')->default('Dilaporkan');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('losses_writeoffs');
    }
};
