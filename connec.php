<?php
// Start or resume the session
session_start();
if (!isset($_SESSION['connected']) || !$_SESSION['connected']) {
    header("Location: ./connecte.php"); 
    exit(); 
}
?>