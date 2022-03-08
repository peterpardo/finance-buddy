const type = document.getElementById('type');
const category = document.getElementById('category');
const amount = document.getElementById('amount');
const description = document.getElementById('description');
const submitBtn = document.getElementById('submitBtn');
const successAlert = document.getElementById('success-alert');

// Form
submitBtn.addEventListener('click', () => {
    if(validateInputs()) {
        let data = {
            typeValue: type.value, 
            categoryValue: category.value, 
            amountValue: amount.value, 
            descriptionValue: description.value, 
        };

        fetch('/add-finance', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json;charset=utf-8',
            },
            body: JSON.stringify(data),
        })
        .then(response => response.json())
        .then(messages => {
            // Clear input fields
            type.value = '';
            category.value = '';
            amount.value = '';
            description.value = '';
            
            // Display success alert
            successAlert.classList.add('d-block');
            successAlert.classList.remove('d-none');
        });
    } else {
       console.log('Somehting is wrong');
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