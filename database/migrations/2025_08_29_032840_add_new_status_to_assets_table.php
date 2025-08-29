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
        Schema::table('assets', function (Blueprint $table) {
            // Add comment to document the new "Baru" status option
            // Current status_aset field values: 'Sedang Digunakan', 'Dalam Penyelenggaraan', 'Rosak', 'Aktif', 'Dilupuskan', 'Baru'
            // The field remains as string type to maintain backward compatibility
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            //
        });
    }
};
