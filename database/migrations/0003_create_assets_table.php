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
            $table->unsignedBigInteger('masjid_surau_id');
            $table->string('no_siri_pendaftaran')->unique();
            $table->string('nama_aset');
            $table->string('jenis_aset');
            $table->date('tarikh_perolehan');
            $table->string('kaedah_perolehan');
            $table->decimal('nilai_perolehan', 10, 2);
            $table->integer('umur_faedah_tahunan')->nullable();
            $table->decimal('susut_nilai_tahunan', 10, 2)->nullable();
            $table->string('lokasi_penempatan');
            $table->string('pegawai_bertanggungjawab_lokasi');
            $table->string('status_aset')->default('Sedang Digunakan');
            $table->json('gambar_aset')->nullable();
            $table->string('no_resit')->nullable();
            $table->timestamp('tarikh_resit')->nullable();
            $table->string('dokumen_resit_url')->nullable();
            $table->string('pembekal')->nullable();
            $table->string('jenama')->nullable();
            $table->string('no_pesanan_kerajaan')->nullable();
            $table->string('no_rujukan_kontrak')->nullable();
            $table->string('tempoh_jaminan')->nullable();
            $table->date('tarikh_tamat_jaminan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('masjid_surau_id')
                  ->references('id')
                  ->on('masjid_surau')
                  ->onDelete('cascade');
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