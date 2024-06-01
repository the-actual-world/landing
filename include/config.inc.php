<?php
@session_start();
global $arrConfig, $arrLangs;

// Configurações de debug
if ($_SERVER['HTTP_HOST'] == 'web.colgaia.local' || $_SERVER['HTTP_HOST'] == 'localhost') {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}

// Configurações de idioma
$arrConfig['langs'] = array('en' => 'English', 'pt' => 'Português');
if (isset($_COOKIE["lang"])) {
    if (!isset($_SESSION["lang"])) {
        $_SESSION["lang"] = $_COOKIE["lang"];
    }
}
if (!isset($_SESSION["lang"])) {
    // $_SESSION["lang"] = "en";
    // setcookie("lang", "en", time() + 86400 * 100, "/");
    // set the language to either pt or en, depending on the browser's language
    $browserLang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    if (array_key_exists($browserLang, $arrConfig['langs'])) {
        $_SESSION["lang"] = $browserLang;
        setcookie("lang", $browserLang, time() + 86400 * 100, "/");
    } else {
        $_SESSION["lang"] = "en";
        setcookie("lang", "en", time() + 86400 * 100, "/");
    }
}

// Configurações de URL e diretórios
$url_site_prod = 'https://theactualworld.com';
$url_site_local = 'http://localhost/projeto-backoffice';
$url_site_school = 'http://web.colgaia.local/12itm212/projeto-backoffice';

$not_localhost_urls = array($url_site_prod, $url_site_school);

// Configurações de URL e diretórios
if ($_SERVER['HTTP_HOST'] == 'web.colgaia.local') {
    $arrConfig['url_site'] = $url_site_school;
    $arrConfig['dir_site'] = 'C:/Share/12itm212/www/projeto-backoffice';
} else if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $arrConfig['url_site'] = $url_site_local;
    if (PHP_OS == 'Linux') {
        $arrConfig['dir_site'] = '/home/kraktoos/dev/projeto-backoffice';
    } else {
        $arrConfig['dir_site'] = 'C:/xampp/htdocs/projeto-backoffice';
    }
} else if ($_SERVER['HTTP_HOST'] == 'theactualworld.com') {
    $arrConfig['url_site'] = $url_site_prod;
    $arrConfig['dir_site'] = "/home/taw/htdocs/theactualworld.com/current";
}

// Carregar variáveis de ambiente
$env = file_get_contents($arrConfig['dir_site'] . '/include/.env');
$env_lines = explode("\n", $env);
$env = [];
foreach ($env_lines as $line) {
    $line = trim($line);
    if ($line == '') {
        continue;
    }
    $parts = explode('=', $line);
    // get all the last parts
    $new_parts = array_slice($parts, 1);
    $env[$parts[0]] = implode('=', $new_parts);
}

// Configurações de base de dados
$arrConfig['servername'] = 'localhost';
if ($_SERVER['HTTP_HOST'] == 'web.colgaia.local') {
    $arrConfig['username'] = $env['DB_SCHOOL_USER'];
    $arrConfig['password'] = $env['DB_SCHOOL_PASS'];
    $arrConfig['dbname'] = $env['DB_SCHOOL_NAME'];
} else if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $arrConfig['username'] = $env['DB_LOCAL_USER'];
    $arrConfig['password'] = $env['DB_LOCAL_PASS'];
    $arrConfig['dbname'] = $env['DB_LOCAL_NAME'];
} else if ($_SERVER['HTTP_HOST'] == 'theactualworld.com') {
    $arrConfig['username'] = $env['DB_PROD_USER'];
    $arrConfig['password'] = $env['DB_PROD_PASS'];
    $arrConfig['dbname'] = $env['DB_PROD_NAME'];
}

// Configurações de URL e diretórios para o admin
$folderAdmin = 'admin';
$arrConfig['url_admin'] = $arrConfig['url_site'] . '/' . $folderAdmin;
$arrConfig['dir_admin'] = $arrConfig['dir_site'] . '/' . $folderAdmin;

// Configurações de URL e diretórios para o front
$arrConfig['url_fotos'] = $arrConfig['url_site'] . '/upload';
$arrConfig['dir_fotos'] = $arrConfig['dir_site'] . '/upload';
$arrConfig['fotos_auth'] = array('image/jpeg', 'image/jpg', 'image/png', 'image/gif');
$arrConfig['fotos_maxUpload'] = 3000000;

/// Configurações de paginação
$arrConfig['pagination'] = 15;

// Outros includes
include_once $arrConfig['dir_site'] . '/include/functions.inc.php';
include_once $arrConfig['dir_site'] . '/include/db.inc.php';
include_once $arrConfig['dir_site'] . '/include/langs/' . $_SESSION['lang'] . '.inc.php';

$errorMap = [
    1 => t("ErrorFillAllFields"),
    2 => t("ErrorPasswordsDontMatch"),
    3 => t("ErrorEmailAlreadyExists"),
    4 => t("ErrorInvalidCredentials"),
];

date_default_timezone_set(t('_Timezone'));
setlocale(LC_ALL, t('_Locale'), t('_LocaleFallback'), t('_LocaleNextFallback'));