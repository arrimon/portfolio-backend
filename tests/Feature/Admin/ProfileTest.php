<?php

namespace Tests\Feature\Admin;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(LanguageSeeder::class);
    }

    private function admin(): User
    {
        $this->seed(RoleSeeder::class);

        return User::factory()->create([
            'role_id' => Role::where('slug', Role::SUPER_ADMIN)->value('id'),
            'is_active' => true,
        ]);
    }

    public function test_guest_cannot_open_profile(): void
    {
        $this->get('/admin/profile')->assertRedirect();
    }

    public function test_admin_can_save_english_profile(): void
    {
        $this->actingAs($this->admin())
            ->put('/admin/profile', [
                'email' => 'me@example.com',
                'translations' => ['en' => ['name' => 'Rahim', 'headline' => 'Developer']],
            ])
            ->assertRedirect(route('admin.profile.edit'));

        $this->assertDatabaseHas('profile_translations', ['locale' => 'en', 'name' => 'Rahim']);
        $this->assertDatabaseCount('profiles', 1);
    }

    public function test_default_language_name_is_required(): void
    {
        $this->actingAs($this->admin())
            ->put('/admin/profile', ['translations' => ['bn' => ['name' => 'রহিম']]])
            ->assertSessionHasErrors('translations.en.name');
    }

    public function test_missing_bangla_shows_fallback_badge(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin/profile')
            ->assertOk()
            ->assertSee('fallback');
    }
}
