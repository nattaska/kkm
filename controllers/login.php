<?php

class Login extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
    }

    function index() {
        $this->view->render('login/index', true);
    }

    function login() {
        $this->model->login();
        // $userModel = $this->loadModedl("User", true);
        $this->model->validateLogin($_POST['usercode'], $_POST['password']);

    }

    function logout() {
        Session::destroy();
        header('location: ../login');
        exit;
    }

}

?>