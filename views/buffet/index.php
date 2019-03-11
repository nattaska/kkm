<?php 
        // $loginData = Session::get('LoginData');
?>
<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Buffet</strong>
                    </div>
                    <div class="card-body">
                        <div class="card">
                            <div class="card-header">
                                <form id="search" action="<?php echo URL; ?>buffet/xhrSearch" method="post" class="form-horizontal">
                                    <div class="row form-group">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <div class="col-12 col-md-11">
                                                    <!-- <select name="bufftype" id="bufftype" class="chosen" tabindex="1"> -->
                                                    <select name="bufftype" id="bufftype" class="chosen-select" style="width: 150px">
                                                        <option value="-1">----&nbsp;All Buffet Type&nbsp;----</option>
                                                        <?php 
                                                        foreach ($this->buffType as $type) {
                                                            echo '<option value="'.$type['code'].'">'.$type['code'].' - '.$type['descp'].'</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input type="date" name="sdate" class="form-control" value="<?php echo $this->criteria['sdate']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input type="date" name="edate" class="form-control" value="<?php echo $this->criteria['edate']; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="input-group">
                                                <!-- <div class="input-group-btn"> -->
                                                    <button class="btn btn-primary"> 
                                                        <i class="ti ti-search"></i> Search
                                                    </button>
                                                <!-- </div> -->
                                                <!-- <input class="btn btn-outline-primary" type="submit" value="Search"> -->
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
                                            <th>Date</th>
                                            <th>Type Code</th>
                                            <th>Type</th>
                                            <th>PAX</th>
                                            <th>Group Name</th>
                                            <th>Amount</th>
                                            <th>Commission</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Date</th>
                                            <th>Type Code</th>
                                            <th>Type</th>
                                            <th>PAX</th>
                                            <th>Group Name</th>
                                            <th>Amount</th>
                                            <th>Commission</th>
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
                                                    <?php
                                                        $date = new DateTime();                                                            
                                                    ?>
                                                    <div class="row form-group">
                                                        <div class="col col-md-3"><label for="text-input" class="form-control-label">Buffet Date</label></div>
                                                        <div class="col-12 col-md-5"><input type="date" id="bfdate" name="bfdate" value="<?php echo date_format($date,"Y-m-d"); ?>" class="form-control"></div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Type</label></div>
                                                        <input type="hidden" name="bftype" value="selected_option_value_goes_here" />
                                                        <div class="col-12 col-md-6">
                                                            <!-- <input type="text" id="room" name="room" placeholder="Room" class="form-control"> -->
                                                            <select name="bftype" id="bftype" class="chosen-select" data-placeholder="Choose a Type..." style="width: 150px">
                                                                <option value="" label="default"></option>
                                                                <?php 
                                                                foreach ($this->buffType as $type) {
                                                                    // echo '<option value="'.$type['code'].'">'.$type['code'].' - '.$type['descp'].'</option>
                                                                    echo "<option value='".json_encode($type)."'>".$type['code']." - ".$type['descp']."</option>
                                                                    ";
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Type name&nbsp;</label></div>
                                                        <div class="col-12 col-md-5"><input type="text" id="typename" name="typename" placeholder="" class="form-control" readonly="readonly" tabindex="1"></div>
                                                    </div>
                                                    <div class="row form-group">
                                                        <div class="col col-md-3"><label for="text-input" class=" form-control-label">Group Name</label></div>    
                                                        <div class="col-12 col-md-5"><input type="text" id="grp" name="grp" class="form-control" value="-" readonly="readonly"></div>
                                                    </div> 
                                                    <div class="row form-group">
                                                        <div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">PAX</label></div>                                          
                                                        <div class="col col-md-3"><input type="number" id="qty" name="qty" class="form-control"></div>
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
</div>
