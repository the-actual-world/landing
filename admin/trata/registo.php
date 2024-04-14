<?php
include '../../include/config.inc.php';

if (!isset($_POST['inputFirstName']) || !isset($_POST['inputLastName']) || !isset($_POST['inputEmail']) || !isset($_POST['inputPassword']) || !isset($_POST['inputPasswordConfirm']) || !isset($_POST['inputFirstName'])) {
    header('Location: ' . $arrConfig['url_site'] . '/admin/register.php?error=1');
    exit();
}

if ($_POST["inputPassword"] != $_POST["inputPasswordConfirm"]) {
    header('Location: ' . $arrConfig['url_site'] . '/admin/register.php?error=2');
    exit();
}

$queryCheckUsers = 'SELECT * FROM utilizadores WHERE email = "' . $_POST['inputEmail'] . '"';
$checkUsers = my_query($queryCheckUsers);
if (count($checkUsers) > 0) {
    header('Location: ' . $arrConfig['url_site'] . '/admin/register.php?error=3');
    exit();
}

$password_hash = password_hash($_POST['inputPassword'], PASSWORD_DEFAULT);

$queryCriarUtilizador = 'INSERT INTO utilizadores (primeiro_nome, ultimo_nome, email, password) VALUES ("' . $_POST['inputFirstName'] . '", "' . $_POST['inputLastName'] . '", "' . $_POST['inputEmail'] . '", "' . $password_hash . '")';
my_query($queryCriarUtilizador);

header('Location: ' . $arrConfig['url_site'] . '/admin/login.php');
exit();
