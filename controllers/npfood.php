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
        
        $this->view->js = array("../assets/js/lib/data-table/datatables.min.js",
                                "../assets/js/lib/data-table/dataTables.bootstrap.min.js",
                                "../assets/js/lib/data-table/dataTables.buttons.min.js",
                                "../assets/js/lib/data-table/buttons.bootstrap.min.js",
                                "../assets/js/lib/data-table/jszip.min.js",
                                "../assets/js/lib/data-table/vfs_fonts.js",
                                "../assets/js/lib/data-table/buttons.html5.min.js",
                                "../assets/js/lib/data-table/buttons.print.min.js",
                                "../assets/js/lib/data-table/buttons.colVis.min.js",
                                "../assets/js/init/datatables-init.js",
                                "npfood/default.js");

        $this->view->css = array(URL.'assets/css/lib/datatable/dataTables.bootstrap.min.css');
        // $this->view->css = array('//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css');
        
    }

    function index() {
        $date = new DateTime();

        $this->view->criteria = array("sdate" => date_format($date,"Y-m-01")
                                    , "edate" => date_format($date,"Y-m-t"));

        $this->view->render('npfood/index');
    }

    function xhrGetNPFoodList() {
        $this->model->xhrGetNPFoodList();
    }

    function xhrInsertNPFood() {
        $this->model->xhrInsertNPFood();
    }

    function xhrDeleteNPFood() {
        $this->model->xhrDeleteNPFood();
    }

    // function update() {
    //     $this->model->update();
    //     $this->view->msg = "Update successful";
    //     $this->view->render('profile/index');
    // }

}

?>