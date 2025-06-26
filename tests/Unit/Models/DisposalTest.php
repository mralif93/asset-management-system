<?php

namespace Tests\Unit\Models;

use App\Models\Disposal;
use App\Models\Asset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DisposalTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        $disposal = new Disposal();
        
        $fillable = [
            'asset_id',
            'user_id',
            'tarikh_pelupusan',
            'sebab_pelupusan',
            'kaedah_pelupusan',
            'nilai_pelupusan',
            'nilai_baki',
            'catatan',
            'status_kelulusan',
            'tarikh_kelulusan',
            'diluluskan_oleh',
            'sebab_penolakan',
            'gambar_pelupusan',
            // Legacy fields for backward compatibility
            'tarikh_permohonan',
            'justifikasi_pelupusan',
            'kaedah_pelupusan_dicadang',
            'nombor_mesyuarat_jawatankuasa',
            'tarikh_kelulusan_pelupusan',
            'status_pelupusan',
            'pegawai_pemohon',
            'catatan_pelupusan',
        ];

        $this->assertEquals($fillable, $disposal->getFillable());
    }

    /** @test */
    public function it_casts_attributes_correctly()
    {
        $disposal = new Disposal();
        
        $expectedCasts = [
            'tarikh_permohonan' => 'date',
            'tarikh_kelulusan_pelupusan' => 'date',
            'tarikh_pelupusan' => 'date',
            'tarikh_kelulusan' => 'date',
            'nilai_pelupusan' => 'decimal:2',
            'nilai_baki' => 'decimal:2',
            'gambar_pelupusan' => 'array',
            'id' => 'int',
        ];

        $this->assertEquals($expectedCasts, $disposal->getCasts());
    }

    /** @test */
    public function it_belongs_to_asset()
    {
        $disposal = new Disposal();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $disposal->asset()
        );
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $disposal = new Disposal();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $disposal->user()
        );
    }

    /** @test */
    public function it_belongs_to_approver()
    {
        $disposal = new Disposal();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $disposal->approver()
        );
    }
} 