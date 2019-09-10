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
                        <form action="#" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="row form-group">
                                <div class="col col-md-3"><label class=" form-control-label">User Code</label></div>
                                    <div class="col-12 col-md-9">
                                        <p class="form-control-static"><?php echo $user['code']; ?></p>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">First Name</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="fname" name="text-input" value="<?php echo $user['firstname']; ?>" placeholder="Text" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Last Name</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="lname" name="text-input" value="<?php echo $user['lastname']; ?>" placeholder="Text" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nick Name</label></div>
                                    <div class="col-12 col-md-9"><input type="text" id="nname" name="text-input" value="<?php echo $user['nickname']; ?>" placeholder="Text" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Department</label></div>
                                    <div class="col col-md-9">
                                        <div class="form-check-inline form-check">
                                            <label for="inline-radio1" class="form-check-label">
                                                <input type="radio" id="dept1" name="department" value="1" class="form-check-input" checked>Cashier
                                            </label>&nbsp;
                                            <label for="inline-radio2" class="form-check-label">
                                                <input type="radio" id="dept2" name="department" value="2" class="form-check-input">Waiter
                                            </label>&nbsp;
                                            <label for="inline-radio3" class="form-check-label">
                                                <input type="radio" id="dept3" name="department" value="3" class="form-check-input">Kitchen
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
<!-- <a href="<?php echo URL; ?>index/logout">Logout</a> -->