<?php
session_start();
require_once 'database.php';
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['selectedRows']) && isset($data['windFieldId']) && isset($data['windTurbineId'])) {
    $selectedRows = $data['selectedRows'];
    $windFieldId = $data['windFieldId'];
    $windTurbineId = $data['windTurbineId'];

    $conn = connectDB();

    foreach ($selectedRows as $row) {
        $date = $row['date'];
        $channel = $row['channel'];
        $faultType = $row['fault_type'];
        $value = $row['value'];
        $datatype = $row['data_type'];
        $stmt = $conn->prepare("SELECT COUNT(*) FROM alarm WHERE time = ? AND channel = ? AND fault_type = ? AND wind_field_id = ? AND wind_turbine_id = ? AND value = ?");
        $stmt->bind_param("sssiid", $date, $channel, $faultType, $windFieldId, $windTurbineId, $value);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->free_result();

        if ($count == 0) {
            $insertStmt = $conn->prepare("INSERT INTO alarm (time, channel, fault_type, wind_field_id, wind_turbine_id, value,data_type) VALUES (?, ?, ?, ?, ?, ?,?)");
            $insertStmt->bind_param("sssiids", $date, $channel, $faultType, $windFieldId, $windTurbineId, $value, $datatype);
            $insertStmt->execute();
            $insertStmt->close();
            echo 'success';
        } else {
            echo 'repeated';
        }
    }

} else {
    echo 'Invalid input';
}
?>
