
<?php
/* Template Name: Processa formulario */

get_header(); ?>

<section class="trabalhe-conosco">
  <div class="container titulo">
    <h2>Faça parte de nossa equipe</h2>
  </div>

  <div class="container-fluid py-5">
    <p>Nossa equipe está pronta para ouvir você! Seja para tirar dúvidas, solicitar um orçamento personalizado ou <br>apenas conversar sobre como podemos ajudar, estamos sempre disponíveis.<br><br>Preencha o formulário abaixo ou utilize um dos nossos canais de atendimento — <b>será um prazer falar com você!</b></p>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $area = $_POST['area'];
    $mensagem = $_POST['mensagem'];

    // Upload do currículo
    if (isset($_FILES['curriculo']) && $_FILES['curriculo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = basename($_FILES['curriculo']['name']);
        $targetPath = $uploadDir . time() . '_' . $filename;

        if (move_uploaded_file($_FILES['curriculo']['tmp_name'], $targetPath)) {
            echo "Currículo enviado com sucesso!";
        } else {
            echo "Erro ao enviar o currículo.";
        }
    } else {
        echo "Erro no envio do arquivo.";
    }

    // Aqui você pode salvar os dados no banco ou enviar por e-mail.
}
?>

<form action="processa-formulario/" method="POST" enctype="multipart/form-data">
      <div class="row g-3">
        <!-- Nome -->
        <div class="col-md-6">
          <label for="nome" class="form-label">Nome completo</label>
          <input type="text" class="form-control" id="nome" name="nome" required>
        </div>

        <!-- E-mail -->
        <div class="col-md-6">
          <label for="email" class="form-label">E-mail</label>
          <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <!-- Telefone -->
        <div class="col-md-6">
          <label for="telefone" class="form-label">Telefone</label>
          <input type="tel" class="form-control" id="telefone" name="telefone" required>
        </div>

        <!-- Área de Interesse -->
        <div class="col-md-6">
          <label for="area" class="form-label">Área de Interesse</label>
          <select class="form-select" id="area" name="area" required>
            <option selected disabled>Selecione...</option>
            <option value="administrativo">Administrativo</option>
            <option value="comercial">Comercial</option>
            <option value="técnico">Técnico</option>
            <option value="outro">Outro</option>
          </select>
        </div>

        <!-- Mensagem -->
        <div class="col-12">
          <label for="mensagem" class="form-label">Mensagem</label>
          <textarea class="form-control" id="mensagem" name="mensagem" rows="4" placeholder="Conte-nos um pouco sobre você..."></textarea>
        </div>

        <!-- Upload do Currículo -->
        <div class="col-12">
          <label for="curriculo" class="form-label">Anexar Currículo (PDF ou DOC)</label>
          <input class="form-control" type="file" id="curriculo" name="curriculo" accept=".pdf,.doc,.docx" required>
        </div>

        <!-- Botão Enviar -->
        <div class="col-12 text-center">
          <button type="submit" class="btn btn-primary px-5">Enviar</button>
        </div>
      </div>
    </form>
  </div>

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
