<?php 
require_once ROOT_PATH . '/app/views/includes/auth_guard.php';
protect_page('admin');
require_once ROOT_PATH . '/app/views/includes/header.php'; 

// Récupérer les horaires
$horaires = $pdo->query("SELECT * FROM horaires ORDER BY id ASC")->fetchAll();
?>

<main class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h1 class="fw-bold text-dark">🕒 Horaires d'ouverture</h1>
            <p class="text-muted">Définissez les plages horaires pour les rendez-vous (créneaux de 30 min par défaut).</p>
        </div>
        <div class="badge bg-info-subtle text-info px-3 py-2 rounded-pill">Configuration Cabinet</div>
    </div>

    <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
        <form action="index.php?page=update-horaires" method="POST" class="p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3 border-0 text-secondary">JOUR</th>
                            <th class="py-3 border-0 text-secondary">OUVERTURE</th>
                            <th class="py-3 border-0 text-secondary">FERMETURE</th>
                            <th class="py-3 border-0 text-secondary text-center">STATUT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($horaires as $h): ?>
                        <tr class="<?= $h['est_ferme'] ? 'table-light opacity-75' : '' ?>">
                            <td class="ps-4 py-4 fw-bold text-dark">
                                <?= htmlspecialchars($h['jour']) ?>
                            </td>
                            <td>
                                <input type="time" name="ouverture[<?= $h['id'] ?>]" 
                                       class="form-control form-control-sm rounded-pill border-light bg-light px-3" 
                                       value="<?= substr($h['ouverture'], 0, 5) ?>"
                                       <?= $h['est_ferme'] ? 'disabled' : '' ?>>
                            </td>
                            <td>
                                <input type="time" name="fermeture[<?= $h['id'] ?>]" 
                                       class="form-control form-control-sm rounded-pill border-light bg-light px-3" 
                                       value="<?= substr($h['fermeture'], 0, 5) ?>"
                                       <?= $h['est_ferme'] ? 'disabled' : '' ?>>
                            </td>
                            <td class="text-center">
                                <div class="form-check form-switch d-inline-block">
                                    <input class="form-check-input" type="checkbox" role="switch" 
                                           name="est_ferme[<?= $h['id'] ?>]" 
                                           <?= $h['est_ferme'] ? 'checked' : '' ?>
                                           style="cursor: pointer;">
                                    <label class="small text-muted ms-2"><?= $h['est_ferme'] ? 'Fermé' : 'Ouvert' ?></label>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="bg-light p-4 text-end border-top">
                <p class="small text-muted float-start mt-2 italic">
                    💡 Note : Le système de réservation générera automatiquement des créneaux toutes les 30 minutes.
                </p>
                <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm fw-bold">
                    Enregistrer les horaires
                </button>
            </div>
        </form>
    </div>
</main>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>