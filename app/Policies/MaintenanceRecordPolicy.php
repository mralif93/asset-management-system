<?php

namespace App\Policies;

use App\Models\User;
use App\Models\MaintenanceRecord;
use Illuminate\Auth\Access\HandlesAuthorization;

class MaintenanceRecordPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']);
    }

    public function view(User $user, MaintenanceRecord $maintenanceRecord): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']);
    }

    public function update(User $user, MaintenanceRecord $maintenanceRecord): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']);
    }

    public function delete(User $user, MaintenanceRecord $maintenanceRecord): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']);
    }
}
