<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('disposals', function (Blueprint $table) {
            $table->timestamp('tarikh_pelupusan')->nullable()->after('tarikh_kelulusan_pelupusan');
            $table->string('kaedah_pelupusan')->nullable()->after('kaedah_pelupusan_dicadang');
            $table->string('tempat_pelupusan')->nullable()->after('catatan');
            $table->decimal('hasil_pelupusan', 12, 2)->default(0)->after('tempat_pelupusan');
            $table->decimal('nilai_pelupusan', 12, 2)->default(0)->after('hasil_pelupusan');
            $table->unsignedBigInteger('user_id')->nullable()->after('asset_id');
            $table->integer('kuantiti')->default(1)->change();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('disposals', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'tarikh_pelupusan',
                'kaedah_pelupusan',
                'tempat_pelupusan',
                'hasil_pelupusan',
                'nilai_pelupusan',
                'user_id',
            ]);
        });
    }
};
