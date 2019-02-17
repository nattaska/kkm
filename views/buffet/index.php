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
                                <form id="search" action="<?php echo URL; ?>buffet/xhrGetBuffetList" method="post" class="form-horizontal">
                                    <div class="row form-group">
                                        <div class="col-md-4">
                                            <div class="input-group">
                                                <!-- <input type="hidden" id="prmid" name="prmid" class="form-control" value="2" > -->
                                                <div class="col-12 col-md-11">
                                                    <select name="bufftype" id="bufftype" class="form-control">
                                                        <option value="-1">All Buffet Type</option>
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

                            <div class="card-body">
                                <table id="buffetTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <td align="center" scope="col">Date</td>
                                            <td align="center" scope="col">Type</td>
                                            <td align="center" scope="col">PAX</td>
                                            <td scope="col">&nbsp;&nbsp;&nbsp;Group Name</td>
                                        </tr>
                                    </thead>
                                    <tbody id="listBuffet">
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
