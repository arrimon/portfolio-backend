<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('group', 30)->index();   // general | seo | theme
            $table->string('key', 80)->unique();
            $table->text('value')->nullable();      // non-translatable value
            $table->string('type', 20)->default('plain'); // plain | translated
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
