         <div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card border border-info">
                            <div class="card-header bg-info">
                                <strong class="card-title text-light"><?php echo $this->title; ?></strong>
                            </div>
                            <div class="card-body">
                                <form id="prepare-form" action="<?php echo URL; ?>stock/xhrPrepareStock" method="post" class="form-horizontal">
                                    <div class="col-md-12">
                                        <div class="input-group">
                                            <input type="hidden" id="url" name="url" value="<?php echo URL; ?>" class="form-control">
                                <?php 
                                if ($this->preStockStat) {
                                ?>
                                            <a id="genStock" href="#" ><button type="button" class="btn btn-info btn-sm" ><i class="fa fa-copy"></i>&nbsp;Prepare Stock</button></a>
                                <?php 
                                }
                                if ($this->stkType == "sys") {
                                ?>
                                            &nbsp;<button type="button" id="upload-btn" class="btn btn-info btn-sm" data-toggle="modal" data-target="#uploadModal"><i class="fa fa-upload"></i> Upload file</button>
                                <?php 
                                }
                                ?>
                                        </div>
                                    </div>
                                </form>
                                <?php 
                                
                                if ($this->stkType == "sys") {
                                ?>
                                <!-- Modal -->
                                <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="staticModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-md" role="document">
                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                <h4 class="modal-title">File upload</h4>
                                            </div>
                                            <div class="modal-body">
                                                <!-- Form -->
                                                <form id="upload-form" method='post' action="" enctype="multipart/form-data">
                                                <div class="row form-group">
                                                    <div class="col-md-12">
                                                        <div class="input-group">
                                                            <input type='file' name='stkfile' id='stkfile' accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class='form-control' >&nbsp;
                                                            <button type="submit" id="upload" class="btn btn-primary"><i class="fa fa-upload"></i> Upload </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                                <div id='msgModel'></div>
                                            </div>                                    
                                        </div>

                                    </div>
                                </div>
                                <?php  } ?>
                                <form id="save-form" action="<?php echo URL; ?>stock/xhrSave" method="post" class="form-horizontal">
                                    <div class="row form-group">
                                        <div class="col-md-3 offset-md-3">
                                            <div class="input-group">
                                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                <input type="date" id="stkDate" name="stkDate" class="form-control" value="<?php echo date("Y-m-d"); ?>" <?php echo ($userMenu['role']=='STA'?'readonly':''); ?>>
                                                <input type="hidden" id="stkType" name="stkType" value="<?php echo $this->stkType; ?>" class="form-control">
                                                <input type="hidden" id="current_date" name="current_date" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <button id="save" class="btn btn-primary"><i class="ti ti-save"></i> Save </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="msgMain" ></div>
                                
                                    <div id="listItems">
                                        <div class="custom-tab" id="order-tab">
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <?php 
                                                foreach ($this->stkGrps as $stkGrp) {
                                                    echo '<a class="nav-item nav-link '.(($stkGrp['code'] == "1"?"active":"")).'" id="custom-nav-'.$stkGrp['code'].'-tab" data-toggle="tab" href="#custom-nav-'.$stkGrp['code'].'" role="tab" aria-controls="custom-nav-'.$stkGrp['code'].'" aria-selected="true">'.$stkGrp['descp'].'</a>
                                                    ';
                                                }
                                                ?>
                                                </div>
                                            </nav>
                                            <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                                <?php 
                                                $oldGroup = "-1";
                                                $count = 0;
                                                $divide = ($this->isMobile()?1:4);

                                                foreach ($this->stkItems as $stkItem) {
                                                    if ($oldGroup != $stkItem['group']) {
                                                        if ($oldGroup != -1) {
                                                            echo '
                                                            </div></div></div>
                                                            ';
                                                        }
                                                        $count = 0;
                                                        echo '<div class="tab-pane fade show '.(($stkItem['group'] == "1"?"active":"")).'" id="custom-nav-'.$stkItem['group'].'" role="tabpanel" aria-labelledby="custom-nav-'.$stkItem['group'].'-tab">
                                                        ';
                                                    }

                                                    if ($count%$divide == 0) {
                                                        if ($count != 0) {
                                                            echo '
                                                            </div></div>
                                                            ';
                                                        }
                                                        echo '<div class="row form-group">
                                                                <div class="form-check-inline form-check col-md-12">
                                                        ';
                                                    }
                                                    echo '<div class="col-md-1 input-group">
                                                            <input type="number" step="1" class="form-control" id="'.$stkItem['code'].'" name="items['.$stkItem['code'].']" value="'.$stkItem[$this->stkType.'qty'].'" '.($this->stkType === "adj"?"readonly":"").' >                                                         
                                                          </div>
                                                          <div class="col-md-2">
                                                          ';
                                                        if ( $this->stkType === "room" ) {
                                                            echo '<span class="badge badge-info">x '.$stkItem['unit'].'</span>&nbsp; ';
                                                        }

                                                        $descStyle = '';

                                                        if ($this->stkType === "adj" && $stkItem[$this->stkType.'qty'] != 0) {
                                                            if ($stkItem[$this->stkType.'qty'] < 0) {
                                                                $descStyle = 'class="bg-danger text-white"';
                                                                // $descStyle = 'class="text-danger"';
                                                            } else if ($stkItem[$this->stkType.'qty'] > 0) {
                                                                $descStyle = 'class="bg-primary text-white"';
                                                                // $descStyle = 'class="text-primary"';
                                                            }

                                                        }
                                                            echo '<label for="'.$stkItem['code'].'" '.$descStyle.'> '.$stkItem['descp'].' </label>
                                                          </div>
                                                    ';
                                                     
                                                    $count++; 
                                                    $oldGroup = $stkItem['group'];                                                    
                                                    
                                                }
                                                    echo '</div>
                                                    ';
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>                      
            </div><!-- .animated -->
        </div><!-- .content -->
