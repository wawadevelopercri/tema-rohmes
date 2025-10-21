document.addEventListener('DOMContentLoaded', function() {

    // --- LÓGICA DO MENU STICKY/FLUTUANTE ---
    // !!! IMPORTANTE: Troque '.your-menu-selector' pelo seletor CSS real do seu menu (ex: '#header', '.main-nav').
    const menu = document.querySelector('.your-menu-selector');

    if (menu) {
        let lastScrollTop = 0;
        // Define um limite de rolagem (altura do menu ou um valor padrão) para o menu aparecer.
        const scrollThreshold = menu.offsetHeight > 0 ? menu.offsetHeight : 100;

        const handleScroll = () => {
            // Desativa a funcionalidade em telas menores (geralmente tablets e celulares)
            /*if (window.innerWidth <= 1024) {
                menu.classList.remove('menu-fixed', 'menu-visible');
                return;
            }*/

            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            // 1. Se o usuário rolar para baixo além do limite, esconde o menu.
            if (scrollTop > lastScrollTop && scrollTop > scrollThreshold) {
                menu.classList.remove('menu-visible');
            }
            // 2. Se o usuário rolar para cima, mostra o menu.
            else if (scrollTop < lastScrollTop) {
                menu.classList.add('menu-visible');
            }

            // Garante que o menu esteja fixo apenas após o limite de rolagem ser ultrapassado.
            if (scrollTop > scrollThreshold) {
                menu.classList.add('menu-fixed');
            } else {
                menu.classList.remove('menu-fixed', 'menu-visible');
            }
            
            // Atualiza a última posição de rolagem.
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        };
        
        // Adiciona os "escutadores" de eventos de forma eficiente.
        window.addEventListener('scroll', handleScroll, { passive: true });
        window.addEventListener('resize', handleScroll);

        // Executa a função uma vez no carregamento para definir o estado inicial.
        handleScroll();

    } else {
        // Aviso no console caso o seletor do menu não seja encontrado.
        console.warn('Elemento do menu com o seletor ".your-menu-selector" não foi encontrado.');
    }


    // --- LÓGICA DO CARROSSEL SWIPER ---
    // Verifica se o elemento do carrossel existe na página antes de inicializar.
    const swiperContainer = document.querySelector('.clientes-swiper');
    
    if (swiperContainer) {
        const swiper = new Swiper(swiperContainer, {
            // Configurações Padrão (para telas maiores)
            slidesPerView: 4,
            spaceBetween: 30,
            loop: true,
            speed: 1000,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            
            // Breakpoints (mobile-first: do menor para o maior)
            breakpoints: {
                // quando a tela for >= 320px
                320: {
                    slidesPerView: 2,
                    spaceBetween: 10
                },
                // quando a tela for >= 576px
                576: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                // quando a tela for >= 768px
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30
                },
                // quando a tela for >= 1024px
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 30
                }
            }
        });
    }

});


const swiper = new Swiper('.categoriaSwiper', {
  // Configurações para Desktop (maior que 768px)
  slidesPerView: 3,
  spaceBetween: 30,
  loop: true,

  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },

  // --- Breakpoints Responsivos ---
  breakpoints: {
    // Para tablets e celulares na horizontal (de 577px até 768px)
    768: {
      slidesPerView: 2, // Exemplo: Mostrar 2 slides
      spaceBetween: 20
    },

    // Para celulares na vertical (telas de até 576px)
    576: {
      slidesPerView: 1, // Mostrar apenas 1 slide
      spaceBetween: 15 // Menos espaço entre os slides
    }
    
    // Você pode até adicionar um breakpoint para telas muito pequenas
    // 320: { ... }
  }
});
new Swiper('.categoriaSwiper', {
    slidesPerView: 1,
    spaceBetween: 20,
    loop: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    breakpoints: {
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 3,
      },
      480: {
        slidesPerView: 2,
      }
    }
  });


  

  
  