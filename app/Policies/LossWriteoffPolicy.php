<?php

namespace App\Policies;

use App\Models\User;
use App\Models\LossWriteoff;
use Illuminate\Auth\Access\HandlesAuthorization;

class LossWriteoffPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function view(User $user, LossWriteoff $lossWriteoff): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function update(User $user, LossWriteoff $lossWriteoff): bool
    {
        return in_array($user->role, ['administrator', 'officer']) && $lossWriteoff->status_kejadian === 'Dilaporkan';
    }

    public function delete(User $user, LossWriteoff $lossWriteoff): bool
    {
        return in_array($user->role, ['administrator', 'officer']);
    }

    public function approve(User $user, LossWriteoff $lossWriteoff): bool
    {
        return in_array($user->role, ['administrator', 'officer']) && $lossWriteoff->status_kejadian === 'Dilaporkan';
    }

    public function reject(User $user, LossWriteoff $lossWriteoff): bool
    {
        return in_array($user->role, ['administrator', 'officer']) && $lossWriteoff->status_kejadian === 'Dilaporkan';
    }
}
