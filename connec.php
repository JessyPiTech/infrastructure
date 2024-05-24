<?php

//verification de si on est connecter ou pas dans les coockies
if (!isset($_SESSION['connected']) || !$_SESSION['connected']) {
    header("Location: ./connecte.php"); 
    exit(); 
}
?>