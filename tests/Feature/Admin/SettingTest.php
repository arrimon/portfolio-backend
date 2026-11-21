<?php

namespace Tests\Feature\Admin;

use App\Models\Role;
use App\Models\User;
use App\Services\Admin\SettingService;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([RoleSeeder::class, LanguageSeeder::class, SettingSeeder::class]);
        $this->actingAs(User::factory()->create([
            'role_id' => Role::where('slug', Role::SUPER_ADMIN)->value('id'),
            'is_active' => true,
        ]));
    }

    public function test_seo_title_saved_per_language(): void
    {
        $this->put('/admin/settings', [
            'translated' => ['meta_title' => ['en' => 'My Portfolio', 'bn' => 'আমার পোর্টফোলিও']],
            'plain' => ['accent' => 'emerald'],
        ])->assertRedirect();

        $this->assertDatabaseHas('setting_translations', ['locale' => 'en', 'value' => 'My Portfolio']);
        $this->assertDatabaseHas('setting_translations', ['locale' => 'bn', 'value' => 'আমার পোর্টফোলিও']);
    }

    public function test_invalid_theme_value_is_rejected(): void
    {
        $this->putJson('/admin/settings', ['plain' => ['accent' => 'url(javascript:alert(1))']])
            ->assertStatus(422)
            ->assertJsonValidationErrors('plain.accent');
    }

    public function test_cache_is_not_stale_after_update(): void
    {
        $service = app(SettingService::class);

        $this->put('/admin/settings', ['translated' => ['site_title' => ['en' => 'One']]]);
        $this->assertSame('One', $service->public('en')['site_title']);

        $this->put('/admin/settings', ['translated' => ['site_title' => ['en' => 'Two']]]);
        $this->assertSame('Two', $service->public('en')['site_title']);
    }

    public function test_bangla_falls_back_to_english_in_public_data(): void
    {
        $this->put('/admin/settings', ['translated' => ['site_title' => ['en' => 'Only English']]]);

        $this->assertSame('Only English', app(SettingService::class)->public('bn')['site_title']);
    }
}
