<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use SpotifyWebAPI\Session;
use SpotifyWebAPI\SpotifyWebAPI;

class SpotifyApiController extends Controller
{
    public function topArtists()
    {
        $api = $this->connect();

        if (!$api instanceof SpotifyWebAPI) {
            return $api; // JSON error response from connect()
        }

        try {
            $topArtists = $api->getMyTop('artists', [
                'limit'      => 5,
                'time_range' => 'short_term', // last 4 weeks
            ]);
        } catch (\Throwable $e) {
            Log::warning('Spotify integration: getMyTop(artists) failed: ' . $e->getMessage());
            return response()->json([]);
        }

        // Shape the response to only what we need
        $artists = collect($topArtists->items)->map(function ($artist) {
            return [
                'name'  => $artist->name,
                'image' => $artist->images[0]->url ?? null,
                'url'   => $artist->external_urls->spotify,
            ];
        });

        return response()->json($artists);
    }

    public function genreData()
    {
        $api = $this->connect();

        if (!$api instanceof SpotifyWebAPI) {
            return $api; // JSON error response from connect()
        }

        try {
            $topArtists = $api->getMyTop('artists', [
                'limit'      => 20,
                'time_range' => 'short_term',
            ]);
        } catch (\Throwable $e) {
            Log::warning('Spotify integration: getMyTop(artists) failed: ' . $e->getMessage());
            return response()->json(['radar' => [], 'tagcloud' => []]);
        }

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
            'Hip-Hop / Rap' => 0,
            'R&B / Soul'    => 0,
            'Electronic'    => 0,
            'Rock / Alt'    => 0,
            'Pop'           => 0,
            'Jazz / Blues'  => 0,
            'Latin'         => 0,
            'Other'         => 0,
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

    /**
     * Exchange the stored refresh token for a fresh access token and hand back a
     * ready-to-use API client.
     *
     * Returns a SpotifyWebAPI on success, or a JsonResponse describing the failure.
     * Nothing here is allowed to throw: a dead refresh token used to bubble up as a
     * 500, which the frontend swallowed silently and rendered as an empty music
     * section with no clue as to why.
     */
    private function connect()
    {
        $tokenData = DB::table('spotify_tokens')->find(1);

        if (!$tokenData || empty($tokenData->refresh_token)) {
            Log::warning('Spotify integration: no refresh token stored. Visit /spotify/auth to connect.');
            return response()->json([
                'error'         => 'Spotify not connected',
                'needs_reauth'  => true,
            ], 401);
        }

        $session = new Session(
            config('notch64.spotify.client_id'),
            config('notch64.spotify.client_secret'),
            config('notch64.spotify.redirect_uri')
        );

        // Use the refresh token to get a fresh access token.
        // Think of this like auto-renewing an expired parking ticket.
        try {
            $session->refreshAccessToken($tokenData->refresh_token);
        } catch (\Throwable $e) {
            // A revoked/expired refresh token (400 invalid_grant) is unrecoverable
            // without a human: Spotify kills it when the account password changes,
            // when the app's access is revoked in the Spotify account page, or when
            // an app-side credential is rotated. Only re-running the OAuth flow at
            // /spotify/auth mints a new one.
            Log::warning('Spotify integration: could not refresh the access token: ' . $e->getMessage()
                . ' — reconnect at /spotify/auth.');
            return response()->json([
                'error'        => 'Spotify token refresh failed',
                'needs_reauth' => true,
            ], 503);
        }

        $accessToken = $session->getAccessToken();

        if (empty($accessToken)) {
            Log::warning('Spotify integration: token refresh returned no access token.');
            return response()->json([
                'error'        => 'Spotify token refresh failed',
                'needs_reauth' => true,
            ], 503);
        }

        // Spotify may hand back a ROTATED refresh token on any refresh. The library
        // keeps it internally, but if we only persist the access token the new
        // refresh token is thrown away and the next refresh retries the superseded
        // one — which eventually comes back as "Refresh token revoked" and takes the
        // whole music section down until someone re-authorises by hand.
        $update = [
            'access_token' => $accessToken,
            'updated_at'   => now(),
        ];

        $rotatedRefreshToken = $session->getRefreshToken();

        if (!empty($rotatedRefreshToken) && $rotatedRefreshToken !== $tokenData->refresh_token) {
            $update['refresh_token'] = $rotatedRefreshToken;
            Log::info('Spotify integration: stored a rotated refresh token.');
        }

        DB::table('spotify_tokens')->where('id', 1)->update($update);

        $api = new SpotifyWebAPI();
        $api->setAccessToken($accessToken);

        return $api;
    }
}
