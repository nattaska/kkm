<?php

$date = new DateTime();
echo date_format($date,"Y-m-01");
echo date_format($date,"Y-m-t");

$p = array("first_key" => "first_value", "second_key" => "second_value");


echo $p['second_key'];

?>