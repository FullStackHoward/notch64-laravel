<style>
@verbatim
    /* ── Fixed MENU button ───────────────────────────────── */
    #nav-menu-btn {
        position: fixed;
        top: 16px;
        right: 20px;
        z-index: 99999;
        font-family: 'Press Start 2P', cursive;
        font-size: 7px;
        color: #ffffff;
        background-color: #2a2a2a;
        border: 2px solid #6e4fa0;
        border-radius: 999px;
        padding: 8px 14px;
        cursor: pointer;
        line-height: 1;
        transition: background-color 0.15s;
    }

    #nav-menu-btn:hover {
        background-color: #6e4fa0;
    }

    /* ── Full screen overlay ─────────────────────────────── */
    #nav-overlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 99998;
        background-color: rgba(0, 0, 0, 0.92);
        background-image: repeating-linear-gradient(
            to bottom,
            transparent 0px,
            transparent 2px,
            rgba(0, 0, 0, 0.15) 2px,
            rgba(0, 0, 0, 0.15) 4px
        );
        align-items: center;
        justify-content: center;
    }

    /* ── Overlay content box ─────────────────────────────── */
    #nav-overlay-content {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        width: 90%;
        max-width: 480px;
        max-height: 80vh;
        overflow-y: auto;
        padding: 40px 36px 36px 36px;
        box-sizing: border-box;
    }

    /* ── Close button ────────────────────────────────────── */
    #nav-close-btn {
        position: absolute;
        top: 0;
        right: 0;
        font-family: 'Press Start 2P', cursive;
        font-size: 14px;
        color: #c4408a;
        background: none;
        border: none;
        cursor: pointer;
        line-height: 1;
        padding: 4px 8px;
    }

    #nav-close-btn:hover {
        color: #ffffff;
    }

    /* ── Link group headings ─────────────────────────────── */
    .nav-overlay-group-heading {
        font-family: 'Press Start 2P', cursive;
        font-size: 8px;
        color: #aaaaaa;
        margin: 0 0 16px 0;
        line-height: 1.6;
    }

    /* ── Divider ─────────────────────────────────────────── */
    .nav-overlay-divider {
        width: 100%;
        height: 2px;
        background-color: #6e4fa0;
        border: none;
        margin: 24px 0;
    }

    /* ── Links ───────────────────────────────────────────── */
    .nav-overlay-link {
        font-family: 'Press Start 2P', cursive;
        font-size: 9px;
        color: #ffffff;
        text-decoration: none;
        display: block;
        padding: 10px 0;
        line-height: 1.6;
        cursor: pointer;
        background: none;
        border: none;
        text-align: left;
        transition: color 0.15s;
    }

    .nav-overlay-link--nav:hover {
        color: #c4408a;
    }

    .nav-overlay-link--connect:hover {
        color: #6e4fa0;
    }
@endverbatim
</style>

<!-- Fixed MENU button -->
<button id="nav-menu-btn" onclick="openMenu()">MENU</button>

<!-- Full screen overlay -->
<div id="nav-overlay">
    <div id="nav-overlay-content">

        <button id="nav-close-btn" onclick="closeMenu()">✕</button>

        <!-- Navigate group -->
        <p class="nav-overlay-group-heading">Navigate</p>
        <button class="nav-overlay-link nav-overlay-link--nav" onclick="navTo(0)">Home</button>
        <button class="nav-overlay-link nav-overlay-link--nav" onclick="navTo('#spotify-section')">My Favorite Artists</button>
        <button class="nav-overlay-link nav-overlay-link--nav" onclick="navTo('#gaming-section')">What I'm Playing</button>
        <button class="nav-overlay-link nav-overlay-link--nav" onclick="navTo('#twitch-section')">Twitch</button>
        <button class="nav-overlay-link nav-overlay-link--nav" onclick="navTo('#pagecontainer')">Join My Community ↗</button>

        <hr class="nav-overlay-divider" />

        <!-- Connect group -->
        <p class="nav-overlay-group-heading">Connect</p>
        <a class="nav-overlay-link nav-overlay-link--connect" href="{{ config('notch64.social.instagram') }}" target="_blank" rel="noopener noreferrer">Instagram</a>
        <a class="nav-overlay-link nav-overlay-link--connect" href="https://twitter.com/itsnotch64" target="_blank" rel="noopener noreferrer">Twitter</a>
        <a class="nav-overlay-link nav-overlay-link--connect" href="{{ config('notch64.social.facebook') }}" target="_blank" rel="noopener noreferrer">Facebook</a>
        <a class="nav-overlay-link nav-overlay-link--connect" href="{{ config('notch64.social.tiktok') }}" target="_blank" rel="noopener noreferrer">TikTok</a>

    </div>
</div>

<script>
    function openMenu() {
        var $overlay = $('#nav-overlay');
        $overlay.css({ display: 'flex', opacity: 0 }).animate({ opacity: 1 }, 250);
    }

    function closeMenu() {
        var $overlay = $('#nav-overlay');
        $overlay.animate({ opacity: 0 }, 200, function () {
            $overlay.css('display', 'none');
        });
    }

    function navTo(target) {
        closeMenu();
        setTimeout(function () {
            if (target === 0) {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } else {
                var $el = $(target);
                if ($el.length) {
                    window.scrollTo({ top: $el.offset().top, behavior: 'smooth' });
                }
            }
        }, 220);
    }

    // Close when clicking outside the content box
    $(document).on('click', '#nav-overlay', function (e) {
        if ($(e.target).is('#nav-overlay')) {
            closeMenu();
        }
    });
</script>
