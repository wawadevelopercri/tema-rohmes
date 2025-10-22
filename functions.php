<?php
add_theme_support('post-thumbnails');

// =========================================================================
//  1. CONFIGURAÇÕES E INICIALIZAÇÃO DO TEMA
// =========================================================================
function rohmes_setup() {
    require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';
    add_theme_support('custom-logo');
    add_theme_support('menus');
    register_nav_menu('menu-principal', 'Menu Principal');
}
add_action('after_setup_theme', 'rohmes_setup');

// =========================================================================
//  2. OTIMIZAÇÕES DE PERFORMANCE
// =========================================================================
function rohmes_start_session_if_not_started() {
    if (is_page('contato') && !session_id()) {
        session_start();
    }
}
add_action('init', 'rohmes_start_session_if_not_started');

function rohmes_optimize_asset_loading($tag, $handle, $src) {
    if (is_admin()) {
        return $tag;
    }
    $critical_js = ['jquery-core', 'jquery-migrate'];
    if (pathinfo($src, PATHINFO_EXTENSION) === 'js' && !in_array($handle, $critical_js)) {
        if (strpos($tag, ' defer') === false && strpos($tag, ' async') === false) {
            $tag = str_replace(' src', ' defer src', $tag);
        }
    }
    $non_critical_css_handles = [
        'bootstrap-css', 'bootstrap-icons', 'font-awesome', 'swiper-css',
        'glightbox-css', 'aos-css', 'wp-block-library', 'css-pos-venda',
        'css-busca', 'css-produtos', 'css-pecas'
    ];
    if (in_array($handle, $non_critical_css_handles)) {
        $preload_tag = str_replace(
            "rel='stylesheet'",
            "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"",
            $tag
        );
        return $preload_tag . "<noscript>$tag</noscript>";
    }
    if ($handle === 'rohmes-style') {
        $tag = str_replace(
            "rel='stylesheet'",
            "rel='preload' as='style' onload=\"this.onload=null;this.rel='stylesheet'\"",
            $tag
        );
        $tag .= "<noscript><link rel='stylesheet' href='" . esc_url(get_stylesheet_uri()) . "'></noscript>";
    }
    return $tag;
}
add_filter('script_loader_tag', 'rohmes_optimize_asset_loading', 999, 3);
add_filter('style_loader_tag', 'rohmes_optimize_asset_loading', 999, 3);

function rohmes_add_preconnect_hints() {
    echo '<link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>';
    echo '<link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    echo '<link rel="dns-prefetch" href="https://fonts.googleapis.com">';
    echo '<link rel="dns-prefetch" href="https://fonts.gstatic.com">';
    echo "<link href='https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap' rel='stylesheet' media='print' onload=\"this.media='all'\">";
    echo "<noscript><link href='https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap' rel='stylesheet'></noscript>";
}
add_action('wp_head', 'rohmes_add_preconnect_hints', 2);

function rohmes_remove_jquery_migrate($scripts) {
    if (!is_admin() && isset($scripts->registered['jquery'])) {
        $script = $scripts->registered['jquery'];
        if ($script->deps) {
            $script->deps = array_diff($script->deps, ['jquery-migrate']);
        }
    }
}
add_action('wp_default_scripts', 'rohmes_remove_jquery_migrate');

function rohmes_optimize_lcp_image($content) {
    $lcp_image_class = 'imagem-banner-fluido';
    if (is_front_page() && strpos($content, $lcp_image_class) !== false) {
        $content = str_replace('<img ', '<img fetchpriority="high" ', $content);
        $content = str_replace(' loading="lazy"', '', $content);
        if (strpos($content, 'data-src=') !== false) {
           $content = preg_replace('/<img(.*?)(data-src=[\'"](.*?)[\'"])(.*?)>/i', '<img$1src="$3"$4>', $content);
        }
    }
    return $content;
}
add_filter('the_content', 'rohmes_optimize_lcp_image', 99);
add_filter('post_thumbnail_html', 'rohmes_optimize_lcp_image', 99);

