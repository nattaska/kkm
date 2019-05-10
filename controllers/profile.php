<?php

// require 'models/parameter_model.php';
// require 'models/profile_model.php';

class Profile extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $logged = Session::get('logged');
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

        $this->view->user = Session::get('UserProfile');

        $paramModel = $this->loadModelByName("Parameter");
        $this->view->depts = $paramModel->getParameter(3);
        $this->view->profiles = $paramModel->getParameter(4);

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