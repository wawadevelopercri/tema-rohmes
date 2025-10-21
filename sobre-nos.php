<?php
/* Template Name: Sobre Nós */
get_header();
?>
<section class="page-header">
    <div class="container">
        <h1>Sobre Nós</h1>
        <p>Conheça a nossa história, nossos valores e o compromisso que temos com a inovação e o sucesso dos nossos clientes.</p>
    </div>
</section>
<section class="sobre-nos">
    <div class="secao-sobre-nos-fundo">
        <div class="container conteudo-sobreposto">
            <div class="row">
                <div class="col-md-12">
                    <div class="video-flutuante" data-aos="fade-up" data-aos-delay="100">
                        <div class="video">
                            <iframe width="100%" height="358" src="https://www.youtube.com/embed/Q8NJ-IET6oE" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
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

<!--<section class="timeline-elegant-section">
    <div class="container" data-aos="fade-up">
        <h2 class="text-center">Nossa Trajetória</h2>
        <div class="timeline-elegant-container" data-aos="fade-up" data-aos-delay="200">

            <div class="timeline-elegant-item" data-aos="fade-left">
                <div class="timeline-elegant-content">
                    <div class="timeline-elegant-image">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/1-inicio.png" alt="Início da Rohmes em 2020">
                    </div>
                    <div class="timeline-elegant-text">
                        <h3>2020 - Início</h3>
                        <p>O início de tudo em uma modesta sala de 5x5 metros.</p>
                    </div>
                </div>
                <div class="timeline-elegant-marker"></div>
            </div>

            <div class="timeline-elegant-item" data-aos="fade-right">
                <div class="timeline-elegant-content">
                    <div class="timeline-elegant-image">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/2.png" alt="Segundo galpão da Rohmes">
                    </div>
                    <div class="timeline-elegant-text">
                        <h3>2021 - 2022</h3>
                        <p>2º Galpão, Wesley e Paulo começando assim a trajetória.</p>
                    </div>
                </div>
                <div class="timeline-elegant-marker"></div>
            </div>

            <div class="timeline-elegant-item" data-aos="fade-left">
                <div class="timeline-elegant-content">
                    <div class="timeline-elegant-image">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/3.png" alt="Sede atual da Rohmes">
                    </div>
                    <div class="timeline-elegant-text">
                        <h3>2023 - 2025</h3>
                        <p>Atualmente estamos nessa sede com fabricação de máquinas de corte a Laser.</p>
                    </div>
                </div>
                <div class="timeline-elegant-marker"></div>
            </div>

            <div class="timeline-elegant-item" data-aos="fade-right">
                <div class="timeline-elegant-content">
                    <div class="timeline-elegant-image">
                        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/img/4.png" alt="Projeto das futuras instalações">
                    </div>
                    <div class="timeline-elegant-text">
                        <h3>Futuras Instalações</h3>
                        <p>Nova sede para ampliar a produção e atender à demanda.</p>
                    </div>
                </div>
                <div class="timeline-elegant-marker"></div>
            </div>

        </div>
    </div>
</section>-->


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
                        <div class="swiper-slide">
                            <a href="<?php echo esc_url($youtube_url); ?>" class="glightbox" data-type="video">
                                <div class="video-slide-item">
                                    <img src="<?php echo esc_url($thumbnail_url); ?>" alt="Thumbnail do vídeo: <?php echo esc_attr($frase_hover); ?>">
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

<section class="clientes" data-aos="fade-in">
    <div class="clientes-marquee">
        <div class="clientes-track">
            <?php
            $clientes = [
                'agnoli.png', 'bocril.png', 'contrex.png', 'dg.png', 'dh-engenharia.png',
                'dw-industria.png', 'fch.png', 'fox.png', 'geris.png', 'gladii.png',
                'irrigabrasil.png', 'litorania.png', 'logo-a.png', 'logo-b.png', 'logo-c.png'
            ];
            foreach (array_merge($clientes, $clientes) as $cliente) {
                echo '<div class="cliente-logo"><img src="' . esc_url(get_template_directory_uri() . '/img/clientes/' . $cliente) . '" alt="Logo Cliente"></div>';
            }
            ?>
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
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/mapa-mundi.png" alt="Mapa Mundi destacando a atuação da Rohmes" class="mapa-mundi img-fluid">
            <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/brasil.png" alt="Mapa do Brasil indicando a presença da Rohmes" id="mapa-brasil" class="mapa-brasil img-fluid">

            <div class="sede-ponto" style="top: 0%;left: 35%;" title="Norte 1"></div><div class="sede-ponto" style="top: 5%;left: 39%;" title="Norte 2"></div><div class="sede-ponto" style="top: 5%;left: 32%;" title="Norte 3"></div><div class="sede-ponto" style="top: 1%;left: 30%;" title="Norte 4"></div><div class="sede-ponto" style="top: 14%; left: 36%;" title="Norte 5"></div><div class="sede-ponto" style="top: 18%; left: 45%;" title="Nordeste 1"></div><div class="sede-ponto" style="top: 21%; left: 46%;" title="Nordeste 2"></div><div class="sede-ponto" style="top: 16%; left: 43%;" title="Nordeste 3"></div><div class="sede-ponto" style="top: 23%; left: 44%;" title="Nordeste 4"></div><div class="sede-ponto" style="top: 12%;left: 46%;" title="Nordeste 5"></div><div class="sede-ponto" style="top: 16%;left: 38%;" title="Centro-Oeste 1"></div><div class="sede-ponto" style="top: 23%; left: 39%;" title="Centro-Oeste 2"></div><div class="sede-ponto" style="top: 13%;left: 41%;" title="Centro-Oeste 3"></div><div class="sede-ponto" style="top: -5%;left: 32%;" title="Centro-Oeste 4"></div><div class="sede-ponto" style="top: 21%;left: 37%;" title="Centro-Oeste 5"></div><div class="sede-ponto" style="top: 29%; left: 40%;" title="Sudeste 1"></div><div class="sede-ponto" style="top: 27%; left: 42%;" title="Sudeste 2"></div><div class="sede-ponto" style="top: 8%;left: 43%;" title="Sudeste 3"></div><div class="sede-ponto" style="top: 28%; left: 39%;" title="Sudeste 4"></div><div class="sede-ponto" style="top: 33%;left: 40%;" title="Sudeste 5"></div><div class="sede-ponto" style="top: 20%;left: 41%;" title="Sul 1"></div><div class="sede-ponto" style="top: 36%;left: 40%;" title="Sul 2"></div><div class="sede-ponto" style="top: 34%; left: 39%;" title="Sul 3"></div><div class="sede-ponto" style="top: 4%;left: 45%;" title="Sul 4"></div><div class="sede-ponto" style="top: 38%;left: 38%;" title="Sul 5"></div>
        </div>
    </div>
</section>

<?php get_footer(); ?>