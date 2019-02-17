<?php

class Buffet_Model extends Model {
    // public $param = array();
    // public $userProfile = array();

    public function __construct() {
        parent::__construct();
    }

    function xhrGetBuffetList() {
        // echo "post code = ".$_POST['code'];
        $user = Session::get('LoginData');
        $date = new DateTime();

        $code = (isset($_POST['bufftype']))?$_POST['bufftype']:"-1";
        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];

        $sql="SELECT bfdate, bftype, prmdesc typename, bfqty qty, ifnull(bfgrpnm,'-') grpnm
                FROM buffet, parameters
                WHERE prmid = 2
                AND bftype = prmcd
                AND (:code = -1 or bftype = :code)
                AND bfdate BETWEEN :sdate AND :edate
                ORDER BY bfdate, bftype, bfgrp ";
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
}

?>