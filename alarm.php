<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/alarm.css">
    <script src="./js/echarts.min.js"></script>
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
                <li class="active" id="alarm">Alarm</li>
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
                <div class="main-center-top">
                    <!-- <div class="center-top"> -->
                    <div class="little-title">
                        <p>All alarms</p>
                    </div>
                    <!-- 筛选项-->
                    <div class="optionsList">
                        <form id="searchForm1">
                            <!-- 风场 -->
                            <div class="date-picker">
                                <ul class="jiansuo">
                                    <li>Log search</li>
                                </ul>
                                <ul class="select-btn">
                                    <li id="exportTable">
                                        <div class="select-button">Export</div>
                                    </li>
                                </ul>
                            </div>
                            <div class="date-picker">
                                <select id="WF" name="WF" class="date-input" aria-placeholder="Wind Filed1">
                                    <option value="">Wind Filed</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <!-- 风场下风机 -->
                            <div class="date-picker">
                                <select id="WT" name="WT" class="date-input">
                                    <option value="">Wind Turbine</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <!-- 部件 -->
                            <div class="date-picker">
                                <select id="channel" name="channel" class="date-input">
                                    <option value="">Channel</option>
                                    <option value="1">channel1</option>
                                    <option value="2">channel2</option>
                                    <option value="3">channel3</option>
                                    <option value="4">channel4</option>
                                </select>
                            </div>
                            <div class="date-picker">
                                <select id="alarmType" name="alarmType" class="date-input">
                                    <option value="">Alarm Type</option>
                                    <option value="MechanicalWear">Mechanical Wear</option>
                                    <option value="ResonanceFault">Resonance Fault</option>
                                    <option value="LightVariationIssue ">Light Variation Issue </option>
                                    <option value="Imbalance">Imbalance</option>
                                    <option value="BearingFault">Bearing Fault</option>
                                </select>
                            </div>
                            <div class="date-picker">
                                <select id="state" name="state" class="date-input">
                                    <option value="">Fault State</option>
                                    <option value="0">untreated</option>
                                    <option value="1">resolved</option>
                                </select>
                            </div>
                            <div class="date-picker" id="date-wrapper">
                                <input type="text" id="customDate" placeholder="StartTime" disabled class="date-input"
                                    value="Starttime">
                                <input type="date" id="startDate" style="color: transparent;width: 2rem;"
                                    name="startDate" class="date-input" placeholder="Starttime">
                            </div>
                            <div class="date-picker" id="date-wrapper">
                                <input type="text" id="customDate1" placeholder="EndTime" disabled class="date-input"
                                    value="Endtime">
                                <input type="date" id="endDate" style="color: transparent;width: 2rem;" name="endDate"
                                    class="date-input" placeholder="Endtime">
                            </div>
                        </form>
                    </div>
                    <div class="tableList">
                        <!-- 表格 -->
                        <table id="myTable" width="100%" border="0" cellspacing="1" cellpadding="4"
                            class="tabtop13 hiddenInp" align="center">
                            <thead>
                                <tr>
                                    <!-- <th class="btbg font-center titfont" rowspan="2"></th> -->
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
                    <!-- </div> -->
                </div>
                <div class="center-bottom">
                    <div class="bottom-left">
                        <div class="little-title">
                            <p>Data Info</p>
                        </div>
                        <div class="datainfo">
                            <ul>
                            </ul>
                        </div>
                    </div>
                    <div class="bottom-right">
                        <div class="little-title">
                            <p>Fault Details</p>
                        </div>
                        <div class="detailInfo">
                            <ul>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
<script src="js/common.js"></script>
<script src="js/alarm.js"></script>

</html>