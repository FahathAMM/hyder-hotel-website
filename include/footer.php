<?php
// Sample data (this can later come from a config file or database)
$contact = [
    // 'address' => '123 Main Street, City, Country',
    'address' => '168/4A2, Medical College Road,',
    'address1' => 'opposite to 1st Gate,',
    'address2' => 'Thanjavur 613004,',
    'address3' => 'Tamil Nadu 613004, India,',
    'phone' => '+91 9342909003, +91 9342909004',
    'email' => 'hydersmahal@gmail.com'
];

$menu_links = [
    ['label' => 'Home', 'href' => 'home', 'active' => true],
    ['label' => 'About', 'href' => 'about'],
    ['label' => 'Our Room', 'href' => 'room'],
    ['label' => 'Gallery', 'href' => 'gallery'],
    ['label' => 'Blog', 'href' => 'blog'],
    ['label' => 'Contact Us', 'href' => 'contact'],
];

$social_links = [
    [
        'name' => '',
        'url' => 'https://www.facebook.com/share/19QoAUmvUw/?mibextid=wwXIfr',
        'icon' => 'fa-facebook'
    ],
    [
        'name' => '',
        'url' => 'https://www.instagram.com/hydersmahal?igsh=MW54MHdmd2V0dzRtZg==',
        'icon' => 'fa-instagram'
    ],
    [
        'name' => '',
        'url' => '#',
        'icon' => 'fa-linkedin'
    ],
    [
        'name' => '',
        'url' => '#',
        'icon' => 'fa-youtube-play'
    ]
];

$activePage = $_GET['page'] ?? 'home';
$currentPage = $activePage;

?>

<?php include "include/whatsapp.php"; ?>


<footer>
    <div class="footer">
        <div class="container">
            <div class="row">
                <!-- Contact Us -->
                <div class="col-md-4">
                    <h3>Contact US</h3>
                    <ul class="conta">
                        <li><i class="fa fa-map-marker" aria-hidden="true"></i> <?= $contact['address'] ?></li>
                        <li> <?= $contact['address1'] ?></li>
                        <li> <?= $contact['address2'] ?></li>
                        <li> <?= $contact['address3'] ?></li>

                        <li style="margin-top: 5px;"><i class="fa fa-mobile" aria-hidden="true"></i><?= $contact['phone'] ?></li>
                        <li><i class="fa fa-envelope" aria-hidden="true"></i>
                            <a href="mailto:<?= $contact['email'] ?>"> <?= $contact['email'] ?></a>
                        </li>
                    </ul>
                </div>

                <!-- Menu Links -->
                <div class="col-md-4">
                    <h3>Menu Link</h3>
                    <ul class="link_menu">

                        <?php foreach ($menu_links as $link): ?>
                            <li class="<?= ($item['href'] == $currentPage) ? 'active' : '' ?>">
                                <a href="app.php?page=<?= $link['href'] ?>"><?= $link['label'] ?></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Newsletter & Social -->
                <div class="col-md-4">
                    <h3>Social Media</h3>
                    <!-- <form class="bottom_form">
                        <input class="enter" placeholder="Enter your email" type="text" name="email">
                        <button class="sub_btn">Subscribe</button>
                    </form> -->
                    <ul class="social_icon">
                        <?php foreach ($social_links as $social): ?>
                            <li>
                                <a href="<?= htmlspecialchars($social['url']) ?>" target="_blank">
                                    <i class="fa <?= $social['icon'] ?>" aria-hidden="true"></i> <?= ucfirst($social['name']) ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Copyright -->
        <div class="copyright">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 offset-md-1">
                        <p>
                            © <?= date('Y') ?> All Rights Reserved.
                            <a href="https://www.linkedin.com/in/fahath-mohamed-3ab47416b/">Fahath</a><br><br>

                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    ul.conta li {
        padding-bottom: 0px;
    }
</style>