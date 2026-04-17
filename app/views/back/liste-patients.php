<?php 
require_once '../includes/auth_guard.php';
protect_page('admin'); // Seul le docteur peut voir ses patients
require_once '../../../config/db.php';
require_once '../includes/header.php'; 

// Récupérer tous les patients par ordre alphabétique
$query = $pdo->query("SELECT id, nom, email, date_inscription FROM users WHERE role = 'patient' ORDER BY nom ASC");
$patients = $query->fetchAll();
?>

<main>
    <div class="dashboard-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h2>👥 Gestion des Patients</h2>
        <div class="stats-mini">
            <strong>Total :</strong> <?php echo count($patients); ?> patients inscrits
        </div>
    </div>

    <section class="rdv-section">
        <div class="card">
            <table style="width: 100%; border-collapse: collapse; background: white;">
                <thead>
                    <tr style="background: var(--dark-navy); color: white;">
                        <th style="padding: 15px; text-align: left;">Nom du Patient</th>
                        <th style="padding: 15px; text-align: left;">Email</th>
                        <th style="padding: 15px; text-align: left;">Inscrit le</th>
                        <th style="padding: 15px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($patients) > 0): ?>
                        <?php foreach ($patients as $p): ?>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 12px;"><strong><?php echo htmlspecialchars($p['nom']); ?></strong></td>
                                <td style="padding: 12px;"><?php echo htmlspecialchars($p['email']); ?></td>
                                <td style="padding: 12px;"><?php echo date('d/m/Y', strtotime($p['date_inscription'])); ?></td>
                                <td style="padding: 12px; text-align: center;">
                                    <a href="dashboard.php?search=<?php echo urlencode($p['nom']); ?>" 
                                       style="text-decoration: none; font-size: 0.9rem; color: var(--medical-blue);">
                                       🔎 Voir ses RDV
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" style="padding: 30px; text-align: center; color: #999;">
                                Aucun patient n'est encore inscrit dans la base.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>

<?php require_once '../includes/footer.php'; ?>