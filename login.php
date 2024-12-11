<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/login.css">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script> -->
    <script src="js/crypto-js.min.js"></script>
    <script src="js/login.js"></script>
</head>

<body>
    <?php
    //import the databse.php to use the functions
    require_once './server/database.php';
    session_start();
    ?>
    <div class="wrapper">
        <div class="top"></div>
        <div class="main">
            <div class="main-top">
            </div>
            <div class="main-center">
                <form id="login-form" class="login-form">
                    <div class="title">Login</div>
                    <div class="date-picker">
                        <label for="username">Username:</label>
                        <input type="text" id="username" name="username" class="date-input" placeholder="Please enter username">
                    </div>
                    <div class="date-picker">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="date-input" placeholder="Please enter password">
                    </div>
                    <div class="select-button-container">
                    <button type="submit" class="select-button">Login</button>
                    <button type="button" class="select-button" onclick="window.location = 'index.php'">home</button>
                    <!-- <button type="submit" class="select-button" id="selectBTN">登录</button> -->
                    </div>
                    <a href="register.php" class="register-link">Don't have an account yet. Sign up</a>
                </form>

            </div>
        </div>

    </div>
</body>

