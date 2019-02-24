

(function( $ ) {
    "use strict";
  
    $(function() {
        // var table = $('#bootstrap-data-table-export').DataTable({
        var table = $('#table-npfood').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    text: '<button type="button" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i>&nbsp;Add</button>',
                    action: function ( e, dt, node, config ) {
                        alert( 'Button activated' );
                    }
                }
            ],
            columns: [
                { data: 'ordid' },
                { data: 'orddate' },
                { data: 'room' },
                { data: 'total' }, 
                { sortable: false,
                  defaultContent: '<a id="edit" href="#" class="edit"><button type="button" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button></a>&nbsp;'+
                                  '<a id="delete" href="#" class="delete"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button></a>' }
            ],
            columnDefs: [
                { targets: [0, 1, 2, 4], "width": "15%", className: 'dt-center' },
                { targets: [3], "width": "10%", className: 'dt-right' }
                    // {"className": "dt-center", "targets": '_all'},
                    // {"className": "dt-right", "targets": [2]}
            ]
            });
 
        // $('#table-npfood tbody').on( 'click', 'tr', function () {
        //     if ( $(this).hasClass('selected') ) {
        //         $(this).removeClass('selected');
        //     }
        //     else {
        //         table.$('tr.selected').removeClass('selected');
        //         $(this).addClass('selected');
        //     }
            // console.log( table.row( this ).data() );
            // var data = table.row( this ).data();
            // alert(data.ordid);
        // } );
 
        // $('#table-npfood tbody').on( 'click', 'button', function () {
        //     var data = table.row( $(this).parents('tr') ).data();
        //     alert( data[0] +"'s total is: "+ data[ 3 ] );
        // } );
            
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
 
        $('#table-npfood tbody').on( 'click', '.delete', function () {
            var data = table.row( $(this).parents('tr') ).data();
            console.log(data.ordid);
        });
 
        $('#table-npfood tbody').on( 'click', '.edit', function () {
            var data = table.row( $(this).parents('tr') ).data();
            console.log(data.ordid);
        });
    });
  
  }(jQuery));
