$(document).ready(function() {

    // Header splash text
    $.ajax({
        url: '/api/splash/random',
        method: 'GET',
        success: function(data) {
            $('#splash').text(data.message);
            if (data.url) {
                $('#splash').closest('a').attr('href', data.url);
            }
        },
        error: function() {
            $('#splash').text('Loading...');
        }
    });

    // Thoughts section — uses the dedicated thought API (latest active thought)
    $.ajax({
        url: '/api/thought/current',
        method: 'GET',
        success: function(data) {
            $('#thoughts-text').text(data.content);
        },
        error: function() {
            $('#thoughts-text').text('...');
        }
    });

});
