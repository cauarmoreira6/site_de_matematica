document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-confirm]').forEach(function (elemento) {
        elemento.addEventListener('click', function (evento) {
            if (!confirm(elemento.dataset.confirm)) evento.preventDefault();
        });
    });
});
