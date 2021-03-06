<?php
session_start();
define('BASE_URL', "http://" . $_SERVER['HTTP_HOST'] . "/baurami/");
define ('ROOT', dirname(dirname(__FILE__)));
require_once (ROOT.'/model/admin.php');
if (isset($_COOKIE['obj_admin'])) {

    $_SESSION['obj_admin'] = $_COOKIE['obj_admin'];
}

if (isset($_SESSION['obj_admin'])) {
    $obj_admin = unserialize($_SESSION['obj_admin']);
} else {
    $obj_admin = new Admin();
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

        <title>BAU RAMI</title>

        <!-- Google font -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700%7CVarela+Round" rel="stylesheet">
        <!-- Bootstrap -->
        <link type="text/css" rel="stylesheet" href="<?php echo (BASE_URL); ?>css/bootstrap.min.css" />
        <!-- Owl Carousel -->
        <link type="text/css" rel="stylesheet" href="<?php echo (BASE_URL); ?>css/owl.carousel.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo (BASE_URL); ?>css/owl.theme.default.css" />
        <!-- Magnific Popup -->
        <link type="text/css" rel="stylesheet" href="<?php echo (BASE_URL); ?>css/magnific-popup.css" />
        <!-- Font Awesome Icon -->
        <link rel="stylesheet" href="<?php echo (BASE_URL); ?>css/font-awesome.min.css">
        <!-- Custom stlylesheet -->
        <link type="text/css" rel="stylesheet" href="<?php echo (BASE_URL); ?>css/style.css" />
        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
