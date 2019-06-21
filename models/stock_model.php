<?php

class Stock_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function xhrPrepareStock() {

            $result = "1";
            $error = "";
        try {
            $this->db->beginTransaction();            

            $sql = "INSERT INTO stock (stkdate, stkitmgrp, stkitmcd, stkunt)
                    SELECT CURRENT_DATE, pmdval1, pmdcd, pmdval4
                    FROM prmdtl
                    WHERE pmdtbno=12 
                    AND pmdval3='1' ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            $this->db->commit();

        } catch (Exception $e) {
            $result = "0";
            $error = $e->getMessage();
            $this->db->rollBack();
        }
        
        $data = array('res' => $result, 'error' => $error);
        echo json_encode($data);
    }

    function getStockByDate($stkDate) {

        $sql="SELECT pmdcd 'code', pmddesc descp, stkitmgrp 'group', stkoutqty outqty
                    , stkunt unit, stkroomqty roomqty, stksysqty sysqty
                    , (ifnull(stkoutqty,0)+(ifnull(stkroomqty,0)*ifnull(stkunt,0)))-ifnull(stksysqty,0) adjqty 
                FROM stock, prmdtl
                WHERE pmdtbno=12
                AND stkdate=:stkDate 
                AND stkitmcd=pmdcd
                ORDER BY pmdval2";
            // echo $sql."<br>";
        $sth=$this->db->prepare($sql);

        $sth->bindParam(':stkDate', $stkDate, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        return $data;

        // echo json_encode($data);
    }

    public function xhrSave() {

            $result = "1";
            $error = "";
        try {
            $this->db->beginTransaction();
            $stkdate = $_POST['stkDate'];
            $items = $_POST['items'];
            $col_qty = $_POST['stkType'];

            $sql = "UPDATE stock SET 
                        stk".$col_qty."qty = :qty
                    WHERE stkdate = :stkdate
                    AND stkitmcd = :code ";
            $stmt = $this->db->prepare($sql);
            
            foreach ($items as $code=>$qty) {
                if (isset($qty) && !empty($qty)) {
                    $stmt->execute(array(
                            ':stkdate'=>$stkdate
                            ,':code'=>$code
                            ,':qty'=>$qty
                        ));
                }
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