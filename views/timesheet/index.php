<?php 
        $loginData = Session::get('LoginData');
?>
<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Working Time</strong>
                    </div>

                    <div class="card-body">
                        <div class="card">
                            <div class="card-header">
                                <form id="search" action="<?php echo URL; ?>timesheet/xhrGetTimesheet" method="post" class="form-horizontal">
                                <!-- <form id="randomInsert" action="<?php echo URL; ?>dashboard/xhrInsert/" method="post"> -->
                                    <div class="row form-group">
                                        <div class="col-md-4">
                                            <div class="input-group">                                            
                                                <div class="col col-md-4">
                                                <input type="text" id="code" name="code" class="form-control" value="<?php echo $this->criteria['code']; ?>" <?php $retVal = ($loginData['pfcode']==1)?"":"disabled"; echo $retVal; ?>></div>
                                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                                <div class="col col-md-6"><input type="text" id="name" name="name" placeholder="<?php echo $this->criteria['nickname']; ?>" class="form-control" disabled></div>
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

                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Date</th>
                                            <th scope="col">Check In</th>
                                            <th scope="col">Check Out</th>
                                            <!-- <th scope="col">Handle</th> -->
                                        </tr>
                                    </thead>
                                    <tbody id="listTimesheet">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>                     
                </div>                     
            </div>
        </div>
    </div>
</div>