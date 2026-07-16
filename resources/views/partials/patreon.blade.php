@verbatim
<style>
    #patreon-section {
        /* patreon-lite-bg.jpg sits behind the whole section (header + all four columns).
           A dark overlay keeps the header text legible over the artwork. */
        background:
            linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.25)),
            url('/img/patreon-lite-bg.jpg') center center / cover no-repeat;
        padding: 60px 20px;
        box-sizing: border-box;
        margin-left: -20px;
        margin-right: -20px;
        width: calc(100% + 40px);
    }

    /* ── Header ───────────────────────────────────────────────── */
    #patreon-section .patreon-heading {
        font-family: 'Press Start 2P', cursive;
        color: #ffffff;
        font-size: 1rem;
        text-align: center;
        margin: 0 0 12px 0;
        line-height: 1.6;
    }

    #patreon-section .patreon-subheading {
        font-family: 'Press Start 2P', cursive;
        color: #c4408a;
        font-size: 12px;
        text-align: center;
        margin: 0 0 40px 0;
        line-height: 1.6;
    }

    /* ── Column grid ──────────────────────────────────────────── */
    #patreon-section .patreon-columns {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        max-width: 1000px;
        margin: 0 auto 40px auto;
    }

    /* Box styling: site pink outline (#c4408a) + card gray background (#1a1a1a,
       the same gray used by the game cards) + the site's 4px box radius. The dark
       background is also what keeps the light/white discord icon visible. */
    #patreon-section .patreon-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        background-color: #1a1a1a;
        border: 1px solid #c4408a;
        border-radius: 4px;
        padding: 24px 18px;
        box-sizing: border-box;
    }

    /* Defined image slot per column, sized for a pixel-art icon (max-height 50px). */
    #patreon-section .patreon-col-icon-slot {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 50px;
        margin-bottom: 18px;
    }

    #patreon-section .patreon-col-icon {
        max-height: 50px;
        width: auto;
        display: block;
        image-rendering: pixelated;
        image-rendering: crisp-edges;
    }

    #patreon-section .patreon-col-title {
        font-family: 'Press Start 2P', cursive;
        color: #ffffff;
        font-size: 11px;
        line-height: 1.6;
        margin: 0 0 14px 0;
    }

    #patreon-section .patreon-col-desc {
        font-family: 'Press Start 2P', cursive;
        color: #aaaaaa;
        font-size: 9px;
        line-height: 2;
        margin: 0;
    }

    /* ── CTA ──────────────────────────────────────────────────── */
    #patreon-section .patreon-cta-wrap {
        text-align: center;
    }

    #patreon-section .patreon-cta {
        display: inline-block;
        font-family: 'Press Start 2P', cursive;
        font-size: 10px;
        line-height: 1.6;
        text-decoration: none;
        color: #ffffff;
        background-color: #c4408a;
        border-radius: 999px;
        padding: 16px 28px;
        transition: opacity 0.2s;
    }

    #patreon-section .patreon-cta:hover {
        opacity: 0.85;
    }

    #patreon-section .patreon-cta-arrow {
        font-size: 1.5em;
        font-weight: bold;
        line-height: 1;
        vertical-align: -1px;
        margin-left: 4px;
        /* System font renders a heavier arrow glyph than the pixel font. */
        font-family: Arial, sans-serif;
        -webkit-text-stroke: 1px currentColor;
    }

    /* ── Responsive: 4 → 2 → 1 columns ────────────────────────── */
    @media only screen and (max-width: 900px) {
        #patreon-section .patreon-columns {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media only screen and (max-width: 560px) {
        #patreon-section .patreon-heading {
            font-size: 0.6rem;
        }

        #patreon-section .patreon-columns {
            grid-template-columns: 1fr;
        }
    }
</style>
@endverbatim

<!-- Patreon Perks Section -->
<section id="patreon-section">
    <h2 class="patreon-heading">Wanna join my Patreon?</h2>
    <p class="patreon-subheading">here are some perks</p>

    <div class="patreon-columns">

        <!-- Column 1: Music and Track-Outs -->
        <div class="patreon-col">
            <div class="patreon-col-icon-slot">
                <img class="patreon-col-icon" src="{{ asset('img/musicnote-icon.png') }}" alt="Music and Track-Outs" />
            </div>
            <h3 class="patreon-col-title">Music and Track-Outs</h3>
            <p class="patreon-col-desc">Those songs you saw on my social media? Get full access to them here plus the track-outs!</p>
        </div>

        <!-- Column 2: In-Game Created Content -->
        <div class="patreon-col">
            <div class="patreon-col-icon-slot">
                <img class="patreon-col-icon" src="{{ asset('img/world-icon.png') }}" alt="In-Game Created Content" />
            </div>
            <h3 class="patreon-col-title">In-Game Created Content</h3>
            {{-- PLACEHOLDER: add any other in-game content you actually offer (custom maps, skins, etc.) before shipping. --}}
            <p class="patreon-col-desc">Get downloads straight from my own in-game builds, starting with the full ViceCraft World (Java and Bedrock).</p>
        </div>

        <!-- Column 3: Retro Homebrew and Mods -->
        <div class="patreon-col">
            <div class="patreon-col-icon-slot">
                <img class="patreon-col-icon" src="{{ asset('img/floppy-icon.png') }}" alt="Retro Homebrew and Mods" />
            </div>
            <h3 class="patreon-col-title">Retro Homebrew and Mods</h3>
            <p class="patreon-col-desc">Access original homebrew games, custom mods, and the tools and guides behind how I build them.</p>
        </div>

        <!-- Column 4: Discord Perks -->
        <div class="patreon-col">
            <div class="patreon-col-icon-slot">
                <img class="patreon-col-icon" src="{{ asset('img/discord-icon.png') }}" alt="Discord Perks" />
            </div>
            <h3 class="patreon-col-title">Discord Perks</h3>
            <p class="patreon-col-desc">Unlock supporter-only channels, exclusive events, and community Q&amp;As, plus dedicated support whenever you need help with your own creative or gaming projects.</p>
        </div>

    </div>

    <div class="patreon-cta-wrap">
        <a class="patreon-cta" href="{{ config('notch64.nav.patreon') }}" target="_blank" rel="noopener noreferrer">Join my Patreon <span class="patreon-cta-arrow">&#8599;</span></a>
    </div>
</section>
