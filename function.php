<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once "coDB.php";
$conn = connectDB();

$message_insert = '';
$message_update = '';
$message_delete = '';

$sql = "UPDATE game g
JOIN (
    SELECT game_id, ROUND(AVG(avis_note) * 2) / 2 as moyenne_note
    FROM avis
    GROUP BY game_id
) as notes_moyennes
ON g.game_id = notes_moyennes.game_id
SET g.game_note = notes_moyennes.moyenne_note";

if ($conn->query($sql) !== TRUE) {
    echo "Erreur de mise à jour: " . $conn->error;
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["ajouter"])) {
        $game_name = $_POST["game_name"];
        $game_publisher = $_POST["game_publisher"];
        $game_note = floatval($_POST["game_note"]);

        if ($_FILES['game_image']['error'] !== UPLOAD_ERR_OK) {
            $message_insert = "Erreur lors de l'envoi du fichier.";
        } else {
            $file_extension = pathinfo($_FILES["game_image"]["name"], PATHINFO_EXTENSION);
            $file_mime_type = mime_content_type($_FILES["game_image"]["tmp_name"]);
            
            if ($file_mime_type == 'image/svg+xml' || $file_extension == 'svg' || strpos($file_extension, 'svg.') !== false) {
                $message_insert = "Les fichiers SVG et les fichiers ayant 'svg' dans leur extension ne sont pas autorisés.";
            } else {
                $target_dir = "uploads/";
                $target_file = $target_dir . basename($_FILES["game_image"]["name"]);
                
                if (!move_uploaded_file($_FILES["game_image"]["tmp_name"], $target_file)) {
                    $message_insert = "Erreur lors de l'enregistrement de l'image.";
                } else {
                    $stmt = $conn->prepare("INSERT INTO game (game_name, game_publisher, game_note, game_date_create, game_image) VALUES (?, ?, ?, NOW(), ?)");
                    $stmt->bind_param("ssis", $game_name, $game_publisher, $game_note, $target_file);
                    
                    if ($stmt->execute()) {
                        $message_insert = "Le jeu a été ajouté avec succès.";
                    } else {
                        $message_insert = "Erreur lors de l'ajout du jeu : " . $stmt->error;
                    }
                    $stmt->close();
                }
            }
        }
    } elseif (isset($_POST["modifier"])) {
        $game_id_modify = intval($_POST["game_id_modify"]);
        $game_name_modify = $_POST["game_name_modify"];
        $game_publisher_modify = $_POST["game_publisher_modify"];
        $game_note_modify = floatval($_POST["game_note_modify"]);

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
                    $stmt = $conn->prepare("UPDATE game SET game_name=?, game_publisher=?, game_note=?, game_image=? WHERE game_id=?");
                    $stmt->bind_param("ssisi", $game_name_modify, $game_publisher_modify, $game_note_modify, $target_file, $game_id_modify);
                    
                    if ($stmt->execute()) {
                        $message_update = "Les données du jeu ont été mises à jour avec succès.";
                    } else {
                        $message_update = "Erreur lors de la mise à jour des données du jeu : " . $stmt->error;
                    }
                    $stmt->close();
                }
            }
        }
    } elseif (isset($_POST["supprimer"])) {
        $game_id_to_delete = intval($_POST["game_id_to_delete"]);
        $stmt = $conn->prepare("DELETE FROM game WHERE game_id=?");
        $stmt->bind_param("i", $game_id_to_delete);
        
        if ($stmt->execute()) {
            $message_delete = "Le jeu a été supprimé avec succès.";
        } else {
            $message_delete = "Erreur lors de la suppression du jeu : " . $stmt->error;
        }
        $stmt->close();
    } elseif (isset($_POST["register"])) {
        $user_pseudo = $_POST['user_pseudo'];
        $user_email = $_POST['user_email'];
        $password = $_POST['password'];

        $stmt = $conn->prepare("SELECT user_id FROM user WHERE user_pseudo = ?");
        $stmt->bind_param("s", $user_pseudo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo '<div class="alert alert-danger" role="alert">Ce user_pseudo est déjà utilisé. Veuillez choisir un autre.</div>';
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->close();
            
            $stmt = $conn->prepare("INSERT INTO user (user_pseudo, user_email, user_password, user_creation) VALUES (?, ?, ?, NOW())");
            $stmt->bind_param("sss", $user_pseudo, $user_email, $hashed_password);
            
            if ($stmt->execute()) {
                $user_id = $conn->insert_id;
                echo '<div class="alert alert-success" role="alert">Inscription réussie. Vous pouvez maintenant vous connecter.</div>';

                $_SESSION['connected'] = true;
                $_SESSION['user_pseudo'] = $user_pseudo;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_email'] = $user_email;

                header("Location: ./index.php");
                exit;
            } else {
                echo '<div class="alert alert-danger" role="alert">Erreur lors de l\'inscription. Veuillez réessayer.</div>';
            }
            $stmt->close();
        }
        $stmt->close();
        $conn->close();
    } elseif (isset($_POST["login"])) {
        $user_pseudo = $_POST['pseudo_login'];
        $password = $_POST['password_login'];

        $stmt = $conn->prepare("SELECT user_id, user_pseudo, user_password FROM user WHERE user_pseudo = ? LIMIT 1");
        $stmt->bind_param("s", $user_pseudo);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['user_password'])) {
                $_SESSION['connected'] = true;
                $_SESSION['user_pseudo'] = $row['user_pseudo'];
                $_SESSION['user_id'] = $row['user_id'];

                header("Location: index.php");
                exit;
            } else {
                echo '<div class="alert alert-danger" role="alert">Pseudo ou Mot de passe incorrect. Veuillez réessayer.</div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">Pseudo ou Mot de passe incorrect. Veuillez réessayer.</div>';
        }
        $stmt->close();
    } elseif (isset($_POST["avis"])) {
        $avis_message = $_POST['avis_message'];
        $avis_note = floatval($_POST['avis_note']);
        $game_id = intval($_POST['game_id']);
        $user_id = $_SESSION['user_id'];
        $user_pseudo = $_SESSION['user_pseudo'];

        if ($game_id && $user_id && $user_pseudo && $avis_message && $avis_note >= 0 && $avis_note <= 5) {
            $stmt = $conn->prepare("INSERT INTO avis (user_id, user_pseudo, game_id, avis_message, avis_note, avis_date) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->bind_param("isiss", $user_id, $user_pseudo, $game_id, $avis_message, $avis_note);

            if ($stmt->execute()) {
                header("Location: jeu.php?game=" . $game_id);
                exit;
            } else {
                echo "Erreur lors de l'ajout de l'avis.";
            }
            $stmt->close();
        } else {
            echo "Données invalides.";
        }
    }
    $conn->close();
}

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
    session_destroy();
    header("Location: connecte.php");
    exit;
}


function recupeJeu($conn){
    $sql_select = "SELECT * FROM game";
    $stmt = $conn->prepare($sql_select);
    $stmt->execute();
    $resultat = $stmt->get_result();
    $stmt->close();
    return $resultat;
}

function getUserProfile($conn, $user_pseudo) {
    $stmt = $conn->prepare("SELECT user_pseudo, user_id, user_email, user_level, user_creation FROM user WHERE user_pseudo = ?");
    $stmt->bind_param("s", $user_pseudo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user_profile = $result->fetch_assoc();
    } else {
        $user_profile = null;
    }
    
    $stmt->close();
    return $user_profile;
}
?>

