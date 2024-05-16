<?php
session_start();
// Fonction pour se connecter à la base de données
function connectDB() {
    $host = "localhost";
    $username = "admin";
    $password_db = "5331jcj9";
    $dbname = "infrastructure";
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
    <div class="container">
        <!-- Formulaire d'inscription -->
        <form method="post">
            <h2>Inscription</h2>
            <div class="form-group">
                <label for="pseudo">Pseudo :</label>
                <input type="text" class="form-control" id="pseudo" name="pseudo" required>
            </div>
            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe :</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary" name="register">S'inscrire</button>
        </form>

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

                //si on veux acher c'est la 
                $hashed_password = $password;

                $insert_sql = "INSERT INTO user (pseudo, email, password) VALUES (?, ?, ?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("sss", $pseudo, $email, $hashed_password);

                if ($insert_stmt->execute()) {
                    echo '<div class="alert alert-success" role="alert">Inscription réussie. Vous pouvez maintenant vous connecter.</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Erreur lors de l\'inscription. Veuillez réessayer.</div>';
                }
                $insert_stmt->close(); // Fermer la déclaration préparée
            }

            $check_stmt->close();
            $conn->close();
        }
        ?>
        
         <!-- Formulaire de connexion -->
         <form method="post">
            <h2>Connexion</h2>
            <div class="form-group">
                <label for="pseudo_login">Pseudo :</label>
                <input type="text" class="form-control" id="pseudo_login" name="pseudo_login" required>
            </div>
            <div class="form-group">
                <label for="password_login">Mot de passe :</label>
                <input type="password" class="form-control" id="password_login" name="password_login" required>
            </div>
            <button type="submit" class="btn btn-primary" name="login">Se connecter</button>
        </form>

        <?php
        // Traitement de la connexion
        if (isset($_POST["login"])) {
            echo "1";
            $pseudo = $_POST['pseudo_login'];
            $password = $_POST['password_login'];
            echo "2";
            
        
            $sql = "SELECT id, pseudo, password FROM user WHERE pseudo = ? LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $pseudo);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows == 1) {
                echo "3";
                $row = $result->fetch_assoc();
                $stored_password = $row['password'];
                
                // Comparaison des mots de passe saisis et stockés
                echo $password,$stored_password;
                if ($password == $stored_password) {
                    echo "4";
                    $_SESSION['connect'] = true;
                    header("Location: index.php"); 
                    exit;
                } else {
                    echo "5";
                    echo '<div class="alert alert-danger" role="alert">Mot de passe incorrect. Veuillez réessayer.</div>';
                }
                echo $password,$stored_password;
            } else {
                echo '<div class="alert alert-danger" role="alert">Pseudo incorrect. Veuillez réessayer.</div>';
            }
        
            $stmt->close();
            $conn->close();
        }
        
        ?>
    </div>
</main>

<?php require_once "footer.php";?>