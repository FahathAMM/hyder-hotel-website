<?php
require_once __DIR__ . '/../app/Core/helpers.php';
loadEnv(__DIR__ . '/../.env');

// $db_name  = "sfa_sapdata";
// $username = "root";
// $password = '';
// $host     = "127.0.0.1";

$db_name  = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PASS');
$host     = getenv('DB_HOST');


$mysqli = new mysqli($host, $username, $password, $db_name);

if (mysqli_connect_errno()) {
    printf("Connect failed: <p>%s</p>", mysqli_connect_error());
    exit();
}
