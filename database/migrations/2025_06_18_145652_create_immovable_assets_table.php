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
        Schema::create('immovable_assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('masjid_surau_id')->constrained('masjids_suraus')->onDelete('cascade');
            $table->string('nama_aset');
            $table->string('jenis_aset');
            $table->text('alamat')->nullable();
            $table->string('no_hakmilik')->nullable();
            $table->string('no_lot')->nullable();
            $table->decimal('luas_tanah_bangunan', 15, 2);
            $table->date('tarikh_perolehan');
            $table->string('sumber_perolehan');
            $table->decimal('kos_perolehan', 15, 2);
            $table->string('keadaan_semasa');
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
        Schema::dropIfExists('immovable_assets');
    }
};
