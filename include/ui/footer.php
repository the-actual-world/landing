<footer class="footer" role="contentinfo">
  <div class="container">
    <div class="row">
      <div class="col-md-4 mb-4 mb-md-0">
        <h3>
          The Actual World
        </h3>
        <p>
          <?php echo t('HeroSubtitle') ?>
        </p>

        <p class="social user-select-none">
          <?php
          $arrSocial = [
            'twitter',
            'facebook',
            'instagram',
            'linkedin'
          ];
          foreach ($arrSocial as $social) {
            echo '<a style="cursor: not-allowed;"><span class="bi bi-' . $social . '"></span></a> ';
          }
          ?>
        </p>
      </div>
      <div class="col-md-7 ms-auto">
        <div class="row site-section pt-0">
          <div class="col-md-4 mb-4 mb-md-0">
            <h3>
              <?php echo t('Navigation'); ?>
            </h3>
            <ul class="list-unstyled">
              <?php
              $links = [
                '' => 'Início',
                'about' => 'Sobre',
                'pricing' => 'Preço',
                'catalog' => 'Catálogo',
                'updates' => 'Atualizações',
                'contact' => 'Contacto'
              ]
                ?>
              <?php foreach ($links as $link => $nome) { ?>
                <li><a href="<?php echo $arrConfig['url_site'] . '/' . $link; ?>">
                    <?php echo $nome; ?>
                  </a></li>
              <?php } ?>
            </ul>
          </div>
          <div class="col-md-4 mb-4 mb-md-0">
            <h3>
              <?php echo t('Help'); ?>
            </h3>
            <ul class="list-unstyled">
              <?php
              $categorias_faq = my_query("SELECT * FROM faq_categorias WHERE id_pai = 0 ORDER BY nome ASC");
              foreach ($categorias_faq as $categoria_faq) {
                echo '<li><a href="' . $arrConfig['url_site'] . '/help?id=' . $categoria_faq['id'] . '">' . $categoria_faq['nome'] . '</a></li>';
              }
              ?>
            </ul>
          </div>
          <div class="col-md-4 mb-4 mb-md-0">
            <h3>
              <?php echo t('Start'); ?>
            </h3>
            <ul class="list-unstyled">
              <li><a href="<?php echo $arrConfig['url_site'] . '/download'; ?>" target="_blank">
                  <?php echo t('Download'); ?>
                </a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Não mudar o footer -->
    <div class="row justify-content-center text-center">
      <div class="col-md-7">
        <p class="copyright">&copy; Copyright . All Rights Reserved</p>
        <div class="credits">
          Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
      </div>
    </div>

  </div>
</footer>

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
    class="bi bi-arrow-up-short"></i></a>

<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/lightbox2/dist/js/lightbox-plus-jquery.min.js"></script>

<script src="assets/js/main.js"></script>

</body>

</html>