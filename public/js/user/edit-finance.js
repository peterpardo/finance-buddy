const editBtns = document.querySelectorAll('.editBtns');
const type = document.getElementById('type');
const category = document.getElementById('category');
const amount = document.getElementById('amount');
const description = document.getElementById('description');
const editForm = document.getElementById('edit-finance-form');
const submitBtn = document.getElementById('submitBtn');
let id = ''; 

// Get values of the edited record
editBtns.forEach((editBtn) => {
    editBtn.addEventListener('click', (e) => {
        e.preventDefault();
        // console.log(e.target.dataset.financeId);
        type.value = e.target.dataset.type;
        category.value = e.target.dataset.category;
        amount.value = e.target.dataset.amount;
        description.value = e.target.dataset.description;
        id = e.target.dataset.financeId;
    });
})


// Submit Edit Finance Form
submitBtn.addEventListener('click', (e) => {
    e.preventDefault();
    if(validateInputs()) {
        // Update action attribute of form
        editForm.setAttribute('action', `/edit-finance/${id}`)
        editForm.submit();
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