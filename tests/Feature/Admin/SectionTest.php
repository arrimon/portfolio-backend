<?php

namespace Tests\Feature\Admin;

use App\Models\Role;
use App\Models\Section;
use App\Models\User;
use Database\Seeders\LanguageSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\SectionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SectionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed([RoleSeeder::class, LanguageSeeder::class, SectionSeeder::class]);
        $this->actingAs(User::factory()->create([
            'role_id' => Role::where('slug', Role::SUPER_ADMIN)->value('id'),
            'is_active' => true,
        ]));
    }

    public function test_guest_is_redirected(): void
    {
        auth()->logout();
        $this->get('/admin/sections')->assertRedirect();
    }

    public function test_toggle_disables_section(): void
    {
        $section = Section::where('key', 'hero')->first();

        $this->patch("/admin/sections/{$section->id}/toggle")->assertRedirect();

        $this->assertFalse($section->fresh()->is_enabled);
    }

    public function test_reorder_updates_sort_order(): void
    {
        $ids = Section::ordered()->pluck('id')->reverse()->values()->all();

        $this->post('/admin/sections/reorder', ['order' => $ids])->assertRedirect();

        $this->assertSame($ids, Section::ordered()->pluck('id')->all());
        $this->assertSame(1, Section::find($ids[0])->sort_order);
    }

    public function test_invalid_variant_is_rejected(): void
    {
        $section = Section::where('key', 'hero')->first();

        $this->putJson("/admin/sections/{$section->id}", ['variant' => 'evil-component'])
            ->assertStatus(422)
            ->assertJsonValidationErrors('variant');
    }

    public function test_valid_variant_and_translation_saved(): void
    {
        $section = Section::where('key', 'hero')->first();

        $this->put("/admin/sections/{$section->id}", [
            'variant' => 'centered',
            'translations' => ['en' => ['title' => 'Hello'], 'bn' => ['title' => 'স্বাগতম']],
        ])->assertRedirect();

        $this->assertSame('centered', $section->fresh()->variant);
        $this->assertDatabaseHas('section_translations', ['locale' => 'bn', 'title' => 'স্বাগতম']);
    }
}
