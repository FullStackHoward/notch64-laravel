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
