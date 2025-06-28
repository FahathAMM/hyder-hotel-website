<!DOCTYPE html>
<!-- <html lang="en"> -->

<html lang="en" data-layout="horizontal" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable" class="sf-js-enabled" data-sidebar-visibility="show" data-layout-style="default" data-bs-theme="light" data-layout-width="fluid" data-layout-position="fixed">

<?php //session_start(); 
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hyders Mahal & Hotel</title>

    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php include "include/head.php"; ?>
</head>

<body class="main-layout">
    <!-- loader  -->
    <!-- <div class="loader_bg">
        <div class="loader"><img src="images/loading.gif" alt="#" /></div>
    </div> -->
    <!-- end loader -->

    <!-- header -->
    <?php include "include/header.php"; ?>
    <!-- end header -->

    <?php include "include/foot.php"; ?>

    <?php
    $pageName = $_GET['page'] ?? 'home';
    require "pages/$pageName.php";
    ?>

    <!--  footer -->
    <?php include "include/footer.php"; ?>


    <!-- end footer -->




</body>

<?php

function setSession($key, $value)
{
    return $_SESSION[$key] = $value;
}

function getSession($key)
{
    if (isset($key)) {
        return $_SESSION[$key];
    }
}

function postAttr($attr)
{
    if ($attr) {
        return $_POST[$attr];
    }
}

function getAttr($attr)
{
    return $_GET[$attr];
}

?>

</html>