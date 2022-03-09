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
    .then(categories => {
        for(let i = 0; i < categories.length; i++) {
            labels.push(categories[i].category);
            amount.push(categories[i].amount);
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

        let myChart = new Chart(
            document.getElementById('incomeChart'),
            config
        );
    });
}

fetchIncomePie();



