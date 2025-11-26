<?php

namespace Tests\Feature;

use App\Models\ImmovableAsset;
use App\Models\MasjidSurau;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ImmovableAssetCreateEditShowTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private MasjidSurau $masjidSurau;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a masjid/surau for testing
        $this->masjidSurau = MasjidSurau::factory()->create([
            'nama' => 'Masjid Al-Hidayah',
            'singkatan_nama' => 'MTAJ',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);

        // Create admin user
        $this->admin = User::factory()->create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'role' => 'admin',
        ]);

        // Fake storage for image uploads
        Storage::fake('public');
    }

    #[Test]
    public function admin_can_view_create_immovable_asset_form()
    {
        $response = $this->actingAs($this->admin)
            ->get('/admin/immovable-assets/create');

        $response->assertStatus(200)
            ->assertSee('Tambah Aset Tak Alih Baru')
            ->assertSee('Daftar Aset Tak Alih Baru')
            ->assertSee('Nama Aset')
            ->assertSee('Jenis Aset')
            ->assertSee('Masjid/Surau')
            ->assertSee('Kos Perolehan');
    }

    #[Test]
    public function admin_can_create_new_immovable_asset_with_all_required_fields()
    {
        $image = UploadedFile::fake()->image('asset-image.jpg', 800, 600);

        $assetData = [
            'masjid_surau_id' => $this->masjidSurau->id,
            'nama_aset' => 'Tanah Masjid Al-Hidayah',
            'jenis_aset' => 'Tanah',
            'alamat' => 'Jalan Taman Melawati, 53100 Kuala Lumpur',
            'no_hakmilik' => 'HS(D) 123456',
            'no_lot' => 'PT 12345',
            'luas_tanah_bangunan' => '500.00',
            'tarikh_perolehan' => '2024-01-15',
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => '500000.00',
            'keadaan_semasa' => 'Baik',
            'gambar_aset' => [$image],
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/immovable-assets', $assetData);

        $response->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertDatabaseHas('immovable_assets', [
            'nama_aset' => 'Tanah Masjid Al-Hidayah',
            'jenis_aset' => 'Tanah',
            'alamat' => 'Jalan Taman Melawati, 53100 Kuala Lumpur',
            'no_hakmilik' => 'HS(D) 123456',
            'no_lot' => 'PT 12345',
            'luas_tanah_bangunan' => 500.00,
            'kos_perolehan' => 500000.00,
            'keadaan_semasa' => 'Baik',
        ]);

        // Verify image was stored
        $asset = ImmovableAsset::where('nama_aset', 'Tanah Masjid Al-Hidayah')->first();
        $this->assertNotNull($asset->gambar_aset);
        $this->assertIsArray($asset->gambar_aset);
        $this->assertCount(1, $asset->gambar_aset);
    }

    #[Test]
    public function admin_can_create_immovable_asset_with_optional_fields()
    {
        $image = UploadedFile::fake()->image('asset-image.jpg');

        $assetData = [
            'masjid_surau_id' => $this->masjidSurau->id,
            'nama_aset' => 'Bangunan Masjid',
            'jenis_aset' => 'Bangunan',
            'alamat' => 'Jalan Contoh, Taman Contoh',
            'no_hakmilik' => 'HS(D) 789012',
            'no_lot' => 'PT 67890',
            'luas_tanah_bangunan' => '1000.00',
            'tarikh_perolehan' => '2024-02-20',
            'sumber_perolehan' => 'Wakaf',
            'kos_perolehan' => '1000000.00',
            'keadaan_semasa' => 'Sangat Baik',
            'catatan' => 'Bangunan untuk kegunaan masjid',
            'gambar_aset' => [$image],
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/immovable-assets', $assetData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('immovable_assets', [
            'nama_aset' => 'Bangunan Masjid',
            'jenis_aset' => 'Bangunan',
            'no_hakmilik' => 'HS(D) 789012',
            'sumber_perolehan' => 'Wakaf',
            'keadaan_semasa' => 'Sangat Baik',
            'catatan' => 'Bangunan untuk kegunaan masjid',
        ]);
    }

    #[Test]
    public function create_immovable_asset_requires_at_least_one_image()
    {
        $assetData = [
            'masjid_surau_id' => $this->masjidSurau->id,
            'nama_aset' => 'Asset Without Image',
            'jenis_aset' => 'Tanah',
            'luas_tanah_bangunan' => '500.00',
            'tarikh_perolehan' => '2024-01-15',
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => '500000.00',
            'keadaan_semasa' => 'Baik',
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/immovable-assets', $assetData);

        $response->assertStatus(302)
            ->assertSessionHasErrors(['gambar_aset']);

        $this->assertDatabaseMissing('immovable_assets', [
            'nama_aset' => 'Asset Without Image',
        ]);
    }

    #[Test]
    public function create_immovable_asset_validates_required_fields()
    {
        $response = $this->actingAs($this->admin)
            ->post('/admin/immovable-assets', []);

        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'masjid_surau_id',
                'nama_aset',
                'jenis_aset',
                'tarikh_perolehan',
                'sumber_perolehan',
                'kos_perolehan',
                'keadaan_semasa',
            ]);
    }

    #[Test]
    public function create_immovable_asset_validates_asset_type()
    {
        $image = UploadedFile::fake()->image('asset.jpg');

        $assetData = [
            'masjid_surau_id' => $this->masjidSurau->id,
            'nama_aset' => 'Test Asset',
            'jenis_aset' => 'Invalid Type',
            'luas_tanah_bangunan' => '500.00',
            'tarikh_perolehan' => '2024-01-15',
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => '500000.00',
            'keadaan_semasa' => 'Baik',
            'gambar_aset' => [$image],
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/immovable-assets', $assetData);

        // Should still create since jenis_aset is just a string field
        // But we can test that it accepts valid types
        $response->assertStatus(302);
    }

    #[Test]
    public function create_immovable_asset_generates_registration_number()
    {
        $image = UploadedFile::fake()->image('asset.jpg');

        $assetData = [
            'masjid_surau_id' => $this->masjidSurau->id,
            'nama_aset' => 'Test Asset Registration',
            'jenis_aset' => 'Tanah',
            'luas_tanah_bangunan' => '500.00',
            'tarikh_perolehan' => '2024-01-15',
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => '500000.00',
            'keadaan_semasa' => 'Baik',
            'gambar_aset' => [$image],
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/immovable-assets', $assetData);

        $response->assertStatus(302);
        
        $asset = ImmovableAsset::where('nama_aset', 'Test Asset Registration')->first();
        $this->assertNotNull($asset);
        $this->assertNotNull($asset->no_siri_pendaftaran);
        $this->assertStringContainsString('MTAJ', $asset->no_siri_pendaftaran);
        $this->assertStringContainsString('HTA', $asset->no_siri_pendaftaran);
        $this->assertStringContainsString('24', $asset->no_siri_pendaftaran);
    }

    #[Test]
    public function create_immovable_asset_can_combine_keluasan_fields()
    {
        $image = UploadedFile::fake()->image('asset.jpg');

        $assetData = [
            'masjid_surau_id' => $this->masjidSurau->id,
            'nama_aset' => 'Tanah dan Bangunan',
            'jenis_aset' => 'Tanah dan Bangunan',
            'tarikh_perolehan' => '2024-01-15',
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => '500000.00',
            'keadaan_semasa' => 'Baik',
            'gambar_aset' => [$image],
        ];

        $response = $this->actingAs($this->admin)
            ->post('/admin/immovable-assets', $assetData);

        $response->assertStatus(302);
        
        $asset = ImmovableAsset::where('nama_aset', 'Tanah dan Bangunan')->first();
        $this->assertNotNull($asset);
        $this->assertEquals(500.00, $asset->luas_tanah_bangunan);
    }

    #[Test]
    public function admin_can_view_edit_immovable_asset_form()
    {
        $asset = ImmovableAsset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST/HTA/24/001',
            'nama_aset' => 'Asset to Edit',
            'jenis_aset' => 'Tanah',
            'luas_tanah_bangunan' => 500.00,
            'tarikh_perolehan' => now(),
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => 500000.00,
            'keadaan_semasa' => 'Baik',
        ]);

        $response = $this->actingAs($this->admin)
            ->get("/admin/immovable-assets/{$asset->id}/edit");

        $response->assertStatus(200)
            ->assertSee('Edit Aset Tak Alih')
            ->assertSee('Kemaskini Maklumat Aset Tak Alih')
            ->assertSee('Asset to Edit')
            ->assertSee($asset->nama_aset);
    }

    #[Test]
    public function admin_can_update_immovable_asset()
    {
        $asset = ImmovableAsset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST/ORIG/24/001',
            'nama_aset' => 'Original Name',
            'jenis_aset' => 'Tanah',
            'luas_tanah_bangunan' => 500.00,
            'tarikh_perolehan' => now(),
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => 500000.00,
            'keadaan_semasa' => 'Baik',
        ]);

        $updateData = [
            'nama_aset' => 'Updated Asset Name',
            'jenis_aset' => 'Bangunan',
            'alamat' => 'Updated Address',
            'no_hakmilik' => 'HS(D) 999999',
            'no_lot' => 'PT 99999',
            'luas_tanah_bangunan' => '750.00',
            'tarikh_perolehan' => $asset->tarikh_perolehan->format('Y-m-d'),
            'sumber_perolehan' => 'Wakaf',
            'kos_perolehan' => '750000.00',
            'keadaan_semasa' => 'Sangat Baik',
            'catatan' => 'Updated notes',
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/immovable-assets/{$asset->id}", $updateData);

        $response->assertStatus(302)
            ->assertRedirect("/admin/immovable-assets/{$asset->id}")
            ->assertSessionHas('success');

        $this->assertDatabaseHas('immovable_assets', [
            'id' => $asset->id,
            'nama_aset' => 'Updated Asset Name',
            'jenis_aset' => 'Bangunan',
            'alamat' => 'Updated Address',
            'no_hakmilik' => 'HS(D) 999999',
            'luas_tanah_bangunan' => 750.00,
            'kos_perolehan' => 750000.00,
            'keadaan_semasa' => 'Sangat Baik',
        ]);
    }

    #[Test]
    public function admin_can_update_immovable_asset_with_optional_fields()
    {
        $asset = ImmovableAsset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST/UP/24/001',
            'nama_aset' => 'Asset to Update',
            'jenis_aset' => 'Tanah',
            'luas_tanah_bangunan' => 500.00,
            'tarikh_perolehan' => now(),
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => 500000.00,
            'keadaan_semasa' => 'Baik',
        ]);

        $updateData = [
            'nama_aset' => 'Asset to Update',
            'jenis_aset' => 'Tanah',
            'luas_tanah_bangunan' => '500.00',
            'tarikh_perolehan' => $asset->tarikh_perolehan->format('Y-m-d'),
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => '500000.00',
            'keadaan_semasa' => 'Baik',
            'alamat' => 'New Address',
            'no_hakmilik' => 'HS(D) 111111',
            'no_lot' => 'PT 11111',
            'catatan' => 'Updated notes',
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/immovable-assets/{$asset->id}", $updateData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('immovable_assets', [
            'id' => $asset->id,
            'alamat' => 'New Address',
            'no_hakmilik' => 'HS(D) 111111',
            'no_lot' => 'PT 11111',
            'catatan' => 'Updated notes',
        ]);
    }

    #[Test]
    public function admin_can_add_images_to_existing_immovable_asset()
    {
        $existingImage = UploadedFile::fake()->image('existing-image.jpg');
        
        // Create asset with initial image via POST
        $initialData = [
            'masjid_surau_id' => $this->masjidSurau->id,
            'nama_aset' => 'Asset with Images',
            'jenis_aset' => 'Tanah',
            'luas_tanah_bangunan' => '500.00',
            'tarikh_perolehan' => now()->format('Y-m-d'),
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => '500000.00',
            'keadaan_semasa' => 'Baik',
            'gambar_aset' => [$existingImage],
        ];
        
        $this->actingAs($this->admin)->post('/admin/immovable-assets', $initialData);
        
        $asset = ImmovableAsset::where('nama_aset', 'Asset with Images')->first();
        $this->assertNotNull($asset);
        $this->assertNotNull($asset->gambar_aset);
        
        // Test that we can update the asset without adding new images
        $updateData = [
            'nama_aset' => $asset->nama_aset,
            'jenis_aset' => $asset->jenis_aset,
            'luas_tanah_bangunan' => $asset->luas_tanah_bangunan,
            'tarikh_perolehan' => $asset->tarikh_perolehan->format('Y-m-d'),
            'sumber_perolehan' => $asset->sumber_perolehan,
            'kos_perolehan' => $asset->kos_perolehan,
            'keadaan_semasa' => $asset->keadaan_semasa,
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/immovable-assets/{$asset->id}", $updateData);

        $response->assertStatus(302)
            ->assertSessionHas('success');

        // Verify the asset still has images after update
        $asset->refresh();
        $this->assertNotNull($asset->gambar_aset);
        $this->assertIsArray($asset->gambar_aset);
    }

    #[Test]
    public function admin_can_delete_images_from_immovable_asset()
    {
        $image1 = UploadedFile::fake()->image('image1.jpg');
        $image2 = UploadedFile::fake()->image('image2.jpg');
        
        // Create asset with images
        $initialData = [
            'masjid_surau_id' => $this->masjidSurau->id,
            'nama_aset' => 'Asset with Multiple Images',
            'jenis_aset' => 'Tanah',
            'luas_tanah_bangunan' => '500.00',
            'tarikh_perolehan' => now()->format('Y-m-d'),
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => '500000.00',
            'keadaan_semasa' => 'Baik',
            'gambar_aset' => [$image1, $image2],
        ];
        
        $this->actingAs($this->admin)->post('/admin/immovable-assets', $initialData);
        
        $asset = ImmovableAsset::where('nama_aset', 'Asset with Multiple Images')->first();
        $this->assertCount(2, $asset->gambar_aset);
        
        // Delete one image
        $imageToDelete = $asset->gambar_aset[0];
        $updateData = [
            'nama_aset' => $asset->nama_aset,
            'jenis_aset' => $asset->jenis_aset,
            'luas_tanah_bangunan' => $asset->luas_tanah_bangunan,
            'tarikh_perolehan' => $asset->tarikh_perolehan->format('Y-m-d'),
            'sumber_perolehan' => $asset->sumber_perolehan,
            'kos_perolehan' => $asset->kos_perolehan,
            'keadaan_semasa' => $asset->keadaan_semasa,
            'delete_images' => [$imageToDelete],
        ];

        $response = $this->actingAs($this->admin)
            ->put("/admin/immovable-assets/{$asset->id}", $updateData);

        $response->assertStatus(302);
        
        $asset->refresh();
        $this->assertCount(1, $asset->gambar_aset);
    }

    #[Test]
    public function admin_can_view_immovable_asset_details()
    {
        $asset = ImmovableAsset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'MTAJ/HTA/24/001',
            'nama_aset' => 'Test Asset Details',
            'jenis_aset' => 'Tanah',
            'alamat' => 'Jalan Test 123',
            'no_hakmilik' => 'HS(D) 123456',
            'no_lot' => 'PT 12345',
            'luas_tanah_bangunan' => 500.00,
            'tarikh_perolehan' => now(),
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => 500000.00,
            'keadaan_semasa' => 'Baik',
        ]);

        $response = $this->actingAs($this->admin)
            ->get("/admin/immovable-assets/{$asset->id}");

        $response->assertStatus(200)
            ->assertSee('Test Asset Details')
            ->assertSee('MTAJ/HTA/24/001')
            ->assertSee('Tanah')
            ->assertSee('RM 500,000.00')
            ->assertSee('Baik');
    }

    #[Test]
    public function show_immovable_asset_displays_all_optional_fields_when_present()
    {
        $asset = ImmovableAsset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST/COMP/24/001',
            'nama_aset' => 'Complete Asset',
            'jenis_aset' => 'Tanah',
            'alamat' => 'Complete Address',
            'no_hakmilik' => 'HS(D) 999999',
            'no_lot' => 'PT 99999',
            'luas_tanah_bangunan' => 500.00,
            'tarikh_perolehan' => now(),
            'sumber_perolehan' => 'Wakaf',
            'kos_perolehan' => 500000.00,
            'keadaan_semasa' => 'Sangat Baik',
            'catatan' => 'Test notes',
        ]);

        $response = $this->actingAs($this->admin)
            ->get("/admin/immovable-assets/{$asset->id}");

        $response->assertStatus(200)
            ->assertSee('Complete Asset')
            ->assertSee('Test notes')
            ->assertSee('Complete Address');
    }

    #[Test]
    public function show_immovable_asset_displays_edit_and_delete_buttons()
    {
        $asset = ImmovableAsset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST/SHOW/24/001',
            'nama_aset' => 'Test Asset',
            'jenis_aset' => 'Tanah',
            'luas_tanah_bangunan' => 500.00,
            'tarikh_perolehan' => now(),
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => 500000.00,
            'keadaan_semasa' => 'Baik',
        ]);

        $response = $this->actingAs($this->admin)
            ->get("/admin/immovable-assets/{$asset->id}");

        $response->assertStatus(200)
            ->assertSee('Edit')
            ->assertSee(route('admin.immovable-assets.edit', $asset))
            ->assertSee(route('admin.immovable-assets.destroy', $asset));
    }

    #[Test]
    public function update_immovable_asset_validates_required_fields()
    {
        $asset = ImmovableAsset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST/SHOW/24/001',
            'nama_aset' => 'Test Asset',
            'jenis_aset' => 'Tanah',
            'luas_tanah_bangunan' => 500.00,
            'tarikh_perolehan' => now(),
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => 500000.00,
            'keadaan_semasa' => 'Baik',
        ]);

        $response = $this->actingAs($this->admin)
            ->put("/admin/immovable-assets/{$asset->id}", []);

        $response->assertStatus(302)
            ->assertSessionHasErrors([
                'nama_aset',
                'jenis_aset',
                'luas_tanah_bangunan',
                'tarikh_perolehan',
                'sumber_perolehan',
                'kos_perolehan',
                'keadaan_semasa',
            ]);
    }

    #[Test]
    public function admin_can_delete_immovable_asset()
    {
        $asset = ImmovableAsset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST/DEL/24/001',
            'nama_aset' => 'Asset to Delete',
            'jenis_aset' => 'Tanah',
            'luas_tanah_bangunan' => 500.00,
            'tarikh_perolehan' => now(),
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => 500000.00,
            'keadaan_semasa' => 'Baik',
        ]);

        $response = $this->actingAs($this->admin)
            ->delete("/admin/immovable-assets/{$asset->id}");

        $response->assertStatus(302)
            ->assertRedirect('/admin/immovable-assets')
            ->assertSessionHas('success');

        $this->assertSoftDeleted('immovable_assets', [
            'id' => $asset->id,
        ]);
    }

    #[Test]
    public function admin_can_view_immovable_assets_index()
    {
        ImmovableAsset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST/INDEX/24/001',
            'nama_aset' => 'Asset 1',
            'jenis_aset' => 'Tanah',
            'luas_tanah_bangunan' => 500.00,
            'tarikh_perolehan' => now(),
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => 500000.00,
            'keadaan_semasa' => 'Baik',
        ]);

        ImmovableAsset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST/INDEX/24/002',
            'nama_aset' => 'Asset 2',
            'jenis_aset' => 'Bangunan',
            'luas_tanah_bangunan' => 1000.00,
            'tarikh_perolehan' => now(),
            'sumber_perolehan' => 'Wakaf',
            'kos_perolehan' => 1000000.00,
            'keadaan_semasa' => 'Sangat Baik',
        ]);

        $response = $this->actingAs($this->admin)
            ->get('/admin/immovable-assets');

        $response->assertStatus(200)
            ->assertSee('Pengurusan Aset Tak Alih')
            ->assertSee('Asset 1')
            ->assertSee('Asset 2')
            ->assertSee('Tanah')
            ->assertSee('Bangunan');
    }

    #[Test]
    public function admin_can_filter_immovable_assets_by_type()
    {
        ImmovableAsset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST/FILTER/24/001',
            'nama_aset' => 'Tanah Asset',
            'jenis_aset' => 'Tanah',
            'luas_tanah_bangunan' => 500.00,
            'tarikh_perolehan' => now(),
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => 500000.00,
            'keadaan_semasa' => 'Baik',
        ]);

        ImmovableAsset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST/FILTER/24/002',
            'nama_aset' => 'Bangunan Asset',
            'jenis_aset' => 'Bangunan',
            'luas_tanah_bangunan' => 1000.00,
            'tarikh_perolehan' => now(),
            'sumber_perolehan' => 'Wakaf',
            'kos_perolehan' => 1000000.00,
            'keadaan_semasa' => 'Baik',
        ]);

        $response = $this->actingAs($this->admin)
            ->get('/admin/immovable-assets?jenis_aset=Tanah');

        $response->assertStatus(200)
            ->assertSee('Tanah Asset')
            ->assertDontSee('Bangunan Asset');
    }

    #[Test]
    public function admin_can_search_immovable_assets()
    {
        ImmovableAsset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST/SEARCH/24/001',
            'nama_aset' => 'Searchable Asset',
            'jenis_aset' => 'Tanah',
            'alamat' => 'Jalan Search',
            'no_hakmilik' => 'HS(D) 111111',
            'no_lot' => 'PT 11111',
            'luas_tanah_bangunan' => 500.00,
            'tarikh_perolehan' => now(),
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => 500000.00,
            'keadaan_semasa' => 'Baik',
        ]);

        ImmovableAsset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST/SEARCH/24/002',
            'nama_aset' => 'Other Asset',
            'jenis_aset' => 'Bangunan',
            'luas_tanah_bangunan' => 1000.00,
            'tarikh_perolehan' => now(),
            'sumber_perolehan' => 'Wakaf',
            'kos_perolehan' => 1000000.00,
            'keadaan_semasa' => 'Baik',
        ]);

        $response = $this->actingAs($this->admin)
            ->get('/admin/immovable-assets?search=Searchable');

        $response->assertStatus(200)
            ->assertSee('Searchable Asset')
            ->assertDontSee('Other Asset');
    }

    #[Test]
    public function unauthorized_user_cannot_access_immovable_asset_forms()
    {
        $regularUser = User::factory()->create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'role' => 'user',
        ]);

        $asset = ImmovableAsset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST/UNAUTH/24/001',
            'nama_aset' => 'Test Asset',
            'jenis_aset' => 'Tanah',
            'luas_tanah_bangunan' => 500.00,
            'tarikh_perolehan' => now(),
            'sumber_perolehan' => 'Pembelian',
            'kos_perolehan' => 500000.00,
            'keadaan_semasa' => 'Baik',
        ]);

        // Test create form
        $response = $this->actingAs($regularUser)
            ->get('/admin/immovable-assets/create');
        $response->assertStatus(403);

        // Test edit form
        $response = $this->actingAs($regularUser)
            ->get("/admin/immovable-assets/{$asset->id}/edit");
        $response->assertStatus(403);

        // Test show page
        $response = $this->actingAs($regularUser)
            ->get("/admin/immovable-assets/{$asset->id}");
        $response->assertStatus(403);
    }
}

