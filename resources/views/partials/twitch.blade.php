<style>
    #twitch-section {
        background: linear-gradient(to bottom, #333333, #d1d1d1);
        padding: 70px 20px;
        box-sizing: border-box;
        margin-left: -20px;
        margin-right: -20px;
        width: calc(100% + 40px);
    }

    #twitch-section .twitch-columns {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        gap: 48px;
    }

    #twitch-section .twitch-col {
        flex: 1 1 0;
        min-width: 0;
    }

    /* ── Left column ─────────────────────────────────────── */
    #twitch-section .twitch-heading {
        font-family: 'Press Start 2P', cursive;
        color: #ffffff;
        font-size: 1rem;
        line-height: 1.6;
        margin: 0 0 24px 0;
    }

    #twitch-section .twitch-desc {
        font-family: 'Press Start 2P', cursive;
        font-size: 12px;
        color: #cccccc;
        line-height: 2;
        margin: 0;
    }

    #twitch-section .twitch-divider {
        border: none;
        height: 2px;
        background-color: #6e4fa0;
        margin: 24px 0;
    }

    #twitch-section .schedule-heading {
        font-family: 'Press Start 2P', cursive;
        font-size: 14px;
        color: #c4408a;
        line-height: 1.6;
        margin: 0 0 20px 0;
    }

    #twitch-section .schedule-card {
        background-color: #1a1a1a;
        border-left: 2px solid #6e4fa0;
        padding: 14px 16px;
        margin-bottom: 12px;
    }

    #twitch-section .schedule-card__title {
        font-family: 'Press Start 2P', cursive;
        font-size: 12px;
        color: #ffffff;
        line-height: 1.8;
        margin: 0 0 6px 0;
    }

    #twitch-section .schedule-card__date {
        font-family: 'Press Start 2P', cursive;
        font-size: 11px;
        color: #c4408a;
        line-height: 1.8;
        margin: 0 0 4px 0;
    }

    #twitch-section .schedule-card__duration {
        font-family: 'Press Start 2P', cursive;
        font-size: 11px;
        color: #aaaaaa;
        line-height: 1.8;
        margin: 0;
    }

    #twitch-section .schedule-empty {
        font-family: 'Press Start 2P', cursive;
        font-size: 11px;
        color: #aaaaaa;
        line-height: 2;
    }

    /* ── Right column ────────────────────────────────────── */
    #twitch-section .on-air-row {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    #twitch-section .on-air-dot {
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background-color: #1DB954;
        flex-shrink: 0;
        animation: twitch-pulse 1.5s ease-in-out infinite;
    }

    #twitch-section .on-air-dot.offline {
        background-color: #555555;
        animation: none;
    }

    @keyframes twitch-pulse {
        0%, 100% {
            box-shadow: 0 0 0 0 rgba(29, 185, 84, 0.6);
        }
        50% {
            box-shadow: 0 0 12px 6px rgba(29, 185, 84, 0.3);
        }
    }

    #twitch-section .on-air-text {
        font-family: 'Press Start 2P', cursive;
        font-size: 15px;
        color: #ffffff;
        line-height: 1;
    }

    #twitch-section .on-air-text.offline {
        color: #aaaaaa;
    }

    #twitch-section .stream-title {
        font-family: 'Press Start 2P', cursive;
        font-size: 12px;
        color: #ffffff;
        text-align: center;
        line-height: 1.8;
        margin: 0 0 20px 0;
        display: none;
    }

    #twitch-section .twitch-embed iframe {
        width: 100%;
        height: 400px;
        border: none;
        display: block;
    }

    /* ── Responsive ──────────────────────────────────────── */
    @media only screen and (max-width: 700px) {
        #twitch-section .twitch-columns {
            flex-direction: column;
        }

        #twitch-section .twitch-col {
            width: 100%;
        }

        #twitch-section .twitch-embed iframe {
            height: 280px;
        }

        #twitch-section .on-air-text.offline {
            color: #555555;
        }
    }
</style>

<!-- Twitch Section -->
<section id="twitch-section">
    <div class="twitch-columns">

        <!-- Left: Info + Schedule -->
        <div class="twitch-col">
            <h2 class="twitch-heading">Yes, I live stream sometimes...</h2>
            <p class="twitch-desc">I stream retro games, game mods, and compose music. Join the community and watch live as I play my favorite classics, tinker with game mods, and make music!</p>
            <hr class="twitch-divider" />
            <h3 class="schedule-heading">Upcoming Streams</h3>
            <div id="twitch-schedule">
                {{-- Schedule cards injected by JS --}}
            </div>
        </div>

        <!-- Right: Live Embed -->
        <div class="twitch-col">
            <div class="on-air-row">
                <div class="on-air-dot offline" id="on-air-dot"></div>
                <span class="on-air-text offline" id="on-air-text">OFF AIR</span>
            </div>
            <p class="stream-title" id="stream-title"></p>
            <div class="twitch-embed">
                <iframe
                    src="https://player.twitch.tv/?channel=itsnotch64&parent=notch64.test"
                    allowfullscreen>
                </iframe>
            </div>
        </div>

    </div>
</section>

<script>
    $(document).ready(function () {

        /* ── Live status ─────────────────────────────────── */
        $.getJSON('/api/twitch/live-status', function (data) {
            var $dot   = $('#on-air-dot');
            var $text  = $('#on-air-text');
            var $title = $('#stream-title');

            if (data.is_live) {
                $dot.removeClass('offline');
                $text.removeClass('offline').text('ON AIR');
                if (data.title) {
                    $title.text(data.title).show();
                }
            } else {
                $dot.addClass('offline');
                $text.addClass('offline').text('OFF AIR');
                $title.hide();
            }
        });

        /* ── Schedule ────────────────────────────────────── */
        $.getJSON('/api/twitch/schedule', function (schedules) {
            var $container = $('#twitch-schedule');
            $container.empty();

            if (!schedules || schedules.length === 0) {
                $container.append(
                    $('<p></p>', {
                        'class': 'schedule-empty',
                        text: 'No streams scheduled yet. Check back soon.'
                    })
                );
                return;
            }

            var limit = Math.min(schedules.length, 5);
            for (var i = 0; i < limit; i++) {
                var s = schedules[i];

                var $card = $('<div></div>', { 'class': 'schedule-card' });

                $card.append($('<p></p>', {
                    'class': 'schedule-card__title',
                    text: s.title
                }));

                $card.append($('<p></p>', {
                    'class': 'schedule-card__date',
                    text: s.scheduled_at
                }));

                $card.append($('<p></p>', {
                    'class': 'schedule-card__duration',
                    text: s.duration_minutes + ' minutes'
                }));

                $container.append($card);
            }
        });

    });
</script>
