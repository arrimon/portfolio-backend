<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Super Admin সব policy/ability-তে অনুমতি পায়; অন্যদের জন্য পরের policy-তে সিদ্ধান্ত হবে।
        Gate::before(fn (User $user) => $user->is_active && $user->isSuperAdmin() ? true : null);
    }
}
