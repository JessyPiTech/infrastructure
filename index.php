<?php //require_once "../connec.php"; ?>
<?php require_once "header.php"; ?>
<?php require_once "connec.php"; ?>
<?php require_once "function.php"; ?>
<?php
    $resultat = recupeJeu($conn);
?>

<main class="flex-base">
    <jeux class="card-container flex-base-2">
        <?php while ($jeu = $resultat->fetch_assoc()): ?>
            <div id="jeu-<?php echo htmlspecialchars($jeu['game_id']); ?>" class="card">
                <a href="./jeu.php?game=<?php echo htmlspecialchars($jeu['game_id']); ?>">
                    <h2><?php echo htmlspecialchars($jeu['game_name']); ?></h2>
                    <?php $image_url = !empty($jeu['game_image']) ? htmlspecialchars($jeu['game_image']) : 'https://placehold.co/300x300'; ?>
                    <img class="card-img-top" src="<?php echo $image_url; ?>" alt="<?php echo htmlspecialchars($jeu['game_name']); ?>" onerror="this.onerror=null; this.src='https://placehold.co/300x300';">
                </a>
                <div class="button-container">
                    <span class="delete flex-base-2" onclick="openConfirmationModal(<?php echo htmlspecialchars($jeu['game_id']); ?>)">&times;</span>
                    <div id="confirmationModal" class="modal">
                        <div class="modal-content">
                            <span id="closeConfirmationModal" class="close">&times;</span>
                            <h2>Confirmer la suppression</h2>
                            <p>Êtes-vous sûr de vouloir supprimer ce jeu?</p>
                            <div>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                    <input type="hidden" class="form-control" id="game_id_to_delete" name="game_id_to_delete" value="<?php echo $jeu['game_id']; ?>">
                                    <button type="submit" id="yesConfirmationModal" class="btn btn-danger" name="supprimer">Oui</button>   
                                </form>
                                <button id="noConfirmationModal" class="btn btn-secondary">Non</button>
                            </div>
                        </div>
                    </div>
                    <span class="btn_modif flex-base-2" onclick="openConfirmationModalModif(<?php echo htmlspecialchars($jeu['game_id']); ?>)">
                        <img id="img_stylo" src="asset/img/icon-stylo-blanc.png" alt="Bouton pour modifier le jeu">
                    </span>
                    <div id="confirmationModalModif" class="modal">
                        <div class="modal-content">
                            <span id="closeModifModal" class="close">&times;</span> 
                            <div>
                                <h2>Modifier un jeu</h2>
                                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                                    <input type="hidden" class="form-control" id="game_id_modify" name="game_id_modify" value="<?php echo $jeu['game_id']; ?>">
                                    <div class="form-group">
                                        <label for="game_name_modify">Nom du jeu:</label>
                                        <input type="text" class="form-control" id="game_name_modify" name="game_name_modify"  >
                                    </div>
                                    <div class="form-group">
                                        <label for="game_publisher_modify">Développeur du jeu:</label>
                                        <input type="text" class="form-control" id="game_publisher_modify" name="game_publisher_modify" >
                                    </div>
                                    <div class="form-group">
                                        <label for="game_note_modify">Note du jeu:</label>
                                        <input type="number" class="form-control" id="game_note_modify" name="game_note_modify" min="0" max="5" step="0.5">
                                    </div>
                                    <div class="form-group">
                                        <label for="game_image_modify">Image du jeu:</label>
                                        <input type="file" class="form-control" id="game_image_modify" name="game_image_modify"  >
                                    </div>
                                    <button type="submit" class="btn btn-primary" name="modifier">Modifier</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="./jeu.php?game=<?php echo htmlspecialchars($jeu['game_id']); ?>">
                    <div id="rating-system-<?php echo htmlspecialchars($jeu['game_id']); ?>" class="etoiles" data-note="<?php echo htmlspecialchars($jeu['game_note']); ?>">
                        <div class="etoile" data-value="1"></div>
                        <div class="etoile" data-value="2"></div>
                        <div class="etoile" data-value="3"></div>
                        <div class="etoile" data-value="4"></div>
                        <div class="etoile" data-value="5"></div>
                    </div>
                    <div id="game-note-<?php echo htmlspecialchars($jeu['game_id']); ?>">
                        <?php echo htmlspecialchars($jeu['game_note']); ?>
                    </div>
                </a>
            </div>
        <?php endwhile; ?>
    </jeux>
    <span class="btn_add flex-base-2"  onclick="OpenModalAjout()">
        <img  id="btn_add" src="asset/img/plus.png" alt="Bouton pour ajouter le jeu">
    </span>
    <div id="addGameModal" class="modal">
        <div class="modal-content">
            <span id="closeButtonAdd" class="close" >&times;</span>
            <h2>Ajouter un jeu</h2>
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
                    <input type="number" class="form-control" id="game_note" name="game_note" min="0" max="5" step="0.5">
                </div>
                <div class="form-group">
                    <label for="game_image">Image du jeu:</label>
                    <input type="file" class="form-control" id="game_image" name="game_image" accept=".png, .jpg, .jpeg" onchange="validateFileType()">
                </div>
                
                <button type="submit" class="btn btn-primary" name="ajouter">Ajouter</button>
            </form>
        </div>
    </div>
</main>

<?php require_once "footer.php"; ?>
<script src="./asset/js/scriptEdite.js"></script> 
<script src="./asset/js/scriptEtoile.js"></script>