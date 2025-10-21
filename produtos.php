<?php
/* Template Name: Produto Detalhado */

?>



<?php

global $wpdb;
$produto_para_pagina = null;
$categoria_para_pagina = null;
$product_slug_url = get_query_var('product_slug');
$category_slug_url = get_query_var('category_slug');

if ($product_slug_url) {
    $tabela_produtos_db = $wpdb->prefix . 'maquinas';
    $tabela_categorias_db = $wpdb->prefix . 'gp_categorias';

    // Busca o produto pelo slug (nome sanitizado)
    $lista_total_produtos = $wpdb->get_results("SELECT * FROM {$tabela_produtos_db}");
    if ($lista_total_produtos) {
        foreach ($lista_total_produtos as $item_produto) {
            if (sanitize_title($item_produto->nome) === $product_slug_url) {
                $produto_para_pagina = $item_produto;
                break;
            }
        }
    }

    // Se encontrou o produto, busca a categoria
    if ($produto_para_pagina && isset($produto_para_pagina->categoria_id)) {
        $categoria_obj_db = $wpdb->get_row($wpdb->prepare(
            "SELECT id, nome FROM {$tabela_categorias_db} WHERE id = %d",
            $produto_para_pagina->categoria_id
        ));
        if ($categoria_obj_db) {
            $categoria_para_pagina = (object) [
                'id' => $categoria_obj_db->id,
                'nome' => $categoria_obj_db->nome,
                'slug' => sanitize_title($categoria_obj_db->nome)
            ];
        }
    }
}


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>
        <?php 
            if ($produto_para_pagina) {
                echo esc_html($produto_para_pagina->nome) . ' | Rohmes Máquinas';
            } else {
                echo 'Produto não encontrado | Rohmes Máquinas';
            }
        ?>
    </title>
    <?php wp_head(); ?>
</head>
<?php
// --- AJUSTE DE TÍTULO E CONTEXTO DA PÁGINA (SOLUÇÃO ROBUSTA) ---

// 1. Primeiro, vamos usar o filtro `pre_get_document_title`.
// Este filtro é executado antes de `document_title_parts` e pode definir o título de forma definitiva.
// Isso é útil para anular qualquer outra manipulação de título feita por plugins de SEO (como Yoast).
add_filter('pre_get_document_title', function ($title) use ($produto_para_pagina, $categoria_para_pagina) {
    if ($produto_para_pagina && !empty($produto_para_pagina->nome)) {
        $new_title = esc_html($produto_para_pagina->nome);
        if ($categoria_para_pagina && !empty($categoria_para_pagina->nome)) {
            $new_title .= ' - ' . esc_html($categoria_para_pagina->nome);
        }
        // Adiciona o nome do site ao final, que é uma prática comum de SEO.
        $new_title .= ' - ' . get_bloginfo('name');
        return $new_title;
    }
    // Se não houver produto, retorna o título original para não afetar outras páginas.
    return $title;
}, 20); // Prioridade alta (20) para tentar executar antes de outros filtros.

// 2. Para garantir compatibilidade máxima e resolver a causa raiz,
// vamos simular um post global.
add_action('wp', function() use ($produto_para_pagina) {
    if (is_page_template('produtos.php') && $produto_para_pagina) {
        global $post;

        // Cria um objeto WP_Post "falso" com as informações do nosso produto.
        // Isso ajuda o WordPress e plugins a entenderem o contexto da página.
        $post = new WP_Post((object)[
            'ID'             => $produto_para_pagina->id, // Use o ID do seu produto
            'post_title'     => $produto_para_pagina->nome,
            'post_name'      => sanitize_title($produto_para_pagina->nome),
            'post_content'   => '', // O conteúdo é gerenciado pelo template
            'post_excerpt'   => '',
            'post_status'    => 'publish',
            'post_type'      => 'page', // Trata como uma página para fins de contexto
            'comment_status' => 'closed',
            'ping_status'    => 'closed',
        ]);

        // Configura os dados globais do post
        setup_postdata($post);
    }
});

// --- FIM DO AJUSTE ---

get_header();

