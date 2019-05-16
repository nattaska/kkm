(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "advance";
        var disabled = ($('#auth').val()==='R'?'disabled':'');

        var table = $('#table-data').DataTable({
            dom: 'Bfrtip',
            buttons: [
                { text: '<a id="add" href="#" class="add"><button '+disabled+' type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifyDataModel"><i class="fa fa-plus"></i>&nbsp;Add</button></a>' }
            ],
            columns: [
                { data: 'empcd' },
                { data: 'name' },
                { data: 'advdate' },
                { data: 'pay' }, 
                { sortable: false,
                  defaultContent: '<a id="edit" href="#" class="edit"><button '+disabled+' type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modifyDataModel"><i class="fa fa-edit"></i></button></a>&nbsp;'+
                                  '<a id="delete" href="#" class="delete"><button '+disabled+' type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button></a>' }
            ],
            columnDefs: [
                { targets: [0, 2, 4], "width": "15%", className: 'dt-center' },
                { targets: [1], "width": "15%", className: 'dt-left' },
                { targets: [3], "width": "10%", className: 'dt-right' }
            ]
        });
        
        var tableRow = table.row($(this).parents('tr'));
    
        $.post("profile/xhrGetUserLov", function(o) {
            // console.log(o);
            $( "#empcd" ).autocomplete({
                minLength: 0,
                source: o,
                focus: function( event, ui ) {
                    $( "#empcd" ).val( ui.item.value );
                    $( "#empname" ).val( $.trim(ui.item.label.split('-')[1]) );
                    return false;
                },
                select: function( event, ui ) {
                    $( "#empcd" ).val( ui.item.value );
                    $( "#empname" ).val( $.trim(ui.item.label.split('-')[1]) );
                    return false;
                } 
            });
        }, 'json');

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

            $("#modify-data-form").attr("action", $('#url').val()+module+'/xhrInsert');
            $("#modifyDataModel #staticModalLabel").html("Add Data");
            $('#empcd').val('');
            $('#empname').val('');
            $('#advdate').val(today);
            $('#pay').val('');
        });
 
        $('#table-data tbody').on( 'click', '.edit', function () {
            tableRow = table.row($(this).parents('tr'));
            var data = tableRow.data();
            // console.log(data.ordid);

            $("#modify-data-form").attr("action", $('#url').val()+module+'/xhrUpdate');
            $("#modifyDataModel #staticModalLabel").html("Edit Data");
            $('#empcd').val(data.empcd);
            $('#empname').val(data.name);
            $('#advdate').val(data.advdate);
            $('#pay').val(data.pay);

            $("#empcd").prop("readonly",true);
            $("#advdate").prop("readonly",true);
    
        });
 
        $('#table-data tbody').on( 'click', '.delete', function () {
            var row = table.row( $(this).parents('tr') );
            var data = row.data();
            // console.log(data);

            $.post(module+'/xhrDelete', {'empcd': data.empcd, 'advdate': data.advdate}, function(o) {
                
                if (o.res > 0) {
                    row.remove().draw();
                    $("#msgMain").html('<div class="alert alert-success"><button type="button" class="close">×</button><strong>Success!</strong> '+data.name+'\'s advance has been deleted successfully</div>');
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
            $("#empcd").removeClass("is-invalid");
            $("#pay").removeClass("is-invalid");
        });

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
                empcd: {
                    required: true,
                    minlength: 5
                },
                advdate: "required",
                pay:  {
                    required: true,
                    number: true
                }
            },
            // Specify validation error messages
            messages: {
                empcd: {
                    required: "Please enter your Order Id",
                    minlength: "Your code must be at least 5 characters long"
                },
                advdate: "Please enter your Advance Date",
                total: {
                    required: "Please enter your patd",
                    number: "Please enter a valid number."
                }
            },
            submitHandler: function(form) { 
                var url = $(form).attr('action');
                var data = $(form).serialize();
    
                var empcd  = $('#empcd').val();
                var empname   = $('#empname').val();
                var advdate = $('#advdate').val();
                var pay = $('#pay').val();
                var msg = "";
                
                $.post(url, data, function(o) {
                    // alert(o);
                    var loadingModal = $("#modifyDataModel");
                    if (o.res > 0) {
                        var newdata_arr = [];
                        var newdata = {"empcd":empcd, "name":empname, "advdate":advdate, "pay":pay};
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
