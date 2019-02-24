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

        $sql="SELECT npfordid ordid, npfdate orddate, npfroom room, npftotal total
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

    public function xhrInsertNPFood() {

        // echo print_r($_POST);
            $result = "1";
            $error = "";
        try {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            $this->db->beginTransaction();

            $sql = "INSERT INTO npfood VALUE(:ordid, :date, null, :room, :total);";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':ordid'=>$_POST['ordid'],
                ':date'=>$_POST['orddate'],
                ':room'=>$_POST['room'],
                ':total'=>$_POST['total']
                ));

            $this->db->commit();

        } catch (Exception $e) {
            $result = "0";
            $error = $e->getMessage();
            //Rollback the transaction.
            $this->db->rollBack();
        }
        
        $data = array('res' => $result, 'error' => $error);
        echo json_encode($data);
        // echo $result;

        //  [fname] => นายกษิดิษ [lname] => เทียมทัด [nname] => Natt [department] => 1 [profile] => 1 [paymethd] => 1 [paytype] => 1 [account] => 4089590539 [acchide] => 4089590539 [paysso] => 600 

        // header('location: ../profile');
    }
}

?>