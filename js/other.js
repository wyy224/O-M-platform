function getQueryParam(param) {
    var searchParams = new URLSearchParams(window.location.search);
    return searchParams.get(param);
}
const idList = ['strain', 'vibration', 'noise', 'rotate', 'light'];
var typeList = [4, 4, 1, 1, 4];
var id = getQueryParam('id') || 0;

function getRandomInRange(min, max) {
    // Make sure min and max are in the correct order
    if (min > max) {
        [min, max] = [max, min];
    }
    // A random number between 0 and 1 is generated and then scaled to the range min to max
    return min + (max - min) * Math.random();
}

// // Use this function to generate a random number of -0.0009 to 0.0009
// let randomNumber = getRandomInRange(-0.0009, 0.0009);
function options(id, currentPage, start, end, arr) {
    if (arr == undefined) {
        for (let i = start; i <= end; i++) {

            let Chart = echarts.init(document.getElementById(idList[id] + i));
            function randomData() {
                now = new Date(+now + oneDay);
                value = getRandomInRange(-0.0009, 0.0009);
                return {
                    name: now.toString(),
                    value: [
                        [now.getFullYear(), now.getMonth() + 1, now.getDate()].join('/'),
                        value.toFixed(4)
                    ]
                };
            }
            let data = [];
            let now = new Date(1997, 9, 3);
            let oneDay = 24 * 3600 * 1000;
            let value = 0;
            if(id == 1) {
                for (let i = 0; i < 3000; i++) {
                    data.push(randomData());
                }
            }else  {
                for (let i = 0; i < 400; i++) {
                    data.push(randomData());
                }
            }

            option = {
                grid: {
                    top: 10,
                    left: 50,
                    right: 20,
                    bottom: 30
                },
                tooltip: {
                    trigger: 'axis',
                    formatter: function (params) {
                        params = params[0];
                        var date = new Date(params.name);
                        return (
                            date.getDate() +
                            '/' +
                            (date.getMonth() + 1) +
                            '/' +
                            date.getFullYear() +
                            ' : ' +
                            params.value[1]
                        );
                    },
                    axisPointer: {
                        animation: false
                    }
                },
                xAxis: {
                    type: 'time',
                    splitLine: {
                        show: false
                    },
                    splitlabel: {
                        show: false
                    }
                },
                yAxis: {
                    type: 'value',
                    boundaryGap: [0, '100%'],
                    min: -0.002,
                    max: 0.002,
                    splitLine: {
                        show: false
                    },
                },
                series: [
                    {
                        name: 'Fake Data',
                        type: 'line',
                        showSymbol: false,
                        data: data
                    }
                ]
            };
            Chart.setOption(option);
            if(id == 1) {
                setInterval(function () {
                    for (let i = 0; i < 1000; i++) {
                        data.push(randomData());
                        data.shift();
                    }
                    Chart.setOption({
                        series: [
                            {
                                data: data
                            }
                        ]
                    });
                }, 100);
            }else {
                setInterval(function () {
                    for (let i = 0; i < 80; i++) {
                        data.push(randomData());
                        data.shift();
                    }
                    Chart.setOption({
                        series: [
                            {
                                data: data
                            }
                        ]
                    });
                }, 1000);
            }

            window.onresize = function () {
                Chart.resize();
            };
        }
    } else {
        // for (let i = start; i <= end; i++) {
        arr.map((i) => {
            let Chart = echarts.init(document.getElementById(idList[id] + i));
            function randomData(i) {
                now = new Date(+now + oneDay);
                value = getRandomInRange(-0.0009, 0.0009);
                return {
                    name: now.toString(),
                    value: [
                        [now.getFullYear(), now.getMonth() + 1, now.getDate()].join('/'),
                        // Math.round(value)
                        value.toFixed(4)
                    ]
                };
            }
            let data = [];
            let now = new Date(1997, 9, 3);
            let oneDay = 24 * 3600 * 1000;
            let value = 0;
            // getRandomInRange(-0.0009, 0.0009)
            for (let i = 0; i < 400; i++) {
                data.push(randomData());
            }
            option = {
                tooltip: {
                    trigger: 'axis',
                    formatter: function (params) {
                        params = params[0];
                        var date = new Date(params.name);
                        return (
                            date.getDate() +
                            '/' +
                            (date.getMonth() + 1) +
                            '/' +
                            date.getFullYear() +
                            ' : ' +
                            params.value[1]
                        );
                    },
                    axisPointer: {
                        animation: false
                    }
                },
                xAxis: {
                    type: 'time',
                    splitLine: {
                        show: false
                    }
                },
                yAxis: {
                    type: 'value',
                    boundaryGap: [0, '100%'],
                    min: -0.001,
                    max: 0.001,
                    splitLine: {
                        show: false
                    }
                },
                series: [
                    {
                        name: 'Fake Data',
                        type: 'line',
                        showSymbol: false,
                        data: data
                    }
                ]
            };
            Chart.setOption(option);
            setInterval(function () {

                for (let i = 0; i < 80; i++) {

                    data.push(randomData(i));
                    data.shift();
                }
                Chart.setOption({
                    series: [
                        {
                            data: data
                        }
                    ]
                });
            }, 2000);
            window.onresize = function () {
                Chart.resize();
            };
        })
    }
}

