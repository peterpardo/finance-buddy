const type = document.getElementById('type');
const category = document.getElementById('category');
const amount = document.getElementById('amount');
const description = document.getElementById('description');
const submitBtn = document.getElementById('submitBtn');
const successAlert = document.getElementById('success-alert');
const userID = document.getElementById('userID');
const form = document.getElementById('add-finance-form');

// Fetch Recent logs
// fetchLogs();

// Add Finance Form
submitBtn.addEventListener('click', () => {
    // if(validateInputs()) {
    //     let data = {
    //         typeValue: type.value, 
    //         categoryValue: category.value, 
    //         amountValue: amount.value, 
    //         descriptionValue: description.value, 
    //     };

    //     fetch('/add-finance', {
    //         method: 'POST',
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
    //             'Content-Type': 'application/json;charset=utf-8',
    //         },
    //         body: JSON.stringify(data),
    //     })
    //     .then(response => response.json())
    //     .then(messages => {
    //         // Clear input fields
    //         type.value = 'income';
    //         category.value = '';
    //         amount.value = '';
    //         description.value = '';
            
    //         // Display success alert
    //         successAlert.classList.add('d-block');
    //         successAlert.classList.remove('d-none')

    //         // Fetch Updated logs
    //         fetchLogs();
    //     });
    // } else {
    //    console.log('Somehting is wrong');
    // }

    if(validateInputs()) {
        form.submit();
    }
});

// Set Error Messages
const setError = (element, message) => {
    const inputControl = element.parentElement;
    const errorDisplay = inputControl.querySelector('.invalid-feedback');

    errorDisplay.innerText = message;
    if(message !== '') {
        element.classList.add('is-invalid');
    } else {
        element.classList.remove('is-invalid');
    }
}

// Validate Inputs
const validateInputs = () => {
    const categoryValue = category.value.trim();
    const amountValue = amount.value.trim();
    const descriptionValue = description.value.trim();
    let validated = true;

    if(categoryValue === '') {
        setError(category, 'Category is required');
        validated = false;
    } else if (categoryValue.length > 30){
        setError(category, 'Category length should be less than 30');
        validated = false;
    } else {
        setError(category, '')
    }

    if(amountValue === '') {
        setError(amount, 'Amount is required');
        validated = false;
    } else if(isNaN(amountValue)) {
        setError(amount, 'Needs to be a number');
    } else {
        setError(amount, '')
    }

    if(descriptionValue === '') {
        setError(description, 'Description is required');
        validated = false;
    } else if (descriptionValue.length > 30){
        setError(category, 'Description length should be less than 30');
        validated = false;
    } else {
        setError(description, '')
    }   

    return validated;
}

function fetchLogs() {
    // Clear table body
    const body = document.getElementById('table-body');
    body.innerHTML = '';

    fetch(`/fetch-logs/${userID.value}`, {
        method: 'GET',
        header: {
            'Content-Type': 'application/json;charset=utf-8',
        },
    })
    .then(response => response.json())
    .then(logs => {
        for(let i = 0; i < logs.length; i++) {
            // Format timestamp to readable format
            let created_at = new Date(logs[i].created_at).toLocaleString();

            const tr =  document.createElement('tr');
            tr.innerHTML = `
                <td class="fw-bold">${logs[i].category}</td>
                <td class="text-muted">${logs[i].description}</td>
                <td class="text-body">${created_at}</td>
                <td class="${logs[i].type === 'income' ? 'text-success' : 'text-danger' }">₱${logs[i].amount}</td>
            `;

            body.appendChild(tr);
        }
    });
}