

<?php
require 'config/paths.php';
require 'libs/Database.php';
require 'config/database.php';
echo "New version 19/03/2563"."<br>";

$pastDate = strtotime('2019-05-28')."<br>";
$currentDate = strtotime(date("Y-m-d"))."<br>";

// echo ($currentDate - $pastDate)/( 60 * 60 * 24 )."<br>";

$date = new DateTime();
echo date_format($date,"Y-m-d H:i:s")."<br>";
echo date("Y-m-d H:i:s")."<br>";
// $date = new DateTime('2020-02-16');
// echo $date."</br>";
echo date_format($date,"Y-m-01")."<br>";
echo date_format($date,"Y-m-t")."<br>";
$date->sub(new DateInterval('P1D'));
echo date_format($date,"Y-m-d")."<br>";
echo date("Y-m-d",strtotime("yesterday"))."<br>"; 

if (date_format($date,"d") <= 15) {
    echo date_format($date,"Y-m-15")."<br>";
} else {
    echo date_format($date,"Y-m-t")."<br>";
}

$p = array("first_key" => "first_value", "second_key" => "second_value");


echo $p['second_key']."<br>";

echo "Current PHP Version : ".phpversion()."<br>";

// echo "PHP Info : ".phpinfo();

echo "HTTP_CLIENT_IP : ". $_SERVER['HTTP_CLIENT_IP']."<br>";
echo "HTTP_X_FORWARDED_FOR : ". $_SERVER['HTTP_X_FORWARDED_FOR']."<br>";
echo "REMOTE_ADDR : ". $_SERVER['REMOTE_ADDR']."<br>";
echo getenv('REMOTE_ADDR')."<br>";

if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
{
    $ip=$_SERVER['HTTP_CLIENT_IP'];
}
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
{
    $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
}
else
{
    $ip=$_SERVER['REMOTE_ADDR'];
}
echo "IP : ". $ip."<br>";

$ipinfo = file_get_contents("http://ipinfo.io/{$ip}");
echo $ipinfo."<br>";

$ipObj = json_decode($ipinfo,true);
// echo "ipObj : ".$ipObj."<br>";
echo "org : ".$ipObj["org"]."<br>";
echo "hostname : ".$ipObj["hostname"]."<br>";

echo strlen(strstr($ipObj["org"],"AS1755 True Internet"))."<br>";
echo strlen(strstr($ipObj["org"],"AS17552 True Internet"))."<br>";
echo strlen(strstr($ipObj["hostname"],"revip2.asianet.co.th"))."<br>";

if (strlen(strstr($ipObj["org"],"AS17552 True Internet"))>0 &&
    strlen(strstr($ipObj["hostname"],"asianet.co.th"))>0) {
    echo  "Can checkin"."<br>";
} else {
    echo  "Cannot checkin"."<br>";
}

// ============================ Database ============================== //

$db = new Database();
$db->query("SET time_zone = '+07:00'");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

$sql = "SELECT pmdval1 ip FROM prmdtl
        WHERE pmdtbno=1
        AND pmdcd=3";
$sth = $db->prepare($sql);
$sth->setFetchMode(PDO::FETCH_ASSOC);
$sth->execute();
$data = $sth->fetch();
echo "Restaurant IP : ".$data['ip']."<br>";

require 'libs/Model.php';
require 'models/checkin_model.php';
$chkin = new Checkin_Model();
$ip = $chkin->xhrShopIP();
echo "Check IP : ".$ip."<br>";

?>