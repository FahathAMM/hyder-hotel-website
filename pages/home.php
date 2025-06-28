<div id="home-area">
    <!-- <section class="banner_main">
        <div id="myCarousel" class="carousel slide banner" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="first-slide" src="assets/images/banner1.jpg" alt="First slide">
                    <div class="container">
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="second-slide" src="assets/images/banner2.jpg" alt="Second slide">
                </div>
                <div class="carousel-item">
                    <img class="third-slide" src="assets/images/banner3.jpg" alt="Third slide">
                </div>
            </div>
            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

    </section> -->

    <section class="banner_main">
        <div class="video-banner">
            <video class="w-100" autoplay muted loop playsinline>
                <source src="assets/images/about/about_vid.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </section>

    <?php

    include "pages/about.php";
    include "pages/room.php";

    ?>
</div>


<style>
    #home-area .title-area {
        display: none;
    }

    .spe-title {
        display: block;
    }

    .video-banner video {
        width: 100%;
        height: auto;
        object-fit: cover;
        max-height: 500px;
        /* Adjust based on your design */
    }
</style>