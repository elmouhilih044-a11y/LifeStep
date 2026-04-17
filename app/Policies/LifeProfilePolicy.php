<?php

namespace App\Policies;

use App\Models\User;

class LifeProfilePolicy
{
   public function create(User $user): bool
    {
        return $user->role === 'user';
    }

    public function view(User $user): bool
    {
        return $user->role === 'user';
    }

    public function update(User $user): bool
    {
        return $user->role === 'user';
    }
}
