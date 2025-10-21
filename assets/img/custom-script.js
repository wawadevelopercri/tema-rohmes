// --- LÓGICA DO PRELOADER (CÓDIGO ADICIONADO) ---
// Este script aguarda o carregamento COMPLETO da página (vídeo, imagens, etc.)
window.addEventListener('load', () => {
  const preloader = document.querySelector('.logo-loader');
  const body = document.querySelector('body');

  if (preloader) {
    // Adiciona a classe 'hidden' para ativar a transição de desaparecimento do CSS
    preloader.classList.add('hidden');
    
    // Libera o scroll da página que foi bloqueado com a classe 'loading'
    if (body) {
      body.classList.remove('loading');
    }
  }
});


// --- SEUS SCRIPTS ORIGINAIS ABAIXO ---

document.addEventListener('DOMContentLoaded', function() {

    // --- LÓGICA DO MENU STICKY/FLUTUANTE ---
    // !!! IMPORTANTE: Troque '.your-menu-selector' pelo seletor CSS real do seu menu (ex: '#header', '.main-nav').
    const menu = document.querySelector('.your-menu-selector');

    if (menu) {
        let lastScrollTop = 0;
        const scrollThreshold = menu.offsetHeight > 0 ? menu.offsetHeight : 100;

        const handleScroll = () => {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop && scrollTop > scrollThreshold) {
                menu.classList.remove('menu-visible');
            } else if (scrollTop < lastScrollTop) {
                menu.classList.add('menu-visible');
            }

            if (scrollTop > scrollThreshold) {
                menu.classList.add('menu-fixed');
            } else {
                menu.classList.remove('menu-fixed', 'menu-visible');
            }
            
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
        };
        
        window.addEventListener('scroll', handleScroll, { passive: true });
        window.addEventListener('resize', handleScroll);
        handleScroll();

    } else {
        console.warn('Elemento do menu com o seletor ".your-menu-selector" não foi encontrado.');
    }
});


const slideElements = document.querySelectorAll('.categoria-slide');
const slideTitles = Array.from(slideElements).map(slide => slide.dataset.title || '');

const swiper = new Swiper('.categoriaSwiper', {
  spaceBetween: 30,
  loop: true,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
    renderBullet: function (index, className) {
      const title = slideTitles[index];
      return `<span class="${className}" data-tooltip="${title}"></span>`;
    },
  },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  breakpoints: {
    320: { slidesPerView: 1, spaceBetween: 20 },
    768: { slidesPerView: 2, spaceBetween: 30 },
    1024: { slidesPerView: 4, spaceBetween: 30 }
  },
});


const clientesSwiper = new Swiper(".clientes-swiper", {
  slidesPerView: 2,
  spaceBetween: 30,
  speed: 8000,
  autoplay: {
    delay: 0,
    disableOnInteraction: false
  },
  loop: false,
  freeMode: true,
  freeModeMomentum: false,
  allowTouchMove: false,
  grabCursor: false,
  breakpoints: {
    576: { slidesPerView: 3 },
    768: { slidesPerView: 4 },
    1024: { slidesPerView: 5 },
    1200: { slidesPerView: 6 }
  }
});


document.addEventListener('DOMContentLoaded', function () {
  
  // CORREÇÃO: Removi uma função 'renderBullet' duplicada que estava aqui.
  const nossosClientesSwiper = new Swiper('.nossos-clientes-swiper', {
    loop: true,
    spaceBetween: 25,
    pagination: {
      el: '.swiper-pagination-nossos-clientes',
      clickable: true,
        renderBullet: function (index, className) {
          const fraseDoTooltip = frasesDosClientes[index] || '';
          return `<span class="${className} has-tooltip" data-tooltip="${fraseDoTooltip}"></span>`;
        },
    },
    breakpoints: {
      320: { slidesPerView: 1, spaceBetween: 15 },
      768: { slidesPerView: 2, spaceBetween: 20 },
      992: { slidesPerView: 2, spaceBetween: 25 }
    }
  });

});


document.addEventListener("DOMContentLoaded", function () {
  const dropdowns = document.querySelectorAll('.nav-item.dropdown');

  dropdowns.forEach(dropdown => {
    const trigger = dropdown.querySelector('.dropdown-toggle');
    const menu = dropdown.querySelector('.dropdown-menu');
    let closeMenuTimeout;

    if (!trigger || !menu) return;

    const openMenu = () => {
      document.querySelectorAll('.nav-item.dropdown.show').forEach(el => {
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

    trigger.addEventListener('click', function (e) {
      if (window.innerWidth > 992) return;
      e.preventDefault();
      e.stopPropagation();
      const isOpen = dropdown.classList.contains('show');
      document.querySelectorAll('.nav-item.dropdown').forEach(d => {
        d.classList.remove('show');
        d.querySelector('.dropdown-menu')?.classList.remove('show-animated');
      });
      if (!isOpen) {
        dropdown.classList.add('show');
        menu.classList.add('show-animated');
      }
    });
  });

  document.addEventListener('click', function (e) {
    if (window.innerWidth <= 992) {
      const isInside = e.target.closest('.nav-item.dropdown');
      if (!isInside) {
        document.querySelectorAll('.nav-item.dropdown').forEach(d => {
          d.classList.remove('show');
          d.querySelector('.dropdown-menu')?.classList.remove('show-animated');
        });
      }
    }
  });
});


jQuery(document).ready(function($) {
    const imagemPreview = $('#imagem-categoria-hover');
    const imagemOriginal = imagemPreview.attr('src');

    function trocarImagem(novaImagem) {
        imagemPreview.addClass('fade-out').removeClass('fade-in');
        setTimeout(() => {
            imagemPreview.attr('src', novaImagem);
            imagemPreview.removeClass('fade-out').addClass('fade-in');
        }, 100);
    }

    $('.mega-dropdown .dropdown-item').on('mouseenter', function() {
        const novaImagem = $(this).data('image');
        if (novaImagem && imagemPreview.attr('src') !== novaImagem) {
            trocarImagem(novaImagem);
        }
    });

    $('.mega-dropdown').on('mouseleave', function() {
        if (imagemPreview.attr('src') !== imagemOriginal) {
            trocarImagem(imagemOriginal);
        }
    });
});


document.addEventListener('DOMContentLoaded', () => {
  const backToTopButton = document.querySelector('.topo-fixo');

  if (backToTopButton) {
    window.addEventListener('scroll', () => {
      if (window.scrollY > 200) {
        backToTopButton.classList.add('show');
      } else {
        backToTopButton.classList.remove('show');
      }
    });

    backToTopButton.addEventListener('click', (event) => {
      event.preventDefault();
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });
  }
});