<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfileTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['profile_id', 'locale', 'name', 'headline', 'bio'];
}
