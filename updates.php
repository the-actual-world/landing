<?php
include_once 'include/config.inc.php';

$page_title = t('Updates');
$page_description = t('UpdatesSubtitle');
$page_keywords = t('UpdatesKeywords');

include 'include/ui/header.php';

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$limit = 15;
$offset = ($page - 1) * $limit;

$total_atualizacoes = my_query("SELECT COUNT(*) AS total FROM atualizacoes WHERE ativo = 1")[0]['total'];
$total_pages = ceil($total_atualizacoes / $limit);

if ($page > $total_pages || $page < 1) {
  redirect('updates');
}

$atualizacoes = my_query("SELECT A.*, B.* FROM atualizacoes A INNER JOIN atualizacoes_lang B ON A.id = B.id WHERE ativo = 1 AND B.lang = '$_SESSION[lang]' ORDER BY data DESC LIMIT $limit OFFSET $offset");

add_log('atualizacoes', 'VER_ATUALIZACOES');
?>

<main id="main">

  <!-- ======= Blog Section ======= -->
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
                <?php echo t('Updates') ?>
              </h1>
              <p class="mb-5" data-aos="fade-up" data-aos-delay="100">
                <?php echo t('UpdatesSubtitle') ?>
              </p>
              <div data-aos="fade-up" data-aos-delay="200">
                <p><strong>
                    <?php echo $page ?>
                  </strong>/<strong>
                    <?php echo $total_pages ?>
                  </strong></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>

  <section class="section">
    <div class="container">
      <div class="grid row">

        <?php foreach ($atualizacoes as $index => $atualizacao) { ?>
          <div class="col-4" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
            <div class="card">
              <div class="post-entry px-3" <?php echo $atualizacao['tipo'] == 'correcao' ? 'correcao' : ($atualizacao['tipo'] == 'melhoria' ? 'melhoria' : 'nova-funcionalidade'); ?>">
                <a href="update?id=<?php echo $atualizacao['id']; ?>" class="d-block my-3">
                  <div style="position: relative; width: 100%; height: 200px; overflow: hidden;" class="rounded">
                    <img src="assets/img/atualizacoes/<?php echo $atualizacao['imagem']; ?>" alt="Image" class="img-fluid"
                      style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 100%;">
                  </div>
                </a>
                <div class="post-text">
                  <span class="post-meta">
                    <?php if ($atualizacao['tipo'] == 'correcao') { ?>
                      <span class="badge bg-danger">
                        <?php echo t('BugFix') ?>
                      </span>
                    <?php } else if ($atualizacao['tipo'] == 'melhoria') { ?>
                        <span class="badge bg-warning">
                        <?php echo t('Improvement') ?>
                        </span>
                    <?php } else { ?>
                        <span class="badge bg-success">
                        <?php echo t('NewFeature') ?>
                        </span>
                    <?php } ?>
                    <?php echo formatLargeDate(strtotime($atualizacao['data'])); ?> &bullet; <a
                      href="https://www.linkedin.com/in/rodrigo-dias-177310209/" target="_blank">
                      Rodrigo Dias
                    </a>
                  </span>
                  <h3><a href="update?id=<?php echo $atualizacao['id']; ?>">
                      <?php echo $atualizacao['titulo']; ?>
                    </a>
                  </h3>
                  <p>
                    <?php echo htmlspecialchars_decode(substr($atualizacao['conteudo'], 0, 100)); ?>...
                  </p>
                  <p><a href="update?id=<?php echo $atualizacao['id']; ?>" class="readmore">
                      <?php echo t('ReadMore') ?>
                    </a></p>
                </div>
              </div>
            </div>
          </div>
        <?php } ?>

      </div>

      <div class="row">
        <div class="col-12 text-center">
          <!-- <span class="p-3 active text-primary">1</span>
          <a href="#" class="p-3">2</a>
          <a href="#" class="p-3">3</a>
          <a href="#" class="p-3">4</a> -->
          <?php if ($page > 1) { ?>
            <a href="updates?page=<?php echo $page - 1; ?>" class="p-3">
              <?php echo t('Previous') ?>
            </a>
          <?php } ?>
          <?php if ($page < $total_pages) { ?>
            <a href="updates?page=<?php echo $page + 1; ?>" class="p-3">
              <?php echo t('Next') ?>
            </a>
          <?php } ?>
        </div>
      </div>
    </div>

  </section>

  <?php include 'include/ui/cta-section.php'; ?>

</main><!-- End #main -->

<?php include 'include/ui/footer.php'; ?>