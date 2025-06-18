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
            $table->foreignId('asset_id')->constrained('assets')->onDelete('cascade');
            $table->date('tarikh_penyelenggaraan');
            $table->string('jenis_penyelenggaraan');
            $table->text('butiran_kerja');
            $table->string('nama_syarikat_kontraktor')->nullable();
            $table->decimal('kos_penyelenggaraan', 15, 2);
            $table->string('status_penyelenggaraan')->default('Dalam Proses');
            $table->string('pegawai_bertanggungjawab');
            $table->text('catatan')->nullable();
            $table->timestamps();
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
