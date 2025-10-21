<?php
/* Template Name: Obrigado */

get_header(); ?>

<section class="contato">
  <div class="container titulo">
    <h2>Entre em contato com nossa equipe</h2>
  </div>


  <div class="container titulo">
    <h3>Formulário enviado com sucesso!</h3>
  </div>


    <div class="container py-5">
        <p>Nossa equipe está pronta para ouvir você! Seja para tirar dúvidas, solicitar um orçamento personalizado ou apenas conversar sobre como podemos ajudar, estamos sempre disponíveis.<br><br>Preencha o formulário abaixo ou utilize um dos nossos canais de atendimento — <b>será um prazer falar com você!</b></p>
         <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" class="mt-4">
  <input type="hidden" name="action" value="enviar_para_ploomes">

  <div class="row g-3">
    <div class="col-md-6">
      <label for="nome" class="form-label">Qual seu nome</label>
      <input type="text" class="form-control" id="nome" name="nome" required>
    </div>

    <div class="col-md-6">
      <label for="empresa" class="form-label">Nome da empresa</label>
      <input type="text" class="form-control" id="empresa" name="empresa" required>
    </div>

    <div class="col-md-6">
      <label for="whatsapp" class="form-label">WhatsApp</label>
      <input type="text" class="form-control" id="whatsapp" name="whatsapp" required>
    </div>

    <div class="col-md-6">
      <label for="email" class="form-label">E-mail</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <div class="col-md-6">
      <label for="maquina" class="form-label">Máquina de interesse</label>
      <input type="text" class="form-control" id="maquina" name="maquina" required>
    </div>

    <div class="col-md-6">
      <label for="material" class="form-label">Material que a empresa processa</label>
      <input type="text" class="form-control" id="material" name="material" required>
    </div>

    <div class="col-12 text-center mt-4">
      <button type="submit" class="btn btn-custom px-5">Enviar</button>
    </div>
  </div>
</form>
    </div>


      <section class="mapa-clientes fade-section">

    <div class="container">
      <div class="numeros">
        <div class="item-numero">
          <div class="counter" id="counter-projetos">0</div>
          <p>Projetos<br>Desenvolvidos</p>
        </div>
        <div class="item-numero">
          <div class="counter" id="counter-maquinas">0</div>
          <p>Máquinas<br>Entregues</p>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="frase">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse <strong>ultrices gravida</strong>. Risus commodo viverra <strong>maecenas accumsan</strong> lacus vel facilisis.
      </div>
    </div>


    <div class="container">
      <div class="mapa-container" id="mapa-area">
        <img src="../wp-content/themes/rohmes/assets/img/mapa-mundi.png" alt="Mapa Mundi" class="mapa-mundi img-fluid">
        <img src="../wp-content/themes/rohmes/assets/img/brasil.png" alt="Mapa Brasil" id="mapa-brasil" class="mapa-brasil img-fluid">
      </div>
    </div>
  </section>
</section>


<?php get_footer(); ?>