function onPasswordChange() {
    const password = document.querySelector('input[name=password]')
    const confirm = document.querySelector('input[name=password-confirmation]')
    
    const passwordFields = document.querySelectorAll('input[type=password]')
    Array.from(passwordFields).forEach(passwordField => {
        if (confirm.value === password.value && confirm.value.length >= 10) {
            passwordField.classList.remove('is-invalid');
        } else {
            passwordField.classList.add('is-invalid');
        }
    })
}

function onFormSubmitted(event) {
    const form = document.getElementById("registration-form")

    if (!form.checkValidity()) {
        console.log(event);
        event.preventDefault()
        event.stopPropagation()
    }
    form.classList.add('was-validated')
}