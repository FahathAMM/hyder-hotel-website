<?php
$activePage = $_GET['page'] ?? 'home';

date_default_timezone_set('Asia/Dubai');

$menuItems = [
    ['title' => 'Home', 'href' => 'home'],
    ['title' => 'About', 'href' => 'about'],
    ['title' => 'Our room', 'href' => 'room'],
    ['title' => 'Marriage Hall', 'href' => 'hall'],
    ['title' => 'Gallery', 'href' => 'gallery'],
    ['title' => 'Blog', 'href' => 'blog'],
    ['title' => 'Contact Us', 'href' => 'contact'],
];

$currentPage = $activePage;
// $currentPage = basename($_SERVER['PHP_SELF']);
?>

<header>
    <!-- header inner -->
    <div class="header">
        <div class="container">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                    <div class="full">
                        <div class="center-desk">
                            <div class="logo">
                                <a href="app.php?page=home"><img src="assets/images/logo/logo.png" alt="#" /></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                    <nav class="navigation navbar navbar-expand-md navbar-dark ">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                            <ul class="navbar-nav mr-auto">
                                <?php foreach ($menuItems as $item): ?>
                                    <li class="nav-item <?= ($item['href'] == $currentPage) ? 'active' : '' ?>">
                                        <a class="nav-link" href="app.php?page=<?= htmlspecialchars($item['href']) ?>">
                                            <?= htmlspecialchars($item['title']) ?>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>