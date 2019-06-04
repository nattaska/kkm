<?php

class View {
    function __construct() {
        // echo "This is the view </br>";
    }

    public function render($name, $noInclude = false) {

        $userMenu = Session::get('userMenu');
        $url = $_GET['url'];
        $url = rtrim($url,'/');
        $url = explode('/',$url);
        $module=$url[0];

        if (($module != "login") && ($module != "checkin") && !isset($userMenu[$module])) {
            require 'views/header.php';
            require 'views/error/403.php';
            require 'views/footer.php';
        } else {
            if ($noInclude == true) {
                require 'views/'.$name.'.php';
            } else {
                $auth = $userMenu[$module];
                require 'views/header.php';
                require 'views/'.$name.'.php';
                require 'views/footer.php';
            }
        }
    }
}


?>