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
        Schema::create('masjids_suraus', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('singkatan_nama');
            $table->text('alamat');
            $table->string('daerah');
            $table->string('no_telefon')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->default('Aktif');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masjids_suraus');
    }
};