// ==========================================================
//  3. ENFILEIRAMENTO DE SCRIPTS E ESTILOS (CORRIGIDO E UNIFICADO)
// ==========================================================
function rohmes_enqueue_assets() {
    $style_version = filemtime(get_stylesheet_directory() . '/style.css');
    $theme_version = wp_get_theme()->get('Version');

    // CSS principal
    wp_enqueue_style('rohmes-style', get_stylesheet_uri(), array(), $style_version);

    // CSS e JS globais
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), '5.3.3');
    wp_enqueue_script('bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array('jquery'), '5.3.3', true);
    wp_enqueue_style('rohmes-fonts-poppins', 'https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap', array(), null);
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css', array(), '1.11.3');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');

    // Scripts personalizados
    wp_enqueue_script('rohmes-custom-script', get_template_directory_uri() . '/js/custom-script.js', array('jquery'), filemtime(get_template_directory() . '/js/custom-script.js'), true);
    wp_localize_script('rohmes-custom-script', 'rohmes_ajax', array('ajax_url' => admin_url('admin-ajax.php')));
    
    // ** CORREÇÃO: Carrega o script do formulário aqui **
    wp_enqueue_script('rohmes-form-cotacao', get_template_directory_uri() . '/js/form-cotacao.js', array(), filemtime(get_template_directory() . '/js/form-cotacao.js'), true);

    // Assets Condicionais
    if (!is_search() && !is_page('contato')) {
        wp_enqueue_style('aos-css', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css', array(), '2.3.4');
        wp_enqueue_script('aos-js', 'https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js', array(), '2.3.4', true);
    }
    
    if (is_front_page() || is_page('pos-vendas-e-suporte') || is_page_template('pos-vendas.php') || is_page('sobre-nos')) {
        wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css', array(), '11');
        wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), '11', true);
    }

    if (is_singular() || is_page('pos-vendas-e-suporte') || is_page_template('pos-vendas.php')) {
        wp_enqueue_style('glightbox-css', 'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css', array(), '3.2.0');
        wp_enqueue_script('glightbox-js', 'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js', array(), '3.2.0', true);
    }

    if (is_page('contato')) {
        wp_enqueue_script('imask-js', 'https://unpkg.com/imask', array(), null, true);
        wp_enqueue_script('form-contato-js', get_template_directory_uri() . '/js/form-contato.js', array('jquery', 'imask-js'), '1.2', true);
        wp_localize_script('form-contato-js', 'ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));
        wp_enqueue_style('css-contato', get_template_directory_uri() . '/css/contato.css', array(), $style_version);
    }
    
    if (is_page('pos-vendas-e-suporte') || is_page_template('pos-vendas.php')) {
        wp_enqueue_style('css-pos-venda', get_template_directory_uri() . '/css/pos-vendas.css', array(), $style_version);
        wp_enqueue_script('masonry-js', 'https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js', array(), '4.2.2', true);
        wp_add_inline_script('masonry-js', "window.addEventListener('load',function(){var g=document.querySelector('.masonry-grid');if(g){new Masonry(g,{itemSelector:'.masonry-item',percentPosition:true});}});");
        wp_enqueue_script('rohmes-pos-venda', get_template_directory_uri() . '/js/pos-venda.js', array('jquery', 'swiper-js'), $theme_version, true);
    }

    if (is_front_page()) {
        $index_css_path = get_template_directory() . '/css/index.css';
        if (file_exists($index_css_path)) {
            wp_enqueue_style('css-index', get_template_directory_uri() . '/css/index.css', array(), filemtime($index_css_path));
        }
    }

    if (is_search()) {
        wp_enqueue_style('css-busca', get_template_directory_uri() . '/css/page-busca.css', array(), $style_version);
    }

    if (is_tax('categoria_maquina') || is_page('maquinas')) {
        $categorias_css_path = get_template_directory() . '/css/categorias.css';
        if (file_exists($categorias_css_path)) {
            wp_enqueue_style('css-categorias', get_template_directory_uri() . '/css/categorias.css', array(), filemtime($categorias_css_path));
        }
    }

    if (is_singular('maquina')) {
        $single_maquina_css_path = get_template_directory() . '/css/single-maquina.css';
        if (file_exists($single_maquina_css_path)) {
            wp_enqueue_style('css-single-maquina', get_template_directory_uri() . '/css/single-maquina.css', array(), filemtime($single_maquina_css_path));
        }
    }

    if (is_page('pecas-e-consumiveis')) {
        wp_enqueue_style('css-pecas', get_template_directory_uri() . '/css/pecas-e-consumiveis.css', array(), $style_version);
    }

    if (is_page_template('page-agradecimento.php')) {
        $agradecimento_css_path = get_template_directory() . '/css/agradecimento.css';
        if (file_exists($agradecimento_css_path)) {
            wp_enqueue_style('css-agradecimento', get_template_directory_uri() . '/css/agradecimento.css', array(), filemtime($agradecimento_css_path));
        }
    }

    if (is_page('trabalhe-conosco')) {
        wp_enqueue_style('css-vagas', get_template_directory_uri() . '/css/vagas.css', array(), $style_version);
    }

    if (is_404()) {
        wp_enqueue_style('css-404', get_template_directory_uri() . '/css/404.css', array(), $style_version);
    }

    if (is_page('sobre-nos')) {
        wp_enqueue_style('css-sobre', get_template_directory_uri() . '/css/sobre-nos.css', array(), $style_version);
        $sobre_js_path = get_template_directory() . '/js/sobre-nos.js';
        if (file_exists($sobre_js_path)) {
            wp_enqueue_script('js-sobre', get_template_directory_uri() . '/js/sobre-nos.js', array('swiper-js'), filemtime($sobre_js_path), true);
        }
    }

    $breadcrumb_css_path = get_template_directory() . '/css/breadcrumb.css';
    if (file_exists($breadcrumb_css_path)) {
        wp_enqueue_style('css-breadcrumb', get_template_directory_uri() . '/css/breadcrumb.css', array(), filemtime($breadcrumb_css_path));
    }

    if ( is_singular('maquina') ) {
        $single_maquina_js_path = get_template_directory() . '/js/single-maquina.js';
        if ( file_exists( $single_maquina_js_path ) ) {
            wp_enqueue_script(
                'rohmes-single-maquina-js',
                get_template_directory_uri() . '/js/single-maquina.js',
                array(),
                filemtime( $single_maquina_js_path ),
                true
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'rohmes_enqueue_assets');


// =========================================================================
//  4. AJAX E PROCESSAMENTO DE FORMULÁRIOS
// =========================================================================

// --- FUNÇÃO ANTIGA DE ANTI-ROBÔ (MANTIDA CASO OUTRO FORMULÁRIO USE) ---
function rohmes_get_anti_robo_question() {
    if(!session_id()) { session_start(); }
    $num1 = rand(1, 10);
    $num2 = rand(1, 10);
    $_SESSION['soma_correta'] = $num1 + $num2;
    wp_send_json_success(['num1' => $num1, 'num2' => $num2]);
}
add_action('wp_ajax_get_anti_robo_question', 'rohmes_get_anti_robo_question');
add_action('wp_ajax_nopriv_get_anti_robo_question', 'rohmes_get_anti_robo_question');


// --- NOVA FUNÇÃO PARA PROCESSAR O FORMULÁRIO DE CONTATO (contato.php) ---
function rohmes_process_contact_form() {
    // ** PASSO 1: Verificação do reCAPTCHA **
    $recaptcha_secret = 'COLE_AQUI_SUA_CHAVE_SECRETA_RECAPTCHA'; // ⚠️ substitua pela sua
    $recaptcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';

    if (empty($recaptcha_response)) {
        wp_send_json_error(['message' => 'Por favor, marque a caixa "Não sou um robô".']);
        wp_die();
    }

    $response = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
        'body' => [
            'secret'   => $recaptcha_secret,
            'response' => $recaptcha_response,
        ],
    ]);

    $result = json_decode(wp_remote_retrieve_body($response), true);
    if (empty($result['success'])) {
        wp_send_json_error(['message' => 'Falha na verificação do reCAPTCHA.']);
        wp_die();
    }

    // ** PASSO 2: Sanitização dos dados **
    $nome     = sanitize_text_field($_POST['nome'] ?? '');
    $empresa  = sanitize_text_field($_POST['empresa'] ?? '');
    $whatsapp = sanitize_text_field($_POST['whatsapp'] ?? '');
    $email    = sanitize_email($_POST['email'] ?? '');
    $motivo   = sanitize_textarea_field($_POST['motivo'] ?? '');

    if (empty($nome) || empty($empresa) || empty($whatsapp) || !is_email($email) || empty($motivo)) {
        wp_send_json_error(['message' => 'Por favor, preencha todos os campos corretamente.']);
        wp_die();
    }

    // ** PASSO 3: Envio ao Pluga Webhook **
    $pluga_webhook_url = 'https://hooks.zapier.com/hooks/catch/18740176/urg0s7c/'; // ⚠️ substitua

    $payload = [
        'nome'            => $nome,
        'empresa'         => $empresa,
        'whatsapp'        => $whatsapp,
        'email'           => $email,
        'motivo_contato'  => $motivo,
        'origem'          => 'Formulário de Contato Site'
    ];

    $response = wp_remote_post($pluga_webhook_url, [
        'headers' => ['Content-Type' => 'application/json; charset=utf-8'],
        'body'    => json_encode($payload),
        'timeout' => 30,
    ]);

    // ** PASSO 4: Tratamento de erros e logs **
    if (is_wp_error($response)) {
        error_log('❌ Erro ao enviar para Pluga: ' . $response->get_error_message());
        wp_send_json_error(['message' => 'Erro ao conectar com o servidor Pluga.']);
        wp_die();
    }

    $status = wp_remote_retrieve_response_code($response);
    $body   = wp_remote_retrieve_body($response);

    if ($status !== 200) {
        error_log("❌ Erro no Webhook Pluga (HTTP $status): $body");
        wp_send_json_error(['message' => 'Falha ao enviar para o Pluga (erro ' . $status . ').']);
        wp_die();
    }

    error_log("✅ Envio bem-sucedido para Pluga: $body");

    // ** PASSO 5: Resposta de sucesso **
    wp_send_json_success(['message' => 'Mensagem enviada com sucesso!']);
}
add_action('wp_ajax_process_contact_form', 'rohmes_process_contact_form');
add_action('wp_ajax_nopriv_process_contact_form', 'rohmes_process_contact_form');


// =========================================================================
//  5. FUNÇÕES AUXILIARES E DO PAINEL ADMIN
// =========================================================================
function rohmes_admin_assets() {
    wp_enqueue_style('rohmes-admin-css', get_template_directory_uri() . '/admin-style.css', array(), '1.0');
}
add_action('admin_enqueue_scripts', 'rohmes_admin_assets');

function remover_block_library_css() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style');
}
add_action('wp_enqueue_scripts', 'remover_block_library_css', 100);

