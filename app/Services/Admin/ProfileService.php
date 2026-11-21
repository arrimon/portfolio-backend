<?php

namespace App\Services\Admin;

use App\Models\Profile;
use App\Support\ContentCache;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProfileService
{
    public function __construct(private MediaService $media) {}

    public function get(): Profile
    {
        return Profile::singleton()->load('translations', 'avatar', 'cv');
    }

    public function update(Profile $profile, array $data, ?UploadedFile $avatar = null, ?UploadedFile $cv = null): Profile
    {
        return DB::transaction(function () use ($profile, $data, $avatar, $cv) {
            $attributes = Arr::only($data, ['email', 'phone', 'location']);
            $attributes['is_available_for_work'] = (bool) ($data['is_available_for_work'] ?? false);

            if ($avatar) {
                $attributes['avatar_media_id'] = $this->media->upload($avatar, 'image')->id;
            }
            if ($cv) {
                $attributes['cv_media_id'] = $this->media->upload($cv, 'document')->id;
            }

            $profile->update($attributes);

            foreach ($data['translations'] ?? [] as $locale => $fields) {
                $values = Arr::only($fields, ['name', 'headline', 'bio']);

                if (blank($values['name'] ?? null) && blank($values['headline'] ?? null) && blank($values['bio'] ?? null)) {
                    $profile->translations()->where('locale', $locale)->delete();

                    continue;
                }

                $profile->translations()->updateOrCreate(['locale' => $locale], $values);
            }

            DB::afterCommit(fn () => ContentCache::bump());

            return $profile->fresh(['translations', 'avatar', 'cv']);
        });
    }
}
