<?php
/**
 * O template para exibir um único produto do tipo "Máquina".
 * Versão unificada com modais de Corte a Laser e Dobradeira
 */

get_header();
?>

<main id="primary" class="site-main">

<?php

if (have_posts()) :
    while (have_posts()) : the_post();

        // --- PREPARAÇÃO DOS DADOS ---
        $categorias = get_the_terms(get_the_ID(), 'categoria_maquina');
        $categoria_principal = (!empty($categorias) && !is_wp_error($categorias)) ? $categorias[0] : null;
        $link_produto = get_the_permalink();

        // Verifica se a máquina pertence às categorias específicas
        $is_corte_laser = has_term('corte-a-laser', 'categoria_maquina', $post);
        $is_dobradeira  = has_term('dobradeiras', 'categoria_maquina', $post);
        $is_solda_laser = has_term('solda-a-laser', 'categoria_maquina', $post);

        // URL padrão para o botão do WhatsApp
        $orcamento_whatsapp_url = 'https://api.whatsapp.com/send?phone=554874001421&text=' . urlencode("Olá, vim do site, gostaria de um orçamento desta máquina: " . get_the_title() . " (" . $link_produto . ")");

        // --- LÓGICA DE IMAGENS E METADADOS ---
        $id_imagem_principal = get_post_thumbnail_id(get_the_ID());
        $imagem_principal_url = get_the_post_thumbnail_url(get_the_ID(), 'large') ?: get_template_directory_uri() . '/assets/img/placeholder.jpg';
        $ids_galeria_str = get_post_meta(get_the_ID(), '_maquina_image_gallery', true);
        $ids_galeria = !empty($ids_galeria_str) ? explode(',', $ids_galeria_str) : [];
        $todos_os_ids = array_unique(array_filter(array_merge([$id_imagem_principal], $ids_galeria)));
        
        // Dados dos Meta Boxes
        $vantagens = get_post_meta(get_the_ID(), '_vantagens', true);
        $potencias = get_post_meta(get_the_ID(), '_potencias', true);
        $tabelas_adicionais = get_post_meta(get_the_ID(), '_tabelas_adicionais', true);
        $componentes = get_post_meta(get_the_ID(), '_componentes_logos', true);
        $software_inclusos = get_post_meta(get_the_ID(), '_software_logos', true);
        $software_adicionais = get_post_meta(get_the_ID(), '_software_adicional_logos', true);
?>

        <div class="container titulo">
            <h2><?php the_title(); ?></h2>
        </div>

        <section class="fotos-produtos">
            <div class="container my-5">
                <div class="row align-items-center justify-content-center galeria-row">
                    <?php if (count($todos_os_ids) > 1): ?>
                        <div class="col-12 col-md-4 carousel-thumbs order-2 order-md-1">
                            <?php foreach ($todos_os_ids as $index => $id_imagem): ?>
                                <img src="<?= esc_url(wp_get_attachment_image_url($id_imagem, 'medium')) ?>"
                                     class="img-fluid thumbnail-img <?= $index === 0 ? 'active' : '' ?>"
                                     data-large="<?= esc_url(wp_get_attachment_image_url($id_imagem, 'large')) ?>"
                                     alt="Miniatura <?php the_title_attribute(); ?> <?= $index + 1 ?>">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="col-12 <?php echo count($todos_os_ids) > 1 ? 'col-md-8' : 'col-md-10'; ?> fotos-maquinas d-flex order-1 order-md-2">
                        <div class="border">
                            <a id="mainImageLink" href="<?= esc_url($imagem_principal_url) ?>" class="glightbox" data-gallery="galeria-principal" style="cursor: zoom-in;" title="">
                                <img id="mainImage" src="<?= esc_url($imagem_principal_url) ?>" alt="Imagem principal de <?php the_title_attribute(); ?>" class="img-fluid main-img rounded">
                            </a>
                            
                            <div id="openNr12ModalBtn" class="nr12-seal-wrapper">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/NR-12.png" alt="Selo NR 12" class="nr12-seal-logo">
                            </div>
                            
                            <div style="display: none;">
                                <?php foreach ($todos_os_ids as $id_imagem): ?>
                                    <a href="<?= esc_url(wp_get_attachment_image_url($id_imagem, 'full')) ?>" class="glightbox" data-gallery="galeria-produto"></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

