document.addEventListener('DOMContentLoaded', function() {

    // Função para animar os contadores
    function animateCounters() {
        const counters = document.querySelectorAll('.mapa-clientes .counter');
        const speed = 200; // Velocidade da animação

        counters.forEach(counter => {
            const finalValue = +counter.getAttribute('data-final-value');
            
            const updateCount = () => {
                const currentValue = +counter.innerText;
                const increment = Math.ceil(finalValue / speed);

                if (currentValue < finalValue) {
                    counter.innerText = Math.min(currentValue + increment, finalValue);
                    setTimeout(updateCount, 10);
                } else {
                    counter.innerText = finalValue;
                }
            };
            updateCount();
        });
    }

    // Função para ativar as animações do mapa
    function handleMapAnimation(entries, observer) {
        entries.forEach(entry => {
            // Se a área do mapa estiver visível na tela
            if (entry.isIntersecting) {
                const mapaBrasil = document.getElementById('mapa-brasil');
                const pontos = document.querySelectorAll('.sede-ponto');
                
                // Ativa a animação do mapa do Brasil
                if (mapaBrasil) {
                    mapaBrasil.classList.add('scale-in');
                }

                // Torna os pontos visíveis
                setTimeout(() => {
                    pontos.forEach(ponto => ponto.classList.add('pontos-visiveis'));
                }, 1000); // Atraso para os pontos aparecerem depois do mapa

                // Ativa a animação dos contadores
                animateCounters();

                // Para de observar o elemento para não repetir a animação
                observer.unobserve(entry.target);
            }
        });
    }

    // Cria o "observador" que verifica quando o mapa entra na tela
    const mapaArea = document.getElementById('mapa-area');
    if (mapaArea) {
        const observerOptions = {
            root: null, // observa em relação ao viewport
            rootMargin: '0px',
            threshold: 0.4 // Ativa quando 40% do elemento estiver visível
        };
        const observer = new IntersectionObserver(handleMapAnimation, observerOptions);
        observer.observe(mapaArea);
    }
});