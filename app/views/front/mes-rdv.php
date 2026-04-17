<?php 
// 1. On utilise ROOT_PATH pour les inclusions de sécurité et d'interface
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('patient'); 

require_once ROOT_PATH . '/app/views/includes/header.php'; 

// 2. $pdo est déjà chargé par l'index, mais on s'assure de sa disponibilité
$user_id = $_SESSION['user_id'];

// 3. On récupère les rendez-vous futurs (ceux qui sont 'prévu')
$query = $pdo->prepare("SELECT * FROM appointments WHERE user_id = ? AND status = 'prévu' ORDER BY date_rdv ASC");
$query->execute([$user_id]);
$appointments = $query->fetchAll();

// 4. On récupère l'historique (ceux qui sont 'effectué')
$query_hist = $pdo->prepare("SELECT * FROM appointments WHERE user_id = ? AND status = 'effectué' ORDER BY date_rdv DESC");
$query_hist->execute([$user_id]);
$history = $query_hist->fetchAll();
?>

<main>
    <div class="dashboard-header">
        <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_nom']); ?> !</h2>
        <?php if (isset($_GET['success'])): ?>
            <p style="color: green;">✅ Action réussie !</p>
        <?php endif; ?>
    </div>

    <section class="rdv-section">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h3>🗓️ Mes prochains rendez-vous</h3>
            <a href="index.php?page=prendre-rdv" class="btn-submit" style="width: auto; text-decoration: none; padding: 8px 15px;">+ Prendre RDV</a>
        </div>
        
        <?php if (count($appointments) > 0): ?>
            <div class="appointments-grid">
                <?php foreach ($appointments as $rdv): ?>
                    <div class="card" style="border: 1px solid #ddd; border-left: 5px solid #3498db; text-align: left; margin-bottom: 15px; position: relative; padding: 15px;">
                        <p><strong>Date :</strong> <?php echo date('d/m/Y', strtotime($rdv['date_rdv'])); ?></p>
                        <p><strong>Heure :</strong> <?php echo substr($rdv['heure_rdv'], 0, 5); ?></p>
                        <p><strong>Motif :</strong> <?php echo htmlspecialchars($rdv['description']) ?: 'Non précisé'; ?></p>
                        
                        <a href="index.php?page=cancel-rdv&id=<?php echo $rdv['id']; ?>" 
                           onclick="return confirm('Annuler ce rendez-vous ?')"
                           style="color: #e74c3c; font-size: 0.8rem; text-decoration: none; position: absolute; top: 10px; right: 10px;">
                           ❌ Annuler
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="card" style="text-align: center; border: 1px dashed #ccc; padding: 20px;">
                <p>Aucun rendez-vous à venir.</p>
            </div>
        <?php endif; ?>
    </section>

    <section class="rdv-section" style="margin-top: 40px;">
        <h3>🦷 Mon historique de soins</h3>
        <table style="width: 100%; border-collapse: collapse; margin-top: 15px; background: white; border-radius: 8px; overflow: hidden;">
            <thead>
                <tr style="background: #2c3e50; color: white;">
                    <th style="padding: 12px; text-align: left;">Date</th>
                    <th style="padding: 12px; text-align: left;">Soin effectué</th>
                    <th style="padding: 12px; text-align: left;">Praticien</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($history) > 0): 
                    foreach ($history as $soin): ?>
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;"><?php echo date('d/m/Y', strtotime($soin['date_rdv'])); ?></td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;"><strong><?php echo htmlspecialchars($soin['notes_soin']); ?></strong></td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;">Dr. Dupont</td>
                        </tr>
                    <?php endforeach; 
                else: ?>
                    <tr>
                        <td colspan="3" style="padding: 20px; text-align: center; color: #999;">Aucun soin passé enregistré.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>