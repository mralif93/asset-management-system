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
        Schema::table('losses_writeoffs', function (Blueprint $table) {
            $table->unsignedInteger('kuantiti_kehilangan')->default(1)->after('asset_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('losses_writeoffs', function (Blueprint $table) {
            $table->dropColumn('kuantiti_kehilangan');
        });
    }
};
