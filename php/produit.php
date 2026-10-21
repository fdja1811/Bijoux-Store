<?php
session_start();
require_once 'db.php';

// Ajouter un produit au panier si formulaire soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['produit_id'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: connexion.php");
        exit;
    }

    $user_id    = $_SESSION['user_id'];
    $produit_id = intval($_POST['produit_id']);
    $quantite   = 1;

    $sql  = "SELECT id, quantite FROM panier WHERE user_id = ? AND produit_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $produit_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row               = $result->fetch_assoc();
        $nouvelle_quantite = $row['quantite'] + $quantite;
        $sql  = "UPDATE panier SET quantite = ?, date_ajout = NOW() WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $nouvelle_quantite, $row['id']);
        $stmt->execute();
    } else {
        $sql  = "INSERT INTO panier (user_id, produit_id, quantite, date_ajout) VALUES (?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $user_id, $produit_id, $quantite);
        $stmt->execute();
    }

    header("Location: produit.php?ajout=success");
    exit;
}

// Récupérer tous les produits
$sql    = "SELECT * FROM produit";
$result = $conn->query($sql);

$pageTitle = "Boutique - Bijoux Store";
$cssPath   = "../css/boutique.css";
$extraCss  = [];
require_once '../components/header.php';
?>

<section class="filtre">
    <h2>Rechercher par catégorie :</h2>
    <button onclick="filtrerProduits('all')">Tous</button>
    <button onclick="filtrerProduits('bague')">Bagues</button>
    <button onclick="filtrerProduits('collier')">Colliers</button>
    <button onclick="filtrerProduits('parure')">Parures</button>
    <button onclick="filtrerProduits('boucle')">Boucles d'oreilles</button>
    <button onclick="filtrerProduits('bracelet')">Bracelets</button>
</section>

<section class="produits">
<?php
if ($result->num_rows > 0) {
    $imagesIndex = ['bague'=>1,'collier'=>1,'parure'=>1,'boucle'=>1,'bracelet'=>1];

    while ($row = $result->fetch_assoc()) {
        $categorie    = $row['categorie'];
        $nom_produit  = $row['nom_produit'];
        $prix         = $row['prix'];
        $quantite     = $row['quantite'];
        $id_produit   = $row['produit_id'];

        $prix_formate     = number_format((float)$prix, 2, ',', ' ') . ' €';
        $quantite_message = ($quantite <= 0) ? "<p style='color:red;font-weight:bold;'>Rupture de stock</p>" : "";
        $indexImage       = $imagesIndex[$categorie];
        $imagePath        = "../images/{$categorie}{$indexImage}.jpeg";
        $imagesIndex[$categorie] = ($imagesIndex[$categorie] % 10) + 1;

        echo "
        <div class='produit {$categorie}'>
            <img src='{$imagePath}' alt='{$categorie} Berbère' class='image-produit' onclick=\"agrandirImage('{$imagePath}')\">
            <p style='color:gray;font-size:0.9em;'>Cliquez pour agrandir l'image</p>
            <h4>{$nom_produit}</h4>
            <p><strong>{$prix_formate}</strong></p>
            {$quantite_message}";

        if ($quantite > 0) {
            echo "<form method='POST' style='display:inline;'>
                    <input type='hidden' name='produit_id' value='{$id_produit}'>
                    <button type='submit'>Ajouter au panier</button>
                  </form>";
        }
        echo "</div>";
    }
} else {
    echo "<p>Aucun produit disponible</p>";
}
$conn->close();
?>
</section>

<?php if (isset($_GET['ajout']) && $_GET['ajout'] == 'success'): ?>
    <div class="success">Produit ajouté au panier avec succès !</div>
<?php endif; ?>

<div id="lightbox" class="lightbox" onclick="fermerImage()">
    <img id="lightbox-img" src="" alt="Image agrandie">
</div>

<script src="../js/produit.js"></script>

<?php require_once '../components/footer.php'; ?>
