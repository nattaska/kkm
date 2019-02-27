<?php

// require 'models/parameter_model.php';

class Buffet extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $logged = Session::get('LoginData');
        if ($logged == false) {
            Session::destroy();
            header('location: login');
            exit;
        }
        
        $this->view->js = array(URL."views/buffet/default.js"
                                ,URL."assets/js/lib/chosen/chosen.jquery.min.js"
                            );

        // $this->view->css = array(URL.'assets/css/lib/datatable/dataTables.bootstrap.min.css');
        $this->view->css = array('https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css'
                                ,URL."assets/css/lib/chosen/chosen.min.css"
                                ,URL."public/css/default.css"
                            );
        
    }

    function index() {
        $date = new DateTime();

        $this->view->criteria = array("sdate" => date_format($date,"Y-m-01")
                                    , "edate" => date_format($date,"Y-m-t"));

        $this->paramModel->getParameter(2);
        $this->view->buffType = $this->paramModel->paramList;
        $this->view->render('buffet/index');
    }

    function xhrGetBuffetList() {
        $this->model->xhrGetBuffetList();
    }

}

?>