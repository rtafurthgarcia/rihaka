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

const ul = document.querySelector(".keyword-box ul")
const input = document.querySelectorAll(".keyword-box input")[0]
let inputValues = document.querySelectorAll(".keyword-box input")[1]

let MAX_TAGS = 5
let tags = []

function createTagElements(){
    ul.querySelectorAll("li").forEach(li => li.remove())
    tags.slice().reverse().forEach(tag =>{
        let liTag = `<li class="mx-1 my-auto">${tag} <i class="bi bi-x-lg" onclick="removeTagElement(this, '${tag}')"></i></li>`
        ul.insertAdjacentHTML("afterbegin", liTag)
    })
}

function removeTagElement(element, tag){
    let index  = tags.indexOf(tag)
    tags = [...tags.slice(0, index), ...tags.slice(index + 1)]
    element.parentElement.remove()
}

function addTag(element){
    if(element.keyCode === 32 && tags.length < MAX_TAGS){
        let tag = element.target.value.replace(/\s+/g, ' ')
        if(tag.length > 1 && !tags.includes(tag)){
            if(tags.length < 20){
                tag.split(',').forEach(tag => {
                    tags.push(tag.trim())
                    createTagElements()
                    inputValues.value = tags.toString()
                    console.log(inputValues)
                });
            }
        }
        element.target.value = ""
    } else if (element.keyCode == 8 && input.value === '') {
        tags.pop()
        createTagElements()
    }
}


if (input) {
    if (input.value.length > 0) {
        tags = input.value.split(',')
        createTagElements()
        input.value = ''
    }

    input.addEventListener("keyup", addTag)
}

if (document.getElementById('demo')) {
    AsciinemaPlayer.create('/videos/demo.cast', document.getElementById('demo'), {
        autoPlay: true, 
        loop: true,
        speed: 2,
        fit: "height"
    })
}

let players = document.querySelectorAll(".player")
if (players) {
    players.forEach(playerElement => {
        const source = playerElement.querySelector("source").src
        console.log(source)
        
        AsciinemaPlayer.create(source, playerElement, {
            autoPlay: false, 
            loop: false,
            speed: 2,
            fit: "height"
        });
    })
}