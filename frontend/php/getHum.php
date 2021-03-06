<?php
$ini = parse_ini_file("../conf/settings.ini", true);
date_default_timezone_set($ini['common']['timezone']);
$date = date('Y-m-d H:i:s', time());
$connection = mysqli_connect($ini['mysql']['mysql_hostname'],$ini['mysql']['mysql_username'],$ini['mysql']['mysql_password'],$ini['mysql']['mysql_database'])
    or die("Connection Error " . mysqli_error($connection));
$sql = "SELECT date, city_curr_hum, nest_curr_hum, nest_targ_hum FROM status WHERE (DATE(date) BETWEEN (date('".$_GET['start']."')) AND (date('".$_GET['end']."')));";
$result = mysqli_query($connection, $sql) or die("Error in Selecting " . mysqli_error($connection));
$sql_array = array("cols" => array(array("label"=>"Date", "type"=>"datetime"),array("label"=>"Target","type"=>"number"),
                                   array("label"=>"Interior","type"=>"number"), array("label"=>"Exterior","type"=>"number")));
while($row =mysqli_fetch_assoc($result))
{
    $phpdate = strtotime($row['date'].' UTC');
    $date_array = "Date(".date('Y', $phpdate).",".(date('n', $phpdate)-1).",".date('d', $phpdate)
        .",".date('H', $phpdate).",".date('i', $phpdate).")";
    $sql_array["rows"][] = array("c" => array(array("v" => $date_array), array("v" => $row["nest_targ_hum"]),
                                              array("v" => $row["nest_curr_hum"]), array("v" => $row["city_curr_hum"])));
}
mysqli_close($connection);
echo json_encode($sql_array);
?>
