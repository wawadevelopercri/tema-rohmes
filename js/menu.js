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





document.addEventListener("DOMContentLoaded", function() {
  const loader = document.querySelector('.logo-loader');

  if (!loader) return;

  const svg = loader.querySelector('svg');
  if (!svg) {
    loader.style.display = 'none';
    return;
  }

  const paths = svg.querySelectorAll('path');
  if (!paths.length) {
    loader.style.display = 'none';
    return;
  }

  loader.classList.add('active');

  // Prepara os paths para começar invisível
  paths.forEach(path => {
    const length = path.getTotalLength();
    path.style.transition = 'none';  // remove transição inicial
    path.style.strokeDasharray = length;
    path.style.strokeDashoffset = length;
    path.style.stroke = 'black';
    path.style.strokeWidth = '1';
  });

  // Força reflow para aplicar estado inicial
  void loader.offsetWidth;

  // Agora adiciona transição
  paths.forEach(path => {
    path.style.transition = 'stroke-dashoffset 2s ease-in-out, fill-opacity 0.5s ease-in-out 0.5s';
  });

  // Inicia a animação do traço
  requestAnimationFrame(() => {
    paths.forEach(path => {
      path.style.strokeDashoffset = '0';
    });
  });

  const fillAnimationStartTime = 2100;

  let siteLoaded = false;
  let animationCompleted = false;

  function hideLoaderWithAnimation() {
    const fadeOutCssDuration = 500;
    loader.style.opacity = '0';
    setTimeout(() => {
      loader.style.display = 'none';
    }, fadeOutCssDuration);
  }

  function checkAndHideLoader() {
    if (siteLoaded && animationCompleted) {
      hideLoaderWithAnimation();
    }
  }

  // Preenchimento após o traço
  setTimeout(() => {
    paths.forEach(path => path.classList.add('filled'));
    animationCompleted = true;
    checkAndHideLoader();
  }, fillAnimationStartTime);

  // Quando site carregar
  window.addEventListener('load', function() {
    siteLoaded = true;
    checkAndHideLoader();
  });
});