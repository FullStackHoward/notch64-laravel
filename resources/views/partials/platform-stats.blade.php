<style>
    #platform-stats-section {
        background-color: #333333;
        padding: 70px 20px;
        box-sizing: border-box;
        margin-left: -20px;
        margin-right: -20px;
        width: calc(100% + 40px);
    }

    #platform-stats-section .ps-heading {
        font-family: 'Press Start 2P', cursive;
        color: #ffffff;
        text-align: center;
        font-size: 1rem;
        line-height: 1.6;
        margin: 0 0 48px 0;
    }

    #platform-stats-section .ps-grid {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 64px 80px;
    }

    #platform-stats-section .ps-stat-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        width: 200px;
    }

    #platform-stats-section .ps-platform-name {
        font-family: 'Press Start 2P', cursive;
        font-size: 22px;
        line-height: 1.6;
        margin: 0 0 14px 0;
    }

    #platform-stats-section .ps-stat-icon {
        width: 48px;
        height: 48px;
        object-fit: contain;
        image-rendering: pixelated;
        margin-bottom: 12px;
    }

    #platform-stats-section .ps-stat-icon-placeholder {
        width: 48px;
        height: 48px;
        margin-bottom: 12px;
    }

    #platform-stats-section .ps-stat-label {
        font-family: 'Press Start 2P', cursive;
        font-size: 20px;
        color: #aaaaaa;
        line-height: 1.6;
        margin: 0 0 8px 0;
    }

    #platform-stats-section .ps-stat-value {
        font-family: 'Press Start 2P', cursive;
        font-size: 32px;
        color: #ffffff;
        line-height: 1.4;
    }

    @media only screen and (max-width: 600px) {
        #platform-stats-section .ps-heading {
            font-size: 0.65rem;
        }

        #platform-stats-section .ps-stat-item {
            width: 130px;
        }

        #platform-stats-section .ps-stat-value {
            font-size: 26px;
        }
    }
</style>

<!-- Platform Stats Section -->
<section id="platform-stats-section">
    <h2 class="ps-heading">Stats &amp; Achievements</h2>
    <div class="ps-grid" id="ps-grid">
        {{-- Stat items injected by JS --}}
    </div>
</section>

<script>
    $(document).ready(function () {

        var PLATFORM_COLORS = {
            'PlayStation':  '#3A88E4',
            'Xbox':         '#8CCB3A',
            'Nintendo':     '#E94E4E',
            'Steam':        '#B7B7B7',
            'Apple Arcade': '#A25CC9',
            'Android':      '#FFC700',
            'Other':        '#c4408a'
        };

        $.getJSON('/api/platform-stats', function (platforms) {
            var $grid = $('#ps-grid');
            $grid.empty();

            if (!platforms || platforms.length === 0) return;

            $.each(platforms, function (i, group) {
                var platform = group.platform;
                var color    = PLATFORM_COLORS[platform] || '#ffffff';

                $.each(group.stats, function (j, stat) {
                    var $item = $('<div></div>', { 'class': 'ps-stat-item' });

                    $item.append($('<p></p>', {
                        'class': 'ps-platform-name',
                        text: platform
                    }).css('color', color));

                    if (stat.icon_path) {
                        $item.append($('<img />', {
                            src: stat.icon_path,
                            alt: stat.stat_label,
                            'class': 'ps-stat-icon'
                        }));
                    } else {
                        $item.append($('<div></div>', { 'class': 'ps-stat-icon-placeholder' }));
                    }

                    $item.append($('<p></p>', {
                        'class': 'ps-stat-label',
                        text: stat.stat_label
                    }));

                    $item.append($('<p></p>', {
                        'class': 'ps-stat-value',
                        text: stat.stat_value
                    }));

                    $grid.append($item);
                });
            });
        });
    });
</script>
