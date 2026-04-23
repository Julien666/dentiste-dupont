<?php
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
require_once ROOT_PATH . '/app/views/includes/header.php';

// 1. Récupération des rendez-vous du jour ou à venir dans 'rendez_vous'
// On fait une jointure avec 'users' pour avoir le nom du patient
try {
    $query = "SELECT r.*, u.nom, u.prenom 
              FROM rendez_vous r 
              JOIN users u ON r.id_patient = u.id 
              WHERE r.statut != 'annulé' 
              ORDER BY r.date ASC";
    $stmt = $pdo->query($query);
    $agenda = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Erreur Agenda : " . $e->getMessage());
}
?>

<main class="container py-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="fw-bold">Agenda du Cabinet</h1>
            <p class="text-muted">Liste de tous les rendez-vous confirmés.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-primary text-white">
                    <tr>
                        <th class="ps-4">Date & Heure</th>
                        <th>Patient</th>
                        <th>Soin / Motif</th>
                        <th>Statut</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($agenda)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                Aucun rendez-vous prévu pour le moment.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($agenda as $rdv): ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold"><?= date('d/m/Y', strtotime($rdv['date'])) ?></span><br>
                                    <span class="badge bg-light text-dark"><?= date('H:i', strtotime($rdv['date'])) ?></span>
                                </td>
                                <td class="fw-bold text-primary">
                                    <?= htmlspecialchars($rdv['prenom'] . ' ' . $rdv['nom']) ?>
                                </td>
                                <td><?= htmlspecialchars($rdv['id_acte'] ?? 'Consultation') ?></td>
                                <td>
                                    <span class="badge bg-success rounded-pill px-3">Confirmé</span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="index.php?page=dossier-patient&id=<?= $rdv['id_patient'] ?>" class="btn btn-sm btn-outline-primary rounded-pill">Voir Dossier</a>
                                    <a href="index.php?page=delete-rdv&id=<?= $rdv['id'] ?>" class="btn btn-sm btn-link text-danger" onclick="return confirm('Supprimer ce RDV ?')">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>