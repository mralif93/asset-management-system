<?php

namespace Tests\Unit\Models;

use App\Models\MaintenanceRecord;
use App\Models\Asset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceRecordTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        $maintenanceRecord = new MaintenanceRecord();
        
        $fillable = [
            'asset_id',
            'user_id',
            'tarikh_penyelenggaraan',
            'jenis_penyelenggaraan',
            'butiran_kerja',
            'nama_syarikat_kontraktor',
            'penyedia_perkhidmatan',
            'kos_penyelenggaraan',
            'status_penyelenggaraan',
            'pegawai_bertanggungjawab',
            'catatan',
            'catatan_penyelenggaraan',
            'tarikh_penyelenggaraan_akan_datang',
            'gambar_penyelenggaraan',
        ];

        $this->assertEquals($fillable, $maintenanceRecord->getFillable());
    }

    /** @test */
    public function it_casts_attributes_correctly()
    {
        $maintenanceRecord = new MaintenanceRecord();
        
        $expectedCasts = [
            'tarikh_penyelenggaraan' => 'date',
            'tarikh_penyelenggaraan_akan_datang' => 'date',
            'kos_penyelenggaraan' => 'decimal:2',
            'gambar_penyelenggaraan' => 'array',
            'id' => 'int',
        ];

        $this->assertEquals($expectedCasts, $maintenanceRecord->getCasts());
    }

    /** @test */
    public function it_belongs_to_asset()
    {
        $maintenanceRecord = new MaintenanceRecord();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $maintenanceRecord->asset()
        );
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $maintenanceRecord = new MaintenanceRecord();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $maintenanceRecord->user()
        );
    }

    /** @test */
    public function it_can_scope_by_status()
    {
        $maintenanceRecord = new MaintenanceRecord();
        $query = $maintenanceRecord->newQuery();
        
        $result = $maintenanceRecord->scopeByStatus($query, 'selesai');
        
        $this->assertStringContainsString(
            'where "status_penyelenggaraan" = ?',
            $result->toSql()
        );
    }

    /** @test */
    public function it_can_scope_by_maintenance_type()
    {
        $maintenanceRecord = new MaintenanceRecord();
        $query = $maintenanceRecord->newQuery();
        
        $result = $maintenanceRecord->scopeByType($query, 'pencegahan');
        
        $this->assertStringContainsString(
            'where "jenis_penyelenggaraan" = ?',
            $result->toSql()
        );
    }

    /** @test */
    public function it_can_scope_by_date_range()
    {
        $maintenanceRecord = new MaintenanceRecord();
        $query = $maintenanceRecord->newQuery();
        
        $startDate = now()->subDays(7);
        $endDate = now();
        
        $result = $maintenanceRecord->scopeMaintenanceDateRange($query, $startDate, $endDate);
        
        $this->assertStringContainsString(
            'where "tarikh_penyelenggaraan" between ? and ?',
            $result->toSql()
        );
    }

    /** @test */
    public function it_can_scope_upcoming_maintenance()
    {
        $maintenanceRecord = new MaintenanceRecord();
        $query = $maintenanceRecord->newQuery();
        
        $result = $maintenanceRecord->scopeUpcoming($query);
        
        $this->assertStringContainsString(
            'where "tarikh_penyelenggaraan_akan_datang" > ?',
            $result->toSql()
        );
    }

    /** @test */
    public function it_can_scope_overdue_maintenance()
    {
        $maintenanceRecord = new MaintenanceRecord();
        $query = $maintenanceRecord->newQuery();
        
        $result = $maintenanceRecord->scopeOverdue($query);
        
        $this->assertStringContainsString(
            'where "tarikh_penyelenggaraan_akan_datang" < ?',
            $result->toSql()
        );
    }

    /** @test */
    public function it_formats_status_correctly()
    {
        $maintenanceRecord = new MaintenanceRecord();
        
        $maintenanceRecord->status_penyelenggaraan = 'belum_mula';
        $this->assertEquals('Belum Mula', $maintenanceRecord->getFormattedStatusAttribute());
        
        $maintenanceRecord->status_penyelenggaraan = 'dalam_proses';
        $this->assertEquals('Dalam Proses', $maintenanceRecord->getFormattedStatusAttribute());
        
        $maintenanceRecord->status_penyelenggaraan = 'selesai';
        $this->assertEquals('Selesai', $maintenanceRecord->getFormattedStatusAttribute());
    }

    /** @test */
    public function it_formats_maintenance_type_correctly()
    {
        $maintenanceRecord = new MaintenanceRecord();
        
        $maintenanceRecord->jenis_penyelenggaraan = 'pencegahan';
        $this->assertEquals('Pencegahan', $maintenanceRecord->getFormattedTypeAttribute());
        
        $maintenanceRecord->jenis_penyelenggaraan = 'pembaikan';
        $this->assertEquals('Pembaikan', $maintenanceRecord->getFormattedTypeAttribute());
    }

    /** @test */
    public function it_determines_if_maintenance_is_completed()
    {
        $maintenanceRecord = new MaintenanceRecord();
        
        $maintenanceRecord->status_penyelenggaraan = 'selesai';
        $this->assertTrue($maintenanceRecord->isCompleted());
        
        $maintenanceRecord->status_penyelenggaraan = 'dalam_proses';
        $this->assertFalse($maintenanceRecord->isCompleted());
    }

    /** @test */
    public function it_determines_if_maintenance_is_overdue()
    {
        $maintenanceRecord = new MaintenanceRecord();
        
        $maintenanceRecord->tarikh_penyelenggaraan_akan_datang = now()->subDay();
        $this->assertTrue($maintenanceRecord->isOverdue());
        
        $maintenanceRecord->tarikh_penyelenggaraan_akan_datang = now()->addDay();
        $this->assertFalse($maintenanceRecord->isOverdue());
    }

    /** @test */
    public function it_calculates_days_until_next_maintenance()
    {
        $maintenanceRecord = new MaintenanceRecord();
        
        $maintenanceRecord->tarikh_penyelenggaraan_akan_datang = now()->startOfDay()->addDays(5);
        $this->assertEquals(5, $maintenanceRecord->daysUntilNextMaintenance());
        
        $maintenanceRecord->tarikh_penyelenggaraan_akan_datang = now()->startOfDay()->subDays(5);
        $this->assertEquals(-5, $maintenanceRecord->daysUntilNextMaintenance());
    }

    /** @test */
    public function it_determines_maintenance_status_color()
    {
        $maintenanceRecord = new MaintenanceRecord();
        
        $maintenanceRecord->status_penyelenggaraan = 'selesai';
        $this->assertEquals('green', $maintenanceRecord->getStatusColorAttribute());
        
        $maintenanceRecord->status_penyelenggaraan = 'dalam_proses';
        $this->assertEquals('yellow', $maintenanceRecord->getStatusColorAttribute());
        
        $maintenanceRecord->status_penyelenggaraan = 'belum_mula';
        $this->assertEquals('gray', $maintenanceRecord->getStatusColorAttribute());
    }
} 