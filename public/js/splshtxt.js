$(document).ready(function() {
    // Fetch splash message from Laravel API
    $.ajax({
        url: '/api/splash/random',
        method: 'GET',
        success: function(data) {
            $('#splash').text(data.message);
        },
        error: function() {
            $('#splash').text('Loading...');
        }
    });
});
