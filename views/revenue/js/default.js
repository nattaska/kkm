(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "revenue";

        var table = $('#table-data').DataTable({
            dom: 'Bfrtip',
            buttons: [
                { text: '<a id="add" href="#" class="add"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifyDataModel"><i class="fa fa-plus"></i>&nbsp;Add</button></a>' },
                { extend: 'excel',
                  exportOptions: { columns: [0, 1, 2, 3] }
                }
            ],
            columns: [
                { data: 'rvndate' },
                { data: 'rvntitle' },
                { data: 'rvnamt' },
                { data: 'rvncmt' },
                { data: 'rvncd' },
                { sortable: false,
                  defaultContent: '<a id="edit" href="#" class="edit"><button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modifyDataModel"><i class="fa fa-edit"></i></button></a>&nbsp;'+
                                  '<a id="delete" href="#" class="delete"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button></a>' }
            ],
            columnDefs: [
                { targets: [1], "width": "15%", className: 'dt-left' },
                { targets: [3], "width": "25%", className: 'dt-left' },
                { targets: [0, 5], "width": "10%", className: 'dt-center' },
                { targets: [2], "width": "10%", className: 'dt-right' },
                { targets: [4], "visible": false }
            ]
        });
        
        var tableRow = table.row($(this).parents('tr'));

        $(".chosen-select").chosen();

        $("#code").change(function(){
            var arr = $("#code option:selected").text().split('-');
            $("#title").val($.trim(arr[1]));
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

            $("#modify-data-form").attr("action", $('#url').val()+module+'/xhrInsert');
            $("#modifyDataModel #staticModalLabel").html("Add Data");
            $('#pdate').val(today);
            $("#code").val('').trigger("chosen:updated");
            $('#amount').val('');
            $('#comment').val('');
        });
 
        $('#table-data tbody').on( 'click', '.edit', function () {
            tableRow = table.row($(this).parents('tr'));
            var data = tableRow.data();
            // console.log(data);

            $("#modify-data-form").attr("action", $('#url').val()+module+'/xhrUpdate');
            $("#modifyDataModel #staticModalLabel").html("Edit Data");
            $('#pdate').val(data.rvndate);
            $("#code").val(data.rvncd).trigger("chosen:updated");
            $('#amount').val(data.rvnamt.replace(',',''));
            $('#comment').val(data.rvncmt);

            $("#pdate").prop("readonly",true);
            $('input[name=code]').val($("#code").val());   
            $('#code').attr("disabled", true).trigger("chosen:updated");
        });
 
        $('#table-data tbody').on( 'click', '.delete', function () {
            var row = table.row( $(this).parents('tr') );
            var data = row.data();
            // console.log(data);

            $.post(module+'/xhrDelete', {'pdate': data.rvndate, 'code': data.rvncd}, function(o) {
                
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

        $('#modifyDataModel').on('hidden.bs.modal', function() {
            $('#modify-data-form').validate().resetForm();
            $("#amount").removeClass("is-invalid");
            $("#comment").removeClass("is-invalid");
            $("#pdate").prop("readonly",false);
            $('#code').attr("disabled", false).trigger("chosen:updated");
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
                pdate: "required",
                code: "required",
                amount: { number: true }
            },
            // Specify validation error messages
            messages: {
                bfdate: "Please enter your date",
                bftype: "Please choose revenue type",
                amount: {
                    number: "Please enter a valid number."
                }
            },
            submitHandler: function(form) { 
                var url = $(form).attr('action');
                var data = $(form).serialize();
    
                var pdate   = $('#pdate').val();
                var code    = $('#code').val();
                var title   = $('#title').val();
                var amount  = parseFloat($('#amount').val()).toFixed(2);
                var comment = $('#comment').val();
                var msg = "";
                // console.log(grpcd+' - '+grpnm);

                $.post(url, data, function(o) {
                    // alert(o);
                    var loadingModal = $("#modifyDataModel");
                    if (o.res > 0) {
                        var newdata_arr = [];
                        var newdata = {"rvndate":pdate, "rvntitle":title, "rvnamt":amount, "rvncmt":comment, "rvncd":code};
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