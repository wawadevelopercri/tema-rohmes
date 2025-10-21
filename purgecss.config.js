// Use 'export default' em vez de 'module.exports'
export default {
  css: ['style.css'],
  content: ['./**/*.php', './**/*.js'],
  output: './css-limpo/style.min.css',
  safelist: {
    greedy: [
      /swiper/, 
      /dropdown/, 
      /nav/, 
      /menu/, 
      /breadcrumb/, 
      /bi-/
    ]
  }
}