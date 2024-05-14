

<?php require_once "function.php";?>
<?php require_once "header.php";?>

<main class="container mt-5">
    <div class="container mt-5">
        <h2>Liste des jeux</h2>
        <div class="row">
            <?php while ($jeu = mysqli_fetch_assoc($resultat)): ?>
                <div class="col-md-4">
                    <div class="card">
                        <img class="card-img-top" src="<?php echo $jeu['game_image']; ?>" alt="<?php echo $jeu['game_name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $jeu['game_name']; ?></h5>
                            <p class="card-text">Développeur: <?php echo $jeu['game_publisher']; ?></p>
                            <p class="card-text">Note: <?php echo $jeu['game_note']; ?>/5</p>
                            <p class="card-text">Id: <?php echo $jeu['game_id']; ?></p>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    <div class="container mt-5">
        <h2>Ajouter un jeu</h2>
        <!-- Formulaire d'ajout de jeu -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="game_name">Nom du jeu:</label>
                <input type="text" class="form-control" id="game_name" name="game_name">
            </div>
            <div class="form-group">
                <label for="game_publisher">Développeur du jeu:</label>
                <input type="text" class="form-control" id="game_publisher" name="game_publisher">
            </div>
            <div class="form-group">
                <label for="game_note">Note du jeu:</label>
                <input type="number" class="form-control" id="game_note" name="game_note" min="0" max="5">
            </div>
            <div class="form-group">
                <label for="game_image">Image du jeu:</label>
                <input type="file" class="form-control" id="game_image" name="game_image">
            </div>
            <button type="submit" class="btn btn-primary" name="ajouter">Ajouter</button>
        </form>
    </div>

    <div class="container mt-5">
    <h2>Modifier un jeu</h2>
    <!-- Formulaire de modification de jeu -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="game_id_modify">ID du jeu à modifier:</label>
            <input type="text" class="form-control" id="game_id_modify" name="game_id_modify">
        </div>

        
                <div class="form-group">
                    <label for="game_name_modify">Nom du jeu:</label>
                    <input type="text" class="form-control" id="game_name_modify" name="game_name_modify" >
                </div>
                <div class="form-group">
                    <label for="game_publisher_modify">Développeur du jeu:</label>
                    <input type="text" class="form-control" id="game_publisher_modify" name="game_publisher_modify" >
                </div>
                <div class="form-group">
                    <label for="game_note_modify">Note du jeu:</label>
                    <input type="number" class="form-control" id="game_note_modify" name="game_note_modify" min="0" max="5" >
                </div>
                <div class="form-group">
                    <label for="game_image_modify">Image du jeu:</label>
                    <input type="file" class="form-control" id="game_image_modify" name="game_image_modify">
                </div>
                <?php
        // Vérifier si l'ID du jeu à modifier est soumis
        if (isset($_POST["game_id_modify"])) {
            // Récupérer l'ID du jeu à partir du formulaire
            $game_id_to_modify = intval($_POST["game_id_modify"]);
            // Requête SQL pour récupérer les informations du jeu à modifier
            $sql_select_game_to_modify = "SELECT * FROM video_game WHERE game_id = $game_id_to_modify";
            $result_game_to_modify = mysqli_query($connexion, $sql_select_game_to_modify);
            // Vérifier si des données sont retournées
            if (mysqli_num_rows($result_game_to_modify) > 0) {
                // Récupérer les données du jeu
                $game_to_modify = mysqli_fetch_assoc($result_game_to_modify);
        ?>
        <?php
            } else {
                echo "Aucun jeu trouvé avec l'ID spécifié.";
            }
        }
        ?>
        <button type="submit" class="btn btn-primary" name="modifier">Modifier</button>
    </form>
</div>

    <div class="container mt-5">
        <h2>Supprimer un jeu</h2>
        <!-- Formulaire de suppression de jeu -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="game_id_to_delete">ID du jeu à supprimer:</label>
                <input type="text" class="form-control" id="game_id_to_delete" name="game_id_to_delete">
            </div>
            <button type="submit" class="btn btn-danger" name="supprimer">Supprimer</button>
        </form>
    </div>

    <div class="container mt-3">
        <!-- Affichage des messages -->
        <?php if (isset($message_insert) || isset($message_update) || isset($message_delete)): ?>
            <div class="alert <?php echo (isset($message_insert) && strpos($message_insert, 'succès') !== false) || (isset($message_update) && strpos($message_update, 'succès') !== false) || (isset($message_delete) && strpos($message_delete, 'succès') !== false) ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                <?php echo isset($message_insert) ? $message_insert : ''; ?>
                <?php echo isset($message_update) ? $message_update : ''; ?>
                <?php echo isset($message_delete) ? $message_delete : ''; ?>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php require_once "footer.php";?>