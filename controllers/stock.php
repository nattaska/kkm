<?php

class Stock extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $logged = Session::get('logged');
        if ($logged == false) {
            Session::destroy();
            header('location: ../../login');
            exit;
        }
        $this->view->js = array(URL."views/stock/js/default.js");
        
    }

    function xhrPrepareStock() {
        $this->model->xhrPrepareStock();
    }

    function uploadStockSystem() {
        // $this->model->uploadStockSystem();
        $this->model->uploadStockSystemExcel();
    }

    function index($stkType) {

        $paramModel = $this->loadModelByName("parameter");

        $this->view->stkType = $stkType;
        $this->view->stkGrps = $paramModel->getParameter(11);
        $this->view->title = "";
        if ($stkType == "out") {
            $this->view->title = "Stock Count";
        } else if($stkType == "room") {
            $this->view->title = "Stock Room";
        } else if($stkType == "sys") {
            $this->view->title = "Stock System";
        } else if($stkType == "adj") {
            $this->view->title = "Stock Checking";
        }
        
        $date = new DateTime();
        $stkDate = (isset($_POST['stkDate']))?$_POST['stkDate']:date_format($date,"Y-m-d");
        $this->view->stkItems = $this->model->getStockByDate($stkDate);
        $this->view->preStockStat = (count($this->view->stkItems) == 0?true:false);

        $this->view->render('stock/index');
    }

    function xhrSearch() {
        $date = new DateTime();
        $stkDate = (isset($_POST['stkDate']))?$_POST['stkDate']:date_format($date,"Y-m-d");
        
        echo json_encode($this->model->getStockByDate($stkDate));
    }

    function xhrSave() {
        $this->model->xhrSave();
    }

}

?>