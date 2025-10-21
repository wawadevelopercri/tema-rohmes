<?php
/* Template Name: Contato */

get_header();
?>
<div class="container-fluid bradcamp">
<?php //custom_breadcrumbs(); ?>
</div>

<section class="contato">
    <div class="container titulo">
        <h2>Entre em contato com nossa equipe</h2>
    </div>
    <div class="container py-5">
        <p class="mb-4">Nossa equipe está pronta para ouvir você! Seja para tirar dúvidas, solicitar um orçamento personalizado ou apenas conversar sobre como podemos ajudar, estamos sempre disponíveis.<br><br>Preencha o formulário abaixo ou utilize um dos nossos canais de atendimento — <b>será um prazer falar com você!</b></p>
        <div class="row g-5">
            <div class="col-lg-8 col-md-7 d-flex flex-column">
                <form method="post" id="form-contato" class="mt-4 needs-validation flex-grow-1" novalidate>
                    <input type="hidden" name="action" value="enviar_formulario_ajax">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nome" class="form-label">Qual seu nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                            <div class="invalid-feedback">Campo obrigatório.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="empresa" class="form-label">Nome da empresa</label>
                            <input type="text" class="form-control" id="empresa" name="empresa" required>
                            <div class="invalid-feedback">Campo obrigatório.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="whatsapp" class="form-label">WhatsApp</label>
                            <input type="text" class="form-control" id="whatsapp" name="whatsapp" required>
                            <div class="invalid-feedback">Campo obrigatório.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="invalid-feedback">Campo obrigatório.</div>
                        </div>
                        <div class="col-12">
                            <label for="motivo" class="form-label">Motivo do contato</label>
                            <textarea class="form-control" id="motivo" name="motivo" required></textarea>
                            <div class="invalid-feedback">Campo obrigatório.</div>
                        </div>
                        <div class="col-12 mt-4">
                            <div class="g-recaptcha" data-sitekey="6Le2nNwrAAAAAMtkcT11HThBZ-eWz45_rZGBYB6e"></div>
                        </div>
                        <div class="col-12 text-center mt-4">
                            <button type="submit" class="btn btn-custom px-5">Enviar</button>
                        </div>
                        <div class="resultado-email mt-3"></div>
                    </div>
                </form>
               <script src="https://www.google.com/recaptcha/api.js?hl=pt-BR" async defer></script>
                <div class="modal fade" id="modalSucesso" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body text-center p-4">
                                <h5 class="mb-3" style="color: #103c64;">✅ Mensagem enviada com sucesso!</h5>
                                <p>Agradecemos seu contato. Nossa equipe retornará em breve.</p>
                                <button type="button" class="btn botao-fechar" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-5 d-flex flex-column justify-content-between">
                <ul class="contact-list-final">
                    <li>
                        <a href="https://www.google.com/maps/dir//R.+José+Felisbino,+613+-+Tereza+Cristina,+Içara+-+SC,+88820-000/@-28.7077244,-49.3620101,23773m/data=!3m1!1e3!4m8!4m7!1m0!1m5!1m1!1s0x95217fb2738d7337:0xa4b4ed0163371ef9!2m2!1d-49.2796087!2d-28.7077494?entry=ttu&g_ep=EgoyMDI1MDYzMC4wIKXMDSoASAFQAw%3D%3D" target="_blank" rel="noopener noreferrer">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                            </div>
                            <div class="text-container">
                                <span class="title">Nosso Endereço</span>
                                <span class="subtitle">R. José Felisbino, 613 - Tereza Cristina, Içara - SC</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="tel:4834200710">
                            <div class="icon-container">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                                </svg>
                            </div>
                            <div class="text-container">
                                <span class="title">Ligue para Nós</span>
                                <span class="subtitle">(48) 3420-0710</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="https://api.whatsapp.com/send?phone=554874001421&text=Ol%C3%A1%2C+vim+do+site%2C+gostaria+de+um+or%C3%A7amento" target="_blank" rel="noopener noreferrer">
                            <div class="icon-container">
                                <i class="fab fa-whatsapp whatsapp"></i>
                            </div>
                            <div class="text-container">
                                <span class="title">Fale com nosso consultor</span>
                                <span class="subtitle">Clique aqui para um orçamento via WhatsApp</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="mapa-clientes">
</section>

<?php get_footer(); ?>