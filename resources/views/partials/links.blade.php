<div id="pagecontainer">
    <h1 class="col"><span class="n64txt">NOTCH<sup style="font-weight: 600; color: #ffac63;">64</sup></span></h1>
    <a href="#"><h3 id="splash">Loading...</h3></a>
    <h2 class="col">Retro Gamer. Music Maker. Community Architect.</h2>

    {{--
        The three link rows are driven by the link_tiles table (Filament:
        Links > Main Tiles / Community Tiles / Social Icons). Each row's
        columns are sized by flex, so adding or removing a tile rescales the
        row on its own. Appearance travels as CSS variables on each anchor;
        the shared .col / .col2 / .col3 rules in ton.css consume them.
    --}}

    @if ($mainTiles->isNotEmpty())
        <div class="maincontain">
            @foreach ($mainTiles as $tile)
                <a class="col"
                   href="{{ $tile->url }}"
                   style="{{ $tile->styleVars() }}"
                   @if ($tile->open_in_new_tab) target="_blank" rel="noopener noreferrer" @endif>
                    <h3 class="title">{{ $tile->title }}</h3>
                </a>
            @endforeach
        </div>
    @endif

    @if ($communityTiles->isNotEmpty())
        <div class="maincontain_community">
            @foreach ($communityTiles as $tile)
                <a class="col3"
                   href="{{ $tile->url }}"
                   style="{{ $tile->styleVars() }}"
                   @if ($tile->open_in_new_tab) target="_blank" rel="noopener noreferrer" @endif>
                    <h3 class="title">{{ $tile->title }}</h3>
                </a>
            @endforeach
        </div>
    @endif

    @if ($socialTiles->isNotEmpty())
        {{-- --tile-count drives the square icons' width so any number of them stays centred and evenly spaced. --}}
        <div class="maincontain_social" style="--tile-count: {{ $socialTiles->count() }}">
            @foreach ($socialTiles as $tile)
                <a class="col2"
                   href="{{ $tile->url }}"
                   style="{{ $tile->styleVars() }}"
                   @if ($tile->title) aria-label="{{ $tile->title }}" @endif
                   @if ($tile->open_in_new_tab) target="_blank" rel="noopener noreferrer" @endif></a>
            @endforeach
        </div>
    @endif

    @include('partials.audio-player')
</div>
