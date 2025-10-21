<?php
/**
 * Menu de Navegação Otimizado para Acessibilidade, SEO e Performance.
 */
?>
<nav class="navbar navbar-expand-lg navbar-dark menu-background your-menu-selector">
  <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
    <?php
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($custom_logo_id) {
      $logo = wp_get_attachment_image($custom_logo_id, 'full', false, ['class' => 'custom-logo', 'alt' => get_bloginfo('name'), 'width' => 120]);
      echo $logo;
    } else {
      echo '<img src="' . esc_url(get_template_directory_uri()) . '/assets/img/logo.png" alt="' . esc_attr(get_bloginfo('name')) . '">';
    }
    ?>
  </a>

  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link <?php if (is_front_page()) echo 'active'; ?>" href="<?php echo esc_url(home_url('/')); ?>">Home</a>
      </li>

      <?php
      $is_categoria_page = (is_tax('categoria_maquina') || is_singular('maquina'));
      ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle <?php if ($is_categoria_page) echo 'active'; ?>" href="#" id="ecosistemaDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Máquinas <i class="fa-solid fa-chevron-down dropdown-icon" aria-hidden="true"></i>
        </a>
        <div class="dropdown-menu mega-dropdown" aria-labelledby="ecosistemaDropdown">
          <div class="bg-submenu"> <?php
            // Otimização com cache
            $categorias_menu = get_transient('menu_maquinas_categorias_v2');

            if (false === $categorias_menu) {
                $categorias_menu = get_terms([
                    'taxonomy'   => 'categoria_maquina',
                    'hide_empty' => false,
                    'parent'     => 0,
                    'orderby'    => 'name',
                    'order'      => 'ASC'
                ]);
                set_transient('menu_maquinas_categorias_v2', $categorias_menu, 12 * HOUR_IN_SECONDS);
            }

            if (!empty($categorias_menu) && !is_wp_error($categorias_menu)) {
                echo '<div class="bg-submenu-links">';

                foreach ($categorias_menu as $cat) {
                    $category_link = get_term_link($cat);
                    
                    
                    
                    // Busca a imagem para o data-attribute
                    $url_imagem = '';
                    $image_id = get_term_meta($cat->term_id, 'categoria_imagem_id', true);
                    if ($image_id) {
                        $url_imagem = wp_get_attachment_image_url($image_id, 'large');
                    }

                    // Busca o ícone para exibir no menu
                    $icone_classe = get_term_meta($cat->term_id, 'categoria_icone', true);
                    $icone_html = $icone_classe ? '<i class="' . esc_attr($icone_classe) . '" aria-hidden="true"></i>' : '<i class="fa-solid fa-angle-right" aria-hidden="true"></i>'; // Ícone padrão
                    ?>
                    
                    <a class="dropdown-item" href="<?php echo esc_url($category_link); ?>" data-image="<?php echo esc_url($url_imagem); ?>">
                        <?php echo $icone_html; ?> <?php echo esc_html($cat->name); ?>
                    </a>
                    
                    <?php
                }

                echo '</div>'; // Fecha o contêiner dos links
            } else {
                echo '<div class="col-12"><p class="dropdown-item">Nenhuma categoria encontrada.</p></div>';
            }
            ?>
          </div>
          <img src="#" id="imagem-categoria-hover" class="d-none d-lg-block img-fluid" alt="Pré-visualização da categoria">
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link <?php if (is_page('suporte-tecnico')) echo 'active'; ?>" href="<?php echo esc_url(site_url('suporte-tecnico')); ?>">Suporte Técnico</a>
      </li>
      
      <?php
      $is_empresa_page = is_page(['sobre-nos', 'trabalhe-conosco', 'contato']);
      ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle <?php if ($is_empresa_page) echo 'active'; ?>" href="#" id="empresaDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Empresa <i class="fa-solid fa-chevron-down dropdown-icon" aria-hidden="true"></i>
        </a>
        <ul class="dropdown-menu" aria-labelledby="empresaDropdown"> 
          <li><a class="dropdown-item" href="<?php echo esc_url(site_url('sobre-nos/')); ?>"><i class="fa-solid fa-angle-right" aria-hidden="true"></i> Quem Somos</a></li>
          <li><a class="dropdown-item" href="<?php echo esc_url(site_url('trabalhe-conosco/')); ?>"><i class="fa-solid fa-angle-right" aria-hidden="true"></i> Trabalhe conosco</a></li>
          <li><a class="dropdown-item" href="<?php echo esc_url(site_url('contato/')); ?>"><i class="fa-solid fa-angle-right" aria-hidden="true"></i> Contato</a></li>
        </ul>
      </li>
    </ul>

    <form class="d-flex ms-auto position-relative form-busca-ajax" role="search" method="get" action="<?php echo esc_url(home_url('/page-busca/')); ?>" autocomplete="off">
        <div class="input-group search-group">
            <input class="form-control busca busca-ajax-input" type="search" placeholder="Buscar por máquina..." aria-label="Buscar" name="q" value="">
            <button class="botao-busca" type="submit"><i class="bi bi-search"></i></button>
        </div>
        <div class="sugestoes-busca-list" style="display: none;"></div>
    </form>
  </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropdownContainer = document.querySelector('.mega-dropdown');
    const targetImage = document.getElementById('imagem-categoria-hover');
    
    // Se não encontrar os elementos necessários, o script não continua.
    if (!dropdownContainer || !targetImage) {
        return;
    }

    const linksComImagem = dropdownContainer.querySelectorAll('a.dropdown-item[data-image]');

    // --- 1. LÓGICA DE HOVER PARA EXIBIR A IMAGEM ---
    // Adiciona um "ouvinte" para cada link com imagem.
    linksComImagem.forEach(link => {
        link.addEventListener('mouseenter', () => {
            const imageUrl = link.dataset.image;
            if (imageUrl) {
                // Define a imagem correspondente e a torna visível
                targetImage.src = imageUrl;
                targetImage.classList.remove('d-none');
            } else {
                // Se um link não tiver imagem, esconde o container da imagem.
                targetImage.classList.add('d-none');
            }
        });
    });

    // Esconde a imagem quando o mouse sai da área inteira do submenu.
    dropdownContainer.addEventListener('mouseleave', () => {
        targetImage.classList.add('d-none');
    });

    // --- 2. LÓGICA DE PRÉ-CARREGAMENTO (PRELOADING) ---
    const maquinaDropdown = document.getElementById('ecosistemaDropdown');
    if (maquinaDropdown) {
        // 'show.bs.dropdown' é um evento do Bootstrap disparado quando o menu abre.
        // A opção { once: true } garante que este código execute APENAS UMA VEZ.
        maquinaDropdown.addEventListener('show.bs.dropdown', () => {
            console.log('Pré-carregando imagens do mega menu...');
            
            linksComImagem.forEach(link => {
                const imageUrl = link.dataset.image;
                if (imageUrl) {
                    // A criação do objeto Image() em background faz o navegador
                    // baixar a imagem e guardá-la em cache para uso futuro.
                    const img = new Image();
                    img.src = imageUrl;
                }
            });

        }, { once: true });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Encontra todos os campos de busca que devem ter a funcionalidade AJAX
  const todosOsInputsDeBusca = document.querySelectorAll('.busca-ajax-input');

  // Adiciona a lógica para cada um deles
  todosOsInputsDeBusca.forEach(function(input) {
    const form = input.closest('.form-busca-ajax');
    if (!form) return; // Se não encontrar o formulário pai, não faz nada

    const sugestoes = form.querySelector('.sugestoes-busca-list');
    if (!sugestoes) return; // Se não encontrar a lista de sugestões, não faz nada

    let timeout = null;

    input.addEventListener('input', function() {
      const termo = input.value.trim();
      clearTimeout(timeout);

      if (termo.length < 2) {
        sugestoes.innerHTML = '';
        sugestoes.style.display = 'none';
        return;
      }

      timeout = setTimeout(function() {
        fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=busca_maquinas_sugestao&q=' + encodeURIComponent(termo))
          .then(response => {
            if (!response.ok) {
              throw new Error('Erro de rede ao buscar sugestões.');
            }
            return response.json();
          })
          .then(data => {
            if (data && data.length > 0) {
              sugestoes.innerHTML = data.map((item, idx) => `
                <a href="${item.link}" class="sugestao-item d-flex align-items-center">
                  <span class="sugestao-numero">${idx + 1}</span>
                  <img src="${item.thumb}" alt="${item.nome}" class="sugestao-thumb me-2" width="40" height="40" loading="lazy">
                  <span class="sugestao-nome">${item.nome}</span>
                </a>
              `).join('');
            } else {
              sugestoes.innerHTML = '<div class="sugestao-item">Nenhuma máquina encontrada</div>';
            }
            sugestoes.style.display = 'block';
          })
          .catch(error => {
            console.error('Erro ao buscar sugestões:', error);
            sugestoes.innerHTML = '';
            sugestoes.style.display = 'none';
          });
      }, 300);
    });

    // Evento para fechar a caixa de sugestões ao clicar fora
    document.addEventListener('click', function(e) {
      if (!form.contains(e.target)) {
        sugestoes.style.display = 'none';
      }
    });

  });
});
</script>

