         <div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card border border-info">
                            <div class="card-header bg-info">
                                <strong class="card-title text-light">Customer Maintenance</strong>
                            </div>
                            <div class="card-body">
                                <form id="search" action="<?php echo URL; ?>customer/xhrSearch" method="post" class="form-horizontal">
                                    <!-- <div class="row form-group">
                                        <div class="col-md-3"></div>
                                        <div class="col-md-4"> -->
                                    <div class="row form-group">
                                        <div class="col-md-2"></div>
                                        <div class="col col-md-1"><label for="name-input" class=" form-control-label">ชื่อลูกค้า</label></div>
                                        <div class="col col-md-5"><input type="text" id="qname" name="qname" placeholder="ชื่อลูกค้า" class="form-control"></div>
                                        <div class="col col-md-2"><button class="btn btn-primary"> <i class="ti ti-search"></i> Search</button></div>
                                    </div>
                                </form>
                                <div id="msgMain" ></div>
                                    
                                <table id="table-data" class="table table-striped table-bordered dataTale" role="grid">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Tax No</th>
                                            <th>Address</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Tax No</th>
                                            <th>Address</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>

                                <div class="modal fade" id="modifyDataModel" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-md" role="document">
                                        <div class="modal-content border border-info">
                                            <div class="modal-header bg-info">
                                                <h5 class="modal-title text-light" id="staticModalLabel">Add Customer</h5>
                                            </div>
                                            <!-- class="form-horizontal" -->
                                            <form id="modify-data-form" action="" method="post" class="form-horizontal">
                                                <div class="modal-body">
                                                        <input type="hidden" id="url" name="url" value="<?php echo URL; ?>" class="form-control">
                                                        <input type="hidden" id="id" name="id" class="form-control">
                                                        <div class="row form-group">
                                                            <div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">ชื่อลูกค้า</label></div> 
                                                            <div class="col col-md-6"><input type="text" id="name" name="name" class="form-control" ></div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="text-input" class="form-control-label">เบอร์ติดต่อ</label></div>
                                                            <div class="col-12 col-md-6"><input type="text" id="phone" name="phone" class="form-control"></div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="text-input" class="form-control-label">เลขประจําตัวผู้เสียภาษี</label></div>
                                                            <div class="col-12 col-md-6"><input type="text" id="taxno" name="taxno" class="form-control"></div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col col-md-3"><label for="textarea-input" class=" form-control-label">ที่อยู่</label></div>
                                                            <div class="col-12 col-md-9"><textarea name="address" id="address" rows="5" class="form-control"></textarea></div>
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
