(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "import";
        var disabled = ($('#auth').val()==='R'?'disabled':'');

        $("#upload-form").submit(function() {

            let fd = new FormData();
            let files = $('#file')[0].files[0];
            fd.append('file',files);
        
            // AJAX request
            $.ajax({
              url: "import/import"+$('#filetype').val(),
              type: 'post',
              dataType: 'json',
              data: fd,
              contentType: false,
              processData: false,
              success: function(o){
                  
                if(o.res > 0){
                  // Show image preview
                    $("#msgMain").html('<div class="alert alert-success"><button type="button" class="close">×</button><strong>Success!</strong> Upload file '+o.error+' successfully</div>');
                    
                }else{
                    $("#msgMain").html('<div class="alert alert-danger"><button type="button" class="close">×</button><strong>Error!</strong> '+o.error+'</div>');
                }
              }
            });
                        
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
        });

    });
  
  }(jQuery));
