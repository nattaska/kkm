(function( $ ) {
    "use strict";
  
    $(function() {

        $("#search").submit(function() {
            var url = $(this).attr('action');
            var data = $(this).serialize();
    
            $.post(url, data, function(o) {
                $("#listBuffet").html("");
                for (var i=0; i < o.length; i++) {
                    $('#listBuffet').append('<tr>	'
                                +'  <td align="center" scope="col">'+o[i].bfdate+'</td> ' 
                                +'  <td align="center" scope="col">'+o[i].typename+'</td> '
                                +'  <td align="center" scope="col">'+o[i].qty+'</td> '
                                +'  <td scope="col">&nbsp;&nbsp;&nbsp;'+o[i].grpnm+'</td> '
                                +'</tr>');
                }
            }, 'json');
    
            return false;
        });

        $("#bufftype").chosen();
    });
  
  }(jQuery));