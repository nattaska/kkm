<?php

class Index extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $logged = Session::get('LoginData');

        if ($logged == false) {
            Session::destroy();
            header('location: login');
            exit;
        }
    }

    function index() {
        header('location: timesheet');
    }

    function logout() {
        Session::destroy();
        header('location: ../login');
        exit;
    }

}

?>