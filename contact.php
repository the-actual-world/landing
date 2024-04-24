<?php
include 'include/ui/header.php';
include_once 'include/config.inc.php';

add_log('contacto', 'VER_CONTACTO');
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
                <?php echo t('StartContact') ?>
              </h1>
              <p class="mb-5" data-aos="fade-up" data-aos-delay="100">
                <?php echo t('StartContactSubtitle') ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>

  <section class="section">
    <div class="container">
      <div class="row mb-5 align-items-end">
        <div class="col-md-6" data-aos="fade-up">

          <h2>
            <?php echo t('ContactUs') ?>
          </h2>
          <p class="mb-0">
            <?php echo t('ContactUsSubtitle') ?>
          </p>
        </div>

      </div>

      <div class="row">
        <div class="col-md-4 ms-auto order-2" data-aos="fade-up">
          <ul class="list-unstyled">
            <li class="mb-3">
              <strong class="d-block mb-1">Website</strong>
              <a href="https://theactual.world">theactual.world</a>
            </li>
            <li class="mb-3">
              <strong class="d-block mb-1">
                <?php echo t('Email') ?>
              </strong>
              <a href="mailto:hey@theactual.world">hey@theactual.world</a>
            </li>
          </ul>
        </div>

        <div class="col-md-6 mb-5 mb-md-0" data-aos="fade-up">
          <form action="forms/contact.php" method="post">

            <div class="row">

              <?php
              if (isset($_GET['success'])) {
                echo '<div class="alert alert-success" role="alert">
                ' . t("SuccessMessageSent") . '
              </div>';
              } else if (isset($_GET['error'])) {
                echo '<div class="alert alert-danger" role="alert">
                ' . t("ErrorSendingMessage") . '
              </div>';
              }
              ?>

              <div class="col-md-6 form-group">
                <label for="nome">
                  <?php echo t('Name') ?>
                </label>
                <input type="text" name="nome" class="form-control" id="nome" required>
              </div>
              <div class="col-md-6 form-group mt-3 mt-md-0">
                <label for="email">
                  <?php echo t('Email') ?>
                </label>
                <input type="email" class="form-control" name="email" id="email" required>
              </div>
              <div class="col-md-12 form-group mt-3">
                <label for="titulo">
                  <?php echo t('Title') ?>
                </label>
                <input type="text" class="form-control" name="titulo" id="titulo" required>
              </div>
              <div class="col-md-12 form-group mt-3">
                <label for="mensagem">
                  <?php echo t('Message') ?>
                </label>
                <textarea class="form-control" name="mensagem" required></textarea>
              </div>

              <div class="col-md-6 form-group pt-5">
                <input type="submit" class="btn btn-primary d-block w-100" value="<?php echo t('Send') ?>">
              </div>
            </div>

          </form>
        </div>

      </div>
    </div>
  </section>

  <?php render_page_title('Contact') ?>

  <?php include 'include/ui/testimonials.php'; ?>

  <?php include 'include/ui/cta-section.php'; ?>
</main>

<?php include 'include/ui/footer.php'; ?>