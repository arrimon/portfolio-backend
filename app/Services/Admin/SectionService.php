<?php

namespace App\Services\Admin;

use App\Models\Section;
use App\Support\ContentCache;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SectionService
{
    public function all()
    {
        return Section::with('translations')->ordered()->get();
    }

    public function toggle(Section $section): Section
    {
        $section->update(['is_enabled' => ! $section->is_enabled]);
        DB::afterCommit(fn () => ContentCache::bump());

        return $section;
    }

    /** @param array<int,int> $orderedIds section ids in the new order */
    public function reorder(array $orderedIds): void
    {
        DB::transaction(function () use ($orderedIds) {
            foreach (array_values($orderedIds) as $index => $id) {
                Section::whereKey($id)->update(['sort_order' => $index + 1]);
            }
            DB::afterCommit(fn () => ContentCache::bump());
        });
    }

    public function update(Section $section, array $data): Section
    {
        return DB::transaction(function () use ($section, $data) {
            $section->update(['variant' => $data['variant'] ?? null]);

            foreach ($data['translations'] ?? [] as $locale => $fields) {
                $values = Arr::only($fields, ['title', 'subtitle']);

                if (blank($values['title'] ?? null) && blank($values['subtitle'] ?? null)) {
                    $section->translations()->where('locale', $locale)->delete();

                    continue;
                }

                $section->translations()->updateOrCreate(['locale' => $locale], $values);
            }

            DB::afterCommit(fn () => ContentCache::bump());

            return $section->fresh('translations');
        });
    }
}
