<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('asset_movements', function (Blueprint $table) {
            $table->longText('tandatangan_penerima')->nullable()->after('catatan');
            $table->longText('tandatangan_pemulangan')->nullable()->after('tandatangan_penerima');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_movements', function (Blueprint $table) {
            $table->dropColumn(['tandatangan_penerima', 'tandatangan_pemulangan']);
        });
    }
};
