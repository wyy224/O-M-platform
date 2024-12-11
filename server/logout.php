<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    unset($_SESSION['username']);
    unset($_SESSION['user_id']);
    unset($_SESSION['role']);
    echo "yes";
}
?>