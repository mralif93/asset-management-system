<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Disposal;
use Illuminate\Auth\Access\HandlesAuthorization;

class DisposalPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function view(User $user, Disposal $disposal): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function update(User $user, Disposal $disposal): bool
    {
        return in_array($user->role, ['administrator', 'officer']) && $disposal->status_pelupusan === 'Dimohon';
    }

    public function delete(User $user, Disposal $disposal): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function approve(User $user, Disposal $disposal): bool
    {
        return in_array($user->role, ['administrator', 'officer']) && $disposal->status_pelupusan === 'Dimohon';
    }

    public function reject(User $user, Disposal $disposal): bool
    {
        return in_array($user->role, ['administrator', 'officer']) && $disposal->status_pelupusan === 'Dimohon';
    }
}
