<?php 
require_once ROOT_PATH . '/app/views/includes/header.php'; 

// 1. Récupération des motifs (Services)
$stmt_services = $pdo->query("SELECT nom FROM services ORDER BY nom ASC");
$motifs = $stmt_services->fetchAll(PDO::FETCH_COLUMN);

if(empty($motifs)) {
    $motifs = ['Consultation de contrôle', 'Détartrage', 'Urgence (douleur)', 'Blanchiment'];
}

// 2. Paramètres des créneaux
$debut = "09:00";
$fin = "18:00";
$intervalle = 30; 

// 3. Logique de vérification des disponibilités
$date_selectionnee = $_GET['date'] ?? null;
$creneaux_occupes = [];

if ($date_selectionnee) {
    // Récupère les heures déjà prises pour cette date (sauf les annulés)
    $stmt = $pdo->prepare("SELECT DATE_FORMAT(date, '%H:%i') as heure_rdv FROM rendez_vous WHERE DATE(date) = ? AND statut != 'annulé'");
    $stmt->execute([$date_selectionnee]);
    $creneaux_occupes = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Formatage HH:MM
    $creneaux_occupes = array_map(function($h) { return substr($h, 0, 5); }, $creneaux_occupes);
}
?>

<main class="container py-5">
    <div class="row justify-content-center py-4">
        <div class="col-lg-11">
            
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-dark">Prendre rendez-vous</h1>
                <p class="lead text-muted">Choisissez votre créneau en quelques clics.</p>
            </div>

            <div class="card border-0 shadow-lg rounded-5 overflow-hidden">
                <div class="row g-0">
                    
                    <div class="col-md-4 bg-primary text-white p-5 d-flex flex-column justify-content-center">
                        <h4 class="fw-bold mb-4">Infos pratiques</h4>
                        <ul class="list-unstyled">
                            <li class="mb-4 d-flex align-items-start">
                                <span class="me-3">✅</span>
                                <div><strong>Confirmation immédiate</strong><br><small class="opacity-75">Votre RDV est réservé instantanément.</small></div>
                            </li>
                            <li class="mb-4 d-flex align-items-start">
                                <span class="me-3">🕒</span>
                                <div><strong>Durée du soin</strong><br><small class="opacity-75">Prévoyez environ 30 minutes.</small></div>
                            </li>
                        </ul>
                    </div>

                    <div class="col-md-8 p-5 bg-white">
                        <?php if (isset($_GET['error']) && $_GET['error'] === 'closed'): ?>
                            <div class="alert alert-danger shadow-sm border-0 rounded-4 px-4 py-3 mb-4" role="alert">
                            <div class="d-flex align-items-center">
                            <span class="fs-3 me-3">📍</span>
                    <div>
                            <strong>Cabinet fermé :</strong> Le Dr. Dupont ne consulte pas à la date sélectionnée. 
                            Veuillez choisir un autre jour.
                </div>
            </div>
        </div>
    <?php endif; ?>
                        <form action="index.php?page=rdv-valid" method="POST">
                            
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <label class="form-label fw-bold">1. Motif de consultation</label>
                                    <select name="motif" id="motif_select" class="form-select border-light bg-light rounded-3" required>
                                        <option value="" selected disabled>Quel est l'objet de votre visite ?</option>
                                        <?php foreach($motifs as $m): ?>
                                            <option value="<?= htmlspecialchars($m) ?>" <?= (isset($_GET['motif']) && $_GET['motif'] == $m) ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($m) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="form-label fw-bold">2. Date du rendez-vous</label>
                                    <input type="date" name="date_rdv" id="date_rdv" 
                                           class="form-control border-light bg-light rounded-3" 
                                           min="<?= date('Y-m-d') ?>" 
                                           value="<?= $date_selectionnee ?>" required>
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label fw-bold">3. Heure disponible</label>
                                    
                                    <div class="d-flex flex-wrap gap-2" id="container-creneaux">
                                        <?php if (!$date_selectionnee): ?>
                                            <div class="alert alert-info w-100 border-0 rounded-4">
                                                👋 Veuillez d'abord choisir une date pour voir les disponibilités.
                                            </div>
                                        <?php else: ?>
                                            <?php 
                                            $current = strtotime($debut);
                                            $end = strtotime($fin);
                                            while ($current < $end): 
                                                $time = date("H:i", $current);
                                                $est_occupe = in_array($time, $creneaux_occupes);
                                            ?>
                                                <input type="radio" class="btn-check" name="heure_rdv" 
                                                       id="time_<?= $time ?>" value="<?= $time ?>" 
                                                       required <?= $est_occupe ? 'disabled' : '' ?>>
                                                
                                                <label class="btn <?= $est_occupe ? 'btn-light text-decoration-line-through opacity-50' : 'btn-outline-primary' ?> rounded-pill px-3" 
                                                       for="time_<?= $time ?>">
                                                    <?= $time ?>
                                                </label>
                                            <?php 
                                                $current = strtotime("+$intervalle minutes", $current);
                                            endwhile; 
                                            ?>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="col-12 mb-4">
                                    <label class="form-label fw-bold">Message (optionnel)</label>
                                    <textarea name="message" rows="2" class="form-control border-light bg-light rounded-3" placeholder="Informations complémentaires..."></textarea>
                                </div>
                            </div>

                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill py-3 fw-bold shadow-sm" <?= !$date_selectionnee ? 'disabled' : '' ?>>
                                    Confirmer mon rendez-vous
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<script>
// Script pour recharger les disponibilités quand la date change
document.getElementById('date_rdv').addEventListener('change', function() {
    const date = this.value;
    const motif = document.getElementById('motif_select').value;
    if(date) {
        // Recharge la page avec la date en paramètre pour filtrer les créneaux occupés
        window.location.href = "index.php?page=prendre-rdv&date=" + date + "&motif=" + motif;
    }
});
</script>

<style>
    .btn-check:checked + .btn-outline-primary {
        background-color: #0d6efd !important;
        color: white !important;
        border-color: #0d6efd !important;
        transform: scale(1.1);
    }
    .btn-outline-primary {
        transition: all 0.2s;
        border: 1px solid #dee2e6;
        color: #495057;
    }
    .btn-light.text-decoration-line-through {
        cursor: not-allowed;
        background: #f8f9fa;
        border-color: #eee;
        color: #adb5bd;
    }
</style>

<?php require_once ROOT_PATH . '/app/views/includes/footer.php'; ?>