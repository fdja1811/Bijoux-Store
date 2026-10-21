const form            = document.getElementById("signup-form");
const password        = document.getElementById("password");
const confirmPassword = document.getElementById("confirm-password");

const lengthConstraint  = document.getElementById("lengthConstraint");
const majConstraint     = document.getElementById("majConstraint");
const minConstraint     = document.getElementById("minConstraint");
const numberConstraint  = document.getElementById("numberConstraint");
const specialConstraint = document.getElementById("specialConstraint");
const capsLockMessage   = document.getElementById("caps-lock-message");

function validatePassword() {
    const value       = password.value;
    const hasUppercase = /[A-Z]/.test(value);
    const hasLowercase = /[a-z]/.test(value);
    const hasNumber    = /\d/.test(value);
    const hasSpecial   = /[!@#$%^&*(),.?":{}|<>]/.test(value);
    const hasLength    = value.length >= 12;

    majConstraint.style.color     = hasUppercase ? "green" : "red";
    minConstraint.style.color     = hasLowercase ? "green" : "red";
    numberConstraint.style.color  = hasNumber    ? "green" : "red";
    specialConstraint.style.color = hasSpecial   ? "green" : "red";
    lengthConstraint.style.color  = hasLength    ? "green" : "red";

    const confirmError = document.getElementById("confirm-password-error");
    if (confirmPassword.value && confirmPassword.value !== value) {
        confirmError.textContent = "Les mots de passe ne correspondent pas";
        confirmError.className   = "error";
    } else if (confirmPassword.value === value && confirmPassword.value !== '') {
        confirmError.textContent = "Les mots de passe correspondent";
        confirmError.className   = "success";
    } else {
        confirmError.textContent = "";
    }
}

password.addEventListener("input", validatePassword);
confirmPassword.addEventListener("input", validatePassword);

password.addEventListener("keyup",   e => { capsLockMessage.style.display = e.getModifierState("CapsLock") ? "block" : "none"; });
password.addEventListener("keydown", e => { capsLockMessage.style.display = e.getModifierState("CapsLock") ? "block" : "none"; });

// Empêcher copier / couper / coller
[password, confirmPassword].forEach(field => {
    field.addEventListener("copy",  e => e.preventDefault());
    field.addEventListener("cut",   e => e.preventDefault());
    field.addEventListener("paste", e => e.preventDefault());
});

form.addEventListener("submit", function(e) {
    if (!password.value || !confirmPassword.value || password.value !== confirmPassword.value) {
        e.preventDefault();
    }
});
