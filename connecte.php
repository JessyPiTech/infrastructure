<?php //require_once "../connec.php";?>
<?php require_once "header.php";?>
<?php require_once "function.php";?>

<main>
<div class="container_inscription_login">
        <div class="card_container">
            <!-- Formulaire d'inscription -->
            <div class="container_inscription form_card front">
                <form method="post">
                    <h2>Inscription</h2>
                    <div class="form-group">
                        <label for="user_pseudo">Pseudo</label>
                        <input type="text" placeholder="Ton pseudo" class="form-control" id="user_pseudo" name="user_pseudo" required>
                    </div>
                    <div class="form-group">
                        <label for="user_email">Adresse e-mail</label>
                        <input type="email" class="form-control" placeholder="exemple@gmail.com" id="user_email" name="user_email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" placeholder="********" class="form-control" id="password" name="password" required>
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
            </div>
        </div>
    </div>
    <script src="./asset/js/scriptShow.js"></script> 
</main>

<?php require_once "footer.php";?>
