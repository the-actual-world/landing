<?php

if (isset($_COOKIE['id']) && $_COOKIE['id'] != '') {
    $_SESSION['id'] = $_COOKIE['id'];
    $_SESSION['isLoggedIn'] = true;
}

if (!isset($_SESSION['isLoggedIn'])) {
    header('Location: ' . $arrConfig['url_site'] . '/admin/login.php');
    exit();
}
