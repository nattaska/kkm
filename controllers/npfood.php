<?php

class NPFood extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $logged = Session::get('LoginData');
        if ($logged == false) {
            Session::destroy();
            header('location: login');
            exit;
        }
        
        $this->view->js = array(URL."assets/js/lib/data-table/datatables.min.js"
                                ,URL."assets/js/lib/data-table/dataTables.bootstrap.min.js"
                                ,URL."assets/js/lib/data-table/dataTables.buttons.min.js"
                                ,URL."assets/js/lib/data-table/buttons.bootstrap.min.js"
                                ,URL."assets/js/lib/data-table/jszip.min.js"
                                ,URL."assets/js/lib/data-table/vfs_fonts.js"
                                ,URL."assets/js/lib/data-table/buttons.html5.min.js"
                                ,URL."assets/js/lib/data-table/buttons.print.min.js"
                                ,URL."assets/js/lib/data-table/buttons.colVis.min.js"
                                ,URL."assets/js/init/datatables-init.js"
                                ,URL."views/npfood/default.js"
                                ,"https://code.jquery.com/ui/1.12.1/jquery-ui.js"
                                ,URL."assets/js/lib/chosen/chosen.jquery.min.js"
                                );

        $this->view->css = array(URL.'assets/css/lib/datatable/dataTables.bootstrap.min.css',
                                 "https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"
                                 ,URL."assets/css/lib/chosen/chosen.min.css"
                                 ,URL."public/css/default.css"
                                );
        
    }

    function index() {
        $date = new DateTime();

        $this->view->criteria = array("sdate" => date_format($date,"Y-m-01")
                                    , "edate" => date_format($date,"Y-m-t"));

        $this->paramModel->getParameter(5);
        $this->view->rooms = $this->paramModel->paramList;

        $this->view->render('npfood/index');
    }

    function xhrGetNPFoodList() {
        $this->model->xhrGetNPFoodList();
    }

    function xhrInsertNPFood() {
        $this->model->xhrInsertNPFood();
    }

    function xhrUpdateNPFood() {
        $this->model->xhrUpdateNPFood();
    }

    function xhrDeleteNPFood() {
        $this->model->xhrDeleteNPFood();
    }

    function xhrGetRoomLov() {
        $arr = [];
        $i = 0;
        $this->paramModel->getParameter(5);
        foreach ($this->paramModel->paramList as $row) {
            $arr[$i]=(array('value' => $row["code"]
                          , 'label' => $row["code"].' - T'.$row["val1"]));
            $i++;
        }

        echo json_encode($arr);
    }

    function xhrGetTable() {
        $this->model->xhrGetTable();
    }

    // function update() {
    //     $this->model->update();
    //     $this->view->msg = "Update successful";
    //     $this->view->render('profile/index');
    // }

}

?>