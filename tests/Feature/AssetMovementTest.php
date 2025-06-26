<?php

namespace Tests\Feature;

use App\Models\Asset;
use App\Models\AssetMovement;
use App\Models\MasjidSurau;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AssetMovementTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private MasjidSurau $masjidSurauAsal;
    private MasjidSurau $masjidSurauDestinasi;
    private Asset $asset;

    protected function setUp(): void
    {
        parent::setUp();

        $this->masjidSurauAsal = MasjidSurau::create([
            'nama' => 'Test Masjid Asal',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);

        $this->masjidSurauDestinasi = MasjidSurau::create([
            'nama' => 'Test Masjid Destinasi',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);

        $this->admin = User::factory()->create([
            'masjid_surau_id' => $this->masjidSurauAsal->id,
            'role' => 'admin',
        ]);

        $this->asset = Asset::create([
            'masjid_surau_id' => $this->masjidSurauAsal->id,
            'no_siri_pendaftaran' => 'TEST-001',
            'nama_aset' => 'Test Asset',
            'jenis_aset' => 'Elektronik',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'susut_nilai_tahunan' => 100,
            'lokasi_penempatan' => 'Original Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
            'status_aset' => 'Aktif',
        ]);
    }

    #[Test]
    public function admin_can_view_asset_movements()
    {
        $movement = AssetMovement::create([
            'asset_id' => $this->asset->id,
            'jenis_pergerakan' => 'Pemindahan',
            'masjid_surau_asal_id' => $this->masjidSurauAsal->id,
            'masjid_surau_destinasi_id' => $this->masjidSurauDestinasi->id,
            'lokasi_asal' => 'Original Location',
            'lokasi_terperinci_asal' => 'Original Location',
            'lokasi_destinasi' => 'New Location',
            'lokasi_terperinci_destinasi' => 'New Location',
            'tarikh_permohonan' => now(),
            'tarikh_pergerakan' => now(),
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Borrower',
            'sebab_pergerakan' => 'Testing purposes',
            'status_pergerakan' => 'menunggu_kelulusan',
            'status_kelulusan_asal' => 'menunggu',
            'status_kelulusan_destinasi' => 'menunggu',
        ]);

        $response = $this->actingAs($this->admin)
            ->get('/admin/asset-movements');

        $response->assertStatus(200)
            ->assertSee('Test Asset')
            ->assertSee('Pemindahan')
            ->assertSee('New Location');
    }

    #[Test]
    public function admin_can_create_asset_movement()
    {
        $movementData = [
            'asset_id' => $this->asset->id,
            'jenis_pergerakan' => 'Pemindahan',
            'masjid_surau_asal_id' => $this->masjidSurauAsal->id,
            'masjid_surau_destinasi_id' => $this->masjidSurauDestinasi->id,
            'lokasi_asal' => 'Original Location',
            'lokasi_terperinci_asal' => 'Original Location',
            'lokasi_destinasi' => 'New Location',
            'lokasi_terperinci_destinasi' => 'New Location',
            'tarikh_permohonan' => now()->format('Y-m-d'),
            'tarikh_pergerakan' => now()->format('Y-m-d'),
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Borrower',
            'sebab_pergerakan' => 'Testing purposes',
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/asset-movements', $movementData);

        $movement = AssetMovement::first();

        $response->assertStatus(302)
            ->assertRedirect("/admin/asset-movements/{$movement->id}");

        $this->assertDatabaseHas('asset_movements', [
            'asset_id' => $this->asset->id,
            'jenis_pergerakan' => 'Pemindahan',
            'status_pergerakan' => 'menunggu_kelulusan',
        ]);
    }

    #[Test]
    public function admin_can_view_movement_details()
    {
        $movement = AssetMovement::create([
            'asset_id' => $this->asset->id,
            'jenis_pergerakan' => 'Pemindahan',
            'masjid_surau_asal_id' => $this->masjidSurauAsal->id,
            'masjid_surau_destinasi_id' => $this->masjidSurauDestinasi->id,
            'lokasi_asal' => 'Original Location',
            'lokasi_terperinci_asal' => 'Original Location',
            'lokasi_destinasi' => 'New Location',
            'lokasi_terperinci_destinasi' => 'New Location',
            'tarikh_permohonan' => now(),
            'tarikh_pergerakan' => now(),
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Borrower',
            'sebab_pergerakan' => 'Testing purposes',
            'status_pergerakan' => 'menunggu_kelulusan',
            'status_kelulusan_asal' => 'menunggu',
            'status_kelulusan_destinasi' => 'menunggu',
        ]);

        $response = $this->actingAs($this->admin)
            ->get("/admin/asset-movements/{$movement->id}");

        $response->assertStatus(200)
            ->assertSee('Test Asset')
            ->assertSee('Pemindahan')
            ->assertSee('New Location')
            ->assertSee('Test Borrower');
    }

    #[Test]
    public function admin_can_update_movement_status()
    {
        $movement = AssetMovement::create([
            'asset_id' => $this->asset->id,
            'jenis_pergerakan' => 'Pemindahan',
            'masjid_surau_asal_id' => $this->masjidSurauAsal->id,
            'masjid_surau_destinasi_id' => $this->masjidSurauDestinasi->id,
            'lokasi_asal' => 'Original Location',
            'lokasi_terperinci_asal' => 'Original Location',
            'lokasi_destinasi' => 'New Location',
            'lokasi_terperinci_destinasi' => 'New Location',
            'tarikh_permohonan' => now(),
            'tarikh_pergerakan' => now(),
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Borrower',
            'sebab_pergerakan' => 'Testing purposes',
            'status_pergerakan' => 'menunggu_kelulusan',
            'status_kelulusan_asal' => 'menunggu',
            'status_kelulusan_destinasi' => 'menunggu',
        ]);

        $updateData = [
            'asset_id' => $this->asset->id,
            'jenis_pergerakan' => 'Pemindahan',
            'masjid_surau_asal_id' => $this->masjidSurauAsal->id,
            'masjid_surau_destinasi_id' => $this->masjidSurauDestinasi->id,
            'lokasi_asal' => 'Original Location',
            'lokasi_terperinci_asal' => 'Original Location',
            'lokasi_destinasi' => 'New Location',
            'lokasi_terperinci_destinasi' => 'New Location',
            'tarikh_permohonan' => now()->format('Y-m-d'),
            'tarikh_pergerakan' => now()->format('Y-m-d'),
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Borrower',
            'sebab_pergerakan' => 'Testing purposes updated',
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/asset-movements/{$movement->id}", $updateData);

        $response->assertStatus(302)
            ->assertRedirect("/admin/asset-movements/{$movement->id}");

        $this->assertDatabaseHas('asset_movements', [
            'id' => $movement->id,
            'sebab_pergerakan' => 'Testing purposes updated',
        ]);
    }

    #[Test]
    public function regular_user_cannot_create_movement()
    {
        $regularUser = User::factory()->create([
            'masjid_surau_id' => $this->masjidSurauAsal->id,
            'role' => 'user',
        ]);

        $movementData = [
            'asset_id' => $this->asset->id,
            'jenis_pergerakan' => 'Pemindahan',
            'masjid_surau_asal_id' => $this->masjidSurauAsal->id,
            'masjid_surau_destinasi_id' => $this->masjidSurauDestinasi->id,
            'lokasi_asal' => 'Original Location',
            'lokasi_terperinci_asal' => 'Original Location',
            'lokasi_destinasi' => 'New Location',
            'lokasi_terperinci_destinasi' => 'New Location',
            'tarikh_permohonan' => now()->format('Y-m-d'),
            'tarikh_pergerakan' => now()->format('Y-m-d'),
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Borrower',
            'sebab_pergerakan' => 'Testing purposes',
        ];

        $response = $this->actingAs($regularUser)
            ->post('/admin/asset-movements', $movementData);

        $response->assertStatus(403);

        $this->assertDatabaseMissing('asset_movements', [
            'asset_id' => $this->asset->id,
            'jenis_pergerakan' => 'Pemindahan',
        ]);
    }

    #[Test]
    public function admin_can_approve_movement_from_source()
    {
        $movement = AssetMovement::create([
            'asset_id' => $this->asset->id,
            'jenis_pergerakan' => 'Pemindahan',
            'masjid_surau_asal_id' => $this->masjidSurauAsal->id,
            'masjid_surau_destinasi_id' => $this->masjidSurauDestinasi->id,
            'lokasi_asal' => 'Original Location',
            'lokasi_terperinci_asal' => 'Original Location',
            'lokasi_destinasi' => 'New Location',
            'lokasi_terperinci_destinasi' => 'New Location',
            'tarikh_permohonan' => now(),
            'tarikh_pergerakan' => now(),
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Borrower',
            'sebab_pergerakan' => 'Testing purposes',
            'status_pergerakan' => 'menunggu_kelulusan',
            'status_kelulusan_asal' => 'menunggu',
            'status_kelulusan_destinasi' => 'menunggu',
        ]);

        $response = $this->actingAs($this->admin)
            ->patch("/admin/asset-movements/{$movement->id}/approve", [
                'type' => 'asal',
                'status' => 'diluluskan',
                'catatan' => 'Approved from source'
            ]);

        $response->assertStatus(302)
            ->assertRedirect("/admin/asset-movements/{$movement->id}");

        $this->assertDatabaseHas('asset_movements', [
            'id' => $movement->id,
            'status_kelulusan_asal' => 'diluluskan',
            'diluluskan_oleh_asal' => $this->admin->id,
        ]);
    }

    #[Test]
    public function admin_can_reject_movement()
    {
        $movement = AssetMovement::create([
            'asset_id' => $this->asset->id,
            'jenis_pergerakan' => 'Pemindahan',
            'masjid_surau_asal_id' => $this->masjidSurauAsal->id,
            'masjid_surau_destinasi_id' => $this->masjidSurauDestinasi->id,
            'lokasi_asal' => 'Original Location',
            'lokasi_terperinci_asal' => 'Original Location',
            'lokasi_destinasi' => 'New Location',
            'lokasi_terperinci_destinasi' => 'New Location',
            'tarikh_permohonan' => now(),
            'tarikh_pergerakan' => now(),
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Borrower',
            'sebab_pergerakan' => 'Testing purposes',
            'status_pergerakan' => 'menunggu_kelulusan',
            'status_kelulusan_asal' => 'menunggu',
            'status_kelulusan_destinasi' => 'menunggu',
        ]);

        $response = $this->actingAs($this->admin)
            ->patch("/admin/asset-movements/{$movement->id}/reject", [
                'approval_type' => 'asal',
                'sebab_penolakan' => 'Asset not available'
            ]);

        $response->assertStatus(302)
            ->assertRedirect("/admin/asset-movements/{$movement->id}");

        $this->assertDatabaseHas('asset_movements', [
            'id' => $movement->id,
            'status_pergerakan' => 'ditolak',
            'status_kelulusan_asal' => 'ditolak',
            'sebab_penolakan' => 'Asset not available'
        ]);
    }

    #[Test]
    public function movement_requires_valid_dates()
    {
        $invalidData = [
            'asset_id' => $this->asset->id,
            'jenis_pergerakan' => 'Pemindahan',
            'masjid_surau_asal_id' => $this->masjidSurauAsal->id,
            'masjid_surau_destinasi_id' => $this->masjidSurauDestinasi->id,
            'lokasi_asal' => 'Original Location',
            'lokasi_terperinci_asal' => 'Original Location',
            'lokasi_destinasi' => 'New Location',
            'lokasi_terperinci_destinasi' => 'New Location',
            'tarikh_permohonan' => now()->addDays(1), // Invalid: Application date in future
            'tarikh_pergerakan' => now(), // Invalid: Movement date before application
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Borrower',
            'sebab_pergerakan' => 'Testing purposes'
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/asset-movements', $invalidData);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['tarikh_pergerakan']);
    }

    #[Test]
    public function admin_can_record_asset_return()
    {
        $movement = AssetMovement::create([
            'asset_id' => $this->asset->id,
            'jenis_pergerakan' => 'Peminjaman',
            'masjid_surau_asal_id' => $this->masjidSurauAsal->id,
            'masjid_surau_destinasi_id' => $this->masjidSurauDestinasi->id,
            'lokasi_asal' => 'Original Location',
            'lokasi_terperinci_asal' => 'Original Location',
            'lokasi_destinasi' => 'New Location',
            'lokasi_terperinci_destinasi' => 'New Location',
            'tarikh_permohonan' => now()->subDays(5),
            'tarikh_pergerakan' => now()->subDays(4),
            'tarikh_jangka_pulangan' => now()->addDays(1),
            'nama_peminjam_pegawai_bertanggungjawab' => 'Test Borrower',
            'sebab_pergerakan' => 'Testing purposes',
            'status_pergerakan' => 'diluluskan',
            'status_kelulusan_asal' => 'diluluskan',
            'status_kelulusan_destinasi' => 'diluluskan',
        ]);

        $response = $this->actingAs($this->admin)
            ->patch("/admin/asset-movements/{$movement->id}/return", [
                'tarikh_pulang_sebenar' => now()->format('Y-m-d H:i:s'),
                'catatan_pergerakan' => 'Returned in good condition'
            ]);

        $response->assertStatus(302)
            ->assertRedirect("/admin/asset-movements/{$movement->id}");

        $this->assertDatabaseHas('asset_movements', [
            'id' => $movement->id,
            'status_pergerakan' => 'selesai',
            'tarikh_pulang_sebenar' => now()->format('Y-m-d H:i:s'),
            'catatan_pergerakan' => 'Returned in good condition'
        ]);
    }
} 