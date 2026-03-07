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
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function view(User $user, Asset $asset): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function update(User $user, Asset $asset): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function delete(User $user, Asset $asset): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function restore(User $user, Asset $asset): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function forceDelete(User $user, Asset $asset): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }
}
