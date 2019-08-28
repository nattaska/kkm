         <div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card border border-info">
                            <div class="card-header bg-info">
                                <strong class="card-title text-light">Salary Advance</strong>
                            </div>
                            <div class="card-body">
                                <form id="search" action="<?php echo URL; ?>advance/xhrSearch" method="post" class="form-horizontal">
                                    <div class="row form-group">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-3">
                                            <label for="sdate" class="control-label mb-1">Start Date</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input type="date" name="sdate" class="form-control" value="<?php echo $this->criteria['sdate']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-1"></div>
                                        <div class="col-md-3">
                                            <label for="edate" class="control-label mb-1">End Date</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input type="date" name="edate" class="form-control" value="<?php echo $this->criteria['edate']; ?>">
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
                                            <th>Date</th>
                                            <th>Advance Paid</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Code</th>
                                            <th>Name</th>
                                            <th>Date</th>
                                            <th>Advance Paid</th>
                                            <th></th>
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
                                                        <div class="row form-group">
                                                            <div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">Employee</label></div>                                          
                                                            <div class="col col-md-3"><input type="text" id="empcd" name="empcd" class="form-control"></div>
                                                            <div class="col col-md-5"><input type="text" id="empname" name="empname" class="form-control" disabled></div>
                                                        </div>
                                                        <?php
                                                            $date = new DateTime();                                                            
                                                        ?>
                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="text-input" class="form-control-label">Advance Date</label></div>
                                                            <div class="col-12 col-md-5"><input type="date" id="advdate" name="advdate" value="<?php echo date_format($date,"Y-m-d"); ?>" class="form-control"></div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Advance Paid</label></div>    
                                                            <div class="col-12 col-md-5"><input type="number" id="pay" name="pay" class="form-control"></div>
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
        </div>
