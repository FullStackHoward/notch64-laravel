<div id="pagecontainer">
    <h1 class="col"><span class="n64txt">NOTCH<sup style="font-weight: 600; color: #ffac63;">64</sup></span></h1>
    <a href="#"><h3 id="splash">Loading...</h3></a>
    <h2 class="col">The Wonderful Works of Notch64</h2>
    <div class="maincontain">
        <a class="col gaming" href="{{ config('notch64.nav.gaming') }}"><h3 class="title">GAMING</h3></a>
        <a class="col music" href="{{ config('notch64.nav.music') }}"><h3 class="title">MUSIC</h3></a>
        <a class="col dev" href="{{ config('notch64.nav.creative') }}"><h3 class="title">CREATIVE</h3></a>
    </div>
    <div class="maincontain_community">
        <a class="col3 community" href="{{ config('notch64.nav.community') }}"><h3 class="title">COMMUNITY</h3></a>
    </div>
    <div class="maincontain_social">
        <a class="col2 bsky"  href="{{ config('notch64.social.bluesky') }}"></a>
        <a class="col2 ttv"   href="{{ config('notch64.social.twitch') }}"></a>
        <a class="col2 fb"    href="{{ config('notch64.social.facebook') }}"></a>
        <a class="col2 ig"    href="{{ config('notch64.social.instagram') }}"></a>
        <a class="col2 sc"    href="{{ config('notch64.social.soundcloud') }}"></a>
        <a class="col2 ttok"  href="{{ config('notch64.social.tiktok') }}"></a>
        <a class="col2 dsc"   href="{{ config('notch64.social.discord') }}"></a>
        <a class="col2 yt"    href="{{ config('notch64.social.youtube') }}"></a>
    </div>
    @include('partials.audio-player')
</div>