<div class="botoes_produtos my-5 text-center">
    <?php if ($is_corte_laser) : ?>
        <a href="#" class="botao-produtos-2 open-modal-btn" data-target="#corteLaserModal">
            <i class="bi bi-ui-checks-grid me-2"></i> Fazer uma cotação
        </a>
    <?php elseif ($is_dobradeira) : ?>
        <a href="#" class="botao-produtos-2 open-modal-btn" data-target="#dobradeiraModal">
            <i class="bi bi-ui-checks-grid me-2"></i> Fazer uma cotação
        </a>
    <?php elseif ($is_solda_laser) : ?>
        <a href="#" class="botao-produtos-2 open-modal-btn" data-target="#soldaLaserModal">
            <i class="bi bi-ui-checks-grid me-2"></i> Fazer uma cotação
        </a>
    <?php else : ?>
        <a href="<?= esc_url($orcamento_whatsapp_url) ?>" target="_blank" class="botao-produtos-2">
            <i class="bi bi-whatsapp me-2"></i> Fazer um orçamento
        </a>
    <?php endif; ?>
</div>
                
                <?php if (!empty($vantagens) && is_array($vantagens)): ?>
                    <div class="row justify-content-center mt-5">
                        <div class="col-12">
                            <div class="vantagens-maquinas-em-linha">
                                <ul>
                                    <?php foreach ($vantagens as $vantagem): ?>
                                        <li class="icon-hover-wrapper">
                                            <i class="<?= esc_attr($vantagem['icone']) ?> icon-hover"></i> <?= esc_html($vantagem['texto']) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <div class="container my-5">
            <div class="row gx-lg-5">
                <div class="col-lg-12">
                    <?php if (!empty($potencias)): ?>
                        <section class="potencias-section">
                            <ul class="nav nav-tabs justify-content-center" id="potenciaTab" role="tablist">
                                <?php foreach ($potencias as $index => $potencia): ?>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link <?= $index === 0 ? 'active' : '' ?>" id="potencia-<?= $index ?>-tab" data-bs-toggle="tab" data-bs-target="#potencia-<?= $index ?>" type="button" role="tab" aria-controls="potencia-<?= $index ?>" aria-selected="<?= $index === 0 ? 'true' : 'false' ?>">
                                            <?= esc_html($potencia['titulo']) ?>
                                        </button>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                            <div class="tab-content pt-4" id="potenciaTabContent">
                                <?php foreach ($potencias as $index => $potencia): ?>
                                    <div class="tab-pane fade <?= $index === 0 ? 'show active' : '' ?>" id="potencia-<?= $index ?>" role="tabpanel" aria-labelledby="potencia-<?= $index ?>-tab">
                                        <?php if (!empty($potencia['id_imagem']) && $url_imagem = wp_get_attachment_image_url($potencia['id_imagem'], 'large')): ?>
                                            <a href="<?= esc_url($url_imagem); ?>" class="glightbox mb-4 d-block text-center" data-gallery="potencia-<?= $index ?>">
                                                <img src="<?= esc_url($url_imagem); ?>" class="img-fluid rounded shadow-sm" alt="Imagem para <?= esc_attr($potencia['titulo']); ?>">
                                            </a>
                                        <?php endif; ?>
                                        <div class="potencia-descricao mb-5">
                                            <?php echo apply_filters('the_content', $potencia['desc']); ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </section>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <?php if (!empty($componentes) && is_array($componentes)) : ?>
        <section class="componentes-section">
            <div class="container">
                <h2 class="componentes-titulo">Configuração dos Componentes</h2>
                <div class="componentes-grid">
                    <?php foreach ($componentes as $componente) :
                        if (!empty($componente['logo_id']) && !empty($componente['titulo']) && $logo_url = wp_get_attachment_image_url($componente['logo_id'], 'medium')) : ?>
                        <div class="componente-card" title="<?= esc_attr($componente['titulo']); ?>">
                            <div class="componente-card-imagem">
                                <img src="<?= esc_url($logo_url); ?>" alt="Logotipo <?= esc_attr($componente['titulo']); ?>" class="img-fluid">
                            </div>
                            <h4 class="componente-card-titulo"><?= esc_html($componente['titulo']); ?></h4>
                        </div>
                    <?php endif; endforeach; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>

        <?php if ((!empty($software_inclusos) && is_array($software_inclusos)) || (!empty($software_adicionais) && is_array($software_adicionais))) : ?>
        <section class="softwares-section-combined">
            <div class="container">
                <div class="software-groups-wrapper">
                    <?php if (!empty($software_inclusos) && is_array($software_inclusos)) : ?>
                    <div class="software-group">
                        <h3 class="softwares-titulo">Softwares Inclusos</h3>
                        <div class="software-logos-grid">
                            <?php foreach ($software_inclusos as $software) :
                                if (!empty($software['logo_id']) && $logo_url = wp_get_attachment_image_url($software['logo_id'], 'medium')) : ?>
                                <div class="software-logo-card" title="<?= esc_attr($software['name']); ?>">
                                    <img src="<?= esc_url($logo_url); ?>" alt="<?= esc_attr($software['name']); ?>" class="img-fluid">
                                </div>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($software_inclusos) && !empty($software_adicionais)) : ?>
                        <div class="software-divider"></div>
                    <?php endif; ?>
                    
                    <?php if (!empty($software_adicionais) && is_array($software_adicionais)) : ?>
                    <div class="software-group">
                        <h3 class="softwares-titulo">Softwares Adicionais</h3>
                        <div class="software-logos-grid">
                           <?php foreach ($software_adicionais as $software) :
                                if (!empty($software['logo_id']) && $logo_url = wp_get_attachment_image_url($software['logo_id'], 'medium')) : ?>
                                <div class="software-logo-card" title="<?= esc_attr($software['name']); ?>">
                                    <img src="<?= esc_url($logo_url); ?>" alt="<?= esc_attr($software['name']); ?>" class="img-fluid">
                                </div>
                            <?php endif; endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <?php endif; ?>
        
