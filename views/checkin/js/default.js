(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "checkin";    
        var arrEmp;    
    
        $.post(module+"/xhrSearch", function(o) {
            arrEmp = o;
            // $("#listTimesheet").html("");
            for (var i=0; i<o.length; i++) {
                $('#listTimeChecked').append('<tr>	'
                            +'  <th scope="row">'+o[i].code+'</th> ' 
                            +'  <th>'+o[i].name+'</th> ' 
                            +'  <th>'+o[i].timin+'</th> '
                            +'  <th>'+o[i].timout+'</th> '
                            +'</tr>');
            }
        }, 'json');
        
        $("#phone").change(function(){
            // alert($("#phone").val());
            $("#code").val('0');
            for (var i=0; i<arrEmp.length; i++) {
                if ($("#phone").val() == arrEmp[i].phone) {
                    $("#code").val(arrEmp[i].code);
                    (arrEmp[i].timin === '-')?$("#clocktype").val('in'):$("#clocktype").val('out');
                }
            }

            if ($("#code").val() === '0') {
                alert("Phone number does not matched !!!");
            }
            // this.form.submit();
        });

        $("#clocked").submit(function() {
            var url = $(this).attr('action');
            var data = $(this).serialize();

            console.log(url);
            console.log(data);
    
            $.post(url, data, function(o) {

                $("#listTimesheet").html("");
                for (var i=0; i<o.length; i++) {
                    $('#listTimesheet').append('<tr>	'
                                +'  <th scope="col">'+o[i].date+'</th> ' 
                                +'  <th scope="col">'+o[i].chkin+'</th> '
                                +'  <th scope="col">'+o[i].chkout+'</th> '
                                +'</tr>');
                }
            }, 'json');
    

            return false;
        });

    });
  
  }(jQuery));