// =========================================================================
//  6. AJAX - BUSCA POR MÁQUINAS (SUGESTÃO)
// =========================================================================
function rohmes_ajax_busca_maquinas_sugestao() {
    $termo = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
    $resultados = [];
    if ($termo && strlen($termo) > 1) {
        $query = new WP_Query([
            'post_type'      => 'maquina',
            'posts_per_page' => 8,
            's'              => $termo,
            'orderby'        => 'title',
            'order'          => 'ASC',
        ]);
        foreach ($query->posts as $post) {
            $resultados[] = [
                'nome'  => get_the_title($post->ID),
                'link'  => get_permalink($post->ID),
                'thumb' => get_the_post_thumbnail_url($post->ID, 'thumbnail') ?: get_template_directory_uri() . '/assets/img/placeholder.jpg',
            ];
        }
    }
    wp_send_json($resultados);
}
add_action('wp_ajax_busca_maquinas_sugestao', 'rohmes_ajax_busca_maquinas_sugestao');
add_action('wp_ajax_nopriv_busca_maquinas_sugestao', 'rohmes_ajax_busca_maquinas_sugestao');

// =========================================================================
//  7. REGISTRO DE POST TYPES E TAXONOMIAS
// =========================================================================
function rohmes_registrar_post_type_e_taxonomia() {
    $args_maquina = array(
        'labels'             => array(
            'name'          => 'Máquinas',
            'singular_name' => 'Máquina'
        ),
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'maquina'),
        'supports'           => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'menu_icon'          => 'dashicons-admin-settings',
    );
    register_post_type('maquina', $args_maquina);

    $args_categoria = array(
        'labels'            => array(
            'name'              => 'Categorias de Máquinas',
            'singular_name'     => 'Categoria de Máquina',
        ),
        'public'            => true,
        'hierarchical'      => true,
        'show_admin_column' => true,
        'rewrite'           => array('slug' => 'maquinas'),
    );
    register_taxonomy('categoria_maquina', 'maquina', $args_categoria);
}
add_action('init', 'rohmes_registrar_post_type_e_taxonomia');

