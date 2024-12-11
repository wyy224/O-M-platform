<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/setting.css">
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
                <li id="analysis">Analysis</li>
                <li id="alarm">Alarm</li>
                <li class="active" id="setting">Setting</li>
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
                <!-- <div class="center-top"> -->
                <div class="little-title">
                    <p>Alarm Management</p>
                    <div class="btn-group">
                        <button class="btn btn-primary select-button" id="deleteBtn">Delete</button>
                        <button class="btn btn-primary select-button" id="addBtn">Create</button>
                    </div>
                </div>
                <div class="tableList">
                    <table id="myTable" width="100%" border="0" cellspacing="1" cellpadding="4"
                        class="tabtop13 hiddenInp" align="center">
                        <thead>
                            <tr>
                                <th class="btbg font-center titfont" rowspan="2">Select</th>
                                <th class="btbg font-center titfont" rowspan="2">Modify</th>
                                <th class="btbg font-center titfont" rowspan="2">Time</th>
                                <th class="btbg font-center titfont" rowspan="2">Wind Field</th>
                                <th class="btbg font-center titfont" rowspan="2">Wind Turbine</th>
                                <th class="btbg font-center titfont" rowspan="2">Channel</th>
                                <th class="btbg font-center titfont" rowspan="2">Fault Type</th>
                                <th class="btbg font-center titfont" rowspan="2">State</th>
                                <th class="btbg font-center titfont" rowspan="2">Type</th>
                            </tr>
                        </thead>

                        <tbody class="font-center">
                        </tbody>
                    </table>
                </div>
            </div>
<!--create table-->
        <div id="addFormModal" class="modal">
            <div class="modal-content">
                <span class="close-btn" id="closeModalBtn">&times;</span>
                <h2 style="color: white">Add Data</h2>
                <form id="addForm">
                    <div class="form-group">
                        <label for="WF">Wind Field num:</label>
                        <input type="number" id="WF" name="WF" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="WT">Wind Turbine num:</label>
                        <input type="number" id="WT" name="WT" required class="form-control">

                        <label for="date">Date:</label>
                        <input type="date" id="date" name="date" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="channel">Channel:</label>
                        <input type="number" id="channel" name="channel" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="value">Value:</label>
                        <input type="text" id="value" name="value" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="type">Type:</label>
                        <select id="dataType">
                            <option value="strain">strain</option>
                            <option value="vibration">vibration</option>
                            <option value="light">light variation</option>
                            <option value="rotate">rotate rate</option>
                            <option value="noise">noise</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="fault">Fault Type:</label>
                        <select id="fault">
                            <option value="Mechanical Wear">Mechanical Wear</option>
                            <option value="Resonance Fault">Resonance Fault</option>
                            <option value="Light Variation Issue">Light Variation Issue</option>
                            <option value="Imbalance">Imbalance</option>
                            <option value="Bearing Fault">Bearing Fault</option>
                            <option value="Unknown Fault">Unknown Fault</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="state3">State:</label>
                        <input type="number" id="state3" name="state3" required class="form-control">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn submit-btn" id="sub">Submit</button>
                        <button type="button" class="btn cancel-btn" id="cancel">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
            <!-- modify -->
            <div class="dialog" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="title">Modify Alarm</div>
                        <!-- <div> -->
                            <img src="./img/close.png" alt="" srcset="" height="100%" id="closeBtn2">
                        <!-- </div> -->
                    </div>
                    <div class="modal-body">
                        <form id="addForm">
                            <div class="form-group">
                                <label for="type">Type：</label>
                                <select id="type" class="date-input" name="type">
                                    <option value="strain">Strain</option>
                                    <option value="vibration">Vibration</option>
                                    <option value="noise">Noise</option>
                                    <option value="rotate">Rotate rate</option>
                                    <option value="light">Light vibration</option>
                                </select>
                            </div>
                            <div class="line"></div>
                            <div class="form-group">
                                <label for="state2">State：</label>
                                <select id="state2" class="date-input" name="state2">
                                    <option value="0">unsolved</option>
                                    <option value="1">has processed</option>
                                </select>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary dialogBtn" id="cancelBtn2">Cancel</button>
                        <button class="btn btn-primary dialogBtn" id="sureBtn2">Confirm</button>
                    </div>
                    </form>

                </div>
            </div>
</body>
<script src="js/common.js"></script>
<script src="js/setting.js"></script>

</html>