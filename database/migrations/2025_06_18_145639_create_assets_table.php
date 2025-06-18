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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('masjid_surau_id')->constrained('masjids_suraus')->onDelete('cascade');
            $table->string('no_siri_pendaftaran')->unique();
            $table->string('nama_aset');
            $table->string('jenis_aset');
            $table->date('tarikh_perolehan');
            $table->string('kaedah_perolehan');
            $table->decimal('nilai_perolehan', 15, 2);
            $table->integer('umur_faedah_tahunan')->nullable();
            $table->decimal('susut_nilai_tahunan', 15, 2)->nullable();
            $table->string('lokasi_penempatan');
            $table->string('pegawai_bertanggungjawab_lokasi');
            $table->string('status_aset')->default('Sedang Digunakan');
            $table->json('gambar_aset')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
