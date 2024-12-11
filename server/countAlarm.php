<?php
session_start();
require_once 'database.php';

$conn = connectDB();

$sql = "SELECT wind_field_id, wind_turbine_id, data_type, channel, COUNT(*) as exception_count
        FROM alarm
        WHERE state = 0 
        GROUP BY wind_field_id, wind_turbine_id, data_type, channel";
$sql2 = "SELECT wind_field_id, wind_turbine_id, data_type, channel, COUNT(*) as exception_count
        FROM alarm
        WHERE state = 1  
        GROUP BY wind_field_id, wind_turbine_id, data_type, channel";

$result = $conn->query($sql);
$result2 = $conn->query($sql2);

$exceptionCounts = [];

if ($result->num_rows != 0 && $result2->num_rows !=0) {
    $rowCount = $result->num_rows;
    $rowCount2 = $result2->num_rows;
    echo $str = sprintf("%d", $rowCount).",".sprintf("%d", $rowCount2);
}
elseif ($result->num_rows != 0 && $result2->num_rows == 0){
    $rowCount = $result->num_rows;
    echo $str = sprintf("%d", $rowCount);
}
elseif ($result->num_rows == 0 && $result2->num_rows !=0){
    $rowCount2 = $result2->num_rows;
    echo sprintf("%d", $rowCount2);}

else {
    echo "0";
}


?>
