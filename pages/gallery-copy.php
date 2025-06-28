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
 </div>