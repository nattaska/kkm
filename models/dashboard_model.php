<?php

class Dashboard_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    function getProfitSummary() {
        
        $date = new DateTime();
        $ddate = (isset($_POST['ddate']))?$_POST['ddate']:date_format($date,"Ym");

        $sql="SELECT (SELECT SUM(rvnamt) FROM revenue WHERE date_format(rvndate,'%Y%m')=:ddate) sale,
                    (SELECT SUM(bfqty) FROM buffet WHERE date_format(bfdate,'%Y%m')=:ddate AND bftype='7') buff,
                    (SELECT SUM(expamt) FROM expenses WHERE date_format(expdate,'%Y%m')=:ddate) expense ";
            // echo $sql."<br>";
        $stmt=$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $stmt=$this->db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute([
            ':ddate' => $ddate
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
}

?>