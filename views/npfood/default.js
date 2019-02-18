

(function( $ ) {
    "use strict";
  
    $(function() {
        // var table = $('#bootstrap-data-table-export').DataTable({
        var table = $('#table-npfood').DataTable({
            columns: [
                { data: 'ordid' },
                { data: 'orddate' },
                { data: 'room' },
                { data: 'total' }, 
                { "defaultContent": "<button>Edit</button>" }, 
                { "defaultContent": "<button>Delete </button>" }
            ]
            });


        $("#search").submit(function() {
            var url = $(this).attr('action');
            var data = $(this).serialize();
    
            $.post(url, data, function(o) {
                table.clear;
                data = JSON.parse(o);
                // console.log(data);
                table.rows.add(data).draw();
            });
    
            return false;
        });
    });
  
  }(jQuery));
