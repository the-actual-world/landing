<?php
include_once 'include/config.inc.php';

function selecionar_categorias_faq($pai = 0)
{
  global $arrConfig, $url_site_escola, $url_site_local;
  $categorias = my_query("SELECT id, icone, nome, id_pai FROM faq_categorias WHERE ativo = 1 AND id_pai = $pai");
  $arr = [];
  foreach ($categorias as $categoria) {
    $paginas = my_query("SELECT id, titulo, conteudo FROM faq WHERE ativo = 1 AND id_categoria = " . $categoria['id']);
    if ($arrConfig['url_site'] == $url_site_escola) {
      foreach ($paginas as $key => $pagina) {
        $paginas[$key]['conteudo'] = str_replace(
          $url_site_local,
          $url_site_escola,
          $pagina['conteudo']
        );
      }
    }

    array_push($arr, [
      'id' => $categoria['id'],
      'icone' => $categoria['icone'],
      'nome' => $categoria['nome'],
      'subcategorias' => selecionar_categorias_faq($categoria['id']),
      'paginas' => my_query("SELECT id, titulo, conteudo FROM faq WHERE ativo = 1 AND id_categoria = " . $categoria['id'])
    ]);
  }
  return $arr;
}

function selecionar_menu($pai = 0)
{
  $menu = my_query("SELECT id, titulo, url, id_pai FROM menu WHERE ativo = 1 AND id_pai = $pai ORDER BY ordem ASC");
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
?>

<!DOCTYPE html>
<html lang="pt">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <link
    href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
    rel="stylesheet">

  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/lightbox2/dist/css/lightbox.min.css" rel="stylesheet">
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex justify-content-between align-items-center">

      <div class="logo">
        <a href="<?php echo $arrConfig['url_site'] ?>"><img src="assets/img/logo.png" alt="" class="img-fluid"
            style="filter:brightness(0) invert(1)"></a>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <?php
          $path = $_GET['path'] ?? 'index';
          ?>
          <!-- <li><a href="<?php echo $arrConfig['url_site'] ?>"
              class="<?php echo $path === 'index' ?? 'active' ?>">Início</a>
          </li>
          <li><a href="about" class="<?php echo $path === 'about' ?? 'active' ?>">Sobre</a></li>
          <li><a href="pricing" class="<?php echo $path === 'pricing' ?? 'active' ?>">Preço</a></li>
          <li><a href="catalog" class="<?php echo $path === 'catalog' ?? 'active' ?>">Catálogo</a></li>
          <li><a href="updates" class="<?php echo $path === 'updates' ?? 'active' ?>">Atualizações</a></li>
          <li><a href="contact" class="<?php echo $path === 'contact' ?? 'active' ?>">Contacto</a></li> -->
          <?php mostrar_menu($menu); ?>
          <li class="dropdown"><a href="help"><span>Ajuda</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <?php mostrar_categorias_faq($categorias_faq); ?>
            </ul>
          </li>
          <li style="margin-left: 20px"><a href="download" class="btn btn-primary" target="_blank">Instalar</a></li>

        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav>

    </div>
  </header>