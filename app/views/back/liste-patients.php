<?php 
// 1. Utilisation de ROOT_PATH pour les inclusions
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('admin'); 

require_once ROOT_PATH . '/app/views/includes/header.php'; 

// 2. Récupération de tous les patients (le $pdo vient de l'index)
$query = $pdo->query("SELECT id, nom, prenom, email FROM users WHERE role = 'patient' ORDER BY nom ASC");
$patients = $query->fetchAll();
?>

<main>
    <div class="dashboard-header">
        <h2>Gestion des Patients</h2>
        <p>Liste complète des utilisateurs enregistrés comme patients.</p>
    </div>

    <section class="admin-section">
        <table class="admin-table" style="width: 100%; border-collapse: collapse; background: white; margin-top: 20px;">
            <thead>
                <tr style="background: #2c3e50; color: white;">
                    <th style="padding: 12px; text-align: left;">ID</th>
                    <th style="padding: 12px; text-align: left;">Nom</th>
                    <th style="padding: 12px; text-align: left;">Prénom</th>
                    <th style="padding: 12px; text-align: left;">Email</th>
                    <th style="padding: 12px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($patients) > 0): ?>
                    <?php foreach ($patients as $p): ?>
                        <tr>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;"><?php echo $p['id']; ?></td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee; font-weight: bold;">
                                <?php echo htmlspecialchars(strtoupper($p['nom'])); ?>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                                <?php echo htmlspecialchars($p['prenom']); ?>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee;">
                                <?php echo htmlspecialchars($p['email']); ?>
                            </td>
                            <td style="padding: 12px; border-bottom: 1px solid #eee; text-align: center;">
                                <a href="index.php?page=dossier-patient&id=<?php echo $p['id']; ?>" style="text-decoration: none;">📁 Voir dossier</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="padding: 20px; text-align: center;">Aucun patient enregistré.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div style="margin-top: 20px;">
            <a href="index.php?page=dashboard" style="text-decoration: none; color: #3498db;">← Retour au Dashboard</a>
        </div>
    </section>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>