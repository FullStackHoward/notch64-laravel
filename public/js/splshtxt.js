$(document).ready(function() {
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
});
