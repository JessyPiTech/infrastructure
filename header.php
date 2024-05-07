<?php
// Start or resume the session
session_start();
if (!isset($_SESSION['connect']) || !$_SESSION['connect']) {
    header("Location: connecte.php"); 
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceuill</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="asset/css/style.css">
</head>
<body>
<header style="background-color: black;" >
    <center>
        <nav style="display: flex;width: 80%;flex-direction: row;align-items: center;margin-top: none;padding: 1%;">
            <a href="index.php"><img height="30" src="asset/img/logo.png" alt="logo"></a>
            <div style="display: flex;justify-content: space-evenly;align-items: center;flex-direction: row;width: 100%;margin: none;margin-top: none;">
                <a href="index.php">acceuill</a>
                <a href="connecte.php">verif emploie</a>
                <a href="page.php">redirection</a>
            </div>
        </nav>
    </center>
</header>