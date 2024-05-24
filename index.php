<?php //require_once "../connec.php";?>
<?php require_once "header.php";?>
<?php require_once "function.php";?>
<?php require_once "./connec.php";?>

<main>
    <div class="card-container">
        <?php while ($jeu = mysqli_fetch_assoc($resultat)): ?>
        <div class="card">
            <?php $image_url = !empty($jeu['game_image']) ? $jeu['game_image'] : 'https://placehold.co/300x300';?>
            <div class="card-img-container">
                <img class="card-img-top" src="<?php echo $image_url; ?>" alt="<?php echo $jeu['game_name']; ?>" onerror="this.onerror=null; this.src='https://placehold.co/300x300';">
                <div class="button-container">
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
                                    <button type="submit" class="btn btn-primary" name="modifier">Modifier</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Bouton de modification -->
                
                <div class="card-body">
                    <h5 class="card-title"><?php echo $jeu['game_name']; ?></h5>
                    <p class="card-text">Développeur: <?php echo $jeu['game_publisher']; ?></p>
                    <p class="card-text">Note: <?php echo $jeu['game_note']; ?>/5</p>
                </div>
            </div>    
        </div>
        <?php endwhile; ?>
    </div>
    <!-- Bouton d'ajout de jeu -->
    <span class="btn_add" class="btn_add" onclick="OpenModalAjout(<?php echo $jeu['game_id']; ?>)">
        <img  id="btn_add" src="asset/img/plus.png" alt="Bouton pour ajouter le jeu">
    </span>
    

    <!-- modale pour l'ajout-->
    <div id="addGameModal" class="modal">
        <div class="modal-content">
            <span id="closeButtonAdd" class="close" onclick="openConfirmationModalModif(<?php echo $jeu['game_id']; ?>)">&times;</span>
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

<script>
    
    
    
    function OpenModalAjout(gameId) {

        var addButton = document.getElementById("btn_add");
        closeButtonAdd.onclick = function() {
            modal.style.display = "none";
        }
        var closeButtonAdd = document.getElementById("closeButtonAdd");
        addButton.onclick = function() {
            modal.style.display = "block";
        }
        // Recup id addGameModal
        var modal = document.getElementById("addGameModal");
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
        
    }
    
    // Fonction pour masquer la fenêtre modale lorsqu'on clique en dehors de celle-ci
   
    function openConfirmationModalModif(gameId) {
        var closeButton3 = document.getElementById("closeModifModal");
        closeButton3.onclick = function() {
            modal.style.display = "none";
        }
        var modal = document.getElementById("confirmationModalModif");
        // Affichez la fenêtre modale
        modal.style.display = "block";
        // Fermez la fenêtre modale lorsqu'on clique en dehors de celle-ci
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }
    function openConfirmationModal(gameId) {
        var closeButton = document.getElementById("closeConfirmationModal");
        closeButton.onclick = function() {
            modal.style.display = "none";
        }
        var modal = document.getElementById("confirmationModal");
        var yesButton = document.getElementById("yesConfirmationModal");
        var noButton = document.getElementById("noConfirmationModal");
        // Mettez en place ici le comportement des boutons de confirmation
        yesButton.onclick = function() {
            
            // Vous pouvez implémenter ici la logique de suppression
            console.log("Suppression du jeu avec l'ID:", gameId);
            // Fermez la fenêtre modale après la suppression
            modal.style.display = "none";
        }
        
        noButton.onclick = function() {
            modal.style.display = "none"; // Fermez simplement la fenêtre modale si "non" est cliqué
        }
        // Affichez la fenêtre modale
        modal.style.display = "block";
        // Fermez la fenêtre modale lorsqu'on clique en dehors de celle-ci
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    }
    // Sélection de tous les éléments avec la classe 'img_stylo'
    var imgElements = document.querySelectorAll("#img_stylo");
    // Ajout d'un écouteur d'événements à chaque élément
    imgElements.forEach(function(img) {
        // Ajout d'un écouteur d'événements pour l'événement mouseover (survol)
        img.addEventListener("mouseover", function() {
            // Changer la source de l'image au survol
            this.src = "asset/img/icon-stylo-noir.png";
        });
        // Ajout d'un écouteur d'événements pour l'événement mouseout (sortie du survol)
        img.addEventListener("mouseout", function() {
            // Revenir à la source d'image par défaut lorsque le curseur sort de l'image
            this.src = "asset/img/icon-stylo-blanc.png";
        });
    }); 
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<?php require_once "footer.php";?>