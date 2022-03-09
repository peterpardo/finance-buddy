
function fetchExpensePie() {
    let labels = [];
    let amount = [];
    let backgroundColors = [];
    let userID = document.getElementById('userID');

    fetch(`/fetch-expense-pie/${userID.value}`, {
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
            document.getElementById('expenseChart'),
            config
        );
    });
}

fetchExpensePie();



