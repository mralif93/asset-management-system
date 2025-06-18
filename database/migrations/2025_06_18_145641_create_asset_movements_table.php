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
        Schema::create('asset_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->date('tarikh_permohonan');
            $table->string('jenis_pergerakan');
            $table->string('lokasi_asal');
            $table->string('lokasi_destinasi');
            $table->string('nama_peminjam_pegawai_bertanggungjawab');
            $table->text('tujuan_pergerakan');
            $table->date('tarikh_jangka_pulang')->nullable();
            $table->date('tarikh_pulang_sebenar')->nullable();
            $table->string('status_pergerakan')->default('Dimohon');
            $table->string('pegawai_meluluskan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_movements');
    }
};
