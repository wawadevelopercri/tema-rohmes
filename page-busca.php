<?php
/* Template Name: Página de Busca */
get_header();

// Pega o termo de busca da URL de forma segura
$busca = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';

$resultados_query = null;
if (!empty($busca)) {
    // Usa WP_Query para buscar diretamente nos posts do tipo 'maquina'
    $args = [
        'post_type'      => 'maquina',
        'posts_per_page' => -1, // Pega todos os resultados
        's'              => $busca, // O parâmetro 's' busca no título e conteúdo
        'orderby'        => 'title',
        'order'          => 'ASC',
    ];
    $resultados_query = new WP_Query($args);
}
?>

<div class="container bradcamp">
    <?php // custom_breadcrumbs(); ?>
</div>

<div class="container mt-5">
    <?php if (!empty($busca)) : ?>
        <?php if ($resultados_query && $resultados_query->have_posts()) : ?>
            <p class="mb-5">
                <strong><?php echo $resultados_query->found_posts; ?></strong> resultado<?php echo $resultados_query->found_posts > 1 ? 's' : ''; ?> encontrado<?php echo $resultados_query->found_posts > 1 ? 's' : ''; ?> com o termo "<b class="busca"><?php echo esc_html($busca); ?></b>".
            </p>

            <?php $index = 0; ?>
            <?php while ($resultados_query->have_posts()) : $resultados_query->the_post();
                
                // Pega o título oficial do post - sempre consistente
                $nome_produto = get_the_title();

                // Pega a imagem destacada do post
                $img_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                if (!$img_url) {
                    $img_url = get_template_directory_uri() . '/assets/img/placeholder.jpg';
                }

                // Pega o link permanente (URL amigável) oficial do post
                $link_produto = get_permalink();

                // Monta os links de WhatsApp
                $orcamento_url = 'https://api.whatsapp.com/send?phone=554874001421&text=' . urlencode("Olá, vim do site, gostaria de um orçamento desta máquina: " . $nome_produto . " (" . $link_produto . ")");

                // Alternância de layout a cada post
                $reverse = $index % 2 !== 0;
            ?>
                <div class="banner-container mb-5">
                    <div class="container py-5">
                        <div class="row align-items-center <?= $reverse ? 'flex-row-reverse' : '' ?>">
                            <div class="col-md-6">
                                <img src="<?= esc_url($img_url) ?>" alt="<?= esc_attr($nome_produto) ?>" class="img-fluid produto-img <?= $reverse ? 'right' : '' ?>">
                            </div>
                            <div class="col-md-6 d-flex flex-column align-items-center text-center d-md-block <?= $reverse ? 'text-md-start ps-md-5' : 'text-md-end pe-md-5' ?> align-items-md-stretch">
                                <h2 class="nome_produtos mb-4"><?= esc_html($nome_produto) ?></h2>

                                <a href="<?= esc_url($link_produto) ?>" class="botao-produtos">
                                    <i class="bi bi-eye me-2"></i> Conheça a máquina
                                </a>

                                <a href="<?= esc_url($orcamento_url) ?>" target="_blank" class="botao-produtos">
                                    <i class="bi bi-whatsapp me-2"></i> Orçamento via WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php 
                $index++;
                endwhile; 
                // Restaura os dados do post original após o loop
                wp_reset_postdata(); 
            ?>
        <?php else : ?>
            <div class="alert alert-warning mt-4" role="alert">
                Nenhuma máquina encontrada com o termo "<strong><?php echo esc_html($busca); ?></strong>". Por favor, tente uma busca diferente.
            </div>
        <?php endif; ?>
    <?php else : ?>
        <div class="alert alert-info mt-4" role="alert">
            Por favor, digite um termo no campo de busca para encontrar máquinas.
        </div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>