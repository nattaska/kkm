<?php

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

        $this->view->js = array(URL."views/profile/js/default.js");
        
    }

    function index() {
        $userMenu = Session::get('userMenu');

        $this->view->user = $this->model->getProfile($userMenu['code']);

        $paramModel = $this->loadModelByName("Parameter");
        $this->view->depts = $paramModel->getParameter(3);

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