document.addEventListener('DOMContentLoaded', function () {
    const thumbnails = document.querySelectorAll('.thumbnail-img');
    const mainImage = document.getElementById('mainImage'); // CONFIRA ESTE ID NO SEU HTML
    const modalImage = document.getElementById('modalZoomImage'); // CONFIRA ESTE ID NO SEU HTML (dentro do modal)
    const imageZoomModalElement = document.getElementById('imageZoomModal'); // CONFIRA ESTE ID NO SEU HTML (o div do modal)

    // --- Seu código de clique nas miniaturas ---
    // Certifique-se de que esta parte está funcionando e atualizando mainImage.src
    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', function () {
            // Remove a classe 'active' de todas as miniaturas
            thumbnails.forEach(img => img.classList.remove('active'));
            // Adiciona a classe 'active' à miniatura clicada
            this.classList.add('active');

            const newLargeImageSrc = this.dataset.large;
            console.log('Miniatura clicada. Novo src para mainImage:', newLargeImageSrc); // DEBUG

            // Atualiza a imagem principal (com efeito de fade opcional)
            if (mainImage && mainImage.src !== newLargeImageSrc) {
                mainImage.style.transition = 'opacity 0.2s ease-in-out';
                mainImage.style.opacity = 0;

                setTimeout(() => {
                    mainImage.src = newLargeImageSrc;
                    mainImage.alt = this.alt.replace("Miniatura", "Imagem");
                    mainImage.style.opacity = 1;
                    console.log('mainImage.src atualizado para:', mainImage.src); // DEBUG
                }, 200);
            } else if (mainImage) {
                // Se o src for o mesmo, apenas garante que está visível (caso necessário)
                mainImage.src = newLargeImageSrc; // Garante que está definido
                 mainImage.alt = this.alt.replace("Miniatura", "Imagem");
                console.log('mainImage.src já era ou foi redefinido para:', mainImage.src); // DEBUG
            } else {
                console.error('Elemento mainImage não encontrado ao clicar na miniatura!'); // DEBUG
            }
        });
    });
    // --- Fim do código de clique nas miniaturas ---


    // Evento disparado ANTES do modal ser exibido
    if (imageZoomModalElement) {
        imageZoomModalElement.addEventListener('show.bs.modal', function (event) {
            console.log('--- Evento show.bs.modal disparado ---'); // DEBUG

            // Verifica se os elementos mainImage e modalImage existem
            if (!mainImage) {
                console.error('Elemento mainImage (ID: "mainImage") não encontrado!');
                return;
            }
            if (!modalImage) {
                console.error('Elemento modalImage (ID: "modalZoomImage") não encontrado dentro do modal!');
                return;
            }

            console.log('mainImage.src atual ANTES de abrir o modal:', mainImage.src); // DEBUG
            console.log('mainImage.alt atual:', mainImage.alt); // DEBUG

            // Define o src da imagem do modal
            if (mainImage.src && mainImage.src.trim() !== '') {
                modalImage.src = mainImage.src;
                modalImage.alt = (mainImage.alt || 'Imagem Principal') + " - Ampliada";
                console.log('modalImage.src DEFINIDO PARA:', modalImage.src); // DEBUG
            } else {
                console.warn('mainImage.src está vazio ou inválido. A imagem no modal não será carregada.'); // DEBUG
                modalImage.src = ''; // Limpa o src se estiver inválido, para não mostrar imagem quebrada
                modalImage.alt = 'Imagem não disponível';
            }
        });
    } else {
        console.error('Elemento do Modal (ID: "imageZoomModal") não foi encontrado para adicionar o listener.'); // DEBUG
    }
});