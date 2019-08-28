<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <div class="card border border-info">
                    <div class="card-header bg-info">
                        <strong class="card-title text-light">Baan Noppadol Food Order</strong>
                    </div>
                    <div class="card-body">
                        <form id="search" action="<?php echo URL; ?>npfood/xhrGetNPFoodList" method="post" class="form-horizontal">
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
                        <table id="table-npfood" class="table table-striped table-bordered dataTale" role="grid">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Order Date</th>
                                    <th>Room</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Ordere Date</th>
                                    <th>Room</th>
                                    <th>Total</th>
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
                                                <div class="col-12 col-md-3"><label for="text-input" class=" form-control-label">Order Id</label></div>
                                                <div class="col-12 col-md-5"><input class="form-control" type="text" id="ordid" name="ordid" placeholder="Order Id"></div>
                                            </div>
                                            <?php                                       
                                                $date = new DateTime();                                                            
                                            ?>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Order Date</label></div>
                                                <div class="col-12 col-md-5"><input type="date" id="orddate" name="orddate" value="<?php echo date_format($date,"Y-m-d"); ?>" class="form-control"></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Room</label></div>
                                                <div class="col-12 col-md-5">
                                                    <!-- <input type="text" id="room" name="room" placeholder="Room" class="form-control"> -->
                                                    <select name="room" id="room" class="form-control" data-placeholder="Choose a Room..." style="width: 150px">
                                                        <option value="" label="default"></option>
                                                        <?php 
                                                        foreach ($this->rooms as $room) {
                                                            echo '<option value="'.$room['code'].'">'.$room['code'].' - '.$room['val1'].'</option>
                                                            ';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Table&nbsp;</label></div>
                                                <div class="col-12 col-md-2"><input type="text" id="tabno" name="tabno" placeholder="-" class="form-control" readonly="readonly" tabindex="1"></div>
                                            </div>
                                            <div class="row form-group">
                                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Total</label></div>
                                                <div class="col-12 col-md-5"><input type="number" id="total" name="total" placeholder="Total" class="form-control"></div>
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
