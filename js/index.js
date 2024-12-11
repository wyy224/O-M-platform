
document.addEventListener('DOMContentLoaded', function () {
    const content = document.querySelectorAll('.showlist .tongdao');
    type = 'strain';
    console.log(type);
    fetch('server/selectAlarm.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            type,
        })
    })
        .then(response => response.json())
        .then(data => {
            if (Array.isArray(data) && data.length > 0) {
                const name = data[0].data_type;
                populateAlarmList(data, name);
                content[0].classList.add('active');
            } else {
                console.error("Error:", data.error);
            }

        });
});

const ybBtn = document.querySelectorAll('.yb-btn');
var returnData = [];
ybBtn.forEach((item, index) => {
    item.addEventListener('click', function () {
        window.location.href = "other.php?id=" + index;
    })
})
const alarmBtn = document.getElementById('alarmTitle');
alarmBtn.addEventListener('click', function () {
    window.location.href = "alarm.php";
})
// shift channel alarm info
const btn = document.querySelectorAll('.zl-list li');
const btnContents = document.querySelectorAll('.showlist .tongdao');
btn.forEach((item, index) => {
    item.addEventListener('click', function (link) {
        btnContents.forEach(col => {
            col.classList.remove('active');
        })
        btn.forEach(col => {
            col.classList.remove('actived');
        })
        item.classList.add('actived');
        type = btnContents[index].id;
        console.log(type);
        fetch('server/selectAlarm.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                type,
            })
        })
            .then(response => response.json())
            .then(data => {
                if (Array.isArray(data)&& data.length > 0) {
                    const name = data[0].data_type;
                    populateAlarmList(data, name);
                    btnContents[index].classList.add('active');
                }
                else {
                    console.error("Error:", data.error);
                }
            })


    })
})

function populateAlarmList(data, name) {
    name1 = name+ '-li';
    console.log(name);
    const listContainer = document.querySelector('#' + name,name);
    listContainer.innerHTML = '';

    const ul = document.createElement('ul');
    data.forEach(item => {
        const li = document.createElement('li');
        if (item.data_type == "light"){
            li.textContent = `light vibration: Wind Field${item.wind_field_id} - Wind Turbine ${item.wind_turbine_id}`;
            li.style.color = item.state === 0 ? 'red' : 'white';
        }
        else {
            li.textContent = `${item.data_type}: Wind Field${item.wind_field_id} - Wind Turbine ${item.wind_turbine_id}`;
            li.style.color = item.state === 0 ? 'red' : 'white';
        }
        ul.appendChild(li);
    });
    listContainer.appendChild(ul);
}

function pieChart() {
    const myChart = echarts.init(document.getElementById('pie'));
    let count = "";
    fetch('server/countAlarm.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        },
    })
        .then(response => response.text())
        .then(message => {
             count = message.split(",");
             if (count.length >1){
                 count1 = parseInt(count[0]);
                 count2 = parseInt(count[1]);
                 normal = 50 - count1 - count2;
             }
             else {
                 count2 = 0;
                 count1 = parseInt(count);
                 normal = 50- count;
             }
             console.log(message)
            var that = this;
            if (count != "") {
                var data = [{
                    value: normal,
                    name: 'Normal'
                }, {
                    value: count2,
                    name: 'solved'
                },{
                    value: count1,
                    name: 'Alarm'
                }];
                var sum = data.reduce(function (accumulator, currentValue) {
                    return accumulator + currentValue.value;
                }, 0);
                var option = {
                    legend: {
                        orient: 'vertical',
                        left: '60%',
                        top: 'center',
                        icon: 'circle',
                        textStyle: {
                            color: '#fff',
                            fontSize: 12
                        },
                        formatter: function (name) {
                            let index = data.findIndex(col => col.name == name);
                            return name + '    ' + data[index].value;
                        }
                    },
                    series: [{
                        type: 'pie',
                        radius: ['40%', '60%'],
                        right: '30%',
                        data: data,
                        label: {
                            show: true,
                            position: 'center',
                            color: '#fff',
                            fontSize: '16',
                            // fontWeight: 'bold',
                            formatter: function (params) {
                                return sum + '\n Number \n of \n channels';
                            }

                        },
                        labelLine: {
                            show: false
                        },
                    },]
                };

                myChart.setOption(option);
            }
        })

}
pieChart();

document.getElementById('Submit').addEventListener('click', function () {
    const date = document.getElementById('date').value;

    if (!date) {
        alert("Please select a date.");
        return;
    }

    fetch('server/getalarmDate.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ date: date })
    })
        .then(response => response.json())
        .then(data => {
            displayDataInTable(data);
        })
        .catch(error => console.error("Error fetching data:", error));
});

function displayDataInTable(data) {
    const showInfo = document.getElementById('showInfo');
    showInfo.innerHTML = '';

    if (data.length === 0) {
        showInfo.innerHTML = '<p>No data found for the selected date.</p>';
        return;
    }

    const table = document.createElement('table');
    table.classList.add('showtable');

    const headerRow = `
            <tr>
                <th>Data Type</th>
                <th>Fault Type</th>
                <th>Channel</th>
                <th>Wind Field ID</th>
                <th>Wind Turbine ID</th>
            </tr>`;
    table.innerHTML = headerRow;

    data.forEach(item => {
        const row = `
                <tr>
                    <td>${item.data_type}</td>
                    <td>${item.fault_type}</td>
                    <td>${item.channel}</td>
                    <td>${item.wind_field_id}</td>
                    <td>${item.wind_turbine_id}</td>
                </tr>`;
        table.innerHTML += row;
    });

    showInfo.appendChild(table);
}