// O restante do seu código permanece igual...
?>
<div class="container-fluid bradcamp">
    <?php
    /*custom_breadcrumbs([
        'product_name'  => ($produto_para_pagina ? $produto_para_pagina->nome : ''),
        'category_name' => ($categoria_para_pagina ? $categoria_para_pagina->nome : ''),
        'category_slug' => ($categoria_para_pagina ? $categoria_para_pagina->slug : '')
    ]);*/
    ?>
</div>
<?php

$produto = $produto_para_pagina;

if (!$produto) {
    echo '<div class="container my-5"><h3>Produto não encontrado.</h3><p>Verifique o endereço ou <a href="' . esc_url(home_url('/categorias/')) . '">volte para a página de categorias</a>.</p></div>';
    get_footer();
    exit;
}

// O restante do seu template produtos.php continua aqui...
// Use $produto para detalhes do produto e $categoria_para_pagina para contexto da categoria, se necessário.

// Exemplo para a URL amigável do produto:
// Define os slugs para a URL amigável, usando os valores da URL como fallback se necessário
$friendly_product_url_category_slug = ($categoria_para_pagina && !empty($categoria_para_pagina->slug)) ? $categoria_para_pagina->slug : $category_slug_url;
$friendly_product_url_product_slug = ($produto && !empty($produto->nome)) ? sanitize_title($produto->nome) : $product_slug_url;

// Constrói a URL amigável
$friendly_product_url = site_url('ecossistema-de-maquinas/' . $friendly_product_url_category_slug . '/' . $friendly_product_url_product_slug . '/');


// Links do WhatsApp e Orçamento usando a URL amigável
$mensagem_whatsapp = 'Veja este produto: ' . esc_html($produto->nome) . ' - ' . $friendly_product_url;
$whatsapp_share_url = 'https://wa.me/?text=' . urlencode($mensagem_whatsapp);
$orcamento_whatsapp_url = 'https://api.whatsapp.com/send?phone=554874003966&text=' . urlencode("Olá, vim do site, gostaria de um orçamento desta máquina: " . esc_html($produto->nome) . " (" . $friendly_product_url . ")");

// Decodifica fotos (JSON)
$fotos = [];
if (!empty($produto->fotos)) {
    $fotos = json_decode(stripslashes($produto->fotos)); //
}

// Pega o ID da categoria do produto
$categoria_id = isset($produto->categoria_id) ? intval($produto->categoria_id) : 0;

