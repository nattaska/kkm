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
        $this->view->js = array(URL."views/stock/js/default.js");
        
    }

    function xhrPrepareStock() {
        $this->model->xhrPrepareStock();
    }

    function index($stkType) {

        $paramModel = $this->loadModelByName("parameter");

        $this->view->stkType = $stkType;
        $this->view->stkGrps = $paramModel->getParameter(11);
        
        $date = new DateTime();
        $stkDate = (isset($_POST['stkDate']))?$_POST['stkDate']:date_format($date,"Y-m-d");
        $this->view->stkItems = $this->model->getStockByDate($stkDate);
        $this->view->preStockStat = (count($this->view->stkItems) == 0?true:false);

        $this->view->render('stock/index');
    }

    function xhrSearch() {
        $date = new DateTime();
        $stkDate = (isset($_POST['stkDate']))?$_POST['stkDate']:date_format($date,"Y-m-d");
        // $this->view->stkItems = $this->model->getStockByDate($stkDate);
        // print_r($this->view->stkItems);

        echo json_encode($this->model->getStockByDate($stkDate));
        // $this->view->preStockStat = false;
    }

    function xhrSave() {
        $this->model->xhrSave();
    }

    function stkcompare() {

        $this->view->js = array(URL."views/stock/js/stkcompare.js");
        $paramModel = $this->loadModelByName("parameter");

        $this->view->stkGrps = $paramModel->getParameter(11);
        $this->view->stkItems = $paramModel->getParameter(12);

        $this->view->render('stock/stkcompare_view');
    }

}

?>