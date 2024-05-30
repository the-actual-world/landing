<?php
include_once 'include/config.inc.php';

function selecionar_categorias_faq($pai = 0)
{
  global $arrConfig, $url_site_school, $url_site_local, $url_site_prod;
  $categorias = my_query("SELECT A.id, A.icone, B.nome, A.id_pai FROM faq_categorias A INNER JOIN faq_categorias_lang B ON A.id = B.id WHERE A.ativo = 1 AND A.id_pai = $pai AND B.lang = '" . $_SESSION['lang'] . "' ORDER BY B.nome ASC");
  $arr = [];
  foreach ($categorias as $categoria) {
    $paginas = my_query("SELECT A.id, B.titulo, B.conteudo FROM faq A INNER JOIN faq_lang B ON A.id = B.id WHERE A.ativo = 1 AND A.id_categoria = " . $categoria['id'] . " AND B.lang = '" . $_SESSION['lang'] . "'");
    if ($arrConfig['url_site'] == $url_site_school) {
      foreach ($paginas as $key => $pagina) {
        $paginas[$key]['conteudo'] = str_replace(
          $url_site_local,
          $url_site_school,
          $pagina['conteudo']
        );
      }
    } else if ($arrConfig['url_site'] == $url_site_prod) {
      foreach ($paginas as $key => $pagina) {
        $paginas[$key]['conteudo'] = str_replace(
          $url_site_local,
          $url_site_prod,
          $pagina['conteudo']
        );
      }
    }

    array_push($arr, [
      'id' => $categoria['id'],
      'icone' => $categoria['icone'],
      'nome' => $categoria['nome'],
      'subcategorias' => selecionar_categorias_faq($categoria['id']),
      'paginas' => my_query("SELECT A.id, B.titulo, B.conteudo FROM faq A INNER JOIN faq_lang B ON A.id = B.id WHERE A.ativo = 1 AND A.id_categoria = " . $categoria['id'] . " AND B.lang = '" . $_SESSION['lang'] . "'"),
    ]);
  }
  return $arr;
}

function selecionar_menu($pai = 0)
{
  // $menu = my_query("SELECT id, titulo, url, id_pai FROM menu WHERE ativo = 1 AND id_pai = $pai ORDER BY ordem ASC");
  $menu = my_query("SELECT A.id, B.titulo, A.url, A.id_pai FROM menu A INNER JOIN menu_lang B ON A.id = B.id WHERE A.ativo = 1 AND A.id_pai = $pai AND B.lang = '" . $_SESSION['lang'] . "' ORDER BY A.ordem ASC");
  $arr = [];
  foreach ($menu as $item) {
    array_push($arr, [
      'id' => $item['id'],
      'titulo' => $item['titulo'],
      'url' => $item['url'],
      'submenus' => selecionar_menu($item['id'])
    ]);
  }
  return $arr;
}

function mostrar_menu($menu)
{
  global $arrConfig;
  foreach ($menu as $item) {
    $tem_filhos = count($item['submenus']) > 0;
    $dropdown = $tem_filhos ? 'dropdown' : '';
    echo '<li class="' . $dropdown . '"><a href="' . $arrConfig['url_site'] . '/' . $item['url'] . '">' . $item['titulo'] . ($tem_filhos ? '<i class="bi bi-chevron-down"></i>' : "") . '</a>';
    if ($tem_filhos) {
      echo '<ul>';
      mostrar_menu($item['submenus']);
      echo '</ul>';
    }
    echo '</li>';
  }
}

$menu = selecionar_menu();
$categorias_faq = selecionar_categorias_faq();

function mostrar_categorias_faq($categorias)
{
  foreach ($categorias as $categoria) {
    $tem_filhos = count($categoria['subcategorias']) > 0;
    $dropdown = $tem_filhos ? 'dropdown' : '';
    echo '<li class="' . $dropdown . '"><a href="help?id=' . $categoria['id'] . '">' . '<span class="d-flex gap-2 align-items-center"><i class="' . $categoria['icone'] . '"></i>' . $categoria['nome'] . "</span>" . ($tem_filhos ? '<i class="bi bi-chevron-down"></i>' : "") . '</a>';
    if ($tem_filhos) {
      echo '<ul>';
      mostrar_categorias_faq($categoria['subcategorias']);
      echo '</ul>';
    }
    echo '</li>';
  }
}

