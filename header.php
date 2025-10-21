<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>

    <link rel="preconnect" href="https://www.googletagmanager.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    

    <link rel="preload" as="image" href="<?php echo get_template_directory_uri(); ?>/assets/img/fundo-2.png">

    <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/apple-touch-icon.png">
    <link rel="manifest" href="<?php echo get_template_directory_uri(); ?>/site.webmanifest">

    <script async>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-5H9L2GHV');</script>

    <?php wp_head(); ?>
</head>

<body <?php body_class('loading'); ?>>
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5H9L2GHV"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <?php wp_body_open(); ?>

    <div class="logo-loader">
        <div class="logo-box">
            <?php
            $svg_path = get_stylesheet_directory() . '/img/SVG/logo-load-3.svg';
            if (file_exists($svg_path)) {
                echo file_get_contents($svg_path);
            }
            ?>
        </div>
    </div>

    <?php if (is_front_page()) : ?>
        <header>
            <div class="container-fluid">
                <?php get_template_part('template-parts/menu'); ?>
            </div>

            <div class="container fundo">
                <div class="swiper-container header-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="container">
                                <video autoplay muted loop playsinline preload="auto" class="bg-video">
                                    <source src="<?php echo get_template_directory_uri(); ?>/assets/video/video-rohmes-2.mp4" type="video/mp4">
                                    Seu navegador não suporta vídeos HTML5.
                                </video>
                                <div class="diagonal-overlay"></div>
                                <div class="overlay-conteudo container text-white">
                                    <div class="d-flex justify-content-center align-items-center full-center">
                                        <div class="coluna-texto d-flex flex-column">
                                            <div class="order-3">
                                                <div class="conteudo-texto">
                                                    <p class="sub-headline-1">
                                                        Tenha o melhor da tecnologia de corte a laser e o melhor suporte técnico do mercado. Com nossa linha de <b>máquinas de corte a laser</b>, você terá sua <b>produção alcançando potêncial máximo</b>.
                                                    </p>
                                                    <div class="container-acoes">
    <a href="#forms-geral" id="openModalBtn" class="whatsapp-banner d-inline-flex align-items-center">
        Fazer uma cotação
    </a>
</div>
                                                </div>
                                            </div>
                                            <div class="order-1">
                                                <h2 class="headline"><b>Eleve o nível de produção</b> da sua industria metal mecânica com nossas <b>Máquinas de Corte a Laser</b></h2>
                                            </div>
                                            <div class="d-lg-none order-2">
                                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/fundo-2.png" class="imagem-banner-fluido img-fluid" alt="Máquina Rohmes" loading="lazy">
                                            </div>
                                        </div>
                                        <div class="coluna-imagem d-none d-lg-block">
                                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/fundo-2.png" class="imagem-banner-fluido img-fluid" alt="Máquina Rohmes" loading="lazy">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination swiper-pagination-header"></div>
                </div>
            </div>
        </header>
    <?php else : ?>
        <div class="container-fluid mb-4">
            <?php get_template_part('template-parts/menu'); ?>
        </div>
        
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                    <?php
                    if (is_page()) {
                        $ancestors = get_post_ancestors(get_the_ID());
                        if ($ancestors) {
                            $ancestors = array_reverse($ancestors);
                            foreach ($ancestors as $ancestor_id) {
                                echo '<li class="breadcrumb-item"><a href="' . esc_url(get_permalink($ancestor_id)) . '">' . esc_html(get_the_title($ancestor_id)) . '</a></li>';
                            }
                        }
                        echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';

                    } elseif (is_post_type_archive()) {
                        echo '<li class="breadcrumb-item active" aria-current="page">' . post_type_archive_title('', false) . '</li>';

                    } elseif (is_single()) {
                        $post_type = get_post_type();
                        if ($post_type !== 'post') {
                            $post_type_object = get_post_type_object($post_type);
                            
                            // --- AJUSTE AQUI ---
                            // Verifica se o post type é 'maquina' e força o link para a página '/maquinas/'
                            if ($post_type === 'maquina') {
                                $archive_link = home_url('/maquinas/');
                            } else {
                                $archive_link = get_post_type_archive_link($post_type);
                            }
                            // --- FIM DO AJUSTE ---

                            if ($archive_link && $post_type_object) {
                                echo '<li class="breadcrumb-item"><a href="' . esc_url($archive_link) . '">' . esc_html($post_type_object->labels->name) . '</a></li>';
                            }
                        } else {
                            $cat = get_the_category();
                            if (!empty($cat)) {
                                $cat_obj = $cat[0];
                                $cat_ancestors = get_ancestors($cat_obj->term_id, 'category');
                                $cat_ancestors = array_reverse($cat_ancestors);
                                foreach ($cat_ancestors as $ancestor_id) {
                                    $ancestor = get_category($ancestor_id);
                                    echo '<li class="breadcrumb-item"><a href="' . esc_url(get_category_link($ancestor->term_id)) . '">' . esc_html($ancestor->name) . '</a></li>';
                                }
                                echo '<li class="breadcrumb-item"><a href="' . esc_url(get_category_link($cat_obj->term_id)) . '">' . esc_html($cat_obj->name) . '</a></li>';
                            }
                        }
                        echo '<li class="breadcrumb-item active" aria-current="page">' . get_the_title() . '</li>';

                    } elseif (is_category() || is_tax()) {
                        $term = get_queried_object();
                        if ($term) {
                            $ancestors = get_ancestors($term->term_id, $term->taxonomy);
                            $ancestors = array_reverse($ancestors);
                            foreach ($ancestors as $ancestor_id) {
                                $ancestor = get_term($ancestor_id, $term->taxonomy);
                                echo '<li class="breadcrumb-item"><a href="' . esc_url(get_term_link($ancestor)) . '">' . esc_html($ancestor->name) . '</a></li>';
                            }
                        }
                        echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html($term->name) . '</li>';
                    }
                    ?>
                </ol>
            </nav>
        </div>
        <?php endif; ?>