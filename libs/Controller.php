<?php

class Controller {
    function __construct() {
        // echo "Main controller</br>";
        $this->view = new View();
    }

    public function loadModel($name, $noInclude = false) {
        $path = 'models/'.$name.'_model.php';
        if (file_exists($path)) {
            require 'models/'.$name.'_model.php';
            $modelName = $name.'_Model';
            $this->model = new $modelName;

            if ($noInclude == false) {
                require 'models/parameter_model.php';
                $this->paramModel = new Parameter_Model();
            }

        }
    }
}

?>