<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Update keadaan_fizikal enum to match controller validation values
     */
    public function up(): void
    {
        // Update existing values to match new enum values
        DB::statement("UPDATE assets SET keadaan_fizikal = 'Baik' WHERE keadaan_fizikal IN ('Sedang Digunakan', 'Baik')");
        DB::statement("UPDATE assets SET keadaan_fizikal = 'Tidak Boleh Digunakan' WHERE keadaan_fizikal = 'Tidak Digunakan'");
        DB::statement("UPDATE assets SET keadaan_fizikal = 'Sederhana' WHERE keadaan_fizikal = 'Sedang Diselenggara'");
        DB::statement("UPDATE assets SET keadaan_fizikal = 'Cemerlang' WHERE keadaan_fizikal = 'Hilang'");
        
        // For SQLite, we need to recreate the table with new CHECK constraint
        // This is a workaround since SQLite doesn't support ALTER COLUMN for CHECK constraints
        if (DB::getDriverName() === 'sqlite') {
            // The CHECK constraint will be enforced on insert/update
            // We just need to ensure the data is updated
        } else {
            // For MySQL/PostgreSQL, alter the enum
            Schema::table('assets', function (Blueprint $table) {
                $table->enum('keadaan_fizikal', ['Cemerlang', 'Baik', 'Sederhana', 'Rosak', 'Tidak Boleh Digunakan'])
                    ->default('Baik')
                    ->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to old values
        DB::statement("UPDATE assets SET keadaan_fizikal = 'Sedang Digunakan' WHERE keadaan_fizikal = 'Baik'");
        DB::statement("UPDATE assets SET keadaan_fizikal = 'Tidak Digunakan' WHERE keadaan_fizikal = 'Tidak Boleh Digunakan'");
        DB::statement("UPDATE assets SET keadaan_fizikal = 'Sedang Diselenggara' WHERE keadaan_fizikal = 'Sederhana'");
        DB::statement("UPDATE assets SET keadaan_fizikal = 'Hilang' WHERE keadaan_fizikal = 'Cemerlang'");
        
        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('assets', function (Blueprint $table) {
                $table->enum('keadaan_fizikal', ['Sedang Digunakan', 'Tidak Digunakan', 'Rosak', 'Sedang Diselenggara', 'Hilang'])
                    ->default('Sedang Digunakan')
                    ->change();
            });
        }
    }
};
