<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        foreach (config('portfolio.settings') as $group => $definitions) {
            foreach ($definitions as $key => $def) {
                Setting::firstOrCreate(
                    ['key' => $key],
                    [
                        'group' => $group,
                        'type' => $def['translatable'] ? 'translated' : 'plain',
                        'value' => $def['translatable'] ? null : ($def['default'] ?? null),
                    ]
                );
            }
        }
    }
}
