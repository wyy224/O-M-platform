<?php
ini_set('memory_limit', '5G');
$dataFile = $_FILES['dataFile'];
$dataType = $_POST['dataType'];

// threshold
$thresholds = [
    'strain' => 11,
    'vibration' => 0.005,
    'light' => 1,
    'rotate' => 5,
    'noise' => 0.5
];
$response = [];
$results = [];


// Group data by channel
if (($handle = fopen($dataFile['tmp_name'], 'r')) !== FALSE) {
    $header = fgetcsv($handle);
    $numChannels = count($header) - 1;

    $channelsData = array_fill(0, $numChannels, []);

    while (($data = fgetcsv($handle)) !== FALSE) {
        $date = $data[0];
        for ($i = 1; $i <= $numChannels; $i++) {
            $value = floatval($data[$i]);
            $channelsData[$i - 1][] = ['date' => $date, 'value' => $value]; // Store data as a channel index
        }
    }
    fclose($handle);

    foreach ($channelsData as $index => $values) {
        $valueArray = array_column($values, 'value');
        $mean = array_sum($valueArray) / count($valueArray);
        $stddev = sqrt(array_sum(array_map(function ($value) use ($mean) {
                return pow($value - $mean, 2);
            }, $valueArray)) / count($valueArray));
        if ($dataType == 'noise'){
            $thresholds[$dataType] = 8 * $stddev;
        }
        foreach ($values as $entry) {
            $date = $entry['date'];
            $value = $entry['value'];

            // Detect differences from the mean
            if (abs($value - $mean) > $thresholds[$dataType]) {
                $results[] = [
                    'date' => $date,
                    'channel' => "channel" . ($index + 1),
                    'value' => $value,
                    'fault_type' => getFaultType($dataType),
                    'data_type' => $dataType
                ];
            }
        }
    }

    if (!empty($results)) {
        foreach ($results as $result) {
            $response[] = [
                'date' => $result['date'],
                'channel' => $result['channel'],
                'value' => $result['value'],
                'fault_type' => $result['fault_type'],
                'data_type' => $result['data_type']
            ];
        }
        echo json_encode(['status' => 'success', 'data' => $response]);
    } else {
        echo json_encode(['status' => 'no_faults', 'message' => $mean]);
    }
}

function getFaultType($dataType) {
    switch ($dataType) {
        case 'strain':
            return 'Mechanical Wear';
        case 'vibration':
            return 'Resonance Fault';
        case 'light':
            return 'Light Variation Issue';
        case 'rotate':
            return 'Rotate Imbalance';
        case 'noise':
            return 'Bearing Fault';
        default:
            return 'Unknown Fault';
    }
}
?>