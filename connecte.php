<?php //require_once "../connec.php";?>
<?php require_once "coDB.php";

require_once "header.php";
$conn = connectDB();
?>
<main>
<div class="container_inscription_login">
        <div class="card_container">
            <!-- Formulaire d'inscription -->
            <div class="container_inscription form_card front">
                <form method="post">
                    <h2>Inscription</h2>
                    <div class="form-group">
                        <label for="pseudo">Pseudo</label>
                        <input type="text" placeholder="Votre pseudo:" class="form-control" id="pseudo" name="pseudo" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" class="form-control" placeholder="Adresse e-mail/Identifiant de connexion:" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
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
            
            <?php
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
                            // echo '<div class="alert alert-success" role="alert">Inscription réussie. Vous pouvez maintenant vous connecter.</div>';
                            // $_SESSION['connected'] = true;
                            // header("Location: ./index.php"); 
                            exit;
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
            <div class="container_inscription form_card back">
                <form method="post">    
                    <h2>Connexion</h2>
                    <div class="form-group">
                        <label for="pseudo_login">Pseudo</label>
                        <input type="text" placeholder="Pseudo :" class="form-control" id="pseudo_login" name="pseudo_login" required>
                    </div>
                    <div class="form-group">
                        <label for="password_login">Mot de passe</label>
                        <input type="password" placeholder="Mot de passe :"class="form-control" id="password_login" name="password_login" required>
                    </div>
                    <button type="submit" class="btn-inscription" name="login">Se connecter</button>
                    <div class="login-link">
                        <p>Vous n'avez pas de compte ? 
                            <a href="#" id="show_register">Register</a>
                        </p>
                    </div>
                </form>
                <?php
                    if (isset($_POST["login"])) {
                        echo "1";
                        $pseudo = $_POST['pseudo_login'];
                        $password = $_POST['password_login'];
                        var_dump("2");
                        

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
                                
                                $_SESSION['connected'] = true;
                                header("Location: ./index.php"); 
                                exit;
                            } else {
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
        </div>
    </div>


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
