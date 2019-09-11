(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "order";
        var disabled = ($('#auth').val()==='R'?'disabled':'');

        $.post(module+"/xhrSearch", { orddate: $("#orddate").val() }, function(o) {
            var sumPrice = 0;

            for (var i=0; i<o.length; i++) {
                $("#qty"+o[i].item).removeAttr("disabled");
                $("#qty"+o[i].item).val(o[i].qty);
                $("#chkOrder"+o[i].item).prop('checked', true);
                $('#price'+o[i].item).removeAttr("disabled");
                sumPrice = sumPrice+(o[i].qty*o[i].price);
                $("#desc"+o[i].item).css('color', 'red');

            }
            $('#sumprice').text(sumPrice);
            
        }, 'json');

        $('input[name="items[]"').click(function(){

            let sumPrice = parseInt($('#sumprice').text());
            let qtyObj = $("#qty"+$(this).val());
            let priceObj = $("#price"+$(this).val());
            let descObj = $("#desc"+$(this).val());
            let price = (isEmpty(priceObj.val())?0:parseInt(priceObj.val()));

            if ($(this).is(":checked")) {
                qtyObj.val("1");
                qtyObj.removeAttr("disabled");
                priceObj.removeAttr("disabled");
                descObj.css('color', 'red');
                $('#sumprice').text(sumPrice + price);
            } else {
                $('#sumprice').text(sumPrice - (qtyObj.val()*price));
                qtyObj.val("");
                qtyObj.attr("disabled", "disabled");
                priceObj.attr("disabled", "disabled");
                descObj.css('color', '');
            }
        });
        
        $('.field').on('focusin', function(){
            $(this).data('val', $(this).val());
        });

        $('.field').on('change', function(){
            let prevQty = $(this).data('val');
            let currentQty = $(this).val();
            let price = $("#price"+$(this).attr("id").substring(3,6)).val();
            price = (isEmpty(price)?0:price);

            $('#sumprice').text(parseInt($('#sumprice').text())+((parseInt(currentQty)-parseInt(prevQty))*price));
        });

        function searchOrder() {

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

            $.post(module+"/xhrSearch", { orddate: $("#orddate").val() }, function(o) {
                var sumPrice = 0;
                $(".itemname").css('color','');
                
                for (var i=0; i<o.length; i++) {
                    // console.log(o[i].item+'  '+o[i].qty);
                    if (diffDays <= 0) {
                        $("#qty"+o[i].item).removeAttr("disabled");
                        $('#price'+o[i].item).removeAttr("disabled");
                    }

                    $("#qty"+o[i].item).val(o[i].qty);
                    $("#chkOrder"+o[i].item).prop('checked', true); 
                    $("#desc"+o[i].item).css('color', 'red');
                    sumPrice = sumPrice+(o[i].qty*o[i].price);                    
                }
                $('#sumprice').text(sumPrice);
                
            }, 'json');

        };

        $("#orddate").focusout(function() {
            searchOrder();
            return false;
        });

        $("#search").click(function(){
            searchOrder();
            return false;
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

  function isEmpty(value) {
    return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
  }