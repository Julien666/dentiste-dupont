<?php
// Inclusion du header (Menu + Bootstrap)
require_once ROOT_PATH . '/app/views/includes/header.php';

// 1. Récupération de l'ID de session (Diagnostic OK : ID 9 pour Rock Lee)
$user_id = $_SESSION['user_id'] ?? ($_SESSION['user']['id'] ?? null);

if (!$user_id) {
    echo "<div class='container py-5'><div class='alert alert-danger'>Veuillez vous connecter pour voir vos rendez-vous.</div></div>";
    require_once ROOT_PATH . '/app/views/includes/footer.php';
    exit();
}

// 2. Requête sur la table 'rendez_vous' (Harmonisée avec le dossier patient)
// On utilise 'id_patient' et 'date' comme dans ta base de données
try {
    $query = "SELECT * FROM rendez_vous WHERE id_patient = ? ORDER BY date DESC";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$user_id]);
    $mes_rdv = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "<div class='alert alert-danger'>Erreur SQL : " . $e->getMessage() . "</div>";
}
?>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold m-0">Mes Rendez-vous</h1>
            <p class="text-muted">Retrouvez l'historique et vos prochaines consultations.</p>
        </div>
        <a href="index.php?page=prendre-rdv" class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold">
            + Nouveau rendez-vous
        </a>
    </div>

    <?php if (isset($_GET['cancelled'])): ?>
        <div class="alert alert-success alert-dismissible fade show rounded-4" role="alert">
            Votre rendez-vous a bien été annulé.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3">DATE & HEURE</th>
                        <th class="py-3">MOTIF / SOIN</th>
                        <th class="py-3">STATUT</th>
                        <th class="py-3 text-end pe-4">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($mes_rdv)): ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <p class="text-muted mb-0">Aucun rendez-vous trouvé pour l'ID <?= $user_id ?>.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($mes_rdv as $rdv): ?>
                            <?php 
                                $statut = strtolower($rdv['statut']);
                                $badgeClass = 'bg-primary'; // par défaut
                                if ($statut == 'annulé') $badgeClass = 'bg-danger';
                                if ($statut == 'confirmé' || $statut == 'effectué') $badgeClass = 'bg-success';
                            ?>
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold"><?= date('d/m/Y', strtotime($rdv['date'])) ?></div>
                                    <div class="text-muted small">à <?= date('H:i', strtotime($rdv['date'])) ?></div>
                                </td>
                                <td>
                                    <span class="fw-medium"><?= htmlspecialchars($rdv['id_acte'] ?? 'Consultation') ?></span>
                                </td>
                                <td>
                                    <span class="badge <?= $badgeClass ?> rounded-pill px-3">
                                        <?= ucfirst($statut) ?>
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <?php if ($statut != 'annulé'): ?>
                                        <a href="index.php?page=rdv-cancel&id=<?= $rdv['id'] ?>" 
                                           class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                           onclick="return confirm('Voulez-vous vraiment annuler ce rendez-vous ?')">
                                            Annuler
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php 
// Inclusion du footer
require_once ROOT_PATH . '/app/views/includes/footer.php'; 
?>