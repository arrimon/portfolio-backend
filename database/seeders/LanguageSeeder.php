<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        Language::updateOrCreate(['code' => 'en'], [
            'name' => 'English', 'native_name' => 'English',
            'is_default' => true, 'is_active' => true, 'sort_order' => 1,
        ]);

        Language::updateOrCreate(['code' => 'bn'], [
            'name' => 'Bangla', 'native_name' => 'বাংলা',
            'is_default' => false, 'is_active' => true, 'sort_order' => 2,
        ]);
    }
}
