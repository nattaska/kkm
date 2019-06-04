<?php

class Order extends Controller {
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
                                ,URL."views/order/js/default.js"
                                );

        $this->view->css = array(URL.'assets/css/lib/datatable/dataTables.bootstrap.min.css'
                                ,"https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"
                                ,URL."assets/css/lib/chosen/chosen.min.css"
                                );
        
    }

    function index() {

        $paramModel = $this->loadModelByName("parameter");

        $this->view->orderGrps = $paramModel->getParameter(6);
        $this->view->orders = $paramModel->getParameter(7);

        $this->view->render('order/index');
    }

    function xhrSave() {
        $this->model->xhrSave();
    }

    function xhrSearch() {
        $this->model->xhrSearch();
    }

    function printOrder() {
        
        $date = new DateTime();
        $orddate = (isset($_POST['prtdate']))?$_POST['prtdate']:date_format($date,"Y-m-d");
        $this->view->orddate = $orddate;
        $this->view->items = $this->model->printOrder($orddate);
        // print_r($this->view->items);

        $this->view->render('order/printOrder', true);
    }

}

?>