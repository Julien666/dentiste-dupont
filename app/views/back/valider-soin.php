<?php 
require_once '../includes/auth_guard.php';
protect_page('admin'); // Sécurité : seul l'admin peut voir cette page

require_once '../includes/header.php'; 
?>

<main>
    <div class="form-container" style="max-width: 600px; margin: 50px auto; padding: 20px; background: white; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
        <h2 style="color: var(--dark-navy); margin-bottom: 20px;">🩺 Valider le soin</h2>
        
        <form action="/dentiste-dupont/app/controllers/CompleteAppointmentController.php" method="POST">
            <input type="hidden" name="appointment_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
            
            <div class="form-group" style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold;">Compte-rendu de l'intervention :</label>
                <textarea name="notes_soin" rows="6" required 
                          placeholder="Ex: Détartrage effectué, pas de caries détectées. Prévoir contrôle dans 6 mois."
                          style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 5px; font-family: inherit;"></textarea>
            </div>

            <div style="display: flex; gap: 10px;">
                <button type="submit" class="btn-submit" style="flex: 2;">✅ Enregistrer et marquer comme terminé</button>
                <a href="dashboard.php" style="flex: 1; text-align: center; text-decoration: none; background: #95a5a6; color: white; padding: 12px; border-radius: 5px;">Annuler</a>
            </div>
        </form>
    </div>
</main>

<?php require_once '../includes/footer.php'; ?>