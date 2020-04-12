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
        $valid = $this->model->validateLogin($_POST['usercode'], $_POST['password']);
        if($valid) {
            Session::init();
            Session::set('logged',$valid);

            $userModel = $this->loadModelByName("user");
            $userMenu = $userModel->getUserPermmission($_POST['usercode']);
            Session::set('userMenu',$userMenu);

            header('location: ../order');
            // header('location: ../timesheet');
        } else {
            Session::destroy();
            header('location: ../login');
            exit;
        }

    }

    function logout() {
        Session::destroy();
        header('location: ../login');
        exit;
    }

}

?>