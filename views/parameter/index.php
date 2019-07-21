<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Parameter Maintenance</strong>
                    </div>

                    <div class="card-body">
                        <div class="card">
                            <div class="card-header">
                                <form id="search" action="<?php echo URL; ?>parameter/xhrSearch" method="post" class="form-horizontal">
                                    <div class="row form-group">
                                        <div class="col-md-6 offset-2">
                                            <div class="input-group">                                            
                                                <div class="col col-md-2">
                                                <input type="text" id="tbserch" name="tbserch" class="form-control" value="" ></div>
                                                <div class="input-group-addon"><i class="fa  fa-th-list"></i></div>
                                                <div class="col col-md-9"><input type="text" id="tbname" name="tbname" placeholder="" class="form-control" disabled></div>
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
                            </div>
                            
                            <div id="msgMain" ></div>

                            <div class="card-body">
                                <table id="table-data" class="table table-striped table-bordered dataTale" role="grid">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Value 1</th>
                                            <th>Value 2</th>
                                            <th>Value 3</th>
                                            <th>Value 4</th>
                                            <th>Value 5</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Code</th>
                                            <th>Description</th>
                                            <th>Value 1</th>
                                            <th>Value 2</th>
                                            <th>Value 3</th>
                                            <th>Value 4</th>
                                            <th>Value 5</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>  <!-- card body -->
                            <div class="modal fade" id="modifyDataModel" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticModalLabel">Add</h5>
                                        </div>
                                        <div id="msgModel" ></div>
                                        <form id="modify-data-form" action="" method="post" class="form-horizontal">
                                            <div class="modal-body">
                                                    <input type="hidden" id="url" name="url" value="<?php echo URL; ?>" class="form-control">
                                                    <div class="row form-group">
                                                        <div class="col col-md-3"><label for="tbno" class="form-control-label">Table No.</label></div>
                                                        <div class="col-12 col-md-3"><input type="text" id="tbno" name="tbno" value="" class="form-control" readonly></div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col col-md-3"><label for="name" class="form-control-label">Table Name.</label></div>
                                                        <div class="col-12 col-md-8"><input type="text" id="name" name="name" value="" class="form-control" readonly></div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col col-md-3"><label for="code" class="form-control-label">Code</label></div>
                                                        <div class="col-12 col-md-3"><input type="text" id="code" name="code" value="" class="form-control" ></div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col col-md-3"><label for="descp" class="form-control-label">Description</label></div>
                                                        <div class="col-12 col-md-8"><input type="text" id="descp" name="descp" value="" class="form-control" ></div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col col-md-3"><label for="val1" class="form-control-label">Value 1</label></div>
                                                        <div class="col-12 col-md-3"><input type="text" id="val1" name="val1" value="" class="form-control" ></div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col col-md-3"><label for="val2" class="form-control-label">Value 2</label></div>
                                                        <div class="col-12 col-md-3"><input type="text" id="val2" name="val2" value="" class="form-control" ></div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col col-md-3"><label for="val3" class="form-control-label">Value 3</label></div>
                                                        <div class="col-12 col-md-3"><input type="text" id="val3" name="val3" value="" class="form-control" ></div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col col-md-3"><label for="val4" class="form-control-label">Value 4</label></div>
                                                        <div class="col-12 col-md-3"><input type="text" id="val4" name="val4" value="" class="form-control" ></div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col col-md-3"><label for="val5" class="form-control-label">Value 5</label></div>
                                                        <div class="col-12 col-md-3"><input type="text" id="val5" name="val5" value="" class="form-control" ></div>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button id="confirmBtn" class="btn btn-primary" >Confirm</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                     
                </div>                     
            </div>
        </div>
    </div>
</div>