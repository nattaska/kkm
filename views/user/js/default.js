(function( $ ) {
    "use strict";
  
    $(function() {
        var module = "user";
        var disabled = ($('#auth').val()==='R'?'disabled':'');

        var table = $('#table-data').DataTable({
            dom: 'Bfrtip',
            buttons: [
                { text: '<a id="add" href="#" class="add"><button '+disabled+' type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifyDataModel"><i class="fa fa-plus"></i>&nbsp;Add</button></a>' }
            ],
            columns: [
                { data: 'code' },
                { data: 'name' },
                { data: 'nickname' },
                { data: 'phone' }, 
                { data: 'rolename' }, 
                { data: 'sdate' }, 
                { data: 'edate' }, 
                { data: 'rolecode' }, 
                { data: 'email' }, 
                { data: 'deptid' }, 
                { data: 'paytype' }, 
                { data: 'paymethd' }, 
                { data: 'account' }, 
                { data: 'paysso' },  
                { data: 'payhour' },  
                { data: 'othour' }, 
                { data: 'stime' }, 
                { data: 'etime' }, 
                { sortable: false,
                  defaultContent: '<a id="edit" href="#" class="edit"><button '+disabled+' type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modifyDataModel"><i class="fa fa-edit"></i></button></a>&nbsp;' }
            ],
            columnDefs: [
                { targets: [0, 2, 5, 6, 18], "width": "10%", className: 'dt-center' },
                { targets: [3], "width": "15%", className: 'dt-center' },
                { targets: [1], "width": "20%", className: 'dt-left' },
                { targets: [4], "width": "10%", className: 'dt-left' },
                { targets: [7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17], "visible": false }
            ]
        });
        
        var tableRow = table.row($(this).parents('tr'));

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
            let now = new Date();
            let day = ("0" + now.getDate()).slice(-2);
            let month = ("0" + (now.getMonth() + 1)).slice(-2);
            let today = now.getFullYear()+"-"+(month)+"-"+(day) ;

            $("#modify-data-form").attr("action", $('#url').val()+module+'/xhrInsert');
            $("#modifyDataModel #staticModalLabel").html("Add Data");
            $('#code').val('AUTO');
            $('#name').val('');
            $('#nickname').val('');
            $('#phone').val('');
            $('#email').val('');
            $('#rolcd').val('');
            $('#sdate').val(today);
            $('#edate').val('2049-12-31');
            $('#dept').val('');
            $('#paymethd').val('');
            $('input[name=paytype]').prop('checked', false);
            $('#account').val('');
            $('#paysso').val('');
            $('#payhour').val('');
            $('#othour').val('');
            $('#stime').val('');
            $('#etime').val('');

            $("#sdate").prop("readonly",false);
            $("#edate").prop("readonly",true);
        });
 
        $('#table-data tbody').on( 'click', '.edit', function () {
            tableRow = table.row($(this).parents('tr'));
            var data = tableRow.data();
            // console.log(data.ordid);

            $("#modify-data-form").attr("action", $('#url').val()+module+'/xhrUpdate');
            $("#modifyDataModel #staticModalLabel").html("Edit Data");
            $('#code').val(data.code);
            $('#name').val(data.name);
            $('#nickname').val(data.nickname);
            $('#phone').val(data.phone);
            $('#email').val(data.email);
            $('#rolcd').val(data.rolecode);
            $('#sdate').val(data.sdate);
            $('#edate').val(data.edate);
            $('#dept').val(data.deptid);
            $('#paymethd').val(data.paymethd);
            $('#paytype'+data.paytype).prop("checked", true);
            // $('#paytype'+data.paytype).attr('checked', true);
            $('#account').val(data.account);
            $('#paysso').val(data.paysso);
            $('#payhour').val(data.payhour);
            $('#othour').val(data.othour);
            $('#stime').val(data.stime);
            $('#etime').val(data.etime);

            $("#code").prop("readonly",true);
            $("#sdate").prop("readonly",true);
            $("#edate").prop("readonly",false);
    
        });
 
        $('#table-data tbody').on( 'click', '.delete', function () {
            var row = table.row( $(this).parents('tr') );
            var data = row.data();
            // console.log(data);

            $.post(module+'/xhrDelete', {'code': data.code}, function(o) {
                
                if (o.res > 0) {
                    row.remove().draw();
                    $("#msgMain").html('<div class="alert alert-success"><button type="button" class="close">×</button><strong>Success!</strong> User code '+data.code+' has been deleted successfully</div>');
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
            $("#name").removeClass("is-invalid");
            $("#nickname").removeClass("is-invalid");
            $("#email").removeClass("is-invalid");
            $("#phone").removeClass("is-invalid");
            $("#rolcd").removeClass("is-invalid");
            $("#sdate").removeClass("is-invalid");
            $("#dept").removeClass("is-invalid");
            $("#paymethd").removeClass("is-invalid");
            $("#paytype").removeClass("is-invalid");
            $("#payhour").removeClass("is-invalid");
            $("#stime").removeClass("is-invalid");
            $("#etime").removeClass("is-invalid");
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
                name: "required",
                nickname: "required",
                phone:  {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10
                },
                email: { email: true },
                rolcd: "required",
                sdate: "required",
                edate: "required",
                deptid: "required",
                paymethd: "required",
                paytype: "required",
                payhour: "required",
                stime: "required",
                etime: "required"
            },
            // Specify validation error messages
            messages: {
                name: "Please enter your name",
                nickname: "Please enter your nickname",
                phone: {
                    required: "Please enter your phone number",
                    number: "Please enter a valid number.",
                    minlength: "Your phone must be 10 characters",
                    maxlength: "Your phone must be 10 characters"
                },
                email: "E-Mail invalid format",
                rolcd: "Please choose your role",
                sdate: "Please enter your start working date",
                edate: "Please enter your end working date",
                deptid: "Please choose your department",
                paymethd: "Please enter your payroll cycle",
                paytype: "Please choose your payment type",
                payhour: "Please enter your working hours",
                stime: "Please enter your start working time",
                etime: "Please enter your end working time"
            },
            submitHandler: function(form) { 
                var url = $(form).attr('action');
                var data = $(form).serialize();

                var sdate = $('#sdate').val();
                var edate = $('#edate').val();
                var msg = "";
                
                $.post(url, data, function(o) {
                    // alert(o);
                    var loadingModal = $("#modifyDataModel");
                    if (o.res > 0) {
                        if(url.indexOf('Insert') >= 0) {
                            code = o.code;
                        }
                        var newdata_arr = [];
                        var newdata = { "code":$('#code').val(), "name":$('#name').val(), "nickname":$('#nickname').val(), "phone":$('#phone').val()
                                    , "rolename":$('#rolcd option:selected').text(), "sdate":$('#sdate').val(), "edate":$('#edate').val()
                                    , "rolecode":$('#rolcd').val(), "email":$('#email').val(), "deptid":$('#dept').val(), "paytype":$("input[name='paytype']:checked"). val()
                                    , "paymethd":$('#paymethd').val(), "account":$('#account').val(), "paysso":$('#paysso').val()
                                    , "payhour":$('#payhour').val(), "othour":$('#othour').val(), "stime":$('#stime').val(), "etime":$('#etime').val() };
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
