<?php
include 'include/ui/header.php';
include_once 'include/config.inc.php';

$patrocinadores = my_query('SELECT B.nome, A.imagem, A.url FROM patrocinadores A INNER JOIN patrocinadores_lang B ON A.id = B.id WHERE A.ativo = 1 AND B.lang = "' . $_SESSION['lang'] . '" ORDER BY A.ordem');
$funcionalidades = my_query('SELECT A.icone, B.titulo, B.descricao FROM funcionalidades A INNER JOIN funcionalidades_lang B ON A.id = B.id WHERE A.ativo = 1 AND B.lang = "' . $_SESSION['lang'] . '" ORDER BY A.ordem');
$passos = my_query('SELECT B.titulo, B.descricao, A.ordem FROM passos A INNER JOIN passos_lang B ON A.id = B.id WHERE A.ativo = 1 AND B.lang = "' . $_SESSION['lang'] . '" ORDER BY A.ordem');

add_log('inicio', 'VER_INICIO');
?>

<section class="hero-section" id="hero">

  <div class="wave">

    <svg width="100%" height="355px" viewBox="0 0 1920 355" version="1.1" xmlns="http://www.w3.org/2000/svg"
      xmlns:xlink="http://www.w3.org/1999/xlink">
      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
        <g id="Apple-TV" transform="translate(0.000000, -402.000000)" fill="#FFFFFF">
          <path
            d="M0,439.134243 C175.04074,464.89273 327.944386,477.771974 458.710937,477.771974 C654.860765,477.771974 870.645295,442.632362 1205.9828,410.192501 C1429.54114,388.565926 1667.54687,411.092417 1920,477.771974 L1920,757 L1017.15166,757 L0,757 L0,439.134243 Z"
            id="Path"></path>
        </g>
      </g>
    </svg>

  </div>

  <div class="container">
    <div class="row align-items-center">
      <div class="col-12 hero-text-image">
        <div class="row">
          <?php
          if (isset($_GET['waitlist'])) {
            echo '<div class="alert alert-success mt-4" role="alert">';
            echo t('WaitlistSuccess');
            echo '</div>';
          }
          ?>
          <div class="col-lg-8 text-center text-lg-start">
            <h4 class="text-white font-weight-light mb-4" data-aos="fade-right" data-aos-delay="500">
              The Actual World
            </h4>
            <h1 data-aos="fade-right"><?php echo t('HeroSlogan') ?></h1>
            <p class="mb-5" data-aos="fade-right" data-aos-delay="100">
              <?php echo t('HeroSubtitle') ?>
            </p>
            <div data-aos="fade-right" data-aos-delay="200" data-aos-offset="-500"
              class="d-flex align-items-center gap-2 justify-content-center justify-content-lg-start">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalDownload">
                <?php echo t('Download') ?>
              </button>
              <a href="help" class="btn btn-outline-white">
                <?php echo t('Help') ?>
              </a>
            </div>
          </div>
          <div class="col-lg-4 iphone-wrap">
            <img src="assets/img/landing/chat_screen.png" alt="Image" class="phone-1" data-aos="fade-right">
            <img src="assets/img/landing/friend_code.png" alt="Image" class="phone-2" data-aos="fade-right"
              data-aos-delay="200">
          </div>
        </div>
      </div>
    </div>
  </div>

</section>

<main id="main">
  <!-- Sponsors section -->
  <section class="section bg-light">
    <div class="container">
      <div class="row justify-content-center text-center align-items-center">
        <!-- Use responsive text sizing and margin/padding utilities -->
        <p class="col-md-2 col-12 fs-md-5 text-uppercase text-muted m-0 py-2 py-md-0" data-aos="fade-up"
          data-aos-delay="100">
          <?php echo t('BroughtBy') ?>
        </p>
        <?php foreach ($patrocinadores as $i => $patrocinador): ?>
          <div class="col-auto d-flex justify-content-center align-items-center m-1" data-aos="fade-up"
            data-aos-delay="<?= $i * 100 ?>">
            <a href="<?= $patrocinador['url'] ?>" target="_blank">
              <!-- Inline styles for demonstration; consider moving to a CSS class for production -->
              <img src="assets/img/patrocinadores/<?= $patrocinador['imagem'] ?>" alt="Image" class="img-fluid"
                style="height: auto; max-height: 50px; width: auto;">
            </a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>

  </section>

  <section class="section">
    <div class="container">

      <div class="row justify-content-center text-center mb-5">
        <div class="col-md-5" data-aos="fade-up">
          <h2 class="section-heading">
            <?php echo t('Features') ?>
          </h2>
        </div>
      </div>

      <div class="row">
        <?php
        foreach ($funcionalidades as $funcionalidade) {
          echo '<div class="col-md-4" data-aos="fade-up" data-aos-delay="">';
          echo '<div class="feature-1 text-center">';
          echo '<div class="wrap-icon icon-1">';
          echo '<i class="text-white fs-1 ' . $funcionalidade['icone'] . '"></i>';
          echo '</div>';
          echo '<h3 class="mb-3">' . $funcionalidade['titulo'] . '</h3>';
          echo '<p>' . $funcionalidade['descricao'] . '</p>';
          echo '</div>';
          echo '</div>';
        }
        ?>
      </div>

    </div>
  </section>

  <section class="section bg-light">

    <div class="container custom-background">
      <div class="row justify-content-center text-center mb-5" data-aos="fade">
      </div>

      <div class="row steps">
        <style>
          .custom-background {
            position: relative;
            text-align: center;
          }

          .custom-background::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('assets/img/landing/create_account.png');
            background-size: 25%;
            background-position: center;
            background-repeat: no-repeat;
            opacity: 0.7;

            z-index: -1;
          }

          .steps {
            position: relative;
            z-index: 2;
          }

          .step>p a {
            color: #007bff;
          }
        </style>

        <?php
        foreach ($passos as $passo) {
          echo '<div class="col-md-4">';
          echo '<div class="step">';
          echo '<span class="number">' . str_pad($passo['ordem'], 2, "0", STR_PAD_LEFT) . '</span>';
          echo '<h3>' . $passo['titulo'] . '</h3>';
          echo '<p>' . $passo['descricao'] . '</p>';
          echo '</div>';
          echo '</div>';
        }
        ?>
      </div>
    </div>

  </section>

  <?php include 'include/ui/testimonials.php'; ?>

  <?php include 'include/ui/cta-section.php'; ?>

</main>

<?php include 'include/ui/footer.php'; ?>