<?php
/* Template Name: Categorias de Produtos */

get_header();

// 1. BUSCAR AS CATEGORIAS USANDO A FUNÇÃO NATIVA DO WORDPRESS
$categorias = get_terms([
    'taxonomy'   => 'categoria_maquina',
    'hide_empty' => true, 
    'parent'     => 0      
]);

// 2. VERIFICAR A CATEGORIA ATIVA PELA URL
$slug_categoria_ativa_da_url = get_query_var('slug_da_categoria');
$categoria_ativa = null;

if ($slug_categoria_ativa_da_url && !empty($categorias)) {
    foreach ($categorias as $categoria_obj) {
        if ($categoria_obj->slug === $slug_categoria_ativa_da_url) {
            $categoria_ativa = $categoria_obj;
            break;
        }
    }
}
?>

<div class="space_cat"></div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-4 titulo-pagina">Máquinas</h1>
            <p class="text-center sub-titulo-pagina">Explore nossas categorias de máquinas e encontre a <b>solução ideal</b> para sua indústria do metal.</p>
        </div>
    </div>
</div>

<div class="container my-5">
    <?php if (!empty($categorias) && !is_wp_error($categorias)): ?>
        <ul class="nav nav-tabs justify-content-center border-bottom" id="categoriaTabs" role="tablist">
            <?php foreach ($categorias as $index => $cat): 
                $is_active = ($categoria_ativa && $categoria_ativa->term_id == $cat->term_id) || (!$categoria_ativa && $index === 0);
            ?>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?php echo $is_active ? 'active' : ''; ?>" 
                       id="tab-<?php echo esc_attr($cat->slug); ?>" 
                       data-bs-toggle="tab" 
                       href="#categoria-<?php echo esc_attr($cat->slug); ?>" 
                       role="tab"
                       aria-controls="categoria-<?php echo esc_attr($cat->slug); ?>"
                       aria-selected="<?php echo $is_active ? 'true' : 'false'; ?>">
                        <?php echo esc_html($cat->name); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="tab-content" id="categoriaTabsContent">
            <?php foreach ($categorias as $index => $cat): 
                $is_active = ($categoria_ativa && $categoria_ativa->term_id == $cat->term_id) || (!$categoria_ativa && $index === 0);
                
                $args_produtos = [
                    'post_type'      => 'maquina',
                    'posts_per_page' => -1,
                    'tax_query'      => [
                        [
                            'taxonomy' => 'categoria_maquina',
                            'field'    => 'term_id',
                            'terms'    => $cat->term_id,
                        ],
                    ],
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ];
                $produtos_query = new WP_Query($args_produtos);
            ?>
                <div class="tab-pane fade <?php echo $is_active ? 'show active' : ''; ?>" id="categoria-<?php echo esc_attr($cat->slug); ?>" role="tabpanel" aria-labelledby="tab-<?php echo esc_attr($cat->slug); ?>">
                    <?php if ($produtos_query->have_posts()): ?>
                        <?php $index_produto = 0; ?>
                        <?php while ($produtos_query->have_posts()): $produtos_query->the_post();
                            $img_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                            if (empty($img_url)) { 
                                $img_url = get_template_directory_uri() . '/assets/img/placeholder.jpg';
                            }

                            $link_produto = get_the_permalink();
                            $orcamento_url = 'https://api.whatsapp.com/send?phone=554874001421&text=' . urlencode("Olá, vim do site, gostaria de um orçamento desta máquina: " . get_the_title() . " (" . $link_produto . ")");
                            
                            $reverse = $index_produto % 2 !== 0; 
                        ?>
                            <div class="banner-container mb-2">
                                <div class="product-counter <?php echo $reverse ? 'counter-right' : ''; ?>"><?php echo $index_produto + 1; ?></div>
                                <div class="container">
                                    <div class="row align-items-center <?= $reverse ? 'flex-row-reverse' : '' ?>">
                                        <div class="col-md-6 ssss">
                                            <a href="<?= esc_url($link_produto) ?>" data-no-lazy="1">
                                                <img src="<?= esc_url($img_url) ?>" alt="<?= esc_attr(get_the_title()) ?>" class="produto-img img-fluid <?= $reverse ? 'right' : '' ?>">
                                            </a>
                                        </div>
                                        <div class="col-md-6 <?= $reverse ? 'text-md-start ps-md-5 text-center' : 'text-md-end pe-md-5 text-center' ?>">
                                            <h2 class="nome_produtos mb-4"><?= esc_html(get_the_title()) ?></h2>
                                            
                                            <a href="<?= esc_url($link_produto) ?>" class="botao-produtos">
                                              <i class="bi bi-eye me-2"></i> Conheça a máquina
                                            </a>

                                            <!--<a href="<?= esc_url($orcamento_url) ?>" target="_blank" class="botao-produtos botao-whatsapp">
                                              <i class="bi bi-whatsapp me-2"></i> Orçamento via WhatsApp
                                            </a>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php $index_produto++; endwhile; wp_reset_postdata(); ?>
                    <?php else: ?>
                        <div class="alert alert-warning mt-3">Nenhum produto encontrado nesta categoria.</div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="container my-5">
             <div class="alert alert-info">Nenhuma categoria de produto encontrada.</div>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>