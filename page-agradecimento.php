<?php
/**
 * Template Name: Página de Agradecimento
 *
 * O modelo para exibir uma página de agradecimento elegante após o envio de um formulário.
 *
 * @package Rohmes
 */

get_header();
?>

<main id="primary" class="site-main">
    <section class="thank-you-page-v2">
        <div class="thank-you-container-v2">

            <div class="logo-container">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo-icon.png" alt="Logotipo Rohmes Máquinas">
            </div>

            <div class="thank-you-box-v2">
                <h2 class="brand-name">Rohmes Máquinas</h2>

                <h1 class="titulo-pagina">Pronto. Entraremos em contato imediatamente</h1>
                
                <p>Mas caso queira um atendimento mais rápido, toque no botão abaixo e fale conosco em nosso WhatsApp.</p>
                
                <a href="https://api.whatsapp.com/send?phone=554874001421&text=Ol%C3%A1%2C+acabei+de+preencher+o+formul%C3%A1rio+no+site+e+gostaria+de+um+atendimento." target="_blank" class="btn-whatsapp">
                    <i class="fab fa-whatsapp"></i> Falar no WhatsApp
                </a>

                <div class="success-footer">
                    <i class="fas fa-info-circle"></i>
                    <span>Você enviou suas respostas com sucesso.</span>
                </div>
            </div>

        </div>
    </section>
</main>

<?php
get_footer();