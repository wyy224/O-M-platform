<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_SESSION['username'])) {
            echo "login";
        }
        if (isset($_SESSION['username']) && $_SESSION['role'] == "admin") {
            echo "admin";
        }
        if (!isset($_SESSION['username'])){
            echo "logout";
        }
    }
    ?>
