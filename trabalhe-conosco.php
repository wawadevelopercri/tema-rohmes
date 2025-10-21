<?php
/* Template Name: Trabalhe Conosco */

get_header();

?>
<section class="page-header">
    <div class="container">
        <h1>Faça parte de nossa equipe</h1>
    </div>
</section>

<section class="trabalhe_conosco">

  <div class="container">
    <div class="row">

      <div class="col-md-12">

      <div class="vagas-header">
        <h2>Vagas Abertas</h2>
        <p>Estamos crescendo de forma exponencial e queremos que os melhores talentos cresçam conosco. Confira abaixo as vagas disponíveis, se aplique e em breve entraremos em contato.</p>
      </div>

     <?php echo do_shortcode('[mostrar_vagas_accordion]'); ?>

      </div>
      <!--
      <div class="col-md-6">
        <div class="row">
          <p>Nossa equipe está pronta para ouvir você! <br>Seja para tirar dúvidas, solicitar um orçamento personalizado ou apenas conversar sobre como<br> <b>Será um prazer falar com você!</b></p>
          <form action="processa-formulario/" method="POST" enctype="multipart/form-data">
            <div class="row g-3">
             
              <div class="col-md-6">
                <label for="nome" class="form-label">Nome completo</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
              </div>

            
              <div class="col-md-6">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
              </div>

             
              <div class="col-md-6">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="tel" class="form-control" id="telefone" name="telefone" required>
              </div>

             
              <div class="col-md-6">
                <label for="area" class="form-label">Área de Interesse</label>
<select class="form-select" id="area" name="area" required>
    <option value="" selected disabled>Selecione...</option> <?php // Mantido o 'value=""' para o 'required' funcionar corretamente ?>
    <?php
    // Argumentos para buscar as 'vagas'
    $args_vagas = array(
        'post_type'      => 'vaga',      // Slug do seu Custom Post Type
        'post_status'    => 'publish',   // Apenas vagas publicadas
        'posts_per_page' => -1,          // '-1' para buscar todas as vagas
        'orderby'        => 'title',     // Ordenar pelo título da vaga
        'order'          => 'ASC',       // Ordem ascendente (A-Z)
    );

    $vagas_query = new WP_Query( $args_vagas );

    // Verifica se existem vagas
    if ( $vagas_query->have_posts() ) {
        while ( $vagas_query->have_posts() ) {
            $vagas_query->the_post();
            $post_id = get_the_ID();
            $nome_vaga = get_the_title();

            // Gera a tag <option> para cada vaga
            // Usamos o ID do post como 'value'. Você pode usar get_post_field('post_name', $post_id) se preferir o slug.
            echo '<option value="' . esc_attr( $post_id ) . '">' . esc_html( $nome_vaga ) . '</option>';
        }
        wp_reset_postdata(); // Restaura os dados originais do post global
    } else {
        // Opcional: se nenhuma vaga for encontrada, você pode adicionar uma mensagem ou outra opção
        // echo '<option value="" disabled>Nenhuma vaga disponível no momento</option>';
        // No seu caso, como o campo é 'required' e já tem "Selecione...",
        // talvez não seja necessário adicionar outra opção aqui se não houver vagas.
        // O select simplesmente não terá outras opções além de "Selecione...".
    }
    ?>
    <?php /*
    // Opções estáticas originais, agora substituídas pela busca dinâmica:
    <option value="administrativo">Administrativo</option>
    <option value="comercial">Comercial</option>
    <option value="técnico">Técnico</option>
    <option value="outro">Outro</option>
    */ ?>
