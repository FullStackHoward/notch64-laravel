<?php

namespace Database\Seeders;

use App\Models\LinkTile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

/**
 * Seeds the link rows with exactly what the hardcoded markup and ton.css
 * rendered before they became database-driven. Values transcribed from the
 * per-tile CSS blocks that this change removed.
 *
 * Safe to re-run: rows are keyed on section + sort_order.
 */
class LinkTileSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->tiles() as $tile) {
            $this->copyImage($tile['image_path']);

            LinkTile::updateOrCreate(
                ['section' => $tile['section'], 'sort_order' => $tile['sort_order']],
                $tile,
            );
        }
    }

    /**
     * The originals live in public/img and are still referenced by other
     * partials, so they are copied (not moved) into the public disk. Every
     * tile image then resolves through one path, whether it shipped with the
     * site or was uploaded in Filament later.
     */
    private function copyImage(?string $path): void
    {
        if ($path === null) {
            return;
        }

        $source = public_path('img/'.basename($path));

        if (! File::exists($source)) {
            $this->command?->warn("LinkTileSeeder: missing source image {$source}");

            return;
        }

        Storage::disk('public')->makeDirectory('tiles');
        File::copy($source, Storage::disk('public')->path($path), true);
    }

    private function tiles(): array
    {
        return [
            // ---- Row 1: main tiles (was .gaming / .music / .dev) ----
            [
                'section' => LinkTile::SECTION_MAIN,
                'sort_order' => 1,
                'title' => 'GAMING',
                'url' => 'https://www.vicegamers.com',
                'image_path' => 'tiles/gamebg.gif',
                'bg_color' => '#d836eb',
                'bg_position' => 'top left',
                'bg_size' => 'cover',
                'bg_position_mobile' => 'right',
                'bg_size_mobile' => null,
                'open_in_new_tab' => false,
                'active' => true,
            ],
            [
                'section' => LinkTile::SECTION_MAIN,
                'sort_order' => 2,
                'title' => 'MUSIC',
                'url' => 'https://www.bignotch.com',
                'image_path' => 'tiles/musicbg.gif',
                'bg_color' => '#0000ff',
                'bg_position' => 'top left',
                'bg_size' => 'cover',
                'bg_position_mobile' => 'center',
                'bg_size_mobile' => null,
                'open_in_new_tab' => false,
                'active' => true,
            ],
            [
                'section' => LinkTile::SECTION_MAIN,
                'sort_order' => 3,
                'title' => 'CREATIVE',
                'url' => 'https://www.vicecreators.com',
                'image_path' => 'tiles/devbg.gif',
                'bg_color' => '#00ff00',
                'bg_position' => 'top left',
                'bg_size' => 'cover',
                'bg_position_mobile' => 'center',
                'bg_size_mobile' => null,
                'open_in_new_tab' => false,
                'active' => true,
            ],

            // ---- Row 2: community (was .community) ----
            [
                'section' => LinkTile::SECTION_COMMUNITY,
                'sort_order' => 1,
                'title' => 'COMMUNITY',
                'url' => 'https://www.vicers.net',
                'image_path' => 'tiles/community.gif',
                'bg_color' => '#40f6ff',
                'bg_position' => 'center',
                'bg_size' => '80%',
                'bg_position_mobile' => null,
                'bg_size_mobile' => '70%',
                'open_in_new_tab' => false,
                'active' => true,
            ],

            /*
             * ---- Row 3: social icons ----
             * The old CSS carried a mobile background-size in ems for each icon
             * (5em, 8em, 12em …). Those existed only to compensate for the
             * stretched non-square tiles; now that the icons are square the
             * percentage sizes below scale correctly at every width, so no
             * mobile override is seeded.
             */
            ...$this->socialTiles(),
        ];
    }

    private function socialTiles(): array
    {
        $socials = [
            ['Bluesky', 'https://bsky.app/profile/notch64.bsky.social', 'bsky.png', '#ffffff', '80% auto'],
            ['Twitch', 'https://www.twitch.com/itsnotch64', 'ttv.gif', '#dfd0ea', '100% auto'],
            ['Facebook', 'https://www.facebook.com/itsnotch64', 'fb.png', '#009bd1', 'cover'],
            ['Instagram', 'https://www.instagram.com/itsnotch64/', 'ig.png', '#d62976', '50% auto'],
            ['SoundCloud', 'https://www.soundcloud.com/notch64', 'sc.png', '#d8d3d3', '130%'],
            // .ttok set `background: #c4c4c4` then `background-color: #000`
            // later in the same block, so black is the colour that actually won.
            ['TikTok', 'https://www.tiktok.com/@itsnotch64', 'ttok.png', '#000000', '70%'],
            ['Discord', 'https://discordapp.com/users/80760379319259136', 'discord.png', '#6b87c8', '100% auto'],
            ['YouTube', 'https://www.youtube.com/@notch64', 'yt.png', '#ff4040', '50% auto'],
        ];

        return collect($socials)
            ->map(fn (array $social, int $index) => [
                'section' => LinkTile::SECTION_SOCIAL,
                'sort_order' => $index + 1,
                'title' => $social[0],
                'url' => $social[1],
                'image_path' => 'tiles/'.$social[2],
                'bg_color' => $social[3],
                'bg_position' => 'center',
                'bg_size' => $social[4],
                'bg_position_mobile' => null,
                'bg_size_mobile' => null,
                'open_in_new_tab' => false,
                'active' => true,
            ])
            ->all();
    }
}
