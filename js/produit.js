function filtrerProduits(categorie) {
    document.querySelectorAll('.produit').forEach(produit => {
        produit.style.display = (categorie === 'all' || produit.classList.contains(categorie)) ? 'block' : 'none';
    });
}

function agrandirImage(src) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox').style.display = 'flex';
}

function fermerImage() {
    document.getElementById('lightbox').style.display = 'none';
}

document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') fermerImage();
});
