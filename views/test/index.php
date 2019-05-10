Test<br/>
<?php
$userMenu =  $_SESSION['userMN'];
// print_r($userMenu);

echo $userMenu["code"].'<br/>';
// $menus = $userMenu["menu"];
foreach ($userMenu["menus"] as $menu) {
    echo $menu["id"]." -> ".$menu["name"]." -> ".$menu["url"]." -> ".$menu["level"]."</br>";
}
?>