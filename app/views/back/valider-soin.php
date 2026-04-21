<?php 
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('admin');
require_once ROOT_PATH . '/app/views/includes/header.php'; 

$id_rdv = $_GET['id'] ?? null;

if (!$id_rdv) {
    header('Location: index.php?page=dashboard');
    exit();
}

// Récupérer les infos du RDV pour savoir quel patient on traite
$stmt = $pdo->prepare("SELECT a.*, u.nom, u.prenom FROM appointments a JOIN users u ON a.user_id = u.id WHERE a.id = ?");
$stmt->execute([$id_rdv]);
$rdv = $stmt->fetch();
?>

<main>
    <div class="dashboard-header">
        <h2>Finaliser le soin</h2>
        <p>Patient : <strong><?php echo htmlspecialchars($rdv['nom'] . ' ' . $rdv['prenom']); ?></strong></p>
    </div>

    <section class="admin-section" style="max-width: 600px; margin: 0 auto;">
        <div class="card" style="padding: 20px; background: white; border-radius: 8px; border: 1px solid #ddd;">
            <form action="index.php?page=confirm-soin-valid" method="POST">
                <input type="hidden" name="id_rdv" value="<?php echo $rdv['id']; ?>">
                
                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Rappel du motif :</label>
                    <p><em><?php echo htmlspecialchars($rdv['description']); ?></em></p>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label for="notes_soin">Notes du Docteur (Soin effectué) :</label>
                    <textarea name="notes_soin" id="notes_soin" rows="5" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;" placeholder="Ex: Détartrage effectué, RAS..."></textarea>
                </div>

                <button type="submit" class="btn-submit">Valider et Archiver le soin</button>
                <a href="index.php?page=dashboard" style="display: block; text-align: center; margin-top: 10px; color: #666;">Annuler</a>
            </form>
        </div>
    </section>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>