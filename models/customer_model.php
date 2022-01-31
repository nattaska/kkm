<?php

class Customer_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    function xhrSearch() {

        $sql="SELECT cusid id, cusname name, custel phone, custax taxno, cusaddr address
              FROM customer
              WHERE cusname  like '%".$_POST['qname']."%'";
            // echo $sql."<br>";


        $stmt = $this->db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $data = $stmt->fetchAll();

        echo json_encode($data);
    }

    public function xhrInsert() {

            $result = "1";
            $error = "";
            $last_id = "";
        try {
            $this->db->beginTransaction();

            $sql = "INSERT INTO customer(cusname, custel, custax, cusaddr) VALUE(:name, :phone, :taxno, :address);";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':name'=>$_POST['name'],
                ':phone'=>$_POST['phone'],
                ':taxno'=>$_POST['taxno'],
                ':address'=>$_POST['address']
                ));
                $last_id = $this->db->lastInsertId();

            $this->db->commit();

        } catch (Exception $e) {
            $result = "0";
            $error = $e->getMessage();
            $this->db->rollBack();
        }
        
        $data = array('res' => $result, 'error' => $error, 'id' => $last_id);
        echo json_encode($data);
    }

    function xhrUpdate() {
        $result = "1";
        $error = "";

        try {
            $this->db->beginTransaction();

            $sql = "UPDATE  customer
                    SET cusname = :name,
                        custel  = :phone,
                        custax   = :taxno,
                        cusaddr = :address
                    WHERE cusid = :id";

            $stmt = $this->db->prepare($sql);
            $stmt->execute(array(
                ':name'=>$_POST['name'],
                ':phone'=>$_POST['phone'],
                ':taxno'=>$_POST['taxno'],
                ':address'=>$_POST['address'],
                ':id'=>$_POST['id'],
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
            $stmt = $this->db->prepare("DELETE FROM customer 
                                        WHERE cusid = :id");
            $stmt->execute(array(
                ':id'=>$_POST['id']
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