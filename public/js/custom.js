(function( $ ) {
    "use strict";

    $(function() {
        $.validator.setDefaults({
            errorClass: 'text-danger',
            ignore: ":hidden:not(select)",
            highlight: function(element) {
              $(element)
                .closest('.form-control')
                .addClass('is-invalid');
            },
            unhighlight: function(element) {
              $(element)
                .closest('.form-control')
                .removeClass('is-invalid');
            },
            errorPlacement: function (error, element) {
              if (element.prop('type') === 'checkbox') {
                error.insertAfter(element.parent());
              } else {
                error.insertAfter(element);
              }
            }
        });
    });
  
}(jQuery));
