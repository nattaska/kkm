<?php

class Profile_Model extends Model {
    // public $param = array();
    // public $userProfile = array();

    public function __construct() {
        parent::__construct();
    }

    public function getProfile($code) {
        $sql = "select empcd code, empfnm firstname, emplnm lastname, empnnm nickname
                , empphone phone, empprof pfcode, pmddesc profile 
                , paydeptid deptid, paytype, paymethd, payaccount account, paysso 
                from employee, prmdtl, payment     
                where empcd=:code
                AND pmdtbno=4 
                AND empprof=pmdcd 
                and payempcd=empcd 
                and current_date between paysdate and payedate ";
// echo $code;
        $sth = $this->db->prepare($sql);
        $sth->execute(array(
            ':code'=>$code
        ));

        // $this->userProfile=$sth->fetch(PDO::FETCH_ASSOC);
        $user=$sth->fetch(PDO::FETCH_ASSOC);
        Session::init();
        Session::set('UserProfile',$user);

    }

    function xhrGetUserLov() {
        // $keyword = $_GET['keyword'];

        $sql = "SELECT empcd value, concat(empcd,' - ',empnnm) label FROM employee";

        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }

    public function update() {

        // echo print_r($_POST);
        try {
    
            $this->db->beginTransaction();

            $sql = "UPDATE employee
                    SET empfnm = :fname, emplnm = :lname, empnnm = :nname, empphone = :phone, empprof = :profile
                    WHERE empcd = :code";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':code'=>$_POST['code'],
                ':fname'=>$_POST['fname'],
                ':lname'=>$_POST['lname'],
                ':nname'=>$_POST['nname'],
                ':phone'=>$_POST['phone'],
                ':profile'=>$_POST['profile']
                ));
    
            $sql = "UPDATE payment
                    SET paydeptid = :department, paytype = :paytype, 
                        paymethd = :paymethd, payaccount = :account, paysso = :paysso
                    WHERE payempcd = :code 
                    AND current_date between paysdate and payedate ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':code'=>$_POST['code'],
                ':department'=>$_POST['department'],
                ':paytype'=>$_POST['paytype'],
                ':paymethd'=>$_POST['paymethd'],
                ':account'=>$_POST['account'],
                ':paysso'=>$_POST['paysso']
                ));

            $this->db->commit();
            $this->getProfile($_POST['code']);

        } catch (Exception $e) {
            echo $e->getMessage();
            //Rollback the transaction.
            $this->db->rollBack();
        }

        //  [fname] => นายกษิดิษ [lname] => เทียมทัด [nname] => Natt [department] => 1 [profile] => 1 [paymethd] => 1 [paytype] => 1 [account] => 4089590539 [acchide] => 4089590539 [paysso] => 600 

        header('location: ../profile');
    }
}

?>