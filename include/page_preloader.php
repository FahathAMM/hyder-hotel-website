<style>
    #loading {
        position: fixed;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0.98;
        background-color: #fff;
        z-index: 9999;
    }

    #loading-image {
        z-index: 9999;
    }

    #loading p {
        margin-top: 10px;
        font-size: 14px;
        font-weight: bold;
    }

    .spinner-border {
        /* color: #f20f21; */
    }

    /* ==================== */
    .zoom-in-out-box {
        width: 100px;
        height: 40px;
        /* background-image: url(https://www.mirnah.com/wp-content/uploads/2021/02/Mirnah_Logo-HR.png); */
        /* background-image: url('{{ asset('assets/images/loader.png') }}'); */


        /* background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 150"><path fill="none" stroke="%23FF156D" stroke-width="10" stroke-linecap="round" stroke-dasharray="300 385" stroke-dashoffset="0" d="M275 75c0 31-27 50-50 50-58 0-92-100-150-100-28 0-50 22-50 50s23 50 50 50c58 0 92-100 150-100 24 0 50 19 50 50Z"><animate attributeName="stroke-dashoffset" calcMode="spline" dur="2.8" values="685;-685" keySplines="0 0 1 1" repeatCount="indefinite"></animate></path></svg>'); */

        /* background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 150"><path fill="none" stroke="%23224069" stroke-width="10" stroke-linecap="round" stroke-dasharray="300 385" stroke-dashoffset="0" d="M275 75c0 31-27 50-50 50-58 0-92-100-150-100-28 0-50 22-50 50s23 50 50 50c58 0 92-100 150-100 24 0 50 19 50 50Z"><animate attributeName="stroke-dashoffset" calcMode="spline" dur="2.8" values="685;-685" keySplines="0 0 1 1" repeatCount="indefinite"></animate></path></svg>'); */

        /* background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 150"><path fill="none" stroke="%23224069" stroke-width="10" stroke-linecap="round" stroke-dasharray="300 385" stroke-dashoffset="0" d="M275 75c0 31-27 50-50 50-58 0-92-100-150-100-28 0-50 22-50 50s23 50 50 50c58 0 92-100 150-100 24 0 50 19 50 50Z"><animate attributeName="stroke-dashoffset" calcMode="spline" dur="2.8" values="685;-685" keySplines="0 0 1 1" repeatCount="indefinite"></animate></path></svg>'); */


        /* animation: zoom-in-zoom-out 1s ease infinite; */
        /* background-size: 100% 100%; */

        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: radial-gradient(farthest-side, #1e42ae 94%, #0000) top/9px 9px no-repeat,
            conic-gradient(#0000 30%, #1e42ae);
        -webkit-mask: radial-gradient(farthest-side, #0000 calc(100% - 9px), #000 0);
        animation: spinner-c7wet2 1s infinite linear;
    }

    @keyframes spinner-c7wet2 {
        100% {
            transform: rotate(1turn);
        }
    }

    @keyframes zoom-in-zoom-out {
        0% {
            transform: scale(1, 1);
        }

        50% {
            transform: scale(1.5, 1.5);
        }

        100% {
            transform: scale(1, 1);
        }
    }

    /* ==================== */
</style>


<div id="loading">
    <div class="zoom-in-out-box">
    </div>
</div>


<script>
    window.addEventListener("load", function() {
        setTimeout(() => {
            pagePreloader();
        }, 1);
    });

    function pagePreloader() {
        $('#status').fadeOut();
        $('#loading').delay(0.001).fadeOut('slow');
    }
</script>