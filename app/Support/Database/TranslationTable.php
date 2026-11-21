<?php

namespace App\Support\Database;

use Closure;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// (File 6 helper — skip if you already created it)
class TranslationTable
{
    public static function create(string $table, string $foreignKey, string $parentTable, Closure $columns): void
    {
        Schema::create($table, function (Blueprint $blueprint) use ($foreignKey, $parentTable, $columns) {
            $blueprint->id();
            $blueprint->foreignId($foreignKey)->constrained($parentTable)->cascadeOnDelete();
            $blueprint->string('locale', 5);
            $columns($blueprint);
            $blueprint->unique([$foreignKey, 'locale']);
        });
    }
}
