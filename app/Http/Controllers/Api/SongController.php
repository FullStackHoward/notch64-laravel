<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Song;

class SongController extends Controller
{
    public function index()
    {
        $songs = Song::active()
            ->ordered()
            ->get()
            ->map(function ($song) {
                return [
                    'title'  => $song->artist ? $song->artist . ' - ' . $song->title : $song->title,
                    'src'    => '/storage/' . $song->file_path,
                ];
            });

        return response()->json($songs);
    }
}
