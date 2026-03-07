<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Inspection;
use Illuminate\Auth\Access\HandlesAuthorization;

class InspectionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function view(User $user, Inspection $inspection): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function update(User $user, Inspection $inspection): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function delete(User $user, Inspection $inspection): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }
}
