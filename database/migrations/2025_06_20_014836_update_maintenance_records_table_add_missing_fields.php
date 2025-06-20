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
        Schema::table('maintenance_records', function (Blueprint $table) {
            // Add user_id foreign key
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null')->after('asset_id');
            
            // Add fields that are being used in the application
            $table->string('penyedia_perkhidmatan')->nullable()->after('nama_syarikat_kontraktor');
            $table->text('catatan_penyelenggaraan')->nullable()->after('catatan');
            $table->date('tarikh_penyelenggaraan_akan_datang')->nullable()->after('catatan_penyelenggaraan');
            $table->json('gambar_penyelenggaraan')->nullable()->after('tarikh_penyelenggaraan_akan_datang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('maintenance_records', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id',
                'penyedia_perkhidmatan',
                'catatan_penyelenggaraan',
                'tarikh_penyelenggaraan_akan_datang',
                'gambar_penyelenggaraan'
            ]);
        });
    }
};
