(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "timesheet";
        var disabled = ($('#auth').val()==='R'?'disabled':'');

        var table = $('#table-data').DataTable({
            dom: 'Bfrtip',
            buttons: [
                { text: '<a id="add" href="#" class="add"><button '+disabled+' type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifyDataModel"><i class="fa fa-plus"></i>&nbsp;Add</button></a>' }
            ],
            columns: [
                { data: 'code' },
                { data: 'name' },
                { data: 'timdate' },
                { data: 'timin' }, 
                { data: 'timout' }, 
                { data: 'timstat' }, 
                { sortable: false,
                  defaultContent: '<a id="edit" href="#" class="edit"><button '+disabled+' type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modifyDataModel"><i class="fa fa-edit"></i></button></a>&nbsp;'+
                                  '<a id="delete" href="#" class="delete"><button '+disabled+' type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button></a>' }
            ],
            columnDefs: [
                { targets: [2, 3, 4], "width": "15%", className: 'dt-center' },
                { targets: [0, 5], "width": "5%", className: 'dt-center' },
                { targets: [1], "width": "15%", className: 'dt-left' },
                { targets: [6], "width": "10%", className: 'dt-right' }
            ]
        });
        
        var tableRow = table.row($(this).parents('tr'));
        
        $('#timin').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            startDate: moment(),
            endDate: moment(),
            locale: {
                format: 'YYYY-MM-DD HH:mm:ss'
            }
        });
        
        $('#timout').daterangepicker({
            singleDatePicker: true,
            timePicker: true,
            startDate: moment(),
            endDate: moment(),
            locale: {
                format: 'YYYY-MM-DD HH:mm:ss'
            }
        });
    
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
            let url = $(this).attr('action');
            let data = $(this).serialize();

            $.post(url, data, function(o) {
                table.clear().draw();
                data = JSON.parse(o);
                // console.log(data);
                table.rows.add(data).draw();
            });
    
            return false;
        });
 
        $('#add').on( 'click', function () {
            let now = new Date();
            let day = ("0" + now.getDate()).slice(-2);
            let month = ("0" + (now.getMonth() + 1)).slice(-2);
            let today = now.getFullYear()+"-"+(month)+"-"+(day) ;
            
            let user = $('#user').val();
            // alert($('#url').val());

            $("#modify-data-form").attr("action", $('#url').val()+module+'/xhrInsert');
            $("#modifyDataModel #staticModalLabel").html("Add Data");
            $('#empcd').val($.trim(user.split('-')[0]));
            $('#empname').val($.trim(user.split('-')[1]));
            $('#timdate').val(today);
            // $('#timin').val(("0" + now.getHours()).slice(-2)+':'+("0" + now.getMinutes()).slice(-2));
            $('#timin').val('');
            $('#timout').val('');
            $('#timstat').val('');
            $("#empcd").prop("readonly",false);
            $("#timdate").prop("readonly",false);
        });
 
        $('#table-data tbody').on( 'click', '.edit', function () {
            tableRow = table.row($(this).parents('tr'));
            var data = tableRow.data();
            // console.log(data.ordid);

            $("#modify-data-form").attr("action", $('#url').val()+module+'/xhrUpdate');
            $("#modifyDataModel #staticModalLabel").html("Edit Data");
            $('#empcd').val(data.code);
            $('#empname').val(data.name);
            $('#timdate').val(data.timdate);
            $('#timin').val(data.timin);
            $('#timout').val(data.timout);
            $('#timstat').val(data.timstat);

            $("#empcd").prop("readonly",true);
            $("#timdate").prop("readonly",true);
    
        });
 
        $('#table-data tbody').on( 'click', '.delete', function () {
            var row = table.row( $(this).parents('tr') );
            var data = row.data();
            // console.log(data);

            $.post(module+'/xhrDelete', {'empcd': data.empcd, 'timdate': data.timdate}, function(o) {
                
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

            $("#empcd").prop("readonly",false);
            $("#timdate").prop("readonly",false);
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
                timdate: "required"
            },
            // Specify validation error messages
            messages: {
                empcd: {
                    required: "Please enter your code",
                    minlength: "Your code must be at least 5 characters long"
                },
                timdate: "Please enter your Date"
            },
            submitHandler: function(form) { 
                let url = $(form).attr('action');
                let data = $(form).serialize();
    
                let empcd  = $('#empcd').val();
                let empname   = $('#empname').val();
                let timdate = $('#timdate').val();
                let timin = $('#timin').val();
                let timout = $('#timout').val();
                let timstat = $('#timstat').val();
                let msg = "";
                
                $.post(url, data, function(o) {
                    // alert(o);
                    let loadingModal = $("#modifyDataModel");
                    if (o.res > 0) {
                        let newdata_arr = [];
                        let newdata = {"code":empcd, "name":empname, "timdate":timdate, "timin":timin, "timout":timout, "timstat":timstat};
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
