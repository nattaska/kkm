
(function ($) {
    "use strict";

    $(function () {
        var module = "permission";
        var disabled = ($('#auth').val()==='R'?'disabled':'');

        var table = $('#table-data').DataTable({
            dom: 'Bfrtip',
            buttons: [
                { text: '<a id="save" href="#" class="save"><button '+disabled+' type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modifyDataModel"><i class="ti ti-save"></i>&nbsp;Save</button></a>' }
            ],
            columns: [
                { data: 'menuid' },
                { data: 'menu' },
                { data: 'auth' },
                { data: 'sort' }
            ],
            columnDefs: [
                { targets: [1], "width": "30%", className: 'dt-left' },
                // { targets: [2], "width": "50%", className: 'dt-center' },
                { targets: [0, 3], "visible": false },
                { 
                    targets: 2,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, full, meta){
                        
                       if(type === 'display'){
                           data = '<div class="row form-group">'
                                    +'<div class="col col-md-9">'
                                    +'    <div class="form-check-inline form-check">'
                                    +'        <label for="auth1" class="form-check-label ">'
                                    +'            <input type="radio" id="auth1'+full.menuid+'" name="auth_'+full.menuid+'" value="R" class="form-check-input" '+(data==='R'?'checked':'')+'>Read&emsp;'
                                    +'        </label>'
                                    +'        <label for="auth2" class="form-check-label ">'
                                    +'            <input type="radio" id="auth2'+full.menuid+'" name="auth_'+full.menuid+'" value="W" class="form-check-input" '+(data==='W'?'checked':'')+'>Write&emsp;'
                                    +'        </label>'
                                    +'        <label for="auth3" class="form-check-label ">'
                                    +'            <input type="radio" id="auth3'+full.menuid+'" name="auth_'+full.menuid+'" value="N" class="form-check-input" '+(data==='N'?'checked':'')+'>None'
                                    +'        </label>'
                                    +'    </div>'
                                    +'</div>'
                                    +'</div>'
                       }
        
                       return data;
                    }
                }
            ],
            orderFixed: [ 3, 'asc' ]
        });
        
        var tableRow = table.row($(this).parents('tr'));        
    
        $.post(module+"/xhrGetRoleLov", function(o) {
            // console.log(o);
            $( "#rolecd" ).autocomplete({
              source: o,
              select: function(event, ui) {
                  event.preventDefault();
                  $("#rolecd").val($.trim((ui.item.label.split('-'))[0]));
                  $("#rolename").val($.trim((ui.item.label.split('-'))[1]));
              }
            });
        }, 'json');

        $("#rolecd").change(function(){
            let data = $(this).serialize();
    
            $.post(module+"/xhrGetRole", data, function(o) {
                
                if (o.length == 0) {                    
                    alert("Don't have Role "+$("#rolecd").val()+" in the system");
                } else {
                    $("#rolename").val(o[0].rolnm);
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
 
        $('#save').on( 'click', function () {
            let datas = [];
            let newdata;
            let auth;

            table.rows().every( function ( ) {
                console.log();
                auth = $("input[name='auth_"+this.data()['menuid']+"']:checked"). val();
                if (jQuery.type(auth) != "undefined") {
                    newdata = {"menuid":this.data()['menuid'], "menu":this.data()['menu'], "auth":auth};
                    datas.push(newdata);
                }
            } );
            // console.log(datas);
            

            $.post(module+"/xhrSave", { "rolecd" : $("#rolecd").val(), "auths" : datas }, function(o) {
                // console.log(o.res);
                if (o.res > 0) {
                    $("#msgMain").html('<div class="alert alert-success"><button type="button" class="close">×</button><strong>Success!</strong> Your data has been saved successfully</div>');
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
    
            return false;

        });

    });
  
}(jQuery));