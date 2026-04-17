<?php 
// 1. Inclusions sécurisées via ROOT_PATH
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('admin'); // On vérifie que c'est bien l'admin

require_once ROOT_PATH . '/app/views/includes/header.php'; 

// 2. Récupération des rendez-vous (le $pdo est fourni par index.php)
$query = $pdo->query("SELECT a.*, u.nom, u.prenom 
                      FROM appointments a 
                      JOIN users u ON a.user_id = u.id 
                      WHERE a.status = 'prévu' 
                      ORDER BY a.date_rdv ASC, a.heure_rdv ASC");
$appointments = $query->fetchAll();
?>

<main>
    <div class="dashboard-header">
        <h2>Tableau de bord Administrateur</h2>
        <p>Gestion des rendez-vous du cabinet.</p>
    </div>

    <section class="admin-section">
        <h3>📅 Rendez-vous à venir</h3>
        
        <table class="admin-table" style="width: 100%; border-collapse: collapse; background: white;">
            <thead>
                <tr style="background: #2c3e50; color: white;">
                    <th style="padding: 10px;">Patient</th>
                    <th style="padding: 10px;">Date</th>
                    <th style="padding: 10px;">Heure</th>
                    <th style="padding: 10px;">Motif</th>
                    <th style="padding: 10px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($appointments) > 0): ?>
                    <?php foreach ($appointments as $rdv): ?>
                        <tr>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">
                                <?php echo htmlspecialchars($rdv['nom'] . ' ' . $rdv['prenom']); ?>
                            </td>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">
                                <?php echo date('d/m/Y', strtotime($rdv['date_rdv'])); ?>
                            </td>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">
                                <?php echo substr($rdv['heure_rdv'], 0, 5); ?>
                            </td>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">
                                <?php echo htmlspecialchars($rdv['description']); ?>
                            </td>
                            <td style="padding: 10px; border-bottom: 1px solid #eee;">
                                <a href="index.php?page=valider-soin&id=<?php echo $rdv['id']; ?>" class="btn-edit" style="color: green; text-decoration: none; margin-right: 10px;">✅ Valider</a>
                                
                                <a href="index.php?page=delete-rdv&id=<?php echo $rdv['id']; ?>" 
                                   onclick="return confirm('Supprimer ce RDV ?')" 
                                   style="color: red; text-decoration: none;">🗑️ Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="padding: 20px; text-align: center;">Aucun rendez-vous prévu.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>