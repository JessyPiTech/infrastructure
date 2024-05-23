<?php
// Paramètres de connexion à la base de données
require_once "coBDSM.php";

$conn = connectDB();
// Déclaration des variables pour les messages
$message_insert = '';
$message_update = '';
$message_delete = '';

// Requête SQL pour récupérer les jeux
$sql_select = "SELECT * FROM video_game";
$resultat = mysqli_query($conn, $sql_select);

// Vérifier si des données ont été soumises via le formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    

    // Vérifier s'il s'agit d'une mise à jour ou d'un ajout de jeu
    if (isset($_POST["ajouter"])) {
        // Validation des entrées
        $game_name = mysqli_real_escape_string($conn, $_POST["game_name"]);
        $game_publisher = mysqli_real_escape_string($conn, $_POST["game_publisher"]);
        $game_note = intval($_POST["game_note"]); // Convertir en entier

        // Validation de l'image
        if ($_FILES['game_image']['error'] !== UPLOAD_ERR_OK) {
            $message_insert = "Erreur lors de l'envoi du fichier.";
        } else {
            // Vérifier l'extension et le type MIME du fichier
            $file_extension = pathinfo($_FILES["game_image"]["name"], PATHINFO_EXTENSION);
            $file_mime_type = mime_content_type($_FILES["game_image"]["tmp_name"]);
        
            if ($file_mime_type == 'image/svg+xml' || $file_extension == 'svg' || strpos($file_extension, 'svg.') !== false) {
                $message_insert = "Les fichiers SVG et les fichiers ayant 'svg' dans leur extension ne sont pas autorisés.";
            } else {
                // Chemin où enregistrer l'image téléchargée
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["game_image"]["name"]);

                // Déplacer le fichier téléchargé vers le dossier cible
                if (!move_uploaded_file($_FILES["game_image"]["tmp_name"], $target_file)) {
                    $message_insert = "Erreur lors de l'enregistrement de l'image.";
                } else {
                    // Requête SQL d'ajout
                    $sql_insert = "INSERT INTO video_game (game_name, game_publisher, game_note, game_evaluation_date, game_image) VALUES ('$game_name', '$game_publisher', $game_note, NOW(), '$target_file')";

                    // Exécuter la requête
                    if (mysqli_query($conn, $sql_insert)) {
                        $message_insert = "Le jeu a été ajouté avec succès.";
                    } else {
                        $message_insert = "Erreur lors de l'ajout du jeu : " . mysqli_error($conn);
                    }
                }
            }
        }
    } elseif (isset($_POST["modifier"])) {
        // Récupérer les données du formulaire
        $game_id_modify = intval($_POST["game_id_modify"]); // Convertir en entier
        $game_name_modify = mysqli_real_escape_string($conn, $_POST["game_name_modify"]);
        $game_publisher_modify = mysqli_real_escape_string($conn, $_POST["game_publisher_modify"]);
        $game_note_modify = intval($_POST["game_note_modify"]); // Convertir en entier

        // Validation de l'image
        if ($_FILES['game_image_modify']['error'] !== UPLOAD_ERR_OK) {
            $message_update = "Erreur lors de l'envoi du fichier.";
        } else {
            // Vérifier l'extension et le type MIME du fichier
            $file_extension = pathinfo($_FILES["game_image_modify"]["name"], PATHINFO_EXTENSION);
            $file_mime_type = mime_content_type($_FILES["game_image_modify"]["tmp_name"]);

            if ($file_mime_type == 'image/svg+xml' || $file_extension == 'svg' || $file_extension == 'svg.png') {
                $message_update = "Les fichiers SVG et SVG.PNG ne sont pas autorisés.";
            } else {
                // Chemin où enregistrer l'image téléchargée
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["game_image_modify"]["name"]);

                // Déplacer le fichier téléchargé vers le dossier cible
                if (!move_uploaded_file($_FILES["game_image_modify"]["tmp_name"], $target_file)) {
                    $message_update = "Erreur lors de l'enregistrement de l'image.";
                } else {
                    // Requête SQL de mise à jour
                    $sql_update = "UPDATE video_game SET game_name='$game_name_modify', game_publisher='$game_publisher_modify', game_note=$game_note_modify, game_image='$target_file' WHERE game_id=$game_id_modify";

                    // Exécuter la requête
                    if (mysqli_query($conn, $sql_update)) {
                        $message_update = "Les données du jeu avec l'ID $game_id_modify ont été mises à jour avec succès.";
                    } else {
                        $message_update = "Erreur lors de la mise à jour des données du jeu : " . mysqli_error($conn);
                    }
                }
            }
        }
    } elseif (isset($_POST["supprimer"])) {
        // Récupérer l'ID du jeu à supprimer
        $game_id_to_delete = intval($_POST["game_id_to_delete"]); // Convertir en entier

        // Requête SQL de suppression
        $sql_delete = "DELETE FROM video_game WHERE game_id=$game_id_to_delete";

        // Exécuter la requête
        if (mysqli_query($conn, $sql_delete)) {
            $message_delete = "Le jeu avec le nom $game_id_to_delete a été supprimé avec succès.";
        } else {
            $message_delete = "Erreur lors de la suppression du jeu : " . mysqli_error($conn);
        }
    }

    // Fermer la connexion
    mysqli_close($conn);
}

// Si des messages sont définis, les afficher via une alerte JavaScript
if (!empty($message_insert) || !empty($message_update) || !empty($message_delete)) {
    echo '<script type="text/javascript">';
    if (!empty($message_insert)) {
        echo 'alert("' . $message_insert . '");';
    }
    if (!empty($message_update)) {
        echo 'alert("' . $message_update . '");';
    }
    if (!empty($message_delete)) {
        echo 'alert("' . $message_delete . '");';
    }
    echo 'window.location.href = "./index.php";';
    echo '</script>';
}

if (isset($_POST["logout"])) {
    // Définir le cookie 'connected' comme faux
    $_SESSION['connected'] = false;
    // Rediriger vers la page de connexion ou une autre page appropriée
    header("Location: ./connecte.php"); // Modifier selon le nom de votre page de connexion
    exit;
}
?>