function optionsTitle(id) {
    var title = document.querySelectorAll('.main-center .left .little-title');
    title.forEach((item, index) => {
        item.classList.remove('actived');
    })
    title[id].classList.add('actived');
}

function insertChart(id, currentPage, start, end, arr) {
    var type_id = document.getElementById('type_id');
    for (let i = 0; i < idList.length; i++) {
        type_id.classList.remove(idList[i]);
    }
    type_id.classList.add(idList[id]);
    var tongdaoAllList = document.getElementById('tongdaoAllList');
    tongdaoAllList.innerHTML = '';
    var typeListName = ["Strain channel", "Vibration channel", "Noise channel", "Rotate channel", "Light vibration channel"];
    //default show strain channel
    if (arr == undefined) {
        for (let i = start; i <= end; i++) {
            const li = document.createElement('li');
            const div1 = li.appendChild(document.createElement('div'));
            const div2 = div1.appendChild(document.createElement('div'));
            div1.innerHTML = typeListName[id] + i + '：';
            div1.classList.add('left-title');
            li.appendChild(div1);
            div2.classList.add('right-pic');
            div2.id = idList[id] + i;
            li.appendChild(div2);
            tongdaoAllList.appendChild(li);
        }
    } else {
        arr.map((item) => {
            const li = document.createElement('li');
            const div1 = li.appendChild(document.createElement('div'));
            const div2 = div1.appendChild(document.createElement('div'));
            div1.innerHTML = typeListName[id] + item + '：';
            div1.classList.add('left-title');
            li.appendChild(div1);
            div2.classList.add('right-pic');
            div2.id = idList[id] + item;
            li.appendChild(div2);
            tongdaoAllList.appendChild(li);
        })
    }

}
function initInsertChart(id, currentPage, start, end, arr) {
    insertChart(id, currentPage, start, end, arr);
    setTimeout(() => {
        options(id, currentPage, start, end, arr);
    }, 0);

}
initInsertChart(id, 1, 1, typeList[id]);


document.getElementById('tongdao').value = id;
optionsTitle(id);
document.getElementById('tongdao').addEventListener('change', function () {
    optionsTitle(this.value);
    initInsertChart(this.value, 1, 1, typeList[this.value])
    initSelect(this.value);

});


function openList(element) {
    var id = document.getElementById('tongdao').value || 0;
    var options = element.nextElementSibling;
    options.style.display = "block";
}



document.addEventListener('click', function (e) {
    var isClickInside = e.target.closest('.custom-select') !== null;
    if (!isClickInside) {
        var options = document.querySelectorAll('.options');
        options.forEach(function (option) {
            option.style.display = "none";
        });
    }
});
function initSelect(id) {
    var input = document.getElementById('selectedOptions');
    var arr = [];
    const optionsList = document.getElementById('optionsList');
    optionsList.innerHTML = '';
    for (let i = 0; i < typeList[id]; i++) {
        const option = document.createElement('div');
        option.classList.add('option');
        option.classList.add('selected');
        option.textContent = 'Channel' + (i + 1);
        arr.push(i);
        option.onclick = function () {
            selectOption(this, i);
        }
        optionsList.appendChild(option);
    }
    input.value = arr;
    tongdaoList.textContent = 'All';
}

var id = document.getElementById('tongdao').value || 0;
tongdaoList.textContent = 'All';
initSelect(id);



var total = 4;
const perPage = 2;
var currentPage = 1;

async function fetchAndDisplayData() {
    var table = document.getElementById('dataType').value;
    var date = document.getElementById('date').value;

    if (table === "Speed") {
        table = "rotate";
    }
    if (table === "light variation") {
        table = "light";
    }
    if (!table || !date) {
        alert("Please select the data type and the date!");
        return;
    }


    const response = await fetch('./server/query.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `table=${encodeURIComponent(table)}&date=${encodeURIComponent(date)}`
    });

    data = await response.json();
    chosenDate = date;

    const chartsContainer = document.getElementById('All');
    chartsContainer.innerHTML = '';
    var title = 'Type: ' + table + ' Date:' + date;
    var showtext = document.getElementById('type');
    showtext.innerText = title;

    if (data.length === 0) {
        alert("No corresponding data was found!");
        return;
    }

    // Get the number of channels and generate the chart dynamically
    channels = Object.keys(data[0]).filter(key => key.startsWith('channel'));
    total = channels.length;

    initPagination();
    inithisChart(currentPage, data, channels);
}

