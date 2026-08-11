<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SteamController extends Controller
{
    /**
     * Cached header_image lookups live this long. Header art almost never changes,
     * and Steam's storefront API is rate-limited (community-documented at roughly
     * 200 requests per 5-minute window), so this must not run per page load.
     */
    private const HEADER_CACHE_TTL = 86400; // 24 hours

    /**
     * "Steam has no image for this appid" is cached far more briefly than a hit — a
     * success:false can also come from a transient hiccup or a region block, and we
     * don't want that pinning a blank card for a whole day.
     */
    private const HEADER_NONE_CACHE_TTL = 3600; // 1 hour

    /** Cache sentinel meaning "Steam says this appid has no store page / no header art". */
    private const HEADER_NONE = 'none';

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

        // Ask Steam for each game's real header image instead of guessing the CDN path.
        $headerImages = $this->resolveHeaderImages(
            collect($games)->pluck('appid')->all()
        );

        $formatted = collect($games)->map(function ($game) use ($loginWalled, $headerImages) {
            $appid = $game['appid'];

            return [
                'title'      => $game['name'],
                'cover_url'  => $this->coverUrl($appid, $headerImages),
                'steam_url'  => in_array($appid, $loginWalled)
                    ? null
                    : 'https://store.steampowered.com/app/' . $appid . '/',
                'playtime'   => round($game['playtime_2weeks'] / 60, 1) . ' hrs last 2 weeks',
            ];
        });

        return response()->json($formatted);
    }

    /**
     * Pick the cover image for one game.
     *
     * $headerImages holds one of three states per appid:
     *   - a URL string        → Steam told us the real header image; use it.
     *   - self::HEADER_NONE   → Steam explicitly has no store page for this appid, so the
     *                           legacy path is guaranteed to 404 too. Return null and let
     *                           the frontend render a deliberate placeholder.
     *   - key absent          → the lookup errored out (timeout, rate limit, bad JSON).
     *                           Fall back to the legacy flat CDN path as a best effort; it
     *                           still resolves for older, long-cached Steam titles, and the
     *                           frontend's onerror handler covers it when it doesn't.
     */
    private function coverUrl(int $appid, array $headerImages): ?string
    {
        $header = $headerImages[$appid] ?? null;

        if ($header === self::HEADER_NONE) {
            return null;
        }

        if (is_string($header) && $header !== '') {
            return $header;
        }

        return 'https://cdn.cloudflare.steamstatic.com/steam/apps/' . $appid . '/header.jpg';
    }

    /**
     * Resolve header image URLs for the given appids via Steam's public Storefront API
     * (no API key needed). Cached per appid; only cache misses hit the network, and those
     * go out concurrently so the endpoint doesn't serialize one request per game.
     *
     * @param  array<int, int>  $appids
     * @return array<int, string>  appid => URL or self::HEADER_NONE (missing key = unresolved)
     */
    private function resolveHeaderImages(array $appids): array
    {
        $resolved = [];
        $missing  = [];

        foreach (array_unique($appids) as $appid) {
            $cached = Cache::get($this->headerCacheKey($appid));

            if (is_string($cached) && $cached !== '') {
                $resolved[$appid] = $cached;
            } else {
                $missing[] = $appid;
            }
        }

        if (empty($missing)) {
            return $resolved;
        }

        try {
            $responses = Http::pool(fn ($pool) => collect($missing)->map(
                fn ($appid) => $pool->as((string) $appid)
                    ->timeout(8)
                    ->get('https://store.steampowered.com/api/appdetails', [
                        'appids'  => $appid,
                        // 'basic' trims the payload down from the full store listing
                        // (descriptions, screenshots, reviews) to just the fields we need.
                        'filters' => 'basic',
                    ])
            )->all());
        } catch (\Throwable $e) {
            Log::warning('Steam integration: appdetails pool request failed: ' . $e->getMessage());

            return $resolved;
        }

        foreach ($missing as $appid) {
            $header = $this->headerImageFrom($responses[(string) $appid] ?? null, $appid);

            if ($header === null) {
                continue;
            }

            $resolved[$appid] = $header;

            Cache::put(
                $this->headerCacheKey($appid),
                $header,
                $header === self::HEADER_NONE ? self::HEADER_NONE_CACHE_TTL : self::HEADER_CACHE_TTL
            );
        }

        return $resolved;
    }

    /**
     * Pull header_image out of a single appdetails response. Returns null when the lookup
     * itself failed (so the caller falls back rather than caching a bad verdict), or
     * self::HEADER_NONE when Steam answered but has no usable image for this appid.
     *
     * Http::pool() hands back a Throwable in place of a Response for connection-level
     * failures, so one dead lookup must not take the whole row down.
     */
    private function headerImageFrom($response, int $appid): ?string
    {
        if ($response instanceof \Throwable) {
            Log::warning("Steam integration: appdetails request for appid {$appid} failed: " . $response->getMessage());

            return null;
        }

        if ($response === null) {
            Log::warning("Steam integration: no appdetails response returned for appid {$appid}.");

            return null;
        }

        try {
            if (!$response->ok()) {
                Log::warning("Steam integration: appdetails returned a non-OK response for appid {$appid}.", [
                    'status' => $response->status(),
                ]);

                return null;
            }

            $payload = $response->json();
        } catch (\Throwable $e) {
            Log::warning("Steam integration: could not read appdetails response for appid {$appid}: " . $e->getMessage());

            return null;
        }

        $entry = $payload[(string) $appid] ?? null;

        // success:false means Steam has no public store page for this appid (delisted,
        // region-locked, or not a store item). That's an answer, not a failure.
        if (!is_array($entry) || ($entry['success'] ?? false) !== true) {
            Log::info("Steam integration: appdetails reported no store data for appid {$appid}.");

            return self::HEADER_NONE;
        }

        $header = $entry['data']['header_image'] ?? null;

        if (!is_string($header) || $header === '') {
            Log::info("Steam integration: appdetails returned no header_image for appid {$appid}.");

            return self::HEADER_NONE;
        }

        return $header;
    }

    private function headerCacheKey(int $appid): string
    {
        return "steam:header_image:{$appid}";
    }
}
