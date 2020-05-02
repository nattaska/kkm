<?php

class Report extends Controller {
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
                                // ,URL."assets/js/lib/chosen/chosen.jquery.min.js"
                                ,URL."public/js/jquery.number.min.js"
                                );

        $this->view->css = array(URL.'assets/css/lib/datatable/dataTables.bootstrap.min.css'
                                ,"https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"
                                ,"https://cdn.datatables.net/1.5.6/css/buttons.dataTables.min.css"
                                ,URL."css/style.css"
                                );
        
    }

    function profitrpt() {

        array_push($this->view->js, URL."views/report/js/profitrpt.js");
        $date = new DateTime();
        $date->modify("last day of previous month");

        $this->view->criteria = array("sdate" => date_format($date,"Y-m-01")
                                    , "edate" => date_format($date,"Y-m-t"));
        // $this->view->criteria = array("sdate" => '2019-08-01'
        //                             , "edate" => '2019-08-30');

        $this->view->render('report/profitrpt');
    }

    function searchProfit() {
        $this->model->getProfit();
    }

}

?>