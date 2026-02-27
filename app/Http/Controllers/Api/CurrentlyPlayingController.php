<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CurrentlyPlaying;

class CurrentlyPlayingController extends Controller
{
    public function index()
    {
        $games = CurrentlyPlaying::where('active', true)
            ->latest()
            ->get();

        return response()->json($games);
    }
}
