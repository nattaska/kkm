<?php

class Order_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    function xhrSearch() {

        $sql="SELECT orddate, orditm item, ordqty qty
                FROM orders
                WHERE orddate=:orddate
                ORDER BY orditm";
            // echo $sql."<br>";
        $sth=$this->db->prepare($sql);

        $sth->bindParam(':orddate', $_POST['orddate'], PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        echo json_encode($data);
    }

    public function xhrSave() {

            $result = "1";
            $error = "";
        try {
            $this->db->beginTransaction();
            $ordDate = $_POST['orddate'];
            $items = $_POST['items'];

            $del = "DELETE FROM orders WHERE orddate = :orddate";
            $stmt = $this->db->prepare($del);
            $stmt->execute(array(
                ':orddate'=>$ordDate
                ));

            $sql = "INSERT INTO orders (orddate, orditm, ordqty) VALUES (:orddate, :item, :qty) ";
            $stmt = $this->db->prepare($sql);
            foreach ($items as $item) {
                $stmt->execute(array(
                    ':orddate'=>$ordDate,
                    ':item'=>$item,
                    ':qty'=> (!(isset($_POST["qty".$item])) || $_POST["qty".$item]==""?"1":$_POST["qty".$item])
                    ));
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

    function printOrder($orddate) {
        // echo $orddate;

        $sql="SELECT pmddesc item, ordqty qty
                FROM orders, prmdtl
                WHERE orddate=:orddate
                AND pmdtbno=7
                AND orditm=pmdcd
                ORDER BY pmdval2 ";
            // echo $sql."<br>";
        $sth=$this->db->prepare($sql);

        $sth->bindParam(':orddate', $orddate, PDO::PARAM_STR);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        $data = $sth->fetchAll();

        return $data;
    }
}

?>