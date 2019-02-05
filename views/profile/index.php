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
                                <div class="col col-md-3"><label class=" form-control-label">Employee Code</label></div>
                                    <div class="col-12 col-md-9">
                                        <p class="form-control-static"><?php echo $user['code']; ?></p>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">First Name</label></div>
                                    <div class="col-12 col-md-3"><input type="text" id="fname" name="fname" value="<?php echo $user['firstname']; ?>" placeholder="First Name" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Last Name</label></div>
                                    <div class="col-12 col-md-3"><input type="text" id="lname" name="lname" value="<?php echo $user['lastname']; ?>" placeholder="Last Name" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Nick Name</label></div>
                                    <div class="col-12 col-md-3"><input type="text" id="nname" name="nname" value="<?php echo $user['nickname']; ?>" placeholder="Nick Name" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Department</label></div>
                                    <div class="col col-md-9">
                                        <div class="form-check-inline form-check">
                                            <?php 
                                            foreach ($this->depts as $dept) {
                                            ?>
                                            <label for="dept-radio<?php echo $dept['code']; ?>" class="form-check-label">
                                                <input type="radio" id="dept<?php echo $dept['code']; ?>" name="department" value="<?php echo $dept['code']; ?>" class="form-check-input" <?php if ($dept['code']==$user['deptid']) {echo "checked";} ?> ><?php echo $dept['descp']; ?>
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Profile</label></div>
                                    <div class="col col-md-9">
                                        <div class="form-check-inline form-check">
                                            <?php 
                                            foreach ($this->profiles as $profile) {
                                            ?>
                                            <label for="profile-radio<?php echo $profile['code']; ?>" class="form-check-label">
                                                <input type="radio" id="profile<?php echo $profile['code']; ?>" name="profile" value="<?php echo $profile['code']; ?>" class="form-check-input" <?php if ($profile['code']==$user['pfcode']) {echo "checked";} ?> ><?php echo $profile['descp']; ?>
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="number-input" class=" form-control-label">Payroll cycle</label></div>
                                    <div class="col-12 col-md-2"><input type="number" id="paymethd" name="number-input" value="<?php echo $user['paymethd']; ?>" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label class=" form-control-label">Payment Type</label></div>
                                    <div class="col col-md-9">
                                        <div class="form-check-inline form-check">
                                            <label for="paytype-radio1" class="form-check-label">
                                                <input type="radio" id="paytype0" name="paytype" value="0" class="form-check-input" <?php if ($user['paytype']==0) {echo "checked";} ?> >Cash
                                            </label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <label for="paytype-radio2" class="form-check-label">
                                                <input type="radio" id="paytype1" name="paytype" value="1" class="form-check-input" <?php if ($user['paytype']==1) {echo "checked";} ?> >Bank
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="text-input" class=" form-control-label">Bank Account</label></div>
                                    <div class="col-12 col-md-3"><input type="text" id="account" name="account" value="<?php echo $user['account']; ?>" class="form-control"></div>
                                    <div class="col-12 col-md-3"><input type="hidden" id="acchide" name="acchide" value="<?php echo $user['account']; ?>" class="form-control"></div>
                                </div>
                                <div class="row form-group">
                                    <div class="col col-md-3"><label for="number-input" class=" form-control-label">ประกันสังคม</label></div>
                                    <div class="col-12 col-md-2"><input type="number" id="paysso" name="paysso" value="<?php echo $user['paysso']; ?>" class="form-control"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <?php  echo print_r($user); ?>
                </div>
            </div>
        </div>
    </div>
</div>