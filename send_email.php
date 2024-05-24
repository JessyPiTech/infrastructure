<?php

//verifi dans les spam
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = filter_var($_POST['to'], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING);
    //mail envoyeur
    
    $headers = "From:  $user_email"; 

    if (mail($to, $subject, $message, $headers)) {
        header("Location: contacte.php?success=1");
    } else {
        header("Location: contacte.php?error=1");
    }
    exit;
}
?>