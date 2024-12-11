<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
session_start();
require_once 'database.php';


$conn = connectDB();

$table = $_POST['table'];
$date = $_POST['date'];

$query = "SELECT * FROM $table WHERE DATE(time) = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}


if (empty($data)) {
    echo json_encode(["message" => "No data found!"]);
} else {
    echo json_encode($data);
}


