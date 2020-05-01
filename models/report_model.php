<?php

class Report_Model extends Model {

    public function __construct() {
        parent::__construct();
    }

    function getProfit() {
        $date = new DateTime();

        $sdate = $_POST['sdate'];
        $edate = $_POST['edate'];

        // echo $bufftype."<br>";
        
        $sql = "SELECT s.sale_date, FORMAT(s.panda,2) panda, FORMAT(s.npfood,2) npfood, 
                        FORMAT(s.kkm,2) kkm, FORMAT(b.bfamt,2) bfamt, 
                        FORMAT((ifnull(s.panda,0)+ifnull(s.npfood,0)+s.kkm+ifnull(b.bfamt,0)),2) income, FORMAT(e.expamt,2) expamt,
                        FORMAT((ifnull(s.panda,0)+ifnull(s.npfood,0)+s.kkm+ifnull(b.bfamt,0)-e.expamt),2) net
                FROM 
                    (
                        SELECT a.sale_date,
                                sum(case when a.ordtyp = 'FPD' then a.amt END) as panda,
                                sum(case when a.ordtyp = 'NPF' then a.amt END) as npfood,
                                sum(case when a.ordtyp = 'KKM' then a.amt END) as kkm
                        FROM (
                                SELECT date(salorddttm) sale_date, salordtyp ordtyp, pmddesc ordtypnm, SUM(salamt-satretamt) amt
                                FROM sales_daily, prmdtl
                                WHERE date(salorddttm) BETWEEN :sdate AND :edate
                                AND pmdtbno=14
                                AND pmdcd=salordtyp
                                GROUP BY date(salorddttm), salordtyp, pmddesc
                            ) a
                        GROUP BY a.sale_date
                    ) s 
                     LEFT JOIN (
                        SELECT bfdate, SUM(bfqty) bfamt 
                        FROM buffet
                        WHERE bfdate BETWEEN :sdate AND :edate
                        AND bftype=7
                        GROUP BY bfdate
                    ) b ON s.sale_date=b.bfdate
                     LEFT JOIN (
                        SELECT expdate, SUM(expamt) expamt FROM expenses
                        WHERE expdate BETWEEN :sdate AND :edate
                        GROUP BY expdate
                    ) e ON s.sale_date=e.expdate ";
                // WHERE s.sale_date=b.bfdate
                // AND s.sale_date=e.expdate ";
            // echo $sql."<br>";
        $stmt=$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
        $stmt=$this->db->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute([
            ':sdate' => $sdate,
            ':edate' => $edate
          ]);
        $data = $stmt->fetchAll();

        echo json_encode($data);
    }
}

?>