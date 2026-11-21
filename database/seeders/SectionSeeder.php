<?php

namespace Database\Seeders;

use App\Enums\SectionKey;
use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        foreach (SectionKey::cases() as $i => $key) {
            // firstOrCreate: re-seeding never resets admin's order / on-off choices
            $section = Section::firstOrCreate(
                ['key' => $key->value],
                ['is_enabled' => true, 'sort_order' => $i + 1, 'variant' => 'default']
            );

            $section->translations()->firstOrCreate(['locale' => 'en'], ['title' => $key->label()]);
        }
    }
}
