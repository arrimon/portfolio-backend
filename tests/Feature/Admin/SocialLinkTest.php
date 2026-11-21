<?php

namespace Tests\Feature\Admin;

use App\Models\Role;
use App\Models\SocialLink;
use App\Models\User;
use App\Services\Admin\SocialLinkService;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SocialLinkTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $this->actingAs(User::factory()->create([
            'role_id' => Role::where('slug', Role::SUPER_ADMIN)->value('id'),
            'is_active' => true,
        ]));
    }

    public function test_https_link_can_be_created(): void
    {
        $this->post('/admin/social-links', [
            'platform' => 'github', 'url' => 'https://github.com/me', 'is_active' => 1,
        ])->assertRedirect(route('admin.social-links.index'));

        $this->assertDatabaseHas('social_links', ['platform' => 'github', 'sort_order' => 1]);
    }

    public function test_javascript_and_http_urls_are_rejected(): void
    {
        foreach (['javascript:alert(1)', 'http://example.com', 'data:text/html,x'] as $bad) {
            $this->postJson('/admin/social-links', ['platform' => 'website', 'url' => $bad])
                ->assertStatus(422)
                ->assertJsonValidationErrors('url');
        }
    }

    public function test_mailto_is_allowed(): void
    {
        $this->post('/admin/social-links', ['platform' => 'email', 'url' => 'mailto:me@example.com'])
            ->assertRedirect();
    }

    public function test_inactive_link_is_excluded_from_public_data(): void
    {
        SocialLink::create(['platform' => 'github', 'url' => 'https://github.com/a', 'is_active' => true, 'sort_order' => 1]);
        SocialLink::create(['platform' => 'x', 'url' => 'https://x.com/a', 'is_active' => false, 'sort_order' => 2]);

        $public = app(SocialLinkService::class)->activeForPublic();

        $this->assertCount(1, $public);
        $this->assertSame('github', $public[0]['platform']);
    }

    public function test_reorder_works(): void
    {
        $a = SocialLink::create(['platform' => 'github', 'url' => 'https://github.com/a', 'sort_order' => 1]);
        $b = SocialLink::create(['platform' => 'x', 'url' => 'https://x.com/a', 'sort_order' => 2]);

        $this->post('/admin/social-links/reorder', ['order' => [$b->id, $a->id]])->assertRedirect();

        $this->assertSame([$b->id, $a->id], SocialLink::ordered()->pluck('id')->all());
    }
}
