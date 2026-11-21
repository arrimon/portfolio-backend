<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;

class SectionPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function update(User $user, Section $section): bool
    {
        return true; // replace with your Module 1 role check if needed
    }
}
