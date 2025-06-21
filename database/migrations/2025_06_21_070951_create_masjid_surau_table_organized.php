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
        Schema::create('masjid_surau', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('singkatan_nama', 20)->nullable();
            $table->enum('jenis', ['Masjid', 'Surau'])->default('Masjid');
            $table->string('kategori', 100)->nullable();
            
            // Address fields
            $table->string('alamat_baris_1')->nullable();
            $table->string('alamat_baris_2')->nullable();
            $table->string('alamat_baris_3')->nullable();
            $table->string('poskod', 10)->default('00000');
            $table->string('bandar', 100)->default('');
            $table->string('negeri', 100)->default('');
            $table->string('negara')->default('Malaysia');
            $table->string('daerah')->default('');
            
            // Contact information
            $table->string('no_telefon', 20)->nullable();
            $table->string('email')->nullable();
            
            // Additional details
            $table->string('imam_ketua')->nullable();
            $table->integer('bilangan_jemaah')->nullable();
            $table->integer('tahun_dibina')->nullable();
            $table->string('status')->default('Aktif');
            $table->text('catatan')->nullable();
            
            // New fields for scraped data
            $table->string('nama_rasmi')->nullable()->comment('Official registered name');
            $table->string('kawasan')->nullable()->comment('Sub-district/local area');
            $table->text('pautan_peta')->nullable()->comment('Google Maps link');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('masjid_surau');
    }
};
