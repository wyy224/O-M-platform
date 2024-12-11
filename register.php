<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="js/crypto-js.min.js"></script>
    <script src="js/register.js"></script>
</head>

<body>
    <div class="wrapper">
        <?php
        //import the databse.php to use the functions
        require_once './server/database.php';
        session_start();
        ?>
        <div class="top"></div>
        <div class="main">
            <div class="main-top">
            </div>
            <div class="main-center">
                <form id="register-form" class="login-form">
                    <div class="title">Register:</div>
                    <div class="date-picker">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" class="date-input" placeholder="Please enter username" required>
                    </div>
                    <div class="date-picker">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="date-input" placeholder="Please enter password" required>
                    </div> 
                    <div class="date-picker">
                        <label for="confirm-password">Confirm password:</label>
                        <input type="password" id="confirm-password" name="password" class="date-input" placeholder="Please enter password again" required>
                    </div> 
                    <div class="date-picker">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="date-input" placeholder="Please enter email" required>
                    </div>
                    <div class="select-button-container">
                    <button type="submit" class="select-button">Register</button>
                    <button type="button" class="select-button" onclick="window.location = 'index.php'">home</button>
                    </div>
                    <a href="login.php" class="register-link">You already have an account! Go to login
                    </a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>