// Pega outros produtos da mesma categoria, exceto o atual
$outros_produtos = [];
if ($categoria_id > 0 && isset($produto->id)) { // Certifique-se que $categoria_id e $produto->id são válidos
    $outros_produtos = $wpdb->get_results($wpdb->prepare("
        SELECT * FROM {$wpdb->prefix}maquinas
        WHERE categoria_id = %d AND id != %d
        ORDER BY RAND()
        LIMIT 4
    ", $categoria_id, $produto->id)); //
}

?>
<div class="container p-0 m-0 titulo">
    <h2><?= esc_html($produto->nome) ?></h2>
</div>
<section class="fotos-produtos">
    <div class="container my-5">
        <div class="row">

            <div class="col-12 col-md-2 carousel-thumbs order-2 order-md-1">
                <?php if (!empty($fotos) && is_array($fotos)): ?>
                    <?php foreach ($fotos as $index => $foto_url): ?>
                        <img src="<?= esc_url(site_url(trim($foto_url))) ?>"
                            class="img-fluid thumbnail-img <?= $index === 0 ? 'active' : '' ?>"
                            data-large="<?= esc_url(site_url(trim($foto_url))) ?>"
                            alt="Miniatura <?= esc_attr($produto->nome) ?> <?= $index + 1 ?>"
                            loading="lazy"
                            style="cursor: pointer; width: 165px; object-fit: cover; margin-bottom: 5px;">
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nenhuma miniatura disponível.</p>
                <?php endif; ?>
            </div>

<div class="col-12 col-md-6 fotos-maquinas border d-flex justify-content-center align-items-center order-1 order-md-2">

    <?php
    $primeira_foto_url = !empty($fotos) && isset($fotos[0])
        ? esc_url(site_url(trim($fotos[0])))
        : esc_url(get_template_directory_uri() . '/assets/img/placeholder.jpg');

    // Prepara o título para o lightbox
    $product_title = esc_attr($produto->nome);
    $total_fotos = !empty($fotos) && is_array($fotos) ? count($fotos) : 1;
    $main_image_title = $product_title . ' (1 de ' . $total_fotos . ')';
    ?>

    <a id="mainImageLink"
       href="<?= $primeira_foto_url ?>"
       class="glightbox"
       data-gallery="galeria-produto"
       title="<?= $main_image_title ?>">
        <img id="mainImage"
             src="<?= $primeira_foto_url ?>"
             alt="Imagem principal de <?= $product_title ?>"
             class="img-fluid main-img rounded"
             style="cursor: zoom-in; max-height: 400px; object-fit: cover;">
    </a>

    <div style="display: none;">
        <?php
        // Começa o loop a partir da segunda imagem (índice 1)
        if ($total_fotos > 1) {
            for ($i = 1; $i < $total_fotos; $i++) {
                $foto_url = esc_url(site_url(trim($fotos[$i])));
                // Cria um título descritivo para cada imagem da galeria
                $gallery_item_title = $product_title . ' (' . ($i + 1) . ' de ' . $total_fotos . ')';
                echo '<a href="' . $foto_url . '" class="glightbox" data-gallery="galeria-produto" title="' . $gallery_item_title . '"></a>';
            }
        }
        ?>
    </div>
</div>

            <div class="modal fade" id="imageZoomModal" tabindex="-1" aria-labelledby="imageZoomModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageZoomModalLabel"><?= esc_html($produto->nome) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img id="modalZoomImage" src="" alt="Imagem Ampliada de <?= esc_attr($produto->nome) ?>" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4 text-center vantagens-maquinas order-3">
                <ul>
                    <?php if ($produto->foco_auto == '1'): ?><li class="icon-hover-wrapper"><i class="fa-solid fa-bullseye icon-hover"></i> Cabeça de laser com foco automático</li><?php endif; ?>
                    <?php if ($produto->controle_inteligente == '1'): ?><li class="icon-hover-wrapper"><i class="fa-solid fa-gamepad icon-hover"></i> Sistema de controle inteligente</li><?php endif; ?>
                    <?php if ($produto->cama_resistente == '1'): ?><li class="icon-hover-wrapper"><i class="fa-solid fa-chess-rook icon-hover"></i> Cama de máquina de solda com tubos de alta resistência</li><?php endif; ?>
                    <?php if ($produto->viga_aluminio == '1'): ?><li class="icon-hover-wrapper"><i class="fa-solid fa-5 icon-hover"></i> Viga de alumínio aeroespacial de quinta geração</li><?php endif; ?>
                    <?php if ($produto->velocidade_troca == '1'): ?><li class="icon-hover-wrapper"><i class="fa-solid fa-bolt icon-hover"></i> Velocidade de troca mais rápida</li><?php endif; ?>
                    <?php if ($produto->mandris_duplo == '1'): ?><li class="icon-hover-wrapper"><i class="fa-solid fa-angles-right icon-hover"></i> Mandris Duplo</li><?php endif; ?>
                    <?php if ($produto->design_tela_dupla == '1'): ?><li class="icon-hover-wrapper"><i class="fa-solid fa-tv icon-hover"></i> Design de tela dupla idependente</li><?php endif; ?>
                    <?php if ($produto->mandril_pneumatico == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-circle-notch icon-hover"></i> Mandril Pneumático de grande diâmetro</li><?php endif; ?>
                    <?php if ($produto->pequeno_ivestimento == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-piggy-bank icon-hover"></i> Pequeno investimento, grande retorno</li><?php endif; ?>
                    <?php if ($produto->design_classico == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-gem icon-hover"></i> Design clássico, compacto e prático</li><?php endif; ?>
                    <?php if ($produto->cama_soldada == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-tools icon-hover"></i> Cama Soldada pendurada lateralmente</li><?php endif; ?>
                    <?php if ($produto->corte_ultracurto == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-compress-alt icon-hover"></i> Corte de cabeçote ultracurto</li><?php endif; ?>
                    <?php if ($produto->gama_diametros == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-sliders-h icon-hover"></i> Ampla gama de diâmetros de corte de tubos</li><?php endif; ?>
                    <?php if ($produto->alta_precisao_dobra == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-bullseye icon-hover"></i> Alta precisão</li><?php endif; ?>
                    <?php if ($produto->funcoes_poderosas_dobra == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-gears icon-hover"></i> Funções poderosas</li><?php endif; ?>
                    <?php if ($produto->facil_utilizacao_dobra == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-thumbs-up icon-hover"></i> Fácil Utlização</li><?php endif; ?>
                    <?php if ($produto->laminas_guilhotina == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-scissors icon-hover"></i> Lâminas de corte afiada</li><?php endif; ?>
                    <?php if ($produto->sensores_seguranca_guilhotina == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-shield-alt icon-hover"></i> Sensor de segurança</li><?php endif; ?>
                    <?php if ($produto->design_simplificado_calandras == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-border-none icon-hover"></i> Design simplificado</li><?php endif; ?>
                    <?php if ($produto->tres_eixos_motor_calandras == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-cogs icon-hover"></i> Três eixos acionados por motor</li><?php endif; ?>
                    <?php if ($produto->motor_de_freio_calandras == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-tachometer-alt icon-hover"></i> Motor de freio de alta precisão para máquina de dobra</li><?php endif; ?>
                    <?php if ($produto->bancada_de_operacao_calandras == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-dolly icon-hover"></i> Bancada de operação móvel</li><?php endif; ?>
                    <?php if ($produto->estrutura_simetricas_calandras == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-ellipsis-h icon-hover"></i> Estrutura simétrica de três rolos</li><?php endif; ?>
                    <?php if ($produto->console_removivel_calandras == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-plug icon-hover"></i> Console removível de uso simplificado</li><?php endif; ?>
                    <?php if ($produto->rolos_calandras == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-circle-notch icon-hover"></i> Rolos endurecidos forjados por indução</li><?php endif; ?>
                    <?php if ($produto->descarregamento_calandras == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-truck-loading icon-hover"></i> Dispositivo de descarregamento</li><?php endif; ?>
                    <?php if ($produto->sistema_composto_calandras == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-circle-notch icon-hover"></i> Sistema composto por quatro rolos</li><?php endif; ?>
                    <?php if ($produto->controle_cnc_calandras == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-microchip icon-hover"></i> Sistema de controle CNC</li><?php endif; ?>
                    <?php if ($produto->balanco_hidraulico_calandras == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-balance-scale icon-hover"></i> Sistema de balanço hidráulico</li><?php endif; ?>
                    <?php if ($produto->mecanismo_limpeza_calandras == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-cogs icon-hover"></i> Mecanismo de limpeza de lâminas e ajuste rápido</li><?php endif; ?>
                    <?php if ($produto->resul_exp_eficazes_solda_laser == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-chart-line icon-hover"></i> Resultados excepecionais e eficazes</li><?php endif; ?>
                    <?php if ($produto->painel_toch_solda_laser == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-hand-pointer icon-hover"></i> Painel touch screen</li><?php endif; ?>
                    <?php if ($produto->facil_instalacao_solda_laser == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-plug icon-hover"></i> Fácil instalação</li><?php endif; ?>
                    <?php if ($produto->cabecote_solda_laser == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-lightbulb icon-hover"></i> Cabeçote de limpeza a laser avançado, leve e versátil</li><?php endif; ?>
                    <?php if ($produto->alta_precisao_rosqueadeira == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-bullseye icon-hover"></i> Alta precisão</li><?php endif; ?>
                    <?php if ($produto->memorizacao__rosqueadeira == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-database icon-hover"></i> Memorização de parâmetros de até 20 roscas</li><?php endif; ?>
                    <?php if ($produto->facil_op__rosqueadeira == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-hand-pointer icon-hover"></i> Fácil operação com interface intuitiva</li><?php endif; ?>
                    <?php if ($produto->agilidade__rosqueadeira == '1'): ?><li class="icon-hover-wrapper"><i class="fas fa-tachometer-alt icon-hover"></i> Mais agilidade no trabalho</li><?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="especificacoes-descricao-section">
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6 tabela-produtos">
                <h3>Características</h3>
                <div class="d-flex">
                    <div class="spec-title d-flex align-items-center justify-content-center">
                        ESPECIFICAÇÕES
                    </div>
                    <div class="spec-table w-100">
                        <?php if (!empty($produto->potencia)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">POTÊNCIA DO LASER</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->potencia) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->precisao_posicionamento)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">PRECISÃO DE POSICIONAMENTO</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->precisao_posicionamento) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->rep_reposicionamento)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">REP. PRECISÃO DE REPOSICIONAMENTO</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->rep_reposicionamento) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->faixa_tubo)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Medida/Peso Tubo</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->faixa_tubo) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->cabecote)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">CABEÇOTE</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->cabecote) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->fonte)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">FONTE</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->fonte) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->area_trabalho)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Área de Trabalho</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->area_trabalho) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->diametro_proc_tubo_redondo)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Diâmetro de dorte efetivo do tubo redondo</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->diametro_proc_tubo_redondo) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->diametro_proc_tubo_quadrado)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Diâmetro de dorte efetivo do tubo quadrado</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->diametro_proc_tubo_quadrado) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->velocidade_max)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Velocidade de deslocamento</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->velocidade_max) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->aceleracao_max)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Aceleracao máxima</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->aceleracao_max) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->cap_dobra)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Capacidade de Dobra</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->cap_dobra) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->comp_dobra)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Comprimento de Dobra</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->comp_dobra) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->dist_colunas_dobra)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Distância de colunas</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->dist_colunas_dobra) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->comp_garganta_dobra)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Comprimento da garganta</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->comp_garganta_dobra) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->tamanho_abertura_dobra)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Tamanho de abertura</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->tamanho_abertura_dobra) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->poder_motor_dobra)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Poder motor</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->poder_motor_dobra) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->curso_dobra)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Curso</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->curso_dobra) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->espessura_guilhotina)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Espessura</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->espessura_guilhotina) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->largura_guilhotina)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Largura</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->largura_guilhotina) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->cortes_minutos_guilhotina)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Cortes por minuto</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->cortes_minutos_guilhotina) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->bitola_traseira_guilhotina)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Alcance de Bitola Traseira</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->bitola_traseira_guilhotina) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->angulo_corte_guilhotina)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Ângulo de corte</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->angulo_corte_guilhotina) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->poder_motos_guilhotina)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Poder motor</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->poder_motor_dobra) ?></div>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($produto->dimensoes_guilhotina)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Dimensões</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->dimensoes_guilhotina) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->espessura_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Expessura</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->espessura_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->largura_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Largura</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->largura_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->limite_de_rendimento_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Limite de rendimento</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->limite_de_rendimento_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->diametro_min_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Diâmetro mínimo de bobina</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->diametro_min_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->motor_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Motor</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->motor_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->peso_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Peso</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->peso_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->espessura_max_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Espessura máxima de dobra</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->espessura_max_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->espessura_pre_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Espessura pré-dobra</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->espessura_pre_calandras) ?></div>
                            </div>
                        <?php endif; ?>



                        <?php if (!empty($produto->comprimento_trabalho_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Comprimento de trabalho dos rolos</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->comprimento_trabalho_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->limite_rendimentos_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Limite de rendimento</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->limite_rendimentos_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->diametro_rolo_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Diâmetros dos rolos</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->diametro_rolo_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->quadro_eletrico_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Quadro elétrico</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->quadro_eletrico_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->peso_cnc_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Peso</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->peso_cnc_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->max_modulos_selecao_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Máximo de módulos de seção</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->max_modulos_selecao_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->vel_rolamento_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Velocidade de Rolamento</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->vel_rolamento_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->forca_rendimento_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Força de Rendimento (mpa)</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->forca_rendimento_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->repetibilidade_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Repetibilidade</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->repetibilidade_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->precisao_movimento_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Precisão de Movimento</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->precisao_movimento_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->cabecote_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Cabeçote</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->cabecote_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->fonte_calandras)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Fonte</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->fonte_calandras) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->potencia_solda_laser)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Potência opcional</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->potencia_solda_laser) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->tamanho_solda_laser)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Tamanho</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->tamanho_solda_laser) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->peso_solda_laser)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Peso</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->peso_solda_laser) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->modo_op_solda_laser)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Modo operativo</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->modo_op_solda_laser) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->ambito_ap_solda_laser)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Âmbito de aplicação</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->ambito_ap_solda_laser) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->logitude_fibra_solda_laser)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Longitude de fibra</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->logitude_fibra_solda_laser) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->met_resfriamento_solda_laser)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Método de resfriamento</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->met_resfriamento_solda_laser) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->ambito_aplicacao_solda_laser)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Âmbito de aplicação</div>Descrição
                                <div class="spec-right spec-value"><?= esc_html($produto->ambito_aplicacao_solda_laser) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->potencia_tres_um)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Potência</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->potencia_tres_um) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->potencia_maquina_tres_um)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Potência Máquina</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->potencia_maquina_tres_um) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->comp_onda_laser_tres_um)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Comprimento de onda do laser</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->comp_onda_laser_tres_um) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->est_potencia_tres_um)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Estabilidade da potência da maquina</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->est_potencia_tres_um) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->requis_solda_tres_um)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Requisitos da </div>
                                <div class="spec-right spec-value"><?= esc_html($produto->requis_solda_tres_um) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->tam_maquina_tres_um)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Tamanho da máquina </div>
                                <div class="spec-right spec-value"><?= esc_html($produto->tam_maquina_tres_um) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->ambito_aplicacao_tres_um)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Âmbito de aplicação </div>
                                <div class="spec-right spec-value"><?= esc_html($produto->ambito_aplicacao_tres_um) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->potencia_limpeza)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Potências </div>
                                <div class="spec-right spec-value"><?= esc_html($produto->potencia_limpeza) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->medida_peso_limpeza)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Medida/Peso </div>
                                <div class="spec-right spec-value"><?= esc_html($produto->medida_peso_limpeza) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->onda_laser_limpeza)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Onda do laser </div>
                                <div class="spec-right spec-value"><?= esc_html($produto->onda_laser_limpeza) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->dist_focal_limepeza)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Distância focal colinada </div>
                                <div class="spec-right spec-value"><?= esc_html($produto->dist_focal_limepeza) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->dist_focal_foco_limpeza)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Distância focal do foco </div>
                                <div class="spec-right spec-value"><?= esc_html($produto->dist_focal_foco_limpeza) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->gas_de_uso_limpeza)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Gás de uso </div>
                                <div class="spec-right spec-value"><?= esc_html($produto->gas_de_uso_limpeza) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->compr_tocha_limpeza)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Comprimento tocha </div>
                                <div class="spec-right spec-value"><?= esc_html($produto->compr_tocha_limpeza) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->fonte_limpeza)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Fonte </div>
                                <div class="spec-right spec-value"><?= esc_html($produto->fonte_limpeza) ?></div>
                            </div>
                        <?php endif; ?>




                        <?php if (!empty($produto->cap_nominal_rosqueadeira)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Capacidade nominal </div>
                                <div class="spec-right spec-value"><?= esc_html($produto->cap_nominal_rosqueadeira) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->raio_trab_rosqueadeira)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Raio de trabalho horizontal/vertical</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->raio_trab_rosqueadeira) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->rot_max_rosqueadeira)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Rotação máxima</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->rot_max_rosqueadeira) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->tipo_pincas_rosqueadeira)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Tipo de pinças</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->tipo_pincas_rosqueadeira) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->ctrl_vel_rosqueadeira)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Controle de velocidade</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->ctrl_vel_rosqueadeira) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->area_art_rosqueadeira)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Área de articulação</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->area_art_rosqueadeira) ?></div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($produto->ang_rosqueadeira)): ?>
                            <div class="table-row">
                                <div class="spec-left spec-label">Ângulos de rosqueamento</div>
                                <div class="spec-right spec-value"><?= esc_html($produto->ang_rosqueadeira) ?></div>
                            </div>
                        <?php endif; ?>



                    </div>


                </div>

                <?php
                $link = site_url('ecossistema-de-maquinas/?produto=' . $produto->id);
                $mensagem = 'Veja este produto: ' . $link;
                $whatsapp_url = 'https://wa.me/?text=' . urlencode($mensagem);
                $orcamento_url = 'https://api.whatsapp.com/send?phone=554874003966&text=' . urlencode("Olá, vim do site, gostaria de um orçamento dessa máquina: $link");
                ?>
                <div class="botoes_produtos col-md-12 mt-4">
                    <?php if (!empty($produto->orcamento)): ?>
                        <a href="<?= $orcamento_url ?>" target="_blank" class="botao-produtos">
                            <i class="bi bi-whatsapp me-2"></i></i> Fazer um orçamento
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($produto->orcamento_dobradeira)): ?>
                        <a href="<?= $orcamento_url ?>" target="_blank" class="botao-produtos">
                            <i class="bi bi-whatsapp me-2"></i></i> Fazer um orçamento
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($produto->orcamento_calandra)): ?>
                        <a href="<?= $orcamento_url ?>" target="_blank" class="botao-produtos">
                            <i class="bi bi-whatsapp me-2"></i></i> Fazer um orçamento
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($produto->orcamento_solda_laser)): ?>
                        <a href="<?= $orcamento_url ?>" target="_blank" class="botao-produtos">
                            <i class="bi bi-whatsapp me-2"></i></i> Fazer um orçamento
                        </a>
                    <?php endif; ?>

                    <?php if (!empty($produto->orcamento_rosqueadeira)): ?>
                        <a href="<?= $orcamento_url ?>" target="_blank" class="botao-produtos">
                            <i class="bi bi-whatsapp me-2"></i></i> Fazer um orçamento
                        </a>
                    <?php endif; ?>

                </div>
            </div>

            <div class="col-md-6 descricao-produto">


                <?php
                $descricoes = [];

                $mapa_campos = [
                    'caracteristicas' => 'Características Gerais',
                    'caracteristicas_dobra' => 'Características da Dobradeira',
                    'caracteristicas_calandras' => 'Características da Calandra',
                    'caracteristicas_solda_laser' => 'Características da Solda a Laser',
                    'caracteristicas_rosquadeira' => 'Características da Rosqueadeira',
                    'caracteristicas_tres_um' => 'Características da Solda 3 em 1',
                    'caracteristicas_limpeza_laser' => 'Características da Limpeza a Laser'
                ];

                foreach ($mapa_campos as $campo => $titulo) {
                    if (isset($produto_para_pagina->$campo) && !empty($produto_para_pagina->$campo)) {
                        $descricao_formatada = nl2br(wp_kses_post($produto_para_pagina->$campo));
                        $descricoes[] = "<h3>{$titulo}</h3><p>{$descricao_formatada}</p>";
                    }
                }

                if (!empty($descricoes)) {
                    echo implode('<hr/>', $descricoes);
                } else {
                    echo '<p>Nenhuma descrição detalhada disponível para este produto.</p>';
                }
                ?>




            </div>
        </div>
    </div>
