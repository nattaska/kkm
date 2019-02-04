<?php

class Login extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        // echo "We are in index </br>";

        // $this->view->render('login/index');
    }

    function index() {
        // require 'models/login_model.php';
        // $model = new Login_Model();
        $this->view->render('login/index', true);
    }

    function login() {
        $this->model->login();
    }

    function logout() {
        Session::destroy();
        header('location: ../login');
        exit;
    }

}

?>