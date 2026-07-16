<?php

return [

    'nav' => [
        'gaming'    => 'https://www.vicegamers.com',
        'music'     => 'https://www.bignotch.com',
        'creative'  => 'https://www.vicecreators.com',
        'community' => 'https://www.vicers.net',
        'patreon'   => 'https://www.patreon.com/Notch64',
    ],

    'social' => [
        'bluesky'   => 'https://bsky.app/profile/notch64.bsky.social',
        'twitch'    => 'https://www.twitch.com/itsnotch64',
        'facebook'  => 'https://www.facebook.com/itsnotch64',
        'instagram' => 'https://www.instagram.com/itsnotch64/',
        'soundcloud'=> 'https://www.soundcloud.com/notch64',
        'tiktok'    => 'https://www.tiktok.com/@itsnotch64',
        'discord'   => 'https://discordapp.com/users/80760379319259136',
        'youtube'   => 'https://www.youtube.com/@notch64',
    ],

    'spotify' => [
        'client_id'     => env('SPOTIFY_CLIENT_ID'),
        'client_secret' => env('SPOTIFY_CLIENT_SECRET'),
        'redirect_uri'  => env('SPOTIFY_REDIRECT_URI'),
    ],

    'steam' => [
        /*
         * Read Steam credentials through config (NOT env() directly in the controller):
         * once production runs `php artisan config:cache`, env() returns null outside
         * config files, which silently blanks the Steam row. Config files are the one
         * place env() is safe to call — this mirrors how the 'spotify' block works.
         */
        'api_key'  => env('STEAM_API_KEY'),
        'steam_id' => env('STEAM_ID'),

        /*
         * Steam appids whose store page sits behind a REAL login wall (not just an
         * age/birthdate gate — those are still publicly viewable and should NOT be
         * listed here). Steam cards for these games render without an outbound link.
         *
         * This is a manual, per-game list on purpose. When a new game appears in the
         * currently-playing feed, open its store page in a logged-out/private window;
         * only if it demands a Steam sign-in, add its appid below.
         */
        'login_walled_appids' => [
            // e.g. 123456,
        ],
    ],

    'twitch' => [
        // Read through config for the same config:cache reason as the 'steam' block.
        'client_id'     => env('TWITCH_CLIENT_ID'),
        'client_secret' => env('TWITCH_CLIENT_SECRET'),
    ],

];