function filter_seo_value($value)
{
  // allow letters, numbers, spaces, hyphens, underscores, and periods and letters with accents as well as ç
  return preg_replace('/[^a-zA-Z0-9\s\-_áéíóúãõâêîôûàèìòùç.]/', '', $value);
}

// SEO
$page_title = isset($page_title) ? filter_seo_value($page_title) . t("GlobalPageTitleSuffix") : t("GlobalPageTitle");
$page_description = isset($page_description) ? filter_seo_value($page_description) . t('GlobalPageDescriptionSuffix') : t('GlobalPageDescription');
$page_keywords = (isset($page_keywords) ? filter_seo_value($page_keywords) . ", " : "") . t('GlobalPageKeywords');
$current_page = basename($_SERVER['PHP_SELF']);

?>

<!DOCTYPE html>
<html lang="<?php echo $_SESSION['lang'] ?>">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <!-- Dynamic Title based on page -->
  <title><?php echo $page_title ?></title>
  <!-- Meta Description -->
  <meta name="description" content="<?php echo $page_description; ?>">
  <!-- Meta Keywords -->
  <meta name="keywords" content="<?php echo $page_keywords; ?>">

  <!-- Open Graph Meta Tags -->
  <meta property="og:title" content="<?php echo $page_title; ?>">
  <meta property="og:description" content="<?php echo $page_description; ?>">
  <meta property="og:type" content="website">
  <meta property="og:url" content="<?php echo $arrConfig['url_site'] . '/' . $current_page; ?>">
  <meta property="og:image" content="<?php echo $arrConfig['url_site'] . '/assets/img/logo.png'; ?>">

  <!-- Twitter Card Meta Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="<?php echo $page_title; ?>">
  <meta name="twitter:description" content="<?php echo $page_description; ?>">
  <meta name="twitter:image" content="<?php echo $arrConfig['url_site'] . '/assets/img/logo.png'; ?>">

  <!-- Robots Meta Tag -->
  <meta name="robots" content="index, follow">

  <!-- Canonical Link -->
  <link rel="canonical" href="<?php echo $arrConfig['url_site'] . '/' . $current_page; ?>">

  <!-- Favicon and Apple Touch Icon -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link
    href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/lightbox2/dist/css/lightbox.min.css" rel="stylesheet">
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

  <!-- Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex justify-content-between align-items-center">

      <div class="logo">
        <a href="<?php echo $arrConfig['url_site'] ?>"><img
            src="<?php echo $arrConfig['url_site'] ?>/assets/img/logo.png" alt="" class="img-fluid"
            style="filter:brightness(0) invert(1)"></a>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <?php
          $path = $_GET['path'] ?? 'index';
          ?>

          <?php mostrar_menu($menu); ?>
          <li class="dropdown"><a href="help"><span><?php echo t('Help') ?></span> <i
                class="bi bi-chevron-down"></i></a>
            <ul>
              <?php mostrar_categorias_faq($categorias_faq); ?>
            </ul>
          </li>

          <li class="dropdown"><a href="about"><span><?php echo t('Language') ?></span> <i
                class="bi bi-chevron-down"></i></a>
            <ul>
              <?php
              foreach ($arrConfig['langs'] as $slug => $lang) {
                echo '
                <li>
                    <a href="' . $arrConfig["url_site"] . '/forms/lang.inc.php?lang=' . $slug . '">
                        <img src="' . $arrConfig["url_site"] . '/assets/flags/' . $slug . '.svg" alt="' . $lang . '" width="30">
                        <span>' . $lang . '</span>
                    </a>
                </li>
                ';
              }
              ?>
            </ul>
          </li>

          <li style="margin-left: 20px"><button class="btn btn-primary" data-bs-toggle="modal"
              data-bs-target="#modalDownload">
              <?php echo t('Download') ?>
            </button></li>

        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>

    </div>
  </header>