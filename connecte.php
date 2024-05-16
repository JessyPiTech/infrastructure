<?php
session_start();
// Fonction pour se connecter à la base de données
function connectDB() {
    require_once "credentials.php";
    $conn = new mysqli($host, $username, $password_db, $dbname);
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }
    return $conn;
}
$conn = connectDB();
?>

<?php require_once "header.php";?>

<main>
<div class="container_inscription_login">
    <div class="card_container">
        <!-- Formulaire d'inscription -->
        <div class="container_inscription form_card front">
            <form method="post">
                <h2>Inscription</h2>
                <div class="form-group">
                    <input type="text" placeholder="Pseudo :" class="form-control" id="pseudo" name="pseudo" required>
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="Email :" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Mot de passe :" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn-inscription" name="register">S'inscrire</button>
                <div class="login-link">
                    <p>Vous avez un compte ? 
                        <a href="#" id="show_login">Login</a>
                    </p>
                </div>
            </form>
        </div>
        
        <!-- Formulaire de connexion -->
        <div class="container_inscription form_card back">
            <form method="post">
                <h2>Connexion</h2>
                <div class="form-group">
                    <input type="text" placeholder="Pseudo :" class="form-control" id="pseudo_login" name="pseudo_login" required>
                </div>
                <div class="form-group">
                    <input type="password" placeholder="Mot de passe :"class="form-control" id="password_login" name="password_login" required>
                </div>
                <button type="submit" class="btn-inscription" name="login">Se connecter</button>
                <div class="login-link">
                    <p>Vous n'avez pas de compte ? 
                        <a href="#" id="show_register">Register</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
// Traitement de l'inscription
if (isset($_POST["register"])) {
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check_sql = "SELECT id FROM user WHERE pseudo = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $pseudo);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo '<div class="alert alert-danger" role="alert">Ce pseudo est déjà utilisé. Veuillez choisir un autre.</div>';
    } else {
        $hashed_password = $password;

        $insert_sql = "INSERT INTO user (pseudo, email, password) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sss", $pseudo, $email, $hashed_password);

        if ($insert_stmt->execute()) {
            $_SESSION['connect'] = true;
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['user_id'] = $insert_stmt->insert_id; // Récupère l'ID de l'utilisateur nouvellement inscrit
            header("Location: index.php");
            exit;
        } else {
            echo '<div class="alert alert-danger" role="alert">Erreur lors de l\'inscription. Veuillez réessayer.</div>';
        }
        $insert_stmt->close();
    }

    $check_stmt->close();
    $conn->close();
}
?>

<?php
// Traitement de la connexion
if (isset($_POST["login"])) {
    $pseudo = $_POST['pseudo_login'];
    $password = $_POST['password_login'];
    
    $sql = "SELECT id, pseudo, password FROM user WHERE pseudo = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $pseudo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password'];
        
        if ($password == $stored_password) {
            $_SESSION['connect'] = true;
            $_SESSION['pseudo'] = $row['pseudo'];
            $_SESSION['user_id'] = $row['id'];
            header("Location: index.php"); 
            exit;
        } else {
            echo '<div class="alert alert-danger" role="alert">Mot de passe incorrect. Veuillez réessayer.</div>';
        }
    } else {
        echo '<div class="alert alert-danger" role="alert">Pseudo incorrect. Veuillez réessayer.</div>';
    }

    $stmt->close();
    $conn->close();
}
?>
<script>
document.getElementById('show_login').addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector('.card_container').classList.add('show-login');
    document.querySelector('.card_container').classList.remove('show-register');
});

document.getElementById('show_register').addEventListener('click', function(e) {
    e.preventDefault();
    document.querySelector('.card_container').classList.add('show-register');
    document.querySelector('.card_container').classList.remove('show-login');
});
</script>

</main>

<?php require_once "footer.php";?>
