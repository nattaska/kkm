<?php

class View {
    function __construct() {
        // echo "This is the view </br>";
    }

    public function render($name, $noInclude = false) {

        Session::init();
        $userMenu = Session::get('userMenu');
        $url = $_GET['url'];
        $arrUrl = rtrim($url,'/');
        $arrUrl = explode('/',$arrUrl);
        $module=$arrUrl[0];
        // print_r($userMenu );
        // echo "</br>$url";
        if (($module != "login") && ($module != "checkin") && !isset($userMenu[$url])) {
            if ($noInclude == true) {
                require 'views/error/403.php';
            } else {
                require 'views/header.php';
                require 'views/error/403.php';
                require 'views/footer.php';
            }
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