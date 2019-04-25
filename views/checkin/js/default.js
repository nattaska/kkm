(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "checkin";    
        var arrEmp;    
    
        $.post(module+"/xhrSearch", function(o) {
            arrEmp = o;
            $("#listTimeChecked").html("");
            for (var i=0; i<o.length; i++) {
                $('#listTimeChecked').append('<tr>	'
                            +'  <th scope="row">'+o[i].code+'</th> ' 
                            +'  <th>'+o[i].name+'</th> ' 
                            +'  <th>'+o[i].timin+'</th> '
                            +'  <th>'+o[i].timout+'</th> '
                            +'</tr>');
            }
        }, 'json');

        $("#clocked").submit(function() {
            
            $("#code").val('0');
            for (var i=0; i<arrEmp.length; i++) {
                if ($("#phone").val() == arrEmp[i].phone) {
                    // console.log(arrEmp[i]);
                    $("#code").val(arrEmp[i].code);
                    (arrEmp[i].timin === '-')?$("#clocktype").val('in'):$("#clocktype").val('out');
                }
            }

            if ($("#code").val() === '0') {
                $("#msgMain").html('<div class="alert alert-warning"><button type="button" class="close">×</button><strong>Warning!</strong> Phone number does not matched !!!</div>');
                // alert("Phone number does not matched !!!");
            } else {                

                var url = $(this).attr('action');
                var data = $(this).serialize();

                $.post(url, data, function(oc) {
                    
                    if (oc.res > 0) {
                        $("#msgMain").html('<div class="alert alert-success"><button type="button" class="close">×</button><strong>Success!</strong> Code '+$("#code").val()+' already checked</div>');

                        $.post(module+'/xhrSearch', function(o) {
                            arrEmp = o;
                            $("#listTimeChecked").html("");
                            for (var i=0; i<o.length; i++) {
                                $('#listTimeChecked').append('<tr>	'
                                            +'  <th scope="row">'+o[i].code+'</th> ' 
                                            +'  <th>'+o[i].name+'</th> ' 
                                            +'  <th>'+o[i].timin+'</th> '
                                            +'  <th>'+o[i].timout+'</th> '
                                            +'</tr>');
                            }
                        }, 'json');
                    } else {
                        $("#msgMain").html('<div class="alert alert-danger"><button type="button" class="close">×</button><strong>Error!</strong> '+oc.error+'</div>');
                    }
                }, 'json');
            }
                    
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
