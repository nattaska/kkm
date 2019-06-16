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
        
        $this->view->js = array(URL."views/order/js/default.js");        
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

        $this->view->render('order/printOrder', true);
    }

    function printOrderExcel() {
        
        $date = new DateTime();
        $orddate = (isset($_POST['prtexceldate']))?$_POST['prtexceldate']:date_format($date,"Y-m-d");
        $this->view->orddate = $orddate;
        $this->view->items = $this->model->printOrder($orddate);

        $this->view->render('order/printOrderExcel',true);
    }

}

?>