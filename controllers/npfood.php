<?php

class NPFood extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $logged = Session::get('logged');
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
                                ,URL."views/npfood/js/default.js"
                                ,URL."assets/js/lib/chosen/chosen.jquery.min.js"
                                ,URL."public/js/jquery.number.min.js"
                                );

        $this->view->css = array(URL.'assets/css/lib/datatable/dataTables.bootstrap.min.css'
                                ,"https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"
                                ,URL."assets/css/lib/chosen/chosen.min.css"
                                );
        
    }

    function index() {
        $date = new DateTime();

        $this->view->criteria = array("sdate" => date_format($date,"Y-m-01")
                                    , "edate" => date_format($date,"Y-m-t"));

        $paramModel = $this->loadModelByName("Parameter");
        $this->view->rooms = $paramModel->getParameter(5);

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

        $paramModel = $this->loadModelByName("Parameter");
        $rooms = $paramModel->getParameter(5);
        foreach ($rooms as $row) {
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