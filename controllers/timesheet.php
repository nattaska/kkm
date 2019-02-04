<?php

class Timesheet extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $user = Session::get('UserData');
        // echo "logged = ".$logged."</br>";
        // print_r($logged);
        if ($user == false) {
            Session::destroy();
            header('location: login');
            exit;
        }
        
        $date = new DateTime();

        // Session::set('criteriaTimesheet', $criteria);
        $this->view->criteria = array("code" => $user['code']
                                    , "nickname" => $user['nickname']
                                    , "sdate" => date_format($date,"Y-m-01")
                                    , "edate" => date_format($date,"Y-m-t"));

        $this->view->js = array('timesheet/js/default.js');
    }

    function index() {
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

    // function logout() {
    //     Session::destroy();
    //     header('location: ../login');
    //     exit;
    // }

    // function xhrInsert() {
    //     $this->model->xhrInsert();
    // }

    // function xhrDeleteListing() {
    //     $this->model->xhrDeleteListing();
    // }

}

?>