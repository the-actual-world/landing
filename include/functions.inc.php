<?php
function pr($arr)
{
    echo '<pre>';
    print_r($arr);
    echo '</pre>';
}

function t($key)
{
    global $arrLangs;
    return $arrLangs[$key] ?? $key;
}

function clean_name($string)
{
    $string = str_replace(' ', '_', $string);
    return preg_replace('/[^A-Za-z0-9\_.]/', '', $string);
}

function get_user_ip_address()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
        $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote = $_SERVER['REMOTE_ADDR'];

    if (filter_var($client, FILTER_VALIDATE_IP)) {
        $ip = $client;
    } elseif (filter_var($forward, FILTER_VALIDATE_IP)) {
        $ip = $forward;
    } else {
        $ip = $remote;
    }

    return $ip;
}

function add_log($modulo = null, $acao = null, $pagina = null, $de_onde = null)
{
    $modulo = $modulo ? $modulo : explode('/', $_SERVER['REQUEST_URI'])[count(explode('/', $_SERVER['REQUEST_URI'])) - 1];
    $acao = $acao ? $acao : $_SERVER['REQUEST_METHOD'];
    $pagina = $pagina ? $pagina : $_SERVER['REQUEST_URI'];
    $de_onde = $de_onde ? $de_onde : (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
    $user = isset($_SESSION['id']) ? $_SESSION['id'] : 0;
    $ip = get_user_ip_address();
    $sessao = session_id();
    $data = date('Y-m-d H:i:s');

    $q = "INSERT INTO logs (pagina, modulo, acao, id_utilizador, endereco_ip, id_sessao, de_onde, data) VALUES ('$pagina', '$modulo', '$acao', $user, '$ip', '$sessao', '$de_onde', '$data')";
    my_query($q);
}

function formatLargeDate($data)
{
    $dia = date('d', $data);

    $meses = array(
        1 => t('January'),
        2 => t('February'),
        3 => t('March'),
        4 => t('April'),
        5 => t('May'),
        6 => t('June'),
        7 => t('July'),
        8 => t('August'),
        9 => t('September'),
        10 => t('October'),
        11 => t('November'),
        12 => t('December'),
    );

    $mes = date('n', $data);
    $ano = date('Y', $data);

    switch ($_SESSION["lang"]) {
        case 'en':
            return "{$meses[$mes]} $dia, $ano";
        case 'pt':
            return "$dia de {$meses[$mes]} de $ano";
    }
}

function redirect($url)
{
    echo "<script>window.location.href = '$url'</script>";
}

function server_redirect($url)
{
    header("Location: $url");
    exit;
}