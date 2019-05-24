<?php

class Test extends Controller {
    function __construct(){
        parent::__construct();

    }

    function index() {
        $userModel = $this->loadModelByName("user");
        
        // $this->view->users=$userModel->getUserPermmission("60001");
        $userMenu = $userModel->getUserPermmission("60001");
        Session::set('userMN',$userMenu);
        $this->view->render('test/index', true);
    }
}