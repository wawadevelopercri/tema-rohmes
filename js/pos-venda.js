/**
 * Arquivo: pos-venda.js
 * Versão Corrigida: 3.1 (Com Paginação na Galeria)
 */

document.addEventListener('DOMContentLoaded', function() {

    // Carrossel SUPERIOR (Galeria de Treinamentos)
    new Swiper('.mySwiper-galeria', {
        loop: true,
        slidesPerView: 3,
        spaceBetween: 30,
        navigation: {
            nextEl: '.swiper-button-next-galeria',
            prevEl: '.swiper-button-prev-galeria',
        },
        // ===== PAGINAÇÃO ADICIONADA AQUI =====
        pagination: {
            el: '.swiper-pagination-galeria', // Aponta para o novo <div> no seu PHP
            clickable: true,                  // Permite clicar nos "dots"
        },
        breakpoints: { 320: { slidesPerView: 1 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
    });

    // Carrossel INFERIOR (Provas Sociais - COM TOOLTIPS)
    new Swiper('.mySwiper-posvenda', {
        loop: true,
        spaceBetween: 25,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination-posvenda',
            clickable: true,
            // ===== LÓGICA DO TOOLTIP RESTAURADA AQUI =====
            renderBullet: function (index, className) {
                // A variável 'frasesPosVenda' vem do arquivo pos-vendas.php
                if (typeof frasesPosVenda !== 'undefined' && frasesPosVenda[index]) {
                    const nomeCliente = frasesPosVenda[index];
                    return `<span class="${className}" data-tooltip="${nomeCliente}"></span>`;
                }
                return `<span class="${className}"></span>`; // Fallback sem tooltip
            },
        },
        breakpoints: { 320: { slidesPerView: 1 }, 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
    });

    // Animações de Scroll e Parallax
    const fadeInSection = document.querySelector('.fade-in-section');
    if (fadeInSection) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1 });
        observer.observe(fadeInSection);
    }

    const parallaxBg = document.querySelector('.parallax-bg');
    if (parallaxBg) {
        window.addEventListener('scroll', function() {
            parallaxBg.style.transform = 'translateY(' + window.pageYOffset * 0.3 + 'px)';
        });
    }
});