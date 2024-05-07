<?php
// Paramètres de connexion à la base de données
$serveur = "localhost";
$utilisateur = "admin";
$mot_de_passe = "5331jcj9";
$base_de_donnees = "infrastructure";

// Vérifier si des données ont été soumises via le formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["ajouter"])) {
    // Récupérer les données du formulaire
    $game_id = $_POST["game_id"];
    $game_name = $_POST["game_name"];
    $game_publisher = $_POST["game_publisher"];
    $game_note = $_POST["game_note"];
    $game_image = $_POST["game_image"];
    $game_evaluation_date = date("Y-m-d H:i:s"); // Date et heure actuelles

    // Connexion à la base de données
    $connexion = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

    // Vérifier la connexion
    if (!$connexion) {
        die("La connexion à la base de données a échoué : " . mysqli_connect_error());
    }

    // Requête SQL d'insertion
    $sql = "INSERT INTO video_game (game_id, game_name, game_publisher, game_note, game_evaluation_date, game_image) 
            VALUES ('$game_id', '$game_name', '$game_publisher', $game_note, '$game_evaluation_date', '$game_image')";

    // Exécuter la requête
    if (mysqli_query($connexion, $sql)) {
        // Message de succès
        $message = "Les données ont été insérées avec succès.";
    } else {
        // Message d'erreur
        $message = "Erreur lors de l'insertion des données : " . mysqli_error($connexion);
    }

    // Fermer la connexion
    mysqli_close($connexion);
}

// Vérifier si des données ont été soumises via le formulaire de suppression
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["supprimer"])) {
    // Récupérer l'ID du jeu à supprimer
    $game_id_to_delete = $_POST["game_id_to_delete"];

    // Connexion à la base de données
    $connexion = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

    // Vérifier la connexion
    if (!$connexion) {
        die("La connexion à la base de données a échoué : " . mysqli_connect_error());
    }

    // Requête SQL de suppression
    $sql_delete = "DELETE FROM video_game WHERE game_id='$game_id_to_delete'";

    // Exécuter la requête
    if (mysqli_query($connexion, $sql_delete)) {
        $message_delete = "Le jeu avec l'ID $game_id_to_delete a été supprimé avec succès.";
    } else {
        $message_delete = "Erreur lors de la suppression du jeu : " . mysqli_error($connexion);
    }

    // Fermer la connexion
    mysqli_close($connexion);
}
?>

<?php require_once "header.php";?>
<main class="container mt-5">
    <div class="jumbotron">
        <h1 class="display-4">Welcome, Bienvenue</h1>
        <p class="lead">Explorez les fonctionnalités et profitez de l'expérience!</p>
        <hr class="my-4">
        <p>Ce site est conçu pour vous offrir la possibilité de consulter votre salaire et celui de vos collègues.</p>
    </div>
</main>

<div class="container mt-5">
    <h2>Ajouter un nouveau jeu</h2>
    <!-- Formulaire d'ajout de jeu -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="game_id">ID du jeu:</label>
            <input type="text" class="form-control" id="game_id" name="game_id">
        </div>
        <div class="form-group">
            <label for="game_name">Nom du jeu:</label>
            <input type="text" class="form-control" id="game_name" name="game_name">
        </div>
        <div class="form-group">
            <label for="game_publisher">Développeur du jeu:</label>
            <input type="text" class="form-control" id="game_publisher" name="game_publisher">
        </div>
        <div class="form-group">
            <label for="game_note">Note du jeu:</label>
            <input type="number" class="form-control" id="game_note" name="game_note" min="0" max="5">
        </div>
        <div class="form-group">
            <label for="game_image">Image du jeu:</label>
            <input type="text" class="form-control" id="game_image" name="game_image">
        </div>
        <button type="submit" class="btn btn-primary" name="ajouter">Ajouter</button>
    </form>
</div>

<div class="container mt-5">
    <h2>Supprimer un jeu</h2>
    <!-- Formulaire de suppression de jeu -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="game_id_to_delete">ID du jeu à supprimer:</label>
            <input type="text" class="form-control" id="game_id_to_delete" name="game_id_to_delete">
        </div>
        <button type="submit" class="btn btn-danger" name="supprimer">Supprimer</button>
    </form>
</div>

<div class="container mt-3">
    <!-- Affichage du message de suppression -->
    <div class="alert <?php echo isset($message_delete) && strpos($message_delete, 'succès') !== false ? 'alert-success' : 'alert-danger'; ?>" role="alert">
        <?php echo isset($message_delete) ? $message_delete : ''; ?>
    </div>
</div>

<?php require_once "footer.php";?>