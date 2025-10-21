document.addEventListener('DOMContentLoaded', function() {
  let animationStarted = false;

  function animateCounter(id, endValue, duration) {
    let startValue = 0;
    let increment = endValue / (duration / 20);
    let obj = document.getElementById(id);
    let counter = setInterval(() => {
      startValue += increment;
      if (startValue >= endValue) {
        startValue = endValue;
        clearInterval(counter);
      }
      obj.innerText = "+" + Math.floor(startValue);
    }, 20);
  }

  function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
      rect.top < window.innerHeight &&
      rect.bottom >= 0
    );
  }

  window.addEventListener('scroll', function() {
    const mapaArea = document.getElementById('mapa-area');
    const mapaBrasil = document.getElementById('mapa-brasil');

    if (isInViewport(mapaArea) && !animationStarted) {
      mapaBrasil.classList.add('scale-in');  // Aplica animação de crescimento e quique
      animateCounter('counter-projetos', 342, 1500);
      animateCounter('counter-maquinas', 100, 1500);
      animationStarted = true;  // Só anima uma vez
    }
  });
});


// Função para verificar a visibilidade do mapa
function checkMapVisibility() {
  const mapaBrasil = document.getElementById('mapa-brasil');
  const mapaArea = document.getElementById('mapa-area');
  const rect = mapaArea.getBoundingClientRect();

  // Verifica se o mapa está visível na tela
  if (rect.top >= 0 && rect.bottom <= window.innerHeight) {
    mapaBrasil.classList.add('scale-up');
  }
}

// Chama a função no carregamento da página
window.addEventListener('load', checkMapVisibility);

// Chama a função a cada scroll
window.addEventListener('scroll', checkMapVisibility);




document.addEventListener('DOMContentLoaded', function() {
  const mapaBrasil = document.getElementById('mapa-brasil');
  const pontosSede = document.querySelectorAll('.sede-ponto');

  if (mapaBrasil && pontosSede.length > 0) {
    // Passo 1: Garantir que a animação do mapa comece.
    // Adiciona a classe 'scale-in' ao mapa do Brasil para iniciar sua animação.
    // Se você já adiciona a classe 'scale-in' de outra forma (ex: ao rolar a página),
    // você pode remover ou ajustar esta linha.
    // Um pequeno timeout pode ajudar se houver problemas de timing com a renderização inicial.
    setTimeout(function() {
        if (!mapaBrasil.classList.contains('scale-in')) {
            mapaBrasil.classList.add('scale-in');
        }
    }, 100); // Adiciona após um pequeno delay

    // Passo 2: Ouvir o fim da animação 'scaleIn' do mapa.
    mapaBrasil.addEventListener('animationend', function(event) {
      // O event.animationName informa qual animação terminou.
      // Queremos agir apenas após a animação 'scaleIn'.
      if (event.animationName === 'scaleIn') {
        // Tornar os pontos visíveis
        pontosSede.forEach(function(ponto) {
          ponto.classList.add('pontos-visiveis');
        });
      }
    });

  } else {
    if (!mapaBrasil) {
      console.warn('Elemento #mapa-brasil não encontrado.');
    }
    if (pontosSede.length === 0) {
      console.warn('Nenhum elemento .sede-ponto encontrado.');
    }
  }
});