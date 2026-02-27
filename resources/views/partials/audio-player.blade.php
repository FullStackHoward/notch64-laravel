<div id="snes-player">
    <div id="player-left">
        <span id="track-name">Notch64 - The Other Notch</span>
        <div id="progress-bar-container">
            <div id="progress-bar"></div>
        </div>
    </div>

    <div id="player-center">
        <button id="play-pause-btn" class="snes-btn-purple">▶</button>
        <div id="snes-buttons">
            <div id="snes-buttons-row">
                <button id="btn-y" class="snes-face-btn snes-purple">Y</button>
                <button id="btn-x" class="snes-face-btn snes-purple">X</button>
                <button id="btn-b" class="snes-face-btn snes-pink">B</button>
                <button id="btn-a" class="snes-face-btn snes-pink">A</button>
            </div>
        </div>
    </div>

    <div id="player-right">
        <a href="https://www.bignotch.com" target="_blank" id="hear-more">
            hear more ►
        </a>
    </div>

    <audio id="snes-audio">
        <source src="{{ asset('audio/theothernotch.ogg') }}" type="audio/ogg"/>
        <source src="{{ asset('audio/theothernotch.mp3') }}" type="audio/mpeg"/>
    </audio>
    <script>
        const audioBaseUrl = "{{ asset('/') }}";
    </script>
</div>
