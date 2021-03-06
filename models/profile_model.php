<?php

class Profile_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function getProfile($code) {
        $sql = "SELECT  usrcd code, usrnm name, usrnnm nickname
                        , usrtel phone, usremail email
                        , paydeptid deptid, paytype, paymethd, payaccount account, paysso 
                FROM user, payment     
                WHERE usrcd=:code
                AND usrcd=payempcd
                AND CURRENT_DATE between paysdate and payedate ";
                
        $sth = $this->db->prepare($sql);
        $sth->execute(array(
            ':code'=>$code
        ));
        
        $user = $sth->fetch(PDO::FETCH_ASSOC);
        return $user;
    }

    function xhrGetUserLov() {
        // $keyword = $_GET['keyword'];

        $sql = "SELECT usrcd value, concat(usrcd,' - ',usrnnm) label FROM user";

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
            
            $sql = "UPDATE user
                    SET usrnm = :name, usrnnm = :nickname, usrtel = :phone, usremail = :email
                    WHERE usrcd = :code";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':code'=>$_POST['code'],
                ':name'=>$_POST['name'],
                ':nickname'=>$_POST['nickname'],
                ':phone'=>$_POST['phone'],
                ':email'=>$_POST['email']
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

        header('location: ../profile');
    }
}

?>