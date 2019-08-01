<?php

class Permission extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();
        $logged = Session::get('logged');
        if ($logged == false) {
            Session::destroy();
            header('location: login');
            exit;
        }
        
        $this->view->js = array(URL."assets/js/lib/data-table/datatables.min.js"
                                ,URL."assets/js/lib/data-table/dataTables.bootstrap.min.js"
                                ,URL."assets/js/lib/data-table/dataTables.buttons.min.js"
                                ,URL."assets/js/lib/data-table/buttons.bootstrap.min.js"
                                ,URL."assets/js/lib/data-table/jszip.min.js"
                                ,URL."assets/js/lib/data-table/vfs_fonts.js"
                                ,URL."assets/js/lib/data-table/buttons.html5.min.js"
                                ,URL."assets/js/lib/data-table/buttons.print.min.js"
                                ,URL."assets/js/lib/data-table/buttons.colVis.min.js"
                                ,URL."assets/js/init/datatables-init.js"
                                ,URL."views/permission/js/default.js"
                                );

        $this->view->css = array(URL.'assets/css/lib/datatable/dataTables.bootstrap.min.css'
                                ,"https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css"
                                );
        
    }

    function index() {

        $this->view->criteria = array("rolesearch" => "ADM");

        $this->view->render('permission/index');
    }

    function xhrGetRoleLov() {
        $arr = [];
        $i = 0;

        $data = $this->model->getRole();
        foreach ($data as $row) {
            $arr[$i]=(array('value' => $row["rolcd"]
                          , 'label' => $row["rolcd"].' - '.$row["rolnm"]));
            $i++;
        }

        echo json_encode($arr);
    }

    function xhrGetRole() {
        $role = $_POST["rolecd"];
        $data = $this->model->getRole($role);
        echo json_encode($data);
    }

    function xhrSearch() {
        $this->model->xhrSearch();
    }

    function xhrSave() {
        $this->model->xhrSave();
    }

}

?>