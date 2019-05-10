<?php

require 'profile_model.php';

class Login_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function validateLogin($user, $password) {
        $valid = false;

        $sql = "SELECT 1 FROM user WHERE usrcd = :code AND usrpwd = :password";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(array(
            ':code'=>$user,
            ':password'=> md5($password)
        ));

        if ($stmt->rowCount() > 0) {
            $valid = true;
            // Session::init();
            // Session::set('logined',true);
        }

        return $valid;
    }

    public function login() {

        $sql = "select usrcd code, usrprof pfcode, pmddesc profdesc, ifnull(empnnm,'-') nickname
                FROM users
                LEFT JOIN employee ON usrcd=empcd
                JOIN prmdtl ON usrprof=pmdcd AND pmdtbno=4 
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
        $sql="SELECT empcd code, emppwd password, empfnm firstname, emplnm lastname, empnnm nickname, pmddesc profile "
            ."FROM employee, prmdtl "
            ."WHERE empcd=:code "
            ."AND pmdtbno=5 "
            ."AND empprof=pmdcd ";
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