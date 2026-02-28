<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PlatformStat;
use Illuminate\Support\Facades\Storage;

class PlatformStatsController extends Controller
{
    public function index()
    {
        $stats = PlatformStat::where('active', true)
            ->orderBy('sort_order')
            ->get();

        $grouped = $stats->groupBy('platform')->map(function ($items, $platform) {
            return [
                'platform' => $platform,
                'stats'    => $items->map(function ($stat) {
                    return [
                        'stat_label' => $stat->stat_label,
                        'stat_value' => $stat->stat_value,
                        'icon_path'  => $stat->icon_path
                            ? Storage::disk('public')->url($stat->icon_path)
                            : null,
                    ];
                })->values(),
            ];
        })->values();

        return response()->json($grouped);
    }
}