</select>
              </div>





              
              <div class="col-12">
                <label for="mensagem" class="form-label">Mensagem</label>
                <textarea class="form-control" id="mensagem" name="mensagem" rows="4" placeholder="Conte-nos um pouco sobre você..."></textarea>
              </div>

              
              <div class="col-12">
                <label for="curriculo" class="form-label">Anexar Currículo (PDF ou DOC)</label>
                <input class="form-control" type="file" id="curriculo" name="curriculo" accept=".pdf,.doc,.docx" required>
              </div>

             
              <div class="col-12 text-center">
                <button type="submit" class="btn btn-custom px-5">Enviar</button>
              </div>
            </div>
          </form>
        </div>

      </div>

    </div>

  </div>
  </div>
  -->


  <section class="mapa-clientes ">
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
        <p>Sua escolha número um para soluções de corte a laser, dobradeiras e etc. Orgulhosamente, distribuímos nossas máquinas de última geração em toda a América Latina, com um foco especial nas regiões do <b>Centro-oeste, sudeste e sul do Brasil</b>.</p>

<p>Estamos comprometidos em atender as demandas de nossos clientes em toda a região, proporcionando qualidade, eficiência e parceria.</p>
      </div>
    </div>

    <div class="container">
      <div class="mapa-container" id="mapa-area">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/mapa-mundi.png" alt="Mapa Mundi destacando a atuação da Rohmes" class="mapa-mundi img-fluid">
        <img src="<?php echo esc_url(get_template_directory_uri()); ?>/assets/img/brasil.png" alt="Mapa do Brasil indicando a presença da Rohmes" id="mapa-brasil" class="mapa-brasil img-fluid">

        <div class="sede-ponto" style="top: 0%;left: 35%;" title="Norte 1"></div>
        <div class="sede-ponto" style="top: 5%;left: 39%;" title="Norte 2"></div>
        <div class="sede-ponto" style="top: 5%;left: 32%;" title="Norte 3"></div>
        <div class="sede-ponto" style="top: 1%;left: 30%;" title="Norte 4"></div>
        <div class="sede-ponto" style="top: 14%; left: 36%;" title="Norte 5"></div>

        <div class="sede-ponto" style="top: 18%; left: 45%;" title="Nordeste 1"></div>
        <div class="sede-ponto" style="top: 21%; left: 46%;" title="Nordeste 2"></div>
        <div class="sede-ponto" style="top: 16%; left: 43%;" title="Nordeste 3"></div>
        <div class="sede-ponto" style="top: 23%; left: 44%;" title="Nordeste 4"></div>
        <div class="sede-ponto" style="top: 12%;left: 46%;" title="Nordeste 5"></div>

        <div class="sede-ponto" style="top: 16%;left: 38%;" title="Centro-Oeste 1"></div>
        <div class="sede-ponto" style="top: 23%; left: 39%;" title="Centro-Oeste 2"></div>
        <div class="sede-ponto" style="top: 13%;left: 41%;" title="Centro-Oeste 3"></div>
        <div class="sede-ponto" style="top: -5%;left: 32%;" title="Centro-Oeste 4"></div>
        <div class="sede-ponto" style="top: 21%;left: 37%;" title="Centro-Oeste 5"></div>

        <div class="sede-ponto" style="top: 29%; left: 40%;" title="Sudeste 1"></div>
        <div class="sede-ponto" style="top: 27%; left: 42%;" title="Sudeste 2"></div>
        <div class="sede-ponto" style="top: 8%;left: 43%;" title="Sudeste 3"></div>
        <div class="sede-ponto" style="top: 28%; left: 39%;" title="Sudeste 4"></div>
        <div class="sede-ponto" style="top: 33%;left: 40%;" title="Sudeste 5"></div>

        <div class="sede-ponto" style="top: 20%;left: 41%;" title="Sul 1"></div>
        <div class="sede-ponto" style="top: 36%;left: 40%;" title="Sul 2"></div>
        <div class="sede-ponto" style="top: 34%; left: 39%;" title="Sul 3"></div>
        <div class="sede-ponto" style="top: 4%;left: 45%;" title="Sul 4"></div>
        <div class="sede-ponto" style="top: 38%;left: 38%;" title="Sul 5"></div>

      </div>
    </div>
  </section>
</section>


<?php get_footer(); ?>