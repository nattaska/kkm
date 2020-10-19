<?php

require 'libs/Database.php';
require 'config/database.php';

$db = new Database();
$db->query("SET time_zone = '+07:00'");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

$ins_hist = "INSERT INTO ip_history(ip_addr, ip_created) VALUES(:ip, current_timestamp)";

$upd_param = "UPDATE prmdtl
        SET pmdval1=:ip
            ,pmdval2=current_timestamp
        WHERE pmdtbno=1
        AND pmdcd=3";

try {
    $db->beginTransaction();
    $db->query("SET time_zone = '+07:00'");

    $stmt_hist = $db->prepare($ins_hist);
    $stmt_upd = $db->prepare($upd_param);

    $stmt_hist->execute(array(':ip'=>$ip));
    $stmt_upd->execute(array(':ip'=>$ip));

    $db->commit();
    echo "Finished";

} catch (Exception $e) {
    echo "Error : ".$e->getMessage();
    $db->rollBack();
}

?>