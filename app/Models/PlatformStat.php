<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlatformStat extends Model
{
    protected $table = 'platform_stats';

    protected $fillable = [
        'platform',
        'stat_label',
        'stat_value',
        'icon_path',
        'active',
        'sort_order',
    ];
}
