<style>
@verbatim
    #site-footer {
        width: calc(100% + 40px);
        margin-left: -20px;
        margin-right: -20px;
        text-align: center;
        font-family: 'Press Start 2P', cursive;
        font-size: 1vw;
        color: #ffffff;
        padding: 0 20px;
        min-height: 140px;
        display: flex;
        align-items: center;
        justify-content: center;
        /* shift centre point up by half the audio player height so text sits
           centred in the visible area above the fixed 70px player bar */
        padding-bottom: 70px;
        box-sizing: border-box;
        background-color: #333333;
        box-shadow:
            inset 0 10px 20px rgba(0, 0, 0, 0.7),
            inset 0 -6px 14px rgba(0, 0, 0, 0.4);
        position: relative;
    }

    #site-footer a {
        text-decoration: none;
    }

    #site-footer .footer-text {
        font-family: 'Press Start 2P', cursive;
        font-size: 1vw;
        margin: 0;
    }

    @media only screen and (min-width: 40em) and (max-width: 64em) {
        #site-footer .footer-text {
            font-size: 2vw;
        }
    }

    @media only screen and (max-width: 40em) {
        #site-footer {
            min-height: 120px;
            padding-bottom: 70px;
        }

        #site-footer .footer-text {
            font-size: 3vw;
        }
    }
@endverbatim
</style>

<footer id="site-footer">
    <p class="footer-text">webpage by <a class="howco-gradient-wipe" href="https://howard.codes">fullstackhoward</a></p>
</footer>
