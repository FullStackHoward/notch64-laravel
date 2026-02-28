<style>
    #gaming-section {
        background: linear-gradient(to bottom, #000000, #333333);
        padding: 70px 20px;
        box-sizing: border-box;
        margin-left: -20px;
        margin-right: -20px;
        width: calc(100% + 40px);
    }

    /* ── Shared headings ─────────────────────────────────────── */
    #gaming-section .gaming-heading {
        font-family: 'Press Start 2P', cursive;
        color: #ffffff;
        text-align: center;
        font-size: 1rem;
        line-height: 1.6;
        margin: 0 0 36px 0;
    }

    /* ── Steam Recently Played ───────────────────────────────── */
    #gaming-section .steam-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: flex-start;
        gap: 20px;
        margin-bottom: 72px;
    }

    #gaming-section .steam-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: #1a1a1a;
        border: 2px solid #B7B7B7;
        padding: 10px;
        width: 200px;
        text-decoration: none;
        cursor: pointer;
        box-sizing: border-box;
        transition: opacity 0.2s;
    }

    #gaming-section .steam-card:hover {
        opacity: 0.8;
    }

    #gaming-section .steam-card__cover {
        width: 100%;
        height: auto;
        display: block;
        margin-bottom: 10px;
    }

    #gaming-section .steam-card__placeholder {
        width: 100%;
        height: 94px;
        background-color: #000000;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        margin-bottom: 10px;
        box-sizing: border-box;
    }

    #gaming-section .steam-card__title {
        font-family: 'Press Start 2P', cursive;
        color: #ffffff;
        font-size: 7px;
        text-align: center;
        line-height: 1.6;
        margin: 0 0 6px 0;
        width: 100%;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    #gaming-section .steam-card__playtime {
        font-family: 'Press Start 2P', cursive;
        color: #888888;
        font-size: 6px;
        text-align: center;
        line-height: 1.6;
        margin: 0;
    }

    /* ── Platform filter buttons ─────────────────────────────── */
    #gaming-section .filter-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        margin-bottom: 36px;
    }

    #gaming-section .filter-btn {
        font-family: 'Press Start 2P', cursive;
        font-size: 7px;
        background-color: #1a1a1a;
        color: #ffffff;
        border: 2px solid;
        padding: 8px 12px;
        cursor: pointer;
        line-height: 1.4;
        transition: background-color 0.15s, color 0.15s;
    }

    #gaming-section .filter-btn[data-platform="All"]          { border-color: #6e4fa0; }
    #gaming-section .filter-btn[data-platform="PlayStation"]  { border-color: #3A88E4; }
    #gaming-section .filter-btn[data-platform="Xbox"]         { border-color: #8CCB3A; }
    #gaming-section .filter-btn[data-platform="Nintendo"]     { border-color: #E94E4E; }
    #gaming-section .filter-btn[data-platform="Steam"]        { border-color: #B7B7B7; }
    #gaming-section .filter-btn[data-platform="Apple Arcade"] { border-color: #A25CC9; }
    #gaming-section .filter-btn[data-platform="Android"]      { border-color: #FFC700; }
    #gaming-section .filter-btn[data-platform="Other"]        { border-color: #c4408a; }

    #gaming-section .filter-btn.active[data-platform="All"]          { background-color: #6e4fa0; }
    #gaming-section .filter-btn.active[data-platform="PlayStation"]  { background-color: #3A88E4; }
    #gaming-section .filter-btn.active[data-platform="Xbox"]         { background-color: #8CCB3A; color: #000000; }
    #gaming-section .filter-btn.active[data-platform="Nintendo"]     { background-color: #E94E4E; }
    #gaming-section .filter-btn.active[data-platform="Steam"]        { background-color: #B7B7B7; color: #000000; }
    #gaming-section .filter-btn.active[data-platform="Apple Arcade"] { background-color: #A25CC9; }
    #gaming-section .filter-btn.active[data-platform="Android"]      { background-color: #FFC700; color: #000000; }
    #gaming-section .filter-btn.active[data-platform="Other"]        { background-color: #c4408a; }

    /* ── CMS game card grid ──────────────────────────────────── */
    #gaming-section .library-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    #gaming-section .game-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: #1a1a1a;
        border: 3px solid;
        padding: 10px;
        width: 160px;
        box-sizing: border-box;
        transition: opacity 0.2s;
    }

    #gaming-section .game-card:hover {
        opacity: 0.8;
    }

    #gaming-section .game-card[data-platform="PlayStation"] { border-color: #3A88E4; }
    #gaming-section .game-card[data-platform="Xbox"]        { border-color: #8CCB3A; }
    #gaming-section .game-card[data-platform="Nintendo"]    { border-color: #E94E4E; }
    #gaming-section .game-card[data-platform="Steam"]       { border-color: #B7B7B7; }
    #gaming-section .game-card[data-platform="Apple Arcade"]{ border-color: #A25CC9; }
    #gaming-section .game-card[data-platform="Android"]     { border-color: #FFC700; }
    #gaming-section .game-card[data-platform="Other"]       { border-color: #c4408a; }

    #gaming-section .game-card__cover {
        width: 100%;
        height: auto;
        display: block;
        margin-bottom: 8px;
    }

    #gaming-section .game-card__placeholder {
        width: 100%;
        height: 80px;
        background-color: #000000;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-bottom: 8px;
        box-sizing: border-box;
    }

    #gaming-section .game-card__title {
        font-family: 'Press Start 2P', cursive;
        color: #ffffff;
        font-size: 7px;
        text-align: center;
        line-height: 1.6;
        margin: 0 0 8px 0;
        width: 100%;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    #gaming-section .game-card__badge {
        font-family: 'Press Start 2P', cursive;
        font-size: 6px;
        padding: 3px 8px;
        border-radius: 999px;
        color: #000000;
        line-height: 1.4;
        margin-top: auto;
    }

    #gaming-section .game-card__badge[data-platform="PlayStation"] { background-color: #3A88E4; }
    #gaming-section .game-card__badge[data-platform="Xbox"]        { background-color: #8CCB3A; }
    #gaming-section .game-card__badge[data-platform="Nintendo"]    { background-color: #E94E4E; color: #ffffff; }
    #gaming-section .game-card__badge[data-platform="Steam"]       { background-color: #B7B7B7; }
    #gaming-section .game-card__badge[data-platform="Apple Arcade"]{ background-color: #A25CC9; color: #ffffff; }
    #gaming-section .game-card__badge[data-platform="Android"]     { background-color: #FFC700; }
    #gaming-section .game-card__badge[data-platform="Other"]       { background-color: #c4408a; color: #ffffff; }

    /* ── Responsive ──────────────────────────────────────────── */
    @media only screen and (max-width: 600px) {
        #gaming-section .gaming-heading {
            font-size: 0.6rem;
        }

        #gaming-section .steam-card {
            width: 160px;
        }

        #gaming-section .game-card {
            width: 140px;
        }
    }
