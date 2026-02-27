<style>
    #spotify-section {
        background-color: #000000;
        padding: 60px 20px;
        box-sizing: border-box;
        margin-left: -20px;
        margin-right: -20px;
        width: calc(100% + 40px);
    }

    #spotify-section .spotify-heading {
        font-family: 'Press Start 2P', cursive;
        color: #1DB954;
        text-align: center;
        margin: 0 0 40px 0;
        font-size: 1rem;
        line-height: 1.6;
    }

    #spotify-section .spotify-cards-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: flex-start;
        gap: 24px;
    }

    #spotify-section .spotify-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        cursor: pointer;
        width: 180px;
    }

    #spotify-section .spotify-card:hover .spotify-card__img,
    #spotify-section .spotify-card:hover .spotify-card__placeholder {
        opacity: 0.8;
    }

    #spotify-section .spotify-card__img {
        width: 180px;
        height: 180px;
        object-fit: cover;
        border: 3px solid #1DB954;
        display: block;
        flex-shrink: 0;
    }

    #spotify-section .spotify-card__placeholder {
        width: 180px;
        height: 180px;
        background-color: #000000;
        border: 3px solid #1DB954;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3.75rem;
        flex-shrink: 0;
        box-sizing: border-box;
    }

    #spotify-section .spotify-card__name {
        font-family: 'Press Start 2P', cursive;
        color: #ffffff;
        font-size: 8px;
        text-align: center;
        margin-top: 10px;
        width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.5;
    }
</style>

<!-- Spotify Top Artists Section -->
<section id="spotify-section">
    <h2 class="spotify-heading">What I'm currently vibing to...</h2>
    <div class="spotify-cards-row" id="spotify-cards-row">
        {{-- Cards injected by JS --}}
    </div>
</section>

<script>
    $(document).ready(function () {
        $.getJSON('/api/spotify/top-artists', function (artists) {
            var $row = $('#spotify-cards-row');
            $row.empty();

            if (!artists || artists.length === 0) {
                return;
            }

            $.each(artists, function (i, artist) {
                var $card = $('<a></a>', {
                    href: artist.url || '#',
                    target: '_blank',
                    rel: 'noopener noreferrer',
                    'class': 'spotify-card'
                });

                var $media;
                if (artist.image) {
                    $media = $('<img />', {
                        src: artist.image,
                        alt: artist.name,
                        'class': 'spotify-card__img'
                    });
                } else {
                    $media = $('<div></div>', {
                        'class': 'spotify-card__placeholder'
                    }).text('🎵');
                }

                var $name = $('<span></span>', {
                    'class': 'spotify-card__name',
                    title: artist.name
                }).text(artist.name);

                $card.append($media).append($name);
                $row.append($card);
            });
        });
    });
</script>
