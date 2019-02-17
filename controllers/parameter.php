<?php

class Parameter extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $logged = Session::get('LoginData');
        if ($logged == false) {
            Session::destroy();
            header('location: login');
            exit;
        }

        $this->view->js = array('parameter/default.js');        
    }

    function index() {
        $this->view->render('parameter/index');
    }

    function xhrGetParameter() {
        $this->model->xhrGetParameter();
    }

}

?>