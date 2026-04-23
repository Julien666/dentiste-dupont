<?php 
require_once ROOT_PATH . '/app/views/includes/header.php'; 

// 1. Vérification de sécurité
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?page=login');
    exit();
}

// 2. Récupération des infos fraîches de l'utilisateur
$query = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$query->execute([$_SESSION['user_id']]);
$user = $query->fetch();

// 3. Correction des statistiques (On utilise la bonne table 'appointments')
$countQuery = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE user_id = ? AND status != 'annulé'");
$countQuery->execute([$_SESSION['user_id']]);
$total_rdv = $countQuery->fetchColumn();

// 4. Récupération du prochain rendez-vous (en utilisant la colonne 'description')
$nextRdvQuery = $pdo->prepare("
    SELECT date_rdv, heure_rdv, description 
    FROM appointments 
    WHERE user_id = ? AND date_rdv >= CURDATE() AND status != 'annulé'
    ORDER BY date_rdv ASC, heure_rdv ASC 
    LIMIT 1
");
$nextRdvQuery->execute([$_SESSION['user_id']]);
$prochain_rdv = $nextRdvQuery->fetch();
?>

<main class="container py-5">
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-lg rounded-5 p-4 text-center">
                <div class="mx-auto mb-3 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; font-size: 2.5rem;">
                    <?= strtoupper(substr($user['nom'], 0, 1)) ?>
                </div>
                <h3 class="fw-bold"><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></h3>
                <p class="text-muted">Patient depuis <?= date('Y', strtotime($user['date_inscription'] ?? date('Y-m-d'))) ?></p>
                
                <hr class="my-4 opacity-50">
                
                <div class="row mb-4">
                    <div class="col-6 border-end">
                        <h4 class="fw-bold text-primary mb-0"><?= $total_rdv ?></h4>
                        <small class="text-muted text-uppercase" style="font-size: 0.7rem;">Rendez-vous</small>
                    </div>
                    <div class="col-6">
                        <h4 class="fw-bold text-success mb-0">Actif</h4>
                        <small class="text-muted text-uppercase" style="font-size: 0.7rem;">Statut Compte</small>
                    </div>
                </div>

                <div class="bg-light rounded-4 p-3 mb-4 text-start">
                       <h6 class="fw-bold text-dark mb-2"><i class="bi bi-calendar-check"></i> Prochain RDV</h6>
                         <?php if ($prochain_rdv): ?>
                <div class="small">
                       <p class="mb-1 text-primary fw-bold">
                           <?= date('d/m/Y', strtotime($prochain_rdv['date_rdv'])) ?> à <?= substr($prochain_rdv['heure_rdv'], 0, 5) ?>
                      </p>
                      <p class="mb-0 text-muted italic">
                       <?= htmlspecialchars($prochain_rdv['description'] ?? 'Aucun détail') ?>
                      </p>
        </div>
    <?php else: ?>
        <p class="small text-muted mb-0">Aucun RDV prévu.</p>
        <a href="index.php?page=prendre-rdv" class="btn btn-sm btn-link p-0">Prendre RDV</a>
    <?php endif; ?>
</div>
                
                <div class="d-grid">
                    <a href="index.php?page=logout" class="btn btn-outline-danger rounded-pill">Déconnexion</a>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card border-0 shadow-lg rounded-5 p-4 p-md-5">
                <h4 class="fw-bold mb-4">Mes Informations Personnelles</h4>
                
                <?php if (isset($_GET['status']) && $_GET['status'] == 'updated'): ?>
                    <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4">
                        ✨ Vos informations ont été mises à jour avec succès.
                    </div>
                <?php endif; ?>

                <form action="index.php?page=profil-update" method="POST">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Nom</label>
                            <input type="text" name="nom" class="form-control form-control-lg rounded-3 border-light bg-light" value="<?= htmlspecialchars($user['nom']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Prénom</label>
                            <input type="text" name="prenom" class="form-control form-control-lg rounded-3 border-light bg-light" value="<?= htmlspecialchars($user['prenom']) ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary">Adresse Email</label>
                            <input type="email" name="email" class="form-control form-control-lg rounded-3 border-light bg-light" value="<?= htmlspecialchars($user['email']) ?>" required>
                        </div>
                        <div class="col-12 mt-5 text-end">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill px-5 shadow">
                                Enregistrer les modifications
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>