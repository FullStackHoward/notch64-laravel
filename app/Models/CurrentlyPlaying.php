<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrentlyPlaying extends Model
{
    protected $table = 'currently_playing';
    protected $fillable = [
        'title',
        'platform',
        'cover_url',
        'active',
    ];
}
