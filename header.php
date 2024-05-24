

<?php //require_once "../connec.php";?>
<?php 
if (session_status() == PHP_SESSION_NONE) {
    // Si aucune session n'est démarrée, démarrer une session
    session_start();
}

$user_pseudo = 'connexion';
if (isset($_SESSION['user_pseudo']) && $_SESSION['user_pseudo'] != null) {
    $user_pseudo = $_SESSION['user_pseudo'];
    $user_id = $_SESSION['user_id'];
}
//print_r($_SESSION);
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <link rel="stylesheet" href="asset/css/normalize.css">
    <link rel="stylesheet" href="asset/css/style.css">
    
</head>

<body>

<header class="header"> 
<nav class="navbar">
    <div class="container">
        <a class="navbar-brand" href="./index.php"><img src="asset/img/logo.jpg" alt="logo"></a>
        <div id="navbarNav" class="collapse navbar-collapse">
            <ul class="navbar-nav-test">
                <li class="nav-item active">
                    <a class="nav-link" href="profil.php"><?php  echo $user_pseudo; ?></a>

                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./infrastructure_documentation_architecture.pdf">À propos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contacte.php">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

</header>
