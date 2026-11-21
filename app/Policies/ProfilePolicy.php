<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;

class ProfilePolicy
{
    // Single-owner site: any authenticated admin. Tighten with your Module 1 role check
    // e.g. return $user->role?->slug === 'super-admin';
    public function view(User $user, Profile $profile): bool
    {
        return true;
    }

    public function update(User $user, Profile $profile): bool
    {
        return true;
    }
}
