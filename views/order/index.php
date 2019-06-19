         <div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Order</strong>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <form id="print-form" action="<?php echo URL; ?>order/printOrderExcel" target="_blank" method="post" class="form-horizontal">
                                                <div class="col-md-2">
                                                    <div class="input-group">
                                                        <input type="hidden" id="prtexceldate" name="prtexceldate" class="form-control" value="<?php echo date("Y-m-d"); ?>">  
                                                        <input type="hidden" id="url" name="url" value="<?php echo URL; ?>" class="form-control">
                                                        <a id="printExcel" href="#"><button type="submit" class="btn btn-info btn-sm" ><i class="fa fa-print"></i>&nbsp;Excel</button></a>
                                                    </div>
                                                </div>
                                            </form>
                                            <form id="print-form" action="<?php echo URL; ?>order/printOrder" target="_blank" method="post" class="form-horizontal">
                                                <div class="col-md-2">
                                                    <div class="input-group">
                                                        <input type="hidden" id="prtdate" name="prtdate" class="form-control" value="<?php echo date("Y-m-d"); ?>">  
                                                        <input type="hidden" id="url" name="url" value="<?php echo URL; ?>" class="form-control">
                                                        <a id="print" href="#"><button type="submit" class="btn btn-info btn-sm" ><i class="fa fa-print"></i>&nbsp;Print</button></a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="col-md-3 offset-md-5">
                                        <div class="card text-white bg-flat-color-1" style="font-size: 0.7rem;">
                                            <div class="card-body">
                                                <div class="card-left pt-1 float-left">
                                                    <h3 class="mb-0 fw-r">
                                                        <span class="currency float-left mr-1">฿</span>
                                                        <span class="stat-text" id="sumprice" >0</span>
                                                    </h3>
                                                    <p class="text-light mt-1 m-0">Advance</p>
                                                </div><!-- /.card-left -->

                                                <div class="card-right float-right text-right">
                                                    <i class="icon fade-5 icon-lg pe-7s-cart"></i>
                                                </div><!-- /.card-right -->

                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form id="save-form" action="<?php echo URL; ?>order/xhrSave" method="post" class="form-horizontal">
                                <div class="card">
                                    <div class="card-header">
                                        <!-- <form id="save" action="<?php echo URL; ?>order/xhrSave" method="post" class="form-horizontal"> -->
                                            <div class="row form-group">
                                                <div class="col-md-3 offset-md-3">
                                                    <div class="input-group">
                                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                                        <input type="date" id="orddate" name="orddate" class="form-control" value="<?php echo date("Y-m-d"); ?>">                                                        
                                                        <input type="hidden" id="current_date" name="current_date" class="form-control" value="<?php echo date("Y-m-d"); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <button id="save" class="btn btn-primary"><i class="ti ti-save"></i> Save </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-- </form> -->
                                    </div>
                                    <div id="msgMain" ></div>
                                
                                    <div class="card-body">
                                        <div class="custom-tab" id="order-tab">
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                <?php 
                                                foreach ($this->orderGrps as $ordGrp) {
                                                    echo '<a class="nav-item nav-link '.(($ordGrp['code'] == "1"?"active":"")).'" id="custom-nav-'.$ordGrp['code'].'-tab" data-toggle="tab" href="#custom-nav-'.$ordGrp['code'].'" role="tab" aria-controls="custom-nav-'.$ordGrp['code'].'" aria-selected="true">'.$ordGrp['descp'].'</a>
                                                    ';
                                                }
                                                ?>
                                                </div>
                                            </nav>
                                            <div class="tab-content pl-3 pt-2" id="nav-tabContent">
                                                <?php 
                                                $oldVal1 = "-1";
                                                $count = 0;
                                                foreach ($this->orders as $order) {
                                                    if ($oldVal1 != $order['val1']) {
                                                        if ($oldVal1 != -1) {
                                                            echo '
                                                            </div></div></div>
                                                            ';
                                                        }
                                                        $count = 0;
                                                        echo '<div class="tab-pane fade show '.(($order['val1'] == "1"?"active":"")).'" id="custom-nav-'.$order['val1'].'" role="tabpanel" aria-labelledby="custom-nav-'.$order['val1'].'-tab">
                                                        ';
                                                    }

                                                    if ($count%4 == 0) {
                                                        if ($count != 0) {
                                                            echo '
                                                            </div></div>
                                                            ';
                                                        }
                                                        echo '<div class="row form-group">
                                                                <div class="form-check-inline form-check col-md-12">
                                                        ';
                                                    }
                                                    echo '<div class="col-md-3">
                                                            <input type="checkbox" id="chkOrder'.$order['code'].'" name="items[]" value="'.$order['code'].'" class="form-check-input">
                                                            <span id="desc'.$order['code'].'" >'.$order['descp'].'</span>
                                                            <span class="text-info"> ( '.(isset($order['val3'])?$order['val3']:0).' ฿ )</span>
                                                            <input type="text" class="form-control field" id="qty'.$order['code'].'" name="qty'.$order['code'].'" disabled >
                                                            <input type="hidden" class="form-control" id="price'.$order['code'].'" name="price'.$order['code'].'" value="'.(isset($order['val3'])?$order['val3']:0).'" disabled >
                                                          </div>
                                                    ';
                                                     
                                                    $count++; 
                                                    $oldVal1 = $order['val1'];
                                                    
                                                }
                                                    echo '</div>
                                                    ';
                                                ?>
                                            </div>
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
