(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "stock";
        var disabled = ($('#auth').val()==='R'?'disabled':'');

        // $.post(module+"/xhrSearchCounting", { countdate: $("#countdate").val() }, function(o) {
            
        //     for (var i=0; i<o.length; i++) {
        //         $("#qty"+o[i].item).removeAttr("disabled");
        //         $("#qty"+o[i].item).val(o[i].qty);
        //         $("#chkOrder"+o[i].item).prop('checked', true); 
        //     }
            
        // }, 'json');

//  ------------    Action Search, Add, Update, Delete  ---------------------   //
            
        $("#save-form").submit(function() {
            var url = $(this).attr('action');
            var data = $(this).serialize();

            $.post(url, data, function(o) {
                // console.log(o.res);
                if (o.res > 0) {
                    $("#msgMain").html('<div class="alert alert-success"><button type="button" class="close">×</button><strong>Success!</strong> Your data has been saved successfully</div>');
                } else {
                    $("#msgMain").html('<div class="alert alert-danger"><button type="button" class="close">×</button><strong>Error!</strong> '+o.error+'</div>');
                }
            }, 'json');
                        
            //timing the alert box to close after 5 seconds
            window.setTimeout(function () {
                $(".alert").fadeTo(500, 0).slideUp(500, function () {
                    $(this).remove();
                });
            }, 5000);

            //Adding a click event to the 'x' button to close immediately
            $('.alert .close').on("click", function (e) {
                $(this).parent().fadeTo(500, 0).slideUp(500);
            });
    
            return false;
        });  // save-form

    });
  
  }(jQuery));
