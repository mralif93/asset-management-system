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
            // Fields for "Disediakan oleh" (Creator)
            // Note: 'nama' is covered by 'nama_peminjam_pegawai_bertanggungjawab' or related user/staff logic, 
            // but for the specific signature box we might want explicit fields if they differ from the logged in user.
            // Based on current form, there is 'nama_peminjam_pegawai_bertanggungjawab'.
            // The existing 'pegawai_bertanggungjawab_signature' maps to "Disediakan oleh" signature.

            $table->string('disediakan_oleh_jawatan')->nullable()->after('pegawai_bertanggungjawab_signature');
            $table->date('disediakan_oleh_tarikh')->nullable()->after('disediakan_oleh_jawatan');

            // Fields for "Disahkan oleh" (Approver/Verifier)
            // Existing 'pegawai_meluluskan' might be used for the name, but let's be explicit for the signature block.
            $table->longText('disahkan_oleh_signature')->nullable()->after('disediakan_oleh_tarikh');
            $table->string('disahkan_oleh_nama')->nullable()->after('disahkan_oleh_signature');
            $table->string('disahkan_oleh_jawatan')->nullable()->after('disahkan_oleh_nama');
            $table->date('disahkan_oleh_tarikh')->nullable()->after('disahkan_oleh_jawatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_movements', function (Blueprint $table) {
            $table->dropColumn([
                'disediakan_oleh_jawatan',
                'disediakan_oleh_tarikh',
                'disahkan_oleh_signature',
                'disahkan_oleh_nama',
                'disahkan_oleh_jawatan',
                'disahkan_oleh_tarikh'
            ]);
        });
    }
};
