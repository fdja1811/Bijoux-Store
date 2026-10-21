const passwordInput     = document.getElementById("password");
const uppercaseWarning  = document.getElementById("uppercase-warning");

passwordInput.addEventListener("keydown", function(e) {
    if (e.getModifierState("CapsLock")) {
        uppercaseWarning.classList.add("active");
    } else {
        uppercaseWarning.classList.remove("active");
    }
});
