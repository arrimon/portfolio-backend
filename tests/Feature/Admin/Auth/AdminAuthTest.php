<?php

namespace Tests\Feature\Admin\Auth;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    private function admin(array $attrs = []): User
    {
        $this->seed(RoleSeeder::class);

        return User::factory()->create(array_merge([
            'role_id' => Role::where('slug', Role::SUPER_ADMIN)->value('id'),
            'password' => 'secret-pass-123',
            'is_active' => true,
        ], $attrs));
    }

    public function test_guest_cannot_open_admin_dashboard(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }

    public function test_admin_can_login_and_see_dashboard(): void
    {
        $user = $this->admin();

        $this->post('/admin/login', ['email' => $user->email, 'password' => 'secret-pass-123'])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
        $this->assertNotNull($user->fresh()->last_login_at);
        $this->get('/admin')->assertOk()->assertSee('Dashboard');
    }

    public function test_wrong_password_is_rejected(): void
    {
        $user = $this->admin();

        $this->from('/admin/login')
            ->post('/admin/login', ['email' => $user->email, 'password' => 'wrong'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_inactive_admin_cannot_login(): void
    {
        $user = $this->admin(['is_active' => false]);

        $this->post('/admin/login', ['email' => $user->email, 'password' => 'secret-pass-123'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_validation_errors_are_shown(): void
    {
        $this->post('/admin/login', [])->assertSessionHasErrors(['email', 'password']);
    }

    public function test_login_is_throttled_after_five_failures(): void
    {
        $user = $this->admin();

        for ($i = 0; $i < 5; $i++) {
            $this->post('/admin/login', ['email' => $user->email, 'password' => 'wrong']);
        }

        // সঠিক password দিলেও এখন block থাকবে
        $this->post('/admin/login', ['email' => $user->email, 'password' => 'secret-pass-123'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_logout_ends_session(): void
    {
        $user = $this->admin();

        $this->actingAs($user)->post('/admin/logout')->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }

    public function test_user_without_role_is_kicked_out(): void
    {
        $user = $this->admin(['role_id' => null]);

        $this->actingAs($user)->get('/admin')->assertRedirect(route('admin.login'));
        $this->assertGuest();
    }
}
