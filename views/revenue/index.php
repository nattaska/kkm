<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card border border-info">
                    <div class="card-header bg-info">
                        <strong class="card-title text-light">Revenue</strong>
                    </div>
                    <div class="card-body">
                        <form id="search" action="<?php echo URL; ?>revenue/xhrSearch" method="post" class="form-horizontal">
                            <div class="row form-group">
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="date" name="sdate" class="form-control" value="<?php echo $this->criteria['sdate']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-1"></div>
                                <div class="col-md-3">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="date" name="edate" class="form-control" value="<?php echo $this->criteria['edate']; ?>">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="input-group">
                                            <button class="btn btn-primary"><i class="ti ti-search"></i> Search </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="msgMain" ></div>
                            
                        <table id="table-data" class="table table-striped table-bordered dataTale" role="grid">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Amount</th>
                                    <th>Comment</th>
                                    <th>Title Code</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Date</th>
                                    <th>Title</th>
                                    <th>Amount</th>
                                    <th>Comment</th>
                                    <th>Title Code</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="modal fade" id="modifyDataModel" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content border border-info">
                                    <div class="modal-header bg-info">
                                        <h5 class="modal-title text-light" id="staticModalLabel">Add</h5>
                                    </div>
                                    <div id="msgModel" ></div>
                                    <form id="modify-data-form" action="" method="post" class="form-horizontal">
                                        <div class="modal-body">
                                            <input type="hidden" id="url" name="url" value="<?php echo URL; ?>" class="form-control">
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input" class="form-control-label">Date</label></div>
                                                <div class="col-12 col-md-5"><input type="date" id="pdate" name="pdate" value="<?php echo date_format($this->nowdate,"Y-m-d"); ?>" class="form-control"></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Title</label></div>
                                                <input type="hidden" id="title" name="title" value="" />
                                                <input type="hidden" name="code" value="selected_option_value_goes_here" />
                                                <div class="col-12 col-md-5">
                                                    <select name="code" id="code" class="chosen-select" data-placeholder="Choose a Revenue..." style="width: 150px">
                                                        <option value="" label="default"></option>
                                                        <?php 
                                                            foreach ($this->revenues as $revenue) {
                                                                echo '<option value="'.$revenue['code'].'">'.$revenue['code'].' - '.$revenue['descp'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Amount&nbsp;</label></div>
                                                <div class="col-12 col-md-5"><input type="number" step="0.01" id="amount" name="amount" value="0" class="form-control"></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="comment" class=" form-control-label">Comment</label></div>    
                                                <div class="col-12 col-md-8"><textarea name="comment" id="comment" rows="5" class="form-control"></textarea>
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