</style>

<!-- Gaming Section -->
<section id="gaming-section">

    <!-- Steam Recently Played -->
    <h2 class="gaming-heading">What I'm currently playing...</h2>
    <div class="steam-row" id="steam-row">
        {{-- Steam cards injected by JS --}}
    </div>

    <!-- CMS Full Library -->
    <h2 class="gaming-heading">Here are other games I play sometimes...</h2>
    <div class="filter-row" id="filter-row">
        {{-- Filter buttons injected by JS --}}
    </div>
    <div class="library-grid" id="library-grid">
        {{-- Game cards injected by JS --}}
    </div>

</section>

<script>
    $(document).ready(function () {

        var PLATFORM_COLORS = {
            'All':           '#6e4fa0',
            'PlayStation':   '#3A88E4',
            'Xbox':          '#8CCB3A',
            'Nintendo':      '#E94E4E',
            'Steam':         '#B7B7B7',
            'Apple Arcade':  '#A25CC9',
            'Android':       '#FFC700',
            'Other':         '#c4408a'
        };

        /* ── Steam Recently Played ─────────────────────────── */
        $.getJSON('/api/steam/recently-played', function (games) {
            var $row = $('#steam-row');
            $row.empty();

            if (!games || games.length === 0) return;

            var limit = Math.min(games.length, 5);
            for (var i = 0; i < limit; i++) {
                var game = games[i];

                var $card = $('<a></a>', {
                    href: game.url || '#',
                    target: '_blank',
                    rel: 'noopener noreferrer',
                    'class': 'steam-card'
                });

                if (game.cover_url) {
                    $card.append($('<img />', {
                        src: game.cover_url,
                        alt: game.title || '',
                        'class': 'steam-card__cover'
                    }));
                } else {
                    $card.append($('<div></div>', { 'class': 'steam-card__placeholder' }).text('🎮'));
                }

                $card.append($('<p></p>', {
                    'class': 'steam-card__title',
                    text: game.title || 'Unknown'
                }));

                if (game.playtime) {
                    $card.append($('<p></p>', {
                        'class': 'steam-card__playtime',
                        text: game.playtime
                    }));
                }

                $row.append($card);
            }
        });

        /* ── CMS Library + Filter ──────────────────────────── */
        $.getJSON('/api/currently-playing', function (games) {
            if (!games || games.length === 0) return;

            var $filterRow  = $('#filter-row');
            var $grid       = $('#library-grid');
            var platforms   = ['All'];

            // collect unique platforms in order of appearance
            $.each(games, function (i, game) {
                var p = game.platform || 'Other';
                if ($.inArray(p, platforms) === -1) platforms.push(p);
            });

            // build filter buttons
            $.each(platforms, function (i, platform) {
                var $btn = $('<button></button>', {
                    'class': 'filter-btn' + (platform === 'All' ? ' active' : ''),
                    'data-platform': platform,
                    text: platform
                });
                $filterRow.append($btn);
            });

            // build game cards
            $.each(games, function (i, game) {
                var platform = game.platform || 'Other';

                var $card = $('<div></div>', {
                    'class': 'game-card',
                    'data-platform': platform
                });

                if (game.cover_url) {
                    $card.append($('<img />', {
                        src: game.cover_url,
                        alt: game.title || '',
                        'class': 'game-card__cover'
                    }));
                } else {
                    $card.append($('<div></div>', { 'class': 'game-card__placeholder' }).text('🕹️'));
                }

                $card.append($('<p></p>', {
                    'class': 'game-card__title',
                    text: game.title || 'Unknown'
                }));

                $card.append($('<span></span>', {
                    'class': 'game-card__badge',
                    'data-platform': platform,
                    text: platform
                }));

                $grid.append($card);
            });

            // filter logic
            $filterRow.on('click', '.filter-btn', function () {
                var selected = $(this).data('platform');

                $filterRow.find('.filter-btn').removeClass('active');
                $(this).addClass('active');

                if (selected === 'All') {
                    $grid.find('.game-card').show();
                } else {
                    $grid.find('.game-card').each(function () {
                        if ($(this).data('platform') === selected) {
                            $(this).show();
                        } else {
                            $(this).hide();
                        }
                    });
                }
            });
        });

    });
</script>
