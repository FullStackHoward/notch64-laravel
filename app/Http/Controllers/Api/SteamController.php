<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class SteamController extends Controller
{
    public function recentlyPlayed()
    {
        $apiKey  = env('STEAM_API_KEY');
        $steamId = env('STEAM_ID');

        $response = Http::get('https://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v1/', [
            'key'     => $apiKey,
            'steamid' => $steamId,
            'count'   => 5,
            'format'  => 'json',
        ]);

        if (!$response->ok()) {
            return response()->json(['error' => 'Failed to fetch Steam data'], 500);
        }

        $games = $response->json()['response']['games'] ?? [];

        $formatted = collect($games)->map(function ($game) {
            return [
                'title'      => $game['name'],
                'cover_url'  => 'https://cdn.cloudflare.steamstatic.com/steam/apps/' . $game['appid'] . '/header.jpg',
                'steam_url'  => 'https://store.steampowered.com/app/' . $game['appid'],
                'playtime'   => round($game['playtime_2weeks'] / 60, 1) . ' hrs last 2 weeks',
            ];
        });

        return response()->json($formatted);
    }
}
