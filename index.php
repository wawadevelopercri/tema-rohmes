<?php get_header(); ?>

<style>
.visually-hidden {
    position: absolute;
    width: 1px;
    height: 1px;
    margin: -1px;
    padding: 0;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    border: 0;
}
</style>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "Rohmes",
  "url": "<?php echo esc_url(home_url('/')); ?>",
  "logo": "<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/seu-logo.png", // "description": "A Rohmes desenvolve máquinas de corte a laser, dobradeiras e soluções para a indústria metal mecânica, oferecendo tecnologia de ponta para otimizar a produção e a qualidade.",
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "+55-48-99999-9999", // "contactType": "Customer Service"
  },
  "sameAs": [
    "https://www.instagram.com/rohmesbrasil/" // ]
}
</script>

<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "WebSite",
    "url": "<?php echo esc_url(home_url('/')); ?>",
    "potentialAction": {
        "@type": "SearchAction",
        "target": "<?php echo esc_url(home_url('/')); ?>?s={search_term_string}",
        "query-input": "required name=search_term_string"
    }
}
</script>

<main>
    <section class="produtos">
        <div class="container-fluid fundo-produtos position-relative">
            <div class="container-mobile">
                <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1116.000000 744.000000" preserveAspectRatio="xMidYMid meet" class="diagonal-overlay-2">
                    <g transform="translate(0.000000,744.000000) scale(0.100000,-0.100000)" fill="#0f3c63" stroke="none">
                        <path d="M260 3720 l0 -3550 2913 2 2912 3 75 23 c122 38 207 88 284 167 49 50 683 943 2229 3135 1188 1686 2171 3087 2185 3114 78 154 42 328 -95 465 -73 73 -182 134 -298 168 -57 17 -324 18 -5132 21 l-5073 2 0 -3550z" />
                    </g>
                </svg>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="titulo-produtos" data-aos="fade-up">
                            <h1 class="visually-hidden">Rohmes: Máquinas de Corte a Laser, Dobradeiras e Solda Industrial</h1>
                            <h2><b>Conheça nossas máquinas</b></h2>
                        </div>

                        <div class="swiper-navigation-wrapper" data-aos="fade-up" data-aos-delay="100">

                            <div class="swiper categoriaSwiper">
                                <div class="swiper-wrapper">
                                    <?php
                                    $categorias = get_terms([
                                        'taxonomy'   => 'categoria_maquina',
                                        'hide_empty' => false,
                                        'parent'     => 0
                                    ]);

                                    if (!empty($categorias) && !is_wp_error($categorias)) :
                                        foreach ($categorias as $cat) :
                                            $imagem_url = '';
                                            $meta_value = get_term_meta($cat->term_id, 'imagem_da_categoria', true);
                                            if (is_numeric($meta_value)) {
                                                $imagem_url = wp_get_attachment_image_url($meta_value, 'large');
                                            }
                                            elseif (filter_var($meta_value, FILTER_VALIDATE_URL)) {
                                                $imagem_url = $meta_value;
                                            }
                                            $category_link = get_term_link($cat);
                                    ?>
                                            <div class="swiper-slide categoria-slide" data-aos="fade-up" data-title="<?php echo esc_attr($cat->name); ?>" style="--bg-image: url('<?php echo esc_url($imagem_url); ?>');">
                                                <div class="overlay card-overlay-azul">
                                                    <p class="nome"><?php echo esc_html($cat->name); ?></p>
                                                    <div class="hover-content">
                                                        <p class="descricao"><?php echo esc_html($cat->description); ?></p>
                                                        <a href="<?php echo esc_url($category_link); ?>" class="learn-more" aria-label="Saiba mais sobre <?php echo esc_attr($cat->name); ?>">
                                                            <span class="circle"><span class="icon arrow"></span></span>
                                                            <span class="button-text">Saiba mais</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <svg class="border-svg" viewBox="0 0 562 423" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path class="border-path" d="M 70 1.5 L 560.5 1.5 L 560.5 351.5 C 560.5 389.26 530.26 421.5 490.5 421.5 L 1.5 421.5 L 1.5 70 C 1.5 32.24 32.24 1.5 70 1.5 Z" />
                                                </svg>
                                            </div>
                                    <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </div>
                                <div class="swiper-pagination swiper-pagination-categorias"></div>
                            </div>
                        </div>

                        <div class="veja-mais" data-aos="fade-up">
                            <a href="<?php echo esc_url(home_url('/maquinas')); ?>" class="learn-more-2">
                                <span class="circle-2" aria-hidden="true">
                                    <span class="icon-2 arrow-2"></span>
                                </span>
                                <span class="button-text-2">Conheça a linha</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="banner-promocional" data-aos="fade-up">
        <div class="container">
            <h2 class="visually-hidden">Destaques: Solda a Laser, Corte a Laser e Dobradeiras CNC</h2>
            <div class="swiper swiper-promocional">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="row">
                            <div class="col-xl-4 col-12 solda-laser" data-aos="fade-right">
                                <h3><span class="solda">Solda a</span> <br> <span class="laser">LASER</span></h3>
                                <p>Processo de soldagem otimizado que aumenta a produtividade por ser rápido e fácil de operar. Ele combina alta velocidade com baixo calor para reduzir o empenamento e garantir <b>soldas mais fortes e seguras</b>.</p>
                                <a href="<?php echo esc_url(home_url('/maquinas/solda-a-laser/')); ?>" class="learn-more variant-3 d-none d-md-inline-block" aria-label="Saiba mais sobre Solda a Laser">
                                    <span class="circle"><span class="icon arrow"></span></span>
                                    <span class="button-text">Saiba mais</span>
                                </a>
                            </div>
                            <div class="col-xl-8 col-12" data-aos="fade-left">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/solda-limpeza.png" class="img-fluid" alt="Máquina de Solda e Limpeza a Laser" loading="lazy" decoding="async" fetchpriority="high">
                            </div>
                            <div class="col-12 d-md-none text-center margin-50">
                                <a href="<?php echo esc_url(home_url('/maquinas/solda-a-laser/')); ?>" class="learn-more variant-3" aria-label="Saiba mais sobre Solda a Laser">
                                    <span class="circle"><span class="icon arrow"></span></span>
                                    <span class="button-text">Saiba mais</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="row">
                            <div class="col-xl-4 col-12 solda-laser" data-aos="fade-right">
                                <h3><span class="solda">Corte a</span> <br> <span class="laser">LASER</span></h3>
                                <p>O <b>cabeçote</b> com foco automático ajusta-se a diferentes espessuras com <b>precisão e eficiência</b>. <b>Detecção de bordas</b> evita colisões e reduz desperdícios, enquanto a <b>estrutura robusta</b> garante <b>estabilidade</b>. <b>Mandris de ar duplo</b> centralizam o tubo automaticamente, otimizando cortes e <b>economizando material</b>.</p>
                                <a href="<?php echo esc_url(home_url('/maquinas/corte-a-laser/')); ?>" class="learn-more variant-3 d-none d-md-inline-block" aria-label="Saiba mais sobre Corte a Laser">
                                    <span class="circle"><span class="icon arrow"></span></span>
                                    <span class="button-text">Saiba mais</span>
                                </a>
                            </div>
                            <div class="col-xl-8" data-aos="fade-left">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/produto_banner_5.png" class="img-fluid" alt="Máquina de Corte a Laser para tubos" loading="lazy" decoding="async" fetchpriority="high">
                            </div>
                            <div class="col-12 d-md-none text-center margin-50">
                                <a href="<?php echo esc_url(home_url('/maquinas/corte-a-laser/')); ?>" class="learn-more variant-3" aria-label="Saiba mais sobre Corte a Laser">
                                    <span class="circle"><span class="icon arrow"></span></span>
                                    <span class="button-text">Saiba mais</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="row">
                            <div class="col-xl-4 col-12 solda-laser" data-aos="fade-right">
                                <h3><span class="solda">Dobradeira CNC </span> <br> <span class="laser">Comando <b>ESA</b></span></h3>
                                <p>A <b>Dobradeira CNC</b> com <b>comando ESA</b> garante <b>alta precisão</b>, <b>produtividade</b> e <b>dobras perfeitas</b>. Com <b>sistema inteligente</b>, reduz <b>erros</b> e <b>desperdícios</b>, unindo <b>eficiência</b>, <b>confiabilidade</b> e <b>facilidade de uso</b> para resultados de <b>alta qualidade</b>.</p>
                                <a href="<?php echo esc_url(home_url('/maquinas/dobradeiras/')); ?>" class="learn-more variant-3 d-none d-md-inline-block" aria-label="Saiba mais sobre Dobradeira CNC com comando ESA">
                                    <span class="circle"><span class="icon arrow"></span></span>
                                    <span class="button-text">Saiba mais</span>
                                </a>
                            </div>
                            <div class="col-xl-8 col-12" data-aos="fade-left">
                                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/esa.png" class="img-fluid" alt="Dobradeira CNC Industrial com comando ESA" loading="lazy" decoding="async" fetchpriority="high">
                            </div>
                            <div class="col-12 d-md-none text-center margin-50">
                                <a href="<?php echo esc_url(home_url('/maquinas/dobradeiras/')); ?>" class="learn-more variant-3" aria-label="Saiba mais sobre Dobradeira CNC com comando ESA">
                                    <span class="circle"><span class="icon arrow"></span></span>
                                    <span class="button-text">Saiba mais</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination swiper-pagination-promocional"></div>
            </div>
        </div>
    </section>

    <section class="pos-vendas">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 pos-vendas" data-aos="fade-up">
                    <h2>Suporte Técnico</h2>
                </div>
                <div class="col-md-6 text-center" data-aos="fade-right">
                    <div class="video">
                        <iframe width="100%" height="358" src="https://www.youtube.com/embed/ycTCR591sws" title="Suporte Técnico Especializado Rohmes" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen loading="lazy"></iframe>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-left">
                    <p>Na <b>Rohmes</b>, a nossa missão não termina com a venda — ela se fortalece com o relacionamento. Sabemos que a <b>qualidade do atendimento técnico</b> é essencial para o sucesso de qualquer operação industrial. Por isso, oferecemos um serviço completo de pós-venda e suporte técnico especializado, voltado para clientes que utilizam máquinas de <b>corte a laser</b>, <b>dobradeiras</b> e outros equipamentos</b> industriais de <b>alto desempenho.</b></p>
                    <div class="pos-vendas">
                        <div class="certifications-container">
                            <div class="certification-item" data-aos="zoom-in">
                                <div class="icon-wrapper">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/fda.png" alt="Certificação FDA" class="img-fluid" loading="lazy" decoding="async">
                                </div>
                                <p class="description">Garante que o equipamento atende aos padrões de segurança e eficácia estabelecidos pela FDA - EUA.</p>
                            </div>
                            <div class="certification-item" data-aos="zoom-in">
                                <div class="icon-wrapper">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/iso.png" alt="Certificação ISO" class="img-fluid" loading="lazy" decoding="async">
                                </div>
                                <p class="description">Significa que o equipamento segue os sistemas de gestão de qualidade internacionais.</p>
                            </div>
                            <div class="certification-item" data-aos="zoom-in">
                                <div class="icon-wrapper">
                                    <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/ce.png" alt="Certificação CE" class="img-fluid" loading="lazy" decoding="async">
                                </div>
                                <p class="description">Conformidade com padrões europeus de qualidade e segurança.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="botao" data-aos="fade-up">
                        <a href="<?php echo esc_url(home_url('suporte-tecnico')); ?>" class="learn-more-5" aria-label="Conheça nosso Suporte técnico detalhadamente">
                            <span class="circle-5"><span class="icon-5 arrow-5"></span></span>
                            <span class="button-text-5">Conheça nosso Suporte técnico</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="space"></div>

    <section class="sobre-nos">
        <div class="secao-sobre-nos-fundo">
            <div class="container conteudo-sobreposto">
                <div class="row">
                    <div class="col-md-12">
                        <div class="video-flutuante" data-aos="fade-up" data-aos-delay="100">
                            <div class="video">
                                <iframe width="100%" height="358" src="https://www.youtube.com/embed/Q8NJ-IET6oE" title="Vídeo Institucional Rohmes" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen loading="lazy"></iframe>
                            </div>
                        </div>
                        <h2 data-aos="fade-up" data-aos-delay="200">Quem somos</h2>
                        <p data-aos="fade-up" data-aos-delay="300">A fundação ocorreu em 2019, marcando o início de uma jornada que resultou na criação da marca Rohmes. Sob essa denominação, a empresa se dedica ao desenvolvimento de máquinas de corte a laser, dobradeiras e demais máquinas para industria metal mecânica, destinadas a oferecer soluções abrangentes no mercado.</p>
                        <p data-aos="fade-up" data-aos-delay="400">Nosso objetivo desde a concepção é proporcionar equipamentos que não só atendam, mas excedam as expectativas daqueles que buscam expandir e aprimorar suas operações industriais. Nossas máquinas foram concebidas para otimizar a produção, elevar a qualidade, reduzir custos operacionais e catalisar o crescimento das empresas que optam por nossos produtos.</p>
                        <p data-aos="fade-up" data-aos-delay="500">Distinguindo-se como uma empresa jovem, trazemos conosco não apenas nossa energia empreendedora, mas também a responsabilidade de introduzir inovações tecnológicas no mercado. Nossas ideias pioneiras e a busca constante por novas tecnologias refletem nossa dedicação em impulsionar a indústria a novos patamares.</p>
                        <div class="frase-sobre" data-aos="fade-up" data-aos-delay="600">
                            <h4>Excelência em tecnologia, <br>compromisso com você.</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="depoimentos">
        <div class="container">
            <h2 class="text-center" data-aos="fade-up">Nossos Clientes</h2>
            <div class="swiper nossos-clientes-swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">
                    <?php
                    $videos_youtube = [
                        ['id' => 'enHqHUJNH7U', 'frase' => 'DeG'],
                        ['id' => '9ojkLflYArI', 'frase' => 'Ribeiro'],
                        ['id' => 'VSMIZrjoR0M', 'frase' => 'Possamai'],
                        ['id' => 'scMfB6pm0PA', 'frase' => 'FCH'],
                        ['id' => 'SO_IOLtAaeo', 'frase' => 'MS'],
                    ];

                    if (!empty($videos_youtube)) :
                        foreach ($videos_youtube as $video) :
                            $video_id = esc_attr($video['id']);
                            $frase_hover = esc_html($video['frase']);
                            $youtube_url = 'https://www.youtube.com/watch?v=' . $video_id;
                            $thumbnail_url = 'https://i.ytimg.com/vi/' . $video_id . '/hqdefault.jpg';
                    ?>
                            <div class="swiper-slide" data-aos="fade-up">
                                <a href="<?php echo esc_url($youtube_url); ?>" class="glightbox" data-type="video" aria-label="Ver depoimento do cliente <?php echo esc_attr($frase_hover); ?>">
                                    <div class="video-slide-item">
                                        <img src="<?php echo esc_url($thumbnail_url); ?>" alt="Thumbnail do depoimento do cliente: <?php echo esc_attr($frase_hover); ?>" loading="lazy" decoding="async">
                                        <div class="video-overlay">
                                            <p class="video-overlay-text"><?php echo esc_html($frase_hover); ?></p>
                                            <i class="fa-solid fa-circle-play video-overlay-play-icon"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                    <?php
                        endforeach;
                    else :
                        echo '<div class="swiper-slide"><p class="text-center">Nenhum vídeo disponível no momento.</p></div>';
                    endif;
                    ?>
                </div>
                <div class="swiper-pagination swiper-pagination-nossos-clientes"></div>
            </div>
        </div>
    </section>

    <?php
    $frases_para_js = array_column($videos_youtube, 'frase');
    ?>
    <script>
        const frasesDosClientes = <?php echo json_encode($frases_para_js); ?>;
    </script>

    <section class="clientes" data-aos="fade-in">
        <div class="container">
            <div class="clientes-marquee">
                <div class="clientes-track">
                    <?php
                    $clientes = [ 'agnoli.png', 'bocril.png', 'contrex.png', 'dg.png', 'dh-engenharia.png', 'dw-industria.png', 'fch.png', 'fox.png', 'geris.png', 'gladii.png', 'irrigabrasil.png', 'litorania.png', 'logo-a.png', 'logo-b.png', 'logo-c.png' ];

                    foreach (array_merge($clientes, $clientes) as $cliente) {
                        // SEO: Melhorado o 'alt' da imagem para ser mais descritivo
                        $client_name = ucfirst(str_replace(['.png', '-'], ['', ' '], $cliente));
                        echo '<div class="cliente-logo"><img src="' . esc_url(get_template_directory_uri() . '/img/clientes/' . $cliente) . '" alt="Logo do cliente ' . esc_attr($client_name) . '" loading="lazy" decoding="async"></div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <div class="space"></div>

    <section class="mapa-clientes">
        <div class="container">
            <div class="numeros" data-aos="fade-up">
                <div class="item-numero">
                    <div class="counter" id="counter-projetos">0</div>
                    <p>Projetos<br>Desenvolvidos</p>
                </div>
                <div class="item-numero">
                    <div class="counter" id="counter-maquinas">0</div>
                    <p>Máquinas<br>Entregues</p>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="frase" data-aos="fade-up" data-aos-delay="100">
                <p>Sua <b>escolha número um</b> para <b>soluções em maquinas para corte e conformação de aço</b>.</p>
                <p>Orgulhosamente, distribuímos nossas <b>máquinas de última geração</b> em toda a <b>América Latina</b>, com um foco especial nas regiões do <b>Centro-oeste, sudeste e sul do Brasil</b>.</p>
                <p>Estamos <b>comprometidos</b> em atender as demandas de nossos clientes em toda a região, proporcionando <b>qualidade</b>, <b>eficiência</b> e <b>parceria</b>.</p>
            </div>
        </div>
        <div class="container">
            <div class="mapa-container" id="mapa-area" data-aos="zoom-in" data-aos-delay="200">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/mapa-mundi.png" alt="Mapa Mundi destacando a atuação da Rohmes" class="mapa-mundi img-fluid" loading="lazy" decoding="async">
                <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/brasil.png" alt="Mapa do Brasil indicando a presença da Rohmes" id="mapa-brasil" class="mapa-brasil img-fluid" loading="lazy" decoding="async">
                
                <div class="sede-ponto" style="top: 0%;left: 35%;" title="Cliente na região Norte"></div>
                <div class="sede-ponto" style="top: 5%;left: 39%;" title="Cliente na região Norte"></div>
                <div class="sede-ponto" style="top: 5%;left: 32%;" title="Cliente na região Norte"></div>
                <div class="sede-ponto" style="top: 1%;left: 30%;" title="Cliente na região Norte"></div>
                <div class="sede-ponto" style="top: 14%; left: 36%;" title="Cliente na região Norte"></div>
                <div class="sede-ponto" style="top: 18%; left: 45%;" title="Cliente na região Nordeste"></div>
                <div class="sede-ponto" style="top: 21%; left: 46%;" title="Cliente na região Nordeste"></div>
                <div class="sede-ponto" style="top: 16%; left: 43%;" title="Cliente na região Nordeste"></div>
                <div class="sede-ponto" style="top: 23%; left: 44%;" title="Cliente na região Nordeste"></div>
                <div class="sede-ponto" style="top: 12%;left: 46%;" title="Cliente na região Nordeste"></div>
                <div class="sede-ponto" style="top: 16%;left: 38%;" title="Cliente na região Centro-Oeste"></div>
                <div class="sede-ponto" style="top: 23%; left: 39%;" title="Cliente na região Centro-Oeste"></div>
                <div class="sede-ponto" style="top: 13%;left: 41%;" title="Cliente na região Centro-Oeste"></div>
                <div class="sede-ponto" style="top: -5%;left: 32%;" title="Cliente na região Centro-Oeste"></div>
                <div class="sede-ponto" style="top: 21%;left: 37%;" title="Cliente na região Centro-Oeste"></div>
                <div class="sede-ponto" style="top: 29%; left: 40%;" title="Cliente na região Sudeste"></div>
                <div class="sede-ponto" style="top: 27%; left: 42%;" title="Cliente na região Sudeste"></div>
                <div class="sede-ponto" style="top: 8%;left: 43%;" title="Cliente na região Sudeste"></div>
                <div class="sede-ponto" style="top: 28%; left: 39%;" title="Cliente na região Sudeste"></div>
                <div class="sede-ponto" style="top: 33%;left: 40%;" title="Cliente na região Sudeste"></div>
                <div class="sede-ponto" style="top: 20%;left: 41%;" title="Cliente na região Sul"></div>
                <div class="sede-ponto" style="top: 36%;left: 40%;" title="Cliente na região Sul"></div>
                <div class="sede-ponto" style="top: 34%; left: 39%;" title="Cliente na região Sul"></div>
                <div class="sede-ponto" style="top: 4%;left: 45%;" title="Cliente na região Sul"></div>
                <div class="sede-ponto" style="top: 38%;left: 38%;" title="Cliente na região Sul"></div>
            </div>
        </div>
    </section>
</main>
<?php get_footer(); ?>