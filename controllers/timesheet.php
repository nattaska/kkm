<?php

class Timesheet extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $logged = Session::get('logged');
        if ($logged == false) {
            Session::destroy();
            header('location: login');
            exit;
        }

        $this->view->js = array(URL.'views/timesheet/default.js');
    }

    function index() {
        
        $date = new DateTime();
        $userMenu = Session::get('userMenu');

        $this->view->criteria = array("code" => $userMenu['code']
                                    , "nickname" => $userMenu['nickname']
                                    , "sdate" => date_format($date,"Y-m-01")
                                    , "edate" => date_format($date,"Y-m-t"));

        $this->view->render('timesheet/index');
    }

    function xhrGetUserLov() {
        $this->model->xhrGetUserLov();
    }

    function xhrUsername() {
        $this->model->xhrUsername();
    }

    function xhrGetTimesheet() {
        $this->model->xhrGetTimesheet();
    }

}

?>