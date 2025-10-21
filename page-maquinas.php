<?php
/**
 * Template Name: Página de Máquinas
 * Description: Exibe todas as máquinas em um layout de abas por categoria.
 */

get_header();

// 1. BUSCAR AS CATEGORIAS DE NÍVEL SUPERIOR
$categorias = get_terms([
    'taxonomy'   => 'categoria_maquina',
    'hide_empty' => true, 
    'parent'     => 0      
]);
?>

<main id="main-content">
    <div class="space_cat"></div>

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h1 class="text-center mb-4 titulo-pagina"><?php the_title(); ?></h1>
                <?php if (get_the_content()): ?>
                    <p class="text-center sub-titulo-pagina"><?php the_content(); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <?php if (!empty($categorias) && !is_wp_error($categorias)): ?>

            <ul class="nav nav-tabs justify-content-center border-bottom mb-4" id="categoriaTabs" role="tablist">
                <?php foreach ($categorias as $index => $cat): ?>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>" 
                           id="tab-<?php echo esc_attr($cat->slug); ?>" 
                           data-bs-toggle="tab" 
                           data-bs-target="#content-<?php echo esc_attr($cat->slug); ?>" 
                           type="button" role="tab"
                           aria-controls="content-<?php echo esc_attr($cat->slug); ?>"
                           aria-selected="<?php echo $index === 0 ? 'true' : 'false'; ?>">
                            <?php echo esc_html($cat->name); ?>
                        </button>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="tab-content" id="categoriaTabsContent">
                <?php foreach ($categorias as $index => $cat): 
                    
                    // Query para buscar os produtos de cada categoria
                    $args_produtos = [
                        'post_type'      => 'maquina',
                        'posts_per_page' => -1, // -1 para mostrar todos
                        'tax_query'      => [
                            [
                                'taxonomy' => 'categoria_maquina',
                                'field'    => 'term_id',
                                'terms'    => $cat->term_id,
                                'include_children' => true,
                            ],
                        ],
                        'orderby'        => 'title',
                        'order'          => 'ASC',
                    ];
                    $produtos_query = new WP_Query($args_produtos);
                ?>
                    <div class="tab-pane fade <?php echo $index === 0 ? 'show active' : ''; ?>" id="content-<?php echo esc_attr($cat->slug); ?>" role="tabpanel" aria-labelledby="tab-<?php echo esc_attr($cat->slug); ?>">
                        <?php if ($produtos_query->have_posts()): ?>
                            <?php $index_produto = 0; ?>
                            <?php while ($produtos_query->have_posts()): $produtos_query->the_post();
                                $img_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                                if (empty($img_url)) { 
                                    $img_url = get_template_directory_uri() . '/assets/img/placeholder.jpg';
                                }

                                $link_produto = get_the_permalink();
                                $orcamento_url = 'https://api.whatsapp.com/send?phone=554874001421&text=' . urlencode("Olá, vim do site, gostaria de um orçamento para a máquina: " . get_the_title() . " (" . $link_produto . ")");
                                
                                $reverse = $index_produto % 2 !== 0; 
                            ?>
                                <div class="banner-container mb-2">
                                    <div class="product-counter <?php echo $reverse ? 'counter-right' : ''; ?>"><?php echo $index_produto + 1; ?></div>
                                    <div class="container">
                                        <div class="row align-items-center <?php echo $reverse ? 'flex-row-reverse' : ''; ?>">
                                            <div class="col-md-6 ssss">
                                                <a href="<?php echo esc_url($link_produto); ?>">
                                                    <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="produto-img img-fluid <?php echo $reverse ? 'right' : ''; ?>">
                                                </a>
                                            </div>
                                            <div class="col-md-6 <?php echo $reverse ? 'text-md-start ps-md-5 text-center' : 'text-md-end pe-md-5 text-center' ?>">
                                                <h2 class="nome_produtos mb-4"><?php echo esc_html(get_the_title()); ?></h2>
                                                
                                                <a href="<?php echo esc_url($link_produto); ?>" class="botao-produtos">
                                                  <i class="bi bi-eye me-2"></i> Conheça a máquina
                                                </a>

                                                <a href="<?php echo esc_url($orcamento_url); ?>" target="_blank" class="botao-produtos botao-whatsapp">
                                                  <i class="bi bi-whatsapp me-2"></i> Orçamento via WhatsApp
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php $index_produto++; endwhile; wp_reset_postdata(); ?>
                        <?php else: ?>
                            <div class="alert alert-info mt-3 text-center">Nenhuma máquina encontrada nesta categoria.</div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php else: ?>
            <div class="alert alert-warning text-center">Nenhuma categoria de máquina foi encontrada.</div>
        <?php endif; ?>
    </div>
</main>

<?php get_footer(); ?>