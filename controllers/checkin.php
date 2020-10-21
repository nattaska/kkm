<?php

class Checkin extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();

        $this->view->js = array(URL.'views/checkin/js/default.js');        
    }

    function index() {
        $this->view->render('checkin/index', true);
    }

    function xhrSearch() {
        $this->model->xhrSearch();
    }

    function xhrClocked() {
        $this->model->xhrClocked();
    }

}

?>