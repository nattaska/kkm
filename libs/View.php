<?php

class View {
    function __construct() {
        // echo "This is the view </br>";
    }

    public function render($name, $noInclude = false) {

        $userMenu = Session::get('userMenu');
        $url = $_GET['url'];
        $arrUrl = rtrim($url,'/');
        $arrUrl = explode('/',$arrUrl);
        $module=$arrUrl[0];

        if (($module != "login") && ($module != "checkin") && !isset($userMenu[$url])) {
            require 'views/header.php';
            require 'views/error/403.php';
            require 'views/footer.php';
        } else {
            if ($noInclude == true) {
                require 'views/'.$name.'.php';
            } else {
                $auth = $userMenu[$url];
                require 'views/header.php';
                require 'views/'.$name.'.php';
                require 'views/footer.php';
            }
        }
    }
}


?>