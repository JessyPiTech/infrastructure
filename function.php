<?php
if (session_status() == PHP_SESSION_NONE) {
    // Si aucune session n'est démarrée, démarrer une session
    session_start();
}
// Paramètres de connexion à la base de données
require_once "coDB.php";

$conn = connectDB();
// Déclaration des variables pour les messages
$message_insert = '';
$message_update = '';
$message_delete = '';

// Requête SQL pour récupérer les jeux
$sql_select = "SELECT * FROM game";
$resultat = mysqli_query($conn, $sql_select);

// Vérifier si des données ont été soumises via le formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    

    // Vérifie s'il s'agit d'une mise à jour ou d'un ajout de jeu
    if (isset($_POST["ajouter"])) {

        $game_name = mysqli_real_escape_string($conn, $_POST["game_name"]);
        $game_publisher = mysqli_real_escape_string($conn, $_POST["game_publisher"]);
        $game_note = intval($_POST["game_note"]); // Convertir en entier


        if ($_FILES['game_image']['error'] !== UPLOAD_ERR_OK) {
            $message_insert = "Erreur lors de l'envoi du fichier.";
        } else {
            // Vérifie l'extension et le type MIME
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
                    $sql_insert = "INSERT INTO game (game_name, game_publisher, game_note, game_evaluation_date, game_image) VALUES ('$game_name', '$game_publisher', $game_note, NOW(), '$target_file')";

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
        $game_id_modify = intval($_POST["game_id_modify"]); 
        $game_name_modify = mysqli_real_escape_string($conn, $_POST["game_name_modify"]);
        $game_publisher_modify = mysqli_real_escape_string($conn, $_POST["game_publisher_modify"]);
        $game_note_modify = intval($_POST["game_note_modify"]); 

        // Validation de l'image
        if ($_FILES['game_image_modify']['error'] !== UPLOAD_ERR_OK) {
            $message_update = "Erreur lors de l'envoi du fichier.";
        } else {
            $file_extension = pathinfo($_FILES["game_image_modify"]["name"], PATHINFO_EXTENSION);
            $file_mime_type = mime_content_type($_FILES["game_image_modify"]["tmp_name"]);

            if ($file_mime_type == 'image/svg+xml' || $file_extension == 'svg' || $file_extension == 'svg.png') {
                $message_update = "Les fichiers SVG et SVG.PNG ne sont pas autorisés.";
            } else {
              
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["game_image_modify"]["name"]);

               
                if (!move_uploaded_file($_FILES["game_image_modify"]["tmp_name"], $target_file)) {
                    $message_update = "Erreur lors de l'enregistrement de l'image.";
                } else {
                    
                    $sql_update = "UPDATE game SET game_name='$game_name_modify', game_publisher='$game_publisher_modify', game_note=$game_note_modify, game_image='$target_file' WHERE game_id=$game_id_modify";

                    // Exécute la requête
                    if (mysqli_query($conn, $sql_update)) {
                        $message_update = "Les données du jeu ont été mises à jour avec succès.";
                    } else {
                        $message_update = "Erreur lors de la mise à jour des données du jeu : " . mysqli_error($conn);
                    }
                }
            }
        }
    } elseif (isset($_POST["supprimer"])) {
        $game_id_to_delete = intval($_POST["game_id_to_delete"]); 
        $sql_delete = "DELETE FROM game WHERE game_id=$game_id_to_delete";

        if (mysqli_query($conn, $sql_delete)) {
            $message_delete = "Le jeu a été supprimé avec succès.";
        } else {
            $message_delete = "Erreur lors de la suppression du jeu : " . mysqli_error($conn);
        }

    } elseif (isset($_POST["register"])) {

        $user_pseudo = $_POST['user_pseudo'];
        $user_email = $_POST['user_email'];
        $password = $_POST['password'];

        $check_sql = "SELECT user_id FROM user WHERE user_pseudo = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("s", $user_pseudo);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();

        if ($check_result->num_rows > 0) {
            echo '<div class="alert alert-danger" role="alert">Ce user_pseudo est déjà utilisé. Veuillez choisir un autre.</div>';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_sql = "INSERT INTO user (user_pseudo, user_email, user_password, user_creation) VALUES (?, ?, ?, NOW())";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->bind_param("sss", $user_pseudo, $user_email, $hashed_password);

            if ($insert_stmt->execute()) {
                echo '<div class="alert alert-success" role="alert">Inscription réussie. Vous pouvez maintenant vous connecter.</div>';
                $_SESSION['connected'] = true;
                $_SESSION['user_pseudo'] = $user_pseudo;
                $_SESSION['user_email'] = $user_email;
                header("Location: ./index.php"); 
                exit;
            } else {
                echo '<div class="alert alert-danger" role="alert">Erreur lors de l\'inscription. Veuillez réessayer.</div>';
            }
            $insert_stmt->close(); 
        }
        $check_stmt->close();
        $conn->close();
    }elseif (isset($_POST["login"])) {
        $user_pseudo = $_POST['pseudo_login'];
        $password = $_POST['password_login'];

        $sql = "SELECT user_id, user_pseudo, user_password FROM user WHERE user_pseudo = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user_pseudo);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $stored_password = $row['user_password'];

            if (password_verify($password, $stored_password)) {
               
                $_SESSION['connected'] = true;
                $_SESSION['user_pseudo'] = $user_pseudo;
                
                header("Location: index.php"); 
                exit;
            } else {
                echo '<div class="alert alert-danger" role="alert">Pseudo ou Mot de passe incorrect. Veuillez réessayer.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Pseudo ou Mot de passe incorrect. Veuillez réessayer.</div>';
        }

        $stmt->close();
    }
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
    $_SESSION['connected'] = false;
    $_SESSION['user_pseudo'] = null;
    $_SESSION['user_email'] = null;
    header("Location: connecte.php"); 
    exit;
}



function getUserProfile($conn, $user_pseudo) {
    $sql = "SELECT user_pseudo, user_email, user_level, user_creation FROM user WHERE user_pseudo = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("s", $user_pseudo);
        $stmt->execute();
        $stmt->bind_result($user_pseudo, $user_email, $user_level, $user_creation);
        $stmt->fetch();
        $stmt->close();
        return [$user_pseudo, $user_email, $user_level, $user_creation];
    } else {
        return null;
    }
}




?>
