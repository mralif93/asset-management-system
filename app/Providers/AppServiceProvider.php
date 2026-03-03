<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Asset;
use App\Models\Disposal;
use App\Models\Inspection;
use App\Models\MaintenanceRecord;
use App\Models\LossWriteoff;
use App\Models\AssetMovement;
use App\Models\ImmovableAsset;
use App\Models\MasjidSurau;
use App\Models\User;
use App\Policies\AssetPolicy;
use App\Policies\DisposalPolicy;
use App\Policies\InspectionPolicy;
use App\Policies\MaintenanceRecordPolicy;
use App\Policies\LossWriteoffPolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Asset::class => AssetPolicy::class,
        Disposal::class => DisposalPolicy::class,
        Inspection::class => InspectionPolicy::class,
        MaintenanceRecord::class => MaintenanceRecordPolicy::class,
        LossWriteoff::class => LossWriteoffPolicy::class,
    ];

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->registerPolicies();

        // Super admin gate - bypasses all authorization
        Gate::before(function ($user, $ability) {
            if ($user->role === 'admin') {
                return true;
            }
        });
    }

    protected function registerPolicies(): void
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
