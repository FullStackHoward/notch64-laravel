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

];
