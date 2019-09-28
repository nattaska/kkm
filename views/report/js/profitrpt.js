(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "report";
        var disabled = ($('#auth').val()==='R'?'disabled':'');

        var table = $('#table-data').DataTable({
            columns: [
                { data: "sale_date" },
                { data: "panda" },
                { data: "npfood" },
                { data: "kkm" },
                { data: "bfamt" },
                { data: "income" },
                { data: "expamt" },
                { data: "net" }
            ],
            columnDefs: [
                { targets: [0], "width": "10%", className: 'dt-center' },
                { targets: [1, 2, 3, 4, 5, 6, 7], className: 'dt-right' }
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
    
                // Total over all pages
                var amtTotal = api.column(7).data().reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Total over this page
                var amtPageSumm = api.column( 7, { page: 'current'} ).data().reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Update footer
                $( api.column(7).footer() ).html(
                    $.number( amtPageSumm, 2 ) +' </br>Total : '+ $.number( amtTotal, 2 )
                );
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


    });
  
}(jQuery));