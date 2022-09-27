function goNextTab() {
    let tabs = document.getElementById("nav-tab").children;
    let isNext = false;
    //tabs.forEach((tab) => {
    for(i = 0; i < tabs.length -1; i++) {
        let tab = tabs[i];
        if (tab.classList.contains("active")) {
            tab.classList.remove("active");
            tab.attributes.getNamedItem("aria-selected").value = "false";
            isNext = true;

            if (tab.id.match("nav-info")) {
                let isFormValid = validateForm();
                if (isFormValid) {
                    document.getElementById("submit-button").hidden = false;
                    document.getElementById("next-button").hidden = false;
                }
            }
        } else if (isNext) {
            tab.classList.add("active");
            tab.attributes.getNamedItem("aria-selected").value = "true";
            tab.disabled = false;
            break;
        }
    };
}



function validateForm() {
    let isFormValid = document.forms["registration-form"].checkValidty();
    if (! isFormValid) {
        document.forms["registration-form"].reportValidty();
    }

    return isFormValid;
  } 