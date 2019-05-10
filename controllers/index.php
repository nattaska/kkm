<?php

class Index extends Controller {
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

    function index() {
        $logged = Session::get('logged');

        if ($logged == false) {
            Session::destroy();
            header('location: login');
            exit;
        }
        header('location: timesheet');
    }

    function logout() {
        Session::destroy();
        header('location: ../login');
        exit;
    }

}

?>