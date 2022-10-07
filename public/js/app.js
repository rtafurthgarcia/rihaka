const MAX_LENGTH_BIOGRAPHY = 300;

function onPasswordChange() {
    const password = document.querySelector('input[name=password]')
    const confirm = document.querySelector('input[name=password-confirmation]')
    
    const passwordFields = document.querySelectorAll('input[type=password]')
    Array.from(passwordFields).forEach(passwordField => {
        if (confirm.value === password.value && confirm.value.length >= 10) {
            passwordField.classList.remove('is-invalid')
        } else {
            passwordField.classList.add('is-invalid')
        }
    })
}

function onFormSubmitted(event) {
    const form = document.querySelector('form.needs-validation')

    if (!form.checkValidity()) {
        console.log(event)
        event.preventDefault()
        event.stopPropagation()
    }
    form.classList.add('was-validated')
}

function onKeyDownBiography() {
    let biographyElement = document.querySelector("#biography")
    let labelElement = document.querySelector("#biography + label")

    labelElement.textContent = `Biography (${biographyElement.textLength}/${MAX_LENGTH_BIOGRAPHY})`

    if (biographyElement.textLength > MAX_LENGTH_BIOGRAPHY) {
        labelElement.classList.remove('is-invalid')
    } else {
        labelElement.classList.add('is-invalid')
    }
}

function onPictureChanged() {
    const photoInputElement = document.getElementById("photo")
    const imgPhotoElement = document.getElementById("img-photo")
    
    const files = photoInputElement.files[0]
    if (files) {
        const fileReader = new FileReader()
        fileReader.readAsDataURL(files)
        fileReader.addEventListener("load", function () {
            imgPhotoElement.src = this.result
        })
    }
}