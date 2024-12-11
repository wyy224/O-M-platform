<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/reset.css">
    <link rel="stylesheet" href="css/common.css">
    <link rel="stylesheet" href="css/other.css">
    <script src="js/echarts.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/element-ui/lib/theme-chalk/index.css">
    <script src="https://unpkg.com/element-ui/lib/index.js"></script>
    <style>

    </style>
</head>

<body>
    <div class="wrapper">
        <div class="top"></div>
        <div class="main">
        <div class="main-top">
            <ul>
                <li id="overview">Overview</li>
                <li class="active" id="selectAndEdit">Data</li>
                <li id="analysis">Analysis</li>
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
                    <div class="little-title actived">
                        <p>Real-time strain information</p>
                    </div>
                    <div class="little-title">
                        <p>Real-time vibration information</p>
                    </div>
                    <div class="little-title">
                        <p>Real-time noise information</p>
                    </div>
                    <div class="little-title">
                        <p>Real-time Rotate rate information</p>
                    </div>
                    <div class="little-title">
                        <p>Real-time Light vibration information</p>
                    </div>
                    <form id="searchForm" class="center-top">
                        <div class="date-picker">
                            <label for="tongdao">Type:</label>
                            <select id="tongdao" name="tongdao" class="date-input">
                                <option value="0">strain</option>
                                <option value="1">vibration</option>
                                <option value="2">noise</option>
                                <option value="3">Rotate rate</option>
                                <option value="4">Light vibration</option>
                            </select>
                        </div>
                        <div class="date-picker">
                            <label for="tongdaoList">Channel:</label>
                            <div class="custom-select" tabindex="0">
                                <!-- <input type="text" id="selectedOptions" name="selectedOptions" multiple> -->
                                <div class="selected" id="tongdaoList" onclick="openList(this)"></div>
                                <div class="options" style="display: none;" id="optionsList">
                                    <!-- 动态插入通道list -->
                                </div>
                            </div>
                            <input type="hidden" id="selectedOptions" name="selectedOptions" multiple>
                        </div>
                        <div class="select-button" id="selectBTN">Search</div>
                    </form>
                    <div class="content" id="type_id">
                        <ul id="tongdaoAllList"></ul>

                    </div>
                </div>
                <div class="right">
                    <div class="little-title">
                        <p>History Data query</p>
                    </div>
                    <div class="date-picker">
                        <label for="date">Choose Date:</label>
                        <input type="date" id="date" name="date" class="date-input" placeholder="YYYY-MM-DD">
                        <label for="dataType">Choose data type:</label>
                        <select id="dataType" class="data-type-select">
                            <option value="strain">strain</option>
                            <option value="vibration">vibration</option>
                            <option value="light">light variation</option>
                            <option value="rotate">Rotate rate</option>
                            <option value="noise">noise</option>
                        </select>
                        <div class="date-picker-button" onclick="fetchAndDisplayData()">Submit</div>
                    </div>
                    <div class="queryChart">
                        <!-- 表格 -->
                        <h3 id="type" style="color: white;right: 50px;top: 200px" ></h3>
                        <div id="All"></div>
                        <div id="pagination">
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</body>
<script src="js/common.js"></script>
<script src="js/other.js"></script>
