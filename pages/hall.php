  <?php
    $rooms = [
        [
            'image' => 'assets/images/hall/type1.jpeg',
            'title' => 'Royal Suite',
            'description' => 'A grand and spacious hall with stage, lighting, and seating ideal for large wedding ceremonies.'
        ],
        [
            'image' => 'assets/images/hall/type2.jpeg',
            'title' => 'Superior Royal King',
            'description' => 'A beautifully decorated wedding space designed for smaller events with a luxurious feel.'
        ],
        [
            'image' => 'assets/images/hall/type3.jpeg',
            'title' => 'Wedding Hall',
            'description' => 'A stylish wedding hall setup with elegant seating, perfect for intimate gatherings.'
        ],
    ];
    ?>


  <div class="back_re title-area">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <div class="title">
                      <h2>Our Room</h2>
                  </div>
              </div>
          </div>
      </div>
  </div>

  <div class="our_room">
      <div class="container">
          <div class="row">
              <div class="col-md-12">
                  <div class="titlepage">
                      <h2 class="spe-title">Our Room</h2>
                      <p class="margin_0">Explore our thoughtfully designed rooms that combine comfort, elegance, and modern amenities for a truly relaxing stay.</p>
                  </div>
              </div>
          </div>
          <div class="row">
              <?php foreach ($rooms as $room): ?>
                  <div class="col-md-4 col-sm-6">
                      <div id="serv_hover" class="room">
                          <div class="room_img">
                              <figure><img src="<?= $room['image'] ?>" alt="#"></figure>
                          </div>
                          <div class="bed_room">
                              <!-- <h3><?= $room['title'] ?></h3> -->
                              <p><?= $room['description'] ?></p>
                          </div>
                      </div>
                  </div>
              <?php endforeach; ?>
          </div>
      </div>
  </div>

  <style>
      .spe-title {
          display: none;
      }
  </style>