</section>

<?php if (!empty($outros_produtos)): ?>
    <section class="produtos-relacionados my-5">
        <div class="container">
            <h3 class="mb-4">Veja também</h3>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <?php foreach ($outros_produtos as $outro_produto): ?>
                    <div class="col">
                        <div class="card h-100 produto-card position-relative overflow-hidden">
                            <?php
                            $img_rel_url = '';
                            if (!empty($outro_produto->fotos)) {
                                $imgs_rel_array = json_decode(stripslashes($outro_produto->fotos));
                                if (is_array($imgs_rel_array) && isset($imgs_rel_array[0])) {
                                    // Adiciona site_url apenas se não for uma URL completa
                                    $img_path_or_url = trim($imgs_rel_array[0]);
                                    if (strpos($img_path_or_url, 'http://') !== 0 && strpos($img_path_or_url, 'https://') !== 0) {
                                        $img_rel_url = esc_url(site_url($img_path_or_url));
                                    } else {
                                        $img_rel_url = esc_url($img_path_or_url);
                                    }
                                }
                            }
                            if (empty($img_rel_url)) {
                                $img_rel_url = esc_url(get_template_directory_uri() . '/assets/img/placeholder.jpg');
                            }

                            // Busca a categoria do produto relacionado para montar o link corretamente
                            $slug_categoria_relacionado = 'categoria-desconhecida'; // Padrão
                            if (isset($outro_produto->categoria_id)) {
                                $cat_rel_obj = $wpdb->get_row($wpdb->prepare("SELECT nome FROM {$wpdb->prefix}gp_categorias WHERE id = %d", $outro_produto->categoria_id));
                                if ($cat_rel_obj) {
                                    $slug_categoria_relacionado = sanitize_title($cat_rel_obj->nome);
                                }
                            }
                            $outro_produto_slug = sanitize_title($outro_produto->nome);
                            $link_rel_produto = site_url('ecossistema-de-maquinas/' . $slug_categoria_relacionado . '/' . $outro_produto_slug . '/');

                            $mensagem_rel_whatsapp = 'Veja este produto: ' . esc_html($outro_produto->nome) . ' - ' . $link_rel_produto;
                            $whatsapp_url_rel_produto = 'https://wa.me/?text=' . urlencode($mensagem_rel_whatsapp);
                            $orcamento_url_rel_produto = 'https://api.whatsapp.com/send?phone=554874003966&text=' . urlencode("Olá, vim do site, gostaria de um orçamento desta máquina: " . esc_html($outro_produto->nome) . " (" . $link_rel_produto . ")");
                            ?>
                            <div class="produto-imagem-wrapper">
                                <img src="<?= $img_rel_url ?>" class="produto-imagem" alt="<?= esc_attr($outro_produto->nome) ?>">
                                <div class="produto-overlay">
                                    <div class="overlay-icons">
                                        <a href="<?= esc_url($whatsapp_url_rel_produto) ?>" target="_blank" class="icon whatsapp" title="Compartilhar no WhatsApp">
                                            <i class="fab fa-whatsapp"></i>
                                        </a>
                                        <a href="<?= esc_url($orcamento_url_rel_produto) ?>" target="_blank" class="icon orcamento" title="Solicitar Orçamento">
                                            <i class="fas fa-hand-holding-usd"></i>
                                        </a>
                                        <a href="<?= esc_url($link_rel_produto) ?>" class="icon visualizar" title="Visualizar Produto">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body text-center d-flex justify-content-center align-items-end">
                                <h5 class="card-title"><?= esc_html($outro_produto->nome) ?></h5>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Garante que o GLightbox está disponível antes de executar o código
    if (typeof GLightbox !== 'function') {
        console.error('GLightbox não foi carregado.');
        return;
    }

    const mainImage = document.getElementById('mainImage');
    const mainImageLink = document.getElementById('mainImageLink');
    const thumbnails = document.querySelectorAll('.thumbnail-img');

    // 1. Coleta todas as imagens e títulos para a galeria a partir dos links existentes
    const galleryLinks = document.querySelectorAll('a[data-gallery="galeria-produto"]');
    const galleryElements = Array.from(galleryLinks).map(link => ({
        'href': link.href,
        'type': 'image',
        'title': link.title || '' // Usa o atributo 'title' de cada link
    }));

    // 2. Inicializa o GLightbox com os elementos coletados, mas sem abrir
    const productLightbox = GLightbox({
        elements: galleryElements,
        loop: true, // Permite navegar em loop pela galeria
        touchNavigation: true
    });

    // 3. Adiciona o evento de clique nas miniaturas para trocar a imagem principal
    if (mainImage && thumbnails.length > 0) {
        thumbnails.forEach(thumb => {
            thumb.addEventListener('click', function() {
                const newImageSrc = this.getAttribute('data-large');

                // Atualiza a imagem principal que o usuário vê
                mainImage.src = newImageSrc;

                // Atualiza o link da imagem principal (para consistência)
                mainImageLink.href = newImageSrc;

                // Marca a miniatura ativa
                document.querySelector('.thumbnail-img.active')?.classList.remove('active');
                this.classList.add('active');
            });
        });
    }

    // 4. Adiciona o evento de clique na imagem principal para abrir o lightbox
    if (mainImageLink) {
        mainImageLink.addEventListener('click', function(e) {
            e.preventDefault(); // Impede que o link seja seguido

            const currentImageSrc = mainImage.src;

            // Encontra o índice da imagem atual na nossa lista da galeria
            const startIndex = galleryElements.findIndex(elem => elem.href === currentImageSrc);

            // Comanda o lightbox para abrir na imagem correta
            productLightbox.openAt(startIndex >= 0 ? startIndex : 0);
        });
    }
});
</script>
<?php get_footer(); ?>