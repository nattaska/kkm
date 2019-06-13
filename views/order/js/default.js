(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "order";
        var disabled = ($('#auth').val()==='R'?'disabled':'');

        $.post("order/xhrSearch", { orddate: $("#orddate").val() }, function(o) {
            
            for (var i=0; i<o.length; i++) {
                $("#qty"+o[i].item).removeAttr("disabled");
                $("#qty"+o[i].item).val(o[i].qty);
                $("#chkOrder"+o[i].item).prop('checked', true); 
            }
            
        }, 'json');

        $('input[name="items[]"').click(function(){
            // alert("Checked"+$(this).val());
            if ($(this).is(":checked")) {
                $("#qty"+$(this).val()).removeAttr("disabled");
                // $("#qty"+$(this).val()).focus();
                $("#qty"+$(this).val()).val("1");
            } else {
                $("#qty"+$(this).val()).val("");
                $("#qty"+$(this).val()).attr("disabled", "disabled");
            }
        });

        $("#orddate").focusout(function() {

            var nowTime = new Date($("#current_date").val()).toLocaleString("en-US", {timeZone: "Asia/Bangkok"});
            nowTime = new Date(nowTime);
            var orddate = new Date($("#orddate").val()).toLocaleString("en-US", {timeZone: "Asia/Bangkok"});
            orddate =  new Date(orddate);
            
            var diffDays =  Math.ceil((nowTime.getTime() - orddate.getTime()) / (1000 * 3600 * 24));

            $("#prtdate").val($("#orddate").val());
            $("#prtexceldate").val($("#orddate").val());
            
            $('input[type="checkbox"]').prop('checked', false); 
            $('input[type="text"]').val(''); 
            $('input[type="text"]').attr("disabled", "disabled");

            if (diffDays > 0) {
                $('input[type="checkbox"]').attr('disabled','disabled');
                $("#save").attr('disabled','disabled');
            } else {
                $('input[type="checkbox"]').removeAttr("disabled");
                $("#save").removeAttr("disabled");
            }

            $.post("order/xhrSearch", { orddate: $("#orddate").val() }, function(o) {
                
                for (var i=0; i<o.length; i++) {
                    // console.log(o[i].item+'  '+o[i].qty);
                    if (diffDays <= 0) {
                        $("#qty"+o[i].item).removeAttr("disabled");
                    }
                    $("#qty"+o[i].item).val(o[i].qty);
                    $("#chkOrder"+o[i].item).prop('checked', true); 
                }
                
            }, 'json');

        });

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
