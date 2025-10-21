<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-12 empresa-footer">
        <img src="<?php echo get_template_directory_uri();?>/assets/img/logo-footer.png" alt="Rohmes" class="img-fluid" loading="lazy" decoding="async">
        <ul class="social">
          <li><a href="https://www.facebook.com/rohmesmaquinas/" target="_blank" rel="noopener" title="Facebook" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a></li>
          <li><a href="https://www.instagram.com/rohmesmaquinas/" target="_blank" rel="noopener" title="Instagram" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a></li>
          <li><a href="https://www.youtube.com/@rohmesmaquinas" target="_blank" rel="noopener" title="Youtube" aria-label="Youtube"><i class="fa-brands fa-youtube"></i></a></li>
        </ul>
      </div>
      <div class="col-md-6 col-12 links-footer">
        <h3>Máquinas</h3>
        <?php
        $categorias = get_terms([
            'taxonomy'   => 'categoria_maquina',
            'hide_empty' => false,
            'parent'     => 0,
            'orderby'    => 'name',
            'order'      => 'ASC'
        ]);
        if (!empty($categorias) && !is_wp_error($categorias)) {
            $total = count($categorias);
            $meio = ceil($total / 2);
            $coluna1 = array_slice($categorias, 0, $meio);
            $coluna2 = array_slice($categorias, $meio);
        ?>
        <div class="duas-colunas-wrapper">
          <ul class="duas-colunas">
            <?php foreach ($coluna1 as $cat): ?>
              <li class="categoria-item">
                <a href="<?= esc_url(get_term_link($cat)) ?>" class="categoria-link">
                  <?php echo get_term_meta($cat->term_id, 'categoria_icone', true) ? '<i class="' . esc_attr(get_term_meta($cat->term_id, 'categoria_icone', true)) . '"></i>' : '<i class="fa-solid fa-angle-right"></i>'; ?>
                  <span><?= esc_html($cat->name) ?></span>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
          <ul class="duas-colunas">
            <?php foreach ($coluna2 as $cat): ?>
              <li class="categoria-item">
                <a href="<?= esc_url(get_term_link($cat)) ?>" class="categoria-link">
                   <?php echo get_term_meta($cat->term_id, 'categoria_icone', true) ? '<i class="' . esc_attr(get_term_meta($cat->term_id, 'categoria_icone', true)) . '"></i>' : '<i class="fa-solid fa-angle-right"></i>'; ?>
                  <span><?= esc_html($cat->name) ?></span>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php } ?>
      </div>
      <div class="col-md-3 col-12 links-footer">
        <h3>Pós venda e Suporte</h3>
        <ul class="duas-colunas">
          <li><a href="<?php echo esc_url(site_url('/sobre-nos/')); ?>"><i class="fa-solid fa-angle-right"></i> Quem Somos</a></li>
          <li><a href="<?php echo esc_url(site_url('/trabalhe-conosco/')); ?>"><i class="fa-solid fa-angle-right"></i> Trabalhe conosco </a></li>
          <li><a href="<?php echo esc_url(site_url('/contato/')); ?>"><i class="fa-solid fa-angle-right"></i> Contato </a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="direitos text-center">
    © Copyright 2025 | Rohmes Equipamentos LTDA - 37.510.196/0001-74.
  </div>
</footer>

<?php wp_footer(); ?>

<a href="#" class="topo-fixo" aria-label="Voltar ao topo">
  <svg class="progress-ring-container" width="60" height="60" viewBox="0 0 60 60">
    <circle class="progress-ring__bg" stroke-width="5" fill="transparent" r="27.5" cx="30" cy="30"/>
    <circle class="progress-ring__circle" stroke-width="5" fill="transparent" r="27.5" cx="30" cy="30"/>
    <path class="progress-ring__icon" d="M30 22.5 L30 37.5 M22.5 30 L30 22.5 L37.5 30" stroke-width="3" fill="none" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>
</a>

<div id="cotacaoModal" class="modal">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2 class="text-center mb-4">Formulário de Cotação</h2>
        <form id="cotacaoForm">
            <div class="row mb-3">
                
<div class="col-md-6">
    <label for="cnpj" class="form-label">CNPJ</label>
    <div class="input-group">
        <input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Digite apenas números">
        <span class="input-group-text" id="cnpj-status" style="display: none;">
            <div class="spinner-border spinner-border-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </span>
    </div>
    <div id="cnpj-error-message" class="invalid-feedback"></div>
</div>

<div class="col-md-6">
                    <label for="nomeEmpresa" class="form-label">Nome da empresa</label>
                    <input type="text" class="form-control" id="nomeEmpresa" name="nomeEmpresa" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="seuNome" class="form-label">Seu nome</label>
                    <input type="text" class="form-control" id="seuNome" name="seuNome" required>
                </div>
                <div class="col-md-6">
                    <label for="telefone" class="form-label">Telefone</label>
                    <input type="tel" class="form-control" id="telefone" name="telefone" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>

            <hr class="my-4">

            <div class="mb-3">
                <label class="form-label">Qual máquina está buscando cotação?</label>
                <small class="form-text text-muted d-block mb-2">Você pode selecionar mais de uma opção.</small>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-check"><input class="form-check-input" type="checkbox" id="corteLaser" name="maquina" value="Corte a laser"><label class="form-check-label" for="corteLaser">Corte a laser</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox" id="dobradeira" name="maquina" value="Dobradeira"><label class="form-check-label" for="dobradeira">Dobradeira</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox" id="soldaLaser" name="maquina" value="Solda a Laser"><label class="form-check-label" for="soldaLaser">Solda a Laser</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox" id="celulaRobo" name="maquina" value="Celula Robo"><label class="form-check-label" for="celulaRobo">Celula Robo</label></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-check"><input class="form-check-input" type="checkbox" id="metaleira" name="maquina" value="Metaleira"><label class="form-check-label" for="metaleira">Metaleira</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox" id="guilhotina" name="maquina" value="Guilhotina"><label class="form-check-label" for="guilhotina">Guilhotina</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox" id="calandra" name="maquina" value="Calandra"><label class="form-check-label" for="calandra">Calandra</label></div>
                        <div class="form-check"><input class="form-check-input" type="checkbox" id="curvadora" name="maquina" value="Curvadora"><label class="form-check-label" for="curvadora">Curvadora</label></div>
                    </div>
                </div>
            </div>

<div class="mb-4">
    <label class="form-label d-block mb-3">Em quanto tempo busca investimento?</label>
    <div class="custom-radio-group">
        <label class="custom-radio-label"><input type="radio" name="investimento" value="Imediato" required><span>Imediato</span></label>
        <label class="custom-radio-label"><input type="radio" name="investimento" value="Em até 3 meses"><span>Em até 3 meses</span></label>
        <label class="custom-radio-label"><input type="radio" name="investimento" value="De 3 a 6 meses"><span>De 3 a 6 meses</span></label>
        <label class="custom-radio-label"><input type="radio" name="investimento" value="Daqui a um ano"><span>Daqui a um ano</span></label>
        <label class="custom-radio-label"><input type="radio" name="investimento" value="Ainda não tenho certeza, estou buscando informações"><span>Ainda não tenho certeza, estou buscando informações</span></label>
    </div>
</div>

            <button type="submit" class="whatsapp-banner btn-lg w-100">
                Enviar Cotação
            </button>
        </form>
    </div>
</div>

</body>
</html>