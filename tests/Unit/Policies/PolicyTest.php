<?php

namespace Tests\Unit\Policies;

use Tests\TestCase;
use App\Policies\AssetPolicy;
use App\Policies\DisposalPolicy;
use App\Policies\InspectionPolicy;
use App\Policies\MaintenanceRecordPolicy;
use App\Policies\LossWriteoffPolicy;
use App\Models\User;
use App\Models\Asset;
use App\Models\Disposal;
use App\Models\Inspection;
use App\Models\MaintenanceRecord;
use App\Models\LossWriteoff;
use App\Models\MasjidSurau;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PolicyTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private User $regularUser;
    private Asset $asset;
    private MasjidSurau $masjidSurau;

    protected function setUp(): void
    {
        parent::setUp();

        $this->masjidSurau = MasjidSurau::factory()->create();
        $this->adminUser = User::factory()->create([
            'role' => 'admin',
            'masjid_surau_id' => $this->masjidSurau->id,
        ]);
        $this->regularUser = User::factory()->create([
            'role' => 'user',
            'masjid_surau_id' => $this->masjidSurau->id,
        ]);
        $this->asset = Asset::factory()->create([
            'masjid_surau_id' => $this->masjidSurau->id,
        ]);
    }

    public function test_asset_policy_allows_admin_to_view_any(): void
    {
        $policy = new AssetPolicy();

        $this->assertTrue($policy->viewAny($this->adminUser));
        $this->assertFalse($policy->viewAny($this->regularUser));
    }

    public function test_asset_policy_allows_admin_to_create(): void
    {
        $policy = new AssetPolicy();

        $this->assertTrue($policy->create($this->adminUser));
        $this->assertFalse($policy->create($this->regularUser));
    }

    public function test_asset_policy_allows_admin_to_update(): void
    {
        $policy = new AssetPolicy();

        $this->assertTrue($policy->update($this->adminUser, $this->asset));
        $this->assertFalse($policy->update($this->regularUser, $this->asset));
    }

    public function test_asset_policy_allows_admin_to_delete(): void
    {
        $policy = new AssetPolicy();

        $this->assertTrue($policy->delete($this->adminUser, $this->asset));
        $this->assertFalse($policy->delete($this->regularUser, $this->asset));
    }

    public function test_asset_policy_allows_admin_to_restore(): void
    {
        $policy = new AssetPolicy();

        $this->assertTrue($policy->restore($this->adminUser, $this->asset));
    }

    public function test_asset_policy_allows_admin_to_force_delete(): void
    {
        $policy = new AssetPolicy();

        $this->assertTrue($policy->forceDelete($this->adminUser, $this->asset));
    }

    public function test_disposal_policy_allows_admin_to_approve_pending_disposal(): void
    {
        $disposal = Disposal::factory()->create([
            'asset_id' => $this->asset->id,
            'user_id' => $this->adminUser->id,
            'status_pelupusan' => 'Dimohon',
        ]);

        $policy = new DisposalPolicy();

        $this->assertTrue($policy->approve($this->adminUser, $disposal));
    }

    public function test_disposal_policy_denies_approve_for_non_pending_disposal(): void
    {
        $disposal = Disposal::factory()->create([
            'asset_id' => $this->asset->id,
            'user_id' => $this->adminUser->id,
            'status_pelupusan' => 'Diluluskan',
        ]);

        $policy = new DisposalPolicy();

        $this->assertFalse($policy->approve($this->adminUser, $disposal));
    }

    public function test_disposal_policy_allows_admin_to_reject_pending_disposal(): void
    {
        $disposal = Disposal::factory()->create([
            'asset_id' => $this->asset->id,
            'user_id' => $this->adminUser->id,
            'status_pelupusan' => 'Dimohon',
        ]);

        $policy = new DisposalPolicy();

        $this->assertTrue($policy->reject($this->adminUser, $disposal));
    }

    public function test_inspection_policy_allows_admin_to_view_any(): void
    {
        $policy = new InspectionPolicy();

        $this->assertTrue($policy->viewAny($this->adminUser));
    }

    public function test_maintenance_record_policy_allows_admin_to_view_any(): void
    {
        $policy = new MaintenanceRecordPolicy();

        $this->assertTrue($policy->viewAny($this->adminUser));
    }

    public function test_loss_writeoff_policy_allows_admin_to_view_any(): void
    {
        $policy = new LossWriteoffPolicy();

        $this->assertTrue($policy->viewAny($this->adminUser));
    }
}
