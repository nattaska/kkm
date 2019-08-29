<?php

class Import extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $logged = Session::get('logged');
        if ($logged == false) {
            Session::destroy();
            header('location: login');
            exit;
        }
        $this->view->js = array(URL."views/import/js/default.js");
        
    }

    function index() {
        $paramModel = $this->loadModelByName("parameter");
        $this->view->filetypes = $paramModel->getParameter(13);
        $this->view->render('import/index');
    }

    function importSales() {
        // echo "importSales";
        $this->model->importOchaSales();
    }

    function importStocks() {
        echo "importStocks";
        // $this->model->importOchaStocks();
    }

}

?>