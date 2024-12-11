<?php
require_once 'database.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['type'])) {
    $type = $data['type'];
    $conn = connectDB();
    $sql = "SELECT data_type, wind_field_id, wind_turbine_id, state 
            FROM alarm 
            WHERE data_type = ? 
            ORDER BY time DESC 
            LIMIT 5";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $type);
    $stmt->execute();
    $result = $stmt->get_result();

    $dataList = [];
    while ($row = $result->fetch_assoc()) {
        $dataList[] = $row;
    }

    echo json_encode($dataList);

} else {
    echo json_encode(["error" => "Data type not specified"]);
}
?>