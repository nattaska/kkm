<?php

class Login_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function login() {
        $sth = $this->db->prepare("select empcd code, empfnm firstname, emplnm lastname, empnnm nickname, empprof pfcode, prmdesc profile 
                , paydeptid deptid, paytype, paymethd, payaccount account, paysso 
                from employee, parameters, payment     
                where empcd=:code
                and emppwd = MD5(:password)
                AND prmid=4 
                AND empprof=prmcd 
                and payempcd=empcd 
                and current_date between paysdate and payedate ");
        $sth->execute(array(
            ':code'=>$_POST['usercode'],
            ':password'=>$_POST['password']
        ));
        
        if ($sth->rowCount() > 0) {
            // login
            $users=$sth->fetch(PDO::FETCH_ASSOC);
            Session::init();
            Session::set('UserData',$users);
            header('location: ../profile');
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