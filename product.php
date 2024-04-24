<?php
include 'include/ui/header.php';
include_once 'include/config.inc.php';

if (!isset($_GET['id'])) {
  redirect($arrConfig['url_site'] . '/404');
}
$id = $_GET['id'];

//SELECT * FROM produtos A INNER JOIN (SELECT imagem, id_produto, ordem AS ordem_i FROM produtos_imagens ORDER BY ordem_i) B ON A.id = B.id_produto INNER JOIN (SELECT ordem AS ordem_c, nome AS nome_c, valor AS valor_c, id_produto AS id_produto_c FROM produtos_caracteristicas ORDER BY ordem_c) C ON A.id = C.id_produto_c WHERE id = $id AND ativo = 1 LIMIT 1;
$produtos = my_query("SELECT * FROM produtos WHERE id = $id AND ativo = 1 LIMIT 1");
if (count($produtos) == 0) {
  redirect($arrConfig['url_site'] . '/404');
}
$produto = $produtos[0];

// para o SEO
if (!isset($_GET['name']) || $_GET['name'] != $produto['nome']) {
  redirect($arrConfig['url_site'] . '/product?id=' . $id . '&name=' . $produto['nome']);
}

$imagens = my_query("SELECT * FROM produtos_imagens WHERE id_produto = $id AND ativo = 1 ORDER BY ordem");
$caracteristicas = my_query("SELECT * FROM produtos_caracteristicas WHERE id_produto = $id AND ativo = 1 ORDER BY ordem");

add_log('produto', 'VER_PRODUTO');
?>

<style>
  @media (max-width: 768px) {
    .small-hide {
      display: none !important;
    }
  }
</style>

<section class="hero-section" id="hero">
  <div class="container">
    <div class="row align-items-center p-0">
      <div class="col-md-8 col-sm-12 hero-text-image">
        <h1>
          <?php echo $produto['nome'] ?>
        </h1>
        <p>
          <?php echo $produto['descricao'] ?>
        </p>
        <div class="d-flex gap-2 align-items-center">
          <button class="btn btn-primary fw-bold">
            <?php echo t('Buy') ?>
          </button>
          <button class="btn btn-outline-white">
            <?php echo t('AddToCart') ?>
          </button>
          <h3>
            <span class="badge bg-info">
              <?php echo $produto['preco'] ?>€
            </span>
            <span class="badge bg-danger cross">
              <del>
                <?php echo round($produto['preco'] * 2) ?>€
              </del>
            </span>
          </h3>
        </div>
      </div>
      <div class="col-md-4 h-100 small-hide">
        <?php
        echo "<img src='assets/img/produtos/" . $imagens[0]["imagem"] . "' alt='$produto[nome]' class='fill object-fit-cover bg-position-right'>";
        ?>
      </div>
    </div>
  </div>
</section>

<main id="main">

  <section class="section">
    <div class="container">
      <div class="row">
        <div class="col-lg-8">
          <div class="row">
            <div class="col-md-12">
              <h2>
                <?php echo t("Description") ?>
              </h2>
              <p>
                <?php echo $produto['descricao'] ?>
              </p>
            </div>
            <div class="col-md-12">
              <h2>
                <?php echo t("Attributes") ?>
              </h2>
              <table class="table table-striped">
                <tbody>
                  <?php
                  foreach ($caracteristicas as $caracteristica) {
                    echo "<tr><td>$caracteristica[nome]</td><td>$caracteristica[valor]</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="row">
            <div class="col-md-12">
              <h2>
                <?php echo t("Images") ?>
              </h2>
              <div class="row">
                <?php
                foreach ($imagens as $imagem) {
                  echo "<a class='col-md-6' href='" . $arrConfig['url_site'] . "/assets/img/produtos/$imagem[imagem]' data-lightbox='$produto[id]' data-title='$produto[nome]'><img src='assets/img/produtos/$imagem[imagem]' alt='$produto[nome]' class='img-fluid'></a>";
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Produtos relacionados</h2>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <img src="assets/img/produtos/1.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">Produto 1</h5>
                            <p class="card-text">Descrição do produto 1</p>
                            <a href="#" class="btn btn-primary">Comprar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card">
                        <img src="assets/img/produtos/2.jpg" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title
                            fw-bold">Produto 2</h5>
                            <p class="card-text">Descrição do produto 2</p>
                            <a href="#" class="btn btn-primary">Comprar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

  <?php render_page_title('Product') ?>

  <?php include 'include/ui/cta-section.php'; ?>
</main>


<?php include 'include/ui/footer.php'; ?>