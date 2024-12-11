document.addEventListener('DOMContentLoaded', () => {
    const uploadForm = document.getElementById('uploadForm');
    if (uploadForm) {
        uploadForm.addEventListener('submit', (event) => {
            event.preventDefault();

            const dataType = document.getElementById('dataType').value;
            const formData = new FormData(uploadForm);
            formData.append('dataType', dataType);
            for (const [key, value] of formData.entries()) {
                console.log(`${key}:`, value);
            }
            fetch('server/algorithm.php', {
                method: 'POST',
                body: formData
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(result => {
                    console.log(result);
                    const resultContainer = document.getElementById('result');
                    if (resultContainer) {
                        resultContainer.innerHTML = '';

                        if (result.status === 'success') {
                            // 创建表格
                            let table = '<table border="1">';
                            table += '<tr class="row"><th>Date</th><th>Channel</th><th>Value</th><th>Fault Type</th><th>Data Type</th><th>Report it</th></tr>';
                            result.data.forEach(item => {
                                table += `<tr class="row">
                                        <td>${item.date}</td>
                                        <td>${item.channel}</td>
                                        <td>${item.value}</td>
                                        <td>${item.fault_type}</td>
                                        <td>${item.data_type}</td>
                                        <td><input type="checkbox" class="row-select"></td>
                                      </tr>`;
                            });
                            table += '</table>';
                            resultContainer.innerHTML = table;
                            resultContainer.innerHTML += `
                                <div class="num">
                                    <label for="windFieldId">Wind Field ID:</label>
                                    <input type="number" id="WFId" style="padding-bottom: 5px" required><br>
                                    
                                    <label for="windTurbineId">Wind Turbine ID:</label>
                                    <input type="number" id="WTId" required>
                                    
                                    <button id="submitBtn" onclick="save()">Submit</button>
                                </div>
                                `;

                        } else if (result.status === 'no_faults') {
                            alert(result.message);
                        }
                    } else {
                        console.error('Result container not found');
                    }
                })
        });
    } else {
        console.error('uploadForm not found');
    }
});

function save(){
    const selectedRows = document.querySelectorAll('.row-select:checked');
    const windFieldId = document.getElementById('WFId').value;
    const windTurbineId = document.getElementById('WTId').value;

    const selectedData = Array.from(selectedRows).map((checkbox, index) => {
        const row = checkbox.closest('tr');
        return {
            date: row.cells[0].textContent,
            channel: row.cells[1].textContent,
            value: row.cells[2].textContent,
            fault_type: row.cells[3].textContent,
            data_type: row.cells[4].textContent
        };
    });
    fetch('server/saveAlarm.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            windFieldId,
            windTurbineId,
            selectedRows: selectedData
        })
    })
        .then(response => {
            return response.text()
        })
        .then(message => {
            console.log(message)
            if (message =="success"){
                alert("Data saved successfully!")
            }
            if (message =="repeated"){
                alert("This fault has stored before!")
            }
            if (message =="Invalid input"){
                alert("Submit failed!")
            }
        })
        .catch(error => {
            console.error('Error:', error);
            console.log("error?")
        });
};