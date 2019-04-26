<?php

class NPFood_Model extends Model {
    // public $param = array();
    // public $userProfile = array();

    public function __construct() {
        parent::__construct();
    }

    function xhrGetNPFoodList() {
        // echo "post code = ".$_POST['code'];
        $date = new DateTime();
        $sdate = (isset($_POST['sdate']))?$_POST['sdate']:date_format($date,"Y-m-01");
        $edate = (isset($_POST['edate']))?$_POST['edate']:date_format($date,"Y-m-t");

        $sql="SELECT npfordid ordid, npfdate orddate, npfroom room, FORMAT(npftotal, 2) total
              FROM npfood
              WHERE npfdate BETWEEN :sdate AND :edate ";
            // echo $sql."<br>";
        $sth=$this->db->prepare($sql);

        $sth->bindParam(':sdate', $sdate, PDO::PARAM_STR);
        $sth->bindParam(':edate', $edate, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }

    function xhrGetTable() {
        $code = $_POST['room'];

        $sth = $this->db->prepare('SELECT pmdval1 tabno FROM prmdtl WHERE pmdtbno=5 AND pmdcd=:code');
        $sth->bindParam(':code', $code, PDO::PARAM_INT);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }

    public function xhrInsertNPFood() {

        // echo print_r($_POST);
            $result = "1";
            $error = "";
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO npfood VALUE(:ordid, :date, :tabno, :room, :total);";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':ordid'=>$_POST['ordid'],
                ':date'=>$_POST['orddate'],
                ':tabno'=>$_POST['tabno'],
                ':room'=>$_POST['room'],
                ':total'=>$_POST['total']
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

    function xhrUpdateNPFood() {
        $result = "1";
        $error = "";

        try {
            $this->db->beginTransaction();

            $sql = "UPDATE  npfood
                    SET  npfdate  = :date
                        , npftable  = :tabno
                        , npfroom  = :room
                        , npftotal = :total
                    WHERE npfordid = :ordid ";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':ordid'=>$_POST['ordid'],
                ':date'=>$_POST['orddate'],
                ':tabno'=>$_POST['tabno'],
                ':room'=>$_POST['room'],
                ':total'=>$_POST['total']
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

    function xhrDeleteNPFood() {
        $result = "1";
        $error = "";

        try {
            $this->db->beginTransaction();
            $id = $_POST['ordid'];
            $stmt = $this->db->prepare('DELETE FROM npfood WHERE npfordid = "'.$id.'"');
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
}

?>