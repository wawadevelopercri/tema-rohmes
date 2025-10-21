// vite.config.js
import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    // Define o diretório de saída para os arquivos compilados
    outDir: 'dist',

    // Gera um manifest.json para facilitar a integração com o WordPress
    manifest: true,

    rollupOptions: {
      // Define os pontos de entrada (seus arquivos principais de CSS e JS)
      input: {
        main: './assets/css/main.css', // Seu CSS principal
        // Se você tiver um JS principal, descomente a linha abaixo
        // app: './assets/js/main.js',
      },
      output: {
        // Garante que os nomes dos arquivos de saída sejam previsíveis
        entryFileNames: `assets/[name].js`,
        chunkFileNames: `assets/[name].js`,
        assetFileNames: `assets/[name].[ext]`
      }
    },
  },
});