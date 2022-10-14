<!DOCTYPE html>
<html>
<head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
</style>
</head>
<body>
<?php

require 'config/paths.php';
require 'libs/Database.php';
require 'config/database.php';

$db = new Database();
$db->query("SET time_zone = '+07:00'");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

// $ins_hist = "INSERT INTO ip_history(ip_addr, ip_created) VALUES(:ip, current_timestamp)";

// $upd_param = "UPDATE prmdtl
//         SET pmdval1=:ip
//             ,pmdval2=current_timestamp
//         WHERE pmdtbno=1
//         AND pmdcd=3";
if (isset($_GET['saldate'])) {
    $saldate = $_GET['saldate'];
    // <p style="font-size:30;">I am big</p>
    echo "<p style='font-size:25px;'><strong>รอบเงินเดือนวันที่ : ".$saldate."</strong></p>";
    // echo "SET @p_edate='".$saldate."';"."<br>";

    try {
        $db->beginTransaction();

        $db->query("SET @p_edate='".($saldate)."';");
        $db->query("SET @p_sdate=DATE(IF((@p_edate)=LAST_DAY(@p_edate)
                    ,date_add(LAST_DAY(date_add(@p_edate,interval -1 MONTH)),interval 16 DAY)
                    ,date_add(LAST_DAY(date_add(@p_edate,interval -1 MONTH)),interval 1 DAY)));");
        $db->query("SET @p_fdate=DATE(date_add(LAST_DAY(date_add(@p_edate,interval -1 MONTH)),interval 1 DAY));");
        $db->query("SET @p_paymethd=IF((@p_edate)=LAST_DAY(@p_edate),1,2);");
        $db->query("SET @daysofmonth=IF(DATE_FORMAT(@p_edate,'%c')=2, 30, DATE_FORMAT(LAST_DAY(@p_edate),'%d'));");

        $db->query("SET @p_empcd=-1;");    

        // $sql = "SELECT @p_empcd empcd, @p_sdate sdate, @p_fdate fdate, @p_edate edate, @p_paymethd paymethd, @daysofmonth daysofmonth;";
        // $result = $db->query($sql);
        
        // output data of each row
        //   while($row = $result->fetch()) {
        //     echo $row["empcd"]. " | " . $row["sdate"]. " | " . $row["fdate"]. " | " . $row["edate"]. " | " . $row["paymethd"]
        //     . " | " . $row["daysofmonth"]."<br>";
        //   }

        $db->prepare("DELETE FROM timesheet_stagging WHERE (@p_empcd=-1 or stimempcd=@p_empcd);")->execute();
        $sql = "insert into timesheet_stagging 
                select timempcd, timdate, timin, timout
                        , ISNULL(timin) leaveday
                        , CASE WHEN paycalctyp='1' THEN
                                IF(DATE_FORMAT(timin,'%Y%m%d %H:%i')<=DATE_FORMAT(timdate,CONCAT('%Y%m%d ',pmdval5)),
                                    UNIX_TIMESTAMP(ADDTIME(timdate,pmdval1)) - UNIX_TIMESTAMP(timin),0)
                            ELSE
                                IF(timin <= DATE_ADD(ADDTIME(timdate, paystime),INTERVAL IF(usrrolcd='ADM', -10, pmdval1) MINUTE),
                                        UNIX_TIMESTAMP(ADDTIME(timdate,paystime)) - UNIX_TIMESTAMP(timin)  /* - IF(timempcd = '63002', 3600, 0) */ ,0) END otmorning
                        , CASE WHEN paycalctyp='1' THEN
                                IF(DATE_FORMAT(timout,'%Y%m%d %H:%i')>=DATE_FORMAT(timdate,CONCAT('%Y%m%d ',pmdval4)),
                                    UNIX_TIMESTAMP(timout) - UNIX_TIMESTAMP(ADDTIME(timdate,pmdval2)),0)
                            ELSE
                                IF(timout >= DATE_ADD(ADDTIME(timdate, payetime),INTERVAL IF(usrrolcd='ADM', 10, pmdval2) MINUTE), -- pmdval1
                                        UNIX_TIMESTAMP(timout) - UNIX_TIMESTAMP(ADDTIME(timdate,payetime))  /* - IF(timempcd = '63002' AND timin >= ADDTIME(timdate, '13:30') , 3600, 0) */ ,0) END otevening
                        , CASE WHEN paycalctyp='1' THEN
                                IF(DATE_FORMAT(timin,'%Y%m%d %H:%i')>=DATE_FORMAT(timdate,CONCAT('%Y%m%d ','11:00')),
                                    UNIX_TIMESTAMP(timin) - UNIX_TIMESTAMP(ADDTIME(timdate,pmdval1)),0)
                            ELSE
                                IF(timin >= DATE_ADD(ADDTIME(timdate, paystime),INTERVAL pmdval3 MINUTE),
                                        UNIX_TIMESTAMP(timin) - UNIX_TIMESTAMP(ADDTIME(timdate,paystime)),0) END latemorning
                        , CASE WHEN paycalctyp='1' THEN
                                IF(DATE_FORMAT(timout,'%Y%m%d %H:%i')<=DATE_FORMAT(timdate,CONCAT('%Y%m%d ','21:50')),
                                    UNIX_TIMESTAMP(ADDTIME(timdate,pmdval2)) - UNIX_TIMESTAMP(timout),0)
                            ELSE 
                                IF(timout <= DATE_ADD(ADDTIME(timdate, payetime),INTERVAL pmdval4 MINUTE),
                                    UNIX_TIMESTAMP(ADDTIME(timdate,payetime)) - UNIX_TIMESTAMP(timout),0) END lateevening
                        , CEIL(paysal/IF(usrrolcd='ADM', 30, @daysofmonth)) payperday
                from timesheet, prmdtl, payment, user
                WHERE (@p_empcd=-1 or timempcd=@p_empcd)
                AND timempcd=usrcd
                and pmdtbno=1
                and pmdcd=paycalctyp
                and paydeptid<>5
                and timempcd=payempcd
                and (paymethd=2 or paymethd=@p_paymethd)
                and timdate BETWEEN paysdate and payedate
                and timdate between IF(paymethd=2,@p_sdate,@p_fdate) and @p_edate
                and timspec IS NULL 
                AND ((paycalctyp='1'  
                        AND (DATE_FORMAT(timdate,'%a')<>'Mon'
                                or ( DATE_FORMAT(timdate,'%a')='Mon' 
                                        and IFNULL(timspec,0) = 0
                                        and (UNIX_TIMESTAMP(timout) - UNIX_TIMESTAMP(timin)) >= 45000)	-- 12.5 Hours
                            )
                        AND ( (timin is NULL AND IFNULL(timspec,0) = 0)
                                    OR DATE_FORMAT(timout,'%Y%m%d %H:%i')>=DATE_FORMAT(timdate,CONCAT('%Y%m%d ',pmdval4)) -- After 22:30
                                    OR DATE_FORMAT(timin,'%Y%m%d %H:%i')<=DATE_FORMAT(timdate,CONCAT('%Y%m%d ',pmdval5))	-- Before 09:20
                                OR DATE_FORMAT(timin,'%Y%m%d %H:%i')>=DATE_FORMAT(timdate,CONCAT('%Y%m%d ','11:00'))
                                OR DATE_FORMAT(timout,'%Y%m%d %H:%i')<=DATE_FORMAT(timdate,CONCAT('%Y%m%d ','21:50'))
                            )
                        ) OR 
                        (paycalctyp='2' 
                        AND ((	timin is NULL 
                                    AND IFNULL(timspec,0) = 0 
                                    AND INSTR(ifnull(paydayoff,'x'), DATE_FORMAT(timdate,'%a')) = 0 )
                                OR (
                                    IFNULL(timspec,0) = 0
                                        AND INSTR(ifnull(paydayoff,'x'), DATE_FORMAT(timdate,'%a')) = 0 
                                    AND (
                                        timin <= DATE_ADD(ADDTIME(timdate, paystime),INTERVAL IF(usrrolcd='ADM', -10, pmdval1) MINUTE)
                                        OR timout >= DATE_ADD(ADDTIME(timdate, payetime),INTERVAL IF(usrrolcd='ADM', 10, pmdval2) MINUTE)
                                        OR timin >= DATE_ADD(ADDTIME(timdate, paystime),INTERVAL 10 MINUTE)
                                        OR timout <= DATE_ADD(ADDTIME(timdate, payetime),INTERVAL -10 MINUTE)
                                        )
                                    )
                            )
                    ))
                order by timempcd, timdate;";
        $db->prepare($sql)->execute();
        $sql = "insert into timesheet_stagging (stimempcd, stimdate, stimin, stimout, stimlvday, stimotmn, stimpayday)
                select timempcd, timdate, timin, timout, ISNULL(timin) leaveday
                        , UNIX_TIMESTAMP(timout) - UNIX_TIMESTAMP(timin) otsec
                        , CEIL(paysal/IF(usrrolcd='ADM', 30, @daysofmonth)) payperday -- , DATE_FORMAT(timdate,'%a')
                from timesheet, prmdtl, payment, user
                where (@p_empcd=-1 or timempcd=@p_empcd)
                AND timempcd=usrcd
                and pmdtbno=1
                and pmdcd=paycalctyp
                and paydeptid<>5
                and timempcd=payempcd
                AND timspec IS null
                and (paymethd=2 or paymethd=@p_paymethd)
                and timdate BETWEEN paysdate and payedate
                and timdate between IF(paymethd=2,@p_sdate,@p_fdate) and @p_edate
                AND INSTR(ifnull(paydayoff,'x'), DATE_FORMAT(timdate,'%a')) > 0
                AND timin IS NOT NULL;";
        $db->prepare($sql)->execute();

        $sql = "SELECT e.usrcd empcd, e.usrnm name, @p_edate paydate, ROUND(p.paysal/p.paymethd,0) sal, p.psso sso 
                , IF(s.otsec=0,NULL,CEIL((MINUTE(SEC_TO_TIME(s.otsec))/60 + HOUR(SEC_TO_TIME(s.otsec)))*(LEAST(s.payday/payhour,IF(usrrolcd='ADM', 100, 50))))) otpay
                , IF(s.latesec=0,NULL,CEIL((MINUTE(SEC_TO_TIME(s.latesec))/60 + HOUR(SEC_TO_TIME(s.latesec)))*(s.payday/payhour))) latepay
                , adv.advpay advance
                , (s.absday * IF(usrrolcd='ADM', FLOOR(paysal/@daysofmonth), s.payday)) absence
                , NULL tax, null total
                , IF(s.otsec=0,NULL,SEC_TO_TIME(otsec)) ottim, IF(s.latesec=0,NULL,SEC_TO_TIME(latesec)) lattim
                , s.absday absday, otsec, latesec
                , (MINUTE(SEC_TO_TIME(s.otsec))/60 + HOUR(SEC_TO_TIME(s.otsec))) otmulti
                , (MINUTE(SEC_TO_TIME(s.latesec))/60 + HOUR(SEC_TO_TIME(s.latesec))) latemulti
            FROM (SELECT * from user WHERE (@p_empcd=-1 or usrcd=@p_empcd)) e join (
                select payempcd, paymethd, paysal, IF(@p_paymethd=2,null,paysso) psso, payhour
                from payment 
                where @p_edate BETWEEN paysdate and payedate
                and paydeptid NOT IN (4,5)
                and (paymethd=2 or paymethd=@p_paymethd)
                ) p on e.usrcd=p.payempcd
            left join (
                    SELECT sumot.empcd, sum(if(sumot.sec >= 0, sumot.sec, 0)) otsec, -sum(if(sumot.sec <= 0, sumot.sec, 0)) latesec, 
                            sum(absday) absday, payday
                    FROM (
                            SELECT stimempcd empcd, (ifnull(stimotmn,0)+ifnull(stimotev,0)-ifnull(stimlatemn,0)-ifnull(stimlateev,0)) sec, 
                                        ifnull(stimlvday,0) absday, stimpayday payday
                            from timesheet_stagging
                            ) sumot
                    GROUP BY empcd, payday
            ) s on e.usrcd=s.empcd
            left join (
                select advempcd, SUM(advpay) advpay from advance, payment
                where @p_edate BETWEEN paysdate and payedate
                AND advempcd=payempcd
                and advdate between IF(paymethd=2,@p_sdate,@p_fdate) and @p_edate
                group by advempcd
            ) adv on adv.advempcd=e.usrcd
            UNION	
            SELECT usrcd empcd, usrnm name, @p_edate paydate, paysal sal, null sso, null otpay, null latepay
                    , null advance, (s.absday*payday) absense, null tax, null total, null ottim, null latetim, null absday, null otsec
                    , null latesec, null otmulti, null latemulti
            FROM (SELECT * from user WHERE (@p_empcd=-1 or usrcd=@p_empcd)) e join (
                    SELECT payempcd, paymethd, paysal, CEIL(paysal/COUNT(date_field)) payday
                    FROM payment, (
                                    SELECT
                                        MAKEDATE(YEAR(@p_edate),1) +
                                        INTERVAL (MONTH(@p_edate)-1) MONTH +
                                        INTERVAL daynum DAY date_field
                                    FROM
                                    (
                                        SELECT t*10+u daynum
                                        FROM
                                            (SELECT 0 t UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6) A,
                                            (SELECT 0 u UNION SELECT 1 UNION SELECT 2 UNION SELECT 3
                                            UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7
                                            UNION SELECT 8 UNION SELECT 9) B
                                        ORDER BY daynum
                                    ) AA
                                ) AAA
                    WHERE MONTH(date_field) = MONTH(@p_edate)
                    AND (paymethd=2 or paymethd=@p_paymethd)
                    AND @p_edate BETWEEN paysdate and payedate
                    AND paydeptid=4
                    AND ifnull(paydayoff,'x') like CONCAT('%',DATE_FORMAT(date_field,'%a'),'%' )
                    GROUP BY payempcd, paymethd, paysal, paysal
            ) p on e.usrcd=p.payempcd
            left join (
            select stimempcd empcd, sum(ifnull(stimlvday,0)) absday
            from timesheet_stagging
            group by stimempcd, stimpayday
            ) s on e.usrcd=s.empcd
            UNION
            SELECT timempcd empcd, usrnm name, @p_edate paydate, COUNT(1)*paysal sal, null sso, SUM(IFNULL(timspec,0))*payothour otpay, null latepay 
                , null advance, null absense, null tax, null total, null ottim, null latetim, null absday, null otsec
                , null latesec, null otmulti, null latemulti
            FROM timesheet, payment, user
            WHERE timempcd=payempcd
            AND timempcd=usrcd
            AND (@p_empcd=-1 or timempcd=@p_empcd)
            and paydeptid=5
            AND @p_edate BETWEEN paysdate and payedate
            and timdate between IF(paymethd=2,@p_sdate,@p_fdate) and @p_edate
            GROUP BY timempcd, payothour, paysal
            ORDER BY empcd;";

            $result = $db->query($sql);
            ?>
            <table id="customers">
                <tr>
                    <th style='text-align:center'>Code</th>
                    <th style='text-align:center'>ชื่อ-นามสกุล</th>
                    <th style='text-align:center'>Salary</th>
                    <th style='text-align:center'>ประกันสังคม</th>
                    <th style='text-align:center'>OT</th>
                    <th style='text-align:center'>สาย</th>
                    <th style='text-align:center'>เบิก</th>
                    <th style='text-align:center'>ขาดงาน</th>
                    <th style='text-align:center'>รวม</th>                
                </tr>
    <?php 
            $net = 0;
            $total = 0;
                
            // output data of each row
            while($row = $result->fetch()) {
            $total = $row["sal"]+$row["otpay"]-$row["sso"]-$row["latepay"]-$row["advance"]-$row["absence"];
            $net = $net+$total;
                
            echo "<tr>
                    <td style='text-align:center'>".$row["empcd"]."</td>
                    <td style='text-align:left'>".$row["name"]."</td>
                    <td style='text-align:right'>".number_format($row["sal"])."</td>
                    <td style='text-align:right'>".number_format($row["sso"])."</td>
                    <td style='text-align:right'>".number_format(($row["otpay"]>=$row["latepay"])?$row["otpay"]-$row["latepay"]:0)."</td>
                    <td style='text-align:right'>".number_format(($row["otpay"]<$row["latepay"])?$row["latepay"]-$row["otpay"]:0)."</td>
                    <td style='text-align:right'>".number_format($row["advance"])."</td>
                    <td style='text-align:right'>".number_format($row["absence"])."</td>
                    <td style='text-align:right'>".number_format($total)."</td>
                </tr>";
                
            }
            echo "<tr style='background-color:#2c9448'>
                <td style='text-align:center; color: #fff'><strong style='font-size: 30px;'>Total</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style='text-align:right; color: #fff'><strong style='font-size: 30px;'>".number_format($net)."</strong></td>
                </tr>";
    ?>
            </table>

    <?php

        $db->commit();

    } catch (Exception $e) {
        echo "Error at ".date("Y-m-d H:i:s")." : ".$e->getMessage()."<br>";
        $db->rollBack();
    }
} else {
    echo "กรุณาระบุวันที่เงินเดือน";
}

?>
</body>
</html>