// --- LÓGICA DO PRELOADER (MÉTODO ROBUSTO SEM OPACIDADE) ---
function initAdvancedPreloader() {
    const preloader = document.querySelector('.logo-loader');
    const body = document.body;
    const svgElements = document.querySelectorAll('.logo-loader svg *');

    if (!preloader || svgElements.length === 0) {
        if (body) body.classList.remove('loading');
        if (preloader) preloader.style.display = 'none';
        return;
    }

    body.classList.add('loading');

    let isLoaded = false;
    window.addEventListener('load', () => {
        isLoaded = true;
    }, { once: true });

    const paths = [];
    svgElements.forEach(element => {
        if (typeof element.getTotalLength === 'function') {
            const length = element.getTotalLength();
            element.style.strokeDasharray = length;
            element.style.strokeDashoffset = length;
            paths.push({ element, length });
        }
    });

    // Ativa o preloader depois de preparar os elementos
   setTimeout(() => {
    preloader.classList.add('active');
}, 0);

    const minAnimationTime = 1000;
    let startTime = null;

    function draw(timestamp) {
        if (!startTime) startTime = timestamp;
        const elapsedTime = timestamp - startTime;
        let progress = elapsedTime / minAnimationTime;
        if (progress > 1) progress = 1;

        paths.forEach(p => {
            p.element.style.strokeDashoffset = p.length * (1 - progress);
        });

        if (progress >= 1 && isLoaded) {
            preloader.classList.remove('active');
            preloader.classList.add('hidden');
            body.classList.remove('loading');
        } else {
            requestAnimationFrame(draw);
        }
    }

    requestAnimationFrame(draw);
}


// --- FUNÇÃO AUXILIAR DE ALTA PERFORMANCE (DEBOUNCE) ---
// Limita a frequência com que uma função pode ser executada. Essencial para eventos como 'scroll'.
function debounce(func, wait = 15) {
    let timeout;
    return function(...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
    };
}


// --- FUNÇÕES DE INICIALIZAÇÃO ---

// --- MENU FIXO TOTALMENTE OTIMIZADO PARA EVITAR REFLOWS ---
function initStickyMenu() {
    const menu = document.querySelector('.your-menu-selector');
    if (!menu) return;

    let lastScrollTop = 0;

    // 1. Usa um elemento "sentinela" para detectar a rolagem de forma performática
    const sentinel = document.createElement('div');
    sentinel.style.position = 'absolute';
    sentinel.style.top = '200px'; // Distância do topo para ativar o menu fixo
    sentinel.style.height = '1px';
    sentinel.style.pointerEvents = 'none'; // Garante que não interfira com cliques
    document.body.prepend(sentinel);

    // 2. IntersectionObserver para a lógica de "Fixar/Soltar" (A mais performática)
    const observer = new IntersectionObserver(([entry]) => {
        // Adiciona a classe .menu-fixed quando o sentinela sai da tela
        menu.classList.toggle('menu-fixed', !entry.isIntersecting);
        // Garante que o menu não fique invisível quando voltar ao topo
        if (entry.isIntersecting) {
            menu.classList.remove('menu-visible');
        }
    });
    observer.observe(sentinel);

    // 3. Listener de Scroll para a lógica de "Mostrar/Esconder" (Otimizado)
    const handleScrollDirection = () => {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        // Só executa a lógica se o menu já estiver fixo
        if (menu.classList.contains('menu-fixed')) {
            if (scrollTop > lastScrollTop) {
                // Rolando para baixo: esconde o menu
                menu.classList.remove('menu-visible');
            } else if (scrollTop < lastScrollTop) {
                // Rolando para cima: mostra o menu
                menu.classList.add('menu-visible');
            }
        }
        lastScrollTop = Math.max(scrollTop, 0);
    };

    // Adiciona o listener otimizado
    window.addEventListener('scroll', handleScrollDirection, { passive: true });
}


