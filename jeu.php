<?php //require_once "../connec.php"; ?>
<?php
require_once "header.php";
require_once "connec.php";
require_once "function.php";

$game_id = isset($_GET['game']) ? intval($_GET['game']) : null;

if ($game_id) {
    $stmt = $conn->prepare("SELECT * FROM game WHERE game_id = ? LIMIT 1");
    $stmt->bind_param("i", $game_id);
    $stmt->execute();
    $resultat = $stmt->get_result();

    if ($game_details = $resultat->fetch_assoc()) {
        $game_name = $game_details['game_name'];
        $game_publisher = $game_details['game_publisher'];
        $game_note = $game_details['game_note'];
        $game_high_score = $game_details['game_high_score'];
        $game_image = $game_details['game_image'];
    } else {
        echo "Le jeu sélectionné n'existe pas.";
        exit; 
    }
    $stmt->close(); 
    
    $stmt_avis = $conn->prepare("SELECT * FROM avis WHERE game_id = ? ORDER BY avis_date DESC");
    $stmt_avis->bind_param("i", $game_id);
    $stmt_avis->execute();
    $avis_resultat = $stmt_avis->get_result();

    $avis_list = [];
    while ($avis = $avis_resultat->fetch_assoc()) {
        $avis_list[] = $avis;
    }

    $stmt_avis->close(); 
} else {
    echo "Identifiant de jeu non spécifié.";
    exit; 
}
?>
<main class="flex-base">
    <jeu class="flex-base">
        <game></game>
        <div class="info-jeu flex-base">
            <h2><?php echo htmlspecialchars($game_name); ?></h2>
            <img src="<?php echo htmlspecialchars($game_image); ?>" alt="<?php echo htmlspecialchars($game_name); ?>">
            <p>Éditeur: <?php echo htmlspecialchars($game_publisher); ?></p>
            <p>Note: <?php echo htmlspecialchars($game_note); ?>/5</p>
            <p>Meilleur score: <?php echo htmlspecialchars($game_high_score); ?></p>
        </div>
        <avis class="flex-base">
            <div class="avis flex-base">
                <h3>Laisser un avis</h3>
                
                <form class="flex-base" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <input type="hidden" name="game_id" value="<?php echo $game_id; ?>">
                    <label for="avis_message">Votre avis:</label>
                    <textarea name="avis_message" id="avis_message" rows="4" required></textarea>
                    <label for="avis_note">Note (sur 5):</label>
                    <input type="number" name="avis_note" id="avis_note" min="0" max="5" step="0.5" required>
                    <button type="submit" class="btn btn-primary" name="avis">Ajouter</button>
                </form>

                
            </div>
            <h3>Avis des utilisateurs</h3>
            <ul class="avis-list">
                <?php foreach ($avis_list as $avis): ?>
                    <li class="avis-item">
                        <p><strong><?php echo htmlspecialchars($avis['user_pseudo']); ?></strong></p>
                        <p><?php echo htmlspecialchars($avis['avis_message']); ?></p>
                        <div id="rating-system-<?php echo $avis['avis_id']; ?>" class="etoiles" data-note="<?php echo $avis['avis_note']; ?>">
                            <div class="etoile" data-value="1"></div>
                            <div class="etoile" data-value="2"></div>
                            <div class="etoile" data-value="3"></div>
                            <div class="etoile" data-value="4"></div>
                            <div class="etoile" data-value="5"></div>
                        </div>
                        <div id="game-note-<?php echo $avis['avis_id']; ?>">
                            <?php echo htmlspecialchars($avis['avis_note']); ?>
                        </div>
                        
                        <p><em><?php echo htmlspecialchars($avis['avis_date']); ?></em></p>
                    </li>
                <?php endforeach; ?>
            </ul>
        </avis>
    </jeu>
</main>
<?php require_once "footer.php"; ?>
<script src="./asset/js/scriptEtoile.js"></script>