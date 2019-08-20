<?php

class Controller {
    function __construct() {
        // echo "Main controller</br>";
        $this->view = new View();
        $this->view->nowdate = new DateTime();
    }

    public function loadModel($name) {
        $path = 'models/'.$name.'_model.php';
        if (file_exists($path)) {
            require 'models/'.$name.'_model.php';
            $modelName = $name.'_Model';
            $this->model = new $modelName;
        }
    }

    public function loadModelByName($name) {
        $model;
        $path = 'models/'.$name.'_model.php';
        if (file_exists($path)) {
            require 'models/'.$name.'_model.php';
            $modelName = $name.'_Model';
            $model = new $modelName;
        }

        return $model;
    }
}

?>