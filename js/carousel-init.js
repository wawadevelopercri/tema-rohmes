document.addEventListener('DOMContentLoaded', function () {
    // Para teste: Descomente a linha abaixo para verificar no console do navegador se este arquivo está sendo carregado
    // console.log('Arquivo carousel-init.js carregado - Versão Mobile Ajustada');

    if (document.querySelector('.client-logo-carousel')) {
        const swiper = new Swiper('.client-logo-carousel', {
            // Configurações base (para telas maiores ou como fallback)
            slidesPerView: 'auto',
            spaceBetween: 50,

            direction: 'horizontal',
            loop: true,
            speed: 800,
            grabCursor: true,
            centeredSlides: false, // Centralização desativada por padrão global
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            
            // --- BREAKPOINTS REVISADOS PARA MELHOR EXPERIÊNCIA MOBILE ---
            breakpoints: {
                // Para telas com largura ATÉ 767px (cobrindo a maioria dos smartphones e alguns tablets em modo retrato)
                0: { 
                    slidesPerView: 1,       // Mostrar APENAS UM logo por vez
                    spaceBetween: 20,       // Espaçamento menor para telas pequenas
                    centeredSlides: true    // Centralizar o único logo visível
                },
                // Para telas com largura A PARTIR de 768px (tablets em modo paisagem e desktops)
                768: {
                    slidesPerView: 3,       // Mostrar 3 logos (ou 'auto' se preferir que ele calcule)
                    spaceBetween: 40,
                    centeredSlides: false   // Não precisa centralizar com múltiplos slides geralmente
                },
                // Para telas com largura A PARTIR de 992px (desktops maiores)
                992: {
                    slidesPerView: 'auto',  // Volta para o cálculo automático baseado no CSS
                    spaceBetween: 50,
                    centeredSlides: false
                }
            }
        });
    }
});