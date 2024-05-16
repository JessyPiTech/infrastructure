<?php
// Start or resume the session
session_start();
if (!isset($_SESSION['connect']) || !$_SESSION['connect']) {
    header("Location: connecte.php"); 
    exit(); 
}
?>