function rohmes_modal_rewrite_rule() {
    add_rewrite_rule('^forms-geral/?$', 'index.php', 'top');
}
add_action('init', 'rohmes_modal_rewrite_rule');

// =========================================================================
//  8. AJAX - PROCESSAMENTO DO FORMULÁRIO DE COTAÇÃO (VERSÃO SEM EMAIL)
// =========================================================================
function rohmes_enviar_cotacao_ajax() {
    error_log('INICIO AJAX CORTE LASER');

    if ( empty($_POST['nome']) || empty($_POST['email']) ) {
        wp_send_json_error('Dados do formulário ausentes.');
        wp_die();
    }
    wp_send_json_success('Submissão recebida. Redirecionando...');
    wp_die();
}
add_action('wp_ajax_enviar_cotacao_ajax', 'rohmes_enviar_cotacao_ajax');
add_action('wp_ajax_nopriv_enviar_cotacao_ajax', 'rohmes_enviar_cotacao_ajax');

function rohmesenviarcortelaserajax() {
    if ( empty($_POST['nome']) || empty($_POST['email']) ) {
        wp_send_json_error('Dados do formulário ausentes.');
        wp_die();
    }

    $dados = array(
        'maquina_nome'  => sanitize_text_field($_POST['maquina_nome'] ?? ''),  // CORRIGIDO
        'maquina_link'  => esc_url_raw($_POST['maquina_link'] ?? ''),         // CORRIGIDO
        'empresa'   => sanitize_text_field($_POST['empresa'] ?? ''),
        'nome'       => sanitize_text_field($_POST['nome'] ?? ''),
        'telefone'      => sanitize_text_field($_POST['telefone'] ?? ''),
        'email'         => sanitize_email($_POST['email'] ?? ''),
        'cnpj'          => sanitize_text_field($_POST['cnpj'] ?? ''),
        'material'      => sanitize_text_field($_POST['material'] ?? ''),
        'investimento'  => sanitize_text_field($_POST['investimento'] ?? ''),
        'origem'        => 'Formulário Corte a Laser (Site)'
    );
    error_log('Dados enviados ao Pluga: ' . print_r($dados,true));
    
$plugawebhookurl = 'https://hooks.zapier.com/hooks/catch/18740176/urq9dvs'; // Use sua URL real do Zapier

$response = wp_remote_post($plugawebhookurl, array(
    'headers' => array('Content-Type' => 'application/json; charset=utf-8'),
    'body'    => json_encode($dados),
    'timeout' => 30,
));


    if ( is_wp_error( $response ) ) {
        error_log( 'Erro ao enviar para Pluga: ' . $response->get_error_message() );
        wp_send_json_error('Erro ao conectar com o servidor Pluga.');
        wp_die();
    }

    $status_code = wp_remote_retrieve_response_code( $response );
    $body = wp_remote_retrieve_body( $response );

    if ( $status_code != 200 ) {
        error_log( 'Erro no Webhook do Pluga. Status ' . $status_code . ' - Resposta: ' . $body );
        wp_send_json_error('Falha ao enviar para o Pluga. Código: ' . $status_code);
        wp_die();
    }

    error_log( 'Envio bem-sucedido para Pluga: ' . $body );
    wp_send_json_success('Formulário enviado com sucesso!');
    wp_die();
}


