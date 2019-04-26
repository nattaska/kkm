// $(function() {
//     alert(1);
    // $('#listTimesheet').append('<div>' + o[i].text + '<a class="del" rel="'+o[i].id+'" href="#">X</a></div>');
    // $('#listTimesheet').append('<tr>	<th scope="col">30/01/2019</th>	<th scope="col">10:05</th>	<th scope="col">23:18</th></tr>');
// });

(function( $ ) {
    "use strict";
  
    $(function() {
    
        $.post("timesheet/xhrGetTimesheet", function(o) {
            
            // $("#listTimesheet").html("");
            for (var i=0; i<o.length; i++) {
                $('#listTimesheet').append('<tr>	'
                            +'  <th scope="col">'+o[i].date+'</th> ' 
                            +'  <th scope="col">'+o[i].chkin+'</th> '
                            +'  <th scope="col">'+o[i].chkout+'</th> '
                            +'</tr>');
            }
        }, 'json');
    
        $.post("timesheet/xhrGetUserLov", function(o) {
            // console.log(o);
            $( "#code" ).autocomplete({
              source: o
            });
        }, 'json');

        $("#code").change(function(){
            // alert("The text has been changed.");
            // var url = $(this).attr('action');
            var data = $(this).serialize();
    
            $.post("timesheet/xhrUsername", data, function(o) {
                
                if (o.length == 0) {                    
                    alert("Don't have user code "+$("#code").val()+" in the system");
                } else {
                    $("#name").val(o[0].name);
                }
            }, 'json');
          });

        $("#search").submit(function() {
            var url = $(this).attr('action');
            var data = $(this).serialize();
    
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