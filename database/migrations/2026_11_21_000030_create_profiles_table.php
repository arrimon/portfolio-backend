<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            // Singleton: always 1, UNIQUE => only one row possible.
            $table->unsignedTinyInteger('singleton_key')->default(1)->unique();
            $table->foreignId('avatar_media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->foreignId('cv_media_id')->nullable()->constrained('media')->nullOnDelete();
            $table->string('email', 150)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('location', 150)->nullable();
            $table->boolean('is_available_for_work')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