<style>
/* --- NOVO LAYOUT PARA SUGESTÕES DE BUSCA --- */

/* Container da lista de sugestões */
.sugestoes-busca-list {
  position: absolute;
  top: 100%;
  left: 0;
  right: 0;
  z-index: 1000;
  background: #fff;
  border: none; /* Cor mais suave */
  max-height: 350px; /* Um pouco mais de altura */
  overflow-y: auto;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1); /* Sombra mais profissional */
  border-radius: 0 0 8px 8px; /* Bordas inferiores arredondadas */
  margin-top: 5px; /* Pequeno espaço do campo de busca */
}

/* Item individual da sugestão */
.sugestao-item {
  display: flex; /* Essencial para o alinhamento */
  align-items: center; /* Alinha verticalmente imagem e texto */
  padding: 10px 15px; /* Mais espaçamento interno */
  cursor: pointer;
  text-decoration: none;
  color: #212529; /* Cor de texto padrão do Bootstrap */
  border-bottom: 1px solid #f1f1f1;
  transition: background-color 0.2s ease-in-out; /* Transição suave */
}

.sugestao-item:last-child {
  border-bottom: none;
}

.sugestao-item:hover {
  background: #f8f9fa; /* Cor de hover suave do Bootstrap */
  color: #0056b3;
}

