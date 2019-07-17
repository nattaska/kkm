         <div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">User Maintenance</strong>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
                                        <form id="search" action="<?php echo URL; ?>user/xhrSearch" method="post" class="form-horizontal">
                                            <div class="row form-group">
                                                <div class="col-md-4"></div>
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-user"></i></div>&nbsp;
                                                        <input type="text" name="usercode" class="form-control" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="input-group">
                                                        <button class="btn btn-primary"> <i class="ti ti-search"></i> Search</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div id="msgMain" ></div>
                                
                                    <div class="card-body">
                                        <!-- <table id="bootstrap-data-table" class="table table-striped table-bordered"> -->
                                        <table id="table-data" class="table table-striped table-bordered dataTale" role="grid">
                                            <thead>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <th>Nick Name</th>
                                                    <th>Phone</th>
                                                    <th>Role</th>
                                                    <th>Role Code</th>
                                                    <th>Email</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Code</th>
                                                    <th>Name</th>
                                                    <th>Nick Name</th>
                                                    <th>Phone</th>
                                                    <th>Role</th>
                                                    <th>Role Code</th>
                                                    <th>Email</th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>

                                    <div class="modal fade" id="modifyDataModel" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-md" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticModalLabel">Add Order</h5>
                                                </div>
                                                <!-- class="form-horizontal" -->
                                                <form id="modify-data-form" action="" method="post" class="form-horizontal">
                                                    <div class="modal-body">
                                                        <input type="hidden" id="url" name="url" value="<?php echo URL; ?>" class="form-control">
                                                        <div class="row form-group">
                                                            <div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">User Code</label></div>                                          
                                                            <div class="col col-md-3"><input type="text" id="code" name="code" value="AUTO" class="form-control" readonly></div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="text-input" class="form-control-label">Name</label></div>
                                                            <div class="col-12 col-md-5"><input type="text" id="name" name="name" value="" class="form-control"></div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nick Name</label></div>    
                                                            <div class="col-12 col-md-5"><input type="text" id="nickname" name="nickname" class="form-control"></div>
                                                        </div> 
                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="phone" class=" form-control-label">Phone</label></div>    
                                                            <div class="col-12 col-md-5"><input type="tel" id="phone" name="phone" placeholder="081xxxxxxx" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" required class="form-control"></div>
                                                        </div> 
                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="email" class=" form-control-label">Email</label></div>    
                                                            <div class="col-12 col-md-5"><input type="email" id="email" name="email" placeholder="xxx@mail.com" pattern=".+@mail.com" class="form-control"></div>
                                                        </div> 
                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="rolcd" class=" form-control-label">Role</label></div>    
                                                            <div class="col-12 col-md-5">
                                                                <select id="rolcd" name="rolcd">
                                                                    <option value="">--Please choose role--</option>
                                                                    <option value="ADM">Administrator</option>
                                                                    <option value="OWN">Owner</option>
                                                                    <option value="MGR">Manager</option>
                                                                    <option value="STA">Staff</option>
                                                                </select>  
                                                            </div>
                                                        </div> 


                                                    </div>
                                                    <div class="modal-footer">
                                                        <button id="confirmBtn" class="btn btn-primary" >Confirm</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    </div>
                                                </form>
                                                <div id="msgModel" ></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                                            
                                            
            </div><!-- .animated -->
        </div><!-- .content -->
