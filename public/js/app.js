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

function onFormSubmitted(form, event) {
    if (!form.checkValidity()) {
        console.log(event)
        event.preventDefault()
        event.stopPropagation()
    }
    form.classList.add('was-validated')
}

function onKeyDownBiography() {
    const biographyElement = document.querySelector("#biography")
    const labelElement = document.querySelector("#biography + label")

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

function setCookie(cookieName, cookieValue, daysToExpire) {
    const date = new Date()
    date.setTime(date.getTime() + (daysToExpire*24*60*60*1000))
    document.cookie = `${cookieName}=${cookieValue}; expires=${date.toGMTString()}; samesite=strict; path=/`
}

function onHideHelp(button) {
    setCookie(button.id, 0, 1)
}