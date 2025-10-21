// Criar o observador para verificar quando as seções entram na tela
const observer = new IntersectionObserver((entries, observer) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible'); // Adiciona a classe 'visible' para a animação
      observer.unobserve(entry.target); // Para de observar a seção após ela aparecer
    }
  });
}, {
  threshold: 0.5 // O quanto da seção precisa estar visível para disparar a animação
});

// Seleciona todas as seções
const sections = document.querySelectorAll('.fade-section');

// Começa a observar cada uma das seções
sections.forEach(section => {
  observer.observe(section);
});






jQuery(document).ready(function($) {
    $('.navbar-toggler').on('click', function () {
      var target = $('#navbarNavDropdown');
      if (target.hasClass('show')) {
        target.collapse('hide');
      } else {
        target.collapse('show');
      }
    });
  });


document.addEventListener("DOMContentLoaded", function() {
  const domContentLoadedTime = Date.now();
  const loader = document.querySelector('.logo-loader');

  if (!loader) {
    console.error('Elemento do logo loader não encontrado.');
    return;
  }

  const svg = loader.querySelector('svg');
  if (!svg) {
    console.error('Elemento SVG dentro do logo loader não encontrado.');
    loader.style.display = 'none';
    return;
  }

  const paths = svg.querySelectorAll('path');
  if (paths.length === 0) {
    console.error('Nenhum path encontrado no SVG para a animação do loader.');
    loader.style.display = 'none';
    return;
  }

  loader.classList.add('active');

  // 2. Prepara os paths para a animação - ESTADO INICIAL CORRETO
  paths.forEach(path => {
    const length = path.getTotalLength();
    path.style.strokeDasharray = length;
    path.style.strokeDashoffset = length; // <<< IMPORTANTE: Começa "invisível"
    path.style.fill = 'none';             // <<< IMPORTANTE: Sem preenchimento inicial
    
    // Certifique-se de que há uma cor de traço e espessura definidas
    // Você pode definir isso no CSS ou aqui, se necessário. Exemplo:
    // path.style.stroke = '#000000'; // Cor do traço que será desenhado
    // path.style.strokeWidth = '1px'; // Espessura do traço
  });

  // 3. Inicia a animação de desenho
  // Usar requestAnimationFrame é mais robusto para garantir que os estilos iniciais
  // sejam aplicados antes da transição começar.
  requestAnimationFrame(() => {
    requestAnimationFrame(() => { // Segunda chamada para garantir que a transição ocorra no próximo quadro
      paths.forEach(path => {
        path.style.strokeDashoffset = '0'; // Inicia a animação de "desenhar"
      });
    });
  });

  // Defina as durações das fases da sua animação aqui, baseadas no seu CSS ou intenção.
  const fillAnimationStartTime = 2100;
  const fillAnimationCssDuration = 500;
  const minLogoAnimationTime = fillAnimationStartTime + fillAnimationCssDuration;

  // 4. Inicia a animação de preenchimento
  setTimeout(() => {
    paths.forEach(path => {
      path.classList.add('filled'); // Adiciona a classe que aplica o fill: 'black'
                                     // Certifique-se que o CSS para .filled tenha a transição de fill.
    });
  }, fillAnimationStartTime);

  function hideLoaderWithAnimation() {
    const fadeOutCssDuration = 500;
    if (loader) {
        loader.style.opacity = '0';
        setTimeout(() => {
            loader.style.display = 'none';
        }, fadeOutCssDuration);
    }
  }

  window.addEventListener('load', function() {
    const timeSinceDomReady = Date.now() - domContentLoadedTime;
    const remainingAnimationDisplayTime = minLogoAnimationTime - timeSinceDomReady;

    if (remainingAnimationDisplayTime > 0) {
      setTimeout(hideLoaderWithAnimation, remainingAnimationDisplayTime);
    } else {
      hideLoaderWithAnimation();
    }
  });
});