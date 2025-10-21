document.addEventListener('DOMContentLoaded', function() {
    var swiper = new Swiper('.mySwiper', {
        slidesPerView: 1,
        spaceBetween: 15,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        breakpoints: {
            768: { slidesPerView: 2 },
            992: { slidesPerView: 3 }
        },

        // --- ADICIONE ESTAS LINHAS ABAIXO ---
        simulateTouch: true,   // Habilita a simulação de toque para interação com o mouse
        allowTouchMove: true,  // Permite arrastar os slides
        grabCursor: true,      // Muda o cursor para uma "mãozinha" ao passar sobre o carrossel
        // --- FIM DAS LINHAS ADICIONADAS ---
    });
});



