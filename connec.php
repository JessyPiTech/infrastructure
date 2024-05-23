<?php

if (!isset($_SESSION['connected']) || !$_SESSION['connected']) {
    header("Location: ./connecte.php"); 
    exit(); 
}
?>