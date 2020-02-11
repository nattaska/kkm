<?php

// require 'models/parameter_model.php';

class Buffet extends Controller {
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
                                ,URL."views/buffet/js/default.js"
                                ,URL."assets/js/lib/chosen/chosen.jquery.min.js"
                                ,URL."public/js/jquery.number.min.js"
                            );

        $this->view->css = array('https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css'
                                ,URL."assets/css/lib/chosen/chosen.min.css"
                                ,URL."public/css/default.css"
                                ,URL."css/style.css"
                            );
        
    }

    function index() {
        $date = new DateTime();

        $this->view->criteria = array("sdate" => date_format($date,"Y-m-d")
                                    , "edate" => date_format($date,"Y-m-d"));

        $paramModel = $this->loadModelByName("parameter");
        $this->view->buffType = $paramModel->getParameter(2);

        $this->view->render('buffet/index');
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