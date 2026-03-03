<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Asset;
use Illuminate\Auth\Access\HandlesAuthorization;

class AssetPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']);
    }

    public function view(User $user, Asset $asset): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']);
    }

    public function update(User $user, Asset $asset): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']);
    }

    public function delete(User $user, Asset $asset): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']);
    }

    public function restore(User $user, Asset $asset): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']);
    }

    public function forceDelete(User $user, Asset $asset): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']);
    }
}
