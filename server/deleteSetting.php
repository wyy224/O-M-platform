<?php
require_once 'database.php';
$conn = connectDB();
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['selected'])) {
    $selectedRows = $data['selected'];
    $conn = connectDB();
    $total = true;
    foreach ($selectedRows as $row) {
        $date = $row['date'] . ' 00:00:00';
        $channel = $row['channel'];
        $faultType = $row['fault_type'];
        $value = $row['value'];
        $datatype = $row['data_type'];
        $state = $row['state'];
        $WT = $row['WT'];
        $WF = $row['WF'];
        $stmt = $conn->prepare("SELECT COUNT(*) FROM alarm WHERE data_type = ? AND state = ? AND time = ? AND channel = ? AND fault_type = ? AND wind_field_id = ? AND wind_turbine_id = ? AND value = ?");
        $stmt->bind_param("sisisiid", $datatype, $state, $date, $channel, $faultType, $WF, $WT, $value);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->free_result();
        $insertStmt = $conn->prepare("DELETE FROM alarm WHERE data_type = ? AND state = ? AND time = ? AND channel = ? AND fault_type = ? AND wind_field_id = ? AND wind_turbine_id = ? AND value = ?");
        if ($count == 1) {
            $insertStmt->bind_param("sisisiid", $datatype, $state, $date, $channel, $faultType, $WF, $WT, $value);
            if ($insertStmt->execute()) {
            }
            else{
                $total = false;
            }
        }
        else{
            $total = false;
            echo $count;
        }
    }
    if ($total){
        echo 'success';
    }
    else{
        echo 'failed';
    }

} else {
    echo 'Invalid input';
}
?>