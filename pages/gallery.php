 <div class="back_re title-area">
     <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <div class="title">
                     <h2>Gallery</h2>
                 </div>
             </div>
         </div>
     </div>
 </div>
 <!-- 
 <div class="gallery">
     <div class="container">
         <div class="row">
             <div class="col-md-12">
                 <div class="titlepage">
                     <h2>gallery</h2>
                 </div>
             </div>
         </div>

         <?php
            $gallery_images = 8; // total number of images
            ?>
         <div class="row">
             <?php for ($i = 1; $i <= $gallery_images; $i++): ?>
                 <div class="col-md-3 col-sm-6">
                     <div class="gallery_img">
                         <figure><img src="assets/images/gallery/gallery-<?= $i ?>.jpeg" alt="#" /></figure>
                     </div>
                 </div>
             <?php endfor; ?>
         </div>
     </div>
 </div> -->

 <div class="container-xxl py-5">
     <div class="container">
         <div class="row g-5 align-items-center">
             <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s" style="visibility: visible; animation-delay: 0.5s; animation-name: fadeInUp;">
                 <div id="lcl_elems_wrapper" class="text-center"></div>
                 <div class="w-100 text-center">
                     <button id="load-more" class="btn btn-primary btn-sm">Load More</button>
                 </div>
             </div>
         </div>
     </div>
 </div>

 <script src="assets/lib/lc/js/lc_lightbox.lite.js"></script>
 <link rel="stylesheet" href="assets/lib/lc/css/lc_lightbox.css">
 <link rel="stylesheet" href="assets/lib/lc/skins/minimal.css">

 <script src="assets/lib/lc/lib/AlloyFinger/alloy_finger.min.js"></script>

 <script>
     $('document').ready(function() {
         console.log('ready');

         var $obj = lc_lightbox('#lcl_elems_wrapper a');


         const galleryWrapper = document.getElementById('lcl_elems_wrapper');
         let currentPage = 1;

         function loadImages(page) {
             fetch(`get-images.php?page=${page}`)
                 .then(response => response.json())
                 .then(images => {
                     //  console.log(images, images);

                     images.forEach(imagePath => {
                         const imageElement = document.createElement('a');
                         imageElement.href = `assets/images/gallery/${imagePath}`;
                         const img = document.createElement('img');
                         img.src = `assets/images/gallery/${imagePath}`;

                         img.style.width = '200px'; // or any fixed value like '150px', '100px'
                         img.style.height = '150px'; // set desired height
                         img.style.objectFit = 'cover'; // ensures image is cropped to fill box while keeping aspect ratio
                         img.style.margin = '10px';

                         imageElement.appendChild(img);
                         galleryWrapper.appendChild(imageElement);
                     });
                 });
         }

         // Load the first page
         loadImages(currentPage);

         // Load more on button click
         document.getElementById('load-more').addEventListener('click', () => {
             currentPage++;
             loadImages(currentPage);
         });

     });
 </script>