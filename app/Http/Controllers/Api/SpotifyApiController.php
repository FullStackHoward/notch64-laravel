<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyApiController extends Controller
{
    public function topArtists()
    {
        // Grab the stored tokens from the database
        $tokenData = \DB::table('spotify_tokens')->find(1);

        if (!$tokenData) {
            return response()->json(['error' => 'Spotify not connected'], 401);
        }

        $session = new Session(
            config('notch64.spotify.client_id'),
            config('notch64.spotify.client_secret'),
            config('notch64.spotify.redirect_uri')
        );

        // Use the refresh token to get a fresh access token
        // Think of this like auto-renewing an expired parking ticket
        $session->refreshAccessToken($tokenData->refresh_token);
        $accessToken = $session->getAccessToken();

        // Update the stored access token with the fresh one
        \DB::table('spotify_tokens')->where('id', 1)->update([
            'access_token' => $accessToken,
            'updated_at'   => now(),
        ]);

        // Now use the fresh token to call Spotify
        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        $topArtists = $api->getMyTop('artists', [
            'limit'      => 5,
            'time_range' => 'short_term', // last 4 weeks
        ]);

        // Shape the response to only what we need
        $artists = collect($topArtists->items)->map(function($artist) {
            return [
                'name'   => $artist->name,
                'image'  => $artist->images[0]->url ?? null,
                'url'    => $artist->external_urls->spotify,
            ];
        });

        return response()->json($artists);
    }
}
