$(document).ready(function() {

    const playlist = [
        {
            title: 'The Other Notch',
            src: [
                audioBaseUrl + 'audio/theothernotch.ogg',
                audioBaseUrl + 'audio/theothernotch.mp3'
            ]
        }
    ];

    let currentTrack = 0;
    let isPlaying = false;
    const audio = document.getElementById('snes-audio');
    const playPauseBtn = document.getElementById('play-pause-btn');
    const progressBar = document.getElementById('progress-bar');
    const trackName = document.getElementById('track-name');

    // Load a track by index
    function loadTrack(index) {
        audio.src = playlist[index].src[0];
        trackName.textContent = playlist[index].title;
        audio.load();
    }

    // Play the current track
    function playTrack() {
        audio.play();
        isPlaying = true;
        playPauseBtn.textContent = '⏸';
    }

    // Pause the current track
    function pauseTrack() {
        audio.pause();
        isPlaying = false;
        playPauseBtn.textContent = '▶';
    }

    // When a track ends, move to the next one
    audio.addEventListener('ended', function() {
        currentTrack = (currentTrack + 1) % playlist.length;
        loadTrack(currentTrack);
        playTrack();
    });

    // Update the progress bar as the song plays
    audio.addEventListener('timeupdate', function() {
        if (audio.duration) {
            const progress = (audio.currentTime / audio.duration) * 100;
            progressBar.style.width = progress + '%';
        }
    });

    // Click the progress bar to seek
    document.getElementById('progress-bar-container').addEventListener('click', function(e) {
        const rect = this.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        const width = rect.width;
        audio.currentTime = (clickX / width) * audio.duration;
    });

    // Play/pause button
    playPauseBtn.addEventListener('click', function() {
        if (isPlaying) {
            pauseTrack();
        } else {
            playTrack();
        }
    });

    // Go to next track
    function nextTrack() {
        currentTrack = (currentTrack + 1) % playlist.length;
        loadTrack(currentTrack);
        if (isPlaying) playTrack();
    }

// Go to previous track
    function prevTrack() {
        currentTrack = (currentTrack - 1 + playlist.length) % playlist.length;
        loadTrack(currentTrack);
        if (isPlaying) playTrack();
    }

// Y button = previous track
    document.getElementById('btn-y').addEventListener('click', function() {
        prevTrack();
    });

// B button = next track
    document.getElementById('btn-b').addEventListener('click', function() {
        nextTrack();
    });

// X and A buttons - placeholder for future use
    document.getElementById('btn-x').addEventListener('click', function() {
        // future feature
    });

    document.getElementById('btn-a').addEventListener('click', function() {
        // future feature
    });

    // Scrolling track name marquee
    let marqueePosition = 100;
    function scrollTrackName() {
        marqueePosition -= 0.5;
        if (marqueePosition < -100) {
            marqueePosition = 100;
        }
        trackName.style.transform = 'translateX(' + marqueePosition + '%)';
        requestAnimationFrame(scrollTrackName);
    }
    scrollTrackName();

    // Load and autoplay the first track
    loadTrack(currentTrack);
    audio.play().then(function() {
        isPlaying = true;
        playPauseBtn.textContent = '⏸';
    }).catch(function() {
        // Browser blocked autoplay, wait for user to click play
        isPlaying = false;
        playPauseBtn.textContent = '▶';
    });

});
