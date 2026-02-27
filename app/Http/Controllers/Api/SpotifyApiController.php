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

    public function genreData()
    {
        $tokenData = \DB::table('spotify_tokens')->find(1);

        if (!$tokenData) {
            return response()->json(['error' => 'Spotify not connected'], 401);
        }

        $session = new Session(
            config('notch64.spotify.client_id'),
            config('notch64.spotify.client_secret'),
            config('notch64.spotify.redirect_uri')
        );

        $session->refreshAccessToken($tokenData->refresh_token);
        $accessToken = $session->getAccessToken();

        \DB::table('spotify_tokens')->where('id', 1)->update([
            'access_token' => $accessToken,
            'updated_at'   => now(),
        ]);

        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        $topArtists = $api->getMyTop('artists', [
            'limit'      => 20,
            'time_range' => 'short_term',
        ]);

        // Collect all genres and count how often each appears
        $genreCounts = [];
        foreach ($topArtists->items as $artist) {
            foreach ($artist->genres as $genre) {
                $genreCounts[$genre] = ($genreCounts[$genre] ?? 0) + 1;
            }
        }

        // Sort by frequency descending
        arsort($genreCounts);

        // Build broad category buckets for the radar chart
        $categories = [
            'Hip-Hop / Rap'   => 0,
            'R&B / Soul'      => 0,
            'Electronic'      => 0,
            'Rock / Alt'      => 0,
            'Pop'             => 0,
            'Jazz / Blues'    => 0,
            'Latin'           => 0,
            'Other'           => 0,
        ];

        foreach ($genreCounts as $genre => $count) {
            if (preg_match('/hip.hop|rap|trap|drill/i', $genre)) {
                $categories['Hip-Hop / Rap'] += $count;
            } elseif (preg_match('/r&b|soul|funk|gospel/i', $genre)) {
                $categories['R&B / Soul'] += $count;
            } elseif (preg_match('/electronic|edm|house|techno|dance|synth/i', $genre)) {
                $categories['Electronic'] += $count;
            } elseif (preg_match('/rock|alt|indie|metal|punk|grunge/i', $genre)) {
                $categories['Rock / Alt'] += $count;
            } elseif (preg_match('/pop/i', $genre)) {
                $categories['Pop'] += $count;
            } elseif (preg_match('/jazz|blues|swing|bebop/i', $genre)) {
                $categories['Jazz / Blues'] += $count;
            } elseif (preg_match('/latin|reggaeton|salsa|cumbia/i', $genre)) {
                $categories['Latin'] += $count;
            } else {
                $categories['Other'] += $count;
            }
        }

        // Remove empty categories
        $categories = array_filter($categories);

        return response()->json([
            'radar'    => $categories,
            'tagcloud' => $genreCounts,
        ]);
    }
}
