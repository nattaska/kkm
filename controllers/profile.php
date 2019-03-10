<?php

// require 'models/parameter_model.php';
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

        // $logged = Session::get('UserProfile');
        // $this->model->getProfile($logged['code']);
        $this->view->user = Session::get('UserProfile');

        // $paramObj = new Parameter_Model();
        $this->paramModel->getParameter(3);

        $this->view->depts = $this->paramModel->paramList;

        $this->paramModel->getParameter(4);
        $this->view->profiles = $this->paramModel->paramList;

        $this->view->render('profile/index');
    }

    function xhrGetUserLov() {
        $this->model->xhrGetUserLov();
    }

    function update() {
        $this->model->update();
        $this->view->user = $this->model->userProfile;
        $this->view->msg='Update successful';

        $this->view->render('profile/index');
    }

}

?>