<div class="botoes_produtos my-5 text-center">
    <?php if ($is_corte_laser) : ?>
        <a href="#" class="botao-produtos-2 open-modal-btn" data-target="#corteLaserModal">
            <i class="bi bi-ui-checks-grid me-2"></i> Fazer uma cotação
        </a>
    <?php elseif ($is_dobradeira) : ?>
        <a href="#" class="botao-produtos-2 open-modal-btn" data-target="#dobradeiraModal">
            <i class="bi bi-ui-checks-grid me-2"></i> Fazer uma cotação
        </a>
    <?php elseif ($is_solda_laser) : ?>
        <a href="#" class="botao-produtos-2 open-modal-btn" data-target="#soldaLaserModal">
            <i class="bi bi-ui-checks-grid me-2"></i> Fazer uma cotação
        </a>
    <?php else : ?>
        <a href="<?= esc_url($orcamento_whatsapp_url) ?>" target="_blank" class="botao-produtos-2">
            <i class="bi bi-whatsapp me-2"></i> Fazer um orçamento
        </a>
    <?php endif; ?>
</div>
        
        <?php if ($categoria_principal) :
            $args_relacionados = [
                'post_type' => 'maquina',
                'posts_per_page' => 4,
                'post__not_in' => [get_the_ID()],
                'tax_query' => [
                    [
                        'taxonomy' => 'categoria_maquina',
                        'field' => 'term_id',
                        'terms' => $categoria_principal->term_id
                    ]
                ],
                'orderby' => 'rand'
            ];
            $relacionados_query = new WP_Query($args_relacionados);
            if ($relacionados_query->have_posts()) : ?>
                <section class="maquinas-relacionados-section mt-5">
                    <div class="container">
                        <h2 class="maquinas-relacionados-titulo">Veja Também</h2>
                        <div class="row">
                            <?php while ($relacionados_query->have_posts()) : $relacionados_query->the_post(); ?>
                                <div class="col-lg-3 col-md-6 mb-4">
                                    <div class="maquina-card-relacionado">
                                        <a href="<?php the_permalink(); ?>" class="maquina-card-link">
                                            <div class="maquina-card-imagem-wrapper">
                                                <?php the_post_thumbnail('medium_large', ['class' => 'maquina-card-imagem']); ?>
                                                <div class="maquina-card-overlay"></div>
                                            </div>
                                            <div class="maquina-card-conteudo">
                                                <h3 class="maquina-card-titulo"><?php the_title(); ?></h3>
                                                <span class="btn btn-primary btn-sm mt-auto">Ver Detalhes</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </section>
        <?php endif; wp_reset_postdata(); endif; ?>

        <div id="nr12Modal" class="modal-nr12">
            <div class="modal-content-nr12">
                <div class="nr12-modal-header">
                    <h5 class="nr12-modal-title">Segurança NR 12</h5>
                    <span class="close-btn-nr12">&times;</span>
                </div>
                <div class="nr12-modal-body">
                    <p>Esta máquina está em conformidade com a Norma Regulamentadora 12 (NR 12)...</p>
                </div>
                <div class="nr12-modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeNr12ModalBtnFooter">Fechar</button>
                </div>
            </div>
        </div>