function initHeaderSwiper() {
    if (typeof Swiper !== 'undefined' && document.querySelector('.header-swiper')) {
        new Swiper('.header-swiper', {
            loop: true,
            effect: 'fade',
            autoHeight: true, // 🔹 Ajusta automaticamente a altura no slide ativo
            fadeEffect: { crossFade: true },
            autoplay: { delay: 8000, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination-header', clickable: true },
        });
    }
}

function initCategoriaSwiper() {
    if (typeof Swiper !== 'undefined' && document.querySelector('.categoriaSwiper')) {
        const slideElements = document.querySelectorAll('.categoria-slide');
        const slideTitles = Array.from(slideElements).map(slide => slide.dataset.title || '');

        const initSvgPathAnimation = (swiperInstance) => {
            const searchContext = swiperInstance ? swiperInstance.el : document;
            const borderPaths = searchContext.querySelectorAll('.border-path');
            borderPaths.forEach(path => {
                const pathLength = path.getTotalLength();
                path.style.strokeDasharray = pathLength;
                path.style.strokeDashoffset = pathLength;
            });
        };

        new Swiper('.categoriaSwiper', {
            spaceBetween: 30,
            loop: false,
            pagination: {
                el: '.swiper-pagination-categorias',
                clickable: true,
                renderBullet: (index, className) => `<span class="${className}" data-tooltip="${slideTitles[index] || ''}"></span>`,
            },
            navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
            breakpoints: {
                320: { slidesPerView: 1, spaceBetween: 20 },
                768: { slidesPerView: 2, spaceBetween: 30 },
                1024: { slidesPerView: 4, spaceBetween: 30 }
            },
            on: {
                init: (swiper) => setTimeout(() => initSvgPathAnimation(swiper), 100),
                slideChangeTransitionEnd: (swiper) => initSvgPathAnimation(swiper),
            }
        });
    }
}

function initPromocionalSwiper() {
    if (typeof Swiper !== 'undefined' && document.querySelector('.swiper-promocional')) {
        new Swiper('.swiper-promocional', {
            loop: true,
            autoplay: { delay: 6000, disableOnInteraction: false },
            pagination: { el: '.swiper-pagination-promocional', clickable: true },
            effect: 'fade',
            fadeEffect: { crossFade: true },
        });
    }
}

function initNossosClientesSwiper() {
    if (typeof Swiper !== 'undefined' && typeof frasesDosClientes !== 'undefined' && document.querySelector('.nossos-clientes-swiper')) {
        new Swiper('.nossos-clientes-swiper', {
            loop: false,
            spaceBetween: 25,
            pagination: {
                el: '.swiper-pagination-nossos-clientes',
                clickable: true,
                renderBullet: (index, className) => `<span class="${className} has-tooltip" data-tooltip="${frasesDosClientes[index] || ''}"></span>`,
            },
            breakpoints: {
                320: { slidesPerView: 1, spaceBetween: 15 },
                768: { slidesPerView: 2, spaceBetween: 20 },
                992: { slidesPerView: 2, spaceBetween: 25 }
            }
        });
    }
}

// --- FUNÇÃO CORRIGIDA PARA ANIMAÇÃO DOS NÚMEROS E MAPA ---
function initMapaClientesAnimations() {
    // Alteração 1: Observar o contêiner dos números, não o mapa.
    const numerosContainer = document.querySelector('.mapa-clientes .numeros');
    if (!numerosContainer) return;

    const animateCounter = (element, target, duration = 2000) => {
        let start = 0;
        const end = parseInt(target, 10);
        if (isNaN(end)) return;
        const increment = end / (duration / 16); // ~60fps

        const timer = setInterval(() => {
            start += increment;
            if (start >= end) {
                start = end;
                clearInterval(timer);
            }
            if (element) {
                // ===== ALTERAÇÃO AQUI =====
                element.textContent = '+' + Math.floor(start);
            }
        }, 16);
    };

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counterProjetos = document.getElementById('counter-projetos');
                const counterMaquinas = document.getElementById('counter-maquinas');
                const mapaBrasil = document.getElementById('mapa-brasil');
                const sedePontos = document.querySelectorAll('.sede-ponto');

                if (counterProjetos && counterProjetos.textContent === '0') animateCounter(counterProjetos, 450);
                if (counterMaquinas && counterMaquinas.textContent === '0') animateCounter(counterMaquinas, 500);

                if (mapaBrasil) mapaBrasil.classList.add('scale-in');
                if (sedePontos) {
                    setTimeout(() => {
                        sedePontos.forEach(ponto => ponto.classList.add('pontos-visiveis'));
                    }, 600);
                }
                obs.unobserve(entry.target);
            }
        });
    }, { 
        // Alteração 2: Disparar a animação assim que o elemento aparecer (10% visível).
        threshold: 0.1 
    });

    observer.observe(numerosContainer);
}

