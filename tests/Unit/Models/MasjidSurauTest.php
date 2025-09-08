<?php

namespace Tests\Unit\Models;

use App\Models\MasjidSurau;
use App\Models\User;
use App\Models\Asset;
use App\Models\ImmovableAsset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MasjidSurauTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_correct_table_name()
    {
        $masjidSurau = new MasjidSurau();
        $this->assertEquals('masjid_surau', $masjidSurau->getTable());
    }

    /** @test */
    public function it_uses_integer_key_type()
    {
        $masjidSurau = new MasjidSurau();
        $this->assertEquals('int', $masjidSurau->getKeyType());
    }

    /** @test */
    public function it_does_auto_increment()
    {
        $masjidSurau = new MasjidSurau();
        $this->assertTrue($masjidSurau->getIncrementing());
    }

    /** @test */
    public function it_has_fillable_attributes()
    {
        $masjidSurau = new MasjidSurau();
        
        $fillable = [
            'id',
            'nama',
            'singkatan_nama',
            'jenis',
            'kategori',
            'alamat_baris_1',
            'alamat_baris_2',
            'alamat_baris_3',
            'poskod',
            'bandar',
            'negeri',
            'negara',
            'daerah',
            'no_telefon',
            'email',
            'imam_ketua',
            'bilangan_jemaah',
            'tahun_dibina',
            'status',
            'catatan',
            'nama_rasmi',
            'kawasan',
            'pautan_peta',
        ];

        $this->assertEquals($fillable, $masjidSurau->getFillable());
    }

    /** @test */
    public function it_casts_attributes_correctly()
    {
        $masjidSurau = new MasjidSurau();
        
        $expectedCasts = [
            'tahun_dibina' => 'integer',
            'bilangan_jemaah' => 'integer',
            'deleted_at' => 'datetime',
            'id' => 'int',
        ];

        $this->assertEquals($expectedCasts, $masjidSurau->getCasts());
    }

    /** @test */
    public function it_has_many_users()
    {
        $masjidSurau = new MasjidSurau();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $masjidSurau->users()
        );
    }

    /** @test */
    public function it_has_many_assets()
    {
        $masjidSurau = new MasjidSurau();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $masjidSurau->assets()
        );
    }

    /** @test */
    public function it_has_many_immovable_assets()
    {
        $masjidSurau = new MasjidSurau();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\HasMany::class,
            $masjidSurau->immovableAssets()
        );
    }

    /** @test */
    public function it_uses_auditable_trait()
    {
        $masjidSurau = new MasjidSurau();
        $this->assertContains('App\Traits\Auditable', class_uses_recursive($masjidSurau));
    }

    /** @test */
    public function it_uses_soft_deletes()
    {
        $masjidSurau = new MasjidSurau();
        $this->assertContains('Illuminate\Database\Eloquent\SoftDeletes', class_uses_recursive($masjidSurau));
    }

    /** @test */
    public function it_can_be_soft_deleted_and_restored()
    {
        $masjidSurau = MasjidSurau::create([
            'nama' => 'Test Masjid',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);
        
        $this->assertDatabaseHas('masjid_surau', ['id' => $masjidSurau->id]);
        
        $masjidSurau->delete();
        $this->assertSoftDeleted('masjid_surau', ['id' => $masjidSurau->id]);
        
        $masjidSurau->restore();
        $this->assertDatabaseHas('masjid_surau', ['id' => $masjidSurau->id, 'deleted_at' => null]);
    }

    /** @test */
    public function it_can_create_masjid_surau_with_valid_attributes()
    {
        $masjidData = [
            'nama' => 'Masjid Test',
            'jenis' => 'Masjid',
            'kategori' => 'Daerah',
            'alamat_baris_1' => 'Jalan Test 123',
            'poskod' => '12345',
            'bandar' => 'Test City',
            'negeri' => 'Test State',
            'negara' => 'Malaysia',
            'status' => 'Aktif',
        ];
        
        $masjidSurau = MasjidSurau::create($masjidData);
        
        $this->assertDatabaseHas('masjid_surau', [
            'id' => $masjidSurau->id,
            'nama' => 'Masjid Test',
            'jenis' => 'Masjid',
            'kategori' => 'Daerah',
        ]);
    }
} 