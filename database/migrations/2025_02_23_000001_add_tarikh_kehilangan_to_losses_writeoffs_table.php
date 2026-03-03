<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('losses_writeoffs', function (Blueprint $table) {
            $table->timestamp('tarikh_kehilangan')->nullable()->after('tarikh_laporan');
        });
    }

    public function down(): void
    {
        Schema::table('losses_writeoffs', function (Blueprint $table) {
            $table->dropColumn('tarikh_kehilangan');
        });
    }
};
