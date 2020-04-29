<?php

class Checkin extends Controller {
    function __construct(){
        parent::__construct();
        Session::init();

        if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
        {
            $ip=$_SERVER['HTTP_CLIENT_IP'];
        }
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
        {
            $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else
        {
            $ip=$_SERVER['REMOTE_ADDR'];
        }
        
        $ipinfo = file_get_contents("http://ipinfo.io/{$ip}");
        // echo $ipinfo."</br>";
        
        $ipObj = json_decode($ipinfo,true);
        // echo "org : ".$ipObj["org"]."</br>";
        
        // if (ISSET($ipObj["org"])) {}
        if (ISSET($ipObj["org"]) &&
            (!(strlen(strstr($ipObj["org"], NT_ORG))>0 &&
             strlen(strstr($ipObj["hostname"], NT_HOST))>0))) {
                header('location: login');
                exit;
        }

        $this->view->js = array(URL.'views/checkin/js/default.js');        
    }

    function index() {
        $this->view->render('checkin/index', true);
    }

    function xhrSearch() {
        $this->model->xhrSearch();
    }

    function xhrClocked() {
        $this->model->xhrClocked();
    }

}

?>