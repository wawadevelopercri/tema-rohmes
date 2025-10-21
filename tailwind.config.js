// tailwind.config.js

/** @type {import('tailwindcss').Config} */
export default {
  // Aqui informamos ao Tailwind para escanear todos os arquivos .php e .js
  content: [
    './**/*.php',
    './assets/js/**/*.js',
  ],

  // Aqui listamos as classes que NUNCA devem ser removidas,
  // pois são adicionadas dinamicamente por JavaScript.
  safelist: [
    'active',
    'show',
    'visible',
    'loading',
    'no-scroll',
    {
      pattern: /show-animated/,
    },
    {
      pattern: /scale-in/,
    },
    {
      pattern: /pontos-visiveis/,
    },
    {
        pattern: /menu-visible/,
    },
    {
        pattern: /tab-loading/,
    },
    // Adicione aqui outras classes ou padrões que você precisar
  ],

  theme: {
    extend: {},
  },

  plugins: [],
}