// =========================================================================
//  10. AJAX - PROCESSAMENTO DO FORMULÁRIO DE DOBRADEIRA
// =========================================================================
function rohmes_enviar_dobradeira_ajax() {
    if ( empty($_POST['nome']) || empty($_POST['email']) ) {
        wp_send_json_error('Dados do formulário ausentes.');
        wp_die();
    }
    wp_send_json_success('Submissão recebida. Redirecionando...');
    wp_die();
}
add_action('wp_ajax_enviarcortelaserajax', 'rohmesenviarcortelaserajax');
add_action('wp_ajax_nopriv_enviarcortelaserajax', 'rohmesenviarcortelaserajax');


// =========================================================================
//  11. AJAX - PROCESSAMENTO DO FORMULÁRIO DE SOLDA A LASER
// =========================================================================
function rohmes_enviar_solda_laser_ajax() {
    if ( empty($_POST['nome']) || empty($_POST['email']) ) {
        wp_send_json_error('Dados do formulário ausentes.');
        wp_die();
    }
    wp_send_json_success('Submissão recebida. Redirecionando...');
    wp_die();
}
add_action('wp_ajax_enviar_solda_laser_ajax', 'rohmes_enviar_solda_laser_ajax');
add_action('wp_ajax_nopriv_enviar_solda_laser_ajax', 'rohmes_enviar_solda_laser_ajax');
?>