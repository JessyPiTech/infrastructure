<?php
//connexion a la base de donnée
function connectDB() {  
    require_once "credentials.php";
    $conn = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);
    if ($conn->connect_error) {
        echo'Erreur de connexion à la base de données : " . $conn->connect_error"';
    }
    return $conn;
}

?>
