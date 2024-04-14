<?php
include '../../include/config.inc.php';

if (!isset($_POST['inputEmail']) || !isset($_POST['inputPassword'])) {
    header('Location: ' . $arrConfig['url_site'] . '/admin/login.php?error=1');
    exit();
}

$password_hash = password_hash($_POST['inputPassword'], PASSWORD_DEFAULT);

$queryUtilizador = 'SELECT id, password FROM utilizadores WHERE email = "' . $_POST['inputEmail'] . '"';
$utilizador = my_query($queryUtilizador);

if (count($utilizador) == 0) {
    header('Location: ' . $arrConfig['url_site'] . '/admin/login.php?error=4');
    exit();
}

if (!password_verify($_POST['inputPassword'], $utilizador[0]['password'])) {
    header('Location: ' . $arrConfig['url_site'] . '/admin/login.php?error=4');
    exit();
}

header('Location: ' . $arrConfig['url_site'] . '/admin/index.php');
$_SESSION['isLoggedIn'] = true;
$_SESSION['id'] = $utilizador[0]["id"];

if (isset($_POST['inputRememberPassword'])) {
    setcookie('id', $utilizador[0]["id"], time() + 3600 * 24 * 30, '/');
}

die;