<?php
    endwhile;
endif;

// =========================================================================
// == MODAIS CONDICIONAIS (Corte a Laser e Dobradeira)                   ==
// =========================================================================

// Modal de Corte a Laser
if ($is_corte_laser):
?>
<div id="corteLaserModal" class="modal-corte-laser">
    <div class="modal-content-corte-laser">
        <span class="close-btn-corte-laser">&times;</span>
        <h2 class="text-center mb-4">Formulário de Cotação</h2>
        
        <form id="corteLaserForm">
            <input type="hidden" name="maquina_nome" value="<?php the_title_attribute(); ?>">
            <input type="hidden" name="maquina_link" value="<?php the_permalink(); ?>">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="cl-cnpj" class="form-label">CNPJ</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="cl-cnpj" name="cnpj" placeholder="Digite apenas números">
                        <span class="input-group-text" id="cl-cnpj-status" style="display: none;">
                            <div class="spinner-border spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>
                        </span>
                    </div>
                    <div id="cl-cnpj-error-message" class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label for="cl-nomeEmpresa" class="form-label">Nome da empresa</label>
                    <input type="text" class="form-control" id="cl-nomeEmpresa" name="nomeEmpresa" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="cl-seuNome" class="form-label">Seu nome</label>
                    <input type="text" class="form-control" id="cl-seuNome" name="seuNome" required>
                </div>
                <div class="col-md-6">
                    <label for="cl-telefone" class="form-label">Telefone</label>
                    <input type="tel" class="form-control" id="cl-telefone" name="telefone" required>
                </div>
            </div>

            <div class="mb-4">
                <label for="cl-email" class="form-label">Email</label>
                <input type="email" class="form-control" id="cl-email" name="email" required>
            </div>

            <hr class="my-4">

            <div class="mb-4">
                <label class="form-label d-block mb-3">Qual é o material que sua empresa geralmente processa?</label>
                <div class="custom-radio-group">
                    <label class="custom-radio-label"><input type="radio" name="material" value="Aço carbono"><span>Aço carbono</span></label>
                    <label class="custom-radio-label"><input type="radio" name="material" value="Aço inoxidável"><span>Aço inoxidável</span></label>
                    <label class="custom-radio-label"><input type="radio" name="material" value="Alumínio"><span>Alumínio</span></label>
                    <label class="custom-radio-label"><input type="radio" name="material" value="Ferro"><span>Ferro</span></label>
                    <label class="custom-radio-label"><input type="radio" name="material" value="Latão"><span>Latão</span></label>
                    <label class="custom-radio-label"><input type="radio" name="material" value="Outros metais"><span>Outros metais</span></label>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label d-block mb-3">Quando busca investir em uma corte a laser?</label>
                <div class="custom-radio-group">
                    <label class="custom-radio-label"><input type="radio" name="investimento" value="Imediato" required><span>Imediato</span></label>
                    <label class="custom-radio-label"><input type="radio" name="investimento" value="Em até 3 meses"><span>Em até 3 meses</span></label>
                    <label class="custom-radio-label"><input type="radio" name="investimento" value="De 3 a 6 meses"><span>De 3 a 6 meses</span></label>
                    <label class="custom-radio-label"><input type="radio" name="investimento" value="Dentro de 1 ano"><span>Dentro de 1 ano</span></label>
                    <label class="custom-radio-label"><input type="radio" name="investimento" value="Mais que 1 ano"><span>Mais que 1 ano</span></label>
                    <label class="custom-radio-label"><input type="radio" name="investimento" value="Apenas sondando informações"><span>Apenas sondando informações</span></label>
                </div>
            </div>

            <button type="submit" class="botao-produtos-2 w-100 mt-3">Enviar Cotação</button>
        </form>
    </div>
