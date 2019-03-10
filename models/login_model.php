<?php

require 'profile_model.php';

class Login_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function login() {

        $sql = "select usrcd code, usrprof pfcode, prmdesc profdesc, ifnull(empnnm,'-') nickname
                FROM users
                LEFT JOIN employee ON usrcd=empcd
                JOIN parameters ON usrprof=prmcd AND prmid=4 
                WHERE usrcd = :code
                AND usrpwd = MD5(:password) ";

        $sth = $this->db->prepare($sql);
        $sth->execute(array(
            ':code'=>$_POST['usercode'],
            ':password'=>$_POST['password']
        ));
        
        if ($sth->rowCount() > 0) {
            // login
            $login=$sth->fetch(PDO::FETCH_ASSOC);
            Session::init();
            Session::set('LoginData',$login);

            $profObj = new Profile_Model();
            $profObj->getProfile($_POST['usercode']);
            // Session::set('UserProfile',$profObj->userProfile);
            header('location: ../timesheet');
        } else {
            // Show an error
            header('location: ../login');
        }
        // print_r($data);
    }

    public function getUser($code) {
        $sql="SELECT empcd code, emppwd password, empfnm firstname, emplnm lastname, empnnm nickname, prmdesc profile "
            ."FROM employee, parameters "
            ."WHERE empcd=:code "
            ."AND prmid=5 "
            ."AND empprof=prmcd ";
        $sth=$this->conn->prepare($sql);
        $sth->bindParam(':code', $code, PDO::PARAM_INT);
        $sth->execute();
        $this->users=$sth->fetch(PDO::FETCH_ASSOC);

        // while($res=$sth->fetch(PDO::FETCH_ASSOC)) {
        //     print_r($res);
        //     $this->users[]=$res;
        // }

        return $this->users;
    }

}
?>