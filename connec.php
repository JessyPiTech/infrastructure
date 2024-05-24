<?php
if (session_status() == PHP_SESSION_NONE) {
    // Si aucune session n'est démarrée, démarrer une session
    session_start();
}
//verification de si on est connecter ou pas dans les coockies
if (!isset($_SESSION['connected']) || !$_SESSION['connected']) {
    header("Location: ./connecte.php"); 
    exit(); 
}
?>