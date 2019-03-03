<?php

class Advance_Model extends Model {
    // public $param = array();
    // public $userProfile = array();

    public function __construct() {
        parent::__construct();
    }

    function xhrSearch() {
        // echo "post code = ".$_POST['code'];
        $date = new DateTime();
        $sdate = (isset($_POST['sdate']))?$_POST['sdate']:date_format($date,"Y-m-01");
        $edate = (isset($_POST['edate']))?$_POST['edate']:date_format($date,"Y-m-t");

        $sql="SELECT advempcd empcd, empnnm name, advdate, advpay pay
              FROM advance, employee
              WHERE advempcd = empcd
              AND advdate BETWEEN :sdate AND :edate ";
            // echo $sql."<br>";
        $sth=$this->db->prepare($sql);

        $sth->bindParam(':sdate', $sdate, PDO::PARAM_STR);
        $sth->bindParam(':edate', $edate, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }

    public function xhrInsert() {

        // echo print_r($_POST);
            $result = "1";
            $error = "";
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO advance VALUE(:empcd, :pdate, :pay);";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':empcd'=>$_POST['empcd'],
                ':pdate'=>$_POST['advdate'],
                ':pay'=>$_POST['pay']
                ));

            $this->db->commit();

        } catch (Exception $e) {
            $result = "0";
            $error = $e->getMessage();
            $this->db->rollBack();
        }
        
        $data = array('res' => $result, 'error' => $error);
        echo json_encode($data);
    }

    function xhrUpdate() {
        $result = "1";
        $error = "";

        try {
            $this->db->beginTransaction();

            $sql = "UPDATE  advance
                    SET  advpay  = :pay
                    WHERE advempcd = :empcd 
                    AND advdate = :pdate";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':empcd'=>$_POST['empcd'],
                ':pdate'=>$_POST['advdate'],
                ':pay'=>$_POST['pay']
                ));

            $this->db->commit();

        } catch (Exception $e) {
            $result = "0";
            $error = $e->getMessage();
            $this->db->rollBack();
        }
        
        $data = array('res' => $result, 'error' => $error);
        echo json_encode($data);
    }

    function xhrDelete() {
        $result = "1";
        $error = "";

        try {
            $this->db->beginTransaction();
            $id = $_POST['ordid'];
            $stmt = $this->db->prepare("DELETE FROM advance 
                                        WHERE advempcd = :empcd 
                                        AND advdate = :pdate");
            $stmt->execute(array(
                ':empcd'=>$_POST['empcd'],
                ':pdate'=>$_POST['advdate']
                ));

            $this->db->commit();

        } catch (Exception $e) {
            $result = "0";
            $error = $e->getMessage();
            $this->db->rollBack();
        }
        
        $data = array('res' => $result, 'error' => $error);
        echo json_encode($data);
    }

    // function xhrGetTable() {
    //     $code = $_POST['room'];

    //     $sth = $this->db->prepare('SELECT prmval1 tabno FROM parameters WHERE prmid=5 AND prmcd=:code');
    //     $sth->bindParam(':code', $code, PDO::PARAM_INT);
    //     $sth->setFetchMode(PDO::FETCH_ASSOC);
    //     $sth->execute();
    //     $data = $sth->fetchAll();

    //     echo json_encode($data);
    // }
}

?>