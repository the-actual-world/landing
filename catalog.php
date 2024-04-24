<?php
include 'include/ui/header.php';
include_once 'include/config.inc.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 15;
$offset = ($page - 1) * $limit;

$total_produtos = my_query("SELECT COUNT(*) as total FROM produtos WHERE ativo = 1")[0]['total'];
$total_pages = ceil($total_produtos / $limit);

if ($page > $total_pages || $page < 1) {
  redirect('catalog');
}

$produtos = my_query("SELECT * FROM produtos WHERE ativo = 1 LIMIT $limit OFFSET $offset");
$imagens = [];

foreach ($produtos as $k => $v) {
  $imagens[$v['id']] = my_query("SELECT * FROM produtos_imagens WHERE id_produto = '$v[id]' AND ativo = 1 ORDER BY ordem");
}

add_log('catalogo', 'VER_CATALOGO');
?>

<section class="hero-section" id="hero">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 col-sm-12 hero-text-image">
        <h1>
          <?php echo t('Catalog') ?>
        </h1>
        <p>
          <?php echo t('CatalogSubtitle') ?>
        </p>
        <div>
          <p><strong>
              <?php echo $page ?>
            </strong>/<strong>
              <?php echo $total_pages ?>
            </strong></p>
        </div>
      </div>
      <div class="col-md-6 col-sm-12">
        <div class="swiper hero-products-slider">
          <div class="swiper-wrapper">
            <?php foreach ($produtos as $produto) { ?>
              <div class="swiper-slide">
                <a href="product?id=<?php echo $produto['id'] ?>&name=<?php echo $produto['nome'] ?>">
                  <img src="assets/img/produtos/<?php echo $imagens[$produto['id']][0]['imagem'] ?>"
                    alt="<?php echo $produto['nome'] ?>" class="img-fluid">
                </a>
              </div>
            <?php } ?>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </div>
</section>

<main id="main">
  <section class="section">
    <div class="container">
      <div class="row">
        <?php foreach ($produtos as $produto) { ?>
          <div class="col-lg-4 col-md-6 col-sm-12">
            <div class="card">
              <div class="swiper products-slider">
                <div class="swiper-wrapper">
                  <?php foreach ($imagens[$produto['id']] as $imagem) { ?>
                    <div class="swiper-slide">
                      <img src="assets/img/produtos/<?php echo $imagem['imagem'] ?>" class="card-img-top"
                        alt="<?php echo $produto['nome'] ?>">
                    </div>
                  <?php } ?>
                </div>
                <div class="swiper-pagination"></div>
              </div>
              <div class="card-body">
                <h5 class="card-title">
                  <?php echo $produto['nome'] ?>
                </h5>
                <p class="card-text text-truncate">
                  <?php echo $produto['descricao'] ?>
                </p>
                <div class="d-flex align-items-center justify-content-between">
                  <a href="product?id=<?php echo $produto['id'] ?>&name=<?php echo $produto['nome'] ?>"
                    class="btn btn-primary">
                    <?php echo t('ViewProduct') ?>
                  </a>
                  <h4><span class="badge bg-info">
                      <?php echo $produto['preco'] ?>€
                    </span></h4>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
      <div class="row mt-4">
        <div class="col-12">
          <nav aria-label="Pagination">
            <ul class="pagination justify-content-center">
              <li class="page-item <?php echo $page == 1 ? 'disabled' : '' ?>">
                <a class="page-link" href="catalog?page=<?php echo $page - 1 ?>" aria-label="Previous">
                  <span aria-hidden="true">&laquo;</span>
                </a>
              </li>
              <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                <li class="page-item <?php echo $page == $i ? 'active' : '' ?>"><a class="page-link"
                    href="catalog?page=<?php echo $i ?>">
                    <?php echo $i ?>
                  </a></li>
              <?php } ?>
              <li class="page-item <?php echo $page == $total_pages ? 'disabled' : '' ?>">
                <a class="page-link" href="catalog?page=<?php echo $page + 1 ?>" aria-label="Next">
                  <span aria-hidden="true">&raquo;</span>
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </section>

  <?php render_page_title('Catalog') ?>

  <?php include 'include/ui/cta-section.php'; ?>
</main>

<?php include 'include/ui/footer.php'; ?>