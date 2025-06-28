<?php

$directory = 'assets/images/gallery/';
$images = array_diff(scandir($directory), array('..', '.'));

$counter = 1;

foreach ($images as $filename) {
    // Skip already renamed files (e.g., gallery-1.jpg, gallery-2.png, etc.)
    if (preg_match('/^gallery-\d+\.[a-zA-Z]{3,4}$/', $filename)) {
        continue;
    }

    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $newFilename = "gallery-{$counter}." . $extension;

    // Check if new filename already exists to avoid overwriting
    while (file_exists($directory . $newFilename)) {
        $counter++;
        $newFilename = "gallery-{$counter}." . $extension;
    }

    rename($directory . $filename, $directory . $newFilename);
    $counter++;
}

// Pagination logic
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$imagesPerPage = 54;
$offset = ($page - 1) * $imagesPerPage;
$paginatedImages = array_slice($images, $offset, $imagesPerPage);

// Return JSON response
header('Content-Type: application/json');
echo json_encode($paginatedImages);