// --- FUNÇÃO CORRIGIDA PARA O BOTÃO VOLTAR AO TOPO COM PROGRESSO ---
function initBackToTop() {
    const backToTopButton = document.querySelector('.topo-fixo');
    // Seleciona o círculo do SVG que será animado
    const progressCircle = document.querySelector('.topo-fixo .progress-ring__circle');

    if (!backToTopButton || !progressCircle) return;

    // Calcula a circunferência do círculo
    const radius = progressCircle.r.baseVal.value;
    const circumference = 2 * Math.PI * radius;

    // Aplica a circunferência ao estilo do círculo
    progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;
    progressCircle.style.strokeDashoffset = circumference;

    // Função para atualizar o progresso com base na rolagem
    const updateProgress = () => {
        const scrollTop = window.scrollY;
        const docHeight = document.documentElement.scrollHeight;
        const clientHeight = document.documentElement.clientHeight;
        
        // Calcula a porcentagem de rolagem (de 0 a 1)
        const scrollPercent = scrollTop / (docHeight - clientHeight);
        
        // Calcula o novo offset para a borda
        const offset = circumference - scrollPercent * circumference;
        
        // Aplica o novo offset ao círculo
        progressCircle.style.strokeDashoffset = offset;

        // Mostra ou esconde o botão
        backToTopButton.classList.toggle('show', scrollTop > 200);
    };

    // Adiciona o listener de scroll para atualizar o progresso
    window.addEventListener('scroll', updateProgress, { passive: true });

    // Adiciona o listener de clique para rolar suavemente para o topo
    backToTopButton.addEventListener('click', (event) => {
        event.preventDefault();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// --- MENUS DROPDOWN (OTIMIZADO) ---
function initDropdownMenus() {
    // Busca os elementos apenas UMA VEZ e armazena na variável
    const dropdowns = document.querySelectorAll('.nav-item.dropdown');
    if (dropdowns.length === 0) return;

    dropdowns.forEach(dropdown => {
        const trigger = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');
        let closeMenuTimeout;
        if (!trigger || !menu) return;

        const openMenu = () => {
            dropdowns.forEach(el => {
                if (el !== dropdown) {
                    el.classList.remove('show');
                    el.querySelector('.dropdown-menu')?.classList.remove('show-animated');
                }
            });
            dropdown.classList.add('show');
            menu.classList.add('show-animated');
        };
        const closeMenu = () => {
            dropdown.classList.remove('show');
            menu.classList.remove('show-animated');
        };

        // Desktop
        dropdown.addEventListener('mouseenter', () => {
            if (window.innerWidth > 992) {
                clearTimeout(closeMenuTimeout);
                openMenu();
            }
        });
        dropdown.addEventListener('mouseleave', () => {
            if (window.innerWidth > 992) {
                closeMenuTimeout = setTimeout(closeMenu, 200);
            }
        });

        // Mobile
        trigger.addEventListener('click', function(e) {
            if (window.innerWidth > 992) return;
            e.preventDefault();
            e.stopPropagation();
            const isOpen = dropdown.classList.contains('show');

            dropdowns.forEach(d => {
                if (d !== dropdown) {
                    d.classList.remove('show');
                    d.querySelector('.dropdown-menu')?.classList.remove('show-animated');
                }
            });

            if (!isOpen) {
                openMenu();
            } else {
                closeMenu();
            }
        });
    });

    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 992 && !e.target.closest('.nav-item.dropdown')) {
            dropdowns.forEach(d => {
                d.classList.remove('show');
                d.querySelector('.dropdown-menu')?.classList.remove('show-animated');
            });
        }
    });
}

function initMegaDropdownImage() {
    const imagemPreview = document.getElementById('imagem-categoria-hover');
    const megaDropdown = document.querySelector('.mega-dropdown');
    const dropdownItems = document.querySelectorAll('.mega-dropdown .dropdown-item');

    if (!imagemPreview || !megaDropdown || dropdownItems.length === 0) {
        return;
    }

    let linkWrapper = imagemPreview.parentElement;
    if (linkWrapper.tagName !== 'A') {
        const newLinkWrapper = document.createElement('a');
        imagemPreview.parentNode.insertBefore(newLinkWrapper, imagemPreview);
        newLinkWrapper.appendChild(imagemPreview);
        linkWrapper = newLinkWrapper;
    }
    linkWrapper.href = '#';

    // --- FUNÇÃO PARA TROCAR IMAGEM (LÓGICA AJUSTADA) ---
    const trocarImagem = (novaImagem, novoLink) => {
        const hasValidImage = novaImagem && novaImagem.trim() !== '';

        if (!hasValidImage) {
            imagemPreview.classList.remove('fade-in');
            imagemPreview.src = ''; // 🔹 Garante que some
            if (linkWrapper) {
                linkWrapper.href = '#';
            }
            return;
        }

        if (imagemPreview.src.endsWith(novaImagem) && imagemPreview.classList.contains('fade-in')) {
            return;
        }

        imagemPreview.classList.remove('fade-in');

        setTimeout(() => {
            imagemPreview.src = novaImagem;
            if (linkWrapper && novoLink) {
                linkWrapper.href = novoLink;
            }
            imagemPreview.classList.add('fade-in');
        }, 150);
    };

    // --- EVENT LISTENERS ---
    dropdownItems.forEach(item => {
        item.addEventListener('mouseenter', function() {
            const novaImagem = this.dataset.image;
            const novoLink = this.getAttribute('href');
            trocarImagem(novaImagem, novoLink);
        });

        // 🔹 NOVO: garante que ao sair de cada item a imagem desaparece
        item.addEventListener('mouseleave', function() {
            trocarImagem('', '#');
        });
    });

    // 🔹 Backup: se sair do container inteiro, também some
    const menuContainer = megaDropdown.closest('.nav-item.dropdown');
    if (menuContainer) {
        menuContainer.addEventListener('mouseleave', () => {
            trocarImagem('', '#');
        });
    }
}


