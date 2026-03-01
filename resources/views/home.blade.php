<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>

    {{-- Favicon --}}
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/favicon/apple-touch-icon.png') }}"/>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}"/>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon/favicon-16x16.png') }}"/>
    <link rel="manifest" href="{{ asset('img/favicon/site.webmanifest') }}"/>
    <link rel="mask-icon" href="{{ asset('img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5"/>
    <meta name="msapplication-TileColor" content="#da532c"/>
    <meta name="theme-color" content="#333333"/>
    <link rel="canonical" href="https://notch64.com"/>

    {{-- Primary SEO --}}
    <title>Notch64 | Retro Gamer, Music Maker & Community Builder</title>
    <meta name="description" content="Notch64 is a retro gamer, music producer, streamer, and community builder. Explore gaming, original music, live streams, and join the Vicers community."/>
    <meta name="author" content="Notch64"/>
    <meta name="keywords" content="Notch64, ItsNotch64, retro gaming, game modding, music producer, Notch64 Music, Twitch streamer, Vice Gamers, Vicers, pixelwave, emulation, community"/>
    <meta name="robots" content="index, follow"/>

    {{-- Open Graph (Facebook, Discord, LinkedIn) --}}
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://notch64.com"/>
    <meta property="og:title" content="Notch64 | Retro Gamer, Music Maker & Community Builder"/>
    <meta property="og:description" content="Notch64 is a retro gamer, music producer, streamer, and community builder. Explore gaming, original music, live streams, and join the Vicers community."/>
    <meta property="og:image" content="{{ asset('img/og-image.png') }}"/>
    <meta property="og:image:width" content="1200"/>
    <meta property="og:image:height" content="630"/>
    <meta property="og:site_name" content="Notch64"/>

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image"/>
    <meta name="twitter:site" content="@itsnotch64"/>
    <meta name="twitter:creator" content="@itsnotch64"/>
    <meta name="twitter:title" content="Notch64 | Retro Gamer, Music Maker & Community Builder"/>
    <meta name="twitter:description" content="Notch64 is a retro gamer, music producer, streamer, and community builder. Explore gaming, original music, live streams, and join the Vicers community."/>
    <meta name="twitter:image" content="{{ asset('img/og-image.png') }}"/>

    {{-- Structured Data --}}
    @verbatim
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
  "@type": "Person",
  "name": "Notch64",
  "alternateName": "ItsNotch64",
  "url": "https://notch64.com",
  "sameAs": [
    "https://www.twitch.tv/itsnotch64",
    "https://www.youtube.com/@notch64",
    "https://www.instagram.com/itsnotch64",
    "https://www.tiktok.com/@itsnotch64",
    "https://bsky.app/profile/notch64.bsky.social",
    "https://www.bignotch.com"
  ],
  "description": "Retro gamer, music producer, streamer, and community builder.",
  "knowsAbout": [
    "Retro Gaming",
    "Game Modding",
    "Music Production",
    "Live Streaming",
    "Community Building"
  ]
}
    </script>
    @endverbatim

    {{-- Styles --}}
    <link href="{{ asset('css/ton.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/audio-player.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Press+Start+2P|Open+Sans"/>
    <link rel="stylesheet" href="https://use.typekit.net/fdx4wex.css"/>

    {{-- Analytics --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-BZGFZ8DHV1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() { dataLayer.push(arguments); }
        gtag("js", new Date());
        gtag("config", "G-BZGFZ8DHV1");
    </script>

    {{-- Scripts --}}
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/splshtxt.js') }}"></script>
    <script src="{{ asset('js/thoughts.js') }}"></script>
    <script src="{{ asset('js/audio-player.js') }}"></script>
</head>
<body>

@include('partials.nav-overlay')
@include('partials.links')
@include('partials.thoughts')
@include('partials.spotify')
@include('partials.spotify-genres')
@include('partials.gaming')
@include('partials.platform-stats')
@include('partials.twitch')
@include('partials.footer')

</body>
</html>
