<?php

require 'models/parameter_model.php';

class Profile extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $logged = Session::get('UserData');
        // echo "logged = ".$logged."</br>";
        if ($logged == false) {
            Session::destroy();
            header('location: login');
            exit;
        }

        $paramObj = new Parameter_Model();
        $paramObj->getParameter(3);

        $this->view->depts  =$paramObj->param;
        // echo "We are in index </br>";
        print_r($this->view->depts);

        // $this->view->render('index/index');
    }

    function index() {
        $this->view->render('profile/index');
    }

}

?>