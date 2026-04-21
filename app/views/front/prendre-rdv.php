<?php 
// Sécurité : Seuls les patients connectés peuvent accéder à cette page
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('patient'); // ou 'user' selon ton nommage de rôle

require_once ROOT_PATH . '/app/views/includes/header.php'; 

// 1. Récupération des services pour alimenter le menu déroulant
$stmt = $pdo->query("SELECT id, nom, prix, duree_minutes FROM services ORDER BY nom ASC");
$services = $stmt->fetchAll();
?>

<main class="container">
    <div class="booking-section">
        <h2>📅 Prendre un rendez-vous</h2>
        <p>Sélectionnez le soin souhaité et choisissez votre créneau.</p>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'deja_pris'): ?>
            <div class="alert alert-danger" style="color: #e74c3c; background: #fdeaea; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
                ⚠️ Ce créneau est déjà réservé. Veuillez choisir une autre heure ou une autre date.
            </div>
        <?php endif; ?>

        <div class="card shadow" style="max-width: 600px; margin: 0 auto; padding: 30px; background: white; border-radius: 12px;">
            <form action="index.php?page=confirm-booking" method="POST">
                
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="service_id">Type de consultation :</label>
                    <select name="service_id" id="service_id" required style="width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #ddd;">
                        <option value="">-- Choisissez un soin --</option>
                        <?php foreach ($services as $s): ?>
                            <option value="<?php echo $s['id']; ?>">
                                <?php echo htmlspecialchars($s['nom']); ?> (<?php echo $s['prix']; ?>€ - <?php echo $s['duree_minutes']; ?>min)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="date_rdv">Date souhaitée :</label>
                    <input type="date" name="date_rdv" id="date_rdv" 
                           min="<?php echo date('Y-m-d'); ?>" 
                           required style="width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #ddd;">
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="heure_rdv">Heure :</label>
                    <select name="heure_rdv" id="heure_rdv" required style="width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #ddd;">
                        <option value="">-- Sélectionnez une heure --</option>
                        <option value="09:00">09:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                    </select>
                    <small style="color: #666;">Le cabinet est ouvert de 9h à 12h et de 14h à 17h.</small>
                </div>

                <div class="form-group" style="margin-bottom: 25px;">
                    <label for="description">Informations complémentaires (optionnel) :</label>
                    <textarea name="description" id="description" rows="3" placeholder="Ex: Douleur intense, premier contrôle..." style="width: 100%; padding: 12px; border-radius: 6px; border: 1px solid #ddd;"></textarea>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; padding: 15px; background: #2c3e50; color: white; border: none; border-radius: 6px; cursor: pointer; font-size: 1.1rem;">
                    Confirmer le rendez-vous
                </button>
            </form>
        </div>
    </div>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>