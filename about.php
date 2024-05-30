<?php
include_once 'include/config.inc.php';

$page_title = t('AboutUs');
$page_description = t('AboutUsSubtitle');
$page_keywords = $page_title;

include 'include/ui/header.php';

$equipa = my_query("SELECT A.nome, B.cargo, A.imagem FROM equipa A INNER JOIN equipa_lang B ON A.id = B.id WHERE A.ativo = 1 AND B.lang = '" . $_SESSION['lang'] . "' ORDER BY A.ordem");
$seccoes_missao = my_query("SELECT B.titulo, B.descricao FROM seccoes_missao A INNER JOIN seccoes_missao_lang B ON A.id = B.id WHERE A.ativo = 1 AND B.lang = '" . $_SESSION['lang'] . "' ORDER BY A.ordem");

add_log('sobre', 'VER_SOBRE');
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
                <?php echo t('AboutUs') ?>
              </h1>
              <p class="mb-5" data-aos="fade-up" data-aos-delay="100">
                <?php echo t('AboutUsSubtitle') ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>

  <section class="section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6" data-aos="fade-up">
          <img src="assets/img/party.jpg" alt="Image" class="img-fluid rounded">
        </div>
        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
          <h2 class="mb-4"><?php echo t('WelcomeTitle') ?></h2>
          <p>
            <?php echo t('WelcomeSubtitle1') ?>
          </p>
          <p>
            <?php echo t('WelcomeSubtitle2') ?>
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="section bg-light border-top border-bottom">
    <div class="container">
      <div class="row justify-content-center text-center mb-5">
        <div class="col-md-8">
          <h2 class="section-heading"><?php echo t('OurMission') ?></h2>
          <p class="lead"><?php echo t('OurMissionSubtitle') ?>
        </div>
      </div>
      <div class="row">
        <?php
        foreach ($seccoes_missao as $i => $seccao) {
          echo '<div class="col-md-4" data-aos="fade-up" data-aos-delay="' . (($i + 1) * 100) . '">
            <div class="feature-block">
              <h3>' . $seccao['titulo'] . '</h3>
              <p>' . $seccao['descricao'] . '</p>
            </div>
          </div>';
        }
        ?>
      </div>
    </div>
  </section>



  <section class="section border-top border-bottom">
    <div class="container">
      <div class="row justify-content-center text-center mb-5">
        <h2 class="section-heading"><?php echo t('OurTeam') ?></h2>
      </div>
      <div class="row">
        <?php
        foreach ($equipa as $i => $membro) {
          echo '<div class="col-md-6 col-lg-3 text-center" data-aos="fade-up" data-aos-delay="' . ($i * 100) . '">
            <div class="card overflow-hidden">
              <img src="assets/img/equipa/' . $membro['imagem'] . '" alt="Image" class="img-fluid mb-2">
              <h2>' . $membro['nome'] . '</h2>
              <p>' . $membro['cargo'] . '</p>
            </div>
          </div>';
        }
        ?>
      </div>
    </div>
  </section>

  <?php include 'include/ui/testimonials.php'; ?>

  <?php include 'include/ui/cta-section.php'; ?>
</main>

<?php include 'include/ui/footer.php'; ?>