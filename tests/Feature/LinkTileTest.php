<?php

namespace Tests\Feature;

use App\Filament\Resources\CommunityTileResource;
use App\Filament\Resources\MainTileResource;
use App\Filament\Resources\SocialIconResource;
use App\Models\LinkTile;
use App\Models\User;
use Database\Seeders\LinkTileSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LinkTileTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_homepage_renders_every_active_tile_in_order(): void
    {
        $this->seed(LinkTileSeeder::class);

        $response = $this->get('/');

        $response->assertStatus(200);

        // Order matters: sort_order drives the on-page order.
        $response->assertSeeInOrder(['GAMING', 'MUSIC', 'CREATIVE', 'COMMUNITY'], escape: false);

        foreach (LinkTile::active()->get() as $tile) {
            $response->assertSee($tile->url, escape: false);
        }

        $response->assertSee('--tile-count: 8', escape: false);
    }

    public function test_an_inactive_tile_is_not_rendered(): void
    {
        $this->seed(LinkTileSeeder::class);

        LinkTile::where('title', 'CREATIVE')->update(['active' => false]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('>CREATIVE<', escape: false);
        $response->assertSee('GAMING', escape: false);
    }

    public function test_an_empty_section_renders_no_container(): void
    {
        $this->seed(LinkTileSeeder::class);

        LinkTile::section(LinkTile::SECTION_SOCIAL)->update(['active' => false]);

        $response = $this->get('/');

        $response->assertStatus(200);
        // The wrapper is dropped entirely rather than leaving a 300px void.
        $response->assertDontSee('maincontain_social', escape: false);
        $response->assertSee('maincontain_community', escape: false);
    }

    public function test_style_vars_only_emit_properties_that_have_values(): void
    {
        $tile = LinkTile::create([
            'section' => LinkTile::SECTION_MAIN,
            'title' => 'PLAIN',
            'url' => 'https://example.com',
            'bg_color' => '#123456',
        ]);

        $this->assertSame('--tile-color:#123456', $tile->styleVars());
    }

    public function test_style_vars_reject_characters_that_would_break_out_of_the_attribute(): void
    {
        $tile = LinkTile::create([
            'section' => LinkTile::SECTION_MAIN,
            'title' => 'NASTY',
            'url' => 'https://example.com',
            'bg_color' => '#fff;background-image:url(https://evil.test/x.png)',
            'bg_position' => 'center"onload="alert(1)',
        ]);

        $style = $tile->styleVars();

        /*
         * The payload is not removed, it is defanged: every character that
         * could terminate the attribute, start a second declaration or rebuild
         * a url() is stripped, so what is left is an inert (if nonsensical)
         * value. Assert those properties rather than the exact mangled string.
         */
        foreach (['"', "'", '(', ')', '<', '>', '/'] as $dangerous) {
            $this->assertStringNotContainsString($dangerous, $style);
        }

        $declarations = explode(';', $style);

        $this->assertCount(2, $declarations);

        foreach ($declarations as $declaration) {
            $this->assertSame(1, substr_count($declaration, ':'));
        }
    }

    public function test_each_resource_only_sees_its_own_section(): void
    {
        $this->seed(LinkTileSeeder::class);

        $this->assertSame(3, MainTileResource::getEloquentQuery()->count());
        $this->assertSame(1, CommunityTileResource::getEloquentQuery()->count());
        $this->assertSame(8, SocialIconResource::getEloquentQuery()->count());
    }

    public function test_the_admin_can_reach_each_link_resource(): void
    {
        $this->seed(LinkTileSeeder::class);

        $this->actingAs(User::factory()->create());

        foreach (['main', 'community', 'social'] as $section) {
            $this->get("/admin/link-tiles/{$section}")->assertStatus(200);
            $this->get("/admin/link-tiles/{$section}/create")->assertStatus(200);
        }

        $tile = LinkTile::section(LinkTile::SECTION_MAIN)->first();
        $this->get("/admin/link-tiles/main/{$tile->id}/edit")->assertStatus(200);
    }
}
