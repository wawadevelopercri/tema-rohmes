document.addEventListener('DOMContentLoaded', function () {
    const thumbnails = document.querySelectorAll('.thumbnail-img');
    const mainImage = document.getElementById('mainImage');
    const imageZoomModalElement = document.getElementById('imageZoomModal');

    // Manipulador de clique para as miniaturas (nenhuma mudança aqui)
    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', function () {
            thumbnails.forEach(img => img.classList.remove('active'));
            this.classList.add('active');

            const newLargeImageSrc = this.dataset.large;

            if (mainImage && mainImage.src !== newLargeImageSrc) {
                mainImage.style.transition = 'opacity 0.2s ease-in-out';
                mainImage.style.opacity = 0;

                setTimeout(() => {
                    mainImage.src = newLargeImageSrc;
                    mainImage.alt = this.alt.replace("Miniatura", "Imagem");
                    mainImage.style.opacity = 1;
                }, 200);
            }
        });
    });

    // Manipulador de evento do modal (aqui está a nova lógica)
    if (imageZoomModalElement) {
        imageZoomModalElement.addEventListener('show.bs.modal', function (event) {
            // event.relatedTarget agora é o link <a> que acionou o modal.
            const triggerLink = event.relatedTarget;
            
            // Encontramos a imagem que está DENTRO do link.
            const imageToZoom = triggerLink.querySelector('img');

            // Pegamos o elemento da imagem do modal.
            const modalImage = document.getElementById('modalZoomImage');

            if (imageToZoom && modalImage) {
                // Usamos a URL da imagem encontrada dentro do link.
                modalImage.src = imageToZoom.getAttribute('src');
                modalImage.alt = (imageToZoom.getAttribute('alt') || 'Imagem Principal') + " - Ampliada";
            } else {
                console.error('Erro: Não foi possível encontrar a imagem para ampliar dentro do link.');
            }
        });
    } else {
        console.error('Erro: Elemento do modal (imageZoomModal) não foi encontrado.');
    }
});