</div>
<?php
endif;


// Modal de Dobradeira
if ($is_dobradeira):
?>
<div id="dobradeiraModal" class="modal-dobradeira">
    <div class="modal-content-dobradeira">
        <span class="close-btn-dobradeira">&times;</span>
        <h2 class="text-center mb-4">Formulário de Cotação</h2>
        
        <form id="dobradeiraForm">
            <input type="hidden" name="maquina_nome" value="<?php the_title_attribute(); ?>">
            <input type="hidden" name="maquina_link" value="<?php the_permalink(); ?>">
            
            <div class="mb-4">
                <label class="form-label d-block mb-2">Quando busca investir em uma dobradeira?</label>
                <textarea class="form-control" name="quando_investir" rows="3" placeholder="Descreva quando pretende investir..." required></textarea>
            </div>
            
            <div class="mb-4">
                <label class="form-label d-block mb-2">Qual espessura e comprimento do metal que busca dobrar?</label>
                <textarea class="form-control" name="especificacoes" rows="4" placeholder="Insira sua resposta..." required></textarea>
            </div>
            
            <hr class="my-4">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="d-cnpj" class="form-label">CNPJ</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="d-cnpj" name="cnpj" placeholder="Digite apenas números">
                        <span class="input-group-text" id="d-cnpj-status" style="display: none;">
                            <div class="spinner-border spinner-border-sm"></div>
                        </span>
                    </div>
                    <div id="d-cnpj-error-message" class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label for="d-nomeEmpresa" class="form-label">Nome da empresa</label>
                    <input type="text" class="form-control" id="d-nomeEmpresa" name="nomeEmpresa" required>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="d-seuNome" class="form-label">Seu nome</label>
                    <input type="text" class="form-control" id="d-seuNome" name="seuNome" required>
                </div>
                <div class="col-md-6">
                    <label for="d-telefone" class="form-label">Telefone</label>
                    <input type="tel" class="form-control" id="d-telefone" name="telefone" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="d-email" class="form-label">Email</label>
                <input type="email" class="form-control" id="d-email" name="email" required>
            </div>
            
            <button type="submit" class="botao-produtos-2 w-100 mt-3">Enviar Cotação</button>
        </form>
    </div>
