<?php
require_once 'database.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['selectedRows']) && isset($data['chType']) && isset($data['chState'])) {
    $selectedRows = $data['selectedRows'];
    $Type = $data['chType'];
    $State = $data['chState'];

    $conn = connectDB();
    foreach ($selectedRows as $row) {
        $value = $row['value'];
        $date = $row['date'];
        $type = $row['type'];
        $windField = $row['windField'];
        $windTurbine = $row['windTurbine'];
        $channel = $row['channel'];
        $fault_type = $row['fault_type'];
        $state = $row['state'];
        $stmt = $conn->prepare("UPDATE alarm SET data_type = ?, state = ? WHERE time = ? AND channel = ? AND fault_type = ? AND wind_field_id = ? AND wind_turbine_id = ? AND value = ? AND data_type = ?");

        $stmt->bind_param("sisssiids", $Type, $State, $date, $channel, $fault_type, $windField, $windTurbine, $value, $type);
        if ($stmt->execute()) {
            echo "Modify successfully";
        } else {
            echo "Error: " . $stmt . "<br>" . $conn->error;
        }
    }
        $conn->close();

}
?>