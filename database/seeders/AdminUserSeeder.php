<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command?->error('.env-এ ADMIN_EMAIL এবং ADMIN_PASSWORD সেট করো, তারপর আবার seed চালাও।');

            return;
        }

        $role = Role::where('slug', Role::SUPER_ADMIN)->firstOrFail();

        // idempotent: বারবার চালালে duplicate হবে না, তবে বিদ্যমান password বদলাবে না।
        $user = User::firstOrNew(['email' => $email]);
        $user->name = $user->name ?: env('ADMIN_NAME', 'Super Admin');
        $user->role_id = $role->id;
        $user->is_active = true;
        if (! $user->exists) {
            $user->password = $password;
        }
        $user->save();
    }
}
