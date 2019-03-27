<?php

class Revenue_Model extends Model {
    // public $param = array();
    // public $userProfile = array();

    public function __construct() {
        parent::__construct();
    }

    function xhrSearch() {
        // echo "post code = ".$_POST['code'];
        $date = new DateTime();
        $sdate = (isset($_POST['sdate']))?$_POST['sdate']:date_format($date,"Y-m-01");
        $edate = (isset($_POST['edate']))?$_POST['edate']:date_format($date,"Y-m-t");
        $code = (isset($_POST['code']))?$_POST['code']:"-1";

        $sql="SELECT rvndate, tb8.pmddesc rvntitle, FORMAT(rvnamt, 2) rvnamt, rvncmt, rvncd
                FROM revenue e, prmdtl tb8
                WHERE tb8.pmdtbno = 8
                AND rvncd = tb8.pmdcd
                AND rvndate BETWEEN :sdate AND :edate 
                AND ('".$code."' = '-1' OR rvncd = '".$code."') ";
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

            $sql = "INSERT INTO revenue VALUE( :rvndate, :rvncd, :rvnamt, :rvncmt )";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':rvndate'=>$_POST['pdate'],
                ':rvncd'=>$_POST['code'],
                ':rvnamt'=>$_POST['amount'],
                ':rvncmt'=>$_POST['comment']
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

            $sql = "UPDATE  revenue
                    SET  rvnamt  = :amount
                        ,rvncmt = :comment
                    WHERE rvndate = :pdate 
                    AND rvncd = :code";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':pdate'=>$_POST['pdate'],
                ':code'=>$_POST['code'],
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
            $stmt = $this->db->prepare("DELETE FROM revenue 
                                        WHERE rvndate = :pdate 
                                        AND rvncd = :code ");
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