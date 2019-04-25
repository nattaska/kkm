<?php

class Checkin_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    function xhrSearch() {
        // echo "post code = ".$_POST['code'];
        $sql = "SELECT empcd code, empnnm name, empphone phone, IFNULL(DATE_FORMAT(timin,'%H:%i'),'-') timin, IFNULL(DATE_FORMAT(timout,'%H:%i'),'-') timout ".
                " FROM employee JOIN payment on (empcd=payempcd and CURRENT_DATE BETWEEN paysdate AND payedate AND paydeptid != 4) ".
                " LEFT JOIN timesheet ON (empcd=timempcd and timdate=CURRENT_DATE) ".
                " ORDER BY empcd";
            // echo $sql."<br>";
        $sth=$this->db->prepare($sql);        
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }

    public function xhrClocked(){

        $result = "1";
        $error = "";

        // echo $_POST['phone']."</br>";
        // echo $_POST['code']."</br>";
        // echo $_POST['clocktype']."</br>";

        $clockType = $_POST['clocktype'];
        $sql = "";

        if (strcmp($clockType, 'in') == 0) {
            $sql = "INSERT INTO timesheet(timempcd, timdate, timin) VALUE(:empcd, CURRENT_DATE, CURRENT_TIMESTAMP);";
        } else {
            $sql = "UPDATE  timesheet
                    SET  timout  = CURRENT_TIMESTAMP
                    WHERE timempcd = :empcd 
                    AND timdate = CURRENT_DATE";
        }
        // echo $sql;
        try {
            $this->db->beginTransaction();
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':empcd'=>$_POST['code']
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

    public function checkIn() {

        // echo print_r($_POST);
            $result = "1";
            $error = "";
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO timesheet(timempcd, timdate, timin) VALUE(:empcd, CURRENT_DATE, CURRENT_TIMESTAMP);";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':empcd'=>$_POST['code']
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

            $sql = "UPDATE  timesheet
                    SET  timout  = CURRENT_TIMESTAMP
                    WHERE timempcd = :empcd 
                    AND timdate = CURRENT_DATE";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':empcd'=>$_POST['empcd']
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