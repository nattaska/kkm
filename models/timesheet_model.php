<?php

class Timesheet_Model extends Model {
    function __construct() {
        parent::__construct();
    }

    // function xhrInsert() {
    //     $text = $_POST['text'];
    //     $sth = $this->db->prepare('INSERT INTO data(text) values (:text)');
    //     $sth->execute(array(':text' => $text));
        
    //     $data = array('text' => $text, 'id' => $this->db->lastInsertId());
    //     echo json_encode($data);
    // }

    function xhrGetUserLov() {
        // $keyword = $_GET['keyword'];

        $sql = "SELECT empcd value, concat(empcd,' - ',empnnm) label FROM employee";

        $sth = $this->db->prepare($sql);
        // $sth->bindParam(':keyword', $keyword, PDO::PARAM_INT);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        // $resultData = array();

        // while($res=$sth->fetch(PDO::FETCH_ASSOC)) {
        //     $resultData[]=$res;
        // }

        // // $data = $sth->fetchAll();

        echo json_encode($data);
    }

    function xhrUsername() {
        $code = $_POST['code'];

        $sth = $this->db->prepare('SELECT empnnm name FROM employee WHERE empcd=:code');
        $sth->bindParam(':code', $code, PDO::PARAM_INT);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }

    // xhrGetTimesheet($param)
    function xhrGetTimesheet() {
        // echo "post code = ".$_POST['code'];
        $user = Session::get('UserData');
        $date = new DateTime();

        $code = (isset($_POST['code']))?$_POST['code']:$user['code'];
        $sdate = (isset($_POST['sdate']))?$_POST['sdate']:date_format($date,"Y-m-01");
        $edate = (isset($_POST['edate']))?$_POST['edate']:date_format($date,"Y-m-t");

        $sql="SELECT empcd code, empnnm name, timdate date, IFNULL(DATE_FORMAT(timin,'%H:%i'),'-') chkin, IFNULL(DATE_FORMAT(timout,'%H:%i'),'-') chkout "
            ."FROM timesheet, employee "
            ."WHERE timempcd=empcd "
            ."AND empcd=:code "
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

        // while($res=$sth->fetch(PDO::FETCH_ASSOC)) {
        //     $this->worksheets[]=$res;
        // }
        // $this->worksheets=$sth->fetch(PDO::FETCH_ASSOC);

        // return $this->worksheets;
    }

    // function xhrDeleteListing() {
    //     $id = $_POST['id'];
    //     $sth = $this->db->prepare('DELETE FROM data WHERE id = "'.$id.'"');
    //     $sth->execute();
    // }

}
?>