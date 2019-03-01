<?php

$date = new DateTime();
echo date_format($date,"Y-m-01")."<br>";
echo date_format($date,"Y-m-t")."<br>";

$p = array("first_key" => "first_value", "second_key" => "second_value");


echo $p['second_key']."<br>";

echo "Current PHP Version : ".phpversion();

echo "PHP Info : ".phpinfo();

?>