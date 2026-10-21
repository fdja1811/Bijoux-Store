<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}
require_once 'db.php';

if (isset($_GET['supprimer'])) {
    $id   = intval($_GET['supprimer']);
    $stmt = $conn->prepare("DELETE FROM panier WHERE id=? AND user_id=?");
    $stmt->bind_param("ii", $id, $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}

if (isset($_GET['vider'])) {
    $stmt = $conn->prepare("DELETE FROM panier WHERE user_id=?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $stmt->close();
}

// Récupérer le panier avec nom_produit pour reconstruire l'image
$stmt = $conn->prepare("SELECT p.id, pr.nom_produit, pr.categorie, pr.prix, p.quantite 
                        FROM panier p 
                        JOIN produit pr ON p.produit_id = pr.produit_id 
                        WHERE p.user_id=?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

$pageTitle = "Panier - Bijoux Store";
$cssPath   = "../css/boutique.css";
$extraCss  = ["../css/panier.css"];
require_once '../components/header.php';
?>

<div class="panier-container">
    <h2>Votre Panier</h2>
    <?php
    $total = 0;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $prix   = floatval(str_replace(',', '.', $row['prix']));
            $total += $prix * $row['quantite'];

            // Reconstruction du chemin image depuis nom_produit (ex: "bague3" → ../images/bague3.jpeg)
            $nom      = strtolower($row['nom_produit']); // ex: bague3
            $imgPath  = "../images/{$nom}.jpeg";

            echo "
            <div class='panier-item'>
                <img src='{$imgPath}' alt='{$row['nom_produit']}' 
                     onerror=\"this.src='../images/placeholder.jpeg'\"
                     style='width:80px;height:80px;object-fit:cover;border-radius:6px;flex-shrink:0;'>
                <div>
                    <h4>{$row['nom_produit']}</h4>
                    <p>Prix unitaire : {$row['prix']} €</p>
                    <p>Quantité : {$row['quantite']}</p>
                    <p><strong>Sous-total : " . number_format($prix * $row['quantite'], 2, ',', ' ') . " €</strong></p>
                </div>
                <a href='?supprimer={$row['id']}'><button>Supprimer</button></a>
            </div>";
        }
        echo "<div class='panier-footer'>
                <p>Total : <strong>" . number_format($total, 2, ',', ' ') . " €</strong></p>
                <a href='?vider=1'><button id='vider-panier'>Vider le panier</button></a>
              </div>";
    } else {
        echo "<p style='text-align:center;padding:2rem;'>Votre panier est vide.</p>";
    }
    $conn->close();
    ?>
</div>

<?php require_once '../components/footer.php'; ?>
