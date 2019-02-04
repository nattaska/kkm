<?php 

// $user =  $_SESSION['UserData'];
// echo "User : ".$user['nickname'];

?>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-lg-10">
                <div class="card border border-primary">
                    <div class="card-header bg-primary">
                        <strong class="card-title text-light">Profile</strong>
                    </div>
                    <div class="card-body">
                        <!-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p> -->
                        
                        <!-- <div class="row form-group">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">                         
                            <div class="input-group">
                                <p class="card-text">Employee Code   </p>
                                <input type="text" id="code" name="code" class="form-control" value="<?php echo $user['code']; ?>" ></div>
                            </div></div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="date" name="sdate" class="form-control" value="<?php echo $this->criteria['sdate']; ?>">
                                </div>
                            </div>
                            <div class="col-md-1"></div>
                        </div> -->
                        <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row form-group">
                                <div class="col col-md-3"><label class=" form-control-label">Employee Code</label></div>
                                    <div class="col-12 col-md-9">
                                        <p class="form-control-static"><?php echo $user['code']; ?></p>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">First Name</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="fname" name="text-input" placeholder="Text" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Last Name</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="lname" name="text-input" placeholder="Text" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nick Name</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="nname" name="text-input" placeholder="Text" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Position</label></div>
                                    <div class="col col-md-9">
                                        <div class="form-check-inline form-check">
                                            <label for="inline-radio1" class="form-check-label ">
                                                <input type="radio" id="pos1" name="position" value="1" class="form-check-input">Cashier
                                            </label>&nbsp;
                                            <label for="inline-radio2" class="form-check-label ">
                                                <input type="radio" id="pos2" name="position" value="2" class="form-check-input">Waiter
                                            </label>&nbsp;
                                            <label for="inline-radio3" class="form-check-label ">
                                                <input type="radio" id="pos3" name="position" value="3" class="form-check-input">Kitchen
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div>
<a href="<?php echo URL; ?>index/logout">Logout</a>