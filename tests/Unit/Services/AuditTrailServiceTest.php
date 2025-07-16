<?php

namespace Tests\Unit\Services;

use App\Models\Asset;
use App\Models\AuditTrail;
use App\Models\MasjidSurau;
use App\Models\User;
use App\Services\AuditTrailService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuditTrailServiceTest extends TestCase
{
    use RefreshDatabase;

    protected MasjidSurau $masjidSurau;
    protected Asset $asset;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create test data
        $this->masjidSurau = MasjidSurau::create([
            'nama' => 'Test Masjid',
            'jenis' => 'Masjid',
            'status' => 'Aktif',
        ]);

        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'masjid_surau_id' => $this->masjidSurau->id,
            'role' => 'admin',
        ]);

        $this->asset = Asset::create([
            'masjid_surau_id' => $this->masjidSurau->id,
            'no_siri_pendaftaran' => 'TEST-001',
            'nama_aset' => 'Test Asset',
            'jenis_aset' => 'Elektronik',
            'tarikh_perolehan' => now(),
            'kaedah_perolehan' => 'Pembelian',
            'nilai_perolehan' => 1000,
            'lokasi_penempatan' => 'Test Location',
            'pegawai_bertanggungjawab_lokasi' => 'Test Officer',
        ]);

        // Authenticate the user for testing
        Auth::login($this->user);
    }

    /** @test */
    public function it_can_log_model_creation()
    {
        // Clear existing audit trails from setup
        AuditTrail::query()->delete();
        
        $auditTrail = AuditTrailService::logCreate($this->asset);
        
        $this->assertInstanceOf(AuditTrail::class, $auditTrail);
        $this->assertEquals('CREATE', $auditTrail->action);
        $this->assertEquals(Asset::class, $auditTrail->model_type);
        $this->assertEquals($this->asset->id, $auditTrail->model_id);
        $this->assertEquals($this->user->id, $auditTrail->user_id);
        $this->assertNotNull($auditTrail->new_values);
    }

    /** @test */
    public function it_can_log_model_update()
    {
        // Clear existing audit trails from setup
        AuditTrail::query()->delete();
        
        $oldValues = ['nama_aset' => 'Test Asset'];
        $this->asset->nama_aset = 'Updated Asset Name';
        
        $auditTrail = AuditTrailService::logUpdate($this->asset, $oldValues);
        
        $this->assertInstanceOf(AuditTrail::class, $auditTrail);
        $this->assertEquals('UPDATE', $auditTrail->action);
        $this->assertEquals(Asset::class, $auditTrail->model_type);
        $this->assertEquals($this->asset->id, $auditTrail->model_id);
        $this->assertEquals($this->user->id, $auditTrail->user_id);
        $this->assertEquals($oldValues, $auditTrail->old_values);
        $this->assertArrayHasKey('nama_aset', $auditTrail->new_values);
        $this->assertEquals('Updated Asset Name', $auditTrail->new_values['nama_aset']);
    }

    /** @test */
    public function it_can_log_model_deletion()
    {
        // Clear existing audit trails from setup
        AuditTrail::query()->delete();
        
        $auditTrail = AuditTrailService::logDelete($this->asset);
        
        $this->assertInstanceOf(AuditTrail::class, $auditTrail);
        $this->assertEquals('DELETE', $auditTrail->action);
        $this->assertEquals(Asset::class, $auditTrail->model_type);
        $this->assertEquals($this->asset->id, $auditTrail->model_id);
        $this->assertEquals($this->user->id, $auditTrail->user_id);
        $this->assertNotNull($auditTrail->old_values);
    }

    /** @test */
    public function it_can_log_model_view()
    {
        // Clear existing audit trails from setup
        AuditTrail::query()->delete();
        
        $auditTrail = AuditTrailService::logView($this->asset);
        
        $this->assertInstanceOf(AuditTrail::class, $auditTrail);
        $this->assertEquals('VIEW', $auditTrail->action);
        $this->assertEquals(Asset::class, $auditTrail->model_type);
        $this->assertEquals($this->asset->id, $auditTrail->model_id);
        $this->assertEquals($this->user->id, $auditTrail->user_id);
    }

    /** @test */
    public function it_can_log_user_login()
    {
        // Clear existing audit trails from setup
        AuditTrail::query()->delete();
        
        $auditTrail = AuditTrailService::logLogin($this->user);
        
        $this->assertInstanceOf(AuditTrail::class, $auditTrail);
        $this->assertEquals('LOGIN', $auditTrail->action);
        $this->assertEquals($this->user->id, $auditTrail->user_id);
        $this->assertEquals('success', $auditTrail->status);
    }

    /** @test */
    public function it_can_log_user_logout()
    {
        // Clear existing audit trails from setup
        AuditTrail::query()->delete();
        
        $auditTrail = AuditTrailService::logLogout($this->user);
        
        $this->assertInstanceOf(AuditTrail::class, $auditTrail);
        $this->assertEquals('LOGOUT', $auditTrail->action);
        $this->assertEquals($this->user->id, $auditTrail->user_id);
    }

    /** @test */
    public function it_can_log_export_action()
    {
        // Clear existing audit trails from setup
        AuditTrail::query()->delete();
        
        $filters = ['status' => 'active', 'location' => 'Test Location'];
        $auditTrail = AuditTrailService::logExport('assets', $filters);
        
        $this->assertInstanceOf(AuditTrail::class, $auditTrail);
        $this->assertEquals('EXPORT', $auditTrail->action);
        $this->assertEquals($this->user->id, $auditTrail->user_id);
        $this->assertArrayHasKey('export_type', $auditTrail->additional_data);
        $this->assertArrayHasKey('filters', $auditTrail->additional_data);
        $this->assertEquals('assets', $auditTrail->additional_data['export_type']);
        $this->assertEquals($filters, $auditTrail->additional_data['filters']);
    }

    /** @test */
    public function it_can_log_import_action()
    {
        // Clear existing audit trails from setup
        AuditTrail::query()->delete();
        
        $auditTrail = AuditTrailService::logImport('assets', 10);
        
        $this->assertInstanceOf(AuditTrail::class, $auditTrail);
        $this->assertEquals('IMPORT', $auditTrail->action);
        $this->assertEquals($this->user->id, $auditTrail->user_id);
        $this->assertArrayHasKey('import_type', $auditTrail->additional_data);
        $this->assertArrayHasKey('record_count', $auditTrail->additional_data);
        $this->assertEquals('assets', $auditTrail->additional_data['import_type']);
        $this->assertEquals(10, $auditTrail->additional_data['record_count']);
    }

    /** @test */
    public function it_can_log_approval_action()
    {
        // Clear existing audit trails from setup
        AuditTrail::query()->delete();
        
        $auditTrail = AuditTrailService::logApproval($this->asset, true, 'Approved by test');
        
        $this->assertInstanceOf(AuditTrail::class, $auditTrail);
        $this->assertEquals('APPROVE', $auditTrail->action);
        $this->assertEquals(Asset::class, $auditTrail->model_type);
        $this->assertEquals($this->asset->id, $auditTrail->model_id);
        $this->assertEquals($this->user->id, $auditTrail->user_id);
        $this->assertArrayHasKey('approved', $auditTrail->additional_data);
        $this->assertArrayHasKey('reason', $auditTrail->additional_data);
        $this->assertTrue($auditTrail->additional_data['approved']);
    }

    /** @test */
    public function it_can_log_rejection_action()
    {
        // Clear existing audit trails from setup
        AuditTrail::query()->delete();
        
        $auditTrail = AuditTrailService::logApproval($this->asset, false, 'Rejected by test');
        
        $this->assertInstanceOf(AuditTrail::class, $auditTrail);
        $this->assertEquals('REJECT', $auditTrail->action);
        $this->assertEquals(Asset::class, $auditTrail->model_type);
        $this->assertEquals($this->asset->id, $auditTrail->model_id);
        $this->assertEquals($this->user->id, $auditTrail->user_id);
        $this->assertArrayHasKey('approved', $auditTrail->additional_data);
        $this->assertArrayHasKey('reason', $auditTrail->additional_data);
        $this->assertFalse($auditTrail->additional_data['approved']);
    }

    /** @test */
    public function it_can_log_status_change()
    {
        // Clear existing audit trails from setup
        AuditTrail::query()->delete();
        
        $auditTrail = AuditTrailService::logStatusChange($this->asset, 'active', 'inactive');
        
        $this->assertInstanceOf(AuditTrail::class, $auditTrail);
        $this->assertEquals('DEACTIVATE', $auditTrail->action);
        $this->assertEquals(Asset::class, $auditTrail->model_type);
        $this->assertEquals($this->asset->id, $auditTrail->model_id);
        $this->assertEquals($this->user->id, $auditTrail->user_id);
        $this->assertArrayHasKey('old_status', $auditTrail->additional_data);
        $this->assertArrayHasKey('new_status', $auditTrail->additional_data);
        $this->assertEquals('active', $auditTrail->additional_data['old_status']);
        $this->assertEquals('inactive', $auditTrail->additional_data['new_status']);
    }

    /** @test */
    public function it_can_log_custom_action()
    {
        // Clear existing audit trails from setup
        AuditTrail::query()->delete();
        
        $additionalData = ['key' => 'value'];
        $auditTrail = AuditTrailService::logCustom('custom_action', 'Custom description', $this->asset, $additionalData);
        
        $this->assertInstanceOf(AuditTrail::class, $auditTrail);
        $this->assertEquals('CUSTOM_ACTION', $auditTrail->action);
        $this->assertEquals(Asset::class, $auditTrail->model_type);
        $this->assertEquals($this->asset->id, $auditTrail->model_id);
        $this->assertEquals($this->user->id, $auditTrail->user_id);
        $this->assertEquals('Custom description', $auditTrail->description);
        $this->assertEquals($additionalData, $auditTrail->additional_data);
    }

    /** @test */
    public function it_can_log_failure()
    {
        // Clear existing audit trails from setup
        AuditTrail::query()->delete();
        
        $auditTrail = AuditTrailService::logFailure('update', 'Failed to update asset', $this->asset);
        
        $this->assertInstanceOf(AuditTrail::class, $auditTrail);
        $this->assertEquals('UPDATE', $auditTrail->action);
        $this->assertEquals(Asset::class, $auditTrail->model_type);
        $this->assertEquals($this->asset->id, $auditTrail->model_id);
        $this->assertEquals($this->user->id, $auditTrail->user_id);
        $this->assertEquals('failed', $auditTrail->status);
        $this->assertEquals('Failed to update asset', $auditTrail->error_message);
    }

    /** @test */
    public function it_can_get_model_name()
    {
        $reflectionMethod = new \ReflectionMethod(AuditTrailService::class, 'getModelName');
        $reflectionMethod->setAccessible(true);
        
        $modelName = $reflectionMethod->invoke(null, $this->asset);
        
        $this->assertStringContainsString('Test Asset', $modelName);
    }

    /** @test */
    public function it_can_cleanup_old_audit_trails()
    {
        // Create old audit trails
        $oldDate = now()->subDays(100);
        
        AuditTrail::create([
            'user_id' => $this->user->id,
            'action' => 'TEST',
            'created_at' => $oldDate,
        ]);
        
        // Create recent audit trail
        AuditTrail::create([
            'user_id' => $this->user->id,
            'action' => 'TEST',
            'created_at' => now(),
        ]);
        
        $deletedCount = AuditTrailService::cleanup(30);
        
        $this->assertEquals(1, $deletedCount);
        $this->assertEquals(1, AuditTrail::count());
    }

    /** @test */
    public function it_can_get_recent_activities()
    {
        // Clear existing audit trails from setup
        AuditTrail::query()->delete();
        
        // Create multiple audit trails
        for ($i = 1; $i <= 5; $i++) {
            AuditTrail::create([
                'user_id' => $this->user->id,
                'action' => "TEST{$i}",
                'created_at' => now()->subDays(6 - $i),
            ]);
        }
        
        $recentActivities = AuditTrailService::getRecentActivities($this->user->id, 3);
        
        $this->assertCount(3, $recentActivities);
        $this->assertEquals('TEST5', $recentActivities->first()->action);
    }

    /** @test */
    public function it_can_get_system_stats()
    {
        // Clear existing audit trails from setup
        AuditTrail::query()->delete();
        
        // Create audit trails with different actions
        AuditTrail::create([
            'user_id' => $this->user->id,
            'action' => 'CREATE',
        ]);
        
        AuditTrail::create([
            'user_id' => $this->user->id,
            'action' => 'UPDATE',
        ]);
        
        AuditTrail::create([
            'user_id' => $this->user->id,
            'action' => 'LOGIN',
        ]);
        
        $stats = AuditTrailService::getSystemStats();
        
        $this->assertArrayHasKey('total_activities', $stats);
        $this->assertArrayHasKey('activities_by_type', $stats);
        $this->assertArrayHasKey('recent_logins', $stats);
        $this->assertEquals(3, $stats['total_activities']);
    }
} 