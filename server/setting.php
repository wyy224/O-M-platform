<?php
session_start();
require_once 'database.php';

$conn = connectDB();


$sql = "SELECT * FROM alarm WHERE 1=1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row=mysqli_fetch_row($result)) {
        printf ("{date:%s, WF:%d, WT:%d, channel:%s, fault_type:%s, state:%d, value:%f, type:%s}&",$row[1],$row[2],$row[3],$row[4],$row[5],$row[8],$row[6], $row[7]);
    }
} else {
    echo "not match";
}

$conn->close();


?>