<?php 
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('admin');
require_once ROOT_PATH . '/app/views/includes/header.php'; 

$patients = $pdo->query("SELECT id, nom, prenom, email FROM users WHERE role = 'patient' ORDER BY nom ASC")->fetchAll();
?>

<main>
    <div class="dashboard-header">
        <h2>👥 Gestion des Patients</h2>
        <p>Liste des patients inscrits au cabinet.</p>
    </div>

    <section class="admin-section">
        <table class="admin-table" style="width: 100%; border-collapse: collapse; background: white;">
            <thead>
                <tr style="background: #2c3e50; color: white;">
                    <th style="padding: 12px;">Nom & Prénom</th>
                    <th style="padding: 12px;">Email</th>
                    <th style="padding: 12px; text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($patients as $p): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 12px;"><?php echo htmlspecialchars(strtoupper($p['nom']) . ' ' . $p['prenom']); ?></td>
                    <td style="padding: 12px;"><?php echo htmlspecialchars($p['email']); ?></td>
                    <td style="padding: 12px; text-align: center;">
                        <a href="index.php?page=dossier-patient&id=<?php echo $p['id']; ?>" style="text-decoration: none; margin-right: 15px;">📁 Dossier</a>
                        <a href="index.php?page=delete-patient&id=<?php echo $p['id']; ?>" 
                           onclick="return confirm('⚠️ Supprimer ce patient et tous ses rendez-vous ?')" 
                           style="color: #e74c3c; text-decoration: none;">🗑️ Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>