<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php bloginfo('name'); ?></title>
  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" type="image/x-icon">
<link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/favicon-16x16.png">
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/apple-touch-icon.png">
<link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/site.webmanifest">
  <?php wp_head(); ?>
</head>



<body <?php body_class('loading'); ?>>
  <?php wp_body_open(); ?>


<div class="logo-loader">
  <div class="logo-box">
    <?php
    echo file_get_contents(get_template_directory() . '/img/SVG/logo-load-3.svg');
    ?>
  </div>
</div>

  <?php if (is_front_page()) : ?>
    <header>
      <div class="container-fluid fundo">
        <?php get_template_part('template-parts/menu'); ?>
      
      <div class="container-fluid d-flex align-items-center justify-content-center h-100 p-0">
        
            
        <div class="container">
          <video autoplay muted loop playsinline class="bg-video">
            <source src="<?php echo get_template_directory_uri(); ?>/assets/video/fundo_3.mp4" type="video/mp4">
            Seu navegador não suporta vídeos HTML5.
          </video>

          <div class="diagonal-overlay"></div>
          <div class="overlay-conteudo container-fluid text-center text-white">

            
            <div class="d-flex justify-content-center align-items-center full-center">
              
              <div class="coluna-texto d-flex flex-column">

                <div class="order-1">
                  <h2 class="headline"><b>Aprimore a linha de produção da sua industria do metal!</b></h2>
                </div>

                <div class="d-lg-none order-2">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/img/fundo-2.png" class="imagem-banner-fluido img-fluid" alt="Máquina Rohmes">
                </div>
                
                <div class="order-3">
                  <div class="conteudo-texto">
                    <p class="sub-headline">
                      Com o nosso <b>ecossistema de maquinário industrial e pós vendas</b>, você terá uma verdadeira <b>parceria</b> desde o primeiro contato, da <b>entrega e até instalação</b> da sua <b>máquina.</b>
                    </p>
                    <div class="container-acoes">
                      <a href="https://api.whatsapp.com/send?phone=554874001421&text=Ol%C3%A1%2C+vim+do+site%2C+gostaria+de+um+or%C3%A7amento" target="_blank" class="whatsapp-banner d-inline-flex align-items-center">
                        <i class="bi bi-whatsapp me-2"></i> Fale com o nosso consultor
                      </a>

                      <div class="icones_banner_personalizado">
                        <div class="logos_wrapper">
                          <div class="circulo"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/topo_blend.png" alt="Bendo"></div>
                          <div class="circulo"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/topo_forteaco.png" alt="Forteaco"></div>
                          <div class="circulo"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/topo_schereer.png" alt="Schnee"></div>
                          <div class="circulo"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/topo_metal-nobre.png" alt="Metal Nobre"></div>
                        </div>
                        <h4><b>+450 empresas</b> elevaram o nível de sua produção com <b>nossas máquinas!</b></h4>
                      </div>
                    </div>
                  </div>
                </div>

              </div>

              <div class="coluna-imagem d-none d-lg-block">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/fundo-2.png" class="imagem-banner-fluido img-fluid" alt="Máquina Rohmes">
              </div>

            </div>
            </div>
        </div>
      </div>
      </div>
    </header>



  <?php else : ?>

    <div class="container-fluid mb-4">
      <?php get_template_part('template-parts/menu'); ?>
    </div>




  <?php endif; ?>