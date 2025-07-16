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
            $table->unsignedBigInteger('asset_id');
            $table->timestamp('tarikh_laporan');
            $table->string('jenis_kejadian');
            $table->string('sebab_kejadian');
            $table->string('butiran_kejadian');
            $table->string('pegawai_pelapor');
            $table->decimal('nilai_kehilangan', 10, 2)->default(0);
            $table->string('laporan_polis')->nullable();
            $table->json('dokumen_kehilangan')->nullable();
            $table->timestamp('tarikh_kelulusan_hapus_kira')->nullable();
            $table->string('status_kejadian')->default('Dilaporkan');
            $table->unsignedBigInteger('diluluskan_oleh')->nullable();
            $table->text('sebab_penolakan')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('asset_id')
                  ->references('id')
                  ->on('assets')
                  ->onDelete('cascade');

            $table->foreign('diluluskan_oleh')
                  ->references('id')
                  ->on('users')
                  ->onDelete('set null');
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