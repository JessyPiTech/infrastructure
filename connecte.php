<?php
    session_start(); // Démarre la session
    echo "you are not already connecte";
    $connect = isset($_SESSION['connect']) ? $_SESSION['connect'] : null;
    echo $connect;
    if ($connect == true){
        echo "you are already connecte";
        // Redirection vers la page projet-PHP.php
        header("Location: index.php");
        exit; // Assure que le script s'arrête après la redirection
    }
?>

<main>
<div class="container">
            <form method="post">
                <div class="form-group">
                    <label for="code_saisi">Entrez le code de vérification :</label>
                    <input type="text" class="form-control" id="code_saisi" name="code_saisi" required>
                </div>
                <button type="submit" class="btn btn-primary">Vérifier le code</button>
            </form>
            <?php
            session_start(); // Démarre la session

            // Récupérer le code de vérification depuis la session
            $code_verification = 'admin';
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Récupérer le code saisi par l'utilisateur
                $code_saisi = $_POST['code_saisi'];
               
                // Vérifier si le code saisi correspond au code de la session
                if ($code_saisi == $code_verification) {
                    $connect = true;
                    $_SESSION['connect'] = $connect;
                    // Redirection si le code est correct
                    header("Location: index.php");
                    exit; // Assure que le script s'arrête après la redirection
                } else {
                    echo '<div class="alert alert-danger" role="alert">Le code saisi est incorrect. Veuillez réessayer.</div>';
                }
            }
            ?>
        </div>
</main>

