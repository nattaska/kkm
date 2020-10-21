<?php

class Checkin_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    function xhrSearch() {
        // echo "post code = ".$_POST['code'];
        $sql = "SELECT usrcd code, usrnnm name, usrtel phone, IFNULL(DATE_FORMAT(timin,'%H:%i'),'-') timin, IFNULL(DATE_FORMAT(timout,'%H:%i'),'-') timout 
                FROM user JOIN payment on (usrcd=payempcd and CURRENT_DATE BETWEEN paysdate AND payedate AND paydeptid != 4) 
                LEFT JOIN timesheet ON (usrcd=timempcd and timdate=CURRENT_DATE) 
                ORDER BY usrcd";
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

        $clockType = $_POST['clocktype'];
        $sql = "";

        if (strcmp($clockType, 'in') == 0) {
            $sql = "INSERT INTO timesheet(timempcd, timdate, timin, timipin) VALUE(:empcd, CURRENT_DATE, CURRENT_TIMESTAMP, :ip);";
        } else {
            $sql = "UPDATE  timesheet
                    SET  timout  = CURRENT_TIMESTAMP,
                         timipout = :ip
                    WHERE timempcd = :empcd 
                    AND timdate = CURRENT_DATE";
        }
        // echo $sql;
        try {
            $this->db->beginTransaction();
            $this->db->query("SET time_zone = '+07:00'");
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':empcd'=>$_POST['code'],
                ':ip'=>$_SERVER['HTTP_X_FORWARDED_FOR']
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

    public function xhrShopIP() {
        // return "124.122.123.56";
        
        $sql = "SELECT pmdval1 ip FROM prmdtl
                WHERE pmdtbno=1
                AND pmdcd=3";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetch();
        
        return $data['ip'];
    }
}

?>
