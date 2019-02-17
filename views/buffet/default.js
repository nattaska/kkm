// $(function() {
//     alert(1);
    // $('#listTimesheet').append('<div>' + o[i].text + '<a class="del" rel="'+o[i].id+'" href="#">X</a></div>');
    // $('#listTimesheet').append('<tr>	<th scope="col">30/01/2019</th>	<th scope="col">10:05</th>	<th scope="col">23:18</th></tr>');
// });

(function( $ ) {
    "use strict";
  
    $(function() {
        // $('#buffetTable').DataTable();
        //   $('#buffetTable-export').DataTable();
        
        // $('#bootstrap-data-table-export').DataTable();

        $("#search").submit(function() {
            var url = $(this).attr('action');
            var data = $(this).serialize();
    
            $.post(url, data, function(o) {
                // bftype, prmdesc typename, bfqty qty, ifnull(bfgrpnm,'') grpnm
                $("#listBuffet").html("");
                for (var i=0; i<o.length; i++) {
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
    });
  
  }(jQuery));

//   $(document).ready(function() {
//     $('#bootstrap-data-table-export').DataTable();
// } );