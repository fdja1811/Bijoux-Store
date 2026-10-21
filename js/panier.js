// Validation du numéro de carte avec l'algorithme de Luhn
function isCardValid(cardNumber) {
    let sum = 0;
    let shouldDouble = false;
    for (let i = cardNumber.length - 1; i >= 0; i--) {
        let digit = parseInt(cardNumber.charAt(i));
        if (shouldDouble) {
            digit *= 2;
            if (digit > 9) digit -= 9;
        }
        sum += digit;
        shouldDouble = !shouldDouble;
    }
    return sum % 10 === 0;
}

// Mise à jour du panier
const productCheckboxes = document.querySelectorAll('.product-checkbox');
const cart = document.getElementById('cart');
productCheckboxes.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
        cart.innerHTML = '';
        let total = 0;
        productCheckboxes.forEach(cb => {
            if (cb.checked) {
                cart.innerHTML += `
                    <div class="cart-item">
                        <img src="${cb.dataset.img}" alt="${cb.dataset.name}">
                        <span>${cb.dataset.name} - ${cb.dataset.price}€</span>
                    </div>`;
                total += parseFloat(cb.dataset.price);
            }
        });
        document.getElementById('shipping-info').innerHTML =
            total >= 130 ? '<p>Livraison gratuite !</p>' : '<p>Frais de livraison : 10€</p>';
    });
});

// Changement de méthode de paiement
document.getElementById('payment-method').addEventListener('change', function() {
    document.querySelectorAll('.payment-details').forEach(d => d.classList.add('hidden'));
    document.getElementById(this.value + '-details').classList.remove('hidden');
});

// Vérification du numéro de carte
document.getElementById('card-number').addEventListener('input', function() {
    const msg = document.getElementById('card-validity-message');
    if (isCardValid(this.value.replace(/\s+/g, ''))) {
        msg.textContent = 'Carte valide !';
        msg.style.color = 'green';
    } else {
        msg.textContent = 'Numéro de carte invalide !';
        msg.style.color = 'red';
    }
});

// Soumission du formulaire de paiement
document.getElementById('payment-form').addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire('Paiement effectué avec succès !', '', 'success');
});
