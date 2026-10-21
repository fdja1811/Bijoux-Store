const nouveauMdp = document.getElementById('nouveau_mdp');
const confMdp    = document.getElementById('conf_mdp');

function validateMdp() {
    const v = nouveauMdp.value;
    document.getElementById('lengthConstraint').style.color  = v.length >= 12                        ? 'green' : 'red';
    document.getElementById('majConstraint').style.color     = /[A-Z]/.test(v)                       ? 'green' : 'red';
    document.getElementById('minConstraint').style.color     = /[a-z]/.test(v)                       ? 'green' : 'red';
    document.getElementById('numberConstraint').style.color  = /[0-9]/.test(v)                       ? 'green' : 'red';
    document.getElementById('specialConstraint').style.color = /[!@#$%^&*(),.?":{}|<>]/.test(v)      ? 'green' : 'red';

    const err = document.getElementById('confirm-error');
    if (confMdp.value && confMdp.value !== v) {
        err.textContent = "Les mots de passe ne correspondent pas";
        err.className = "error";
    } else if (confMdp.value === v && confMdp.value !== '') {
        err.textContent = "Les mots de passe correspondent";
        err.className = "success";
    } else {
        err.textContent = "";
    }
}

nouveauMdp.addEventListener('input', validateMdp);
confMdp.addEventListener('input', validateMdp);
