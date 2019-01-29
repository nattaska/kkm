<?php

class Index extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $logged = Session::get('UserData');
        if ($logged == false) {
            Session::destroy();
            header('location: login');
            exit;
        }
        // echo "We are in index </br>";

        // $this->view->render('index/index');
    }

    function index() {
        $this->view->render('index/index');
    }

    function details() {
        $this->view->render('index/index');
    }

}

?>