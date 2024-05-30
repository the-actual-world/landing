<?php
include_once 'include/config.inc.php';

$id_categoria = $_GET['id'] ?? 0;

if ($id_categoria != 0) {
  $resultados = my_query("SELECT A.id, B.nome, A.icone, A.id_pai FROM faq_categorias A INNER JOIN faq_categorias_lang B ON A.id = B.id WHERE A.id = '$id_categoria' AND B.lang = '" . $_SESSION['lang'] . "'");
  if (count($resultados) != 0) {
    $categoria = $resultados[0];
    $categorias_abertas = array($id_categoria);
    if ($categoria['id_pai'] != 0) {
      $categoria_pai = $categoria;
      while ($categoria_pai['id_pai'] != 0 && count($categoria_pai) > 0) {
        array_unshift($categorias_abertas, $categoria_pai['id_pai']);
        $categoria_pai = my_query("SELECT A.id, A.id_pai FROM faq_categorias A INNER JOIN faq_categorias_lang B ON A.id = B.id WHERE A.id = " . $categoria_pai['id_pai'] . " AND B.lang = '" . $_SESSION['lang'] . "'")[0];
      }
    }
  } else {
    redirect($arrConfig['url_site'] . '/help');
  }
}

$page_title = isset($categoria['nome']) ? $categoria['nome'] : t('Help');
$page_description = t('HelpSubtitle') . (isset($categoria['nome']) ? t('HelpSubtitle2') . $categoria['nome'] . t('HelpSubtitle3') : '');
$page_keywords = $page_title;

include 'include/ui/header.php';

function mostrar_categorias_faq_large($categorias)
{
  global $id_categoria, $url_site_local, $url_site_prod, $arrConfig;
  foreach ($categorias as $categoria) {
    $tem_filhos = count($categoria['subcategorias']) > 0;
    echo '<div class="accordion mb-2" id="categoria-' . $categoria['id'] . '">';
    echo '<div class="accordion-item">';
    echo '<h2 class="accordion-header" id="heading-' . $categoria['id'] . '">';
    echo '<button class="accordion-button d-flex gap-2 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-' . $categoria['id'] . '" aria-expanded="false" aria-controls="collapse-' . $categoria['id'] . '" id="categoria-' . $categoria['id'] . '">';
    echo '<i class="' . $categoria['icone'] . '"></i><span>' . $categoria['nome'] . '</span>';
    echo '</button>';
    echo '</h2>';
    echo '<div id="collapse-' . $categoria['id'] . '" class="accordion-collapse collapse  aria-labelledby="heading-' . $categoria['id'] . '" data-bs-parent="#categoria-' . $categoria['id'] . '">';
    echo '<div class="accordion-body">';
    if ($tem_filhos) {
      echo '<div class="accordion" id="subcategoria-' . $categoria['id'] . '">';
      foreach ($categoria['subcategorias'] as $subcategoria) {
        mostrar_categorias_faq_large(array($subcategoria));
      }
      echo '</div>';
    }
    if (!empty($categoria['paginas'])) {
      echo '<div class="accordion" id="pagina-' . $categoria['id'] . '">';
      foreach ($categoria['paginas'] as $pagina) {
        echo '<div class="accordion-item">';
        echo '<h2 class="accordion-header" id="heading-pagina-' . $pagina['id'] . '">';
        echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-pagina-' . $pagina['id'] . '" aria-expanded="false" aria-controls="collapse-pagina-' . $pagina['id'] . '" id="pagina-' . $pagina['id'] . '">';
        echo $pagina['titulo'];
        echo '</button>';
        echo '</h2>';
        echo '<div id="collapse-pagina-' . $pagina['id'] . '" class="accordion-collapse collapse" aria-labelledby="heading-pagina-' . $pagina['id'] . '" data-bs-parent="#pagina-' . $categoria['id'] . '">';
        echo '<div class="accordion-body">';
        if ($arrConfig['url_site'] == $url_site_prod) {
          $pagina['conteudo'] = str_replace(
            $url_site_local,
            $url_site_prod,
            $pagina['conteudo']
          );
        }
        ;
        echo $pagina['conteudo'];
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }
      echo '</div>';
    }
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
  }
}

add_log('ajuda', 'VER_AJUDA');
?>

<main id="main">

  <section class="hero-section inner-page">
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
                <?php echo isset($categoria['nome']) ? $categoria['nome'] : t('Help'); ?>
              </h1>
              <p class="mb-5" data-aos="fade-up" data-aos-delay="100">
                <?php echo t("HelpSubtitle") ?>
                <?php echo isset($categoria['nome']) ? t("HelpSubtitle2") . $categoria['nome'] . t("HelpSubtitle3") : ''; ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="row">
        <?php mostrar_categorias_faq_large($categorias_faq); ?>
      </div>
    </div>
  </section>

  <?php include 'include/ui/cta-section.php'; ?>

</main><!-- End #main -->

<?php include 'include/ui/footer.php'; ?>

<script type="text/javascript">
  const categoriasToOpen = <?php echo json_encode($categorias_abertas); ?>;
  const delay = 750;
  categoriasToOpen.forEach((categoriaId, i) => {
    setTimeout(() => {
      document.querySelector('#categoria-' + categoriaId + ' button').click();
      document.querySelector('#categoria-' + categoriaId).scrollIntoView({
        behavior: 'smooth',
        block: 'center'
      });
    }, delay * (i + 1));
  })
</script>