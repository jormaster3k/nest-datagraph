<?php
$ini = parse_ini_file("../conf/settings.ini", true);
date_default_timezone_set($ini['common']['timezone']);
$connection =
mysqli_connect($ini['mysql']['mysql_hostname'],$ini['mysql']['mysql_username'],$ini['mysql']['mysql_password'],$ini['mysql']['mysql_database'])
    or die("Connection Error " . mysqli_error($connection));
$sql = "SELECT city_curr_temp FROM status ORDER BY id DESC LIMIT 1;";
$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection)); 
$row = mysqli_fetch_assoc($result);
$sql_array = array("cols" => array(array("label"=>"Exterior", "type"=>"number")), "rows" => array(array("c" => array(array("v" => round($row['city_curr_temp'],1, PHP_ROUND_HALF_UP))))));
echo json_encode($sql_array);
?>
