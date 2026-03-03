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
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']);
    }

    public function view(User $user, LossWriteoff $lossWriteoff): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']);
    }

    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']);
    }

    public function update(User $user, LossWriteoff $lossWriteoff): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']) && $lossWriteoff->status_kejadian === 'Dilaporkan';
    }

    public function delete(User $user, LossWriteoff $lossWriteoff): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']);
    }

    public function approve(User $user, LossWriteoff $lossWriteoff): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']) && $lossWriteoff->status_kejadian === 'Dilaporkan';
    }

    public function reject(User $user, LossWriteoff $lossWriteoff): bool
    {
        return in_array($user->role, ['admin', 'superadmin', 'Asset Officer']) && $lossWriteoff->status_kejadian === 'Dilaporkan';
    }
}
