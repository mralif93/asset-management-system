<?php

namespace Tests\Feature\Integration;

use App\Models\Asset;
use App\Models\AssetMovement;
use App\Models\Inspection;
use App\Models\MaintenanceRecord;
use App\Models\MasjidSurau;
use App\Models\User;
use App\Helpers\AssetRegistrationNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AssetWorkflowTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $user;
    private MasjidSurau $sourceMasjid;
    private MasjidSurau $destinationMasjid;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test users
        $this->admin = User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@test.com',
            'role' => 'admin'
        ]);

        $this->user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'user@test.com',
            'role' => 'user'
        ]);

        // Create test masjids
        $this->sourceMasjid = MasjidSurau::create([
            'nama' => 'Source Masjid',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
            'singkatan_nama' => 'SM'
        ]);

        $this->destinationMasjid = MasjidSurau::create([
            'nama' => 'Destination Masjid',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
            'singkatan_nama' => 'DM'
        ]);
    }

    #[Test]
    public function complete_asset_lifecycle_workflow()
    {
        // 1. Create a new asset
        $response = $this->actingAs($this->admin)->post('/admin/assets', [
            'masjid_surau_id' => $this->sourceMasjid->id,
            'nama_aset' => 'Integration Test Asset',
            'jenis_aset' => 'Elektronik',
            'tarikh_perolehan' => now()->format('Y-m-d'),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'susut_nilai_tahunan' => 100,
            'lokasi_penempatan' => 'Integration Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Integration Test Officer',
            'status_aset' => 'Aktif'
        ]);

        $response->assertStatus(302);
        $asset = Asset::latest()->first();
        $this->assertNotNull($asset);

        // 2. Perform initial inspection
        $response = $this->actingAs($this->admin)->post('/admin/inspections', [
            'asset_id' => $asset->id,
            'tarikh_pemeriksaan' => now()->format('Y-m-d'),
            'kondisi_aset' => 'Baik',
            'nama_pemeriksa' => 'Integration Test Inspector',
            'catatan_pemeriksaan' => 'Initial inspection',
            'tindakan_diperlukan' => 'None',
            'tarikh_pemeriksaan_akan_datang' => now()->addDays(90)->format('Y-m-d')
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('inspections', [
            'asset_id' => $asset->id,
            'kondisi_aset' => 'Baik'
        ]);

        // 3. Create maintenance record based on inspection
        $response = $this->actingAs($this->admin)->post('/admin/maintenance-records', [
            'asset_id' => $asset->id,
            'jenis_penyelenggaraan' => 'Pembaikan',
            'tarikh_penyelenggaraan' => now()->format('Y-m-d'),
            'kos_penyelenggaraan' => 100,
            'penyedia_perkhidmatan' => 'Integration Test Provider',
            'catatan_penyelenggaraan' => 'Regular maintenance',
            'tarikh_penyelenggaraan_akan_datang' => now()->addDays(90)->format('Y-m-d'),
            'butiran_kerja' => 'Regular maintenance work',
            'pegawai_bertanggungjawab' => 'Integration Test Officer',
            'status_penyelenggaraan' => 'Selesai'
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('maintenance_records', [
            'asset_id' => $asset->id,
            'status_penyelenggaraan' => 'Selesai'
        ]);

        // 4. Create asset movement request
        $response = $this->actingAs($this->admin)->post('/admin/asset-movements', [
            'asset_id' => $asset->id,
            'jenis_pergerakan' => 'Pemindahan',
            'masjid_surau_asal_id' => $this->sourceMasjid->id,
            'masjid_surau_destinasi_id' => $this->destinationMasjid->id,
            'lokasi_asal' => 'Integration Test Location',
            'lokasi_terperinci_asal' => 'Original Location',
            'lokasi_destinasi' => 'New Location',
            'lokasi_terperinci_destinasi' => 'New Location Details',
            'tarikh_permohonan' => now()->format('Y-m-d'),
            'tarikh_pergerakan' => now()->addDays(1)->format('Y-m-d'),
            'nama_peminjam_pegawai_bertanggungjawab' => 'Integration Test Officer',
            'sebab_pergerakan' => 'Integration testing'
        ]);

        $response->assertStatus(302);
        $movement = AssetMovement::latest()->first();
        $this->assertNotNull($movement);

        // 5. Approve movement from source
        $response = $this->actingAs($this->admin)
            ->patch("/admin/asset-movements/{$movement->id}/approve", [
                'type' => 'asal',
                'status' => 'diluluskan',
                'catatan' => 'Approved from source'
            ]);

        $response->assertStatus(302);

        // 6. Approve movement from destination
        $response = $this->actingAs($this->admin)
            ->patch("/admin/asset-movements/{$movement->id}/approve", [
                'type' => 'destinasi',
                'status' => 'diluluskan',
                'catatan' => 'Approved from destination'
            ]);

        $response->assertStatus(302);

        // 7. Record asset return
        $response = $this->actingAs($this->admin)
            ->patch("/admin/asset-movements/{$movement->id}/return", [
                'tarikh_pulang_sebenar' => now()->addDays(7)->format('Y-m-d'),
                'catatan_pergerakan' => 'Asset returned in good condition'
            ]);

        $response->assertStatus(302);
        $this->assertDatabaseHas('asset_movements', [
            'id' => $movement->id,
            'status_pergerakan' => 'selesai'
        ]);

        // 8. Verify final asset location
        $asset->refresh();
        $this->assertEquals($this->sourceMasjid->id, $asset->masjid_surau_id);
    }

    #[Test]
    public function asset_maintenance_workflow()
    {
        // Create test asset with registration number
        $registrationNumber = AssetRegistrationNumber::generate(
            $this->sourceMasjid->id,
            'Elektronik',
            now()->format('y')
        );

        $asset = Asset::create([
            'masjid_surau_id' => $this->sourceMasjid->id,
            'no_siri_pendaftaran' => $registrationNumber,
            'nama_aset' => 'Maintenance Test Asset',
            'jenis_aset' => 'Elektronik',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'susut_nilai_tahunan' => 100,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
            'status_aset' => 'Aktif'
        ]);

        // 1. Regular inspection identifies issues
        $response = $this->actingAs($this->admin)->post('/admin/inspections', [
            'asset_id' => $asset->id,
            'tarikh_pemeriksaan' => now()->format('Y-m-d'),
            'kondisi_aset' => 'Memerlukan Pembaikan',
            'nama_pemeriksa' => 'Integration Test Inspector',
            'catatan_pemeriksaan' => 'Issues found during inspection',
            'tindakan_diperlukan' => 'Maintenance required',
            'tarikh_pemeriksaan_akan_datang' => now()->addDays(30)->format('Y-m-d')
        ]);

        $response->assertStatus(302);
        $inspection = Inspection::latest()->first();
        $this->assertEquals('Memerlukan Pembaikan', $inspection->kondisi_aset);

        // 2. Create maintenance record based on inspection
        $response = $this->actingAs($this->admin)->post('/admin/maintenance-records', [
            'asset_id' => $asset->id,
            'jenis_penyelenggaraan' => 'Pembaikan',
            'tarikh_penyelenggaraan' => now()->format('Y-m-d'),
            'kos_penyelenggaraan' => 200,
            'penyedia_perkhidmatan' => 'Integration Test Provider',
            'catatan_penyelenggaraan' => 'Repairs based on inspection',
            'tarikh_penyelenggaraan_akan_datang' => now()->addDays(90)->format('Y-m-d'),
            'butiran_kerja' => 'Repair work based on inspection findings',
            'pegawai_bertanggungjawab' => 'Integration Test Officer',
            'status_penyelenggaraan' => 'Dalam Proses'
        ]);

        $response->assertStatus(302);
        $maintenance = MaintenanceRecord::latest()->first();
        $this->assertEquals('Dalam Proses', $maintenance->status_penyelenggaraan);

        // 3. Update maintenance status to complete
        $response = $this->actingAs($this->admin)
            ->patch("/admin/maintenance-records/{$maintenance->id}", [
                'asset_id' => $asset->id,
                'jenis_penyelenggaraan' => 'Pembaikan',
                'tarikh_penyelenggaraan' => now()->format('Y-m-d'),
                'kos_penyelenggaraan' => 200,
                'penyedia_perkhidmatan' => 'Integration Test Provider',
                'catatan_penyelenggaraan' => 'Repairs completed successfully',
                'tarikh_penyelenggaraan_akan_datang' => now()->addDays(90)->format('Y-m-d'),
                'status_penyelenggaraan' => 'Selesai'
            ]);

        $response->assertStatus(302);
        $maintenance->refresh();
        $this->assertEquals('Selesai', $maintenance->status_penyelenggaraan);

        // 4. Follow-up inspection after maintenance
        $response = $this->actingAs($this->admin)->post('/admin/inspections', [
            'asset_id' => $asset->id,
            'tarikh_pemeriksaan' => now()->addDays(1)->format('Y-m-d'),
            'kondisi_aset' => 'Memerlukan Pembaikan',
            'nama_pemeriksa' => 'Integration Test Inspector',
            'catatan_pemeriksaan' => 'Post-maintenance inspection',
            'tindakan_diperlukan' => 'Further maintenance required',
            'tarikh_pemeriksaan_akan_datang' => now()->addDays(90)->format('Y-m-d')
        ]);

        $response->assertStatus(302);
        $followUpInspection = Inspection::latest()->first();
        $this->assertEquals('Memerlukan Pembaikan', $followUpInspection->kondisi_aset);
    }
} 