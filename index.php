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
            <!-- Bouton de suppression -->
            <span class="delete" onclick="openConfirmationModal(<?php echo $jeu['game_id']; ?>)">&times;</span>
            <!-- Bouton de modification -->
            <span class="btn_modif">
                <img class="img_stylo" src="asset/img/icon-stylo-blanc.png" alt="Bouton pour modifier le jeu">
            </span>
        </div>

        <div class="card-body">
            <h5 class="card-title"><?php echo $jeu['game_name']; ?></h5>
            <p class="card-text">Développeur: <?php echo $jeu['game_publisher']; ?></p>
            <p class="card-text">Note: <?php echo $jeu['game_note']; ?>/5</p>
        </div>
    </div>
        <?php endwhile; ?>
    </div>


    <!-- Bouton d'ajout de jeu -->
    <div id="btn_add" class="btn_add">
        <img  src="asset/img/plus.png" alt="Bouton pour modifier le jeu">
    </div>

    <!-- Fenêtre modale pour l'ajout de jeu -->
    <div id="addGameModal" class="modal">
        <div class="modal-content">

        <!--2-->
        <span id="azerty" class="close">&times;</span>
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
           
<script>
        // Obtenez la référence du bouton d'ajout
        var addButton = document.getElementById("btn_add");

        // Obtenez la référence de la fenêtre modale
        var modal = document.getElementById("addGameModal");

        // Obtenez la référence de l'élément de fermeture
        var closeButton2 = document.getElementById("azerty");

        // Fonction pour afficher la fenêtre modale
        addButton.onclick = function() {
            modal.style.display = "block";
        }

        // Fonction pour masquer la fenêtre modale lorsqu'on clique sur le bouton de fermeture
        closeButton2.onclick = function() {
            modal.style.display = "none";
        }

        // Fonction pour masquer la fenêtre modale lorsqu'on clique en dehors de celle-ci
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        function openConfirmationModal(gameId) {
    var modal = document.getElementById("confirmationModal");
    //1
    var closeButton = document.getElementById("closeConfirmationModal");
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

    // Fermez la fenêtre modale lorsqu'on clique sur le bouton de fermeture
    closeButton.onclick = function() {
        modal.style.display = "none";
    }

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
    </script>
                <button type="submit" class="btn btn-primary" name="ajouter">Ajouter</button>
            </form>
        </div>
    </div>
</main>

<?php require_once "footer.php";?>