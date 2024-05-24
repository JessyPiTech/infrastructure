<?php //require_once "../connec.php";?>
<?php require_once "header.php";?>
<?php require_once "connec.php";?>
<?php 

    if ($_SESSION['user_email'] != null) {
        $user_email = $_SESSION['user_email'];
    } else {
        $user_email = '';
    }       
?>
<main>
<div class="container_inscription_login">
        <div class="card_container">
            <div class="container_inscription form_card front">
                <form method="post">
                    <h2>Envoyer un Email</h2>
        
                    <div class="form-group">
                        <!--je prescise que c''est un mail que j'utilise uniquement a des fin de developpement test-->
                        <input type="hidden" id="to" name="to" value="plutorede@gmail.com" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Sujet:</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" rows="4" required></textarea>
                    </div>
                    <button type="submit">Envoyer</button>
                    
                    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                        <div class="success">Email envoyé avec succès !</div>
                    <?php elseif (isset($_GET['error']) && $_GET['error'] == 1): ?>
                        <div class="error">Erreur lors de l'envoi de l'email. Veuillez réessayer.</div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</main>
        
<?php require_once "send_email.php";?>
<?php require_once "footer.php";?>