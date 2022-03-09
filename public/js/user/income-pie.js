function fetchIncomePie() {
    let labels = [];
    let amount = [];
    let backgroundColors = [];
    let userID = document.getElementById('userID');

    fetch(`/fetch-income-pie/${userID.value}`, {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Content-Type': 'application/json;charset=utf-8',
        },
    })
    .then(response => response.json())
    .then(finance => {
        for (const [key, value] of Object.entries(finance)) {
            labels.push(key);
            amount.push(value);
            backgroundColors.push(`rgb(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)})`)
        }
        
        const data = {
            labels: labels,
            datasets: [{
                backgroundColor: backgroundColors,
                data: amount,
            }]
        };
        
        const config = {
            type: 'pie',
            data: data,
            options: {}
        };

        const myChart = new Chart(
            document.getElementById('incomeChart'),
            config
        );

        
        
        // function fetchLogs() {
        //     // Clear table and category
        //     const body = document.getElementById('table-body');
        //     const categoryContainer = document.getElementById('category-container');
        //     // body.innerHTML = '';
        //     // categoryContainer.innerHTML = '';
        
        //     // Success alert
        //     const alert = document.getElementById('success-alert');
        //     console.log('fetch logs called');
        //     fetch(`/fetch-income-logs/${userID.value}`, {
        //         method: 'GET',
        //         header: {
        //             'Content-Type': 'application/json;charset=utf-8',
        //         },
        //     })
        //     .then(response => response.json())
        //     .then(logs => {
        //         console.log('fetch logs api');
        //         // Clear table and category
        //         body.innerHTML = '';
        //         categoryContainer.innerHTML = '';

        //         // Create div (for categories)
        //         for(let j = 0; j < logs[1].length; j++) {
        //             const div = document.createElement('div');
        //             div.innerHTML = `
                        // <div class="border border-success text-center text-success p-2 rounded-pill mx-2 my-1" style="width:18rem;">
                        //     ${logs[1][j].category}
                        // </div>
        //             `;
        //             categoryContainer.appendChild(div);
        //         }
        
        //         // Create Row (for logs)
        //         for(let i = 0; i < logs[0].length; i++) {
        //             // Format timestamp to readable format
        //             let created_at = new Date(logs[0][i].created_at).toLocaleString();
                    
        //             const tr =  document.createElement('tr');
        //             tr.innerHTML = `
        //                 <td class="fw-bold">${logs[0][i].category}</td>
        //                 <td class="text-muted">${logs[0][i].description}</td>
        //                 <td class="text-body">${created_at}</td>
        //                 <td class="${logs[0][i].type === 'income' ? 'text-success' : 'text-danger' }">P${logs[0][i].amount}</td>
                        // <td>
                        //     <button 
                        //         type="button"
                        //         class="btn btn-danger" 
                        //         data-bs-toggle="modal" 
                        //         data-bs-target="#deleteModal"
                        //         data-id="${logs[0][i].id}">
                        //         &times;
                        //     </button>
                        // </td>
        //             `;
        //             body.appendChild(tr);
        
        //             // Delete Button
        //             const deleteBtn = tr.querySelector('.btn');
        //             deleteBtn.addEventListener('click', (e) => {
        //                 const submitBtn = document.getElementById('delete-btn');
        //                 const financeID = deleteBtn.dataset.id
        
        //                 // Submit delete form
        //                 submitBtn.addEventListener('click', (e) => {
        //                     e.preventDefault();
        
        //                     fetch(`/delete-finance/${financeID}`, {
        //                         method: 'POST',
        //                         headers: {
        //                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        //                             'Content-Type': 'application/json;charset=utf-8',
        //                         },
        //                         body: JSON.stringify({}),
        //                     })
        //                     .then(response => response.json())
        //                     .then(data => {
        //                         console.log('updated logs');
        //                         if(firstInstantiation) {
        //                             fetchLogs();
        //                             firstInstantiation = false;
        //                         }

        //                         // Update Pie chart
        //                         let labels = [];
        //                         let amount = [];

        //                         for(let i = 0; i < data.length; i++) {
        //                             labels.push(data[i].category);
        //                             amount.push(data[i].amount);
        //                         }

        //                         myChart.data.datasets[0].data = amount;
        //                         myChart.data.labels = labels;

        //                         myChart.update();
        
        //                         // Close delete modal
        //                         document.getElementById('closeModalBtn').click();
        
        //                         // Show success alert for 2 seconds
        //                         alert.classList.add('d-block');
        //                         alert.classList.remove('d-none');
        //                         setTimeout(() => {
        //                             alert.classList.remove('d-block');
        //                             alert.classList.add('d-none');
        //                         }, 2000);
        
        //                     });
        //                 });
        //             });
        //         }
        //     });
        // }

    });
}

function updateChart() {
    // Update Pie chart
    let labels = [];
    let amount = [];

    for(let i = 0; i < data.length; i++) {
        labels.push(data[i].category);
        amount.push(data[i].amount);
    }

    myChart.data.datasets[0].data = amount;
    myChart.data.labels = labels;

    myChart.update();
}

// function fetchLogs() {
//     // Clear table body
//     const body = document.getElementById('table-body');
//     body.innerHTML = '';

//     fetch(`/fetch-logs/${userID.value}`, {
//         method: 'GET',
//         header: {
//             'Content-Type': 'application/json;charset=utf-8',
//         },
//     })
//     .then(response => response.json())
//     .then(logs => {
//         for(let i = 0; i < logs.length; i++) {
//             // Format timestamp to readable format
//             let created_at = new Date(logs[i].created_at).toLocaleString();

//             const tr =  document.createElement('tr');
//             tr.innerHTML = `
//                 <td class="fw-bold">${logs[i].category}</td>
//                 <td class="text-muted">${logs[i].description}</td>
//                 <td class="text-body">${created_at}</td>
//                 <td class="${logs[i].type === 'income' ? 'text-success' : 'text-danger' }">₱${logs[i].amount}</td>
//             `;

//             body.appendChild(tr);
//         }
//     });
// }

fetchIncomePie();



