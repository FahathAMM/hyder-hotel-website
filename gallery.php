 <div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
     <div class="container text-center py-5">
         <h1 class="display-4 text-white animated slideInDown mb-4">Gallery</h1>
         <nav aria-label="breadcrumb animated slideInDown">
             <span>
                 Explore our gallery to see our dedication in action! Witness the exceptional cleaning and technical services we've delivered, showcasing our commitment to professionalism, reliability, and quality. Each image reflects the trust our clients place in us and the advanced solutions we provide to meet their unique needs
             </span>
         </nav>
     </div>
 </div>

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

 <script src="assets/js/jquery.min.js"></script>

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
                     console.log(images, images);

                     images.forEach(imagePath => {
                         const imageElement = document.createElement('a');
                         imageElement.href = `assets/images/gallery/${imagePath}`;
                         const img = document.createElement('img');
                         img.src = `assets/images/gallery/${imagePath}`;
                         img.style.width = '50px';
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