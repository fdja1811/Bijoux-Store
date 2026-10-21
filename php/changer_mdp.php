<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}
require_once 'db.php';

$message = '';

// Vérifie si deux mots de passe sont trop similaires par sous-chaînes
function mot_trop_similaire($ancien, $nouveau, $taille = 3) {
    $ancien   = strtolower($ancien);
    $nouveau  = strtolower($nouveau);
    $longueur = strlen($ancien);
    for ($i = 0; $i <= $longueur - $taille; $i++) {
        $sous_chaine = substr($ancien, $i, $taille);
        if (strpos($nouveau, $sous_chaine) !== false) {
            return true;
        }
    }
    return false;
}

// Vérifie la complexité du nouveau mot de passe (règles RGPD côté serveur)
function valider_complexite($mdp) {
    if (strlen($mdp) < 12)
        return "Le mot de passe doit contenir au moins 12 caractères.";
    if (!preg_match('/[A-Z]/', $mdp))
        return "Le mot de passe doit contenir au moins une majuscule.";
    if (!preg_match('/[a-z]/', $mdp))
        return "Le mot de passe doit contenir au moins une minuscule.";
    if (!preg_match('/[0-9]/', $mdp))
        return "Le mot de passe doit contenir au moins un chiffre.";
    if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $mdp))
        return "Le mot de passe doit contenir au moins un caractère spécial.";
    return null;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ancien_mdp  = trim($_POST['ancien_mdp'] ?? '');
    $nouveau_mdp = trim($_POST['nouveau_mdp'] ?? '');
    $conf_mdp    = trim($_POST['conf_mdp'] ?? '');
    $user_id     = $_SESSION['user_id'];

    if (empty($ancien_mdp) || empty($nouveau_mdp) || empty($conf_mdp)) {
        $message = "Tous les champs sont obligatoires.";
    } elseif ($nouveau_mdp !== $conf_mdp) {
        $message = "Le nouveau mot de passe et sa confirmation ne correspondent pas.";
    } else {
        $erreur_complexite = valider_complexite($nouveau_mdp);
        if ($erreur_complexite) {
            $message = $erreur_complexite;
        } else {
            $sql  = "SELECT mot_de_passe FROM utilisateurs WHERE id_user = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $user   = $result->fetch_assoc();
            $stmt->close();

            if (password_verify($ancien_mdp, $user['mot_de_passe'])) {
                $sql_hist  = "SELECT mot_de_passe FROM historique_mdp WHERE id_user = ?";
                $stmt_hist = $conn->prepare($sql_hist);
                $stmt_hist->bind_param("i", $user_id);
                $stmt_hist->execute();
                $result_hist  = $stmt_hist->get_result();
                $mot_interdit = false;

                while ($row = $result_hist->fetch_assoc()) {
                    if (mot_trop_similaire($row['mot_de_passe'], $nouveau_mdp)) {
                        $mot_interdit = true;
                        break;
                    }
                }
                $stmt_hist->close();

                if (mot_trop_similaire($ancien_mdp, $nouveau_mdp)) {
                    $mot_interdit = true;
                }

                if ($mot_interdit) {
                    $message = "Le nouveau mot de passe est trop similaire à un ancien mot de passe.";
                } else {
                    $date        = date('Y-m-d H:i:s');
                    $stmt_insert = $conn->prepare("INSERT INTO historique_mdp (id_user, mot_de_passe, date_changement) VALUES (?, ?, ?)");
                    $stmt_insert->bind_param("iss", $user_id, $ancien_mdp, $date);
                    $stmt_insert->execute();
                    $stmt_insert->close();

                    $nouveau_mdp_hash = password_hash($nouveau_mdp, PASSWORD_DEFAULT);
                    $stmt_update = $conn->prepare("UPDATE utilisateurs SET mot_de_passe = ? WHERE id_user = ?");
                    $stmt_update->bind_param("si", $nouveau_mdp_hash, $user_id);
                    $message = $stmt_update->execute()
                        ? "Mot de passe mis à jour avec succès !"
                        : "Erreur lors de la mise à jour.";
                    $stmt_update->close();
                }
            } else {
                $message = "Ancien mot de passe incorrect.";
            }
        }
    }
}
$conn->close();

$pageTitle = "Changer le mot de passe - Bijoux Store";
$cssPath   = "../css/boutique.css";
$extraCss  = ["../css/index.css", "../css/forms.css"];
require_once '../components/header.php';
?>

<div class="form-wrapper">
    <form method="POST">
        <h2>Changer le mot de passe</h2>

        <?php if (!empty($message)): ?>
            <p class="<?php echo strpos($message, 'succès') !== false ? 'success' : 'error-message'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </p>
        <?php endif; ?>

        <input type="password" name="ancien_mdp" placeholder="Ancien mot de passe" required>
        <input type="password" name="nouveau_mdp" id="nouveau_mdp" placeholder="Nouveau mot de passe" required>

        <div class="constraint" id="lengthConstraint"  style="color:red;">Minimum 12 caractères</div>
        <div class="constraint" id="majConstraint"     style="color:red;">Une majuscule est requise</div>
        <div class="constraint" id="minConstraint"     style="color:red;">Une minuscule est requise</div>
        <div class="constraint" id="numberConstraint"  style="color:red;">Un chiffre est requis</div>
        <div class="constraint" id="specialConstraint" style="color:red;">Un caractère spécial est requis</div>

        <input type="password" name="conf_mdp" id="conf_mdp" placeholder="Confirmer le nouveau mot de passe" required>
        <div id="confirm-error" class="error"></div>

        <button type="submit" class="btn">Mettre à jour</button>

        <div class="bottom-link">
            <p><a href="produit.php">Retour à la boutique</a></p>
        </div>
    </form>
</div>

<script src="../js/changer_mdp.js"></script>

<?php require_once '../components/footer.php'; ?>
