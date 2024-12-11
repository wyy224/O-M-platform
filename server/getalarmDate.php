<?php
require_once 'database.php';

$data = json_decode(file_get_contents('php://input'), true);
$date = isset($data['date']) ? $data['date'] : null;
$conn = connectDB();

if ($date) {
    $sql = "SELECT data_type, fault_type, channel, wind_field_id, wind_turbine_id 
            FROM alarm 
            WHERE DATE(time) = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $date);
    $stmt->execute();
    $result = $stmt->get_result();

    $alarms = [];
    while ($row = $result->fetch_assoc()) {
        $alarms[] = $row;
    }

    echo json_encode($alarms);
} else {
    echo json_encode([]);
}


$conn->close();
?>