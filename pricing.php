<?php
include_once 'include/config.inc.php';

$page_title = t('Pricing');
$page_description = t('OurPricesSubtitle');
$page_keywords = t('OurPrices');

include 'include/ui/header.php';

add_log('precos', 'VER_PRECOS');
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
                <?php echo t('OurPrices') ?>
              </h1>
              <p class="mb-5" data-aos="fade-up" data-aos-delay="100">
                <?php echo t('OurPricesSubtitle') ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <section class="section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 fs-5">
          <?php echo t('PricingPageHTML') ?>
        </div>
      </div>
    </div>
  </section>

  <!--
  <section class="section bg-light">
    <div class="container">

      <div class="row justify-content-center">

        <div class="col-lg-4 mb-4 mb-lg-0">
          <div class="pricing h-100 text-center">
            <span>&nbsp;</span>
            <h3>Basic</h3>
            <ul class="list-unstyled">
              <li>Create up to 5 forms</li>
              <li>Generate 100 monthly reports</li>
            </ul>
            <div class="price-cta">
              <strong class="price">Free</strong>
              <p><a href="#" class="btn btn-white">Choose Plan</a></p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-4 mb-lg-0">
          <div class="pricing h-100 text-center popular">
            <span class="popularity">Privado</span>
            <h3>The Actual World</h3>
            <ul class="list-unstyled">
              <li>Utilização ilimitada</li>
              <li>Experiência privacidade</li>
              <li>Experiência social única</li>
              <li>Memórias guardadas de forma segura</li>
            </ul>
            <div class="price-cta">
              <strong class="price">1,99€/mês</strong>
              <p><a href="#" class="btn btn-white">Registar</a></p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-4 mb-lg-0">
          <div class="pricing h-100 text-center">
            <span class="popularity">Best Value</span>
            <h3>Ultimate</h3>
            <ul class="list-unstyled">
              <li>Create up to 20 forms</li>
              <li>Generate 2500 monthly reports</li>
              <li>Manage a team of up to 5 people</li>
            </ul>
            <div class="price-cta">
              <strong class="price">$199.95/month</strong>
              <p><a href="#" class="btn btn-white">Choose Plan</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  -->

  <?php include 'include/ui/cta-section.php'; ?>
</main>

<?php include 'include/ui/footer.php'; ?>