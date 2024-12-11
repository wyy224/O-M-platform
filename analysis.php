
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/analysis.css">

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
            <ul>
                <li id="overview">Overview</li>
                <li id="selectAndEdit">Data</li>
                <li class="active"  id="analysis">Analysis</li>
                <li id="alarm">Alarm</li>
                <li id="setting">Setting</li>
            </ul>
            <div class="logout">
                <a onclick="loginStatus()"><svg t="1721957044713" class="icon" viewBox="0 0 1024 1024" version="1.1"
                                                xmlns="http://www.w3.org/2000/svg" p-id="1487" width="30" height="30">
                        <path
                                d="M749.098667 157.226667A426.24 426.24 0 0 1 938.666667 512c0 235.648-191.018667 426.666667-426.666667 426.666667S85.333333 747.648 85.333333 512a426.24 426.24 0 0 1 189.226667-354.56 42.666667 42.666667 0 1 1 47.530667 70.869333 341.333333 341.333333 0 1 0 379.52-0.213333 42.666667 42.666667 0 0 1 47.488-70.869333zM512 64a42.666667 42.666667 0 0 1 42.666667 42.666667v298.666666a42.666667 42.666667 0 0 1-85.333334 0v-298.666666a42.666667 42.666667 0 0 1 42.666667-42.666667z"
                                fill="#ffffff" p-id="1488"></path>
                    </svg></a>
            </div>
        </div>
            <div class="main-center">
                <div class="left">
                    <div class="left-top" style="height: 200px;">
                        <div class="little-title">
                            <p>Input info</p>
                        </div>
                        <div class="content">
                            <div class="date-picker">
                                <form id="uploadForm" enctype="multipart/form-data">
                                    <label for="dataType">Choose data type:</label>
                                    <select id="dataType" class="data-type-select">
                                        <option value="strain">strain</option>
                                        <option value="vibration">vibration</option>
                                        <option value="light">light variation</option>
                                        <option value="rotate">rotate rate</option>
                                        <option value="noise">noise</option>
                                    </select>
                                    <input type="file" id="dataFile" name="dataFile" accept=".csv" required>
                                    <button type="submit" class="date-picker-button">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="left-bottom">
                        <div class="little-title">
                            <p>Preview of <br>
                                analysis results</p>
                        </div>
                        <div class="showlist">
                            <p>1. Mechanical Wear </p>
                            <p>2. Resonance Fault </p>
                            <p>3. Light Variation Issue </p>
                            <p>4. Imbalance </p>
                            <p>5. Bearing Fault </p>
                        </div>
                    </div>
                </div>
                <div class="right">
                    <div class="little-title" id="alarmTitle">
                        <p>Failure display</p>
                    </div>
                    <div class="tableList" id="result">

                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="js/common.js"></script>
<script src="js/analysis.js"></script>
