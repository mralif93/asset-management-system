<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\NotificationService;
use App\Models\User;
use App\Models\Asset;
use App\Models\Disposal;
use App\Models\AssetMovement;
use App\Models\LossWriteoff;
use App\Models\MasjidSurau;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NotificationServiceTest extends TestCase
{
    use RefreshDatabase;

    private User $adminUser;
    private Asset $asset;
    private MasjidSurau $masjidSurau;

    protected function setUp(): void
    {
        parent::setUp();

        $this->masjidSurau = MasjidSurau::factory()->create();
        $this->adminUser = User::factory()->create([
            'role' => 'administrator',
            'masjid_surau_id' => $this->masjidSurau->id,
        ]);
        $this->asset = Asset::factory()->create([
            'masjid_surau_id' => $this->masjidSurau->id,
        ]);
    }

    public function test_notify_new_disposal_request_logs_correctly(): void
    {
        $disposal = Disposal::factory()->create([
            'asset_id' => $this->asset->id,
            'user_id' => $this->adminUser->id,
        ]);

        NotificationService::notifyNewDisposalRequest($disposal);

        $this->assertNotNull($disposal->id);
    }

    public function test_notify_disposal_approved_logs_correctly(): void
    {
        $disposal = Disposal::factory()->create([
            'asset_id' => $this->asset->id,
            'user_id' => $this->adminUser->id,
            'status_pelupusan' => 'Diluluskan',
        ]);

        NotificationService::notifyDisposalApproved($disposal);

        $this->assertEquals('Diluluskan', $disposal->status_pelupusan);
    }

    public function test_notify_disposal_rejected_logs_correctly(): void
    {
        $disposal = Disposal::factory()->create([
            'asset_id' => $this->asset->id,
            'user_id' => $this->adminUser->id,
            'status_pelupusan' => 'Ditolak',
        ]);

        NotificationService::notifyDisposalRejected($disposal, 'Test rejection reason');

        $this->assertEquals('Ditolak', $disposal->status_pelupusan);
    }

    public function test_get_pending_notifications_for_admin(): void
    {
        $user = User::factory()->create(['role' => 'administrator']);

        $notifications = NotificationService::getPendingNotifications($user);

        $this->assertIsArray($notifications);
    }

    public function test_get_pending_notifications_returns_empty_for_non_admin(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $notifications = NotificationService::getPendingNotifications($user);

        $this->assertEmpty($notifications);
    }
}
