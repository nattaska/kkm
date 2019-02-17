<div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Baan Noppadol Food Order</strong>
                            </div>
                            <div class="card-body">
                                <div class="card">
                                    <div class="card-header">
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
                                                    <label for="sdate" class="control-label mb-1">End Date</label>
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                        <input type="date" name="edate" class="form-control" value="<?php echo $this->criteria['edate']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="sdate" class="control-label mb-1"></label>
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
                                
                                    <div class="card-body">
                                        <!-- <table id="bootstrap-data-table" class="table table-striped table-bordered"> -->
                                        <!-- <table id="table-npfood" class="table table-striped table-bordered"> -->
                                        <table id="example" class="display" width="100%"></table>
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Ordere Date</th>
                                                    <th>Room</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Ordere Date</th>
                                                    <th>Room</th>
                                                    <th>Total</th>
                                                </tr>
                                            </tfoot>
                                            <!-- <tbody id="listNPFood">
                                            </tbody> -->
                                            <!-- <tbody>
                                                <tr>
                                                    <td>Tiger Nixon</td>
                                                    <td>System Architect</td>
                                                    <td>Edinburgh</td>
                                                    <td>$320,800</td>
                                                </tr>
                                                <tr>
                                                    <td>Garrett Winters</td>
                                                    <td>Accountant</td>
                                                    <td>Tokyo</td>
                                                    <td>$170,750</td>
                                                </tr>
                                                <tr>
                                                    <td>Ashton Cox</td>
                                                    <td>Junior Technical Author</td>
                                                    <td>San Francisco</td>
                                                    <td>$86,000</td>
                                                </tr>
                                            </tbody> -->
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- .animated -->
        </div><!-- .content -->
        <!-- <script type="text/javascript">
        $(document).ready(function() {
          $('#bootstrap-data-table-export').DataTable();
      } ); -->
  <!-- </script> -->