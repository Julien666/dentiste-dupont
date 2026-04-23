<?php 
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('admin');
require_once ROOT_PATH . '/app/views/includes/header.php'; 

// Récupération des patients
$patients = $pdo->query("SELECT id, nom, prenom, email FROM users WHERE role = 'patient' ORDER BY nom ASC")->fetchAll();
?>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold">👥 Gestion des Patients</h1>
            <p class="text-muted">Consultez les dossiers et gérez les accès de vos patients.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-primary px-3 py-2 rounded-pill">Mode Administrateur</span>
        </div>
    </div>

    <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
        <div class="bg-white p-4 border-bottom">
            <h4 class="fw-bold mb-0">Liste des patients inscrits</h4>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">PATIENT</th>
                        <th>ADRESSE EMAIL</th>
                        <th class="text-end pe-4">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($patients)): ?>
                        <tr>
                            <td colspan="3" class="text-center py-5 text-muted">Aucun patient inscrit pour le moment.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($patients as $p): ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; font-weight: bold; color: #3498db;">
                                        <?php echo strtoupper(substr($p['nom'], 0, 1)); ?>
                                    </div>
                                    <span class="fw-bold"><?php echo htmlspecialchars(strtoupper($p['nom']) . ' ' . $p['prenom']); ?></span>
                                </div>
                            </td>
                            <td class="text-muted">
                                <?php echo htmlspecialchars($p['email']); ?>
                            </td>
                            <td class="text-end pe-4">
                                <a href="index.php?page=dossier-patient&id=<?php echo $p['id']; ?>" class="btn btn-sm btn-primary rounded-pill px-3">📁 Dossier</a>
                                <a href="index.php?page=delete-patient&id=<?php echo $p['id']; ?>" 
                                   onclick="return confirm('⚠️ Supprimer ce patient et tous ses rendez-vous ?')" 
                                   class="btn btn-sm btn-outline-danger rounded-pill px-3 ms-2">🗑️</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        <a href="index.php?page=dashboard" class="text-decoration-none text-muted small">← Retour à l'Agenda</a>
    </div>
</main>

<style>
/* Animation au survol identique au dashboard */
.table-hover tbody tr:hover {
    background-color: rgba(52, 152, 219, 0.02);
    transition: background-color 0.2s ease;
}
</style>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>