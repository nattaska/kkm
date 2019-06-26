(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "stock";
        var disabled = ($('#auth').val()==='R'?'disabled':'');
        
        $("#genStock").click(function() {
            $.post($('#url').val()+"stock/xhrPrepareStock", function(o) {
                if (o.res > 0) {
                    $("#msgMain").html('<div class="alert alert-success"><button type="button" class="close">×</button><strong>Success!</strong> Prepare stock successfully</div>');
                    $("#prepare-form").remove();
                } else {
                    $("#msgMain").html('<div class="alert alert-danger"><button type="button" class="close">×</button><strong>Error!</strong> '+o.error+'</div>');
                }
            }, 'json');

            $("#listItems").load(location.href + " #listItems");
        });

        $("#stkDate").focusout(function() {

            var nowTime = new Date($("#current_date").val()).toLocaleString("en-US", {timeZone: "Asia/Bangkok"});
            nowTime = new Date(nowTime);
            var stkDate = new Date($("#stkDate").val()).toLocaleString("en-US", {timeZone: "Asia/Bangkok"});
            stkDate =  new Date(stkDate);
            
            var diffDays =  Math.ceil((nowTime.getTime() - stkDate.getTime()) / (1000 * 3600 * 24));

            $('input[type="number"]').val('');            

            if (diffDays > 0) {
                $('input[type="number"]').attr('disabled','disabled');
                $("#save").attr('disabled','disabled');
            } else if (diffDays === 0) {
                $('input[type="number"]').removeAttr("disabled");
                $("#save").removeAttr("disabled");
            } else {
                $("#stkDate").val($("#current_date").val());
                $('input[type="number"]').removeAttr("disabled");
                $("#save").removeAttr("disabled");
            }

            $.post("../../stock/xhrSearch", { stkDate: $("#stkDate").val() }, function(o) {
                
                for (var i=0; i<o.length; i++) {
                    if ($("#stkType").val() === "out") {
                        $("#"+o[i].code).val(o[i].outqty);
                    } else if($("#stkType").val() === "room") {
                        $("#"+o[i].code).val(o[i].roomqty);
                    }else if($("#stkType").val() === "sys") {
                        $("#"+o[i].code).val(o[i].sysqty);
                    }else if($("#stkType").val() === "adj") {
                        $("#"+o[i].code).val(o[i].adjqty);
                    }
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
