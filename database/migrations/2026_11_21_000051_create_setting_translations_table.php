<?php

use App\Support\Database\TranslationTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        TranslationTable::create('setting_translations', 'setting_id', 'settings', function (Blueprint $table) {
            $table->text('value')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('setting_translations');
    }
};
