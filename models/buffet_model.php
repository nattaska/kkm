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
        $sdate = (isset($_POST['sdate']))?$_POST['sdate']:date_format($date,"Y-m-d");
        $edate = (isset($_POST['edate']))?$_POST['edate']:date_format($date,"Y-m-d");

        // echo $bufftype."<br>";

        $sql="SELECT bfdate, bftype, bfgrp grp, pmddesc typename
                    , if((pmdval1 = 1),'-',bfqty) qty,FORMAT((bfqty*pmdval1),2) amount
                    , FORMAT(ROUND((bfqty)*IFNULL(pmdval1*pmdval2/100, IFNULL(pmdval3,0)),2),2) comm
                    , ifnull(bfnote,'-') note
                FROM buffet, prmdtl
                WHERE pmdtbno = 2
                AND bftype = pmdcd
                AND ('".$bufftype."' = '-1' or bftype = '".$bufftype."')
                AND bfdate BETWEEN :sdate AND :edate
                ORDER BY bfdate, typename, bfgrp ";
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

            $sql = "SELECT IFNULL(MAX(bfgrp),0)+1 grp
                        FROM buffet 
                        WHERE bfdate=:bfdate 
                        AND bftype=:bftype";

            $sth=$this->db->prepare($sql);

            $sth->bindParam(':bfdate', $_POST['bfdate'], PDO::PARAM_STR);
            $sth->bindParam(':bftype', $arrType['code'], PDO::PARAM_STR);
            $sth->setFetchMode(PDO::FETCH_ASSOC);
            $sth->execute();
            $data = $sth->fetchAll();

            $sql = "INSERT INTO buffet VALUE(:bfdate, :bfgrp, :bftype, :bfqty, :bfnote)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':bfdate'=>$_POST['bfdate'],
                ':bfgrp' => $data[0]["grp"],
                ':bftype'=>$arrType['code'],
                ':bfnote'=>$_POST['note'],
                ':bfqty'=>$_POST['qty']
                ));

            if ($arrType['code'] == '7' ) {
                $sql = "REPLACE INTO revenue(rvndate, rvncd, rvnamt, rvncmt) 
                                VALUES (:bfdate,2,(SELECT SUM(bfqty)
                                                FROM buffet
                                                WHERE bfdate=:bfdate2
                                                AND bftype='7'), NULL)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute(array(
                    ':bfdate'=>$_POST['bfdate'],
                    ':bfdate2'=>$_POST['bfdate']
                    ));
            }

            $this->db->commit();

        } catch (Exception $e) {
            $result = "0";
            $error = $e->getMessage();
            $this->db->rollBack();
        }
        
        $data = array('res' => $result,'grp' => $data[0]["grp"], 'error' => $error);
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
                    SET bfqty  = :bfqty,
                        bfnote = :bfnote
                    WHERE bfdate = :bfdate 
                    AND bftype = :bftype
                    AND bfgrp = :bfgrp";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':bfdate'=>$_POST['bfdate'],
                ':bftype'=>$arrType['code'],
                ':bfgrp'=>$_POST['grp'],
                ':bfqty'=>$_POST['qty'],
                ':bfnote'=>$_POST['note']
                ));

            if ($arrType['code'] == '7' ) {
                $sql = "REPLACE INTO revenue(rvndate, rvncd, rvnamt, rvncmt) 
                                VALUES (:bfdate,2,(SELECT SUM(bfqty)
                                                FROM buffet
                                                WHERE bfdate=:bfdate2
                                                AND bftype='7'), NULL)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute(array(
                    ':bfdate'=>$_POST['bfdate'],
                    ':bfdate2'=>$_POST['bfdate']
                    ));
            }

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

            if ($_POST['bftype'] == '7' ) {
                $sql = "REPLACE INTO revenue(rvndate, rvncd, rvnamt, rvncmt) 
                                VALUES (:bfdate,2,(SELECT SUM(bfqty)
                                                FROM buffet
                                                WHERE bfdate=:bfdate2
                                                AND bftype='7'), NULL)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute(array(
                    ':bfdate'=>$_POST['bfdate'],
                    ':bfdate2'=>$_POST['bfdate']
                    ));
            }

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