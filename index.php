<?php //require_once "../connec.php";?>
<?php require_once "header.php";?>
<?php require_once "connec.php";?>
<?php require_once "function.php";?>


<main>
    <div class="card-container">
        <?php while ($jeu = mysqli_fetch_assoc($resultat)): ?>
        <div class="card">
            
            <?php $image_url = !empty($jeu['game_image']) ? $jeu['game_image'] : 'https://placehold.co/300x300';?>
            <div class="card-img-container">
                <img class="card-img-top" src="<?php echo $image_url; ?>" alt="<?php echo $jeu['game_name']; ?>" onerror="this.onerror=null; this.src='https://placehold.co/300x300';">
                <div class="button-container">
                    <!-- Span de supp -->
                    <span class="delete" onclick="openConfirmationModal(<?php echo $jeu['game_id']; ?>)">&times;</span>
                    <!-- Modal de supp -->
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
                    <!-- Span de modif -->
                    <span class="btn_modif" onclick="openConfirmationModalModif(<?php echo $jeu['game_id']; ?>)">
                        <img id="img_stylo" src="asset/img/icon-stylo-blanc.png" alt="Bouton pour modifier le jeu">
                    </span>
                    
                    <!-- Modal de modif -->
                    <div id="confirmationModalModif" class="modal">
                    
                        <div class="modal-content">
                            <!-- Bouton femeture modal -->
                            <span id="closeModifModal" class="close">&times;</span> 
                            <div>
                                <h2>Modifier un jeu</h2>
                                <!-- Formulaire de modification de jeu -->
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
                                        <input type="number" class="form-control" id="game_note_modify" name="game_note_modify" min="0" max="5" >
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
                <!-- donné du Jeu -->
                <div class="card-body">
                    <h5 class="card-title"><?php echo $jeu['game_name']; ?></h5>
                    <p class="card-text">Développeur: <?php echo $jeu['game_publisher']; ?></p>
                    <p class="card-text">Note: <?php echo $jeu['game_note']; ?>/5</p>
                    <p class="card-text">Date d'évaluation: <?php echo $jeu['game_evaluation_date']; ?></p>
                </div>
            </div>    
        </div>
        <?php endwhile; ?>
    </div>
    <!-- Span d'ajout de jeu -->
    <span class="btn_add" class="btn_add" onclick="OpenModalAjout()">
        <img  id="btn_add" src="asset/img/plus.png" alt="Bouton pour ajouter le jeu">
    </span>
    <!-- modale pour l'ajout-->
    <div id="addGameModal" class="modal">
        <div class="modal-content">
            <span id="closeButtonAdd" class="close" >&times;</span>
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
                    <input type="file" class="form-control" id="game_image" name="game_image" accept=".png, .jpg, .jpeg" onchange="validateFileType()">
                </div>
                
                <button type="submit" class="btn btn-primary" name="ajouter">Ajouter</button>
            </form>
        </div>
    </div>
</main>
<script src="./asset/js/scriptEdite.js"></script> 
    
<?php require_once "footer.php";?>