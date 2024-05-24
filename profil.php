<?php //require_once "../connec.php";?>
<?php 
require_once "header.php";
require_once "connec.php";
require_once "function.php";

[$user_pseudo, $user_email, $user_level, $user_creation] = getUserProfile($conn, $user_pseudo);
?>
<main>
    <div class="profile-container">
        <div class="profile-header">
            <h2>Profil de <?php echo htmlspecialchars($user_pseudo); ?></h2>
        </div>
        <div class="profile-item">
            <strong>Email :</strong> <?php echo htmlspecialchars($user_email); ?>
        </div>
        <div class="profile-item">
            <strong>Niveau :</strong> <?php echo htmlspecialchars($user_level); ?>
        </div>
        <div class="profile-item">
            <strong>Date de création :</strong> <?php echo htmlspecialchars($user_creation); ?>
        </div>
    </div>

    </body>
    </html>

    <?php
    $conn->close();
    ?>
</main>
<?php require_once "footer.php";?>