

(function( $ ) {
    "use strict";
  
    $(function() {
        // $('#bootstrap-data-table-export').DataTable();
                $('#bootstrap-data-table-export').DataTable( {
                    "ajax": "ajax.txt"
                } );

        $("#search").submit(function() {
            var url = $(this).attr('action');
            var data = $(this).serialize();
    
            $.post(url, data, function(o) {
                // alert(o);
                // bftype, prmdesc typename, bfqty qty, ifnull(bfgrpnm,'') grpnm
                // $('#bootstrap-data-table-export').DataTable( {
                //     "ajax": "ajax.txt"
                // } );
                // $('#bootstrap-data-table-export').DataTable( {
                // $('#example').DataTable( {
                //     data: o,
                //     columns: [
                //         { title: "Order ID" },
                //         { title: "Ordere Date" },
                //         { title: "Room" },
                //         { title: "Total" }
                //     ]
                // } );
                
                // $('#example').DataTable( {
                //         "ajax": o,
                //         "columns": [
                //             { "data": "ordid" },
                //             { "data": "orddate" },
                //             { "data": "room" },
                //             { "data": "total" }
                //         ]
                // } );
                $('#example').DataTable( {
                    "ajax": {
                        "url": o,
                        "dataSrc": ""
                    },
                    "columns": [
                                { "data": "ordid" },
                                { "data": "orddate" },
                                { "data": "room" },
                                { "data": "total" }
                    ]
                } );

                // $("#listNPFood").html("");
                // for (var i=0; i<o.length; i++) {
                //     $('#listNPFood').append('<tr>	'
                //                 +'  <td align="center" scope="col">'+o[i].ordid+'</td> ' 
                //                 +'  <td align="center" scope="col">'+o[i].orddate+'</td> '
                //                 +'  <td align="center" scope="col">'+o[i].room+'</td> '
                //                 +'  <td scope="col">&nbsp;&nbsp;&nbsp;'+o[i].total+'</td> '
                //                 +'</tr>');
                // }
            });
    
            return false;
        });
    });
  
  }(jQuery));
