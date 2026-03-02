$(document).ready(function() {

    var thoughtContent = null;
    var typewriterStarted = false;

    function typewriter(element, text, speed) {
        element.text('');
        var i = 0;
        var interval = setInterval(function() {
            element.text(element.text() + text.charAt(i));
            i++;
            if (i >= text.length) clearInterval(interval);
        }, speed);
    }

    function maybeStartTypewriter() {
        if (typewriterStarted || thoughtContent === null) return;
        typewriterStarted = true;
        typewriter($('#thoughts-text'), thoughtContent, 40);
    }

    $.ajax({
        url: '/api/thought/current',
        method: 'GET',
        success: function(data) {
            thoughtContent = data.content || '...';
            $('#thoughts-text').text('');

            if ('IntersectionObserver' in window) {
                var observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            maybeStartTypewriter();
                            observer.disconnect();
                        }
                    });
                }, { threshold: 0.2 });

                observer.observe(document.querySelector('.thoughts-bubble'));
            } else {
                maybeStartTypewriter();
            }
        },
        error: function() {
            $('#thoughts-text').text('...');
        }
    });

});
