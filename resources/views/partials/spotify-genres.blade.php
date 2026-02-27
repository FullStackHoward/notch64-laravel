<style>
    #spotify-genres-section {
        background-color: #000000;
        padding: 60px 20px;
        box-sizing: border-box;
        margin-left: -20px;
        margin-right: -20px;
        width: calc(100% + 40px);
    }

    #spotify-genres-section .genres-columns {
        display: flex;
        flex-direction: row;
        align-items: flex-start;
        gap: 40px;
    }

    #spotify-genres-section .genres-col {
        flex: 1 1 0;
        min-width: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    #spotify-genres-section .genres-col-heading {
        font-family: 'Press Start 2P', cursive;
        color: #ffffff;
        font-size: 1rem;
        text-align: center;
        margin: 0 0 24px 0;
        line-height: 1.6;
    }

    /* ---- Radar chart ---- */
    #spotify-genres-section .radar-wrap {
        position: relative;
        width: 100%;
        max-width: 380px;
    }

    #spotify-genres-section #genre-radar-chart {
        background-color: #000000;
        display: block;
        width: 100% !important;
        height: auto !important;
    }

    /* ---- Tag cloud ---- */
    #spotify-genres-section .tag-cloud {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 10px;
        width: 100%;
    }

    #spotify-genres-section .genre-tag {
        font-family: 'Press Start 2P', cursive;
        padding: 6px 12px;
        border-radius: 999px;
        line-height: 1.4;
        white-space: nowrap;
        display: inline-block;
    }

    #spotify-genres-section .genre-tag--green {
        background-color: #1DB954;
        color: #000000;
        border: none;
    }

    #spotify-genres-section .genre-tag--dark {
        background-color: #222222;
        color: #1DB954;
        border: 1px solid #1DB954;
    }

    @media only screen and (max-width: 700px) {
        #spotify-genres-section .genres-columns {
            flex-direction: column;
            align-items: center;
        }

        #spotify-genres-section .genres-col {
            width: 100%;
        }

        #spotify-genres-section .radar-wrap {
            max-width: 100%;
        }
    }
</style>

<!-- Spotify Genre Radar + Tag Cloud Section -->
<section id="spotify-genres-section">
    <div class="genres-columns">

        <!-- Left: Radar Chart -->
        <div class="genres-col">
            <h2 class="genres-col-heading">Genre Radar</h2>
            <div class="radar-wrap">
                <canvas id="genre-radar-chart"></canvas>
            </div>
        </div>

        <!-- Right: Tag Cloud -->
        <div class="genres-col">
            <h2 class="genres-col-heading">Genres I'm Exploring</h2>
            <div class="tag-cloud" id="genre-tag-cloud">
                {{-- Tags injected by JS --}}
            </div>
        </div>

    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
    $(document).ready(function () {
        $.getJSON('/api/spotify/genre-data', function (data) {

            /* ── Radar Chart ─────────────────────────────────────── */
            var radarData = data.radar || {};
            var radarLabels = Object.keys(radarData);
            var radarValues = Object.values(radarData);

            if (radarLabels.length > 0) {
                var ctx = document.getElementById('genre-radar-chart').getContext('2d');

                new Chart(ctx, {
                    type: 'radar',
                    data: {
                        labels: radarLabels,
                        datasets: [{
                            data: radarValues,
                            backgroundColor: 'rgba(29, 185, 84, 0.4)',
                            borderColor: '#1DB954',
                            borderWidth: 2,
                            pointBackgroundColor: '#1DB954',
                            pointBorderColor: '#1DB954',
                            pointRadius: 3
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            r: {
                                backgroundColor: '#000000',
                                angleLines: {
                                    color: '#333333'
                                },
                                grid: {
                                    color: '#333333'
                                },
                                ticks: {
                                    display: false,
                                    backdropColor: 'transparent'
                                },
                                pointLabels: {
                                    color: '#ffffff',
                                    font: {
                                        family: "'Press Start 2P', cursive",
                                        size: 7
                                    }
                                }
                            }
                        }
                    }
                });
            }

            /* ── Tag Cloud ───────────────────────────────────────── */
            var tagData = data.tagcloud || {};
            var tagEntries = Object.entries(tagData);

            if (tagEntries.length === 0) return;

            var counts = tagEntries.map(function (e) { return e[1]; });
            var minCount = Math.min.apply(null, counts);
            var maxCount = Math.max.apply(null, counts);
            var minSize = 7;
            var maxSize = 16;

            var $cloud = $('#genre-tag-cloud');
            $cloud.empty();

            tagEntries.forEach(function (entry, index) {
                var genre = entry[0];
                var count = entry[1];

                var fontSize = minSize;
                if (maxCount !== minCount) {
                    fontSize = minSize + ((count - minCount) / (maxCount - minCount)) * (maxSize - minSize);
                }

                var styleClass = (index % 2 === 0) ? 'genre-tag--green' : 'genre-tag--dark';

                var $tag = $('<span></span>', {
                    'class': 'genre-tag ' + styleClass,
                    text: genre
                }).css('font-size', fontSize.toFixed(1) + 'px');

                $cloud.append($tag);
            });

        });
    });
</script>
