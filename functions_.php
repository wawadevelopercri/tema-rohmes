<?php
// Inclui a classe WP_Bootstrap_Navwalker
require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';

// Carrega estilos do tema
function meu_tema_enqueue_styles() {
    wp_enqueue_style('meu-tema-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'meu_tema_enqueue_styles');

// Suporte à logo personalizada
function meu_tema_setup_2() {
    add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'meu_tema_setup_2');

// Suporte a menus
function meu_tema_setup() {
    add_theme_support('menus');
}
add_action('after_setup_theme', 'meu_tema_setup');

// Registrar menu
function meu_tema_menus() {
    register_nav_menu('menu-principal', 'Menu Principal');
}
add_action('init', 'meu_tema_menus');

// Scripts do tema (menu.js)
function tema_enqueue_scripts() {
    if (!is_admin()) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('meu-script', get_template_directory_uri() . '/js/menu.js', array('jquery'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'tema_enqueue_scripts');

// Carregar Select2 (somente no frontend)
function meu_plugin_carregar_select2() {
    if (!is_admin()) {
        wp_enqueue_style('select2-css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css');
        wp_enqueue_script('select2-js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array('jquery'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'meu_plugin_carregar_select2');

// Carregar GLightbox (somente no frontend)
function adicionar_glightbox_scripts() {
    if (!is_admin()) {
        wp_enqueue_style('glightbox-css', 'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css', array(), null);
        wp_enqueue_script('glightbox-js', 'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js', array(), null, true);

        // Inicializa o GLightbox somente no frontend
        wp_add_inline_script('glightbox-js', "
            document.addEventListener('DOMContentLoaded', function() {
                const lightbox = GLightbox({
                    selector: '.glightbox'
                });
            });
        ");
    }
}
add_action('wp_enqueue_scripts', 'adicionar_glightbox_scripts');

// Carregar Carrossel Vertical (somente no frontend)
function carrosel_vertical() {
    if (!is_admin()) {
        wp_enqueue_script('carrosel-vertical', get_template_directory_uri() . '/js/carrosel-vertical.js', array('jquery'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'carrosel_vertical');

// CSS e JS do Admin
function meu_tema_admin_scripts() {
    wp_enqueue_style( 'meu-admin-css', get_template_directory_uri() . '/admin-style.css', array(), '1.0' );

    $screen = get_current_screen();
    if ($screen->post_type === 'maquinas') {
        wp_enqueue_script( 'upload-js', get_template_directory_uri() . '/js/uploads.js', array('jquery', 'media-upload', 'thickbox', 'wp-media'), '1.0', true );
        wp_enqueue_media();
    }

    wp_enqueue_script( 'meu-admin-js', get_template_directory_uri() . '/admin-script.js', array('jquery'), '1.0', true );
}
add_action('admin_enqueue_scripts', 'meu_tema_admin_scripts');

// Carregar Bootstrap
function load_bootstrap() {
    wp_enqueue_style('bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-bundle', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'load_bootstrap');

// Carregar Fontes (Poppins, Bootstrap Icons, Font Awesome)
function meu_tema_carregar_fontes_e_icones() {
    wp_enqueue_style('meu-tema-fontes-poppins', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap', false );
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css', array(), '1.11.3');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css', array(), '6.5.1');
}
add_action('wp_enqueue_scripts', 'meu_tema_carregar_fontes_e_icones');

// Carregar Swiper JS
function adicionar_swiper_recursos() {
    wp_enqueue_style('swiper-css', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
    wp_enqueue_script('swiper-js', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', array(), null, true);
    wp_enqueue_script('swiper-init', get_template_directory_uri() . '/js/swiper-init.js', array('swiper-js'), null, true);
}
add_action('wp_enqueue_scripts', 'adicionar_swiper_recursos');

// Carregar scripts específicos para cada página
function carregar_scripts_condicionais() {
    // Home
    if ( is_front_page() || is_home() ) {
        wp_enqueue_script('meu-home-script', get_template_directory_uri() . '/js/home.js', array(), '1.0.0', true );
    }
    // Página de Produtos
    if (is_page_template('produtos.php')) {
        wp_enqueue_script('script-produtos', get_template_directory_uri() . '/js/produtos.js', array('jquery'), '1.0', true );
    }
    // Página Sobre Nós
    if (is_page_template('sobre-nos.php')) {
        wp_enqueue_script('script-sobre', get_template_directory_uri() . '/js/home.js', array('jquery'), '1.0', true );
    }
    // Página Trabalhe Conosco
    if (is_page_template('trabalhe-conosco.php')) {
        wp_enqueue_script('script-trabalhe', get_template_directory_uri() . '/js/home.js', array('jquery'), '1.0', true );
    }
    // Página Pós-Vendas
    if (is_page_template('pos-vendas.php')) {
        wp_enqueue_script('script-pos-venda', get_template_directory_uri() . '/js/home.js', array('jquery'), '1.0', true );
    }
        // Página Pós-Vendas
    if (is_page_template('contato.php')) {
        wp_enqueue_script('script-contato', get_template_directory_uri() . '/js/home.js', array('jquery'), '1.0', true );
    }
}
add_action( 'wp_enqueue_scripts', 'carregar_scripts_condicionais' );


// Carregar CSS específicos para cada página
function carregar_estilos_condicionais() {
    // CSS para Vagas
    if (is_page_template('trabalhe-conosco.php')) {
        wp_enqueue_style('cadastro-vagas-simples-style', get_template_directory_uri() . '/css/vagas.css');
    }
    // CSS para Pós-Vendas
    if (is_page('pos-vendas-e-suporte')) {
        wp_enqueue_style('estilo-pos-venda', get_template_directory_uri() . '/css/pos-vendas.css');
    }
    // CSS para Contato
    if (is_page('contato')) {
        wp_enqueue_style('estilo-contato', get_template_directory_uri() . '/css/contato.css');
    }
}
add_action('wp_enqueue_scripts', 'carregar_estilos_condicionais');


// =========================================================================
//  REGRAS DE REESCRITA DE URL E BREADCRUMBS
// =========================================================================

function custom_rewrite_rules_e_query_vars() {
    add_rewrite_rule('^maquinas/([^/]+)/?$', 'index.php?pagename=maquinas&custom_category_slug=$matches[1]', 'top');
    add_rewrite_rule('^maquinas/([^/]+)/([^/]+)/?$', 'index.php?pagename=produtos&category_slug=$matches[1]&product_slug=$matches[2]', 'top');
}
add_action('init', 'custom_rewrite_rules_e_query_vars');

function add_custom_query_vars($vars) {
    $vars[] = 'custom_category_slug';
    $vars[] = 'category_slug';
    $vars[] = 'product_slug';
    return $vars;
}
add_filter('query_vars', 'add_custom_query_vars');


function custom_breadcrumbs($args = []) {
    $defaults = [
        'product_name'  => '',
        'category_name' => '',
        'category_slug' => ''
    ];
    $args = wp_parse_args($args, $defaults);

    $separator = '<span class="mx-2">/</span>';
    $home_title = 'Início';
    
    echo '<nav aria-label="breadcrumb"><ol class="breadcrumb">';
    echo '<li class="breadcrumb-item"><a href="' . esc_url(home_url('/')) . '">' . esc_html($home_title) . '</a></li>';

    if (!empty($args['product_name'])) {
        echo $separator;
        if (!empty($args['category_name']) && !empty($args['category_slug'])) {
            $category_url = esc_url(home_url('/maquinas/' . $args['category_slug'] . '/'));
            echo '<li class="breadcrumb-item"><a href="' . $category_url . '">' . esc_html($args['category_name']) . '</a></li>';
            echo $separator;
        }
        echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html($args['product_name']) . '</li>';
    } 
    else {
        if (is_home() || is_front_page()) {
            echo '</ol></nav>';
            return;
        }
        echo $separator;
        if (is_page()) {
            echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html(get_the_title()) . '</li>';
        } elseif (is_singular('post')) {
            $category = get_the_category();
            if (!empty($category)) {
                $first_category = $category[0];
                echo '<li class="breadcrumb-item"><a href="' . esc_url(get_category_link($first_category->term_id)) . '">' . esc_html($first_category->name) . '</a></li>';
                echo $separator;
            }
            echo '<li class="breadcrumb-item active" aria-current="page">' . esc_html(get_the_title()) . '</li>';
        } elseif (is_category()) {
             echo '<li class="breadcrumb-item active" aria-current="page">' . single_cat_title('', false) . '</li>';
        } elseif (is_search()) {
            echo '<li class="breadcrumb-item active" aria-current="page">Busca por: “' . get_search_query() . '”</li>';
        }
    }
    echo '</ol></nav>';
}


// =========================================================================
//  PROCESSAMENTO DO FORMULÁRIO DE CONTATO (VIA AJAX)
// =========================================================================

/**
 * Carrega os scripts necessários APENAS para a página de contato.
 * Inclui o script da máscara (imask.js) e o de validação/AJAX (form-contato.js).
 */
function carregar_scripts_contato() {
    if (is_page_template('contato.php')) {
        // Carrega a biblioteca IMask.js para a máscara de telefone
        wp_enqueue_script('imask-js', 'https://unpkg.com/imask', [], null, true);

        // Carrega seu script do formulário, que agora depende do imask.js
        wp_enqueue_script('form-contato-js', get_template_directory_uri() . '/js/form-contato.js', ['imask-js'], '1.1', true);

        // Passa a URL do AJAX para o script, essencial para o WordPress
        wp_localize_script('form-contato-js', 'ajax_object', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }
}
add_action('wp_enqueue_scripts', 'carregar_scripts_contato');

// Handler AJAX para gerar a pergunta anti robô
add_action('wp_ajax_get_anti_robo_question', 'get_anti_robo_question_handler');
add_action('wp_ajax_nopriv_get_anti_robo_question', 'get_anti_robo_question_handler');
function get_anti_robo_question_handler() {
    $num1 = rand(1, 9);
    $num2 = rand(1, 9);
    // Salva no session para validação posterior
    if (!session_id()) session_start();
    $_SESSION['anti_robo_soma'] = $num1 + $num2;
    wp_send_json_success(['num1' => $num1, 'num2' => $num2]);
}

/**
 * Manipulador AJAX para o formulário de contato.
 * Esta função recebe os dados do JavaScript, valida no servidor e salva no banco.
 */
add_action('wp_ajax_enviar_formulario_ajax', 'enviar_formulario_ajax_handler');
add_action('wp_ajax_nopriv_enviar_formulario_ajax', 'enviar_formulario_ajax_handler');

function enviar_formulario_ajax_handler() {
    // Inicia sessão para validação anti robô
    if (!session_id()) session_start();
    $campos_obrigatorios = ['nome', 'empresa', 'whatsapp', 'email', 'motivo', 'resposta_robo'];
    foreach ($campos_obrigatorios as $campo) {
        if (empty(trim($_POST[$campo]))) {
            wp_send_json_error('O campo "' . ucfirst($campo) . '" é obrigatório.');
            return;
        }
    }
    if (!is_email($_POST['email'])) {
        wp_send_json_error('O formato do e-mail é inválido.');
        return;
    }
    // Validação anti robô
    $resposta_robo = intval($_POST['resposta_robo']);
    $soma_correta = isset($_SESSION['anti_robo_soma']) ? intval($_SESSION['anti_robo_soma']) : null;
    if ($soma_correta === null || $resposta_robo !== $soma_correta) {
        wp_send_json_error('Resposta da verificação anti-robô incorreta.');
        return;
    }
    // Limpa a pergunta após uso
    unset($_SESSION['anti_robo_soma']);
    // Higieniza os dados
    $nome     = sanitize_text_field($_POST['nome']);
    $empresa  = sanitize_text_field($_POST['empresa']);
    $whatsapp = sanitize_text_field($_POST['whatsapp']);
    $email    = sanitize_email($_POST['email']);
    $motivo   = wp_kses_post($_POST['motivo']);

    // Insere os dados no banco de dados do WordPress
    global $wpdb;
    $tabela = $wpdb->prefix . 'minhas_submissoes';
    $inserido = $wpdb->insert($tabela, [
        'nome'       => $nome,
        'empresa'    => $empresa,
        'whatsapp'   => $whatsapp,
        'email'      => $email,
        'motivo'     => $motivo,
        'data_envio' => current_time('mysql'),
    ]);
    if ($inserido) {
        $para = get_option('admin_email');
        $assunto = 'Novo Contato Recebido do Site: ' . $empresa;
        $corpo_email = "<html><head><title>{$assunto}</title></head><body><h2>Nova Submissão do Formulário de Contato</h2><p><strong>Nome:</strong> {$nome}</p><p><strong>Empresa:</strong> {$empresa}</p><p><strong>WhatsApp:</strong> {$whatsapp}</p><p><strong>E-mail:</strong> {$email}</p><p><strong>Motivo do contato:</strong> {$motivo}</p></body></html>";
        $headers = array('Content-Type: text/html; charset=UTF-8');
        $headers[] = 'Reply-To: ' . $nome . ' <' . $email . '>';
        wp_mail($para, $assunto, $corpo_email, $headers);
        wp_send_json_success('Dados salvos com sucesso!');
    } else {
        wp_send_json_error('Ocorreu um erro ao salvar os dados no banco. Tente novamente.');
    }
}

function meu_tema_scripts() {
    wp_enqueue_script(
        'custom-script', // Um nome único para o seu script
        get_template_directory_uri() . '/js/custom-script.js', // O caminho para o seu arquivo .js
        array(), // Dependências, como jQuery, se houver
        '1.0.0', // A versão do seu script
        true // Carregar o script no rodapé (footer)
    );
}
add_action( 'wp_enqueue_scripts', 'meu_tema_scripts' );