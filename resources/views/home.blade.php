<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset("img/favicon/apple-touch-icon.png")}}"/>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset("img/favicon/favicon-32x32.png")}}"/>
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset("img/favicon/favicon-16x16.png")}}"/>
    <link rel="manifest" href="{{ asset('img/favicon/site.webmanifest') }}"/>
    <link rel="mask-icon" href="{{ asset('img/favicon/safari-pinned-tab.svg') }}" color="#5bbad5"/>
    <meta name="msapplication-TileColor" content="#da532c"/>
    <meta name="theme-color" content="#ffffff"/>
    <meta name="description" content="The Wonderful Works of Notch64"/>
    <meta name="author" content="Notch64"/>
    <meta name="keywords"
          content="Notch64, Notch 64, Big Notch, Big Notch Music, Vicers, Howard.codes, Howard Codes, ItsNotch64, Notch64 Twitter, Notch64 Instagram, Notch64 Youtube, Notch64 TikTok, Notch64 Twitch, Vice Gamers, Pixelwave, #Pixelwave, Pixel Wave"/>
    <title>No, not that Notch.</title>
    <link href="{{ asset('css/ton.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/audio-player.css') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Press+Start+2P|Open+Sans"/>
    <link rel="stylesheet" href="https://use.typekit.net/fdx4wex.css"/>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-BZGFZ8DHV1"></script>
    <script>window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag("js", new Date());
        gtag("config", "G-BZGFZ8DHV1"); </script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('js/splshtxt.js') }}"></script>
    <script src="{{ asset('js/thoughts.js') }}"></script>
    <script src="{{ asset('js/audio-player.js') }}"></script>
</head>
<body>
<div id="pagecontainer"><h1 class="col"><span class="n64txt">NOTCH<sup
                style="font-weight: 600; color: #ffac63;">64</sup></span></h1><a href="#">
        <h3
            id="splash">Loading...</h3></a>
    <h2 class="col">The Wonderful Works of Notch64</h2>
    <div class="maincontain"><a class="col gaming" href="{{ config('notch64.nav.gaming') }}"><h3 class="title">GAMING</h3></a><a
            class="col music" href="{{ config('notch64.nav.music') }}"><h3 class="title">MUSIC</h3></a><a class="col dev"
                                                                                                 href="{{ config('notch64.nav.creative') }}">
            <h3 class="title">CREATIVE</h3></a></div>
    <div class="maincontain_community"><a class="col3 community" href="{{ config('notch64.nav.community') }}"><h3
                class="title">COMMUNITY</h3></a></div>
    <div class="maincontain_social"><a class="col2 bsky" href="{{ config('notch64.social.bluesky') }}"></a><a
            class="col2 ttv" href="{{ config('notch64.social.twitch') }}"></a><a class="col2 fb"
                                                                             href="{{ config('notch64.social.facebook') }}"></a><a
            class="col2 ig" href="{{ config('notch64.social.instagram') }}"></a><a class="col2 sc"
                                                                                href="{{ config('notch64.social.soundcloud') }}"></a><a
            class="col2 ttok" href="{{ config('notch64.social.tiktok') }}"></a><a class="col2 dsc"
                                                                               href="{{ config('notch64.social.discord') }}"></a><a
            class="col2 yt" href="{{ config('notch64.social.youtube') }}"></a></div>
    @include('partials.audio-player')
</div>

@include('partials.thoughts')
@include('partials.spotify')
@include('partials.spotify-genres')
<footer>webpage by <a class="howco-gradient-wipe" href="https://howard.codes">fullstackhoward</a></footer>

</body>
</html>