// =============================================================================
//  >>> INÍCIO DO NOVO CÓDIGO: SUGESTÕES DE BUSCA COM AJAX <<<
// =============================================================================
function initAjaxSearch() {
    // Verifica se jQuery está disponível
    if (typeof jQuery === 'undefined') {
        console.error('jQuery não está carregado. A busca AJAX não funcionará.');
        return;
    }

    // Usa o escopo seguro do jQuery
    (function($) {
        const searchInput = $('#s');
        const resultsContainer = $('#sugestoes-busca-resultados');

        // Evento de digitação no campo de busca, usando a função debounce já existente no arquivo
        searchInput.on('keyup', debounce(function() {
            let searchTerm = $(this).val();

            // Só faz a busca se o termo tiver mais de 2 caracteres
            if (searchTerm.length > 2) {
                $.ajax({
                    // A variável `rohmes_ajax` vem do `wp_localize_script` no functions.php
                    url: typeof rohmes_ajax !== 'undefined' ? rohmes_ajax.ajax_url : '',
                    type: 'GET',
                    data: {
                        action: 'busca_maquinas_sugestao', // Ação AJAX definida no functions.php
                        q: searchTerm // O termo da busca
                    },
                    beforeSend: function() {
                        resultsContainer.html('<div class="sugestao-loading">Buscando...</div>').show();
                    },
                    success: function(response) {
                        resultsContainer.html(''); // Limpa resultados anteriores
                        if (response && response.length > 0) {
                            $.each(response, function(index, item) {
                                let suggestionHtml = `
                                    <a href="${item.link}" class="sugestao-item">
                                        <img src="${item.thumb}" alt="${item.nome}" class="sugestao-thumb">
                                        <span class="sugestao-nome">${item.nome}</span>
                                    </a>`;
                                resultsContainer.append(suggestionHtml);
                            });
                        } else {
                            resultsContainer.html('<div class="sugestao-none">Nenhuma máquina encontrada.</div>');
                        }
                        resultsContainer.show();
                    },
                    error: function() {
                        resultsContainer.html('<div class="sugestao-none">Ocorreu um erro na busca.</div>').show();
                    }
                });
            } else {
                resultsContainer.hide().html('');
            }
        }, 300)); // Espera 300ms após o usuário parar de digitar

        // Esconde as sugestões se o usuário clicar fora da busca
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-group, #sugestoes-busca-resultados').length) {
                resultsContainer.hide();
            }
        });
    })(jQuery);
}
// =============================================================================
//  >>> FIM DO NOVO CÓDIGO <<<
// =============================================================================


// --- INICIALIZAÇÃO GERAL ---
// Executa todas as funções quando o DOM inicial estiver pronto.
document.addEventListener('DOMContentLoaded', () => {
    initAdvancedPreloader();
    initStickyMenu();
    initHeaderSwiper();
    initCategoriaSwiper();
    initPromocionalSwiper();
    initNossosClientesSwiper();
    initMapaClientesAnimations();
    initBackToTop();
    initDropdownMenus();
    initMegaDropdownImage();
    initAjaxSearch(); // <<< CHAMADA DA NOVA FUNÇÃO DE BUSCA

    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 900,
            once: true,
            easing: 'ease-out-cubic'
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
  
  // Seleciona todos os contadores que devem ser animados
  const counters = document.querySelectorAll('.product-counter');

  // Configurações do observador
  const observerOptions = {
    root: null, // Observa em relação à viewport do navegador
    rootMargin: '0px',
    threshold: 0.4 // Ativa quando 40% do elemento estiver visível
  };

  // Cria o observador
  const observer = new IntersectionObserver((entries, observer) => {
    entries.forEach(entry => {
      // Se o elemento entrou na viewport
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        // Opcional: para de observar o elemento depois que ele já foi animado
        observer.unobserve(entry.target); 
      }
    });
  }, observerOptions);

  // Inicia a observação para cada contador
  counters.forEach(counter => {
    observer.observe(counter);
  });

});