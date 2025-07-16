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
        Schema::create('maintenance_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamp('tarikh_penyelenggaraan');
            $table->string('jenis_penyelenggaraan');
            $table->string('butiran_kerja');
            $table->string('nama_syarikat_kontraktor')->nullable();
            $table->string('penyedia_perkhidmatan')->nullable();
            $table->decimal('kos_penyelenggaraan', 10, 2);
            $table->string('status_penyelenggaraan')->default('Dalam Proses');
            $table->string('pegawai_bertanggungjawab');
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
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_records');
    }
}; 