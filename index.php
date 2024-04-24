<?php
include_once 'include/config.inc.php';

$path = $_GET['path'] ?? 'index';

error_reporting(0);

if (strpos($path, 'admin') != false) {
  exit;
} else if ($path == '' || $path == 'index' || $path == 'index.php') {
  include 'home.php';
  exit;
} else if (file_exists($path . '.php')) {
  include $path . '.php';
  exit;
}

$page = my_query("SELECT titulo, conteudo FROM paginas WHERE url = '$path' AND ativo = 1")[0] ?? null;

if ($page != null) {
  if (strpos($page['conteudo'], '<?php') !== false) {
    $page['conteudo'] = eval ('?>' . $page['conteudo']);
  } else {
    echo $page['conteudo'];
  }
  echo '<script>document.title = "The Actual World - ' . $page['titulo'] . '";</script>';
  exit;
}

$page = my_query("SELECT imagem, titulo, conteudo FROM conteudo WHERE slug = '$path' AND ativo = 1")[0] ?? null;

if ($page != null) {
  eval ('?>' . '
  <?php
    include "include/ui/header.php";
    include_once "include/config.inc.php";

    add_log("PAGINA", "' . $path . '");
    ?>

    <main id="main">

      <!-- ======= FeatPricingures Section ======= -->
      <div class="hero-section inner-page">
        <div class="wave">

          <svg width="1920px" height="265px" viewBox="0 0 1920 265" version="1.1" xmlns="http://www.w3.org/2000/svg"
            xmlns:xlink="http://www.w3.org/1999/xlink">
            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
              <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
                <path
                  d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,667 L1017.15166,667 L0,667 L0,439.134243 Z"
                  id="Path"></path>
              </g>
            </g>
          </svg>

        </div>

        <div class="container">
          <div class="row align-items-center">
            <div class="col-12">
              <div class="row justify-content-center">
                <div class="col-md-7 text-center hero-text">
                  <h1 data-aos="fade-up" data-aos-delay="">
                    ' . $page['titulo'] . '
                  </h1>
                  <img src="' . $arrConfig['url_site'] . '/assets/img/conteudo/' . $page['imagem'] . '" alt="' . $page['titulo'] . '" class="img-fluid rounded-circle" data-aos="fade-up" data-aos-delay="100" width="120">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <section class="section">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <p>
                ' . $page['conteudo'] . '
              </p>
            </div>
          </div>
        </div>
      </section>

      <?php include "include/ui/cta-section.php"; ?>

    </main>

    <?php include "include/ui/footer.php"; ?>
  ');

  echo '<script>document.title = "The Actual World - ' . $page['titulo'] . '";</script>';
  die;
}


$page['titulo'] = 'Página não encontrada';
$page['conteudo'] = '
  <?php include \'include/ui/header.php\'; ?>
  <?php
    add_log(\'404\', \'PAGINA_NAO_ENCONTRADA\');
  ?>

  <section class="hero-section" id="hero">
    <div class="container">
      <div class="row align-items-center p-0">
        <div class="col-12 hero-text-image">
          <h1 class="mb-0">
            404
          </h1>
          <h2 class="text-white">
            Página não encontrada
          </h2>
          <p>
            A página que procura não foi encontrada.
          </p>
          <a href="<?php echo $arrConfig[\'url_site\'] ?>" class="btn btn-primary">
            Voltar
          </a>
        </div>
      </div>
    </div>
  </section>

  <?php include \'include/ui/footer.php\'; ?>
';