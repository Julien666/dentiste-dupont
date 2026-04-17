<?php 
require_once '../includes/auth_guard.php';
protect_page('admin'); 
require_once '../../../config/db.php';
require_once '../includes/header.php'; 

$search = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($search)) {
    $sql = "SELECT a.*, u.nom, u.prenom 
            FROM appointments a 
            JOIN users u ON a.user_id = u.id 
            WHERE u.nom LIKE ? 
            ORDER BY a.date_rdv ASC, a.heure_rdv ASC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%$search%"]);
} else {
    $sql = "SELECT a.*, u.nom, u.prenom 
            FROM appointments a 
            JOIN users u ON a.user_id = u.id 
            ORDER BY a.date_rdv ASC, a.heure_rdv ASC";
    $stmt = $pdo->query($sql);
}

$all_appointments = $stmt->fetchAll();
?>

<main>
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h2>Espace Administrateur - Dr. Dupont</h2>
        <div>
            <?php if(!empty($search)): ?>
                <a href="dashboard.php" style="text-decoration:none; font-size:0.8rem; margin-right:10px; color: #7f8c8d;">❌ Effacer le filtre</a>
            <?php endif; ?>
            <span style="background: #e74c3c; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.8rem;">Mode Admin</span>
        </div>
    </div>

    <section class="rdv-section">
        <h3>📋 <?php echo !empty($search) ? "Rendez-vous de " . htmlspecialchars($search) : "Liste globale des rendez-vous"; ?></h3>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px; background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background: #2c3e50; color: white;">
                    <th style="padding: 12px; text-align: left;">Date</th>
                    <th style="padding: 12px; text-align: left;">Heure</th>
                    <th style="padding: 12px; text-align: left;">Patient</th>
                    <th style="padding: 12px; text-align: left;">Description</th>
                    <th style="padding: 12px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($all_appointments as $rdv): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;"><?php echo date('d/m/Y', strtotime($rdv['date_rdv'])); ?></td>
                    
                    <td style="padding: 12px;"><?php echo date('H:i', strtotime($rdv['heure_rdv'])); ?></td>
                    
                    <td style="padding: 12px;"><strong><?php echo htmlspecialchars($rdv['nom'] . ' ' . $rdv['prenom']); ?></strong></td>
                    
                    <td style="padding: 12px; font-style: italic; color: #7f8c8d;">
                        <?php echo !empty($rdv['description']) ? htmlspecialchars($rdv['description']) : 'Aucune description'; ?>
                    </td>
                    
                    <td style="padding: 12px; text-align: center;">
                        <?php if ($rdv['status'] === 'prévu'): ?>
                            <a href="valider-soin.php?id=<?php echo $rdv['id']; ?>" 
                               style="text-decoration: none; background-color: #2ecc71; color: white; padding: 6px 12px; border-radius: 4px; font-size: 0.85rem;">
                               ✅ Valider
                            </a>
                        <?php else: ?>
                            <span style="color: #27ae60; font-weight: bold;">✔️ Effectué</span>
                        <?php endif; ?>
                        
                        <a href="../../controllers/AdminDeleteRDV.php?id=<?php echo $rdv['id']; ?>" 
                           onclick="return confirm('Supprimer ce rendez-vous ?')" 
                           style="margin-left: 10px; text-decoration: none;">🗑️</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                
                <?php if (count($all_appointments) === 0): ?>
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #95a5a6;">Aucun rendez-vous trouvé.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php require_once '../includes/footer.php'; ?>