function renderPagination(totalPages) {
    const pagination = document.getElementById('pagination');
    pagination.innerHTML = ''; //

    for (let i = 1; i <= totalPages; i++) {
        const link = document.createElement('a');
        link.href = '#';
        link.textContent = i;
        link.onclick = function (e) {
            const chartsContainer = document.getElementById('All');
            chartsContainer.innerHTML = '';
            e.preventDefault();
            currentPage = this.textContent;
            renderPaginationActive(currentPage);
            inithisChart(currentPage, data, channels);
        };

        if (i === currentPage) {
            link.classList.add('active');
        }

        pagination.appendChild(link);
    }
}

function renderPaginationActive(activePage) {
    const links = document.querySelectorAll('#pagination a');
    links.forEach(link => {
        link.classList.remove('active');
        if (link.textContent === activePage) {
            link.classList.add('active');
        }
    });
}

function initPagination() {
    const totalPages = Math.ceil(total / perPage);
    renderPagination(totalPages);
}

function inithisChart(currentPage, data, channels) {
    const start = (currentPage - 1) * perPage;
    const end = Math.min(start + perPage, total);
    for (let i = start; i < end; i++) {
        const channel = channels[i];
        const chartDiv = document.createElement('div')
        chartDiv.style.width = '500px';
        chartDiv.style.height = '240px';
        chartDiv.style.padding='5px';
        chartDiv.id = `chart-${i}`;
        document.getElementById('All').appendChild(chartDiv);

        const chartData = data.map(item => ({
            date: item.date,
            value: parseFloat(item[channel])
        }));

        drawLineChart(`chart-${i}`, chartData, channel);
    }
}

function drawLineChart(containerId, initialData, channel) {
    const chart = echarts.init(document.getElementById(containerId));
    let data = [...initialData];

    function generateXAxisData(length) {
        const xData = [];
        const baseDate = new Date(chosenDate);
        for (let i = 0; i < length; i++) {
            const currentDate = new Date(baseDate);
            const hoursToAdd = Math.floor(i / 60); // Add one hour for every 60 data points
            const minutesToAdd = i % 60; // remain minute
            currentDate.setHours(currentDate.getHours() + hoursToAdd);
            currentDate.setMinutes(minutesToAdd);
            xData.push(currentDate.toISOString().slice(0, 19).replace('T', ' ')); // YYYY-MM-DD HH:MM:SS
        }
        return xData.slice(0, length);
    }
        const Xall = generateXAxisData(data.length);
        console.log(Xall);

        function updateChart(yData, xData) {
            const option = {
                grid: {
                    top: 0,
                    left: 50,
                    right: 20,
                    bottom: 30
                },
                title: {
                    text: `Channel ${channel} Data`,
                    textStyle: {
                        fontSize: 10,
                        color: "white"
                    },
                    top: 10,
                    right: 10
                },
                tooltip: {
                    trigger: 'axis',
                    textStyle: {
                        fontSize: 10
                    }
                },
                xAxis: {
                    type: 'category',
                    data: xData,
                    axisLabel: {
                        rotate: 45,
                        formatter: function (value) {
                            const date = new Date(value);
                            const hours = date.getHours().toString().padStart(2, '0');
                            const minutes = date.getMinutes().toString().padStart(2, '0');
                            return `${hours}:${minutes}`;
                        }
                    },
                    splitLine: {
                        show: false
                    },
                    axisTick: {
                        show: false
                    },
                },
                yAxis: {
                    type: 'value',
                    min: Math.min(...yData) - 0.1,
                    max: Math.max(...yData) + 0.1,
                    splitLine: {
                        show: true,
                        // lineStyle: {
                        //     type: 'dashed',
                        //     color: 'gray'
                        // }
                    }
                },
                series: [
                    {
                        name: channel,
                        type: 'line',
                        data: yData,
                    }
                ],
            };

            chart.setOption(option);
        }

        // The update method is determined by the number of Y-axis data
        if (data.length <= 20) {
            // Data less than or equal to 20, directly draw the chart

            updateChart(data.map(item => item.value), generateXAxisData(data.length));
        } else {
            // The data is greater than 20, and 20 are taken each time for drawing
            let index = 0;
            function refreshData() {
                const yDataSlice = data.slice(index, index + 20);
                if (yDataSlice.length > 0) {
                    const xData = Xall.slice(index, index + 20);
                    updateChart(yDataSlice, xData);
                    index += 20;
                    if (index >= data.length) {
                        index = 0;
                    }
                }
            }

            setInterval(refreshData, 2000);
        }

        window.addEventListener('resize', () => chart.resize());
    }



