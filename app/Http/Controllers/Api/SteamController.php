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

        // Appids whose store page requires an actual Steam login — those cards get no link.
        $loginWalled = config('notch64.steam.login_walled_appids', []);

        $formatted = collect($games)->map(function ($game) use ($loginWalled) {
            $appid = $game['appid'];

            return [
                'title'      => $game['name'],
                'cover_url'  => 'https://cdn.cloudflare.steamstatic.com/steam/apps/' . $appid . '/header.jpg',
                'steam_url'  => in_array($appid, $loginWalled)
                    ? null
                    : 'https://store.steampowered.com/app/' . $appid . '/',
                'playtime'   => round($game['playtime_2weeks'] / 60, 1) . ' hrs last 2 weeks',
            ];
        });

        return response()->json($formatted);
    }
}