/* Imagem (thumbnail) da máquina */
.sugestao-thumb {
  width: 60px;   /* Tamanho aumentado */
  height: 60px;  /* Tamanho aumentado */
  min-width: 60px; /* Garante que a imagem não encolha */
  object-fit: cover; /* Garante que a imagem não se distorça */
  border-radius: 6px; /* Bordas levemente arredondadas */
  margin-right: 15px; /* Espaço entre a imagem e o texto */
  background-color: #f0f0f0; /* Cor de fundo enquanto a imagem carrega */
}

/* Span que contém a numeração */
.sugestao-numero {
    margin-right: 8px;
    flex-shrink: 0;
    color: #6c757d;
    border: 2px solid #e3e3e3;
    padding: 10px;
    height: 30px;
    width: 30px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 40px;
    font-size: 12px;
    color: #103b63;
    font-weight: 600;
}

/* Span que contém o nome da máquina - CORRIGIDO */
.sugestao-item .sugestao-nome {
    font-weight: 500;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    color: #000;
}


/* (Opcional) Estilização da barra de rolagem para um look mais limpo */
.sugestoes-busca-list::-webkit-scrollbar {
  width: 6px;
}
.sugestoes-busca-list::-webkit-scrollbar-track {
  background: #f1f1f1;
}
.sugestoes-busca-list::-webkit-scrollbar-thumb {
  background: #ccc;
  border-radius: 6px;
}
.sugestoes-busca-list::-webkit-scrollbar-thumb:hover {
  background: #aaa;
}
</style>