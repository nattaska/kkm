<?php

class Stock extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $logged = Session::get('logged');
        if ($logged == false) {
            Session::destroy();
            header('location: login');
            exit;
        }     
        
    }

    function stkcount() {

        $this->view->js = array(URL."views/stock/js/stkcount.js");

        $paramModel = $this->loadModelByName("parameter");

        $this->view->stkGrps = $paramModel->getParameter(11);
        $this->view->stkItems = $paramModel->getParameter(12);

        $this->view->render('stock/stkcount_view');
    }

    function stkcompare() {

        $this->view->js = array(URL."views/stock/js/stkcompare.js");
        $paramModel = $this->loadModelByName("parameter");

        $this->view->stkGrps = $paramModel->getParameter(11);
        $this->view->stkItems = $paramModel->getParameter(12);

        $this->view->render('stock/stkcount_view');
    }

    function stkroom() {

        $this->view->js = array(URL."views/stock/js/stkroom.js");

        $paramModel = $this->loadModelByName("parameter");

        $this->view->stkGrps = $paramModel->getParameter(11);
        $this->view->stkItems = $paramModel->getParameter(12);

        $this->view->render('stock/stkroom_view');
    }

    function xhrSaveCounting() {
        $this->model->xhrSaveCounting();
    }

    function xhrSearchCounting() {
        $this->model->xhrSearchCounting();
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