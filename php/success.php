<?php
session_start();
$pageTitle = "Inscription réussie - Bijoux Store";
$cssPath   = "../css/boutique.css";
$extraCss  = ["../css/index.css", "../css/forms.css"];
require_once '../components/header.php';
?>

<div class="form-wrapper" style="text-align:center;">
    <div class="success-message">
        <h2>Inscription réussie !</h2>
        <p>Votre compte a été créé avec succès.</p>
        <a href="connexion.php" class="btn">Se connecter</a>
    </div>
</div>

<?php require_once '../components/footer.php'; ?>
