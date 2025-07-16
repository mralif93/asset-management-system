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
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('origin_masjid_surau_id');
            $table->unsignedBigInteger('destination_masjid_surau_id');
            $table->timestamp('tarikh_permohonan');
            $table->string('jenis_pergerakan');
            $table->string('lokasi_asal_spesifik');
            $table->string('lokasi_destinasi_spesifik');
            $table->string('nama_peminjam_pegawai_bertanggungjawab');
            $table->string('tujuan_pergerakan');
            $table->timestamp('tarikh_pergerakan')->nullable();
            $table->timestamp('tarikh_jangka_pulang')->nullable();
            $table->timestamp('tarikh_pulang_sebenar')->nullable();
            $table->string('status_pergerakan')->default('Dimohon');
            $table->string('pegawai_meluluskan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('asset_id')
                  ->references('id')
                  ->on('assets')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');

            $table->foreign('origin_masjid_surau_id')
                  ->references('id')
                  ->on('masjid_surau')
                  ->onDelete('cascade');

            $table->foreign('destination_masjid_surau_id')
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
        Schema::dropIfExists('asset_movements');
    }
}; 