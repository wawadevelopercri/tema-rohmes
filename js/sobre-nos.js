document.addEventListener('DOMContentLoaded', function () {
    // --- INÍCIO: CÓDIGO UNIFICADO PARA ANIMAÇÃO DO MAPA (DO HOME.JS) ---

    const mapaArea = document.getElementById('mapa-area');
    if (mapaArea) {
        const mapaBrasil = document.getElementById('mapa-brasil');
        const pontosSede = document.querySelectorAll('.sede-ponto');
        const counterProjetos = document.getElementById('counter-projetos');
        const counterMaquinas = document.getElementById('counter-maquinas');

        // Função para animar os números dos contadores
        function animateCounter(element, endValue, duration) {
            if (!element) return;
            let startValue = 0;
            const increment = endValue / (duration / 16); // ~60fps
            const timer = setInterval(() => {
                startValue += increment;
                if (startValue >= endValue) {
                    startValue = endValue;
                    clearInterval(timer);
                }
                if (element) {
                    element.innerText = "+" + Math.floor(startValue);
                }
            }, 16);
        }

        // Cria o observador de interseção para a área do mapa
        const mapObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                // Verifica se a área do mapa está pelo menos 50% visível
                if (entry.isIntersecting) {
                    // Executa TODAS as animações uma única vez:
                    if (mapaBrasil) mapaBrasil.classList.add('scale-in');
                    
                    // ===== ALTERAÇÃO AQUI =====
                    animateCounter(counterProjetos, 450, 2000); 
                    animateCounter(counterMaquinas, 500, 2000); 

                    setTimeout(() => {
                        pontosSede.forEach(ponto => {
                            ponto.classList.add('pontos-visiveis');
                        });
                    }, 2000);

                    // Para de observar para não repetir a animação
                    mapObserver.unobserve(mapaArea);
                }
            });
        }, {
            threshold: 0.5 // Aciona com 50% de visibilidade
        });

        // Inicia a observação da área do mapa
        mapObserver.observe(mapaArea);
    }
    // --- FIM: CÓDIGO DO MAPA ---


    /* =================================================================== */
    /* == INÍCIO: BLOCO OTIMIZADO PARA ANIMAÇÃO DA TIMELINE AO ROLAR     == */
    /* (Este bloco foi modificado para aguardar o carregamento da imagem)  */
    /* =================================================================== */

    // 1. Seleciona todos os itens da timeline que queremos animar.
    const timelineItems = document.querySelectorAll(".timeline-elegant-item");

    // Verifica se existem itens de timeline na página antes de criar o observador.
    if (timelineItems.length > 0) {
        
        // 2. Define as opções para o observador da timeline.
        const timelineOptions = {
            root: null,
            rootMargin: '0px',
            threshold: 0.15
        };

        // 3. Define a função que será executada quando um item da timeline entrar na tela.
        const handleTimelineIntersection = (entries, observer) => {
            entries.forEach(entry => {
                // Verifica se o item está visível na tela
                if (entry.isIntersecting) {
                    const timelineItem = entry.target;
                    const image = timelineItem.querySelector('.timeline-elegant-image img');

                    // Função que ativa a animação e para de observar o elemento
                    const triggerAnimation = () => {
                        timelineItem.classList.add("is-visible");
                        observer.unobserve(timelineItem);
                    };

                    // Se o card não tiver uma imagem ou se a imagem já estiver carregada,
                    // dispara a animação imediatamente.
                    if (!image || image.complete) {
                        triggerAnimation();
                    } else {
                        // Se a imagem ainda não carregou, adiciona um "ouvinte".
                        // A animação só será disparada quando a imagem terminar de carregar.
                        image.addEventListener('load', triggerAnimation);
                        // Adiciona um listener de erro para o caso de a imagem não carregar.
                        image.addEventListener('error', triggerAnimation);
                    }
                }
            });
        };

        // 4. Cria um novo observador especificamente para a timeline.
        const timelineObserver = new IntersectionObserver(handleTimelineIntersection, timelineOptions);

        // 5. Manda o observador "vigiar" cada um dos itens da timeline.
        timelineItems.forEach(item => {
            timelineObserver.observe(item);
        });
    }
    /* =================================================================== */
    /* == FIM: BLOCO DA TIMELINE                                        == */
    /* =================================================================== */


    // --- INÍCIO: INICIALIZAÇÃO DO SWIPER "NOSSOS CLIENTES" ---
    // Verifica se o elemento swiper existe antes de inicializar
    if (document.querySelector('.nossos-clientes-swiper')) {
        const clientesSwiper = new Swiper('.nossos-clientes-swiper', {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },
            pagination: {
                el: '.swiper-pagination-nossos-clientes',
                clickable: true,
            },
            spaceBetween: 20,
            slidesPerView: 1,
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                992: {
                    slidesPerView: 2,
                    spaceBetween: 30
                }
            },
        });
    }
    // --- FIM: SWIPER ---
});