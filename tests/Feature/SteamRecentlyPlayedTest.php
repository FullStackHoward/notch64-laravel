<?php

namespace Tests\Feature;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SteamRecentlyPlayedTest extends TestCase
{
    private const RECENTLY_PLAYED = 'api.steampowered.com/IPlayerService/GetRecentlyPlayedGames/*';
    private const APPDETAILS      = 'store.steampowered.com/api/appdetails*';

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'notch64.steam.api_key'  => 'test-key',
            'notch64.steam.steam_id' => '76561190000000000',
        ]);

        Cache::flush();
    }

    private function fakeRecentlyPlayed(array $games): array
    {
        return [
            self::RECENTLY_PLAYED => Http::response(['response' => ['games' => $games]]),
        ];
    }

    private function game(int $appid, string $name = 'Test Game'): array
    {
        return ['appid' => $appid, 'name' => $name, 'playtime_2weeks' => 66];
    }

    public function test_it_uses_the_header_image_returned_by_appdetails(): void
    {
        $header = 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/4067130/abc123/header.jpg?t=1';

        Http::fake($this->fakeRecentlyPlayed([$this->game(4067130, 'Drifter Star: Evolution')]) + [
            self::APPDETAILS => Http::response([
                '4067130' => ['success' => true, 'data' => ['header_image' => $header]],
            ]),
        ]);

        $this->getJson('/api/steam/recently-played')
            ->assertOk()
            ->assertJsonPath('0.title', 'Drifter Star: Evolution')
            ->assertJsonPath('0.cover_url', $header)
            ->assertJsonPath('0.playtime', '1.1 hrs last 2 weeks');
    }

    public function test_it_caches_the_header_image_and_skips_repeat_appdetails_calls(): void
    {
        $header = 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/438100/header.jpg?t=2';

        Http::fake($this->fakeRecentlyPlayed([$this->game(438100, 'VRChat')]) + [
            self::APPDETAILS => Http::response([
                '438100' => ['success' => true, 'data' => ['header_image' => $header]],
            ]),
        ]);

        $this->getJson('/api/steam/recently-played')->assertJsonPath('0.cover_url', $header);
        $this->getJson('/api/steam/recently-played')->assertJsonPath('0.cover_url', $header);

        // Two page loads, one storefront lookup — the point of the cache.
        Http::assertSentCount(3);
    }

    public function test_it_falls_back_to_the_legacy_cdn_path_when_appdetails_connection_fails(): void
    {
        Http::fake($this->fakeRecentlyPlayed([$this->game(252950, 'Rocket League')]) + [
            self::APPDETAILS => fn () => throw new ConnectionException('simulated timeout'),
        ]);

        $this->getJson('/api/steam/recently-played')->assertJsonPath(
            '0.cover_url',
            'https://cdn.cloudflare.steamstatic.com/steam/apps/252950/header.jpg'
        );

        // A failed lookup must not be cached, or one blip would stick for 24 hours.
        $this->assertFalse(Cache::has('steam:header_image:252950'));
    }

    public function test_it_falls_back_to_the_legacy_cdn_path_when_appdetails_is_rate_limited(): void
    {
        Http::fake($this->fakeRecentlyPlayed([$this->game(252950, 'Rocket League')]) + [
            self::APPDETAILS => Http::response('', 429),
        ]);

        $this->getJson('/api/steam/recently-played')->assertJsonPath(
            '0.cover_url',
            'https://cdn.cloudflare.steamstatic.com/steam/apps/252950/header.jpg'
        );

        $this->assertFalse(Cache::has('steam:header_image:252950'));
    }

    public function test_it_returns_a_null_cover_url_when_steam_has_no_store_data(): void
    {
        Http::fake($this->fakeRecentlyPlayed([$this->game(999999999, 'Delisted Game')]) + [
            self::APPDETAILS => Http::response(['999999999' => ['success' => false]]),
        ]);

        // success:false means the legacy path is guaranteed to 404 too, so send null and
        // let the frontend render a deliberate placeholder instead of a broken <img>.
        $this->getJson('/api/steam/recently-played')
            ->assertOk()
            ->assertJsonPath('0.cover_url', null)
            ->assertJsonPath('0.title', 'Delisted Game');
    }

    public function test_it_returns_a_null_cover_url_when_appdetails_omits_the_header_image(): void
    {
        Http::fake($this->fakeRecentlyPlayed([$this->game(123456, 'No Art Game')]) + [
            self::APPDETAILS => Http::response([
                '123456' => ['success' => true, 'data' => ['name' => 'No Art Game']],
            ]),
        ]);

        $this->getJson('/api/steam/recently-played')->assertJsonPath('0.cover_url', null);
    }

    public function test_one_failed_lookup_does_not_break_the_other_games(): void
    {
        $good = 'https://shared.akamai.steamstatic.com/store_item_assets/steam/apps/438100/header.jpg?t=3';

        Http::fake($this->fakeRecentlyPlayed([
            $this->game(438100, 'VRChat'),
            $this->game(999999999, 'Delisted Game'),
            $this->game(252950, 'Rocket League'),
        ]) + [
            self::APPDETAILS => function ($request) use ($good) {
                $appid = $request->data()['appids'] ?? null;

                return match ((int) $appid) {
                    438100    => Http::response(['438100' => ['success' => true, 'data' => ['header_image' => $good]]]),
                    999999999 => Http::response(['999999999' => ['success' => false]]),
                    default   => throw new ConnectionException('simulated timeout'),
                };
            },
        ]);

        $this->getJson('/api/steam/recently-played')
            ->assertOk()
            ->assertJsonCount(3)
            ->assertJsonPath('0.cover_url', $good)
            ->assertJsonPath('1.cover_url', null)
            ->assertJsonPath('2.cover_url', 'https://cdn.cloudflare.steamstatic.com/steam/apps/252950/header.jpg');
    }

    public function test_it_skips_appdetails_entirely_when_there_are_no_recent_games(): void
    {
        Http::fake($this->fakeRecentlyPlayed([]));

        $this->getJson('/api/steam/recently-played')->assertOk()->assertExactJson([]);

        Http::assertSentCount(1);
    }

    public function test_it_returns_an_empty_list_when_credentials_are_missing(): void
    {
        config(['notch64.steam.api_key' => null]);
        Http::fake();

        $this->getJson('/api/steam/recently-played')->assertOk()->assertExactJson([]);

        Http::assertNothingSent();
    }
}
