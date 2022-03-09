// function fetchLogs() {
//     // Clear table and category
//     const body = document.getElementById('table-body');
//     const categoryContainer = document.getElementById('category-container');
//     body.innerHTML = '';
//     categoryContainer.innerHTML = '';

//     // Success alert
//     const alert = document.getElementById('success-alert');

//     fetch(`/fetch-income-logs/${userID.value}`, {
//         method: 'GET',
//         header: {
//             'Content-Type': 'application/json;charset=utf-8',
//         },
//     })
//     .then(response => response.json())
//     .then(logs => {
//         // Create div (for categories)
//         for(let j = 0; j < logs[1].length; j++) {
//             const div = document.createElement('div');
//             div.innerHTML = `
//                 <div class="border border-success text-center text-success p-2 rounded-pill mx-2 my-1" style="width:18rem;">
//                     ${logs[1][j].category}
//                 </div>
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
//                 <td>
//                     <button 
//                         type="button"
//                         class="btn btn-danger " 
//                         data-bs-toggle="modal" 
//                         data-bs-target="#deleteModal"
//                         data-id="${logs[0][i].id}">
//                         &times;
//                     </button>
//                 </td>
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
//                     .then(message => {
//                         fetchLogs();
//                         // updateIncomePie();
//                         fetchIncomePie(message.toUpdate);

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

// function updateIncomePie() {
//     let labels = [];
//     let amount = [];
//     let backgroundColors = [];
//     let userID = document.getElementById('userID');

//     fetch(`/fetch-income-pie/${userID.value}`, {
//         method: 'GET',
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
//             'Content-Type': 'application/json;charset=utf-8',
//         },
//     })
//     .then(response => response.json())
//     .then(categories => {
//         const myChart = document.getElementById('incomeChart');

//         console.log(myChart);

//         // for(let i = 0; i < categories.length; i++) {
//         //     labels.push(categories[i].category);
//         //     amount.push(categories[i].amount);
//         //     // backgroundColors.push(`rgb(${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)}, ${Math.floor(Math.random() * 256)})`)
//         // }

//         // const data = {
//         //     labels: labels,
//         //     datasets: [{
//         //         backgroundColor: backgroundColors,
//         //         data: amount,
//         //     }]
//         // };

//         // myChart.data.datasets[0].data = amount;
//         // myChart.data.labels = labels;

//         // myChart.update();
//     });
// }

// fetchLogs();