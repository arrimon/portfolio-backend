<?php

use App\Support\Database\TranslationTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        TranslationTable::create('profile_translations', 'profile_id', 'profiles', function (Blueprint $table) {
            $table->string('name', 150)->nullable();
            $table->string('headline', 200)->nullable();
            $table->text('bio')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_translations');
    }
};
