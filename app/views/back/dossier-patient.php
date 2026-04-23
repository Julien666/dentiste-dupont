<?php
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
require_once ROOT_PATH . '/app/views/includes/header.php';

// 1. Récupération de l'ID du patient depuis l'URL
$id_patient = $_GET['id'] ?? null;

if (!$id_patient) {
    header('Location: index.php?page=gestion-patients');
    exit();
}

// 2. Récupération des informations personnelles du patient
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? AND role = 'patient'");
$stmt->execute([$id_patient]);
$patient = $stmt->fetch();

if (!$patient) {
    echo "<div class='container mt-5 alert alert-danger'>Patient introuvable.</div>";
    exit();
}

// 3. RÉQUÊTE CORRIGÉE : On cherche dans la table 'rendez_vous' 
// On utilise 'id_patient' pour filtrer et on trie par date décroissante
$queryRdv = "SELECT * FROM rendez_vous WHERE id_patient = ? ORDER BY date DESC";
$stmtRdv = $pdo->prepare($queryRdv);
$stmtRdv->execute([$id_patient]);
$rendezvous = $stmtRdv->fetchAll();

// Calcul des initiales pour le design
$initiales = strtoupper(substr($patient['prenom'], 0, 1) . substr($patient['nom'], 0, 1));
?>

<main class="container py-5">
    <div class="d-flex align-items-center mb-4">
        <a href="index.php?page=gestion-patients" class="btn btn-outline-secondary rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h1 class="fw-bold m-0">Dossier Médical #<?= $patient['id'] ?></h1>
            <p class="text-muted m-0">Patient : <?= htmlspecialchars($patient['prenom'] . ' ' . $patient['nom']) ?></p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4">
                <div class="mx-auto bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px; font-size: 1.5rem; font-weight: bold;">
                    <?= $initiales ?>
                </div>
                <div class="text-center mb-4">
                    <h4 class="fw-bold"><?= htmlspecialchars($patient['prenom'] . ' ' . $patient['nom']) ?></h4>
                    <span class="badge bg-light text-primary border border-primary rounded-pill">Patient</span>
                </div>
                <hr>
                <div class="mt-3">
                    <p class="small text-muted text-uppercase fw-bold mb-1">Coordonnées</p>
                    <p class="mb-2"><strong>Email:</strong> <?= htmlspecialchars($patient['email']) ?></p>
                    <p class="mb-0"><strong>Tel:</strong> <?= htmlspecialchars($patient['telephone'] ?? 'Non renseigné') ?></p>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold m-0 text-primary"><i class="bi bi-clock-history me-2"></i>Historique des consultations</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th class="ps-4">Date & Heure</th>
                                <th>Soin / Motif</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($rendezvous)): ?>
                                <tr>
                                    <td colspan="3" class="text-center py-5">
                                        <p class="text-muted mb-0">Aucun rendez-vous enregistré pour ce patient dans la table <b>rendez_vous</b>.</p>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($rendezvous as $rdv): ?>
                                    <?php 
                                        $statut = strtolower($rdv['statut']);
                                        $badgeClass = 'bg-primary'; 
                                        if ($statut == 'annulé') $badgeClass = 'bg-danger';
                                        if ($statut == 'confirmé' || $statut == 'effectué') $badgeClass = 'bg-success';
                                    ?>
                                    <tr>
                                        <td class="ps-4">
                                            <strong><?= date('d/m/Y', strtotime($rdv['date'])) ?></strong><br>
                                            <small class="text-muted"><?= date('H:i', strtotime($rdv['date'])) ?></small>
                                        </td>
                                        <td class="fw-medium">
                                            <?= htmlspecialchars($rdv['id_acte'] ?? 'Consultation') ?>
                                        </td>
                                        <td>
                                            <span class="badge <?= $badgeClass ?> rounded-pill px-3">
                                                <?= ucfirst($statut) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>