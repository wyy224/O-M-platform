document.addEventListener('DOMContentLoaded', function () {
    const myTable = document.getElementById('myTable');
    var returnData = [];
    function getFengjiList() {
        fetch('server/setting.php', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json'
            },
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
                        // 移除开头和结尾的大括号
                        str = str.slice(1, -1);
                        // 使用逗号分割字符串为数组
                        const parts = str.split(',');
                        // 创建一个空对象
                        const obj = {};
                        // 遍历每个部分，并添加到对象中
                        parts.forEach(part => {
                            // 使用冒号分割键和值
                            const [key, value] = part.trim().split(':');
                            // 将值转换为适当的类型（这里假设数字是整数）
                            obj[key.trim()] = isNaN(Number(value.trim())) ? value.trim() : Number(value.trim());
                        });
                        return obj;
                    });
                    // 初始时调用一次，以立即显示数据
                    returnData = [];
                    returnData.push(...objectArray);
                    createTable(returnData);
                }
            })
            .catch(error => {
                document.getElementById("myTable").classList.add('hiddenInp');
                clearTable([]);
                console.error('登录出错:', error);
            });

    }
    getFengjiList();



    function clearTable() {
        var table = myTable.getElementsByTagName('tbody')[0];
        // 清除所有行（除了表头）
        while (table.rows.length > 0) {
            table.deleteRow(0);
        }
    }
    // 创建表格,动态添加数据
    function createTable(data) {
        var table = myTable.getElementsByTagName('tbody')[0];
        // 清除所有行（除了表头）
        while (table.rows.length > 0) {
            table.deleteRow(0);
        }

        for (var i = 0; i < data.length; i++) {
            var newRow = table.insertRow();
            newRow.classList.add('row');
            var cell1 = newRow.insertCell(0);
            var cell2 = newRow.insertCell(1);
            cell1.innerHTML = `<input type="checkbox" class="check" value="${i}">`;
            cell2.innerHTML = `<button class="modifyBtn" value="${i}">Modify</button>`;
            cell2.classList.add('modifyBtn');
            var cell3 = newRow.insertCell(2);
            var cell4 = newRow.insertCell(3);
            var cell5 = newRow.insertCell(4);
            var cell6 = newRow.insertCell(5);
            var cell7 = newRow.insertCell(6);
            var cell8 = newRow.insertCell(7);
            var cell9 = newRow.insertCell(8);
            var cell10 = newRow.insertCell(9);
            cell3.textContent = data[i].date.split(" ")[0];
            cell4.textContent = data[i].WF;
            cell5.textContent = data[i].WT;
            cell6.textContent = data[i].channel;
            cell7.textContent = data[i].fault_type;
            cell8.textContent = data[i].state;
            cell9.textContent = data[i].type;
            cell10.textContent = data[i].value;
            cell10.style.display = "none";
            const modifiyBtn = cell2.getElementsByTagName('button')[0];
            modifiyBtn.addEventListener('click', function () {
                let index = Number(modifiyBtn.value);
                modifyData(data[index]);

            });
        }

    }


    // 新建
    const addBtn = document.getElementById('addBtn');
    addBtn.addEventListener('click', function () {
        const myModal = document.getElementById('addFormModal');
        const sureBtn = document.getElementById('sub');
        const cancelBtn = document.getElementById('cancel');
        const closeBtn = document.getElementById('closeBtn');
        myModal.style.display = 'block';

        // 确定新建
        sureBtn.addEventListener('click', function () {
            // fengji、ybULV、ybLLV、zdULV、zdLLV、zsULV、zsLLV、zhuansuULV、zhuansuLLV、wenduULV、wenduLLV
            var WF = document.getElementById('WF').value;
            var WT = document.getElementById('WT').value;
            var date = document.getElementById('date').value;
            var channel = document.getElementById('channel').value;
            var value = document.getElementById('value').value;
            var type = document.getElementById('dataType').value;
            var Fault = document.getElementById('fault').value;
            var state = document.getElementById('state3').value;
            if (WF == '' || WT == '' || date == '' || channel == '' || value == '' || type == '' || Fault == '' || state == '') {
                alert('Please enter all parameters!')
                return;
            }
            alert(type);
            fetch('./server/addSetting.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `WF=${(WF)}&WT=${(WT)}&date=${(date)}&channel=${(channel)}&value=${(value)}&type=${(type)}&fault=${(Fault)}&state=${(state)}`
            })
                .then(response => response.text())
                .then(message => {
                    if (message == '添加成功') {
                        myModal.style.display = 'none';
                        alert(message);
                        // 刷新页面
                        location.reload();
                    } else {
                        alert(message);
                    }
                })
                .catch(error => {
                    console.error('登录出错:', error);
                });

        });
        // 关闭新建
        cancelBtn.addEventListener('click', function () {
            myModal.style.display = 'none';
        });
        closeBtn.addEventListener('click', function () {
            myModal.style.display = 'none';
        });
    });


    // 批量删除
    const deleteBtn = document.getElementById('deleteBtn');
    deleteBtn.addEventListener('click', function () {
        const checkboxes = document.querySelectorAll('.check:checked');
        const alarmList = Array.from(checkboxes).map(checkbox => {
            const row = checkbox.closest('tr');
            alert(row.cells[9].textContent)
            return {
                date: row.cells[2].textContent,
                channel: row.cells[5].textContent,
                value: row.cells[9].textContent,
                fault_type: row.cells[6].textContent,
                data_type: row.cells[8].textContent,
                state: row.cells[7].textContent,
                WT: row.cells[4].textContent,
                WF: row.cells[3].textContent
            };

        });

        if (alarmList.length == 0) {
            alert('Please select the alarm you want to delete');
            return;
        }
        console.log(alarmList);
        fetch('./server/deleteSetting.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                selected: alarmList
            })
        })
            .then(response => response.text())
            .then(message => {
                if (message == 'success') {
                    alert("Delete successfully!");
                    // 刷新页面
                    location.reload();
                } else if(message =='failed') {
                    alert("Delete failed");
                }
                else{
                    alert(message);
                }
            })
            .catch(error => {
                console.error('删除出错:', error);
            });
    });
});

function modifyData(data) {
    // 数据回显
    const selected = [
        {
            value: data.value,
            date: data.date,
            type: data.type,
            windField: data.WF,
            windTurbine: data.WT,
            channel: data.channel,
            fault_type: data.fault_type,
            state: data.state
        }
    ];
    const type = document.getElementById('type');
    const state = document.getElementById('state2');
    const myModal2 = document.getElementById('myModal2');
    myModal2.style.display = 'block';
    const sureBtn2 = document.getElementById('sureBtn2');
    const cancelBtn2 = document.getElementById('cancelBtn2');
    const closeBtn2 = document.getElementById('closeBtn2');
    // 确定修改
    sureBtn2.addEventListener('click', function () {
        var chType = type.value;
        var chState = state.value;
        console.log(chType)
        console.log(chState);

        fetch('./server/modifySetting.php', {
            method: 'POST',
            headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
            body: JSON.stringify({
                chType,
                chState,
                selectedRows: selected
            })
        })
            .then(response => response.text())
            .then(message => {
                if (message == 'Modify successfully') {
                    alert("Modify successfully!");
                    // 刷新页面
                    location.reload();
                } else {
                    alert(message);
                }
            })
            .catch(error => {
                console.error('Modify error:', error);
            });
        myModal2.style.display = 'none';
    });
    // 关闭修改
    cancelBtn2.addEventListener('click', function () {
        myModal2.style.display = 'none';
    })
    closeBtn2.addEventListener('click', function () {
        myModal2.style.display = 'none';
    })

}
