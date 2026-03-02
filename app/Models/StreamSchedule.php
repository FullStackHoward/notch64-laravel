<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamSchedule extends Model
{
    protected $fillable = [
        'title',
        'description',
        'scheduled_at',
        'duration_minutes',
        'active',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];
}
