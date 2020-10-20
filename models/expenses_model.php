<?php

class Expenses_Model extends Model {
    // public $param = array();
    // public $userProfile = array();

    public function __construct() {
        parent::__construct();
    }

    function xhrSearch() {
        // echo "post code = ".$_POST['code'];
        $date = new DateTime();
        $sdate = (isset($_POST['sdate']))?$_POST['sdate']:date("Y-m-d",strtotime("yesterday"));
        $edate = (isset($_POST['edate']))?$_POST['edate']:date_format($date,"Y-m-d");
        $grp = (isset($_POST['grp']))?$_POST['grp']:"-1";
        // echo $sdate;
        // echo $edate;

        $sql="SELECT expdate, tb10.pmddesc expgrpnm, tb9.pmddesc exptitle, FORMAT(expamt, 2) expamt, expcmt, expgrp expgrpcd, expcd
                FROM expenses e, prmdtl tb9, prmdtl tb10
                WHERE tb9.pmdtbno = 9
                AND tb10.pmdtbno = 10
                AND expcd = tb9.pmdcd
                AND expgrp = tb10.pmdcd
                AND expdate BETWEEN :sdate AND :edate 
                AND ('".$grp."' = '-1' OR expgrp = '".$grp."') ";
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

            $sql = "INSERT INTO expenses VALUE( :expdate, :expcd, :expgrp, :expamt, :expcmt )";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':expdate'=>$_POST['pdate'],
                ':expcd'=>$_POST['code'],
                ':expgrp'=>$_POST['grpcd'],
                ':expamt'=>$_POST['amount'],
                ':expcmt'=>$_POST['comment']
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

            $sql = "UPDATE  expenses
                    SET  expamt  = :amount
                        ,expcmt = :comment
                    WHERE expdate = :pdate 
                    AND expcd = :code";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':code'=>$_POST['code'],
                ':pdate'=>$_POST['pdate'],
                ':amount'=>$_POST['amount'],
                ':comment'=>$_POST['comment']
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
            $stmt = $this->db->prepare("DELETE FROM expenses 
                                        WHERE expdate = :pdate 
                                        AND expcd = :code ");
            $stmt->execute(array(
                ':pdate'=>$_POST['pdate'],
                ':code'=>$_POST['code']
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
}

?>