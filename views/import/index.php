         <div class="content">
            <div class="animated fadeIn">
                <div class="row">

                    <div class="col-md-12">
                        <div class="card border border-info">
                            <div class="card-header bg-info">
                                <strong class="card-title text-light">Import</strong>
                            </div>
                            <div class="card-body">
                                <form id="upload-form" method='post' action="" enctype="multipart/form-data">
                                <div class="row form-group">
                                    <div class="col-md-8 offset-2">
                                        <div class="input-group"> 
                                            <select id="filetype" name="filetype">
                                                <option value="">--Please Choose File Type--</option>
                                                <!-- <option value="sale">Sales File</option>
                                                <option value="stock">Stock File</option> -->

                                                <?php 
                                                foreach ($this->filetypes as $filetype) {
                                                ?>
                                                <option value="<?php echo $filetype['val1']; ?>"><?php echo $filetype['descp']; ?></option>
                                                <?php } ?>
                                            </select>  &nbsp;
                                            <input type='file' name='file' id='file' accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" class='form-control' >&nbsp;
                                            <button type="submit" id="upload" class="btn btn-primary"><i class="fa fa-upload"></i> Upload </button>
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <div id="msgMain" ></div>
                            </div>
                        </div>
                    </div>
                </div>      
            </div><!-- .animated -->
        </div><!-- .content -->
