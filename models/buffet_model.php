<?php

class Buffet_Model extends Model {
    // public $param = array();
    // public $userProfile = array();

    public function __construct() {
        parent::__construct();
    }

    function xhrSearch() {
        $date = new DateTime();

        $bufftype = (isset($_POST['bufftype']))?$_POST['bufftype']:"-1";
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];

        // echo $bufftype."<br>";

        $sql="SELECT bfdate, bftype, pmddesc typename, bfqty qty, ifnull(bfgrp,'-') grp
                    ,(bfqty*pmdval1) amount, ROUND((bfqty*pmdval1*pmdval2/100),2) comm
                FROM buffet, prmdtl
                WHERE pmdtbno = 2
                AND bftype = pmdcd
                AND ('".$bufftype."' = '-1' or bftype = '".$bufftype."')
                AND bfdate BETWEEN :sdate AND :edate
                ORDER BY bfdate, bftype, bfgrp ";
            // echo $sql."<br>";
        $sth=$this->db->prepare($sql);

        $sth->bindParam(':sdate', $sdate, PDO::PARAM_STR);
        $sth->bindParam(':edate', $edate, PDO::PARAM_STR);
        // $sth->bindParam(':bufftype', $bufftype, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }

    public function xhrInsert() {

        // echo print_r($_POST);
        $result = "1";
        $error = "";
        $arrType = json_decode($_POST['bftype'], true);

        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO buffet VALUE(:bfdate, :bftype, :bfgrp, :bfqty);";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':bfdate'=>$_POST['bfdate'],
                ':bftype'=>$arrType['code'],
                ':bfgrp'=>$_POST['grp'],
                ':bfqty'=>$_POST['qty']
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
        $arrType = json_decode($_POST['bftype'], true);
        // echo $arrType['code'];

        try {
            $this->db->beginTransaction();

            $sql = "UPDATE  buffet
                    SET bfqty  = :bfqty
                    WHERE bfdate = :bfdate 
                    AND bftype = :bftype
                    AND bfgrp = :bfgrp";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':bfdate'=>$_POST['bfdate'],
                ':bftype'=>$arrType['code'],
                ':bfgrp'=>$_POST['grp'],
                ':bfqty'=>$_POST['qty']
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

            $sql = "DELETE FROM buffet 
                    WHERE bfdate = :bfdate 
                    AND bftype = :bftype 
                    AND bfgrp = :bfgrp";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':bfdate'=>$_POST['bfdate'],
                ':bftype'=>$_POST['bftype'],
                ':bfgrp'=>$_POST['grp']
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