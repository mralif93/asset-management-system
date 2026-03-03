<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('maintenance_records', function (Blueprint $table) {
            $table->timestamp('tarikh_penyelenggaraan_akan_datang')->nullable()->after('tarikh_penyelenggaraan');
            $table->json('gambar_penyelenggaraan')->nullable()->after('catatan');
        });
    }

    public function down(): void
    {
        Schema::table('maintenance_records', function (Blueprint $table) {
            $table->dropColumn(['tarikh_penyelenggaraan_akan_datang', 'gambar_penyelenggaraan']);
        });
    }
};
