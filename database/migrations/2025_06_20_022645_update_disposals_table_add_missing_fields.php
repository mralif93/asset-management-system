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
        Schema::table('disposals', function (Blueprint $table) {
            // Add user relationship
            $table->foreignId('user_id')->nullable()->after('asset_id')->constrained('users')->onDelete('set null');
            
            // Add new disposal fields
            $table->date('tarikh_pelupusan')->nullable()->after('tarikh_permohonan');
            $table->string('sebab_pelupusan')->nullable()->after('justifikasi_pelupusan');
            $table->string('kaedah_pelupusan')->nullable()->after('kaedah_pelupusan_dicadang');
            $table->decimal('nilai_pelupusan', 12, 2)->nullable()->after('kaedah_pelupusan');
            $table->decimal('nilai_baki', 12, 2)->nullable()->after('nilai_pelupusan');
            
            // Add approval fields
            $table->string('status_kelulusan')->default('menunggu')->after('status_pelupusan');
            $table->date('tarikh_kelulusan')->nullable()->after('tarikh_kelulusan_pelupusan');
            $table->foreignId('diluluskan_oleh')->nullable()->after('tarikh_kelulusan')->constrained('users')->onDelete('set null');
            $table->text('sebab_penolakan')->nullable()->after('diluluskan_oleh');
            
            // Add image/document field
            $table->json('gambar_pelupusan')->nullable()->after('catatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disposals', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['diluluskan_oleh']);
            $table->dropColumn([
                'user_id',
                'tarikh_pelupusan',
                'sebab_pelupusan',
                'kaedah_pelupusan',
                'nilai_pelupusan',
                'nilai_baki',
                'status_kelulusan',
                'tarikh_kelulusan',
                'diluluskan_oleh',
                'sebab_penolakan',
                'gambar_pelupusan'
            ]);
        });
    }
};
