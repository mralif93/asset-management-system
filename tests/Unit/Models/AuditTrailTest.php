<?php

namespace Tests\Unit\Models;

use App\Models\AuditTrail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuditTrailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_fillable_attributes()
    {
        $auditTrail = new AuditTrail();
        
        $fillable = [
            'user_id',
            'user_name',
            'user_email',
            'user_role',
            'action',
            'model_type',
            'model_id',
            'model_name',
            'ip_address',
            'user_agent',
            'method',
            'url',
            'route_name',
            'old_values',
            'new_values',
            'description',
            'event_type',
            'status',
            'error_message',
            'additional_data',
        ];

        $this->assertEquals($fillable, $auditTrail->getFillable());
    }

    /** @test */
    public function it_casts_attributes_correctly()
    {
        $auditTrail = new AuditTrail();
        
        $expectedCasts = [
            'old_values' => 'array',
            'new_values' => 'array',
            'additional_data' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'id' => 'int',
        ];

        $this->assertEquals($expectedCasts, $auditTrail->getCasts());
    }

    /** @test */
    public function it_belongs_to_user()
    {
        $auditTrail = new AuditTrail();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\BelongsTo::class,
            $auditTrail->user()
        );
    }

    /** @test */
    public function it_has_auditable_relationship()
    {
        $auditTrail = new AuditTrail();
        
        $this->assertInstanceOf(
            \Illuminate\Database\Eloquent\Relations\MorphTo::class,
            $auditTrail->auditable()
        );
    }

    /** @test */
    public function it_can_filter_by_action()
    {
        $auditTrail = new AuditTrail();
        $query = $auditTrail->newQuery();
        
        $result = $auditTrail->scopeAction($query, 'create');
        
        $this->assertStringContainsString(
            'where "action" = ?',
            $result->toSql()
        );
    }

    /** @test */
    public function it_can_filter_by_model()
    {
        $auditTrail = new AuditTrail();
        $query = $auditTrail->newQuery();
        
        $result = $auditTrail->scopeForModel($query, 'App\Models\User');
        
        $this->assertStringContainsString(
            'where "model_type" = ?',
            $result->toSql()
        );
    }

    /** @test */
    public function it_can_filter_by_user()
    {
        $auditTrail = new AuditTrail();
        $query = $auditTrail->newQuery();
        
        $result = $auditTrail->scopeByUser($query, 1);
        
        $this->assertStringContainsString(
            'where "user_id" = ?',
            $result->toSql()
        );
    }

    /** @test */
    public function it_can_filter_by_date_range()
    {
        $auditTrail = new AuditTrail();
        $query = $auditTrail->newQuery();
        
        $startDate = now()->subDays(7);
        $endDate = now();
        
        $result = $auditTrail->scopeDateRange($query, $startDate, $endDate);
        
        $this->assertStringContainsString(
            'between ? and ?',
            $result->toSql()
        );
    }

    /** @test */
    public function it_can_filter_recent_activities()
    {
        $auditTrail = new AuditTrail();
        $query = $auditTrail->newQuery();
        
        $result = $auditTrail->scopeRecent($query, 7);
        
        $this->assertStringContainsString(
            'where "created_at" >= ?',
            $result->toSql()
        );
    }

    /** @test */
    public function it_formats_action_correctly()
    {
        $auditTrail = new AuditTrail();
        $auditTrail->action = 'create';
        
        $this->assertEquals('Dicipta', $auditTrail->formatAction());
        
        $auditTrail->action = 'update';
        $this->assertEquals('Dikemaskini', $auditTrail->formatAction());
        
        $auditTrail->action = 'delete';
        $this->assertEquals('Dipadam', $auditTrail->formatAction());
        
        $auditTrail->action = 'custom_action';
        $this->assertEquals('Custom action', $auditTrail->formatAction());
    }

    /** @test */
    public function it_returns_correct_status_color()
    {
        $auditTrail = new AuditTrail();
        
        $auditTrail->status = 'success';
        $this->assertEquals('green', $auditTrail->getStatusColorAttribute());
        
        $auditTrail->status = 'failed';
        $this->assertEquals('red', $auditTrail->getStatusColorAttribute());
        
        $auditTrail->status = 'warning';
        $this->assertEquals('yellow', $auditTrail->getStatusColorAttribute());
        
        $auditTrail->status = 'unknown';
        $this->assertEquals('gray', $auditTrail->getStatusColorAttribute());
    }

    /** @test */
    public function it_generates_changes_summary()
    {
        $auditTrail = new AuditTrail();
        $auditTrail->old_values = ['name' => 'Old Name', 'email' => 'old@email.com'];
        $auditTrail->new_values = ['name' => 'New Name', 'email' => 'old@email.com'];
        
        $expected = [
            [
                'field' => 'name',
                'old' => 'Old Name',
                'new' => 'New Name'
            ]
        ];
        
        $this->assertEquals($expected, $auditTrail->getChangesSummaryAttribute());
    }
    
    /** @test */
    public function it_detects_browser_correctly()
    {
        $auditTrail = new AuditTrail();
        
        $auditTrail->user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36';
        $this->assertEquals('Chrome', $auditTrail->getBrowserName());
        
        $auditTrail->user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0';
        $this->assertEquals('Firefox', $auditTrail->getBrowserName());
        
        $auditTrail->user_agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15';
        $this->assertEquals('Safari', $auditTrail->getBrowserName());
        
        $auditTrail->user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36 Edg/91.0.864.59';
        $this->assertEquals('Chrome', $auditTrail->getBrowserName());
        
        $auditTrail->user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36 OPR/77.0.4054.277';
        $this->assertEquals('Chrome', $auditTrail->getBrowserName());
        
        $auditTrail->user_agent = null;
        $this->assertEquals('Unknown', $auditTrail->getBrowserName());
        
        $auditTrail->user_agent = 'Unknown Browser';
        $this->assertEquals('Unknown', $auditTrail->getBrowserName());
    }
    
    /** @test */
    public function it_detects_platform_correctly()
    {
        $auditTrail = new AuditTrail();
        
        $auditTrail->user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36';
        $this->assertEquals('Windows', $auditTrail->getPlatformName());
        
        $auditTrail->user_agent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.1.1 Safari/605.1.15';
        $this->assertEquals('macOS', $auditTrail->getPlatformName());
        
        $auditTrail->user_agent = 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36';
        $this->assertEquals('Linux', $auditTrail->getPlatformName());
        
        $auditTrail->user_agent = 'Mozilla/5.0 (Linux; Android 11; SM-G991B) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.120 Mobile Safari/537.36';
        $this->assertEquals('Linux', $auditTrail->getPlatformName());
        
        $auditTrail->user_agent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 14_6 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0 Mobile/15E148 Safari/604.1';
        $this->assertEquals('macOS', $auditTrail->getPlatformName());
        
        $auditTrail->user_agent = null;
        $this->assertEquals('Unknown', $auditTrail->getPlatformName());
        
        $auditTrail->user_agent = 'Unknown Platform';
        $this->assertEquals('Unknown', $auditTrail->getPlatformName());
    }
    
    /** @test */
    public function it_has_browser_attribute_accessor()
    {
        $auditTrail = new AuditTrail();
        $auditTrail->user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36';
        
        $this->assertEquals('Chrome', $auditTrail->getBrowserAttribute());
    }
    
    /** @test */
    public function it_has_platform_attribute_accessor()
    {
        $auditTrail = new AuditTrail();
        $auditTrail->user_agent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36';
        
        $this->assertEquals('Windows', $auditTrail->getPlatformAttribute());
    }
} 