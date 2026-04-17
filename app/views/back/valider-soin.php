<?php 
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('admin'); 

require_once ROOT_PATH . '/app/views/includes/header.php'; 

// Récupération de l'ID du RDV
$id_rdv = $_GET['id'] ?? null;

if (!$id_rdv) {
    die("ID du rendez-vous manquant.");
}

// Récupérer les détails du RDV pour savoir de quel patient on parle
$stmt = $pdo->prepare("SELECT a.*, u.nom, u.prenom FROM appointments a JOIN users u ON a.user_id = u.id WHERE a.id = ?");
$stmt->execute([$id_rdv]);
$rdv = $stmt->fetch();

if (!$rdv) {
    die("Rendez-vous introuvable.");
}
?>

<main>
    <div class="form-container">
        <h2>Valider le soin</h2>
        <p>Patient : <strong><?php echo htmlspecialchars($rdv['nom'] . ' ' . $rdv['prenom']); ?></strong></p>
        <p>Date : <?php echo date('d/m/Y', strtotime($rdv['date_rdv'])); ?></p>

        <form action="index.php?page=complete-soin" method="POST">
            <input type="hidden" name="id_rdv" value="<?php echo $rdv['id']; ?>">

            <div class="form-group">
                <label for="notes_soin">Soin effectué / Observations :</label>
                <textarea name="notes_soin" id="notes_soin" rows="5" required placeholder="Ex: Détartrage complet et vérification carie molaire gauche..."></textarea>
            </div>

            <button type="submit" class="btn-submit">Marquer comme terminé</button>
            <a href="index.php?page=dashboard" style="display: block; text-align: center; margin-top: 10px; color: #666; text-decoration: none;">Annuler</a>
        </form>
    </div>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>