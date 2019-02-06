

(function( $ ) {
    "use strict";
  
    $(function() {
        $('#paytype0').change(function(){
            // alert ( $(this).val() );
            $('#account').val("");
            $('#account').attr("disabled","disabled");
            // $('#account').disabled();
        });

        $('#paytype1').change(function(){
            // alert ( $(this).val() );
            $('#account').val($('#acchide').val());
            $('#account').removeAttr('disabled');
            $('#account').focus();
        });
    });
  
  }(jQuery));