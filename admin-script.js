document.addEventListener('DOMContentLoaded', function () {
    const categoriaSelect = document.getElementById('categoria_select');
    const gruposCampos = document.querySelectorAll('.categoria-campos');

    function mostrarCamposDaCategoria(idCategoria) {
        gruposCampos.forEach(grupo => {
            grupo.style.display = grupo.getAttribute('data-categoria') === idCategoria ? 'contents' : 'none';
        });
    }

    if (categoriaSelect) {
        categoriaSelect.addEventListener('change', function () {
            mostrarCamposDaCategoria(this.value);
        });

        // Exibir o correto se houver valor no carregamento
        if (categoriaSelect.value) {
            mostrarCamposDaCategoria(categoriaSelect.value);
        }
    }
});