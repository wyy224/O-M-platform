<?php
require_once 'database.php';

$conn = connectDB();


$param1 = $_POST['WF'];
$param2 = $_POST['WT'];
$param3 = $_POST['date'];
$param4 = 'channel'. $_POST['channel'];
$param5 = $_POST['value'];
$param6 = $_POST['type'];
$param7 = $_POST['fault'];
$param8 = $_POST['state'];

$stmt = $conn->prepare("SELECT COUNT(*) FROM alarm WHERE time = ? AND channel = ? AND fault_type = ? AND wind_field_id = ? AND wind_turbine_id = ? AND value = ? AND data_type = ?");
$stmt->bind_param("sssiids", $param3, $param4, $param7, $param1, $param2, $param5, $param6);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->free_result();

if ($count == 0) {
    $stmt2 = $conn->prepare("INSERT INTO alarm (time, channel, fault_type, wind_field_id, wind_turbine_id, value,data_type,state) VALUES (?, ?, ?, ?, ?, ?,?,?)");
    $stmt2->bind_param("sssiidsi", $param3, $param4, $param7, $param1, $param2, $param5, $param6, $param8);
    if ($stmt2->execute()) {
        echo "Create successfully";
    } else {
        echo "Error: " . $stmt2 . "<br>" . $conn->error;
    }
}
else{
    echo "repeated alarm!";
}

?>