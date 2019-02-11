<?php

require 'models/parameter_model.php';
// require 'models/profile_model.php';

class Profile extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $logged = Session::get('LoginData');
        // echo "logged = ".$logged."</br>";
        if ($logged == false) {
            Session::destroy();
            header('location: login');
            exit;
        }

        // $this->model->getProfile($logged['code']);
        // $profObj = new Profile_Model();
        // $profObj->getProfile($logged['code']);
        // $this->view->user = $profObj->userProfile;

        // echo "We are in index </br>";
        $this->view->js = array('profile/default.js');
        
    }

    function index() {

        $logged = Session::get('LoginData');
        $this->model->getProfile($logged['code']);
        $this->view->user = $this->model->userProfile;

        $paramObj = new Parameter_Model();
        $paramObj->getParameter(3);

        $this->view->depts = $paramObj->param;

        $paramObj->getParameter(4);
        $this->view->profiles = $paramObj->param;

        $this->view->render('profile/index');
    }

    function update() {
        $this->model->update();
        $this->view->msg = "Update successful";
        $this->view->render('profile/index');
    }

}

?>