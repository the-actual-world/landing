<?php
$testemunhos = my_query('SELECT B.nome_pessoa, A.imagem_pessoa, B.cargo_pessoa, B.titulo, B.conteudo, A.estrelas FROM testemunhos A INNER JOIN testemunhos_lang B ON A.id = B.id WHERE B.lang = "' . $_SESSION['lang'] . '" AND A.ativo = 1');
?>

<section class="section border-top border-bottom">
  <div class="container">
    <div class="row justify-content-center text-center mb-5">
      <h2 class="section-heading">
        <?php echo t('Testimonials') ?>
      </h2>
    </div>
    <div class="row justify-content-center text-center">
      <div class="col-md-7">

        <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
          <div class="swiper-wrapper">

            <?php
            foreach ($testemunhos as $testemunho) {
              echo '<div class="swiper-slide">
                <div class="review text-center">
                  <p class="stars">';
              for ($i = 0; $i < $testemunho['estrelas']; $i++) {
                echo '<span class="bi bi-star-fill"></span>';
              }
              for ($i = 0; $i < 5 - $testemunho['estrelas']; $i++) {
                echo '<span class="bi bi-star-fill muted"></span>';
              }
              echo '</p>
                    <h3>' . $testemunho['titulo'] . '</h3>
                    <blockquote>
                      <p>' . $testemunho['conteudo'] . '</p>
                    </blockquote>
                    <p class="review-user">
                      <img src="assets/img/testemunhos/' . $testemunho['imagem_pessoa'] . '" alt="Image" class="img-fluid rounded-circle mb-3">
                      <span class="d-block">
                        <span class="text-black
                        ">' . $testemunho['nome_pessoa'] . '</span>, &mdash; ' . $testemunho['cargo_pessoa'] . '
                      </span>
                    </p>
                  </div>
                </div>';
            }
            ?>

          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </div>
  </div>
</section>