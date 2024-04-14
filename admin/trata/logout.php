<?php
include '../../include/config.inc.php';

$_SESSION["isLoggedIn"] = false;
$_SESSION["id"] = null;

session_destroy();

setcookie('id', '', time() - 3600, '/');

header('Location: ' . $arrConfig['url_site'] . '/admin/login.php');
exit();