<?php
session_start();
require_once 'db.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email         = trim($_POST['email'] ?? '');
    $passwordInput = trim($_POST['password'] ?? '');
    $email         = $conn->real_escape_string($email);

    $sql  = "SELECT * FROM utilisateurs WHERE adresse_email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($passwordInput, $user['mot_de_passe'])) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['nom']     = $user['nom'];
            $_SESSION['prenom']  = $user['prenom'];
            header("Location: produit.php");
            exit();
        } else {
            $message = "Mot de passe  ou adresse mail incorrect.";
        }
    } else {
        $message = "Aucun utilisateur trouvé avec cet email.";
    }
    $stmt->close();
}
$conn->close();

$pageTitle = "Connexion - Bijoux Store";
$cssPath   = "../css/boutique.css";
$extraCss  = ["../css/index.css", "../css/forms.css"];
require_once '../components/header.php';
?>

<div class="form-wrapper">
    <form id="login-form" method="POST">
        <h2>Connexion</h2>

        <?php if (!empty($message)): ?>
            <p class="error-message"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <input type="email" id="email" name="email" placeholder="Adresse e-mail" required>
        <input type="password" id="password" name="password" placeholder="Mot de passe" required>

        <p id="uppercase-warning" class="notification">La touche majuscule est activée.</p>

        <button type="submit" class="btn">Se connecter</button>

        <div class="bottom-link">
            <p>Pas encore de compte ? <a href="inscription.php">Créer un compte ici</a></p>
        </div>
    </form>
</div>

<script src="../js/connexion.js"></script>

<?php require_once '../components/footer.php'; ?>
