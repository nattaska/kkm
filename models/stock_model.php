<?php
include_once('libs/PHPExcel.php');

class Stock_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function xhrPrepareStock() {

            $result = "1";
            $error = "";
        try {
            $this->db->beginTransaction();            

            $sql = "INSERT INTO stock (stkdate, stkitmgrp, stkitmcd, stkunt, stkoutqty)
                    SELECT CURRENT_DATE, pmdval1, pmdcd, pmdval4, pmdval5
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

    public function uploadStockSystem() {

        $result = "1";
        $error = "";

        try {
            $this->db->beginTransaction();

            if (isset($_FILES['stkfile'])) {

                $filename = $_FILES['stkfile']['name'];
                
                if($_FILES["stkfile"]["size"] > 0)
                {
                    move_uploaded_file($_FILES["stkfile"]["tmp_name"],$filename);
                    $file = fopen($filename, "r");

                    $sql = "DELETE FROM stock_import";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute();

                    $sql = "INSERT INTO stock_import values (:id, :name, :qty)";
                    $stmt = $this->db->prepare($sql);
                    // echo $file;
                    while (($getData = fgetcsv($file, 10000, ",")) !== FALSE) {
                        $stmt->execute(array(
                            ':id'=>$getData[0]
                            ,':name'=>$getData[1]
                            ,':qty'=>$getData[2]
                        ));
                    }

                    $sql = "REPLACE INTO stock (stkdate, stkitmgrp, stkitmcd, stkoutqty, stkroomqty, stksysqty, stkunt, stkadjqty)
                            SELECT CURRENT_DATE, p.pmdval1, p.pmdcd, stkoutqty, stkroomqty, stiqty, p.pmdval4, stkadjqty
                            FROM (SELECT * FROM prmdtl WHERE pmdtbno=12) p
                            LEFT JOIN stock_import ON REPLACE(stiname,' (ราคาปกติ)','')=p.pmddesc
                            LEFT JOIN stock ON stkdate=CURRENT_DATE 
                                    AND p.pmdcd=stkitmcd";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute();
                }

                $error = $filename;

                $this->db->commit();
                fclose($file);
                unlink($filename);
            } else {
                $result = "0";
                $error = "No upload file";
            }

        } catch (Exception $e) {
            $result = "0";
            $error = $e->getMessage();
            $this->db->rollBack();
        }
        
        $data = array('res' => $result, 'error' => $error);
        echo json_encode($data);

    }

    public function uploadStockSystemExcel() {

        $result = "1";
        $error = "";

        try {
            $this->db->beginTransaction();

            if (isset($_FILES['stkfile'])) {

                $filename = $_FILES['stkfile']['name'];
                
                if($_FILES["stkfile"]["size"] > 0)
                {
                    move_uploaded_file($_FILES["stkfile"]["tmp_name"],$filename);
                    $excelReader = PHPExcel_IOFactory::createReaderForFile($filename);
                    $excelObj = $excelReader->load($filename);
                    $worksheet = $excelObj->getSheet(0);
                    $lastRow = $worksheet->getHighestRow();

                    $sql = "DELETE FROM stock_import";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute();

                    $sql = "INSERT INTO stock_import values (:id, :name, :qty)";
                    $stmt = $this->db->prepare($sql);
                    // echo $file;
                    for ($row = 13; $row <= $lastRow; $row++) {
                        $stmt->execute(array(
                            ':id'=>$worksheet->getCell('B'.$row)->getValue()
                            ,':name'=>$worksheet->getCell('C'.$row)->getValue()
                            ,':qty'=>$worksheet->getCell('D'.$row)->getValue()
                        ));
                    }

                    $sql = "REPLACE INTO stock (stkdate, stkitmgrp, stkitmcd, stkoutqty, stkroomqty, stksysqty, stkunt, stkadjqty)
                            SELECT CURRENT_DATE, p.pmdval1, p.pmdcd, stkoutqty, stkroomqty, stiqty, p.pmdval4, stkadjqty
                            FROM (SELECT * FROM prmdtl WHERE pmdtbno=12) p
                            LEFT JOIN stock_import ON REPLACE(stiname,' (ราคาปกติ)','')=p.pmddesc
                            LEFT JOIN stock ON stkdate=CURRENT_DATE 
                                    AND p.pmdcd=stkitmcd";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute();
                }

                $error = $filename;

                $this->db->commit();
                unlink($filename);
            } else {
                $result = "0";
                $error = "No upload file";
            }

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
                ORDER BY stkitmgrp, pmddesc";
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
                if (isset($qty) && (!empty($qty) || $qty=="0")) {
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