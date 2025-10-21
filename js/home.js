document.addEventListener('DOMContentLoaded', function() {
    // --- INÍCIO DO CÓDIGO UNIFICADO PARA ANIMAÇÃO DO MAPA ---

    // Seleciona todos os elementos que vamos animar
    const mapaArea = document.getElementById('mapa-area');
    const mapaBrasil = document.getElementById('mapa-brasil');
    const pontosSede = document.querySelectorAll('.sede-ponto');
    const counterProjetos = document.getElementById('counter-projetos');
    const counterMaquinas = document.getElementById('counter-maquinas');

    // Se algum dos elementos essenciais não existir, o código não é executado
    if (!mapaArea || !mapaBrasil || !counterProjetos || !counterMaquinas || pontosSede.length === 0) {
        console.warn('Elementos para a animação do mapa estão faltando. A animação não será executada.');
        return;
    }

    // Função para animar os números dos contadores
    function animateCounter(element, endValue, duration) {
        let startValue = 0;
        const increment = endValue / (duration / 16); // ~60fps
        
        const timer = setInterval(() => {
            startValue += increment;
            if (startValue >= endValue) {
                startValue = endValue;
                clearInterval(timer);
            }
            // Garante que o elemento ainda exista antes de tentar atualizar
            if (element) {
                element.innerText = "+" + Math.floor(startValue);
            }
        }, 16);
    }

    // Cria o observador de interseção para a área do mapa
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            // Verifica se a área do mapa está pelo menos 50% visível
            if (entry.isIntersecting) {
                // Executa TODAS as animações uma única vez:
                
                // 1. Anima o mapa do Brasil
                mapaBrasil.classList.add('scale-in');

                // 2. Anima os contadores
                // ===== ALTERAÇÃO AQUI =====
                animateCounter(counterProjetos, 450, 2000); // Duração de 2s
                animateCounter(counterMaquinas, 500, 2000); // Duração de 2s

                // 3. Mostra os pontos no mapa após a animação de 'scaleIn' (que dura 2s)
                setTimeout(() => {
                    pontosSede.forEach(ponto => {
                        ponto.classList.add('pontos-visiveis');
                    });
                }, 2000); // Tempo deve ser igual à duração da animação 'scaleIn'

                // 4. Para de observar o elemento para não repetir a animação
                observer.unobserve(mapaArea);
            }
        });
    }, {
        threshold: 0.5 // Nível de visibilidade para acionar a animação
    });

    // Inicia a observação da área do mapa
    observer.observe(mapaArea);

    // --- FIM DO CÓDIGO UNIFICADO ---
});




  const swiperPromocional = new Swiper('.swiper-promocional', {
    // Efeito de transição principal
    effect: 'fade',
    fadeEffect: {
      crossFade: true // Permite que o slide que sai e o que entra façam o fade ao mesmo tempo
    },

    // Autoplay (troca automática de slides)
    autoplay: {
      delay: 5000, // Tempo em milissegundos (5 segundos)
      disableOnInteraction: false, // Não para o autoplay após interação do usuário
      pauseOnMouseEnter: true, // Pausa ao passar o mouse em cima
    },

    // Loop infinito
    loop: true,

    // Velocidade da transição e efeito de aceleração
    speed: 1200, // Duração da animação em milissegundos (1.2 segundos)
    easing: 'ease-in-out', // Começa e termina devagar, acelera no meio

    // Paginação (as bolinhas)
    pagination: {
      el: '.swiper-pagination',
      clickable: true, // Permite clicar nas bolinhas para navegar
    },

    // Melhora a acessibilidade
    a11y: {
      prevSlideMessage: 'Slide anterior',
      nextSlideMessage: 'Próximo slide',
    },
  });