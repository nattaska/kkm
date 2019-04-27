(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "checkin";    
        var arrEmp;    
    
        $('#loader').show();
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
            $('#loader').hide();
        }, 'json');
        
        $("#clocked").submit(function(e) {
            e.preventDefault();
            $('#loader').show();
        }).validate({
            rules: {
                phone: {
                    required: true,
                    minlength: 10
                }
            },
            // Specify validation error messages
            messages: {
                phone: {
                    required: "Please enter your phone number",
                    minlength: "Your phone must be at least 10 characters long"
                }
            },
            submitHandler: function(form) {
                var url = $(form).attr('action');
                var data = $(form).serialize();

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
                    $('#loader').hide();
                } else {
    
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
                        $('#loader').hide();
                        // $('#loader').hide();
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
                    }, 'json');
                }
                // $('#loader').hide();
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

                return false;  //This doesn't prevent the form from submitting.
            }
        });

        
        // $("#clocked").submit(function(e) {
        //     e.preventDefault();
        //     $('#loader').show();

        //     $("#code").val('0');
        //     for (var i=0; i<arrEmp.length; i++) {
        //         if ($("#phone").val() == arrEmp[i].phone) {
        //             // console.log(arrEmp[i]);
        //             $("#code").val(arrEmp[i].code);
        //             (arrEmp[i].timin === '-')?$("#clocktype").val('in'):$("#clocktype").val('out');
        //         }
        //     }

        //     if ($("#code").val() === '0') {
        //         $("#msgMain").html('<div class="alert alert-warning"><button type="button" class="close">×</button><strong>Warning!</strong> Phone number does not matched !!!</div>');
        //         // alert("Phone number does not matched !!!");
        //     } else {                

        //         var url = $(this).attr('action');
        //         var data = $(this).serialize();

        //         $.post(url, data, function(oc) {
                    
        //             if (oc.res > 0) {
        //                 $("#msgMain").html('<div class="alert alert-success"><button type="button" class="close">×</button><strong>Success!</strong> Code '+$("#code").val()+' already checked</div>');

        //                 $.post(module+'/xhrSearch', function(o) {
        //                     arrEmp = o;
        //                     $("#listTimeChecked").html("");
        //                     for (var i=0; i<o.length; i++) {
        //                         $('#listTimeChecked').append('<tr>	'
        //                                     +'  <th scope="row">'+o[i].code+'</th> ' 
        //                                     +'  <th>'+o[i].name+'</th> ' 
        //                                     +'  <th>'+o[i].timin+'</th> '
        //                                     +'  <th>'+o[i].timout+'</th> '
        //                                     +'</tr>');
        //                     }
        //                 }, 'json');
        //             } else {
        //                 $("#msgMain").html('<div class="alert alert-danger"><button type="button" class="close">×</button><strong>Error!</strong> '+oc.error+'</div>');
        //             }
        //         }, 'json');
        //     }
        //     $('#loader').hide();
        //     //timing the alert box to close after 5 seconds
        //     window.setTimeout(function () {
        //         $(".alert").fadeTo(500, 0).slideUp(500, function () {
        //             $(this).remove();
        //         });
        //     }, 5000);
    
        //     //Adding a click event to the 'x' button to close immediately
        //     $('.alert .close').on("click", function (e) {
        //         $(this).parent().fadeTo(500, 0).slideUp(500);
        //     }); 

        //     return false;
        // });

    });
  
  }(jQuery));
