
(function ($) {
    "use strict";

    $(function () {
        var module = "parameter";
        var disabled = ($('#auth').val()==='R'?'disabled':'');

        var table = $('#table-data').DataTable({
            dom: 'Bfrtip',
            buttons: [
                { text: '<a id="add" href="#" class="add"><button '+disabled+' type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifyDataModel"><i class="fa fa-plus"></i>&nbsp;Add</button></a>' }
            ],
            columns: [
                { data: 'code' },
                { data: 'descp' },
                { data: 'val1' },
                { data: 'val2' },
                { data: 'val3' },
                { data: 'val4' },
                { data: 'val5' },
                { sortable: false,
                  defaultContent: '<a id="edit" href="#" class="edit"><button '+disabled+' type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modifyDataModel"><i class="fa fa-edit"></i></button></a>&nbsp;'+
                                  '<a id="delete" href="#" class="delete"><button '+disabled+' type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button></a>' }
            ],
            columnDefs: [
                { targets: [0], "width": "10%", className: 'dt-left' },
                { targets: [1], "width": "30%", className: 'dt-left' },
                { targets: [2, 3, 4, 5, 6], "width": "10%", className: 'dt-left' },
                { targets: [7], "width": "10%", className: 'dt-center' }
            ]
        });
        
        var tableRow = table.row($(this).parents('tr'));        
    
        $.post(module+"/xhrGetParameterHeaderLov", function(o) {
            // console.log(o);
            $( "#tbserch" ).autocomplete({
              source: o,
              select: function(event, ui) {
                  event.preventDefault();
                  $("#tbserch").val($.trim((ui.item.label.split('-'))[0]));
                  $("#tbname").val($.trim((ui.item.label.split('-'))[1]));
              }
            });
        }, 'json');

        $("#tbserch").change(function(){
            let data = $(this).serialize();
    
            $.post("parameter/xhrGetParameter", data, function(o) {
                
                if (o.length == 0) {                    
                    alert("Don't have table no "+$("#tbserch").val()+" in the system");
                } else {
                    $("#tbname").val(o[0].tbname);
                }
            }, 'json');
        });

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
            $("#modify-data-form").attr("action", $('#url').val()+module+'/xhrInsert');
            $("#modifyDataModel #staticModalLabel").html("Add Data");
            $('#tbno').val($("#tbserch").val());
            $('#name').val($("#tbname").val());
            $("#code").val('');
            $('#descp').val('');
            $('#val1').val('');
            $('#val2').val('');
            $('#val3').val('');
            $('#val4').val('');
            $('#val5').val('');

            $("#code").prop("readonly",false);
        });
 
        $('#table-data tbody').on( 'click', '.edit', function () {
            tableRow = table.row($(this).parents('tr'));
            let data = tableRow.data();
            // console.log(data);

            $("#modify-data-form").attr("action", $('#url').val()+module+'/xhrUpdate');
            $("#modifyDataModel #staticModalLabel").html("Edit Data");
            $('#tbno').val($("#tbserch").val());
            $('#name').val($("#tbname").val());
            $('#code').val(data.code);
            $('#descp').val(data.descp);
            $('#val1').val(data.val1);
            $('#val2').val(data.val2);
            $('#val3').val(data.val3);
            $('#val4').val(data.val4);
            $('#val5').val(data.val5);

            $("#code").prop("readonly",true);
        });
 
        $('#table-data tbody').on( 'click', '.delete', function () {
            let row = table.row( $(this).parents('tr') );
            let data = row.data();
            // console.log(data);

            $.post(module+'/xhrDelete', {'tbno': data.tbno, 'code': data.code}, function(o) {
                
                if (o.res > 0) {
                    row.remove().draw();
                    $("#msgMain").html('<div class="alert alert-success"><button type="button" class="close">×</button><strong>Success!</strong> The data has been deleted successfully</div>');
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
                code: "required",
                descp: "required"
            },
            // Specify validation error messages
            messages: {
                code: "Please enter parameter code",
                descp: "Please enter parameter description"
            },
            submitHandler: function(form) { 
                var url = $(form).attr('action');
                var data = $(form).serialize();
    
                var code    = $('#code').val();
                var descp   = $('#descp').val();
                var val1    = $('#val1').val();
                var val2    = $('#val2').val();
                var val3    = $('#val3').val();
                var val4    = $('#val4').val();
                var val5    = $('#val5').val();
                var msg = "";
                // console.log(grpcd+' - '+grpnm);

                $.post(url, data, function(o) {
                    // alert(o);
                    var loadingModal = $("#modifyDataModel");
                    if (o.res > 0) {
                        var newdata_arr = [];
                        var newdata = {"code":code, "descp":descp, "val1":val1, "val2":val2, "val3":val3, "val4":val4, "val5":val5};
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