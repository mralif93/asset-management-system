<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\AssetMovement;
use App\Models\MasjidSurau;
use App\Models\User;
use App\Models\Inspection;
use App\Models\MaintenanceRecord;
use App\Helpers\AssetRegistrationNumber;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SmokeTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $user;
    private MasjidSurau $masjidSurau;
    private Asset $asset;

    protected function setUp(): void
    {
        parent::setUp();

        // Create basic test data
        $this->masjidSurau = MasjidSurau::create([
            'nama' => 'Masjid Test',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
            'singkatan_nama' => 'MT',
        ]);

        $this->admin = User::factory()->create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'role' => 'admin'
        ]);

        $this->user = User::factory()->create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'role' => 'user'
        ]);

        $this->asset = Asset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => AssetRegistrationNumber::generate($this->masjidSurau->id, 'Elektronik'),
            'nama_aset' => 'Smoke Test Asset',
            'jenis_aset' => 'Elektronik',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'susut_nilai_tahunan' => 100,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
            'status_aset' => 'Aktif',
        ]);
    }

    #[Test]
    public function smoke_test_critical_paths()
    {
        // 1. Authentication
        $response = $this->post('/login', [
            'email' => $this->admin->email,
            'password' => 'password'
        ]);
        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticated();

        // 2. Admin Dashboard Access
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200);

        // 3. Asset Management
        // 3.1 Create Asset
        $response = $this->actingAs($this->admin)->post('/admin/assets', [
            'masjid_surau_id' => $this->masjidSurau->id,
            'nama_aset' => 'New Smoke Test Asset',
            'jenis_aset' => 'Elektronik',
            'tarikh_perolehan' => now()->format('Y-m-d'),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 2000,
            'susut_nilai_tahunan' => 200,
            'lokasi_penempatan' => 'Smoke Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Smoke Test Officer',
            'status_aset' => 'Aktif',
        ]);
        $response->assertStatus(302);

        // Get the created asset
        $newAsset = Asset::latest()->first();
        $this->assertNotNull($newAsset);
        $this->assertStringStartsWith('MT/E/' . now()->format('y'), $newAsset->no_siri_pendaftaran);

        // 3.2 View Asset List
        $response = $this->actingAs($this->admin)->get('/admin/assets');
        $response->assertStatus(200)
            ->assertSee($this->asset->no_siri_pendaftaran)
            ->assertSee($newAsset->no_siri_pendaftaran);

        // 4. Asset Movement Workflow
        // 4.1 Create Movement Request
        $destinationMasjid = MasjidSurau::create([
            'nama' => 'Masjid Destination',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
            'singkatan_nama' => 'MD',
        ]);

        $response = $this->actingAs($this->admin)->post('/admin/asset-movements', [
            'asset_id' => $this->asset->id,
            'jenis_pergerakan' => 'Pemindahan',
            'masjid_surau_asal_id' => $this->masjidSurau->id,
            'masjid_surau_destinasi_id' => $destinationMasjid->id,
            'lokasi_asal' => 'Test Location',
            'lokasi_terperinci_asal' => 'Test Location Detail',
            'lokasi_destinasi' => 'New Location',
            'lokasi_terperinci_destinasi' => 'New Location Detail',
            'tarikh_permohonan' => now()->format('Y-m-d'),
            'tarikh_pergerakan' => now()->format('Y-m-d'),
            'nama_peminjam_pegawai_bertanggungjawab' => 'Smoke Test Officer',
            'sebab_pergerakan' => 'Smoke Testing',
        ]);
        $response->assertStatus(302);

        $movement = AssetMovement::latest()->first();

        // 4.2 Approve Movement
        $response = $this->actingAs($this->admin)
            ->patch("/admin/asset-movements/{$movement->id}/approve", [
                'type' => 'asal',
                'status' => 'diluluskan',
                'catatan' => 'Approved in smoke test'
            ]);
        $response->assertStatus(302);

        // 5. Asset Inspection
        $response = $this->actingAs($this->admin)->post('/admin/inspections', [
            'asset_id' => $this->asset->id,
            'tarikh_pemeriksaan' => now()->format('Y-m-d'),
            'kondisi_aset' => 'Baik',
            'nama_pemeriksa' => 'Smoke Test Inspector',
            'catatan_pemeriksaan' => 'Smoke test inspection',
            'tindakan_diperlukan' => 'None',
            'tarikh_pemeriksaan_akan_datang' => now()->addDays(90)->format('Y-m-d'),
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('inspections', [
            'asset_id' => $this->asset->id,
            'kondisi_aset' => 'Baik',
            'nama_pemeriksa' => 'Smoke Test Inspector'
        ]);

        // 6. Maintenance Record
        $response = $this->actingAs($this->admin)->post('/admin/maintenance-records', [
            'asset_id' => $this->asset->id,
            'jenis_penyelenggaraan' => 'Pembaikan',
            'tarikh_penyelenggaraan' => now()->format('Y-m-d'),
            'kos_penyelenggaraan' => 100,
            'penyedia_perkhidmatan' => 'Smoke Test Contractor',
            'catatan_penyelenggaraan' => 'Smoke test maintenance',
            'tarikh_penyelenggaraan_akan_datang' => now()->addDays(90)->format('Y-m-d'),
            'butiran_kerja' => 'Pembaikan dan penyelenggaraan untuk smoke test',
            'pegawai_bertanggungjawab' => 'Smoke Test Officer',
            'status_penyelenggaraan' => 'Dalam Proses',
        ]);
        $response->assertStatus(302);
        $this->assertDatabaseHas('maintenance_records', [
            'asset_id' => $this->asset->id,
            'jenis_penyelenggaraan' => 'Pembaikan',
            'penyedia_perkhidmatan' => 'Smoke Test Contractor',
            'butiran_kerja' => 'Pembaikan dan penyelenggaraan untuk smoke test',
        ]);

        // 7. Regular User Access Control
        $response = $this->actingAs($this->user)->get('/admin/assets');
        $response->assertStatus(403);

        // 8. Logout
        $response = $this->post('/logout');
        $response->assertStatus(302);
        $this->assertGuest();
    }
} 