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
                { targets: [0], className: 'dt-center' },
                { targets: [1, 2, 3, 4, 5, 6, 7], className: 'dt-right' }
            ]
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