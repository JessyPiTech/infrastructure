function OpenModalAjout() {
    var modal = document.getElementById("addGameModal");
    var addButton = document.getElementById("btn_add");
    addButton.onclick = function() {
        modal.style.display = "block";
    }
    var closeButtonAdd = document.getElementById("closeButtonAdd");
    closeButtonAdd.onclick = function() {
        modal.style.display = "none";
    }
    // Recup id addGameModal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function openConfirmationModalModif(gameId) {
    var modal = document.getElementById("confirmationModalModif");
    document.getElementById("game_id_modify").value = gameId;
    modal.style.display = "block";
    var closeButton3 = document.getElementById("closeModifModal");
    closeButton3.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

function openConfirmationModal(gameId) {
    var modal = document.getElementById("confirmationModal");
    var yesButton = document.getElementById("yesConfirmationModal");
    var noButton = document.getElementById("noConfirmationModal");
    document.getElementById("game_id_to_delete").value = gameId;
    modal.style.display = "block";
    var closeButton = document.getElementById("closeConfirmationModal");
    closeButton.onclick = function() {
        modal.style.display = "none";
    }
    yesButton.onclick = function() {
        console.log("Suppression du jeu avec l'ID:", gameId);
        modal.style.display = "none";
    }
    noButton.onclick = function() {
        modal.style.display = "none";
    }
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

var imgElements = document.querySelectorAll("#img_stylo");
imgElements.forEach(function(img) {
    img.addEventListener("mouseover", function() {
        this.src = "asset/img/icon-stylo-noir.png";
    });
    img.addEventListener("mouseout", function() {
        this.src = "asset/img/icon-stylo-blanc.png";
    });
}); 