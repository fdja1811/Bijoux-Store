<?php

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Bijoux Store'; ?></title>
    <link rel="stylesheet" href="<?php echo $cssPath ?? '../css/boutique.css'; ?>">
    <?php if (!empty($extraCss)): ?>
        <?php foreach ($extraCss as $css): ?>
            <link rel="stylesheet" href="<?php echo $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>
</head>
<body>

<header>
    <div class="container">
        <h1>Bijoux Store</h1>
        <nav>
            <ul>
                <li><a href="../php/produit.php">Boutique</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="../php/panier.php">Panier 🛒</a></li>
                    <li><a href="../php/changer_mdp.php">Changer mon mot de passe 👤</a></li>
                    <li><a href="../php/deconnexion.php">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="../php/connexion.php">Connexion 👤</a></li>
                    <li><a href="../php/inscription.php">Inscription</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>