(function( $ ) {
    "use strict";
  
    $(function() {
        var table = $('#table-npfood').DataTable({
            dom: 'Bfrtip',
            buttons: [
                { text: '<a id="add" href="#" class="add"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifyDataModel"><i class="fa fa-plus"></i>&nbsp;Add</button></a>' }
            ],
            columns: [
                { data: 'ordid' },
                { data: 'orddate' },
                { data: 'room' },
                { data: 'total' }, 
                { sortable: false,
                  defaultContent: '<a id="edit" href="#" class="edit"><button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modifyDataModel"><i class="fa fa-edit"></i></button></a>&nbsp;'+
                                  '<a id="delete" href="#" class="delete"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button></a>' }
            ],
            columnDefs: [
                { targets: [0, 1, 2, 4], "width": "15%", className: 'dt-center' },
                { targets: [3], "width": "20%", className: 'dt-right' }
            ],            
            footerCallback: function ( row, data, start, end, display ) {
                var api = this.api(), data;
    
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
    
                // Total over all pages
                var amtTotal = api.column(3).data().reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Total over this page
                var amtPageSumm = api.column( 3, { page: 'current'} ).data().reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
    
                // Update footer
                $( api.column(3).footer() ).html(
                    $.number( amtPageSumm, 2 ) +' </br>Total : '+ $.number( amtTotal, 2 )
                );
            }
        });
        
        var tableRow = table.row($(this).parents('tr'));

//  ------------    Action on field  ---------------------   //

        $("#room").chosen();

        $("#room").change(function(){
            var arr = $("#room option:selected").text().split('-');
            $("#tabno").val($.trim(arr[1]));
        });

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
 
        $('#add').on( 'click', function () {
            var now = new Date();
            var day = ("0" + now.getDate()).slice(-2);
            var month = ("0" + (now.getMonth() + 1)).slice(-2);
            var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
            // alert($('#url').val());

            $("#modify-data-form").attr("action", $('#url').val()+'npfood/xhrInsertNPFood');
            $("#modifyDataModel #staticModalLabel").html("Add Data");
            $('#ordid').val('');
            $('#orddate').val(today);
            $("#room").val('').trigger("chosen:updated");
            $('#tabno').val('');
            $('#total').val('');
        });
 
        $('#table-npfood tbody').on( 'click', '.edit', function () {
            tableRow = table.row($(this).parents('tr'));
            var data = tableRow.data();
            // console.log(data.ordid);

            $("#modify-data-form").attr("action", $('#url').val()+'npfood/xhrUpdateNPFood');
            $("#modifyDataModel #staticModalLabel").html("Edit Data");
            $('#ordid').val(data.ordid);
            $('#orddate').val(data.orddate);
            $("#room").val(data.room).trigger("chosen:updated");
            // $('#room').val(data.room);
            $('#total').val(data.total);            
    
            $.post("npfood/xhrGetTable", {'room': data.room}, function(o) {
                
                if (o.length == 0) {
                    $("#tabno").val('');
                } else {
                    $("#tabno").val(o[0].tabno);
                }
            }, 'json');
        });
 
        $('#table-npfood tbody').on( 'click', '.delete', function () {
            var row = table.row( $(this).parents('tr') );
            var data = row.data();
            // console.log(data.ordid);

            $.post('npfood/xhrDeleteNPFood', {'ordid': data.ordid}, function(o) {
                // console.log(o);
                
                if (o.res > 0) {
                    row.remove().draw();
                    $("#msgMain").html('<div class="alert alert-success"><button type="button" class="close">×</button><strong>Success!</strong> Order '+data.ordid+' has been deleted successfully</div>');
                } else {
                    $("#msgMain").html('<div class="alert alert-danger"><button type="button" class="close">×</button><strong>Error!</strong> '+o.error+'</div>');
                }
            }, 'json');
                    
            //timing the alert box to close after 5 seconds
            window.setTimeout(function () {
                $(".alert").fadeTo(500, 0).slideUp(500, function () {
                    $(this).remove();
                });
            }, 5000);
    
            //Adding a click event to the 'x' button to close immediately
            $('.alert .close').on("click", function (e) {
                $(this).parent().fadeTo(500, 0).slideUp(500);
            });
        });

        $('#modifyDataModel').on('hidden.bs.modal', function() {
            $('#modify-data-form').validate().resetForm();
            $("#ordid").removeClass("is-invalid");
            $("#total").removeClass("is-invalid");
        });

        // $('[data-toggle="tooltip"]').tooltip();

//  ------------    Validation and submit from  ---------------------   //
        
        $.validator.setDefaults({
            errorClass: 'text-danger',
            ignore: ":hidden:not(select)",
            highlight: function(element) {
              $(element)
                .closest('.form-control')
                .addClass('is-invalid');
            },
            unhighlight: function(element) {
              $(element)
                .closest('.form-control')
                .removeClass('is-invalid');
            }
        });
        
        $("#modify-data-form").submit(function(e) {
            e.preventDefault();
        }).validate({
            rules: {
                ordid: {
                    required: true,
                    number: true,
                    minlength: 4
                },
                orddate: "required",
                room: "required",
                total:  {
                    required: true,
                    number: true
                }
            },
            // Specify validation error messages
            messages: {
                ordid: {
                    required: "Please enter your Order Id",
                    number: "Please enter a valid number.",
                    minlength: "Your order must be at least 4 characters long"
                },
                orddate: "Please enter your Order Date",
                room: "Please choose your room",
                total: {
                    required: "Please enter your total",
                    number: "Please enter a valid number."
                }
            },
            submitHandler: function(form) { 
                var url = $(form).attr('action');
                var data = $(form).serialize();
    
                var ordid  = $('#ordid').val();
                var orddate = $('#orddate').val();
                var room   = $('#room').val();
                var total = $('#total').val();
                var msg = "";
        
                if(!ordid || !orddate || !room || !total){
                    msg = "All fields are required.";
                } else if(isNaN(ordid) || isNaN(total)) {
                    msg = "Order Id and Total must be number";                
                } else {
                    $.post(url, data, function(o) {
                        // alert(o);
                        var loadingModal = $("#modifyDataModel");
                        if (o.res > 0) {
                            var newdata_arr = [];
                            var newdata = {"ordid":ordid, "orddate":orddate, "room":room, "total":total};
                            newdata_arr.push(newdata);
    
                            if(url.indexOf('Insert') >= 0) {
                                table.rows.add(newdata_arr).draw();         // Insert
                            } else if(url.indexOf('Update') >= 0) {
                                table.row(tableRow).data(newdata).draw();   // Update
                            }
    
                            loadingModal.modal("hide");
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            $(".alert").hide().show('medium');
                            $("#msgMain").html('<div class="alert alert-success"><button type="button" class="close">×</button><strong>Success!</strong> Your data has been saved successfully</div>');
                        } else {
                            // alert(o.error);
                            $("#msgModel").html('<div class="alert alert-danger"><button type="button" class="close">×</button><strong>Error!</strong> '+o.error+'</div>');
                        }
                    }, 'json');
                }
        
                if (msg.length > 0) {
                    $("#msgModel").html('<div class="alert alert-warning"><button type="button" class="close">×</button><strong>Warning!</strong> '+msg+'</div>');
                }
                        
                //timing the alert box to close after 5 seconds
                window.setTimeout(function () {
                    $(".alert").fadeTo(500, 0).slideUp(500, function () {
                        $(this).remove();
                    });
                }, 5000);
    
                //Adding a click event to the 'x' button to close immediately
                $('.alert .close').on("click", function (e) {
                    $(this).parent().fadeTo(500, 0).slideUp(500);
                });

                return false;  //This doesn't prevent the form from submitting.
            }
        });

    });
  
  }(jQuery));
