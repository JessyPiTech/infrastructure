<?php
// Paramètres de connexion à la base de données
$serveur = "localhost";
$utilisateur = "admin";
$mot_de_passe = "5331jcj9";
$base_de_donnees = "infrastructure";
$connexion = mysqli_connect($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);
// Déclaration de la variable $resultat en dehors du bloc conditionnel
$resultat = null;
// Requête SQL pour récupérer les jeux
$sql_select = "SELECT * FROM video_game";
$resultat = mysqli_query($connexion, $sql_select);

// Vérifier si des données ont été soumises via le formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    

    // Vérifier la connexion
    if (!$connexion) {
        die("La connexion à la base de données a échoué : " . mysqli_connect_error());
    }

    // Vérifier s'il s'agit d'une mise à jour ou d'un ajout de jeu
    if (isset($_POST["ajouter"])) {
        // Validation des entrées
        $game_name = mysqli_real_escape_string($connexion, $_POST["game_name"]);
        $game_publisher = mysqli_real_escape_string($connexion, $_POST["game_publisher"]);
        $game_note = intval($_POST["game_note"]); // Convertir en entier
        // Validation de l'image - Vous pouvez ajouter plus de validation ici si nécessaire

        // Vérification des erreurs d'upload
        if ($_FILES['game_image']['error'] !== UPLOAD_ERR_OK) {
            die("Erreur lors de l'envoi du fichier.");
        }

        // Chemin où enregistrer l'image téléchargée
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["game_image"]["name"]);

        // Déplacer le fichier téléchargé vers le dossier cible
        if (!move_uploaded_file($_FILES["game_image"]["tmp_name"], $target_file)) {
            die("Erreur lors de l'enregistrement de l'image.");
        }

        // Requête SQL d'ajout
        $sql_insert = "INSERT INTO video_game (game_name, game_publisher, game_note, game_evaluation_date, game_image) VALUES ('$game_name', '$game_publisher', $game_note, NOW(), '$target_file')";

        // Exécuter la requête
        if (mysqli_query($connexion, $sql_insert)) {
            $message_insert = "Le jeu a été ajouté avec succès.";
        } else {
            $message_insert = "Erreur lors de l'ajout du jeu : " . mysqli_error($connexion);
        }
    } elseif (isset($_POST["modifier"])) {
        // Récupérer les données du formulaire
        $game_id_modify = intval($_POST["game_id_modify"]); // Convertir en entier
        $game_name_modify = mysqli_real_escape_string($connexion, $_POST["game_name_modify"]);
        $game_publisher_modify = mysqli_real_escape_string($connexion, $_POST["game_publisher_modify"]);
        $game_note_modify = intval($_POST["game_note_modify"]); // Convertir en entier
        // Validation de l'image - Vous pouvez ajouter plus de validation ici si nécessaire
        // Vérification des erreurs d'upload
        if ($_FILES['game_image_modify']['error'] !== UPLOAD_ERR_OK) {
            die("Erreur lors de l'envoi du fichier.");
        }

        // Chemin où enregistrer l'image téléchargée
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["game_image_modify"]["name"]);

        // Déplacer le fichier téléchargé vers le dossier cible
        if (!move_uploaded_file($_FILES["game_image_modify"]["tmp_name"], $target_file)) {
            die("Erreur lors de l'enregistrement de l'image.");
        }

        // Requête SQL de mise à jour
        $sql_update = "UPDATE video_game SET game_name='$game_name_modify', game_publisher='$game_publisher_modify', game_note=$game_note_modify, game_image='$target_file' WHERE game_id=$game_id_modify";


        // Exécuter la requête
        if (mysqli_query($connexion, $sql_update)) {
            $message_update = "Les données du jeu avec l'ID $game_id_modify ont été mises à jour avec succès.";
        } else {
            $message_update = "Erreur lors de la mise à jour des données du jeu : " . mysqli_error($connexion);
        }
    } elseif (isset($_POST["supprimer"])) {
        // Récupérer l'ID du jeu à supprimer
        $game_id_to_delete = intval($_POST["game_id_to_delete"]); // Convertir en entier

        // Requête SQL de suppression
        $sql_delete = "DELETE FROM video_game WHERE game_id=$game_id_to_delete";

        // Exécuter la requête
        if (mysqli_query($connexion, $sql_delete)) {
            $message_delete = "Le jeu avec l'ID $game_id_to_delete a été supprimé avec succès.";
        } else {
            $message_delete = "Erreur lors de la suppression du jeu : " . mysqli_error($connexion);
        }
    }
    
    // Fermer la connexion
    mysqli_close($connexion);
}


// Traitement de la déconnexion
if (isset($_POST["logout"])) {
    // Détruire toutes les variables de session
    $_SESSION = array();

    // Si vous voulez détruire complètement la session, effacez également le cookie de session.
    // Notez que cela détruira la session et pas seulement les données de session !
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Finalement, détruire la session
    session_destroy();
    
    // Rediriger vers la page de connexion ou une autre page appropriée
    header("Location: connecte.php"); // Modifier login.php selon le nom de votre page de connexion
    exit;
}
?>