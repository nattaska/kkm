        <div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card border border-info">
                            <div class="card-header bg-info">
                                <strong class="card-title text-light">Profit Report</strong>
                            </div>
                            <div class="card-body">
                                <form id="search" action="<?php echo URL; ?>report/searchProfit" method="post" class="form-horizontal">
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
                                        <tr title="">
                                            <th>Date</th>
                                            <th>Panda</th>
                                            <th>Grab</th>
                                            <th>Weserve</th>
                                            <th>Partner</th>
                                            <th>Noppadol</th>
                                            <th>Krua Kroo Meuk</th>
                                            <th>NP Staff</th>
                                            <th>Income</th>
                                            <th>Expense</th>
                                            <th>Net Income</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr title="">
                                            <th>Date</th>
                                            <th>Panda</th>
                                            <th>Grab</th>
                                            <th>Weserve</th>
                                            <th>Partner</th>
                                            <th>Noppadol</th>
                                            <th>Krua Kroo Meuk</th>
                                            <th>NP Staff</th>
                                            <th>Income</th>
                                            <th>Expense</th>
                                            <th>Net Income</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
