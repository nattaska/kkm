<?php

class Timesheet_Model extends Model {
    function __construct() {
        parent::__construct();
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

    function xhrUsername() {
        $code = $_POST['code'];

        $sth = $this->db->prepare('SELECT usrnnm name FROM user WHERE usrcd=:code');
        $sth->bindParam(':code', $code, PDO::PARAM_INT);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }

    // xhrGetTimesheet($param)
    function xhrGetTimesheet() {
        // echo "post code = ".$_POST['code'];
        $user = Session::get('userMenu');
        $date = new DateTime();

        $code = (isset($_POST['code']))?$_POST['code']:$user['code'];
        $sdate = (isset($_POST['sdate']))?$_POST['sdate']:date_format($date,"Y-m-01");
        $edate = (isset($_POST['edate']))?$_POST['edate']:date_format($date,"Y-m-t");

        $sql="SELECT usrcd code, usrnnm name, timdate date, IFNULL(DATE_FORMAT(timin,'%H:%i'),'-') chkin, IFNULL(DATE_FORMAT(timout,'%H:%i'),'-') chkout "
            ."FROM timesheet, user "
            ."WHERE timempcd=usrcd "
            ."AND usrcd=:code "
            ."AND timdate BETWEEN :sdate AND :edate "
            ."ORDER BY timdate ";
            // echo $sql."<br>";
        $sth=$this->db->prepare($sql);

        $sth->bindParam(':code', $code, PDO::PARAM_INT);
        $sth->bindParam(':sdate', $sdate, PDO::PARAM_STR);
        $sth->bindParam(':edate', $edate, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }

    function xhrSearch() {
        
        $date = new DateTime();
        $sdate = (isset($_POST['sdate']))?$_POST['sdate']:date_format($date,"Y-m-d");
        $edate = (isset($_POST['edate']))?$_POST['edate']:date_format($date,"Y-m-d");
        $userMenu = Session::get('userMenu');

        $sql="SELECT usrcd code, usrnnm name, timdate, timin, timout, timspec timstat "
            ."FROM timesheet, user "
            ."WHERE timempcd=usrcd "
            ."AND timdate BETWEEN :sdate AND :edate ";

        if ($userMenu['role']!="ADM") {
            $sql .= "AND usrcd=".$userMenu['code']." ";
        }
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

            $result = "1";
            $error = "";
            $timin = (!isset($_POST['timin']) || $_POST['timin']=="")?null:$_POST['timin'];
            $timout = (!isset($_POST['timout']) || $_POST['timout']=="")?null:$_POST['timout'];
            $timstat = (!isset($_POST['timstat']) || $_POST['timstat']=="")?null:$_POST['timstat'];
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO timesheet(timempcd, timdate, timin, timout, timspec) 
                    VALUE(:empcd, :pdate, :timin, :timout, :timstat);";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':empcd'=>$_POST['empcd'],
                ':pdate'=>$_POST['timdate'],
                ':timin'=>$timin,
                ':timout'=>$timout,
                ':timstat'=>$timstat
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
        $timin = (!isset($_POST['timin']) || $_POST['timin']=="")?null:$_POST['timin'];
        $timout = (!isset($_POST['timout']) || $_POST['timout']=="")?null:$_POST['timout'];
        $timstat = (!isset($_POST['timstat']) || $_POST['timstat']=="")?null:$_POST['timstat'];

        try {
            $this->db->beginTransaction();

            $sql = "UPDATE  timesheet
                    SET  timin  = :timin
                        ,timout = :timout
                        ,timspec = :timstat
                    WHERE timempcd = :empcd 
                    AND timdate = :pdate";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':empcd'=>$_POST['empcd'],
                ':pdate'=>$_POST['timdate'],
                ':timin'=>$timin,
                ':timout'=>$timout,
                ':timstat'=>$timstat
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
            $stmt = $this->db->prepare("DELETE FROM timesheet 
                                        WHERE timempcd = :empcd 
                                        AND timdate = :pdate");
            $stmt->execute(array(
                ':empcd'=>$_POST['empcd'],
                ':pdate'=>$_POST['timdate']
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

    function xhrDayOff() {
        $result = "1";
        $error = "";

        $begin = new DateTime($_POST['sdate']);
        $end = new DateTime($_POST['edate']);        

        try {
            $this->db->beginTransaction();
            $sql = "insert into timesheet(timempcd, timdate)
                    select usrcd, ':ddate'
                    from user, payment
                    where usrcd=payempcd
                    and ':ddate' between paysdate and payedate
                    and paydeptid<>4
                    and usrcd not in (select timempcd from timesheet
                                            where timdate=':ddate' )";
            
            for($i = $begin; $i <= $end; $i->modify('+1 day')){
                $stmt = $this->db->prepare(str_replace(":ddate",$i->format("Y-m-d"),$sql));            
                $stmt->execute();
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

    function xhrSearchTimesheetLogs() {
        
        $date = new DateTime();
        $empcd = $_POST['empcd'];
        $pdate = (isset($_POST['timdate']))?$_POST['timdate']:date_format($date,"Y-m-d");
        $userMenu = Session::get('userMenu');

        $sql="SELECT ltimempcd lcode, usrnnm name, ltimtyp ltype, ltimtime ltime "
            ."FROM timesheet_logs, user "
            ."WHERE ltimempcd=usrcd "
            ."AND ltimempcd=:empcd "
            ."AND ltimdate=:pdate ";

            // echo $sql."<br>";
        $sth=$this->db->prepare($sql);

        $sth->bindParam(':empcd', $empcd, PDO::PARAM_STR);
        $sth->bindParam(':pdate', $pdate, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }

}
?>