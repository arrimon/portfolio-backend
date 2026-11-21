<?php

namespace App\Services\Admin;

use App\Models\SocialLink;
use App\Support\ContentCache;
use Illuminate\Support\Facades\DB;

class SocialLinkService
{
    public function all()
    {
        return SocialLink::ordered()->get();
    }

    /** Active links only, in order — for the public API. */
    public function activeForPublic(): array
    {
        return SocialLink::active()->ordered()
            ->get(['platform', 'url', 'icon_key'])
            ->toArray();
    }

    public function create(array $data): SocialLink
    {
        return DB::transaction(function () use ($data) {
            $link = SocialLink::create([
                'platform' => $data['platform'],
                'url' => $data['url'],
                'icon_key' => $data['platform'],
                'is_active' => (bool) ($data['is_active'] ?? false),
                'sort_order' => (int) SocialLink::max('sort_order') + 1,
            ]);
            DB::afterCommit(fn () => ContentCache::bump());

            return $link;
        });
    }

    public function update(SocialLink $link, array $data): SocialLink
    {
        $link->update([
            'platform' => $data['platform'],
            'url' => $data['url'],
            'icon_key' => $data['platform'],
            'is_active' => (bool) ($data['is_active'] ?? false),
        ]);
        DB::afterCommit(fn () => ContentCache::bump());

        return $link;
    }

    public function delete(SocialLink $link): void
    {
        $link->delete();
        DB::afterCommit(fn () => ContentCache::bump());
    }

    public function reorder(array $orderedIds): void
    {
        DB::transaction(function () use ($orderedIds) {
            foreach (array_values($orderedIds) as $index => $id) {
                SocialLink::whereKey($id)->update(['sort_order' => $index + 1]);
            }
            DB::afterCommit(fn () => ContentCache::bump());
        });
    }
}
