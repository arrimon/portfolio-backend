<?php

namespace App\Models;

use App\Models\Concerns\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Setting extends Model
{
    use HasTranslations;

    protected $fillable = ['group', 'key', 'value', 'type'];

    public function translations(): HasMany
    {
        return $this->hasMany(SettingTranslation::class);
    }
}
