<?php

namespace App\Policies;

use App\Models\SocialLink;
use App\Models\User;

class SocialLinkPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, SocialLink $link): bool
    {
        return true;
    }

    public function delete(User $user, SocialLink $link): bool
    {
        return true;
    }
}
