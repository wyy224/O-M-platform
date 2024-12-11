<?php
require_once 'database.php';

    $data = json_decode(file_get_contents('php://input'), true);
    $WF = isset($data['WF']) ? $data['WF'] : '';
    $WT = isset($data['WT']) ? $data['WT'] : '';
    $channel = isset($data['channel']) ? $data['channel'] : '';
    $alarmType = isset($data['alarmType']) ? $data['alarmType'] : '';
    $state = isset($data['state']) ? $data['state'] : '';
    $startDate = isset($data['startDate']) ? $data['startDate'] : '';
    $endDate = isset($data['endDate']) ? $data['endDate'] : '';

    $conn = connectDB();


    $sql = "SELECT * FROM alarm WHERE 1=1";

    if ($WF) {
        $sql .= " AND wind_field_id = '$WF'";
    }
    if ($WT) {
        $sql .= " AND wind_turbine_id = '$WT'";
    }
    if ($channel) {
        $sql .= " AND channel = '$channel'";
    }
    if ($alarmType) {
        $sql .= " AND fault_type = '$alarmType'";
    }
    if ($state) {
        $sql .= " AND state = '$state'";
    }
    if ($startDate && $endDate) {
        $sql .= " AND time BETWEEN '$startDate' AND '$endDate'";
    }


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