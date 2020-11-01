(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "report";
        var disabled = ($('#auth').val()==='R'?'disabled':'');

        var table = $('#table-data').DataTable({
            columns: [
                { data: "sale_date" },
                { data: "panda" },
                { data: "grab" },
                { data: "weserve" },
                { data: "partner" },
                { data: "npfood" },
                { data: "kkm" },
                { data: "bfamt" },
                { data: "income" },
                { data: "expamt" },
                { data: "net" }
            ],
            columnDefs: [
                { targets: [0], "width": "10%", className: 'dt-center' },
                { targets: [4, 5, 6, 7, 8, 9, 10], className: 'dt-right' },
                { targets: [1, 2, 3], "visible": false }
            ],
            "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                let intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                if (intVal(aData["net"]) < 0) {
                    $('td', nRow).css('background-color', 'rgb(251, 142, 142)');
                }
                var sPartner = 'Panda[ '+aData["panda"]+' ], Grab[ '+aData["grab"]+' ], Weserve[ '+aData["weserve"]+' ]';
                nRow.setAttribute( 'title', sPartner );

                return nRow;
            },
            "fnFooterCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;
    
                // Remove the formatting to get integer data for summation
                let intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                function total( c ) {
    
                    // Total over all pages
                    var amtTotal = api.column(c).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
        
                    // Total over this page
                    var amtPageSumm = api.column(c, { page: 'current'} ).data().reduce( function (a, b) {
                            return intVal(a) + intVal(b);
                        }, 0 );
        
                    // Update footer
                    $( api.column(c).footer() ).html(
                        $.number( amtPageSumm, 2 ) +' </br>Total :</br> '+ $.number( amtTotal, 2 )
                    );
                        
                }

                total(10);
                // total(2);
                // total(3);
                total(4);
                total(5);
                total(6);
                total(7);
                total(8);
                total(9);
            }
        });

        // var tableRow = table.row($(this).parents('tr'));

        //  ------------    Action Search, Add, Update, Delete  ---------------------   //
                    
        $("#search").submit(function() {
            var url = $(this).attr('action');
            var data = $(this).serialize();

            $.post(url, data, function(o) {
                table.clear().draw();
                data = JSON.parse(o);
                // console.log(data);
                table.rows.add(data).draw();
            });
    
            return false;
        });

        /* Apply the tooltips */
        table.$('tr').tooltip( {
            "delay": 0,
            "track": true,
            "fade": 250
        } );


    });
  
}(jQuery));