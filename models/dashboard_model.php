<?php

class Dashboard_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    function getProfitSummary() {
        $date = new DateTime();
        
        $sdate = (isset($_POST['sdate']))?$_POST['sdate']:date_format($date,"Y-m-01");
        $edate = (isset($_POST['edate']))?$_POST['edate']:date_format($date,"Y-m-t");

        $sql="SELECT (SELECT IFNULL(SUM(rvnamt), 0) FROM revenue WHERE rvndate BETWEEN :sdate AND :edate AND rvncd != '2') sale,
                    (SELECT IFNULL(SUM(bfqty), 0) FROM buffet WHERE bfdate BETWEEN :sdate AND :edate AND bftype='7') buff,
                    (SELECT IFNULL(SUM(expamt), 0) FROM expenses WHERE expdate BETWEEN :sdate AND :edate) expense ";
            // echo $sql."<br>";
        $stmt=$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $stmt=$this->db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute([
            ':sdate' => $sdate,
            ':edate' => $edate
          ]);

        $data = $stmt->fetch();

        return $data;
    }

    function getProfitAllDays() {
        
        $date = new DateTime();
        $year = (isset($_POST['p_year']))?$_POST['p_year']:date_format($date,"Y");
        $month = (isset($_POST['p_month']))?$_POST['p_month']:date_format($date,"m");

        $sql="call search_profit_by_month(:year, :month); ";
            // echo $sql."<br>";
        $stmt=$this->db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute([
            ':year' => $year,
            ':month' => $month
          ]);

        $data = $stmt->fetchAll();

        return $data;
    }

    function getProfitDetails() {
        $date = new DateTime();
        
        $sdate = (isset($_POST['sdate']))?$_POST['sdate']:date_format($date,"Y-m-01");
        $edate = (isset($_POST['edate']))?$_POST['edate']:date_format($date,"Y-m-t");

        $sql="call search_profit_details(:sdate, :edate); ";
            // echo $sql."<br>";
        $stmt=$this->db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute([
            ':sdate' => $sdate,
            ':edate' => $edate
          ]);

        $data = $stmt->fetchAll();

        return $data;
    }
}

?>