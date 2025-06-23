<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For SQLite, we need to recreate the table to fix foreign key constraints
        
        // First, create a temporary table with the correct foreign key
        Schema::create('users_temp', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('remember_token', 100)->nullable();
            $table->timestamps();
            $table->string('role')->default('Pegawai Aset');
            $table->foreignId('masjid_surau_id')->nullable()->constrained('masjid_surau')->onDelete('set null');
            $table->string('phone')->nullable();
            $table->string('position')->nullable();
        });

        // Copy data from old table to new table
        $users = DB::table('users')->get();
        
        foreach ($users as $user) {
            // Map the masjid_surau_id from old table to new table
            // We need to find the corresponding ID in the masjid_surau table
            $masjidSurauId = null;
            
            if ($user->masjid_surau_id) {
                // Try to find the corresponding record in masjid_surau table
                $masjidSurau = DB::table('masjid_surau')
                    ->where('id', $user->masjid_surau_id)
                    ->first();
                
                if ($masjidSurau) {
                    $masjidSurauId = $masjidSurau->id;
                } else {
                    // If not found, try to find by name from masjids_suraus
                    $oldMasjidSurau = DB::table('masjids_suraus')
                        ->where('id', $user->masjid_surau_id)
                        ->first();
                    
                    if ($oldMasjidSurau) {
                        $newMasjidSurau = DB::table('masjid_surau')
                            ->where('nama', $oldMasjidSurau->nama)
                            ->first();
                        
                        if ($newMasjidSurau) {
                            $masjidSurauId = $newMasjidSurau->id;
                        }
                    }
                }
            }

            DB::table('users_temp')->insert([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'password' => $user->password,
                'remember_token' => $user->remember_token,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
                'role' => $user->role,
                'masjid_surau_id' => $masjidSurauId,
                'phone' => $user->phone ?? null,
                'position' => $user->position ?? null,
            ]);
        }

        // Drop the old table and rename the temp table
        Schema::dropIfExists('users');
        Schema::rename('users_temp', 'users');
        
        echo "Fixed users table foreign key constraint to point to masjid_surau table.\n";
        
        // Fix assets table foreign key constraint
        $this->fixAssetsTable();
        
        // Fix immovable_assets table foreign key constraint
        $this->fixImmovableAssetsTable();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is not easily reversible
        echo "This migration cannot be easily reversed.\n";
    }
    
    private function fixAssetsTable(): void
    {
        // Create temporary assets table with correct foreign key
        Schema::create('assets_temp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('masjid_surau_id')->constrained('masjid_surau')->onDelete('cascade');
            $table->string('no_siri_pendaftaran')->unique();
            $table->string('nama_aset');
            $table->string('jenis_aset');
            $table->date('tarikh_perolehan');
            $table->string('kaedah_perolehan');
            $table->decimal('nilai_perolehan', 15, 2);
            $table->integer('umur_faedah_tahunan')->nullable();
            $table->decimal('susut_nilai_tahunan', 15, 2)->nullable();
            $table->string('lokasi_penempatan');
            $table->string('pegawai_bertanggungjawab_lokasi');
            $table->string('status_aset')->default('Sedang Digunakan');
            $table->json('gambar_aset')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // Copy data from old table to new table
        $assets = DB::table('assets')->get();
        
        foreach ($assets as $asset) {
            // Map the masjid_surau_id from old table to new table
            $masjidSurauId = $this->mapMasjidSurauId($asset->masjid_surau_id);

            if ($masjidSurauId) {
                DB::table('assets_temp')->insert([
                    'id' => $asset->id,
                    'masjid_surau_id' => $masjidSurauId,
                    'no_siri_pendaftaran' => $asset->no_daftar_aset ?? 'TEMP-' . $asset->id,
                    'nama_aset' => $asset->nama_aset,
                    'jenis_aset' => $asset->jenis_aset,
                    'tarikh_perolehan' => $asset->tarikh_perolehan,
                    'kaedah_perolehan' => $asset->cara_perolehan ?? 'Pembelian',
                    'nilai_perolehan' => $asset->nilai_perolehan,
                    'umur_faedah_tahunan' => null,
                    'susut_nilai_tahunan' => null,
                    'lokasi_penempatan' => $asset->lokasi_semasa ?? 'Tidak Dinyatakan',
                    'pegawai_bertanggungjawab_lokasi' => 'Tidak Dinyatakan',
                    'status_aset' => $asset->status_aset,
                    'gambar_aset' => null,
                    'catatan' => $asset->catatan,
                    'created_at' => $asset->created_at,
                    'updated_at' => $asset->updated_at,
                ]);
            }
        }

        // Drop the old table and rename the temp table
        Schema::dropIfExists('assets');
        Schema::rename('assets_temp', 'assets');
        
        echo "Fixed assets table foreign key constraint.\n";
    }
    
    private function fixImmovableAssetsTable(): void
    {
        // Create temporary immovable_assets table with correct foreign key
        Schema::create('immovable_assets_temp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('masjid_surau_id')->constrained('masjid_surau')->onDelete('cascade');
            $table->string('nama_aset');
            $table->string('jenis_aset');
            $table->text('alamat')->nullable();
            $table->string('no_hakmilik')->nullable();
            $table->string('no_lot')->nullable();
            $table->decimal('luas_tanah_bangunan', 15, 2);
            $table->date('tarikh_perolehan');
            $table->string('sumber_perolehan');
            $table->decimal('kos_perolehan', 15, 2);
            $table->string('keadaan_semasa');
            $table->json('gambar_aset')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        // Copy data from old table to new table
        $immovableAssets = DB::table('immovable_assets')->get();
        
        foreach ($immovableAssets as $asset) {
            // Map the masjid_surau_id from old table to new table
            $masjidSurauId = $this->mapMasjidSurauId($asset->masjid_surau_id);

            if ($masjidSurauId) {
                DB::table('immovable_assets_temp')->insert([
                    'id' => $asset->id,
                    'masjid_surau_id' => $masjidSurauId,
                    'nama_aset' => $asset->nama_aset,
                    'jenis_aset' => $asset->jenis_aset,
                    'alamat' => null,
                    'no_hakmilik' => null,
                    'no_lot' => null,
                    'luas_tanah_bangunan' => 0,
                    'tarikh_perolehan' => $asset->tarikh_perolehan,
                    'sumber_perolehan' => $asset->cara_perolehan ?? 'Tidak Dinyatakan',
                    'kos_perolehan' => $asset->nilai_perolehan ?? 0,
                    'keadaan_semasa' => $asset->keadaan_aset ?? 'Baik',
                    'gambar_aset' => null,
                    'catatan' => $asset->catatan,
                    'created_at' => $asset->created_at,
                    'updated_at' => $asset->updated_at,
                ]);
            }
        }

        // Drop the old table and rename the temp table
        Schema::dropIfExists('immovable_assets');
        Schema::rename('immovable_assets_temp', 'immovable_assets');
        
        echo "Fixed immovable_assets table foreign key constraint.\n";
    }
    
    private function mapMasjidSurauId($oldId): ?int
    {
        if (!$oldId) {
            return null;
        }
        
        // Try to find the corresponding record in masjid_surau table
        $masjidSurau = DB::table('masjid_surau')
            ->where('id', $oldId)
            ->first();
        
        if ($masjidSurau) {
            return $masjidSurau->id;
        }
        
        // If not found, try to find by name from masjids_suraus
        $oldMasjidSurau = DB::table('masjids_suraus')
            ->where('id', $oldId)
            ->first();
        
        if ($oldMasjidSurau) {
            $newMasjidSurau = DB::table('masjid_surau')
                ->where('nama', $oldMasjidSurau->nama)
                ->first();
            
            if ($newMasjidSurau) {
                return $newMasjidSurau->id;
            }
        }
        
        return null;
    }
};
