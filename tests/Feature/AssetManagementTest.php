<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\MasjidSurau;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AssetManagementTest extends TestCase
{
    use RefreshDatabase;

    private User $user;
    private MasjidSurau $masjidSurau;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a masjid/surau and user for testing
        $this->masjidSurau = MasjidSurau::create([
            'nama' => 'Test Masjid',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);

        $this->user = User::factory()->create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'role' => 'admin',
        ]);
    }

    #[Test]
    public function user_can_view_assets_list()
    {
        // Create some test assets
        Asset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST-001',
            'nama_aset' => 'Test Asset 1',
            'jenis_aset' => 'Elektronik',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'susut_nilai_tahunan' => 100,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
            'status_aset' => 'Aktif',
        ]);

        Asset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST-002',
            'nama_aset' => 'Test Asset 2',
            'jenis_aset' => 'Perabot',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 2000,
            'susut_nilai_tahunan' => 200,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
            'status_aset' => 'Aktif',
        ]);

        $response = $this->actingAs($this->user)
            ->get('/admin/assets');

        $response->assertStatus(200)
            ->assertSee('Test Asset 1')
            ->assertSee('Test Asset 2');
    }

    #[Test]
    public function user_can_create_new_asset()
    {
        $assetData = [
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST-003',
            'nama_aset' => 'New Test Asset',
            'jenis_aset' => 'Elektronik',
            'tarikh_perolehan' => now()->format('Y-m-d'),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1500,
            'susut_nilai_tahunan' => 150,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
            'status_aset' => 'Aktif',
        ];

        $response = $this->actingAs($this->user)
            ->post('/admin/assets', $assetData);

        $asset = Asset::where('nama_aset', 'New Test Asset')->first();

        $response->assertStatus(302)
            ->assertRedirect("/admin/assets/{$asset->id}");

        $this->assertDatabaseHas('assets', [
            'nama_aset' => 'New Test Asset',
        ]);
    }

    #[Test]
    public function user_can_view_asset_details()
    {
        $asset = Asset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST-004',
            'nama_aset' => 'Test Asset Details',
            'jenis_aset' => 'Elektronik',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'susut_nilai_tahunan' => 100,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
            'status_aset' => 'Aktif',
        ]);

        $response = $this->actingAs($this->user)
            ->get("/admin/assets/{$asset->id}");

        $response->assertStatus(200)
            ->assertSee('Test Asset Details')
            ->assertSee('TEST-004');
    }

    #[Test]
    public function user_can_update_asset()
    {
        $asset = Asset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST-005',
            'nama_aset' => 'Test Asset Update',
            'jenis_aset' => 'Elektronik',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'susut_nilai_tahunan' => 100,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
            'status_aset' => 'Aktif',
        ]);

        $updateData = [
            'nama_aset' => 'Updated Asset Name',
            'jenis_aset' => 'Elektronik',
            'tarikh_perolehan' => now()->format('Y-m-d'),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'susut_nilai_tahunan' => 100,
            'lokasi_penempatan' => 'New Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
            'status_aset' => 'Aktif',
        ];

        $response = $this->actingAs($this->user)
            ->put("/admin/assets/{$asset->id}", $updateData);

        $response->assertStatus(302)
            ->assertRedirect("/admin/assets/{$asset->id}");

        $this->assertDatabaseHas('assets', [
            'id' => $asset->id,
            'nama_aset' => 'Updated Asset Name',
            'lokasi_penempatan' => 'New Location',
        ]);
    }

    #[Test]
    public function user_can_delete_asset()
    {
        $asset = Asset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST-006',
            'nama_aset' => 'Test Asset Delete',
            'jenis_aset' => 'Elektronik',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'susut_nilai_tahunan' => 100,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
            'status_aset' => 'Aktif',
        ]);

        $response = $this->actingAs($this->user)
            ->delete("/admin/assets/{$asset->id}");

        $response->assertStatus(302)
            ->assertRedirect('/admin/assets');

        $this->assertDatabaseMissing('assets', [
            'id' => $asset->id,
        ]);
    }

    #[Test]
    public function unauthorized_user_cannot_manage_assets()
    {
        $regularUser = User::factory()->create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'role' => 'user',
        ]);

        $assetData = [
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST-007',
            'nama_aset' => 'Unauthorized Test',
            'jenis_aset' => 'Elektronik',
            'tarikh_perolehan' => now()->format('Y-m-d'),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'susut_nilai_tahunan' => 100,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
            'status_aset' => 'Aktif',
        ];

        $response = $this->actingAs($regularUser)
            ->post('/admin/assets', $assetData);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('assets', [
            'no_siri_pendaftaran' => 'TEST-007',
        ]);
    }
} 