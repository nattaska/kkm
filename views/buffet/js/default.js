(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "buffet";

        var table = $('#table-data').DataTable({
            dom: 'Bfrtip',
            buttons: [
                { text: '<a id="add" href="#" class="add"><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifyDataModel"><i class="fa fa-plus"></i>&nbsp;Add</button></a>' }
            ],
            columns: [
                { data: 'bfdate' },
                { data: 'bftype' },
                { data: 'grp' },
                { data: 'typename' },
                { data: 'qty' },
                { data: 'amount' },
                { data: 'comm' },
                { data: 'note' },
                { sortable: false,
                  defaultContent: '<a id="edit" href="#" class="edit"><button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modifyDataModel"><i class="fa fa-edit"></i></button></a>&nbsp;'+
                                  '<a id="delete" href="#" class="delete"><button type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i></button></a>' }
            ],
            columnDefs: [
                { targets: [0, 3], "width": "15%", className: 'dt-center' },
                { targets: [7], "width": "20%", className: 'dt-left' },
                { targets: [8], "width": "10%", className: 'dt-center' },
                // { targets: [4], "width": "5%", className: 'dt-center' },
                { targets: [4, 5, 6], "width": "10%", className: 'dt-right' },
                { targets: [1, 2], "visible": false }
            ]
        });
        
        var tableRow = table.row($(this).parents('tr'));

        $("#bufftype").chosen();
        $("#bftype").chosen();

        $("#bftype").change(function(){
            var arr = $("#bftype option:selected").text().split('-');
            $("#typename").val($.trim(arr[1]));

            // if ($.trim(arr[0]) >= 3) {
            //     $("#grp").removeAttr('readonly');
            // } else {
            //     $("#grp").val('-');
            //     $("#grp").attr('readonly', 'readonly');
            // }
            
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
            $('#bfdate').val(today);
            $("#bftype").val('').trigger("chosen:updated");
            $('#typename').val('');
            $('#qty').val('');
            $('#grp').val('');
            $('#note').val('');
        });
 
        $('#table-data tbody').on( 'click', '.edit', function () {
            tableRow = table.row($(this).parents('tr'));
            var data = tableRow.data();
            var bftype = data.bftype+' - '+data.typename;

            $("#modify-data-form").attr("action", $('#url').val()+module+'/xhrUpdate');
            $("#modifyDataModel #staticModalLabel").html("Edit Data");
            $('#bfdate').val(data.bfdate);
            $("#bftype option:contains(" + bftype + ")").attr('selected', 'selected').trigger("chosen:updated");
            $('#typename').val(data.typename);
            $('#qty').val(data.qty);
            $('#grp').val(data.grp);
            $('#note').val(data.note);

            $("#bfdate").prop("readonly",true);
            // $("#bftype").prop("readonly",true).trigger("chosen:updated");
            // $("#bftype").chosen().chosenReadonly(true).trigger("chosen:updated");
            // $("#bftype").prop('readonly',true).trigger("chosen:updated");
            $('input[name=bftype]').val($("#bftype").val());   
            $('#bftype').attr("disabled", true).trigger("chosen:updated");
    
        });
 
        $('#table-data tbody').on( 'click', '.delete', function () {
            var row = table.row( $(this).parents('tr') );
            var data = row.data();
            // console.log(data);

            $.post(module+'/xhrDelete', {'bfdate': data.bfdate, 'bftype': data.bftype, 'grp': data.grp}, function(o) {
                
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
            // $("#grp").removeClass("is-invalid");
            $("#qty").removeClass("is-invalid");
            $('#bftype').attr("disabled", false).trigger("chosen:updated");
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
                bfdate: "required",
                bftype: "required",
                qty:  {
                    required: true,
                    number: true
                }
            },
            // Specify validation error messages
            messages: {
                bfdate: "Please enter your buffet date",
                bftype: "Please choose buffet type",
                qty: {
                    required: "Please enter your pax",
                    number: "Please enter a valid number."
                }
            },
            submitHandler: function(form) { 
                var url = $(form).attr('action');
                var data = $(form).serialize();
    
                var bfdate = $('#bfdate').val();
                var bftype   = $('#bftype').val();
                var typename   = $('#typename').val();
                var grp = $('#grp').val();
                var note   = $('#note').val();
                var qty = $('#qty').val();
                var msg = "";
                // console.log(data);
                
                var jtype = JSON.parse(bftype);
                var amount = (qty * jtype.val1);
                var comm = (amount * jtype.val2)/100;

                $.post(url, data, function(o) {
                    // alert(o);
                    var loadingModal = $("#modifyDataModel");
                    if (o.res > 0) {
                        var newdata_arr = [];
                        var newdata = {"bfdate":bfdate, "bftype":jtype.code, "grp":grp, "typename":typename, "qty":qty, "amount":amount, "comm":comm, "note":note};
                        newdata_arr.push(newdata);

                        if(url.indexOf('Insert') >= 0) {
                            newdata_arr[0]["grp"] = o.grp;
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