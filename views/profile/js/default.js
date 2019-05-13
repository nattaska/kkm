

(function( $ ) {
    "use strict";
  
    $(function() {
        $('#paytype0').change(function(){
            $('#account').val("");
            $('#account').attr("disabled","disabled");
        });

        $('#paytype1').change(function(){
            $('#account').val($('#acchide').val());
            $('#account').removeAttr('disabled');
            $('#account').focus();
        });
    });
  
  }(jQuery));