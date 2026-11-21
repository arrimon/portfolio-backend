<?php

namespace Tests\Feature\Admin;

use App\Models\Media;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MediaUploadTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        $this->seed(RoleSeeder::class);

        return User::factory()->create([
            'role_id' => Role::where('slug', Role::SUPER_ADMIN)->value('id'),
            'is_active' => true,
        ]);
    }

    public function test_png_upload_works_and_filename_is_random(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())
            ->postJson('/admin/media', ['file' => UploadedFile::fake()->image('me.png'), 'kind' => 'image'])
            ->assertCreated();

        $media = Media::first();
        $this->assertNotSame('me.png', basename($media->path));
        Storage::disk('public')->assertExists($media->path);
    }

    public function test_svg_is_rejected(): void
    {
        Storage::fake('public');

        $this->actingAs($this->admin())
            ->postJson('/admin/media', [
                'file' => UploadedFile::fake()->createWithContent('x.svg', '<svg xmlns="http://www.w3.org/2000/svg"></svg>'),
                'kind' => 'image',
            ])
            ->assertStatus(422);
    }

    public function test_media_in_use_cannot_be_deleted(): void
    {
        $media = Media::create([
            'disk' => 'public', 'path' => 'uploads/a.png', 'original_name' => 'a.png',
            'mime_type' => 'image/png', 'size' => 10,
        ]);
        Profile::singleton()->update(['avatar_media_id' => $media->id]);

        $this->actingAs($this->admin())
            ->delete("/admin/media/{$media->id}")
            ->assertSessionHasErrors('media');

        $this->assertNotSoftDeleted($media);
    }
}
