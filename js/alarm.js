document.addEventListener('DOMContentLoaded', function () {
    const myTable = document.getElementById('myTable');
    var returnData = [];
    var timer = null;
    var WF = '', WT = '', channel = '', alarmType = '', state = '', startDate = '', endDate = '';
    const customDate = document.getElementById('customDate');
    const customDate1 = document.getElementById('customDate1');

    getAlarmData(WF, WT, channel, alarmType, state, startDate, endDate);
    document.getElementById('WF').addEventListener('change', function () {
        WF = this.value;
        getAlarmData(WF, WT, channel, alarmType, state, startDate, endDate);
        clearInterval(timer);
        setTimeout(() => {
            startInterval(returnData, startIndex);
        }, 2000);

    });
    document.getElementById('WT').addEventListener('change', function () {
        WT = this.value;
        getAlarmData(WF, WT, channel, alarmType, state, startDate, endDate);
        clearInterval(timer);
        setTimeout(() => {
            startInterval(returnData, startIndex);
        }, 2000);
    });
    document.getElementById('channel').addEventListener('change', function () {
        channel = this.value;
        getAlarmData(WF, WT, channel, alarmType, state, startDate, endDate);
        clearInterval(timer);
        setTimeout(() => {
            startInterval(returnData, startIndex);
        }, 2000);
    });
    document.getElementById('alarmType').addEventListener('change', function () {
        alarmType = this.value;
        getAlarmData(WF, WT, channel, alarmType, state, startDate, endDate);
        clearInterval(timer);
        setTimeout(() => {
            startInterval(returnData, startIndex);
        }, 2000);
    });
    document.getElementById('state').addEventListener('change', function () {
        state = this.value;
        getAlarmData(WF, WT, channel, alarmType, state, startDate, endDate);
        clearInterval(timer);
        setTimeout(() => {
            startInterval(returnData, startIndex);
        }, 2000);
    });

    document.getElementById('startDate').addEventListener('change', function () {
        startDate = this.value;
        customDate.value = this.value;
        getAlarmData(WF, WT, channel, alarmType, state, startDate, endDate);
        clearInterval(timer);
        setTimeout(() => {
            startInterval(returnData, startIndex);
        }, 2000);
        clearInterval(timer);
    });
    document.getElementById('endDate').addEventListener('change', function () {
        endDate = this.value;
        customDate1.value = this.value;
        getAlarmData(WF, WT, channel, alarmType, state, startDate, endDate);
        clearInterval(timer);
        setTimeout(() => {
            startInterval(returnData, startIndex);
        }, 2000);
    });
    var startIndex = 0;
    function startInterval(returnData, startIndex) {
        clearInterval(timer);
        // The timing cycle starts only when there are more than 6 data pieces
        if (returnData.length > 6) {
            timer = setInterval(() => {
                startIndex = startIndex + 6 >= returnData.length ? 0 : startIndex + 6;
                createTable(returnData, startIndex);
            }, 2000);
        }

    }
    function getAlarmData(WF, WT, channel, alarmType, laiyuan, startDate, endDate) {
        fetch('server/getalarmdata.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ WF, WT, channel, alarmType, state, startDate, endDate })
        })
            .then(response => response.text())
            .then(message => {
                if (message == 'not match') {
                    alert(message);
                    clearTable([]);
                } else {
                    console.log(message)
                    myTable.classList.remove('hiddenInp');
                    let stringArray = message.slice(0, -1).split("&");
                    const objectArray = stringArray.map(str => {
                        str = str.slice(1, -1);
                        const parts = str.split(',');
                        const obj = {};
                        parts.forEach(part => {
                            const [key, value] = part.trim().split(':');
                            obj[key.trim()] = isNaN(Number(value.trim())) ? value.trim() : Number(value.trim());
                        });
                        return obj;
                    });
                    returnData = [];
                    returnData.push(...objectArray);
                    createTable(returnData, startIndex);
                }
            })
            .catch(error => {
                document.getElementById("myTable").classList.add('hiddenInp');
                clearTable([]);
                console.error('Login error:', error);
            });

    }
    getAlarmData(WF, WT, channel, alarmType, state, startDate, endDate);
    setTimeout(() => {
        startInterval(returnData, startIndex);
    }, 2000);
});



