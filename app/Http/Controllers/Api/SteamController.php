<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SteamController extends Controller
{
    public function recentlyPlayed()
    {
        $apiKey  = config('notch64.steam.api_key');
        $steamId = config('notch64.steam.steam_id');

        if (empty($apiKey) || empty($steamId)) {
            Log::warning('Steam integration: STEAM_API_KEY or STEAM_ID is not configured.');
            return response()->json([]);
        }

        try {
            $response = Http::timeout(8)->get('https://api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/v1/', [
                'key'     => $apiKey,
                'steamid' => $steamId,
                'count'   => 5,
                'format'  => 'json',
            ]);
        } catch (\Throwable $e) {
            Log::warning('Steam integration: request to Steam API failed: ' . $e->getMessage());
            return response()->json([]);
        }

        if (!$response->ok()) {
            Log::warning('Steam integration: Steam API returned a non-OK response.', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            return response()->json([]);
        }

        $games = $response->json()['response']['games'] ?? [];

        if (empty($games)) {
            // GetRecentlyPlayedGames returns an empty list when the Steam profile's
            // game details are set to private, or when there has been no playtime in
            // the last 2 weeks. This is the most common cause of a blank Steam row.
            Log::info('Steam integration: no recently played games returned (private profile or no recent playtime).');
        }

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
