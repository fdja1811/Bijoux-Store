<?php
session_start();

$host     = 'localhost';
$user     = 'root';
$password = '';
$dbname   = 'ppe';
$conn     = mysqli_connect($host, $user, $password, $dbname);
if (!$conn) die("Connexion échouée : " . mysqli_connect_error());

$prenom = $nom = $email = '';
$error  = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom               = isset($_POST['prenom'])           ? htmlspecialchars($_POST['prenom'])   : '';
    $nom                  = isset($_POST['nom'])              ? htmlspecialchars($_POST['nom'])       : '';
    $email                = isset($_POST['email'])            ? htmlspecialchars($_POST['email'])     : '';
    $mot_de_passe         = isset($_POST['password'])         ? $_POST['password']                   : '';
    $confirm_mot_de_passe = isset($_POST['confirm-password']) ? $_POST['confirm-password']           : '';

    if (empty($prenom) || empty($nom) || empty($email) || empty($mot_de_passe) || empty($confirm_mot_de_passe)) {
        $error = "Tous les champs doivent être remplis.";
    } elseif ($mot_de_passe !== $confirm_mot_de_passe) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $sql_check  = "SELECT * FROM utilisateurs WHERE adresse_email = ?";
        $stmt_check = mysqli_prepare($conn, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $email);
        mysqli_stmt_execute($stmt_check);
        mysqli_stmt_store_result($stmt_check);

        if (mysqli_stmt_num_rows($stmt_check) > 0) {
            $error = "Cette adresse e-mail est déjà utilisée.";
        } else {
            $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_DEFAULT);
            $sql  = "INSERT INTO utilisateurs (nom, prenom, adresse_email, mot_de_passe) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "ssss", $nom, $prenom, $email, $mot_de_passe_hache);
                mysqli_stmt_execute($stmt);
                header("Location: connexion.php");
                exit();
            } else {
                $error = "Erreur lors de l'insertion : " . mysqli_error($conn);
            }
        }
        mysqli_stmt_close($stmt_check);
    }
    mysqli_close($conn);
}

$pageTitle = "Inscription - Bijoux Store";
$cssPath   = "../css/boutique.css";
$extraCss  = ["../css/index.css", "../css/forms.css"];
require_once '../components/header.php';
?>

<div class="form-wrapper">
    <form id="signup-form" action="" method="POST">
        <h2>Créer un compte</h2>

        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php elseif ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>

        <input type="text" id="prenom" name="prenom" placeholder="Prénom" value="<?php echo htmlspecialchars($prenom); ?>" required>
        <div id="prenom-error" class="error"></div>

        <input type="text" id="nom" name="nom" placeholder="Nom" value="<?php echo htmlspecialchars($nom); ?>" required>
        <div id="nom-error" class="error"></div>

        <input type="email" id="email" name="email" placeholder="Adresse e-mail" value="<?php echo htmlspecialchars($email); ?>" required>
        <div id="email-error" class="error"></div>

        <input type="password" id="password" name="password" placeholder="Mot de passe" required>
        <div id="caps-lock-message" style="color:orange;font-size:0.9rem;display:none;">⚠️ La touche MAJ est activée !</div>

        <div class="constraint" id="lengthConstraint"  style="color:red;">Minimum 12 caractères</div>
        <div class="constraint" id="majConstraint"     style="color:red;">Une majuscule est requise</div>
        <div class="constraint" id="minConstraint"     style="color:red;">Une minuscule est requise</div>
        <div class="constraint" id="numberConstraint"  style="color:red;">Un chiffre est requis</div>
        <div class="constraint" id="specialConstraint" style="color:red;">Un caractère spécial est requis</div>

        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirmer le mot de passe" required oncopy="return false">
        <div id="confirm-password-error" class="error"></div>

        <button type="submit" class="btn">Créer le compte</button>

        <div class="bottom-link">
            <p>Déjà inscrit ? <a href="connexion.php">Connectez-vous ici</a></p>
        </div>
    </form>
</div>

<script src="../js/inscription.js"></script>

<?php require_once '../components/footer.php'; ?>