function clearTable() {
    var table = myTable.getElementsByTagName('tbody')[0];
    while (table.rows.length > 0) {
        table.deleteRow(0);
    }
}
function createTable(data, startIndex) {
    var table = myTable.getElementsByTagName('tbody')[0];
    while (table.rows.length > 0) {
        table.deleteRow(0);
    }
    if (startIndex > data.length) {
        startIndex = 0;
    }
    const endIndex = Math.min(startIndex + 5, data.length);

    for (var i = startIndex; i < endIndex; i++) {
        // for (var i = 0; i < data.length; i++) {
        var newRow = table.insertRow();
        newRow.classList.add('row');
        var cell1 = newRow.insertCell(0);
        var cell2 = newRow.insertCell(1);
        var cell3 = newRow.insertCell(2);
        var cell4 = newRow.insertCell(3);
        var cell5 = newRow.insertCell(4);
        var cell6 = newRow.insertCell(5);
        var cell7 = newRow.insertCell(6);
        var cell8 = newRow.insertCell(7);
        cell1.textContent = data[i].date.split(" ")[0];
        cell2.textContent = data[i].WF;
        cell3.textContent = data[i].WT;
        cell4.textContent = data[i].channel;
        cell5.textContent = data[i].fault_type;
        cell6.textContent = data[i].state;
        cell7.textContent = data[i].type;
        cell8.textContent = data[i].value;
        cell8.style.display = "none";
        newRow.ondblclick = function () {
            insertDataInfo(this);
            insertDetailInfo(this);
        };
    }
}


function insertDataInfo(data) {
    const datainfo = document.getElementsByClassName('datainfo')[0].getElementsByTagName('ul')[0];
    datainfo.innerHTML = '';
    var li1 = document.createElement('li');
    li1.textContent = "Fault Type: "+ `${data.cells[4].textContent}`;
    datainfo.appendChild(li1);
    var li2 = document.createElement('li');
    li2.textContent = "Alarm value: "+ `${data.cells[6].textContent}`;
    datainfo.appendChild(li2);
    var li3 = document.createElement('li');
    li3.textContent = "Channel: "+ `${data.cells[3].textContent}`;
    datainfo.appendChild(li3);
    var li4 = document.createElement('li');
    li4.textContent = "Wind Field: "+ `${data.cells[1].textContent}` + "; Wind Turbine: "+ `${data.cells[2].textContent}`;
    datainfo.appendChild(li4);
}

function insertDetailInfo(data) {
    const datainfo = document.getElementsByClassName('detailInfo')[0].getElementsByTagName('ul')[0];
    datainfo.innerHTML = '';
    var li1 = document.createElement('li');
    if (data.cells[5] == 0){
        li1.textContent = `Processing progress: Not processed`;
    }
    else{
        li1.textContent = `Processing progress: Already processed`;
    }
    datainfo.appendChild(li1);
    var li2= document.createElement('li');
    li2.textContent = "corresponding channel: "+ `${data.cells[6].textContent}`;
    datainfo.appendChild(li2);

}


const exportBtn = document.getElementById('exportTable');
exportBtn.addEventListener('click', function () {
    exportTableToCSV('myTable', 'table.csv');
});
function exportTableToCSV(tableID, filename) {
    var table = document.getElementById(tableID);
    var csv = '';
    for (var i = 0; i < table.rows.length; i++) {
        var row = table.rows[i];
        for (var j = 0; j < row.cells.length; j++) {
            if (j > 0) csv += ',';
            csv += '"' + row.cells[j].innerText.replace(/"/g, '""') + '"';
        }
        csv += '\n';
    }

    var csvData = new Blob([csv], { type: 'text/csv;charset=utf-8;' });

    if (navigator.msSaveBlob) { // IE 10+
        navigator.msSaveBlob(csvData, filename);
    } else {
        var link = document.createElement("a");
        if (link.download !== undefined) { // feature detection
            // Browsers that support HTML5 download attribute
            var url = URL.createObjectURL(csvData);
            link.setAttribute("href", url);
            link.setAttribute("download", filename);
            link.style.visibility = 'hidden';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }
    }
}