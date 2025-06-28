  <?php
    $rooms = [
        [
            'image' => 'assets/images/roomtype/type1.jpeg',
            'title' => 'Royal Suite',
            'description' => 'Spacious and ideal for 4 adults. Features centralized air conditioning, 24-hour hot water, high-speed Wi-Fi, toiletries, fresh towels, a wardrobe with hangers, and an electric kettle.',
        ],
        [
            'image' => 'assets/images/roomtype/type2.jpeg',
            'title' => 'Superior Royal King',
            'description' => 'Perfect for 2 adults. Includes centralized air conditioning, 24-hour hot water, high-speed Wi-Fi, toiletries, fresh towels, a wardrobe with hangers, a study table, and an electric kettle.'
        ],
        [
            'image' => 'assets/images/roomtype/type3.jpeg',
            'title' => 'Wedding Hall',
            'description' => 'A spacious and elegant hall ideal for weddings and special events. Fully air-conditioned with decorative lighting, premium seating, stage area, sound system, and ample parking facilities.'
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
                              <h3><?= $room['title'] ?></h3>
                              <p><?= $room['description'] ?></p>
                              <a target="/blank" href="assets/doc/profile.pdf" class="read_more">View More..</a>
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