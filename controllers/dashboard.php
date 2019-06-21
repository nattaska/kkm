<?php

class Dashboard extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $logged = Session::get('logged');
        if ($logged == false) {
            Session::destroy();
            header('location: login');
            exit;
        }
        
        $this->view->js = array("https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.js"
                                ,"https://cdn.jsdelivr.net/npm/chartist-plugin-legend@0.6.2/chartist-plugin-legend.min.js"
                                ,URL."views/dashboard/js/default.js"
                                );

        $this->view->css = array("https://cdn.jsdelivr.net/npm/chartist@0.11.0/dist/chartist.min.css"
                                ,URL.'assets/css/lib/datatable/dataTables.bootstrap.min.css'
                                ,URL."views/dashboard/default.css"
                                );
        
    }

    function index() {

        $this->view->profit = $this->model->getProfitSummary();

        $this->view->render('dashboard/index');
    }

    function xhrGetProfitAllDays() {
        echo json_encode($this->model->getProfitAllDays());
    }

    function xhrSearch() {
        $this->model->xhrSearch();
    }

}

?>