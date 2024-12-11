<?php
session_start();
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
 $username = $_POST['username'];
 $password = hash('sha256', $_POST['password']);
 $email = $_POST['email'];
    if (registerUser($username, $password, $email)) {
        echo "success";
    } else {
        echo "Failed to register user";
    }
}
?>