</div>
<?php
endif;

// Modal de Solda a Laser
if ($is_solda_laser):
?>
<div id="soldaLaserModal" class="modal-solda-laser">
    <div class="modal-content-solda-laser">
        <span class="close-btn-solda-laser">&times;</span>
        <h2 class="text-center mb-4">Formulário de Cotação</h2>
        
        <form id="soldaLaserForm">
            <input type="hidden" name="maquina_nome" value="<?php the_title_attribute(); ?>">
            <input type="hidden" name="maquina_link" value="<?php the_permalink(); ?>">

            <div class="mb-4">
                <label class="form-label d-block mb-3">Qual é o material que sua empresa geralmente processa?</label>
                <div class="custom-radio-group">
                    <label class="custom-radio-label"><input type="radio" name="material" value="Aço carbono" required><span>Aço carbono</span></label>
                    <label class="custom-radio-label"><input type="radio" name="material" value="Aço inoxidável"><span>Aço inoxidável</span></label>
                    <label class="custom-radio-label"><input type="radio" name="material" value="Alumínio"><span>Alumínio</span></label>
                    <label class="custom-radio-label"><input type="radio" name="material" value="Ferro"><span>Ferro</span></label>
                    <label class="custom-radio-label"><input type="radio" name="material" value="Latão"><span>Latão</span></label>
                    <label class="custom-radio-label"><input type="radio" name="material" value="Outros metais"><span>Outros metais</span></label>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="form-label d-block mb-3">Quando busca investir em uma solda a laser?</label>
                <div class="custom-radio-group">
                    <label class="custom-radio-label"><input type="radio" name="investimento" value="Imediato" required><span>Imediato</span></label>
                    <label class="custom-radio-label"><input type="radio" name="investimento" value="Em até 3 meses"><span>Em até 3 meses</span></label>
                    <label class="custom-radio-label"><input type="radio" name="investimento" value="De 3 a 6 meses"><span>De 3 a 6 meses</span></label>
                    <label class="custom-radio-label"><input type="radio" name="investimento" value="Dentro de 1 ano"><span>Dentro de 1 ano</span></label>
                    <label class="custom-radio-label"><input type="radio" name="investimento" value="Mais que 1 ano"><span>Mais que 1 ano</span></label>
                    <label class="custom-radio-label"><input type="radio" name="investimento" value="Apenas sondando informações, não tenho certeza de quando quero investir"><span>Apenas sondando informações, não tenho certeza de quando quero investir</span></label>
                </div>
            </div>

            <hr class="my-4">
                            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="s-cnpj" class="form-label">CNPJ</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="s-cnpj" name="cnpj" placeholder="Digite apenas números">
                        <span class="input-group-text" id="s-cnpj-status" style="display: none;">
                            <div class="spinner-border spinner-border-sm"></div>
                        </span>
                    </div>
                    <div id="s-cnpj-error-message" class="invalid-feedback"></div>
                </div>
                <div class="col-md-6">
                    <label for="s-nomeEmpresa" class="form-label">Nome da empresa</label>
                    <input type="text" class="form-control" id="s-nomeEmpresa" name="nomeEmpresa" required>
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="s-seuNome" class="form-label">Seu nome</label>
                    <input type="text" class="form-control" id="s-seuNome" name="seuNome" required>
                </div>
                <div class="col-md-6">
                    <label for="s-telefone" class="form-label">Telefone</label>
                    <input type="tel" class="form-control" id="s-telefone" name="telefone" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="s-email" class="form-label">Email</label>
                <input type="email" class="form-control" id="s-email" name="email" required>
            </div>
            
            <button type="submit" class="botao-produtos-2 w-100 mt-3">Enviar Cotação</button>
        </form>
    </div>
</div>
<?php
endif;
?>


</main><?php
get_footer();
?>