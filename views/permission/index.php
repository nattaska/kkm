<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border border-info">
                    <div class="card-header bg-info">
                        <strong class="card-title text-light">Permission Maintenance</strong>
                    </div>

                    <div class="card-body">
                        <form id="search" action="<?php echo URL; ?>permission/xhrSearch" method="post" class="form-horizontal">
                            <div class="row form-group">
                                <div class="col-md-6 offset-2">
                                    <div class="input-group">                                            
                                        <div class="col col-md-2">
                                        <input type="text" id="rolecd" name="rolecd" class="form-control" value="" ></div>
                                        <div class="input-group-addon"><i class="fa  fa-th-list"></i></div>
                                        <div class="col col-md-9"><input type="text" id="rolename" name="rolename" placeholder="" class="form-control" disabled></div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                            <button class="btn btn-primary"> 
                                                <i class="ti ti-search"></i> Search
                                            </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                        <div id="msgMain" ></div>

                        <div class="card-body">
                            <table id="table-data" class="table table-striped table-bordered dataTale" role="grid">
                                <thead>
                                    <tr>
                                        <th>Menu ID</th>
                                        <th>Menu</th>
                                        <th>Permission</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Menu ID</th>
                                        <th>Menu</th>
                                        <th>Permission</th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>  <!-- card body -->
                    </div>                     
                </div>                     
            </div>
        </div>
    </div>
</div>