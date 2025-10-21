<?php
/**
 * Template para exibir o arquivo da taxonomia 'categoria_maquina'
 * com layout de abas (SEM PAGINAÇÃO).
 */

get_header();

// 1. IDENTIFICAR A CATEGORIA ATIVA ATUAL PELA URL
$categoria_ativa = get_queried_object();

// 2. BUSCAR TODAS AS CATEGORIAS PARA CRIAR AS ABAS DE NAVEGAÇÃO
$todas_categorias = get_terms([
    'taxonomy'   => 'categoria_maquina',
    'hide_empty' => true,
    'parent'     => 0
]);
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
    <?php if (!empty($todas_categorias) && !is_wp_error($todas_categorias)): ?>
        
        <ul class="nav nav-tabs justify-content-center border-bottom" id="categoriaTabs" role="tablist">
            <?php foreach ($todas_categorias as $cat_tab): 
                $is_active = ($categoria_ativa && $categoria_ativa->term_id == $cat_tab->term_id);
            ?>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?php echo $is_active ? 'active' : ''; ?>" 
                       href="<?php echo esc_url(get_term_link($cat_tab)); ?>">
                        <?php echo esc_html($cat_tab->name); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <div class="tab-content" id="categoriaTabsContent">
            <?php
            // =================================================================
            // INÍCIO DAS ALTERAÇÕES PARA REMOVER A PAGINAÇÃO
            // =================================================================

            // 3. BUSCAR TODOS OS PRODUTOS DA CATEGORIA ATIVA
            $args_produtos = [
                'post_type'      => 'maquina',
                'posts_per_page' => -1, // Alterado para -1 para buscar TODOS os produtos
                'tax_query'      => [
                    [
                        'taxonomy' => 'categoria_maquina',
                        'field'    => 'term_id',
                        'terms'    => $categoria_ativa->term_id,
                    ],
                ],
                'orderby'        => 'title',
                'order'          => 'ASC',
            ];
            $produtos_query = new WP_Query($args_produtos);
            ?>
            <div class="tab-pane fade show active" role="tabpanel">
                <?php if ($produtos_query->have_posts()): ?>
                    <?php 
                    // O contador agora é simples, iniciando do zero.
                    $index_produto = 0; 
                    ?>
                    <?php while ($produtos_query->have_posts()): $produtos_query->the_post();
                        $img_url = get_the_post_thumbnail_url(get_the_ID(), 'large') ?: get_template_directory_uri() . '/assets/img/placeholder.jpg';
                        $link_produto = get_the_permalink();
                        $orcamento_url = 'https://api.whatsapp.com/send?phone=554874001421&text=' . urlencode("Olá, vim do site, gostaria de um orçamento desta máquina: " . get_the_title() . " (" . $link_produto . ")");
                        $reverse = ($index_produto % 2 !== 0); 
                    ?>
                        <div class="banner-container mb-2">
                            <div class="product-counter <?php echo $reverse ? 'counter-right' : ''; ?>"><?php echo $index_produto + 1; ?></div>
                            <div class="container">
                                <div class="row align-items-center <?= $reverse ? 'flex-row-reverse' : '' ?>">
                                    <div class="col-md-6 ssss">
                                        <a href="<?= esc_url($link_produto) ?>">
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
                    <?php $index_produto++; endwhile; ?>

                    <?php
                    // =================================================================
                    // CÓDIGO DA PAGINAÇÃO FOI COMPLETAMENTE REMOVIDO DAQUI
                    // =================================================================
                    
                    // Restaura os dados do post original. Importante!
                    wp_reset_postdata(); 
                    ?>

                <?php else: ?>
                    <div class="alert alert-warning mt-3">Nenhum produto encontrado nesta categoria.</div>
                <?php endif; ?>
            </div>
        </div>
        
    <?php else: ?>
        <div class="container my-5">
             <div class="alert alert-info">Nenhuma categoria de produto encontrada.</div>
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>