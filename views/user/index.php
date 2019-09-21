         <div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card border border-info">
                            <div class="card-header bg-info">
                                <strong class="card-title text-light">User Maintenance</strong>
                            </div>
                            <div class="card-body">
                                <form id="search" action="<?php echo URL; ?>user/xhrSearch" method="post" class="form-horizontal">
                                    <div class="row form-group">
                                        <div class="col-md-3 offset-2">
                                        <label for="usercode" class="control-label mb-1">User</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-user"></i></div>&nbsp;
                                                <input type="text" name="usercode" class="form-control" value="">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="activedate" class="control-label mb-1">Active Date</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input type="date" name="activedate" class="form-control" value="<?php echo date_format($this->nowdate,"Y-m-d"); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label for="search" class="control-label mb-1"></label>
                                            <div class="input-group">
                                                <button class="btn btn-primary"> <i class="ti ti-search"></i> Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div id="msgMain" ></div>
                                <table id="table-data" class="table table-striped table-bordered dataTale" role="grid">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Nick Name</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>Start</th>
                                            <th>End</th>
                                            <th>Role Code</th>
                                            <th>Email</th>
                                            <th></th><th></th><th></th><th></th><th></th>
                                            <th></th><th></th><th></th><th></th>
                                            <th></th><th></th><th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Nick Name</th>
                                            <th>Phone</th>
                                            <th>Role</th>
                                            <th>Start</th>
                                            <th>End</th>
                                            <th>Role Code</th>
                                            <th>Email</th>
                                            <th></th><th></th><th></th><th></th><th></th>
                                            <th></th><th></th><th></th><th></th>
                                            <th></th><th></th><th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="modal fade" id="modifyDataModel" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-md" role="document">
                                        <div class="modal-content border border-info">
                                            <div class="modal-header bg-info">
                                                <h5 class="modal-title text-light" id="staticModalLabel">Add Order</h5>
                                            </div>
                                            <!-- class="form-horizontal" -->
                                            <form id="modify-data-form" action="" method="post" class="form-horizontal">
                                                <div class="modal-body">
                                                    <input type="hidden" id="url" name="url" value="<?php echo URL; ?>" class="form-control">
                                                    <div class="custom-tab">
                                                        <nav>
                                                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                                <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="custom-nav-home" aria-selected="true">Profile</a>
                                                                <a class="nav-link" id="payment-tab" data-toggle="tab" href="#payment" role="tab" aria-controls="custom-nav-profile" aria-selected="false">Payment</a>
                                                            </div>
                                                        </nav>
                                                        <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
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
                                                                            <?php 
                                                                            foreach ($this->roles as $role) {
                                                                            ?>
                                                                            <option value="<?php echo $role['code']; ?>"><?php echo $role['name']; ?></option>
                                                                            <?php } ?>
                                                                        </select>  
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                            <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="sdate" class="form-control-label">Start Date</label></div>
                                                                    <div class="col-12 col-md-5"><input type="date" id="sdate" name="sdate" value="<?php echo date_format($this->nowdate,"Y-m-d"); ?>" class="form-control"></div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="edate" class="form-control-label">End Date</label></div>
                                                                    <div class="col-12 col-md-5"><input type="date" id="edate" name="edate" value="2049-12-31" class="form-control" readonly></div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label class=" form-control-label">Department</label></div>
                                                                    <div class="col col-md-5">
                                                                        <select id="dept" name="dept">
                                                                            <option value="">-- Please choose department --</option>
                                                                            <?php 
                                                                            foreach ($this->depts as $dept) {
                                                                            ?>
                                                                            <option value="<?php echo $dept['code']; ?>"><?php echo $dept['descp']; ?></option>
                                                                            <?php } ?>
                                                                        </select>  
                                                                    </div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="number-input" class=" form-control-label">Payroll cycle</label></div>
                                                                    <div class="col-12 col-md-3"><input type="number" id="paymethd" name="paymethd" class="form-control" value="" <?php echo ($auth=="R"?"disabled":""); ?> ></div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label class=" form-control-label">Payment Type</label></div>
                                                                    <div class="col col-md-9">
                                                                        <div class="form-check-inline form-check">
                                                                            <label for="paytype-radio1" class="form-check-label">
                                                                                <input type="radio" id="paytype0" name="paytype" value="0" class="form-check-input" >Cash
                                                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <label for="paytype-radio2" class="form-check-label">
                                                                                <input type="radio" id="paytype1" name="paytype" value="1" class="form-check-input" >Bank
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Bank Account</label></div>
                                                                    <div class="col-12 col-md-5"><input type="text" id="account" name="account" value="" class="form-control"></div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="number-input" class=" form-control-label">ประกันสังคม</label></div>
                                                                    <div class="col-12 col-md-3"><input type="number" id="paysso" name="paysso" value="" class="form-control"></div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="number-input" class=" form-control-label">Work Hours</label></div>
                                                                    <div class="col-12 col-md-3"><input type="number" id="payhour" name="payhour" value="" class="form-control"></div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="number-input" class=" form-control-label">OT Pay</label></div>
                                                                    <div class="col-12 col-md-3"><input type="number" id="othour" name="othour" value="" class="form-control"></div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Start Time</label></div>
                                                                    <div class="col-12 col-md-4"><input type="time" id="stime" name="stime" pattern="^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$" value="" class="form-control"></div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">End Time</label></div>
                                                                    <div class="col-12 col-md-4"><input type="time" id="etime" name="etime" pattern="^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$" value="" class="form-control"></div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label class=" form-control-label">Working Type</label></div>
                                                                    <div class="col col-md-5">
                                                                        <select id="calctyp" name="calctyp">
                                                                            <option value="1">10 AM. - 10 PM.</option>
                                                                            <option value="2">Shift work</option>
                                                                        </select>  
                                                                    </div>
                                                                </div>
                                                                <div class="row form-group">
                                                                    <div class="col col-md-3"><label class=" form-control-label">Day-Off</label></div>
                                                                    <div class="col col-md-5">
                                                                        <select id="dayoff" name="dayoff">
                                                                            <option value="Sun">Sunday</option>
                                                                            <option value="Mon">Monday</option>
                                                                            <option value="Tue">Tuesday</option>
                                                                            <option value="Wed">Wednesday</option>
                                                                            <option value="Thu">Thursday</option>
                                                                            <option value="Fri">Friday</option>
                                                                            <option value="Sat">Saturday</option>
                                                                        </select>  
                                                                    </div>
                                                                </div>
                                                            </div>
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
            </div><!-- .animated -->
        </div><!-- .content -->
