<?php

class Timesheet extends Controller {
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
                                ,URL."assets/js/lib/chosen/chosen.jquery.min.js"
                                ,"https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"
                                ,"https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"
                                ,URL."views/timesheet/js/default.js"
                                );

        $this->view->css = array(URL.'assets/css/lib/datatable/dataTables.bootstrap.min.css'
                                ,"https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"
                                ,URL."assets/css/lib/chosen/chosen.min.css"
                                ,"https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"
                                ,URL."css/style.css"
                                );

        // $this->view->js = array(URL.'views/timesheet/default.js');
    }

    function index() {
        
        $date = new DateTime();
        $this->view->criteria = array( "sdate" => date_format($date,"Y-m-d")
                                        , "edate" => date_format($date,"Y-m-d"));

        $this->view->render('timesheet/index');
    }

    function xhrGetUserLov() {
        $this->model->xhrGetUserLov();
    }

    function xhrUsername() {
        $this->model->xhrUsername();
    }

    function xhrGetTimesheet() {
        $this->model->xhrGetTimesheet();
    }

    function xhrSearch() {
        $this->model->xhrSearch();
    }

    function xhrInsert() {
        $this->model->xhrInsert();
    }

    function xhrUpdate() {
        $this->model->xhrUpdate();
    }

    function xhrDelete() {
        $this->model->xhrDelete();
    }

}

?>