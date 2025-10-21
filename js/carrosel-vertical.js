const thumbnails = document.querySelectorAll('.thumbnail-img');
    const mainImage = document.getElementById('mainImage');

    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', () => {
            // Trocar classe ativa
            thumbnails.forEach(img => img.classList.remove('active'));
            thumb.classList.add('active');

            // Efeito de fade e troca
            mainImage.style.opacity = 0;
            setTimeout(() => {
                mainImage.src = thumb.dataset.large;
                mainImage.style.opacity = 1;
            }, 200);
        });
    });



    