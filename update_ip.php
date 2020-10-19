<?php

require 'libs/Database.php';
require 'config/database.php';

$db = new Database();
$db->query("SET time_zone = '+07:00'");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

$ins_hist = "INSERT INTO ip_history(ip_addr) VALUES(:ip)";
$stmt_hist = $db->prepare($ins_hist);

$upd_param = "UPDATE prmdtl
        SET pmdval1=:ip
            ,pmdval2=current_timestamp
        WHERE pmdtbno=1
        AND pmdcd=3";

$stmt_upd = $db->prepare($upd_param);

$stmt_hist->execute(array(':ip'=>$ip));
$stmt_upd->execute(array(':ip'=>$ip));

?>