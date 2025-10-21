<?php
/**
 * O modelo para exibir páginas 404 (não encontrado) - Versão Final Animada
 *
 * @package Rohmes
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="error-404-v2">

        <div class="floating-icons-container">
            <i class="fas fa-crosshairs icon-1"></i>     <i class="fas fa-burst icon-2"></i>           <i class="fas fa-ruler-combined icon-3"></i>  <i class="fas fa-layer-group icon-4"></i>     <i class="fas fa-gear icon-5"></i>            <i class="fas fa-vector-square icon-6"></i>  </div>

        <div class="container">
            <?php //custom_breadcrumbs(); ?>
            <div class="error-container-v2">

                <h1 class="error-heading-v2">404</h1>

                <div class="error-box-v2">
                    <h2 class="titulo-pagina">Página Não Encontrada</h2>
                    <p>Parece que a página que você tentou acessar se perdeu no universo digital. Vamos encontrar um novo rumo para você.</p>
                    
                    <div class="search-form-404">
                        <?php get_search_form(); ?>
                    </div>

                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-banner">
                        Voltar à Segurança da Home
                    </a>
                </div>

            </div>
        </div>
    </section>
</main>

<?php
get_footer();