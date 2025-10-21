jQuery(document).ready(function($) {
  $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
      const targetId = $(e.target).attr('href'); // ex: #produtos
      const $target = $(targetId);

      // Ativa loader e esmaece
      $('#loader').fadeIn();
      $target.addClass('tab-loading');

      // Simula carregamento (substitua por seu AJAX real)
      setTimeout(function () {
        $('#loader').fadeOut();
        $target.removeClass('tab-loading');
      }, 1200);
    });
  });

  