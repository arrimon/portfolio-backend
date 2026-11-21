<?php

use App\Support\Database\TranslationTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        TranslationTable::create('section_translations', 'section_id', 'sections', function (Blueprint $table) {
            $table->string('title', 150)->nullable();
            $table->string('subtitle', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('section_translations');
    }
};
