<?php
/**
 * Template Name: Página de Produtos e Categorias
 */
get_header();

global $wpdb;

// Tabelas corretas
$tabela_produtos = $wpdb->prefix . 'maquinas';
$tabela_categorias = $wpdb->prefix . 'gp_categorias';

// Recupera todas as categorias
$categorias = $wpdb->get_results("SELECT id, nome FROM $tabela_categorias ORDER BY nome");

// Recupera todos os produtos agrupados por categoria
$produtos_por_categoria = [];
foreach ($categorias as $categoria) {
    $produtos = $wpdb->get_results($wpdb->prepare("SELECT id, nome, fotos FROM $tabela_produtos WHERE categoria_id = %d ORDER BY nome", $categoria->id));
    $produtos_por_categoria[$categoria->id] = $produtos;
}
?>

<div class="container-fluid mt-5">
    <!-- Tabs de Categorias -->
    <ul class="nav nav-tabs mb-4" id="categoriaTabs" role="tablist">
        <?php foreach ($categorias as $index => $categoria) : ?>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?php echo $index === 0 ? 'active' : ''; ?>" id="tab-<?php echo $categoria->id; ?>" data-bs-toggle="tab" data-bs-target="#categoria-<?php echo $categoria->id; ?>" type="button" role="tab">
                    <?php echo esc_html($categoria->nome); ?>
                </button>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Conteúdo das Abas -->
    <div class="tab-content" id="categoriaTabsContent">
        <?php foreach ($categorias as $index => $categoria) :
            $produtos = $produtos_por_categoria[$categoria->id];
        ?>
            <div class="tab-pane fade <?php echo $index === 0 ? 'show active' : ''; ?>" id="categoria-<?php echo $categoria->id; ?>" role="tabpanel">
                <?php if (!empty($produtos)) : ?>
                    <?php foreach ($produtos as $i => $produto) :
                        $nome = esc_html($produto->nome);

                        // Imagem
                        $fotos_array = explode(',', $produto->fotos);
                        $foto_path = trim($fotos_array[0], " []\"'");
                        $img = (!empty($foto_path)) 
                            ? (filter_var($foto_path, FILTER_VALIDATE_URL) ? esc_url($foto_path) : esc_url(home_url($foto_path)))
                            : 'https://via.placeholder.com/600x400?text=Sem+Imagem';

                        // Links
                        $link = site_url('/ecossistema-de-maquinas/?produto=' . $produto->id);
                        $mensagem = 'Veja este produto: ' . $link;
                        $whatsapp_url = 'https://wa.me/?text=' . urlencode($mensagem);
                        $orcamento_url = 'https://api.whatsapp.com/send?phone=554874001421&text=' . urlencode("Olá, vim do site, gostaria de um orçamento dessa máquina: $link");

                        // Alternar layout
                        $reverse = $i % 2 !== 0;
                    ?>
                        <div class="banner-container mb-5">
                            <div class="container py-5">
                                <div class="row align-items-center <?= $reverse ? 'flex-row-reverse' : '' ?>">
                                    <div class="col-md-6">
                                        <img src="<?= $img ?>" alt="<?= $nome ?>" class="produto-img <?= $reverse ? 'right' : '' ?>">
                                    </div>
                                    <div class="col-md-6 <?= $reverse ? 'text-start ps-md-5' : 'text-end pe-md-5' ?>">
                                        <h2 class="nome_produtos mb-4"><?= $nome ?></h2>
                                        <a href="<?= esc_url($link) ?>" class="learn-more-6 me-3">
                                            <span class="circle-6"><span class="icon-6 arrow-6"></span></span>
                                            <span class="button-text-6">Saiba mais</span>
                                        </a>
                                        <a href="<?= esc_url($orcamento_url) ?>" target="_blank" class="botao-produtos">
                                            <i class="bi bi-whatsapp me-2"></i> Orçamento via WhatsApp
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="alert alert-warning">Nenhum produto encontrado nesta categoria.</div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php get_footer(); ?>
