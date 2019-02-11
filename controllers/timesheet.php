<?php

class Timesheet extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $loginData = Session::get('LoginData');
        // echo "logged = ".$logged."</br>";
        // print_r($logged);
        if ($loginData == false) {
            Session::destroy();
            header('location: login');
            exit;
        }

        $this->view->js = array('timesheet/default.js');
    }

    function index() {
        
        $date = new DateTime();
        $loginData = Session::get('LoginData');
        // echo print_r($loginData);

        // Session::set('criteriaTimesheet', $criteria);
        $this->view->criteria = array("code" => $loginData['code']
                                    , "nickname" => $loginData['nickname']
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